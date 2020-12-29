<?php /*a:1:{s:84:"E:\phpstudy1\PHPTutorial\WWW\bgn\application\layuiadmin\view\app\workorder\list.html";i:1571809645;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layuiAdmin 工单系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../../layuiadmin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">  
    <div class="layui-card">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">工单号</label>
            <div class="layui-input-block">
              <input type="text" name="orderid" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">工单标题</label>
            <div class="layui-input-block">
              <input type="text" name="title" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">业务性质</label>
            <div class="layui-input-block">
              <input type="text" name="attr" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">受理人</label>
            <div class="layui-input-block">
              <input type="text" name="accept" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <button class="layui-btn layuiadmin-btn-order" lay-submit lay-filter="LAY-app-order-search">
              <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="layui-card-body">
        <table id="LAY-app-system-order" lay-filter="LAY-app-system-order"></table> 
        <script type="text/html" id="progressTpl">
          <div class="layui-progress layuiadmin-order-progress" lay-filter="progress-"+ {{ d.orderid }} +"">
            <div class="layui-progress-bar layui-bg-blue" lay-percent= {{ d.progress }}></div>
          </div>
        </script>
        <script type="text/html" id="buttonTpl">
          {{#  if(d.state == '已处理'){ }}
            <button class="layui-btn layui-btn-normal layui-btn-xs">已处理</button>
          {{#  } else if(d.state == '未分配'){ }}
            <button class="layui-btn layui-btn-primary layui-btn-xs">未分配</button>
          {{#  } else{ }}
            <button class="layui-btn layui-btn-warm layui-btn-xs">处理中</button>
          {{#  } }}
        </script>
        <script type="text/html" id="table-system-order">
          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
        </script>
      </div>
    </div>
  </div>

  <script src="../../../layuiadmin/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '../../../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'workorder', 'table'], function(){
    var $ = layui.$
    ,form = layui.form
    ,table = layui.table;
    
    //监听搜索
    form.on('submit(LAY-app-order-search)', function(data){
      var field = data.field;
      
      //执行重载
      table.reload('LAY-app-system-order', {
        where: field
      });
    });
  });
  </script>
</body>
</html>