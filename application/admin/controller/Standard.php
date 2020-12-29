<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;

class Standard extends Common
{
    public function initialize(){
//        parent::initialize();
    }
    public function stList()
    {
        if(Request::isAjax()){
            $list=Db::table('standard')->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
        }
        return $this->fetch('stList');
    }

    public function stDel() {
        $id=input('post.id');
        if($id){
            Db::table('standard')->where('id','=',$id)->delete();
            return $result = ['code'=>1,'msg'=>'删除成功!'];
        }else{
            return $result = ['code'=>0,'msg'=>'删除失败'];
        }
    }

    public function stAdd(){
        if(Request::isAjax()){
            $data = input('post.');
            $msg = [
                'create_time'=>time(),
                'stand_text'=>$data['stand_text'],
                'stand_name'=>$data['stand_name'],
                'mark'=>$data['mark'],
            ];
            $list = Db::table('standard')->insert($msg);
            if ($list) {
                return $result = ['code'=>1,'msg'=>'添加成功!','url'=>url('stList')];
            }
            return $result = ['code'=>0,'msg'=>'添加失败!','url'=>url('stList')];
        }else{
            $this->assign('info','null');
            return view('stAdd');
        }
    }

    public function stEdit() {
        if(request()->isPost()){
            $data = input('post.');
            $msg = [
                'stand_text'=>$data['stand_text'],
                'stand_name'=>$data['stand_name'],
                'mark'=>$data['mark'],
            ];
            $res = Db::table('standard')->where('id',$data['id'])->update($msg);
            return $result = ['code'=>1,'msg'=>'修改成功!','url'=>url('stList')];
        }else{
            $info = Db::name('standard')->find(input('id'));
            $this->assign('info', json_encode($info,true));
            return view('stAdd');
        }
    }
}