<?php
namespace app\api\validate;

use think\Db;
use think\Validate;

class Users extends Validate
{
    protected $rule =   [
        'phone'  => 'max:11|mobile|unique:users',
        'email'  => 'email|unique:users',
        'password' =>'require|length:6,32',
        'code' => 'require',
        'country_code' => 'require',
    ];
    protected $message  =   [
        'phone.max'      => '手机号最多11个数字',
        'phone.mobile'      => '手机号格式错误',
        'phone.unique'      => '手机号已经注册过了',
        'password.require'       => '密码不能为空',
        'password.length'       => '登录密码位数不能少于6位或者大于32位',
        'code.require'       => '验证码不能为空',
        'country_code.require'       => '国家代码不能为空',
        'email.email'           => '邮箱格式不正确',
        'email.unique'           => '该邮箱已经注册过了',
    ];

}