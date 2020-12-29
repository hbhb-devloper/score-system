<?php /*a:1:{s:72:"D:\wwwroot\buguniao\application\layuiadmin\view\senior\echarts\line.html";i:1571751280;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Echarts集成 - 折线图</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../../layuiadmin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">标准折线图</div>
          <div class="layui-card-body">

            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-normline">
              <div carousel-item id="LAY-index-normline">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">堆积折线图</div>
          <div class="layui-card-body">
            
            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-heapline">
              <div carousel-item id="LAY-index-heapline">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">不等距折线图</div>
          <div class="layui-card-body">
            
            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-diffline">
              <div carousel-item id="LAY-index-diffline">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">堆积面积图</div>
          <div class="layui-card-body">
            
            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-heaparea">
              <div carousel-item id="LAY-index-heaparea">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">面积图</div>
          <div class="layui-card-body">
           
            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-area">
              <div carousel-item id="LAY-index-area">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

          </div>
        </div>
        <div class="layui-card">
          <div class="layui-card-header">对数轴</div>
          <div class="layui-card-body">
           
            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-logline">
              <div carousel-item id="LAY-index-logline">
                <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
              </div>
            </div>

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
  }).use(['index', 'senior']);
  </script>
</body>
</html>



