<?php
namespace app\api\validate;

use think\Db;
use think\Validate;

class Company extends Validate
{
    protected $rule =   [
        'compname'  => 'require',
        'bank_name'  => 'require',
        'bank_account' =>'require',
        'swift' => 'require',
    ];
    protected $message  =   [
        'compname.require'      => '用户真实姓名不能为空',
        'bank_name.require'      => '开户银行不能为空',
        'bank_account.require'      => '银行账户不能为空',
        'swift.require'       => 'swift不能为空',
    ];

}