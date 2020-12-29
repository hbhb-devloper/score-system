<?php /*a:3:{s:75:"D:\wwwroot\buguniao\application\admin\view\parameter\exchangerate_list.html";i:1572228769;s:59:"D:\wwwroot\buguniao\application\admin\view\common\head.html";i:1570713522;s:59:"D:\wwwroot\buguniao\application\admin\view\common\foot.html";i:1570713522;}*/ ?>
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
        <legend><?php echo lang('exchangerate'); ?></legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>

<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script type="text/html" id="topBtn">
   <a href="<?php echo url('exchangerateAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?><?php echo lang('exchangerate'); ?></a>
</script>

<script type="text/html" id="barDemo">
    <a href="<?php echo url('userEdit'); ?>?admin_id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>

<!--<script type="text/html" id="topBtn">-->
   <!--<a href="<?php echo url('adminAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?><?php echo lang('admin'); ?></a>-->
<!--</script>-->
<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;

        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("exchangerare"); ?>',
            method:'post',
			toolbar: '#topBtn',
			title:'<?php echo lang("exchangerare"); ?>',
            cols: [[
                {field:'id', title: '编号', width:60,fixed: true}
                ,{field:'rate_date', title: '日期', minWidth:120}
				,{field:'rate', title: '美元vs人民币汇率', minWidth:150}
                ,{field:'add_user', title: '操作用户ID', minWidth:100}
                ,{field:'add_time', title: '添加时间', minWidth:150}
                ,{field:'up_user', title: '操作用户ID',minWidth:100}
                ,{field:'up_time', title: '修改时间',minWidth:150}
                ,{minWidth:120, align:'center', toolbar: '#barDemo'}
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
        form.on('switch(open)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var is_open = obj.elem.checked===true?1:2;
            $.post('<?php echo url("userState"); ?>',{'id':id,'is_open':is_open},function (res) {
                layer.close(loading);
                if (res.status==1) {
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    return false;
                }
            })
        });
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('<?php echo lang("Are you sure you want to delete it"); ?>', function(index){
                    $.post("<?php echo url('userDel'); ?>",{admin_id:data.admin_id},function(res){
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            obj.del();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });

    });
</script>
</body>
</html>