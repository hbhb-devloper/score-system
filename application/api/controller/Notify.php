<?php
namespace app\api\controller;
use app\common\model\Order as mOrder;
use app\common\model\PayLog as mPayLog;
use app\common\model\UserCardFlow;
use app\common\model\UserGoldFlow;
use app\common\model\Users as mUser;
use app\common\model\UserScoreFlow;
use app\common\model\WeixinNotify as mWeixinNotify;

class Notify extends Base
{
    protected $appid;
    protected $appkey;
    protected $mch_id;
    protected $key;
    function __construct()
    {
        $this->appid        = config('weixin.WECHAT_PAYMENT_APPID');
        $this->appkey        = config('weixin.WECHAT_PAYMENT_APPID_KEY');
        $this->mch_id       = config('weixin.WECHAT_PAYMENT_MCH_ID');
        $this->key          = config('weixin.WECHAT_PAYMENT_MCH_KEY');
    }
    // 微信支付回调
    function wxpay()
    {
        $xml = file_get_contents('php://input');
        //记录回调信息
        writeLog('weixin/pay_notify',date('H:i:s')."\r\n".$xml."\r\n");
        //
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $result = $arr;
        if($result) {
            // 当支付通知返回支付成功时
            if ($arr['return_code'] == "FAIL") {
                $this->addLog($result, 401);
            } elseif ($arr['result_code'] == "FAIL") {
                $this->addLog($result, 402);
            } elseif ($arr['result_code'] == "SUCCESS") {
                foreach ($arr as $k => $v) {
                    if ($k == 'sign') {
                        $xmlSign = $arr[$k];
                        unset($arr[$k]);
                    };
                }
                $sign = http_build_query($arr);
                //md5处理
                $key = $this->key;
                $sign = md5($sign . '&key=' . $key);
                //转大写
                $sign = strtoupper($sign);
                //验签名。默认支持MD5
                //验证加密后的32位值和 微信返回的sign 是否一致！！！
                if ($sign === $xmlSign) {
                    // 支付记录编号
                    $trade_no = $result['out_trade_no'];
                    //获取支付记录
                    $pay_log = mPayLog::where('out_trade_no',$trade_no)->find();
                    if ($pay_log) {
                        mPayLog::update(['transaction_id'=>$result['transaction_id']],['out_trade_no'=>$trade_no]);
                        if ($pay_log['is_paid'] == 0) {
                            $this->addLog($result, 200);
                            $this->wxPaid($pay_log);
                            $this::return_success();
                        } else {
                            $this::return_success();
                        }
                    }
                } else {
                    $this->addLog($result, 403);
                }
            }
        }
    }
    public function refund(){
        $xml = file_get_contents('php://input');
        //记录回调信息
        writeLog('weixin/refund_notify',date('H:i:s')."\r\n".$xml."\r\n");
        //
        $data = $this->xmlToArray($xml);
        if ($data['return_code'] == "FAIL") {
            $this->addLog($data, 701);
        }
        elseif($data['return_code'] == 'SUCCESS'){
            $refundDecryptData = $this->refundDecrypt($data['req_info']);//解密
            writeLog('weixin/refund_notify',$refundDecryptData."\r\n");
            $refundData = $this->xmlToArray($refundDecryptData);//将XML转换成数组
            $data['req_info_arr'] = $refundData;
            $this->addLog($data, 200);
            /**处理事务逻辑**/
            if($refundData['refund_status']=='SUCCESS'){
                // 支付记录编号
                $out_refund_no = $refundData['out_refund_no'];
                //获取支付记录
                $pay_log = mPayLog::where('out_refund_no',$out_refund_no)->find();
                if ($pay_log && $pay_log['refund_status'] == 0) {
                    if($pay_log['refund_status'] == 0) {
                        $this->order_refund($pay_log);
                        $this::return_success();
                    }else{
                        $this::return_success();
                    }
                }
            }
        }
    }

    function wxPaid($pay_log){
        if ($pay_log && $pay_log['is_paid'] == 0) {
            /* 修改此次支付操作的状态为已付款 */
            mPayLog::update(['is_paid'=>1],['id'=>$pay_log['id']]);

            /* 根据记录类型做相应处理 */
            $scoreflowtype = 0;
            $scoredetail = '';
            //下单支付，$orderid为订单ID
            if ($pay_log['type'] == 1){
                $scoreflowtype = 1;
                $scoredetail = '商城下单';
                //更新流水
                $order = mOrder::get($pay_log['orderid']);
                if($order['pay_card']>0){
                    UserCardFlow::update(['status'=>1],['orderid'=>$pay_log['orderid'],'incdec'=>'dec','status'=>0]);
                }
                if($order['pay_gold']>0){
                    UserGoldFlow::update(['status'=>1],['orderid'=>$pay_log['orderid'],'incdec'=>'dec','status'=>0]);
                }
                //更新订单
                mOrder::update(['pay_time'=>date('Y-m-d H:i:s'),'status'=>2],['id'=>$pay_log['orderid']]);
                //分佣
                getCommission($pay_log['orderid'],$pay_log['userid']);
            }
            //余额充值，$orderid为余额流水ID
            else if($pay_log['type'] == 2){
                $scoreflowtype = 2;
                $scoredetail = '余额充值';
                $goldflow = [
                    'userid'    => $pay_log['userid']
                    ,'incdec'   => 'inc'
                    ,'gold'     => $pay_log['amount']
                    ,'flowtype' => 1
                    ,'detail'   => '微信充值'
                    ,'paylog_id'  => $pay_log['id']
                    ,'status'   =>1
                ];
                UserGoldFlow::create($goldflow);
                UserGoldFlow::update(['status'=>1],['id'=>$pay_log['orderid'],'incdec'=>'inc','status'=>0]);
                mUser::where('id',$pay_log['userid'])->setInc('gold',$pay_log['amount']);
            }
            //积分
            $score_has = UserScoreFlow::where('paylogid',$pay_log['id'])->count();
            $scorenum = intval($pay_log['amount']);
            if(!$score_has && $scoreflowtype && $scorenum>0){
                addScore($pay_log['userid'],$scorenum,$scoredetail,$pay_log['id'],$pay_log['orderid'],$scoreflowtype);
            }
        }
    }
    function order_refund($pay_log){
        /* 修改此次退款操作的状态 */
        mPayLog::update(['refund_status'=>1],['id'=>$pay_log['id']]);
        $orderid = $pay_log['orderid'];
        //更新订单
        mOrder::update(['status'=>0],['id'=>$orderid]);
    }
    function addLog($other = array(), $status = 1,$type = 1) {
        $log ['ip'] = $_SERVER['REMOTE_ADDR'];
        $log ['time'] = date('Y-m-d H:i:s');
        $log ['get'] = input();
        $log ['other'] = $other;
        $log = serialize ( $log );
        $data = ['content'=>$log,'status'=>$status,'type'=>$type];
        mWeixinNotify::create($data);
        return mWeixinNotify::create($data);
    }
    /*
     * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
     */
    public static  function return_success(){
        $return['return_code'] = 'SUCCESS';
        $return['return_msg'] = 'OK';
        $xml_post = '<xml>
                <return_code>'.$return['return_code'].'</return_code>
                <return_msg>'.$return['return_msg'].'</return_msg>
                </xml>';
        echo $xml_post;exit;
    }

    /**
    * 对密文进行解密
    * @param string $encrypted 需要解密的密文
    * @return string 解密得到的明文
    */
    function refundDecrypt($str) {
        $decrypt = base64_decode($str,true);
        $key = md5($this->key);
        return openssl_decrypt($decrypt , 'aes-256-ecb',$key, OPENSSL_RAW_DATA);
    }
    /**
    * xml 转换成数组
    * @param string $xml
    * @return array
    */
     function xmlToArray($xml){
         //禁止引用外部xml实体
         libxml_disable_entity_loader(true);
         $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
         $val = json_decode(json_encode($xmlstring), true);
         return $val;
     }
    public function wxPayOld(){
        $xmlData = file_get_contents('php://input');
        $data = json_decode(json_encode(simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        // Log::info($data);
        ksort($data);
        $buff = '';
        foreach ($data as $k => $v) {
            if ($k != 'sign') {
                $buff .= $k . '=' . $v . '&';
            }
        }
        $stringSignTemp = $buff . "key=$this->key";//key为证书密钥
        $sign = strtoupper(md5($stringSignTemp));
        //判断算出的签名和通知信息的签名是否一致
        if ($sign == $data['sign']) {
            //真实入库判断
            //find out_trade_no
            $out_trade_no = $data['out_trade_no'];
            $result = Order::where('orderNumber', $out_trade_no)->first();
            if ($result) {

                $nowMember = 9700;
                $nowuser = $result->nowuser;

                $finduser = UserGz::where('name',$nowuser)->first();
                $finduser->ordertotal = $finduser->ordertotal + 1;
                $finduser->save();
                $nowlevel = $finduser->userlevel;

                $nowaddgold2 = 0;
                $nowaddgold = 0;
                if($result->orderStatus < 3){
                    $result->orderStatus = 3;//支付完结
                    $result->buy_at = date('Y-m-d H:i:s', time());
                    if($result->ordertype == 2){ //充值类型
                        if($result->orderid == "0,0,0"){//充值，任意金额
                            $nowaddgold = floatval($result->orderpayv) / 100;
                            $nowaddgold2 = $nowaddgold;
                            if($finduser->userlevel == 2)//金牌会员
                            {
                                // $nowaddgold2 = $nowaddgold * 2;//充1返2
                                $nowaddgold2 = $nowaddgold;//20190617金牌会员不再冲一返二
                            }
                            Log::info("now add rengyi: $nowaddgold realgold $nowaddgold2");
                            $nowuser = $result->nowuser;
                            $findgold = UserGzGlod::where('name',$nowuser)->first();//找到加载
                            if($findgold){
                                $findgold->gold += $nowaddgold2;
                                $findgold->save();
                                Log::info("now lv:$nowlevel user $nowuser add gold rengyi:  $nowaddgold ok ,now total:".$findgold->gold);
                            }

                            //充值记录表
                            $userczres = new UserGzCZ();
                            $userczres->cz_type = $result->ordertype;
                            $userczres->name = $nowuser;
                            $userczres->userlevel =  $finduser->userlevel;
                            $userczres->cz_time = date('Y-m-d H:i:s', time());
                            $userczres->cz_gold = $nowaddgold;
                            $userczres->cz_realgold = $nowaddgold2;
                            $userczres->save();//充值记录保存
                        }
                        else{
                            //充值操作 卡冲
                            $nowaddvalueidx = $result->orderid - 1;
                            if($nowaddvalueidx >= 0 && $nowaddvalueidx <= 2){
                                $nowaddgold = $this->ordervalue[$nowaddvalueidx];
                                Log::info("now add $nowaddgold");

                                $findgold = UserGzGlod::where('name',$nowuser)->first();//找到加载
                                if($findgold){
                                    $findgold->gold += $nowaddgold;
                                    $findgold->save();
                                    Log::info("now user $nowuser add gold $nowaddgold ok ,now total".$findgold->gold);
                                }
                            }
                            else{
                                Log::info("now add none!!!");
                            }
                        }
                    }




                    if($finduser && $finduser->userlevel == 1){
                        Log::info("WxNotify OK".$nowuser." leveup start !");
                        $nowpayv = $result->orderpayv;//计算金牌会员触发条件
                        if($nowpayv >= $nowMember){
                            Log::info("WxNotify OK".$nowuser."leveup !!!".date('Y-m-d H:i:s', time()));
                            $finduser->userlevel = 2;
                            $finduser->updatelv = date('Y-m-d H:i:s', time());
                            $finduser->save();
                        }
                    }

                    if($result->ordertype == 1){
                        $findgold = UserGzGlod::where('name',$nowuser)->first();//找到加载
                        if($findgold){
                            $nowgold = $findgold->gold*100;
                            $nowgold = $nowgold - $result->ordercardv;
                            $findgold->gold = $nowgold / 100;
                            $findgold->save();
                            Log::info("now user $nowuser update gold ok ,now total ".$findgold->gold);
                        }
                    }

                    $result->save();
                }
            }
            //处理完成之后，告诉微信成功结果
            echo '<xml>
              <return_code><![CDATA[SUCCESS]]></return_code>
              <return_msg><![CDATA[OK]]></return_msg>
            </xml>';
            exit();
        }

        //return sprintf("<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>");
    }

}