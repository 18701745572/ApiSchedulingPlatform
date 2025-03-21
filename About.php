<?php 
include 'Comment.php';
$url="About.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>更新历程</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css" media="all">
  <?echo $ver_config['css'];?>
</head>
<body>

<style>
/* 这段样式只是用于演示 */
#LAY-component-timeline .layui-card-body{padding:20px 42px;}
@media screen and (max-width:500px){#LAY-component-timeline .layui-card-body{padding:20px 25px;}.span-box{display:none !important;}}
.span-box{display:inline-block;border:0.04em solid;width:20%;margin:6px auto;}
</style>
<style type="text/css">
.layui-card{border-radius:10px;}
.layui-card-body>h3:before{content: '';position: absolute;top: 2px;left: 0;width: 20px!important;height: 20px!important;background: url(https://xyblog-1259307513.cos.ap-guangzhou.myqcloud.com/wp-content/uploads/2021/12/b0cebb85c3ed.png) no-repeat center;box-shadow: none;background-size: 100% !important;}
.layui-card-body>h3{color: var(--main);font-size: 18px;line-height: 24px;margin-bottom: 18px;position: relative;padding: 0 15px 0 28px;}
</style>

  <div class="layui-fluid" id="LAY-component-timeline">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">关于我们</div>
          <div class="layui-card-body">
            <h2 style="text-align:center;font-size:18px;margin:0 0 15px 0;">
                <span class="span-box"></span>
                <span style="margin: 0 12px;">关于免费API调用平台</span>
                <span class="span-box"></span>
            </h2>
            <p style="text-align:center;margin:0 0 20px 0;">API平台是免费为用户提供网络数据接口调用的服务平台</p>
            <p style="text-indent: 28px;">免费API调度平台主要提供稳定、高效、免费的 API 接口服务；接口服务器采用中小型服务器，请合理使用资源，不要长时间大流量占用接口；本站只是提供技术支持及维护，若以上接口侵犯贵站数据，请联系站长给以删除停止接口使用；本站API由站长个人开发并维护不能保证能永久使用，更多API接口正在赶来的路上....</p>
            <?php echo $ver_config['footer']?>
          </div>
      </div>
    </div>
  </div>
</div>
<script src="./assets/layuiadmin/layui/layui.js"></script>  
<script>
  layui.config({
    base: './assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index']);
</script>
</body>
</html>