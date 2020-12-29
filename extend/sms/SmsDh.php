<?php

namespace sms;

//use think\facade\Config;
/**
 * 短信网短信控制器
 */
class SmsDh
{
    protected $url,$account,$password,$sign,$subcode;

    public function __construct()
    {
        $this->url = config('sms.dh.url');
        $this->account = config('sms.dh.account');
        $this->password = config('sms.dh.password');
        $this->sign = config('sms.dh.sign');
        $this->subcode = config('sms.dh.subcode');
    }

    /**
     * 发送短信
     * @param string $phones 手机号码,
     * @param string $content 短信内容
     * @param string $msgid 短信ID(唯一，UUID)，可空
     * @param string $sendtime 短信发送时间，可空
     *
     */
    public function sendSms($phones, $content, $msgid='') {
        $sendtime = date('YmdHi');
        // 发送数据包json格式：{"account":"8528","password":"e717ebfd5271ea4a98bd38653c01113d","msgid":"2c92825934837c4d0134837dcba00150","phones":"15711666132","content":"您好，您的手机验证码为：430237。","sign":"【8528】","subcode":"8528","sendtime":"201405051230"}
        $data = [
            'account' => $this->account,
            'password' => $this->password,
            'msgid' => $msgid,
            'phones' => $phones,
            'content' => $content,
            'sign' => $this->sign,
            'subcode' => $this->subcode,
            'sendtime' => $sendtime
        ];
        return $this->http_post_json ( $this->url . "/Submit", json_encode($data));
    }

    /**
     * 获取短信状态报告
     *
     */
    public function getSmsReport() {
        // 获取短信状态报告数据包json格式：{"account":"8528","password":"e717ebfd5271ea4a98bd38653c01113d"}
        $data = array ('account' => $this->account, 'password' => $this->password );
        return $this->http_post_json ( $this->url . "/Report", json_encode($data));
    }
    /**
     * 获取手机回复的上行短信
     *
     */
    public function getSms() {
        // 获取上行数据包json格式：{"account":"8528","password":"e717ebfd5271ea4a98bd38653c01113d"}
        $data = array ('account' => $this->account, 'password' => $this->password);
        return $this->http_post_json ( $this->url . "/Deliver", json_encode($data) );
    }

    /**
     * PHP发送Json对象数据, 发送HTTP请求
     *
     * @param string $url 请求地址
     * @param array $data 发送数据
     * @return String
     */
    public function http_post_json($url, $data) {
        $ch = curl_init ( $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen ( $data ) ) );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $ret = curl_exec ( $ch );
        curl_close ( $ch );
        return $ret;
    }

    public function verCode($content){
        return '您的验证码是'.$content;
    }

    public function get()
    {
        return config('sms.dh');
    }
}