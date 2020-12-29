<?php
namespace app\admin\validate;

use think\Validate;

class Users extends Validate
{
    protected $rule =   [
//        'nickname'  => 'require|length:3,25',
        'email'     =>'email',
//        'real_name' =>'require'
    ];
    protected $message  =   [
//        'nickname.require'      => '用户名不能为空',
//        'nickname.length'      => '用户名在3到25个字符之间',
//        'real_name.require'       => '真实姓名不能为空',
        'email.email'           => '邮箱格式不正确',
    ];
}