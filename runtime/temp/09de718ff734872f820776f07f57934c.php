<?php /*a:1:{s:74:"D:\wwwroot\buguniao\application\layuiadmin\view\component\table\thead.html";i:1571751279;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>复杂表头 - 数据表格</title>
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
      <a><cite>复杂表头</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">复杂表头</div>
          <div class="layui-card-body">
            <fieldset class="layui-elem-field layui-field-title">
              <legend>常用两级表头</legend>
            </fieldset>
 
            <table class="layui-table" lay-data="{width:800, page: true, limit: 6, limits:[6]}" lay-filter="test-table-thead1">
              <thead>
                <tr>
                  <th lay-data="{checkbox:true, fixed:'left'}" rowspan="2"></th>
                  <th lay-data="{field:'username', width:150}" rowspan="2">联系人</th>
                  <th lay-data="{align:'center'}" colspan="3">地址</th>
                  <th lay-data="{field:'amount', width:120}" rowspan="2">金额</th>
                  <th lay-data="{fixed: 'right', width: 160, align: 'center', toolbar: '#test-table-thead-barDemo'}" rowspan="2">操作</th>
                </tr>
                <tr>
                  <th lay-data="{field:'province', width:120}">省</th>
                  <th lay-data="{field:'city', width:120}">市</th>
                  <th lay-data="{field:'zone', width:200}">区</th>
                </tr>
              </thead>
            </table>
            
            <br>
            
            <fieldset class="layui-elem-field layui-field-title">
              <legend>更多级表头（可以无限极）</legend>
            </fieldset>
            <table class="layui-table" lay-data="{cellMinWidth: 80, page: true}" lay-filter="test-table-thead1">
              <thead>
                <tr>
                  <th lay-data="{field:'username', width:80}" rowspan="3">联系人</th>
                  <th lay-data="{field:'amount', width:120}" rowspan="3">金额</th>
                  <th lay-data="{align:'center'}" colspan="5">地址1</th>
                  <th lay-data="{align:'center'}" colspan="2">地址2</th>
                  <th lay-data="{fixed: 'right', width: 160, align: 'center', toolbar: '#test-table-thead-barDemo'}" rowspan="3">操作</th>
                </tr>
                <tr>
                  <th lay-data="{field:'province'}" rowspan="2">省</th>
                  <th lay-data="{field:'city'}" rowspan="2">市</th>
                  <th lay-data="{align:'center'}" colspan="3">详细</th>
                  <th lay-data="{field:'province'}" rowspan="2">省</th>
                  <th lay-data="{field:'city'}" rowspan="2">市</th>
                </tr>
                <tr>
                  <th lay-data="{field:'street'}" rowspan="2">街道</th>
                  <th lay-data="{field:'address'}">小区</th>
                  <th lay-data="{field:'house'}">单元</th>
                </tr>
              </thead>
            </table>
             
            <script type="text/html" id="test-table-thead-barDemo">
              <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">按钮1</a>
              <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">按钮2</a>
            </script>
            
            <br>
            <blockquote class="layui-elem-quote">注：上述例子读取的均是静态模拟数据</blockquote>
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
  
    table.init('test-table-thead1', {
      url: layui.setter.base + 'json/table/demo2.js'
    });
    
    table.init('test-table-thead2', {
      url: layui.setter.base + 'json/table/demo2.js'
    });
  
  });
  </script>
</body>
</html>