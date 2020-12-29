<?php
namespace app\common\model;

use think\Model;

class WeixinUser extends Model
{
    protected $name = "weixin_user";
    //自动过滤掉不存在的字段
    protected $field = true;
}