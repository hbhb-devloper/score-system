<?php /*a:3:{s:64:"/www/wwwroot/pingshen/application/admin/view/standard/stAdd.html";i:1578104548;s:61:"/www/wwwroot/pingshen/application/admin/view/common/head.html";i:1576644440;s:61:"/www/wwwroot/pingshen/application/admin/view/common/foot.html";i:1576644440;}*/ ?>
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
    <fieldset class="layui-elem-field layui-field-title">
        <legend>编辑评选标准</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" lay-filter="form">
        <div class="layui-form-item">
            <label class="layui-form-label">评选标准</label>
            <div class="layui-input-4">
                <input type="text" lay-verify="stand_name" name="stand_name" placeholder="<?php echo lang('pleaseEnter'); ?>评选标准" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分数档次</label>
            <div class="layui-input-4">
                <input type="text" lay-verify="mark" name="mark" placeholder="<?php echo lang('pleaseEnter'); ?>分数档次(格式示例：30,25,20,15,10)" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">评价要点</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="stand_text" class="layui-textarea" id="demo" style="display: none;"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <a href="<?php echo url('stList'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    layui.use(['form', 'layer','upload','layedit'], function () {
        var form = layui.form, layer = layui.layer,$= layui.jquery,upload = layui.upload,layedit = layui.layedit;
        var info = <?php echo $info; ?>;
        form.val("form", info);
        form.render();
        form.on('submit(submit)', function (data) {
            if (info) {
                data.field.id = info.id;
            }
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });
        layedit.set({
            uploadImage: {
                url: '<?php echo url("UpFiles/layedit"); ?>' //接口url
                ,type: 'post' //默认post
            }
        });
        var index = layedit.build('demo',{
            tool: ['left', 'center', 'right', '|', 'face','image','link','strong','italic','underline','del']
        });
        form.verify({
            stand_text: function(value) {
                layedit.sync(index);
            }
        });
    });
</script>