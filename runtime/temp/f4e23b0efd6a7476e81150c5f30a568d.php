<?php /*a:3:{s:60:"/www/wwwroot/pingshen/application/admin/view/system/log.html";i:1576651886;s:61:"/www/wwwroot/pingshen/application/admin/view/common/head.html";i:1576644440;s:61:"/www/wwwroot/pingshen/application/admin/view/common/foot.html";i:1576644440;}*/ ?>
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
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键字</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keywords" placeholder="模块|方法|内容|操作用户" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <fieldset class="layui-elem-field layui-field-title">-->
<!--        <legend><?php echo lang('userlist'); ?></legend>-->
<!--    </fieldset>-->
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>

<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script type="text/html" id="barDemo">
    <a href="<?php echo url('userEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
<!--    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>-->
</script>
<script type="text/html" id="open">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="正常|禁用" lay-filter="open"  {{ d.status == 1 ? 'checked' : '' }} >
</script>
<script type="text/html" id="userlevel">
    {{ d.userlevel == 1 ? '普通会员' : '金牌会员' }}
</script>
<script type="text/html" id="wxacode">
    <a href="{{d.wxacode}}" target="_blank"><img src="{{d.wxacode}}" alt="" width="30"></a>
</script>
<script type="text/html" id="parent_id">
    <a href="javascript:void(0)" lay-event="change_parent" title="单击变更" style="color: #008cff">{{d.parent_user}}</a>
</script>
<!--<script type="text/html" id="topBtn">-->
   <!--<a href="<?php echo url('adminAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?><?php echo lang('admin'); ?></a>-->
<!--</script>-->
<script>
    layui.use(['table','form','layer'], function() {
        var table = layui.table,form = layui.form,layer = layui.layer,$ = layui.jquery;

        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("log"); ?>',
            page:true,
            method:'post',
			toolbar: '#topBtn',
			title:'系统日志',
            // count:1000,
            // limit:20,
            cols: [[
                {field:'id', title: '编号', width:80,fixed: true}
                ,{field:'moudle', title: '模块'}
				,{field:'action', title: '方法'}
                ,{field:'detail', title: '内容',minWidth:400}
                ,{field:'admin_user', title: '操作人'}
                ,{field:'create_ip', title: '操作IP'}
                ,{field:'create_time', title: '操作时间'}
            ]]
        });
        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;
//            console.log(field);
            //执行重载
            tableIn.reload({
                where: field
            });

        });

    });
</script>
</body>
</html>