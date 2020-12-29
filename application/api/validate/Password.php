<?php
namespace app\api\validate;

use think\Db;
use think\Validate;

class Password extends Validate
{
    protected $rule =   [
        'new_password'  => 'length:6,32',
        'old_password'  => 'checkPass:old_password'
    ];
    protected $message  =   [
        'new_password.length'   => '登录密码位数不能少于6位或者大于32位',
    ];

    protected function checkPass($value,$role,$data) {
        $user = Db::table('users')->where(['password'=>$value,'id'=>$data['id']])->find();
        if (!empty($user)) {
            return true;
        }else{
            return '原密码错误';
        }
    }
}