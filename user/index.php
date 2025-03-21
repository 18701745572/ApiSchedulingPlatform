<?php 
include '../includes/comment.php';
include '../Comment.php';
if($ulogin['status']==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$rowts=mysqli_query($con,"SELECT * from sc_login WHERE ip='$ip'");
$zid=mysqli_fetch_array($rowts);
$kk = $zid['zid'];
$rowts=mysqli_query($con,"SELECT * from sc_users WHERE zid='$kk'");
$user=mysqli_fetch_array($rowts);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>用户后台 - <?php echo $conf_config['site']; ?></title>
    <meta name="keywords" content="<?php echo $conf_config['keywords']; ?>"/>
    <meta name="description" content="<?php echo $conf_config['description']; ?>">    
    <meta itemprop="name" content="免费API调用平台">
    <meta itemprop="image" content="../assets/img/logo.jpg">
    <meta name="description" itemprop="description" content="免费API接口使用平台、稳定、简单、快速的API接口调用平台！">
    <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
	<link rel="shortcut icon" href="https://www.tzyx.site/wp-content/uploads/2021/08/favicon-1.png">
	<?echo $ver_config['css'];?>
<script>
/^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
</script>
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="../" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right" style="margin-right:25px;">
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <img alt="XyPro的头像-台州驿宣网络" src="<?php echo $user['user_image']?>" style="width:35px;border-radius:20px;">
            <a href="javascript:;" style="display:inline-block;padding:0 20px 0 6px;">
              <p id="username"><?php echo $user['display_name']?></p>
            </a>
            <dl class="layui-nav-child layui-anim layui-anim-upbit">
                <dd class="layui-this">
                    <a href="javascript:;" lay-href="User.php" data-title="基本资料" data-icon="fa fa-gears">基本资料<span class="layui-badge-dot"></span></a>
                </dd>
                <dd>
                    <a href="javascript:;" lay-href="User-password.php" data-title="修改密码" data-icon="fa fa-gears">修改密码</a>
                </dd>
                <dd>
                    <hr>
                </dd>
                <dd>
                    <a href="javascript:;" onclick="OutOrder(<?php echo $kk?>)" class="login-out">退出登录</a>
                </dd>
            </dl>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="Home.php">
            <span><img src="/assets/layuiadmin/style/res/logo.png"/> 用户管理后台</span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <a lay-href="home.php">首页</a>
                </dd>
              </dl>
            </li>
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home.php" lay-attr="home.php" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="home.php" frameborder="0" class="layadmin-iframe" id="home"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script src="../Admin/js/jquery.min.js"></script>
<script>
  layui.config({
    base: '../assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
</script>  
<script>
var _hmt = _hmt || [];
(function() {
    var hm = document.createElement("script");
    var analytics_bd = 'e2ee099794c060028d1831d471790697';
    hm.src = ['ht', 't', 'ps', ':/', '/h', 'm', '.', 'ba', 'i', 'd', 'u.c', 'o', 'm/', 'h', 'm', '.j', 's?', analytics_bd].join('');
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
}
)();
function OutOrder(zid){
    var user = $('#username').html();
    var dd = layer.load(1, {shade:[0.1,'#fff']});
    $.ajax({
		type : "POST",
		url : "ajax.php?outclose",
		data : {"zid":zid,"user":user},
		dataType : "json",
		success : function(data) {
			layer.close(dd);
			if(data.code == 0){
				layer.msg(data.msg);
				setTimeout(function(){window.location.reload();},800);
			}else{
				layer.msg(data.msg);
			}
		},
		error : function(data) {
		    layer.close(dd);
            layer.msg('数据返回失败 ');
            console.log(data.msg);
        }
	});
};
</script>
<script type="text/javascript">
    console.log("页面生成耗时：<?php 
        $timer->stop();
        echo $timer->spent().'ms'; 
    ?>");
</script>
</body>
</html>