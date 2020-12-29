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

class Standard extends Base
{

    public function initialize()
    {
        parent::initialize();
    }

    //评分标准列表
    public function standList() {
        $data = input();
        $data['start_page'] = isset($data['start_page'])?$data['start_page']:0;
        $data['pages'] = isset($data['pages'])?$data['pages']:12;
        $sql = Db::table('standard')->field('stand_name,stand_text,mark');
        $res_data['total_pages'] = ceil($sql->count()/$data['pages']);
        $res_data['is_next'] = ($data['start_page']+1)<$res_data['total_pages'] ? 1:0;  //是否还有下一页
        $res_data['list'] = $sql->limit($data['start_page']*$data['pages'],$data['pages'])->select();
        $res_data['mark_msg'] = Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'status'=>1])->field('score_detail,total_score,c_id')->select();
        if (!empty($res_data['mark_msg'])) {
            array_walk_recursive($res_data['mark_msg'], function (& $val, $key ) {
                if ($key == 'score_detail') {
                    $val = explode(',',$val);
                }
            });
        }
        if (!empty($res_data['list'])) {
            foreach ($res_data['list'] as &$value) {
                $value['mark'] = explode(',',$value['mark']);
            }
        }
        return $this->response(1,'',$res_data);
    }

    //提交评分
    public function submitMark() {
        $data = input();
        if (!isset($data['mark_msg']) || !is_array($data['mark_msg'])) {
            return $this->response(0,'参数错误或数据格式错误');
        }
        if (!empty($data['mark_msg'])) {
            foreach ($data['mark_msg'] as $value) {
//                if ((!isset($value['c_id']) || empty($value['c_id'])) ||
//                    (!isset($value['total_score']) || empty($value['total_score'])) ||
//                    (!isset($value['score_detail']) || empty($value['score_detail']))) {
//                    return $this->response(0,'数据有误');
//                }
                $res = Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'c_id'=>$value['c_id'],'status'=>1])->find();
                $count = Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'c_id'=>$value['c_id']])->count();
                if (!empty($res)) {
                    Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'c_id'=>$value['c_id'],'status'=>1])->update([
                        'status'=>2,
                        'create_time'=>time(),
                        'sign'=>strval($count),
                        'total_score'=>intval($value['total_score']),
                        'score_detail'=>implode(',',$value['score_detail']),
                        'c_id'=>intval($value['c_id'])
                    ]);
                    continue;
                }
                $msg = [
                    'uid'=>$this->userinfo['id'],
                    'status'=>2,
                    'create_time'=>time(),
                    'sign'=>strval($count+1),
                    'total_score'=>intval($value['total_score']),
                    'score_detail'=>implode(',',$value['score_detail']),
                    'c_id'=>intval($value['c_id'])
                ];
                $db = Db::table('achievement')->insert($msg);
                if (!$db) {
                    return $this->response(0,'提交失败');
                }
            }
            return $this->response(1,'提交成功');
        }
        return $this->response(0,'提交数据不能为空');
    }

    //保存评分
    public function saveMark() {
        $data = input();
        if (!isset($data['mark_msg']) || !is_array($data['mark_msg'])) {
            return $this->response(0,'参数错误或数据格式错误');
        }
        if (!empty($data['mark_msg'])) {
            foreach ($data['mark_msg'] as $value) {
//                if ((!isset($value['c_id']) || empty($value['c_id'])) ||
//                    (!isset($value['total_score']) || empty($value['total_score'])) ||
//                    (!isset($value['score_detail']) || empty($value['score_detail']))) {
//                    return $this->response(0,'数据有误');
//                }
                $count = Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'c_id'=>$value['c_id']])->count();
                $msg = [
                    'uid'=>$this->userinfo['id'],
                    'status'=>1,
                    'create_time'=>time(),
                    'sign'=>strval($count+1),
                    'total_score'=>intval($value['total_score']),
                    'score_detail'=>implode(',',$value['score_detail']),
                    'c_id'=>intval($value['c_id'])
                ];
                $db = Db::table('achievement')->insert($msg);
                if (!$db) {
                    return $this->response(0,'提交失败');
                }
            }
            return $this->response(1,'提交成功');
        }
        return $this->response(0,'提交数据不能为空');
    }

    //评分列表
    public function markList() {
        $db = Db::table('achievement')->where(['uid'=>$this->userinfo['id']])->field('id,sign')->group('sign')->select();
//        var_dump($db);die;
        return $this->response(1,'',$db);
    }

    //获取评分详情
    public function markDetail() {
        $data = input();
        if (!isset($data['sign'])) {
            return $this->response(0,'参数错误');
        }
        $data['start_page'] = isset($data['start_page'])?$data['start_page']:0;
        $data['pages'] = isset($data['pages'])?$data['pages']:12;
        $sql = Db::table('standard')->field('stand_name,stand_text,mark');
        $res_data['total_pages'] = ceil($sql->count()/$data['pages']);
        $res_data['is_next'] = ($data['start_page']+1)<$res_data['total_pages'] ? 1:0;  //是否还有下一页
        $res_data['list'] = $sql->limit($data['start_page']*$data['pages'],$data['pages'])->select();
        $res_data['mark_msg'] = Db::table('achievement')->where(['uid'=>$this->userinfo['id'],'sign'=>$data['sign']])->field('score_detail,total_score,c_id')->select();
        if (empty($res_data['mark_msg'])) {
            return $this->response(0,'数据错误');
        }
        array_walk_recursive($res_data['mark_msg'], function (& $val, $key ) {
            if ($key == 'score_detail') {
                $val = explode(',',$val);
            }
        });
        if (!empty($res_data['list'])) {
            foreach ($res_data['list'] as &$value) {
                $value['mark'] = explode(',',$value['mark']);
            }
        }
        return $this->response(1,'',$res_data);
    }
}