<?php /*a:1:{s:74:"D:\wwwroot\buguniao\application\layuiadmin\view\component\table\radio.html";i:1571751279;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>开启单选框 - 数据表格</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../../layuiadmin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
      <a lay-href="">主页</a>
      <a><cite>组件</cite></a>
      <a><cite>数据表格</cite></a>
      <a><cite>开启单选框</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">开启单选框</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-radio" lay-filter="test-table-radio"></table>
            
            <script type="text/html" id="test-table-radio-toolbarDemo">
              <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
              </div>
            </script>

          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="../../../layuiadmin/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '../../../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'table'], function(){
    var admin = layui.admin
    ,table = layui.table;
  
    table.render({
      elem: '#test-table-radio'
      ,url: layui.setter.base + '/json/table/user.js'
      ,toolbar: '#test-table-radio-toolbarDemo'
      ,cols: [[
        {type:'radio'}
        ,{field:'id', width:80, title: 'ID', sort: true}
        ,{field:'username', width:80, title: '用户名'}
        ,{field:'sex', width:80, title: '性别', sort: true}
        ,{field:'city', width:80, title: '城市'}
        ,{field:'sign', title: '签名', minWidth: 100}
        ,{field:'experience', width:80, title: '积分', sort: true}
        ,{field:'score', width:80, title: '评分', sort: true}
        ,{field:'classify', width:80, title: '职业'}
        ,{field:'wealth', width:135, title: '财富', sort: true}
      ]]
      ,page: true
    });
    
    //头工具栏事件
    table.on('toolbar(test-table-radio)', function(obj){
      var checkStatus = table.checkStatus(obj.config.id); //获取选中行状态
      switch(obj.event){
        case 'getCheckData':
          var data = checkStatus.data;  //获取选中行数据
          layer.alert(JSON.stringify(data));
        break;
      };
    });
  
  });
  </script>
  
</body>
</html>