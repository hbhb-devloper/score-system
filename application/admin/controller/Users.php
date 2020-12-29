<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;

class Users extends Common
{
    public function initialize(){
//        parent::initialize();
    }
    public function userList()
    {
        if(Request::isAjax()){
            $val=input('nickname');
//            $map='';
//            if($val){
//                $map['nickname|email|phone']= ['like',"%".$val."%"];
//            }
//            var_dump($map);
            $list=Db::table('users')->where('nickname|email|mobile','like',"%".$val."%")->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
        }
        return $this->fetch();
    }
    public function userState() {
        $id=input('post.id');
        $is_open=input('post.status');
        if (empty($id)){
            $result['status'] = 0;
            $result['info'] = '用户ID不存在!';
            $result['url'] = url('userList');
            return $result;
        }
        $res = db('users')->where('id='.$id)->update(['status'=>$is_open]);
        $result['status'] = !empty($res) ? 1:0;
        $result['info'] = $result['status'] == 1 ? '修改成功!':'修改失败';
        $result['url'] = url('userList');
        return $result;
    }

    public function userDel() {
        $id=input('post.id');
        if ($id){
            Db::table('users')->where('id','=',$id)->delete();
            return $result = ['code'=>1,'msg'=>'删除成功!'];
        }else{
            return $result = ['code'=>0,'msg'=>'删除失败'];
        }
    }

    public function userEdit() {
        if(request()->isPost()){
            $data = input('post.');
            $pwd = input('post.password');
//            $map[] = ['admin_id','<>',$data['admin_id']];
//            $where['admin_id'] = $data['admin_id'];

            if($data['nickname']){
                $check_user = Db::table('users')->where('id','<>',$data['id'])
                    ->where('nickname','=',$data['nickname'])->find();
                if ($check_user) {
                    return $result = ['code'=>0,'msg'=>'用户已存在，请重新输入用户名!'];
                }
            }

//            if ($pwd){
//                $data['password']=input('post.password','','md5');
//            }else{
//                unset($data['password']);
//            }
//            $msg = $this->validate($data,'app\admin\validate\Users');
//            if($msg!='true'){
//                return $result = ['code'=>0,'msg'=>$msg];
//            }
//            var_dump($data);die;
//            unset($data['file']);
            $res = Db::table('users')->where('id',$data['id'])->update($data);
//            var_dump($res);die;
            return $result = ['code'=>1,'msg'=>'修改成功!','url'=>url('userList')];
        }else{
            $info = Db::name('users')->find(input('id'));
            $this->assign('info', json_encode($info,true));
            $this->assign('title','编辑会员信息');
            return view('user_form');
        }
    }
}