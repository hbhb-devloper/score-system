<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 2019/4/26 0026
 * Time: 18:01
 */

namespace weixin;

use think\facade\Request;

class WeixinPay
{
    protected $appid;
    protected $appkey;
    protected $mch_id;
    protected $key;
    protected $sslcert_path;
    protected $sslkey_path;
    protected $notify_url;
    protected $refund_notify_url;

    function __construct()
    {
        $this->appid        = config('weixin.WECHAT_PAYMENT_APPID');
        $this->appkey        = config('weixin.WECHAT_PAYMENT_APPID_KEY');
        $this->mch_id       = config('weixin.WECHAT_PAYMENT_MCH_ID');
        $this->key          = config('weixin.WECHAT_PAYMENT_MCH_KEY');
        $this->sslcert_path = dirname(__FILE__).'/cert/cert.pem';
        $this->sslkey_path = dirname(__FILE__).'/cert/key.pem';
        $this->notify_url   = Request::instance()->domain().'/api/notify/wxpay';
        $this->refund_notify_url   = Request::instance()->domain().'/api/notify/refund';
    }

    //统一下单接口
    public function pay($param)
    {
        $return = $this->weixinapp($param);
        return $return;
    }
    //申请退款
    public function refund($param){
        $return = $this->wxRefundApi($param);
        return $return;
    }
    //企业付款
    public function mchpay($param){
        $return = $this->mchPayApi($param);
        return $return;
    }

    /**
     * @return array
     */
    private function weixinapp($param)
    {
        //统一下单接口
        $unifiedorder = $this->unifiedorder($param);
        $parameters = array(
            'appId' => $this->appid, //小程序ID
            'timeStamp' => '' . time() . '', //时间戳
            'nonceStr' => $this->createNoncestr(), //随机串
            'package' => 'prepay_id=' . $unifiedorder['prepay_id'], //数据包
            'signType' => 'MD5'//签名方式
        );
        //签名
        $parameters['paySign'] = $this->getSign($parameters);
        return $parameters;
    }

    //统一下单接口
    private function unifiedorder($param)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $nowip = $this->get_real_ip();

        if ($nowip == 0) {
            $nowip = getIp();
        }
        $parameters = array(
            'appid' => $this->appid, //小程序ID
            'mch_id' => $this->mch_id, //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'body' => $param['body'],
            'out_trade_no' => $param['out_trade_no'],
            'total_fee' => $param['total_fee'],
            'spbill_create_ip' => $nowip,//'101.83.174.215', //终端IP
            'notify_url' => $this->notify_url, //通知地址  确保外网能正常访问
            'openid' => $param['openid'], //用户id
            'trade_type' => 'JSAPI'//交易类型
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        writeLog('weixin/unifiedOrder',date('H:i:s')."\r\n"."xml:".$xmlData."\r\n"."reponse:".json_encode($return)."\r\n");
        return $return;
    }

    //退款
    private function wxRefundApi($param){
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
        $parameters = array(
            'appId' => $this->appid, //小程序ID
            'mch_id' => $this->mch_id, //时间戳
            'nonceStr' => $this->createNoncestr(), //随机串
            'out_trade_no'=>$param['out_trade_no'],
            'out_refund_no'=>$param['out_refund_no'],
            'total_fee' => $param['total_fee'],
            'refund_fee' => $param['refund_fee'],
            'refund_desc'=>$param['refund_desc']??'',
            'notify_url' => $this->refund_notify_url, //通知地址  确保外网能正常访问
        );
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $result = $this->xmlToArray($this->postXmlSSLCurl($xmlData, $url, 60));
        writeLog('weixin/refund',date('H:i:s')."\r\n"."xml:".$xmlData."\r\n"."reponse:".$result."\r\n");
        return $result;
    }
    /**
    *param=[partner_trade_no,openid,amount,desc,check_name,re_user_name]
     */
    private function mchPayApi($param){
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $nowip = $this->get_real_ip();
        if ($nowip == 0) {
            $nowip = getIp();
        }
        $parameters = array(
            'mch_appid' => $this->appid, //小程序ID
            'mchid' => $this->mch_id, //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'partner_trade_no' => $param['partner_trade_no'],
            'openid' => $param['openid'], //用户id
            'check_name'=>$param['check_name']??'NO_CHECK',//校验用户姓名选项,
            're_user_name'=> $param['re_user_name']??'',//收款用户姓名
            'amount'=>$param['amount'],//金额
            'desc'=> $param['desc'],//企业付款描述信息
            'spbill_create_ip'=> $nowip,//Ip地址
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $return = $this->xmlToArray($this->postXmlSSLCurl($xmlData, $url, 60));
        writeLog('weixin/unifiedOrder',date('H:i:s')."\r\n"."xml:".$xmlData."\r\n"."reponse:".json_encode($return)."\r\n");
        return $return;
    }
    private function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }
    private function postXmlSSLCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //设置代理
//        curl_setopt($ch, CURLOPT_PROXY, '8.8.8.8');
//        curl_setopt($ch, CURLOPT_PROXYPORT, 8080);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        /**设置证书，cert与key分属两个.pem文件*/
//        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');//默认pem，可以注释
        //curl_setopt($ch,CURLOPT_CAINFO, $this->SSLROOTCA_PATH);
        curl_setopt($ch, CURLOPT_SSLCERT, $this->sslcert_path);
//        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');//默认pem，可以注释
        curl_setopt($ch, CURLOPT_SSLKEY, $this->sslkey_path);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }
    //数组转换成xml
    private function arrayToXml($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }

    //xml转换成数组
    private function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //作用：生成签名
    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    //作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = "";
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    function get_real_ip()
    {
        $ip = false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi('^(10│172.16│192.168).', $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    function get_client_ip($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    function wx_http_curl($url){
        //用curl传参
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //关闭ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);


        curl_setopt($ch,CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}