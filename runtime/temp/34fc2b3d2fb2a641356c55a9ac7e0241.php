<?php /*a:3:{s:68:"/www/wwwroot/pingshen/application/admin/view/achievement/acList.html";i:1583566955;s:61:"/www/wwwroot/pingshen/application/admin/view/common/head.html";i:1576644440;s:61:"/www/wwwroot/pingshen/application/admin/view/common/foot.html";i:1576644440;}*/ ?>
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
        <legend>评分记录信息</legend>
    </fieldset>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">用户昵称</label>
                        <div class="layui-input-6">
                            <input type="text" name="nickname"  autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-6">
                            <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                                <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>

<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script type="text/html" id="barDemo">
    <!--<a href="<?php echo url('acEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>-->
    <a href="<?php echo url('acdList'); ?>?id={{d.id}}&uid={{d.uid}}&sign={{d.sign}}" class="layui-btn layui-btn-xs">详情信息</a>
    <!--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>-->
</script>
<!--<script type="text/html" id="open">-->
    <!--<input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="open" {{ d.status == 1 ? 'checked' : '' }}>-->
<!--</script>-->

<!--<script type="text/html" id="topBtn">-->
   <!--<a href="<?php echo url('stAdd'); ?>" class="layui-btn layui-btn-sm">添加评选标准</a>-->
<!--</script>-->
<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;

        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("acList"); ?>',
            method:'post',
			toolbar: '#topBtn',
            page:true,
            limit: 10,
            limits: [10, 20, 30],
			title:'部门信息',
            cols: [[
                {field:'id', title: '编号', width:60,fixed: true,type:'numbers'}
                ,{field:'nickname', title: '用户昵称', minWidth:80}
                ,{field:'signs', title: '期数', minWidth:170}
//                ,{field:'score', title: '分数', minWidth:170}
                ,{field:'create_time', title: '添加时间', minWidth:120,templet: function(d){
                    return layui.util.toDateString(parseInt(d.create_time+"000"), "yyyy-MM-dd HH:mm:ss");
                }}
                ,{minWidth:120, align:'center', toolbar: '#barDemo'}
            ]],
            request: {
                pageName: 'page' // 页码的参数名称，默认：page
                , limitName: 'limit' //每页数据量的参数名，默认：limit
            },
            parseData: function (res) { //将原始数据解析成 table 组件所规定的数据
                return {
                    "code": res.code, //解析接口状态
                    "msg": res.msg, //解析提示文本
                    "count": res.count, //解析数据长度
                    "data": res.data //解析数据列表
                };
            }
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
//        form.on('switch(open)', function(obj){
//            loading =layer.load(1, {shade: [0.1,'#fff']});
//            var id = this.value;
//            var is_open = obj.elem.checked===true?1:2;
//            $.post('<?php echo url("deState"); ?>',{'id':id,'is_open':is_open},function (res) {
//                layer.close(loading);
//                if (res.status==1) {
//                    tableIn.reload();
//                }else{
//                    layer.msg(res.msg,{time:1000,icon:2});
//                    return false;
//                }
//            })
//        });
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('<?php echo lang("Are you sure you want to delete it"); ?>', function(index){
                    $.post("<?php echo url('stDel'); ?>",{id:data.id},function(res){
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