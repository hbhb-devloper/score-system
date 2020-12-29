<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/15 0015
 * Time: 下午 12:43
 */

namespace app\common\controller;

use think\Controller;
use think\Db;

/**
 * 短信网短信控制器
 */
class SmsDxw extends Controller
{
    
    public $qcode = "http://api.1cloudsp.com/api/v2/single_send?";


    /**
     * 发送短消息
     * @param  [str] $mobile [手机号]
     * @param  [str] $code   [验证码]
     * @return [bool]         [description]
     */
    public function sendCode($mobile,$code)
    {
    	// 系统配置
    	$data = Db::name("config")->where("name","sms_cloudsp")->value("value");
    	$config = json_decode($data,true);

    	// 参数整理
    	$param = [
            "accesskey" => $config['accesskey'],
            "secret"    => $config['secret'],
            "sign"      => $config['sign'],
            "templateId"=> $config['templateId'],
            'mobile'    => $mobile,
            "content"   => json_encode("$code##10")
        ];

        // 调用commom.php公共函数发送短信息
        $result = httpRequestTwo($this->qcode, $param, "POST");
        
        $re = json_decode($result,true);

        return $re;
    }





}