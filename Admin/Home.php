<?php 
include '../includes/comment.php';
include '../Comment.php';
if($start['status']==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$rowts=mysqli_query($con,"SELECT * from sc_config WHERE k='admin_ction'");
$user=mysqli_fetch_array($rowts);
$total_con=mysqli_query($con,"select * from `sc_total`");
$total_tj=mysqli_fetch_array($total_con);
$qiuhe_sql=mysqli_query($con,"SELECT SUM(counter) AS heji FROM sc_inter");
$heji=mysqli_fetch_array($qiuhe_sql);
$qiuhe=$heji['heji'];
$coun = mysqli_query($con,"SELECT name FROM sc_inter");
$count=mysqli_num_rows($coun);

$total1 = $qiuhe - $total_tj['total'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>首页</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="css/layui-mini.css" media="all">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="//at.alicdn.com/t/font_2827587_e7db1paq2rd.css" media="all">
  <script src="//at.alicdn.com/t/font_2827587_e7db1paq2rd.js"></script>
  <?echo $ver_config['css'];?>
</head>
<body>
<style>
    @media screen and (min-width:475px){.ptch-overflow-x td{white-space: nowrap;}}
    .layui-layer-dialog,.layui-layer{top:150px !important;}
    .current{background: #ff5149 !important;}
    a.page-numbers:hover{color: #00ffd2;}
    .page-numbers {border-radius:4px;padding:2px 6px;margin:4px;font-size:16px;background: #009688;color: #fff;}
    .layui-card {border:1px solid #f2f2f2;border-radius:5px;}
    .icon {margin-right:10px;color:#1aa094;}
    .icon-cray {color:#ffb800!important;}
    .icon-blue {color:#1e9fff!important;}
    .icon-tip {color:#ff5722!important;}
    .layuimini-qiuck-module {text-align:center;margin-top: 10px}
    .layuimini-qiuck-module a i {display:inline-block;width:100%;height:60px;line-height:60px;text-align:center;border-radius:2px;font-size:30px;background-color:#F8F8F8;color:#333;transition:all .3s;-webkit-transition:all .3s;}
    .layuimini-qiuck-module a cite {position:relative;top:2px;display:block;color:#666;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;font-size:14px;}
    .welcome-module {width:100%;height:210px;}
    .panel {background-color:#fff;border:1px solid transparent;border-radius:3px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
    .panel-body {padding:10px}
    .panel-title {margin-top:0;margin-bottom:0;font-size:12px;color:inherit}
    .label {display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;margin-top: .3em;}
    .layui-red {color:red}
    .main_btn > p {height:40px;}
    .layui-bg-number {background-color:#F8F8F8;}
    .layuimini-notice:hover {background:#f6f6f6;}
    .layuimini-notice {padding:7px 16px;clear:both;font-size:12px !important;cursor:pointer;position:relative;transition:background 0.2s ease-in-out;}
    .layuimini-notice-title,.layuimini-notice-label {
            padding-right: 70px !important;text-overflow:ellipsis!important;overflow:hidden!important;white-space:nowrap!important;}
    .layuimini-notice-title {line-height:28px;font-size:14px;}
    .layuimini-notice-extra {position:absolute;top:50%;margin-top:-8px;right:16px;display:inline-block;height:16px;color:#999;}
    .pull-right {float:right;}
    .layui-col-space15>* {padding:7.5px;}
    .layui-col-md6 {padding:7.5px;}
    @media screen and (max-width:532px){.width{width: 493px;}}
</style>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">   
        <!-- 数据统计 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-warning icon"></i>数据统计</div>
                <div class="layui-card-body">
                    <div class="welcome-module">
                        <div class="layui-row layui-col-space10">
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-blue">接口</span>
                                            <h5>今日调用</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $total1?></h1>
                                            <small>今日调用接口总数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-cyan">接口</span>
                                            <h5>昨日调用</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $total_tj['yesterday']?></h1>
                                            <small>昨日调用接口总数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-orange">接口</span>
                                            <h5>公共调用</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $total_tj['total']?></h1>
                                            <small>总共调用接口总数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-green">页面</span>
                                            <h5>访问统计</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $total_tj['visit']?></h1>
                                            <small>访问本站页面总数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 版本信息 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-fire icon"></i>版本信息</div>
                <div class="layui-card-body layui-text">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td>框架名称</td>
                                <td><?php echo $ver_config['LayuiVer']?></td>
                            </tr>
                            <tr>
                                <td>当前版本</td>
                                <td><?php echo $ver_config['versions']?></td>
                            </tr>
                            <tr>
                                <td>主要特色</td>
                                <td>零门槛/响应式/清爽/极简</td>
                            </tr>
                            <tr>
                                <td>服务特色</td>
                                <td>免费提供API接口服务</td>
                            </tr>
                            <tr>
                                <td>网站接口</td>
                                <td>当前共有<span style="color:#ff5722;font-weight:600;"> <?php echo $count?></span> 个接口</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--作者心语-->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card" style="height:232px;">
                    <div class="layui-card-header">
                        <i class="fa fa-bullhorn icon icon-tip"></i>作者心语
                    </div>
                    <div class="layui-card-body layui-text layadmin-text">
                        <p>不知道写什么...</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- 服务器信息 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-gears icon"></i>服务器信息</div>
                <div class="layui-card-body layui-text ptch-overflow-x">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td>服务器系统</td>
                                <td>
                                    <?php $os = explode(" ", php_uname()); echo $os[0];?>
                                    (
                                    <?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?>
                                    )
                                </td>
                            </tr>
                            <tr>
                                <td>PHP运行版本</td>
                                <td>
                                    <?php echo PHP_VERSION?>
                                </td>
                            </tr>
                            <tr>
                                <td>服务器读写权限 </td>
                                <td><?php echo is_writable('../Comment.php') ? '<span style="color: green;">可写</span>' : '<span style="color: red;">不可写</span>'?></td>
                            </tr>
                            <tr>
                                <td>服务器解释引擎</td>
                                <td style="padding-bottom: 0;">
                                    <?php echo $_SERVER['SERVER_SOFTWARE'];?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>      
        </div>
        <!-- 用户反馈 -->
        <div class="layui-col-md12" style="padding: 7.5px;">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-paper-plane-o icon"></i>用户反馈</div>
                <div class="layui-table-body layui-table-main">
                    <table class="layui-table" style="margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td style="width:5%;border-left: none;">
                                    <div class="layui-table-cell" align="center">ID</div>
                                </td>
                                <td style="width:25%">
                                    <div class="layui-table-cell" align="center"><span>IP地址</span>
                                    </div>
                                </td>
                                <td style="width:25%">
                                    <div class="layui-table-cell" align="center">接口名称</div>
                                </td>
                                <td style="width:35%">
                                    <div class="layui-table-cell" align="center">接口问题</div>
                                </td>
                                <td style="width:10%;border-right: none;">
                                    <div class="layui-table-cell" align="center">操作</div>
                                </td>
                            </tr>
                            <?php 
                                //设置   
                                $page=1;
                                $pagesize=10;
         
                                //计算一共多少记录，用于计算页数
                                $rs = mysqli_query($con,"select count(*) from sc_reg");
                                $row = @mysqli_fetch_array($rs);
                                $numrows = $row[0];
         
                                //计算页数
                                $pages = intval($numrows / $pagesize);//求得整页
                                if ($numrows % $pagesize){   //余下的按一页来算
                                    $pages++;
                                }
                                //留存总页数
                                $_SESSION['pages']=$pages;
                                
                                //设置页数
                                if (isset($_GET['page'])){  //获取地址传来的页数
                                    $page = intval($_GET['page']);
                                }else{
                                    $page = 1;        //其他情况，都指向第一页
                                }
                                //计算记录的偏移量
                                $offset = $pagesize * ($page - 1);
         
                                //读取指定记录
                                $result = mysqli_query($con,"select * from `sc_reg` order by id limit $offset,$pagesize",$connect);

                                while($row=mysqli_fetch_array($result)){
                                    echo '<tr>';
                                    echo '<td style="width:5%;border-left: none;"><div class="layui-table-cell" align="center">'.$row['id'].'</div></td>';
                                    echo '<td style="width:25%"><div class="layui-table-cell" align="center">'.$row['ip'].'</div></td>';
                                    echo '<td style="width:25%"><div class="layui-table-cell" align="center">'.$row['name'].'</div></td>';
                                    echo '<td style="width:35%"><div class="layui-table-cell" align="center">'.$row['problem'].'</div></td>';
                                    echo '<td style="width:10%;border-right: none;"><div class="layui-table-cell" align="center"><a class="layui-btn layui-btn-danger layui-btn-xs" onclick="DelOrder('.$row['id'].')">删除</a></div></td>';
                                    echo '</tr>';
                                };
                                error_reporting(0);
                                if($pages>=2){
                                echo "<table><div class='width' align='center'><div style='margin:10px 0;'>共 <span class='tiaopages'>".$pages."</span> 页（".$page."/".$pages."）</div>";
                                if($page==1){//处于首页的话
                                    echo '<div style="margin:10px 0;"><span aria-current="page" class="page-numbers current">首页</span>';
                                    echo '<span aria-current="page" class="page-numbers current">上一页</span>';
                                    $tempx=$page+1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$tempx." '>下一页</a>";
                                    echo "<a class='page-numbers' href='Home.php?page=".$pages."'>末页</a>";
                                }else if($page==$pages){//处于末页的话
                                    echo "<div style='margin:10px 0;'><a class='page-numbers' href='Home.php?page=1'>首页</a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$temps."'>上一页</a>";
                                    echo '<span aria-current="page" class="page-numbers current">下一页</span>';
                                    echo '<span aria-current="page" class="page-numbers current">末页</span>';
                                }else {
                                    echo "<div style='margin:10px 0;'><a class='page-numbers' href='Home.php?page='1''>首页</a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$temps."'>上一页</a>";
                                    $tempx=$page+1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$tempx." '>下一页</a>";
                                    echo "<a class='page-numbers' href='Home.php?page=".$pages."'>末页</a>";
                                }
                                echo " 跳转到<input style='width:40px;margin:0 6px;text-align:center;color:#009688;border-radius:4px;border:1px solid;' id='tiao' type='text' value='".$page."'>页   <input style='border:none;' class='page-numbers' type='submit' value='跳转' onclick='tiao()'></div>"; 
                                echo '</div></table>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<div style="text-align:center;margin:20px 0 4px 0;"><a href="https://www.tzyx.site" target="_blank">台州驿宣网络 ·<a target="_blank" href="https://beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img style="float:left;" src="/assets/img/beian.jpg">皖ICP备1906666666号</a>
</div>
<div style="text-align:center;color:#009688;margin:0 0 20px 0;">© Copyright 2022 - 2025 | 免费API调度平台 | All Rights Reserved </div>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
layui.use('carousel', function(){
  var carousel = layui.carousel;
  //建造实例
  carousel.render({
    elem: '#test-carousel-normal'
    ,width: '100%' //设置容器宽度
    ,height: '238px' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
});

  layui.config({
    base: '../assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
  
  //跳转页面
function tiao(){
    var page=$("#tiao").val();
    var pages=<?php echo $pages?>;
    if(page>'0'&&page<=pages){
        parent.document.getElementById("home").src="Home.php?page="+page;
    }else{
        layer.alert('你在搞什么，没看到你有多少页吗？',{offset:'150px'});
        return;
    }
}
  
  //删除数据
  function DelOrder(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	layer.confirm("你确定要删除吗？",{
		btn: ['确定', '取消']
	}, function () {
		$.ajax({
		type : "POST",
		url : 'ajax.php?del',
		data : {id:id},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg(data.msg);
			}else{
				layer.alert(data.msg);
			}
			setTimeout(function(){window.location.reload();},800);
		} 
	});
	}, function(){
	    layer.close(ii);
		return;
	});
};
</script>
</body>
</html>