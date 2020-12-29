<?php
namespace app\api\controller;

use app\api\model\Token;
use app\common\model\PayLog as mPayLog;
use think\Db;
use app\common\model\Users as mUser;
use app\common\model\WeixinUser as mWxuser;
use app\common\model\UserAddress as mAddr;
use weixin\Weixin;
use weixin\WeixinPay;

class Users extends Base
{

    public function initialize()
    {
        parent::initialize();
    }

    public function wxlogin(){
        $data = $this->postdata;
        if(!is_set($data['code'])){
            $this->response(0,'登录凭证不能为空');
        }
        $wx = new Weixin();
        $res = $wx->code2session($data['code']);
        if(is_set($res['errcode']) || $res['errcode']!=0 || !is_set($res['openid'])){
            $this->response(0,'微信登录失败，请重试');
        }
        $openid = $res['openid'];
        //检测微信用户是否存在，不存在则添加
        $wxuser = mWxuser::where('openid',$openid)->find();
        if($wxuser && $wxuser['userid']){
            $user = mUser::get($wxuser['userid']);
            if($user){
                $user['openid'] = $openid;
                $user['token'] = Token::createToken(['userid'=>$user['id'],'openid'=>$openid]);
                $this->response(1,'登录成功',$user);
            }
        }
        $this->response(2,'用户不存在，请获取用户授权',$res);
    }
    /**
     * 用户注册并登录
     */
    public function reg(){
        $data = $this->postdata;
        $data['nickname'] = is_set($data['nickname'])?$data['nickname']:$data['nickName'];
        $data['avatarurl'] = is_set($data['avatarurl'])?$data['avatarurl']:$data['avatarUrl'];
        $data['openid'] = $data['openid']??$this->openid;
        if(!$data['openid']){
            return ['code'=>0,'msg'=>'非法登录:未授权'];
        }
        //检测微信用户是否存在，不存在则添加
        $wxuser = mWxuser::where('openid',$data['openid'])->find();
        if(!$wxuser){
            $wx = mWxuser::create($data);
            $wxuser = mWxuser::where('openid',$data['openid'])->find();
        }
        $userid = $wxuser['userid']??0;
        //通过微信用户绑定的用户编号获取用户信息
        if($userid){
            $user = mUser::get($userid);
        }else{
            $user = mUser::where('openid',$data['openid'])->order('id desc')->find();
            $userid = $user['id'];
        }
        //用户信息不存在则添加
        $data['headimg'] = $data['avatarurl'];
        $data['sex'] = $data['gender'];
        $data['parent_id'] = (int)$data['u'];
        if(!$user){
//            $userid = Db::table('users')->strict(false)->insertGetId($data);
            $user = mUser::create($data);
            $userid = $user->id;
        }
        $user = $user??mUser::get($userid);
        if(!$wxuser['userid'] || $wxuser['userid']!=$userid) {
            mWxuser::update(['userid' => $userid],['openid'=>$data['openid']]);
        }
        $upuser = [];
        if(!$user['nickname']){$upuser['nickname'] = $data['nickname'];}
        if(!$user['sex']){$upuser['sex'] = $data['sex'];}
        if(!$user['headimg']){$upuser['headimg'] = $data['headimg'];}
        if(!$user['country']){$upuser['country'] = $data['country'];}
        if(!$user['province']){$upuser['province'] = $data['province'];}
        if(!$user['city']){$upuser['city'] = $data['city'];}
        if($upuser){
            mUser::update($upuser,['id'=>$userid]);
            $user = mUser::get($userid);
        }
        $user['openid'] = $data['openid'];
        $user['token'] = Token::createToken(['userid'=>$userid,'openid'=>$data['openid']]);
        return ['code'=>1,'msg'=>'ok','data'=>$user];
    }

    /**
     * 绑定手机
     */
    public function bindMobile(){
//        $data = input('post.');
        $data = $this->postdata;
        $user = $this->userinfo;
        if(!$user['id']){
            return ['code'=>0,'msg'=>'用户编号错误'];
        }
        $msg = $this->validate(input(),'app\api\validate\Mobile');
        if($msg!='true'){
            $this->response(0,$msg);
        }
        $mobile = $data['mobile'];
        $code = $data['code'];
        $cachecode = cache('code_'.$mobile);
        if($code!=$cachecode && $code){
            $this->response(0,'验证码错误');
        }
        $uparr['mobile'] = $data['mobile'];
        if(!$this->userinfo['name']){
            $uparr['name'] = $data['mobile'];
        }
        mUser::update($uparr,['id'=>$user['id']]);
        $this->response(1,'绑定成功');
    }
    public function wxacode(){
        $param['u'] = $this->userid;
        $param['page'] = is_set(input('page'))?input('page'):'';
        $imgname = $this->userid.'_wxacode.jpg';
        $path = __DIR__.'/../../../public/wxacode/';
        $wxacode = $path.$imgname;
        if(!file_exists($wxacode)){
            $wx = new Weixin();
            $wx->getWxAcode($param);
        }
        return DOMAIN.'/wxacode/'.$imgname;
    }

    /**-------------------收货地地址---------------------/
    /**
     * 地址列表
     */
    public function addrList(){
        $map[] = ['userid','=',$this->userinfo['id']];
        $list = mAddr::where($map)
            ->order('is_default desc')
            ->select();
        foreach ($list as $k=>$v){
            $list[$k]['province_name'] = $this->region[$v['province']];
            $list[$k]['city_name'] = $this->region[$v['city']];
            $list[$k]['district_name'] = $this->region[$v['district']];
        }
        $this->response(1,'',$list);
    }
    /**
     * 添加地址
     */
    public function addAddr(){
        $data = $this->postdata;
        $msg = $this->validate($data,'app\api\validate\UserAddress');
        if($msg!='true'){
            $this->response(0,$msg);
        }

        //添加
        if ($res=mAddr::create($data)) {
            mAddr::update(['is_default'=>0],[['userid','=',$this->userinfo['id'],['id','<>',$res->id]]]);
            $this->response(1,'添加成功');
        } else {
            $this->response(0,'添加失败');
        }
    }
    /**
     * 修改地址
     */
    public function updateAddr(){
        $data = $this->postdata;
        if(!$data['id']){
            $this->response(0,'未选择要修改的地址');
        }
        if (mAddr::update($data,['id'=>$data['id'],'userid'=>$this->userinfo['id']])) {
            mAddr::update(['is_default'=>0],[['userid','=',$this->userinfo['id'],['id','<>',$data['id']]]]);
            $this->response(1,'success');
        } else {
            $this->response(0,'fail');
        }
    }
    /**
     * 删除地址
     */
    public function delAddr(){
        $data = $this->postdata;
        if(!$data['id']){
            $this->response(0,'未选择要删除的地址');
        }
        $map[] = ['id','=',$data['id']];
        $map[] = ['userid','=',$this->userinfo['id']];
        if (mAddr::where($map)->delete()) {
            $this->response(1,'success');
        } else {
            $this->response(0,'fail');
        }
    }
}