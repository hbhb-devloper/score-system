<?php /*a:1:{s:75:"D:\wwwroot\buguniao\application\layuiadmin\view\component\table\height.html";i:1571751279;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>高度最大适应 - 数据表格</title>
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
      <a><cite>高度最大适应</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">高度最大适应</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-height"></table>
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
      elem: '#test-table-height'
      ,url: layui.setter.base + 'json/table/user30.js'
      ,height: 'full-100'
      ,cellMinWidth: 80
      ,page: true
      ,limit: 30
      ,cols: [[
        {type:'checkbox'}
        ,{field:'id', title: 'ID', width:100, sort: true}
        ,{field:'username', title: '用户名', width:100}
        ,{field:'sex', title: '性别', width:100, sort: true}
        ,{field:'sign', title: '签名', minWidth: 150}
        ,{field:'experience', title: '积分', sort: true, align: 'right'}
        ,{field:'score', title: '评分', sort: true, minWidth: 100, align: 'right'}
      ]]
    });
    
  });
  </script>
</body>
</html>