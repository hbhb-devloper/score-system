<?php
namespace app\api\validate;

use think\Db;
use think\Validate;

class Member extends Validate
{
	protected $rule = [
		'password' => 'require|checkPwd:password|length:6,32',
		'phone' => 'checkName:phone',
		'email' => 'email',
//		['password', 'require|checkPwd:password', '登录密码不能为空'],
//		['phone', 'checkName:phone|unique:member', '手机号码格式不正确|该手机已注册'],
//		['email', 'email|unique:member', '邮箱格式不正确|该邮箱已注册'],
	];

	protected $message = [
		'password.require' => '密码不能为空',
		'password.length' => '登录密码位数不能少于6位或者大于32位',
		'email.email' => '邮箱格式不正确'
	];

	// 自定义验证规则
	protected function checkName($value,$rule,$data){
		if(is_mobile_phone($value)){
			return true;
		}else{
			return '手机号码格式不正确';
		}
	}

	protected function checkPwd($value,$rule,$data) {
//		var_dump($value);die;
		if (isset($data['phone'])) {
			$user = Db::table('users')->where(['password'=>$value,'phone'=>$data['phone']])->find();
		}else{
			$user = Db::table('users')->where(['password'=>$value,'email'=>$data['email']])->find();
		}
		if (!empty($user)) {
			return true;
		}else{
			return '密码不正确';
		}

	}
}