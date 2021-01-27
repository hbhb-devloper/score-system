<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;

class Achievement extends Common
{
    public function initialize(){
//        parent::initialize();
    }

    public function acList()
    {
        $data = input();
        if(Request::isAjax()){
            $sql = Db::table('achievement')->alias('a')->leftJoin('users u','u.id=a.uid')->field('a.*,u.nickname');
            if (isset($data['nickname'])) {
                $sql->where('u.nickname','like',"%".$data['nickname']."%");
            }
            $list = $sql->group('uid,sign')->select();
            $count = count($list);
            if (!empty($list)) {
                foreach ($list as &$value) {
                    $value['nickname'] = Db::table('users')->where(['id'=>$value['uid']])->value('nickname');
                    $value['signs'] = '第'.$value['sign'].'期';
//                    $value['score'] = $this->getScore($value['id']);
                }
                array_multisort($list,SORT_DESC);
                $list = array_slice($list,($data['page']-1)*$data['limit'],$data['limit']);
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1,'count'=>$count];
        }
        return $this->fetch('acList');
    }

    public function acfList()
    {
        $data = input();
        if(Request::isAjax()){
            $sql = Db::table('achievement')->alias('a')->leftJoin('department d','d.id=a.c_id');
            $list = $sql->group('sign,c_id')->select();
            $count = count($list);
            if (!empty($list)) {
                foreach ($list as &$value) {
                    $value['signs'] = '第'.$value['sign'].'期';
                    $value['score'] = $this->getScore($value['sign'],$value['c_id']);
                }
//                array_multisort($list,SORT_DESC);
                $list = array_slice($list,($data['page']-1)*$data['limit'],$data['limit']);
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1,'count'=>$count];
        }
        return $this->fetch('acfList');
    }

    public function getScore($sign,$c_id) {
//        $user = ['王文生','盛华','高琴','郑航海','屠宇飞'];
        $user = ['2'=>'薄荷微凉','4'=>'Takers','6'=>'Lesley','16'=>'屠宇飞','17'=>'盛华'];
        $userid = ['2','4','6','16','17'];
        $data = Db::table('achievement')->alias('a')->leftJoin('users u','u.id=a.uid')
            ->where(['sign'=>$sign,'c_id'=>$c_id,'uid'=>$userid])->select();
        if (!empty($data)) {
            $num = 0;
            foreach ($data as $value) {
                //不管什么部门总经理分数占比一样
                if ($value['userlevel'] == 1) {
                    $num = $num + $value['total_score']/2;
                }else{
                    $depart = Db::table('department')->where('c_user','like',"%".$user[$value['uid']]."%")->column('id');
                    //总经理部门区别计算公式和有两个经理的分管领导部门相同
                    if (in_array($c_id,['2','3']) || $c_id == '5') {
                        $num = $num + $value['total_score']/8;
//                    }elseif($c_id == '5'){
//                        //判断是否为两个经理的部门
//                        $num = $num + $value['total_score']/8;
                    }else{
                        //判断是否为本部门经理
                        $num = $num + (in_array($c_id,$depart) ? $value['total_score']/4:$value['total_score']/12);
                    }
                }
            }
            return round($num,2);
        }
        return '';
    }

    public function acdList()
    {
        $data = input();
        if(Request::isAjax()){
            $sql = Db::table('achievement')->where(['uid'=>$data['uid'],'sign'=>$data['sign']]);
            $count = $sql->count();
            $list = $sql->limit(($data['page']-1)*$data['limit'],$data['limit'])->select();
            if (!empty($list)) {
                foreach ($list as &$value) {
                    $arr = explode(',',$value['score_detail']);
                    $value['nickname'] = Db::table('users')->where(['id'=>$value['uid']])->value('nickname');
                    $value['signs'] = '第'.$value['sign'].'期';
                    $value['c_id'] = Db::table('department')->where(['id'=>$value['c_id']])->value('class_name');
                    $value['total_score1'] = $arr[0];
                    $value['total_score2'] = $arr[1];
                    $value['total_score3'] = $arr[2];
                    $value['total_score4'] = $arr[3];
                }
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1,'count'=>$count];
        }
        $this->assign('uid',$data['uid']);
        $this->assign('sign',$data['sign']);
        return $this->fetch('acdList');
    }

    public function acDel() {
        $id=input('post.id');
        if($id){
            Db::table('achievement')->where('id','=',$id)->delete();
            return $result = ['code'=>1,'msg'=>'删除成功!'];
        }else{
            return $result = ['code'=>0,'msg'=>'删除失败'];
        }
    }

    public function acEdit() {
        if(request()->isPost()){
            $data = input('post.');
            $msg = [
                'stand_text'=>$data['stand_text'],
                'stand_name'=>$data['stand_name'],
                'mark'=>$data['mark'],
            ];
            $res = Db::table('achievement')->where('id',$data['id'])->update($msg);
            return $result = ['code'=>1,'msg'=>'修改成功!','url'=>url('stList')];
        }else{
            $info = Db::name('achievement')->find(input('id'));
            $this->assign('info', json_encode($info,true));
            return view('acAdd');
        }
    }


}
