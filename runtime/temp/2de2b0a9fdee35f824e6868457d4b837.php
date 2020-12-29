<?php /*a:1:{s:78:"D:\wwwroot\buguniao\application\layuiadmin\view\component\table\resetPage.html";i:1571751279;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>自定义分页 - 数据表格</title>
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
      <a><cite>自定义分页</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">自定义分页</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-resetPage"></table>
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
      elem: '#test-table-resetPage'
      ,url: layui.setter.base + 'json/table/user.js'
      ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
        //,curr: 5 //设定初始在第 5 页
        ,groups: 1 //只显示 1 个连续页码
        ,first: false //不显示首页
        ,last: false //不显示尾页
        
      }
      ,cols: [[
        {field:'id', width:80, title: 'ID', sort: true}
        ,{field:'username', width:100, title: '用户名'}
        ,{field:'sex', width:80, title: '性别', sort: true}
        ,{field:'city', width:80, title: '城市'}
        ,{field:'sign', title: '签名', minWidth: 150}
        ,{field:'experience', width:80, title: '积分', sort: true}
        ,{field:'score', width:80, title: '评分', sort: true}
        ,{field:'classify', width:80, title: '职业'}
        ,{field:'wealth', width:135, title: '财富', sort: true}
      ]]
      
    });
  
  });
  </script>
</body>
</html>