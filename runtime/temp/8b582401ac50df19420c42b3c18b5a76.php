<?php /*a:3:{s:74:"D:\wwwroot\buguniao\application\admin\view\parameter\exchangerate_add.html";i:1572235888;s:59:"D:\wwwroot\buguniao\application\admin\view\common\head.html";i:1570713522;s:59:"D:\wwwroot\buguniao\application\admin\view\common\foot.html";i:1570713522;}*/ ?>
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
<div style="margin: 15px;" class="fadeInUp animated">
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo lang('add'); ?><?php echo lang('exchangerate'); ?></legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">日期</label>
            <div class="layui-input-4">
                <input type="text" name="rate_date" class="layui-input" id="rate_date" value="<?php echo htmlentities($rate_date); ?>" placeholder="请选择日期">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">汇率</label>
            <div class="layui-input-4">
                <input type="text" name="exchangerate" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>美元vs人民币汇率" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="admin_id">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <a href="<?php echo url('exchangerateList'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form,laydate = layui.laydate,$= layui.jquery;
        laydate.render({
            elem:'#rate_date'
            ,zIndex:999
        })
        form.render();
        form.on('submit(submit)', function (data) {
            // 提交到方法 默认为本身
            $.post("<?php echo url('exchangerateAdd'); ?>",data.field,function(res){
                if(res.code > 0){
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        location.href = res.url;
                    });
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            });
        })
    });
</script>