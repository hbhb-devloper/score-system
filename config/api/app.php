<?php
return [
    'default_return_type'    => 'json',
    'whitelist' => [
        '/api/users/test',
        '/api/users/test2',
        '/api/up_files/upload',
        '/api/test/index',
        '/api/department/departList',
//        '/api/standard/standList',
        //
        '/api/system/sendsmscode',
        '/api/system/checksmscode',
        //登录注册
        '/api/users/reg',
        '/api/users/wxlogin',
        //回调
        '/api/notify/wxpay',
        '/api/notify/refund',
    ],
    'api_pwd'=>'9c9d947dea9dd37752ab091dcb45e9ac53eea851',
    'orderstatus'=>[
        -1  => '已删除'
        ,0  => '已取消'
        ,1   => '待付款'
        ,2   => '待发货'
        ,3   => '待收货'
        ,4   => '已收货'
        ,5   => '已自提'
//        6   => '已评价',
//        ,7   => '售后中'
//        ,8   => '售后完成'
    ],
];
