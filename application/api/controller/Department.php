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

class Department extends Base
{

    public function initialize()
    {
        parent::initialize();
    }

    public function departList() {
        $data = input();
        $data['start_page'] = isset($data['start_page'])?$data['start_page']:0;
        $data['pages'] = isset($data['pages'])?$data['pages']:12;
        $sql = Db::table('department')->field('id,class_name')->order('sort desc,id asc');
        $res_data['total_pages'] = ceil($sql->count()/$data['pages']);
        $res_data['is_next'] = ($data['start_page']+1)<$res_data['total_pages'] ? 1:0;  //是否还有下一页
        $res_data['list'] = $sql->limit($data['start_page']*$data['pages'],$data['pages'])->select();
        return $this->response(1,'',$res_data);
    }
}