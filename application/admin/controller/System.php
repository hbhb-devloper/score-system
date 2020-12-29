<?php
namespace app\admin\controller;

use think\facade\Request;
use app\admin\model\SysLog;

class System extends Common
{
    public function log(){
        if(Request::isAjax()){
            $page = input('page')??1;
            $limit = input('limit')??10;
            $offset = $this->getOffset($page,$limit);
            $val=input('keywords');
            $map = [];
            if($val){
                $map[]= ['moudle|action|detail|admin_user','like',"%".$val."%"];
            }
            $count = SysLog::where($map)->count();
            $list = SysLog::where($map)->limit($offset,$limit)->order('id desc')->select();
            return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
        }
        return $this->fetch();
    }
}