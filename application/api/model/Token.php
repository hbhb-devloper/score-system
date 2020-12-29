<?php
namespace app\api\model;

use think\Db;
use think\Model;
use think\facade\Cache;

class Token extends Model
{

	public $errcode = 0;
	public $code = 1;


	public function checktoken($token)
	{
		$userid = cache($token);
		if (!$userid) {
			return ['code'=>0,'msg'=>'登陆已过期或还没有登陆'];
		}
		return ['code'=>1,'data'=>$userid];
	}

	//生成唯一标识符
	protected function create_unique($uid=NULL) {
		$agent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT']:'undefine1';
		$addr = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:'undefine2';
		$data = $uid == NULL ? $agent . $addr
			.time() . rand() : $agent . $addr
			. $uid .time() . rand();

		return sha1($data);
	}

	//生成token
	public static function createToken($data=[]) {
		$token = self::create_unique($data['userid']);
		cache($token,$data['userid']);
        cache($token.'_openid',$data['openid']);
		return $token;
	}


}