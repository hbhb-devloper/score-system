<?php /*a:3:{s:57:"D:\wwwroot\tp_base\application\admin\view\index\main.html";i:1570713521;s:58:"D:\wwwroot\tp_base\application\admin\view\common\head.html";i:1570713522;s:58:"D:\wwwroot\tp_base\application\admin\view\common\foot.html";i:1570713522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo config('sys_name'); ?>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/global.css" media="all">
    <link rel="stylesheet" href="/static/common/css/font.css" media="all">
</head>
<body class="skin-<?php if(!empty($_COOKIE['skin'])){echo $_COOKIE['skin'];}else{echo '0';setcookie('skin','0');}?>">
<div class="admin-main layui-anim layui-anim-upbit">
    <div class="table-responsive">
        <table class="layui-table" lay-even lay-skin="line">
            <colgroup>
                <col width="40%">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th class="text-center" colspan="2"><?php echo lang('systemInfo'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>网站域名</td>
                <td><?php echo htmlentities($config['url']); ?></td>
            </tr>
            <tr>
                <td>网站目录</td>
                <td><?php echo htmlentities($config['document_root']); ?></td>
            </tr>
            <tr>
                <td>服务器操作系统</td>
                <td><?php echo htmlentities($config['server_os']); ?></td>
            </tr>
            <tr>
                <td>服务器端口</td>
                <td><?php echo htmlentities($config['server_port']); ?></td>
            </tr>
            <tr>
                <td>服务器IP</td>
                <td><?php echo htmlentities($config['server_ip']); ?></td>
            </tr>
            <tr>
                <td>WEB运行环境</td>
                <td><?php echo htmlentities($config['server_soft']); ?></td>
            </tr>
            <tr>
                <td>MySQL数据库版本</td>
                <td><?php echo htmlentities($config['mysql_version']); ?></td>
            </tr>
            <tr>
                <td>运行PHP版本</td>
                <td><?php echo htmlentities($config['php_version']); ?></td>
            </tr>

            <tr>
                <td>最大上传限制</td>
                <td><?php echo htmlentities($config['max_upload_size']); ?></td>
            </tr>
            <tr>
                <td>CLTPHP版本</td>
                <td><?php echo config('version'); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    layui.use('table', function() {
        var table = layui.table;
    })
</script>
</body>
</html>