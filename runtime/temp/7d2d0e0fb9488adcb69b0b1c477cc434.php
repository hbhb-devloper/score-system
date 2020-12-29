<?php /*a:1:{s:72:"D:\wwwroot\buguniao\application\layuiadmin\view\component\nav\index.html";i:1571751278;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>导航</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../../layuiadmin/style/admin.css" media="all">
</head>
<body>

  <style>
  /* 这段样式只是用于演示 */
  #LAY-component-nav .layui-nav-tree {vertical-align: top;}
  </style>

  <div class="layui-fluid" id="LAY-component-nav">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">水平导航菜单</div>
          <div class="layui-card-body">
            <ul class="layui-nav" lay-filter="component-nav">
              <li class="layui-nav-item"><a href="javascript:;">最新活动</a></li>
              <li class="layui-nav-item layui-this">
                <a href="javascript:;">产品</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">选项1</a></dd>
                  <dd><a href="javascript:;">选项2</a></dd>
                  <dd><a href="javascript:;">选项3</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">大数据</a></li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd class="layui-this"><a href="javascript:;">选中项</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul>
          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">导航带徽章和图片</div>
          <div class="layui-card-body">
            <ul class="layui-nav" lay-filter="component-nav">
              <li class="layui-nav-item">
                <a href="javascript:;">控制台<span class="layui-badge">9</span></a>
              </li>
              <li class="layui-nav-item">
                <a href="javascript:;">个人中心<span class="layui-badge-dot"></span></a>
              </li>
              <li class="layui-nav-item" lay-unselect="">
                <a href="javascript:;"><img src="http://t.cn/RCzsdCq" class="layui-nav-img">我</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">修改信息</a></dd>
                  <dd><a href="javascript:;">安全管理</a></dd>
                  <dd><a href="javascript:;">退了</a></dd>
                </dl>
              </li>
            </ul>
          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">导航主题</div>
          <div class="layui-card-body">
            <ul class="layui-nav layui-bg-cyan" lay-filter="component-nav">
              <li class="layui-nav-item"><a href="javascript:;">藏青导航</a></li>
              <li class="layui-nav-item layui-this"><a href="javascript:;">产品</a></li>
              <li class="layui-nav-item"><a href="javascript:;">大数据</a></li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul>
            <br>
            <ul class="layui-nav layui-bg-green" lay-filter="component-nav">
              <li class="layui-nav-item"><a href="javascript:;">墨绿导航</a></li>
              <li class="layui-nav-item layui-this"><a href="javascript:;">产品</a></li>
              <li class="layui-nav-item"><a href="javascript:;">大数据</a></li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul>
            <br>
            <ul class="layui-nav layui-bg-blue" lay-filter="component-nav">
              <li class="layui-nav-item"><a href="javascript:;">艳蓝导航</a></li>
              <li class="layui-nav-item layui-this"><a href="javascript:;">产品</a></li>
              <li class="layui-nav-item"><a href="javascript:;">大数据</a></li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul> 
          </div>
        </div>
      </div>
      
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">垂直导航菜单</div>
          <div class="layui-card-body">
            <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="component-nav-active" style="margin-right: 10px;">
              <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;">默认展开</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">选项一</a></dd>
                  <dd><a href="javascript:;">选项二</a></dd>
                  <dd><a href="javascript:;">选项三</a></dd>
                  <dd><a href="javascript:;">跳转项</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">云市场</a></li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul>
            <ul class="layui-nav layui-nav-tree layui-bg-cyan layui-inline" lay-filter="component-nav-active">
              <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;">默认展开</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">选项一</a></dd>
                  <dd><a href="javascript:;">选项二</a></dd>
                  <dd><a href="javascript:;">选项三</a></dd>
                  <dd><a href="http://www.layui.com/admin/" target="_blank">跳转项</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item">
                <a href="javascript:;">解决方案</a>
                <dl class="layui-nav-child">
                  <dd><a href="javascript:;">移动模块</a></dd>
                  <dd><a href="javascript:;">后台模版</a></dd>
                  <dd><a href="javascript:;">电商平台</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="javascript:;">云市场</a></li>
              <li class="layui-nav-item"><a href="javascript:;">社区</a></li>
            </ul>
          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">面包屑</div>
          <div class="layui-card-body">
            <span class="layui-breadcrumb" lay-filter="breadcrumb">
              <a href="javascript:;">首页</a>
              <a href="javascript:;">演示</a>
              <a><cite>导航元素</cite></a>
            </span>
            <br>
            <span class="layui-breadcrumb" lay-separator="-" lay-filter="breadcrumb">
              <a href="javascript:;">首页</a>
              <a href="javascript:;">演示</a>
              <a><cite>导航元素</cite></a>
            </span>
            <br>
            <span class="layui-breadcrumb" lay-separator="\" lay-filter="breadcrumb">
              <a href="javascript:;">首页</a>
              <a href="javascript:;">演示</a>
              <a><cite>导航元素</cite></a>
            </span>
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
  }).use(['index'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element;

    element.render('nav', 'component-nav');
    element.render('nav', 'component-nav-active');
    
    element.on('nav(component-nav-active)', function(elem){
      layer.msg(elem.text());
    });
  });
  </script>
</body>
</html>
