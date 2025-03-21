<?php 
include './includes/comment.php';
include 'Comment.php';
session_start();

// 检查登录状态
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 从session获取用户信息
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_zid = $_SESSION['user_zid'];

$rowts=mysqli_query($con,"SELECT * from sc_login WHERE ip='$ip'");
$zid=mysqli_fetch_array($rowts);
$kk = $zid['zid'];
$rowts=mysqli_query($con,"SELECT * from sc_users WHERE zid='$kk'");
$user=mysqli_fetch_array($rowts);
$counter = intval(file_get_contents("counter.dat"));
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $conf_config['site']; ?> - 免费提供API接口让用户有更好的体验！</title>
    <meta name="keywords" content="<?php echo $conf_config['keywords']; ?>"/>
    <meta name="description" content="<?php echo $conf_config['description']; ?>">    
    <meta itemprop="name" content="免费API调用平台">
    <meta itemprop="image" content="./assets/img/logo.jpg">
    <meta name="description" itemprop="description" content="免费API接口使用平台、稳定、简单、快速的API接口调用平台！">
    <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css" media="all">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
            <a href="#" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords="> 
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          
          <li class="layui-nav-item" lay-unselect>
            <a lay-href="Update.php" layadmin-event="message" lay-text="更新日记">
              <i class="layui-icon layui-icon-notice"></i>  
              
              <!-- 如果有新消息，则显示小圆点 -->
              <span class="layui-badge-dot"></span>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>

          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
                <div style="width:35px;height:35px;border-radius:20px;background-color:#1E9FFF;color:#fff;text-align:center;line-height:35px;display:inline-block;vertical-align:middle;">
                    <?php echo mb_substr($user_name, 0, 1); ?>
                </div>
                <span style="display:inline-block;padding:0 20px 0 6px;">
                    <?php echo $user_name; ?> (ID: <?php echo $user_zid; ?>)
                </span>
            </a>
            <dl class="layui-nav-child">
                <dd><a href="javascript:;" onclick="OutOrder()">退出登录</a></dd>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="Home.php">
            <span><img src="./assets/layuiadmin/style/res/logo.png"/> <?php echo $conf_config['site']; ?></span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <a lay-href="Home.php">首页</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="About.php">本站信息</a>
                </dd>
              </dl>
            </li>
            <li data-name="api" class="layui-nav-item">
              <a href="javascript:;" lay-tips="API管理" lay-direction="2">
                <i class="layui-icon layui-icon-api"></i>
                <cite>API管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console">
                  <a lay-href="Admin/Inter.php">接口管理</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="Admin/publish_api.php">发布接口</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="Admin/Addapi.php">接口页面</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="Admin/Addreturn.php">返回参数</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="Admin/Adderror.php">错误参数</a>
                </dd>
              </dl>
            </li>
            <li data-name="system" class="layui-nav-item">
              <a href="javascript:;" lay-tips="系统管理" lay-direction="2">
                <i class="layui-icon layui-icon-set"></i>
                <cite>系统管理</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console">
                  <a lay-href="Admin/management.php">用户管理</a>
                </dd>
              </dl>
            </li>
          </ul>
        </div>
        <p style="position:inherit;bottom:25px;left:45px;">本站被浏览了 <?php echo "$counter";?> 次</p>
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
            <li lay-id="Home.php" lay-attr="Home.php" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="Home.php" frameborder="0" class="layadmin-iframe" id="home" allowTransparency="true" ranat="server"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

<script src="./assets/layuiadmin/layui/layui.js"></script>
<!-- <script type="module">
	import devtools from './assets/js/moukey.js';
    	if (devtools.isOpen) {
    	   window.location.href = "./assets/banf12"};
	window.addEventListener('devtoolschange', event => {
	    if (event.detail.isOpen) {
	       window.location.href = "./assets/banf12"};
	});
</script> -->
<script>
  layui.config({
    base: './assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');

var _hmt = _hmt || [];
(function() {
    var hm = document.createElement("script");
    var analytics_bd = 'e2ee099794c060028d1831d471790697';
    hm.src = ['ht', 't', 'ps', ':/', '/h', 'm', '.', 'ba', 'i', 'd', 'u.c', 'o', 'm/', 'h', 'm', '.j', 's?', analytics_bd].join('');
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
}
)();
function openpage() {
        layer.ready(function() {
            //官网欢迎页
            layer.open({
                type: 2,
                skin: 'layui-layer-lan',
                title: '台州驿宣网络主页',
                fix: false,
                shadeClose: true,
                maxmin: true,
                shade: false,
                area: ['100%', '100%'],
                content: 'https://www.tzyx.site'
            });
            layer.msg('欢迎进入台州驿宣网络');
        }); 
};
</script>
<script type="text/javascript">
    console.log("页面生成耗时：<?php 
        $timer->stop();
        echo $timer->spent().'ms'; 
    ?>");
</script>
<script>
// 保存用户信息到本地缓存
function saveUserInfo(zid, username) {
    localStorage.setItem('user_zid', zid);
    localStorage.setItem('user_name', username);
}

// 从本地缓存获取用户信息
function getUserInfo() {
    return {
        zid: localStorage.getItem('user_zid'),
        username: localStorage.getItem('user_name')
    };
}

// 清除本地缓存的用户信息
function clearUserInfo() {
    localStorage.removeItem('user_zid');
    localStorage.removeItem('user_name');
}

// 页面加载时保存用户信息
document.addEventListener('DOMContentLoaded', function() {
    var userInfo = {
        zid: '<?php echo $user['zid']; ?>',
        username: '<?php echo $user['display_name']; ?>'
    };
    saveUserInfo(userInfo.zid, userInfo.username);
});

function OutOrder(){
    var dd = layer.load(1, {shade:[0.1,'#fff']});
    
    $.ajax({
        type : "POST",
        url : "logout.php",
        dataType : "json",
        success : function(data) {
            layer.close(dd);
            if(data.code == 0){
                layer.msg('退出成功');
                setTimeout(function(){
                    window.location.href = 'login.php';
                }, 800);
            } else {
                layer.msg(data.msg || '退出失败');
            }
        },
        error : function() {
            layer.close(dd);
            window.location.href = 'logout.php';
        }
    });
}
</script>
</body>
</html>