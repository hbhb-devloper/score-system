<?php /*a:3:{s:65:"/www/wwwroot/pingshen/application/admin/view/users/user_list.html";i:1582703630;s:61:"/www/wwwroot/pingshen/application/admin/view/common/head.html";i:1576644440;s:61:"/www/wwwroot/pingshen/application/admin/view/common/foot.html";i:1576644440;}*/ ?>
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
                        <label class="layui-form-label">用户信息</label>
                        <div class="layui-input-inline">
                            <input type="text" name="nickname" placeholder="请输入" autocomplete="off" class="layui-input">
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
    <fieldset class="layui-elem-field layui-field-title">
        <legend>用户信息</legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>

<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script type="text/html" id="barDemo">
    <a href="<?php echo url('userEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="open">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="open" {{ d.status == 1 ? 'checked' : '' }}>
</script>

<!--<script type="text/html" id="topBtn">-->
   <!--<a href="<?php echo url('adminAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?><?php echo lang('admin'); ?></a>-->
<!--</script>-->
<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;

        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("userList"); ?>',
            method:'post',
			toolbar: '#topBtn',
			title:'用户信息',
            cols: [[
                {field:'id', title: '编号', width:60,fixed: true}
                ,{field:'nickname', title: '用户名', minWidth:80}
                ,{field:'email', title: '邮箱', minWidth:170}
                ,{field:'mobile', title: '手机号', minWidth:120}
                ,{field:'headimg', title: '头像',minWidth:100}
                ,{field:'status', title: '状态',minWidth:100,toolbar: '#open'}
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
            var is_open = obj.elem.checked===true?1:0;
            $.post('<?php echo url("userState"); ?>',{'id':id,'status':is_open},function (res) {
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