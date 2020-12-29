<?php

namespace app\api\controller;

use app\common\model\GoodsCategory as mCat;
use app\common\model\Users as mUser;
use app\common\model\Warehouse as mWH;
use sms\SmsDh;
use think\facade\Env;
use think\facade\Request;
use weixin\Weixin;
use weixin\WeixinPay;
use think\Db;

//use think\facade\Config;

class Test extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    function getChildCatId($cat_id,$ids){
        $clist = mCat::where(['status'=>1,'parent_id'=>$cat_id])->select();
        if(!empty($clist)){
            foreach ($clist as $k=>$v){
                if($ids!=''){$ids .= ',';}
                $ids .= $v['id'];
                $this->getChildCatId($v['id'],$ids);
            }
        }
        return $ids;
    }
    public function index(){
        echo $_SERVER['DOCUMENT_ROOT'];
        echo '<br>';
        echo ROOT_PATH;
        echo '<br>';
        echo PROJECT_PATH;
        echo '<br>';
        echo $_SERVER['HTTP_HOST'];
        echo '<br>';
        echo $_SERVER['PHP_SELF'];
        echo '<br>';
        echo $_SERVER['SCRIPT_FILENAME'];
        echo '<br>';
        echo $_SERVER['REQUEST_URI'];
        echo '<br>';
        echo $_SERVER['REQUEST_METHOD'];
        echo '<br>';
        echo DOMAIN;
        die;
        mUser::where('id',11910)->dec('cardgold',5);
        die;
        $res = Db::connect('mysql://facepaynew:3rxfGY2S4SmaLLpM@127.0.0.1:3306/facepaynew#utf8mb4')->table('b_webset')->select();var_dump($res);
        die;
        echo $this->getChildCatId(1,1);die;
        echo Env::get('runtime_path').'/../public/';
        echo __DIR__.'/../../../public/wxacode/';die;
        $wx = new Weixin();
        $wx->getWxAcode();
        $id = 0;
        $aa = createWxacode($id."_qrcode.jpg",'dddddddddddd');die;
$wxp = new WeixinPay();

//        writeLog('weixin/unifiedOrder',date('H:i:s')."\r\n"."xml:1"."\r\n"."reponse:2"."\r\n");die;
//        $data = $this->postdata;
        echo '<pre>';
       echo cache('mp_accesstoken');
        die;
        getCommission(10,11808);
        $cityid = 320300;
        $whid = mWH::where([['','EXP',Db::raw("FIND_IN_SET($cityid,region)")]])->value('id');
        var_dump($whid);die;
//        $wx = new WeixinPay(1,1,1,1,1);
//        var_dump(config('sms.dh'));echo 111;exit;
//        exit;
        $this->response(0,'error');
        var_dump(config('cardflow')[1]);
//        $sms = new SmsDh();
//        $res = $sms->sendSms('15068706979',$sms->verCode(rand(1000,9999)));
//        echo $res;
    }
}