<?php /*a:1:{s:75:"D:\wwwroot\buguniao\application\layuiadmin\view\component\table\simple.html";i:1571751279;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>简单用法 - 数据表格</title>
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
      <a><cite>简单用法</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">简单用法</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-simple"></table>
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
    var table = layui.table;
  
    table.render({
      elem: '#test-table-simple'
      ,url: layui.setter.base + 'json/table/user.js'
      ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
      ,cols: [[
        {field:'id', width:80, title: 'ID', sort: true}
        ,{field:'username', width:80, title: '用户名'}
        ,{field:'sex', width:80, title: '性别', sort: true}
        ,{field:'city', width:80, title: '城市'}
        ,{field:'sign', title: '签名', width: '30%', minWidth: 100} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
        ,{field:'experience', title: '积分', sort: true}
        ,{field:'score', title: '评分', sort: true}
        ,{field:'classify', title: '职业'}
        ,{field:'wealth', width:137, title: '财富', sort: true}
      ]]
    });
  });
  </script>
</body>
</html>