<?php
namespace app\api\controller;

use app\common\model\Express as mExpress;
use sms\SmsDh;

class System extends Base
{
    public function sendSmsCode(){
        //验证
        $code = rand(1000,9999);
        $data = $this->postdata;
        $data['code'] = $code;
        $msg = $this->validate($data,'app\api\validate\Mobile');
        if($msg!='true'){
            return $result = ['code'=>0,'msg'=>$msg];
        }
        $mobile = $data['mobile'];
        $sms = new SmsDh();
        $res = $sms->sendSms($mobile,$sms->verCode($code));
        $res = json_decode($res,true);
        if($res['result']==0) {
            cache('code_' . $mobile, $code, 300);
            return ['code'=>1,'msg'=>'发送成功'];
        }else{
            return ['code'=>0,'msg'=>'发送失败'];
        }
    }

    public function checkSmsCode(){
        //验证
        $msg = $this->validate(input(),'app\api\validate\Mobile');
        if($msg!='true'){
            return $result = ['code'=>0,'msg'=>$msg];
        }
        $mobile = input('mobile');
        $code = input('code');
        $cachecode = cache('code_'.$mobile);
        if($code==$cachecode){
            return ['code'=>1,'msg'=>'ok'];
        }else{
            return ['code'=>0,'msg'=>'验证码错误'];
        }
    }

    public function region(){
        $data = $this->postdata;
        $pid = is_set($data['pid'])?$data['pid']:0;
        $list = $this->regionByPid($pid);
        $this->response(1,'ok',$list);
    }

    /**物流公司*/
    public function expressList(){
        $express_list = mExpress::where('status',1)->all();
        $this->response(1,'',$express_list);
    }
}