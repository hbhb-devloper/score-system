<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;

class Department extends Common
{
    public function initialize(){
//        parent::initialize();
    }
    public function deList()
    {
        if(Request::isAjax()){
            $list=Db::table('department')->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
        }
        return $this->fetch('deList');
    }

    public function deDel() {
        $id=input('post.id');
        if ($id){
            Db::table('department')->where('id','=',$id)->delete();
            return $result = ['code'=>1,'msg'=>'删除成功!'];
        }else{
            return $result = ['code'=>0,'msg'=>'删除失败'];
        }
    }

    public function deAdd(){
        if(Request::isAjax()){
            $data = input('post.');
            $msg = [
                'create_time'=>time(),
                'sort'=>$data['sort'],
                'class_name'=>$data['class_name'],
            ];
            $list = Db::table('department')->insert($msg);
            if ($list) {
                return $result = ['code'=>1,'msg'=>'添加成功!','url'=>url('deList')];
            }
            return $result = ['code'=>0,'msg'=>'添加失败!','url'=>url('deList')];
        }else{
            $this->assign('info','null');
            return view('deAdd');
        }
    }

    public function deEdit() {
        if(request()->isPost()){
            $data = input('post.');
            $res = Db::table('department')->where('id',$data['id'])->update($data);
            return $result = ['code'=>1,'msg'=>'修改成功!','url'=>url('deList')];
        }else{
            $info = Db::name('department')->find(input('id'));
            $this->assign('info', json_encode($info,true));
            $this->assign('title','编辑部门信息');
            return view('deAdd');
        }
    }
}