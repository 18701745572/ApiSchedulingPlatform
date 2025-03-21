<?php
include 'Comment.php';
include 'includes/Config.php';
$counter1 = intval(file_get_contents("counter.dat"));  
$_SESSION['#'] = true;  
$counter1++;  
$fp = fopen("counter.dat","w");  
fwrite($fp, $counter1);  
fclose($fp); 

$coun = mysqli_query($con,"SELECT name FROM sc_inter");
$count=mysqli_num_rows($coun);

$total_con=mysqli_query($con,"select * from `sc_total`");
$total_tj=mysqli_fetch_array($total_con);
$qiuhe_sql=mysqli_query($con,"SELECT SUM(counter) AS heji FROM sc_inter");
$heji=mysqli_fetch_array($qiuhe_sql);
$qiuhe=$heji['heji'];
$total1 = $qiuhe - $total_tj['total'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>API列表</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="./assets/css/currency.css" media="all">
  <link rel="stylesheet" href="//at.alicdn.com/t/font_2827587_e7db1paq2rd.css" media="all">
  <script src="//at.alicdn.com/t/font_2827587_e7db1paq2rd.js"></script>
  <?echo $ver_config['css'];?>
</head>
<body>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">   
        <div class="layui-card" style="width:98%;text-align:center">
            <div class="layui-card-header" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                共发布了 <span class="inter"><?php echo $count?></span> 个接口 • 今日调用 <span class="inter"><?php echo $total1?></span> 次 • 总共调用了 <span class="inter"><?php echo $qiuhe?></span> 次
            </div>
        </div>
      </div>
      <div class="layui-col-md12">   
                            <?php 
                                //设置   
                                $page=1;
                                $pagesize=10;
         
                                //计算一共多少记录，用于计算页数
                                $rs = mysqli_query($con,"select count(*) from sc_inter");
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
                                $result = mysqli_query($con,"select * from `sc_inter` order by id DESC limit $offset,$pagesize",$connect);
                                while($row=mysqli_fetch_array($result)){
                                    $zid = $row['zid'];
                                    if($row['status']=='1'){
                                        $offset = 'layui-form-onswitch';
                                        $onf = 'state1';
                                        $java = "onclick='inclick($zid)'";
                                        $java1 = '<a '.$java.' class="layui-btn layui-btn-danger">点击调用</a>';
                                    }else{
                                        $offset = '';
                                        $onf = 'state0';
                                        $java = "javascript:void(layer.alert('接口在修复中...',{offset:'100px'}))";
                                        $java1 = '<a href="'.$java.'" class="layui-btn layui-btn-danger">点击调用</a>';
                                        
                                    }
                                    echo '<div class="layui-card">
                                            <div class="lcard">
                                                <div class="layui-card-header">
                                                    '.$row['name'].'
                                                </div>
                                                <div class="layui-card-body layui-text">
                                                    <table class="layui-table">
                                                    <colgroup>
                                                        <col width="100"><col>
                                                    </colgroup>
                                                    <tbody>
                                                        <tr>
                                                            <td class="weight">接口状态</td>
                                                            <td>
                                                                <script type="text/html" template>
                                                                    '. $ver_config[$onf].'
                                                                </script>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="weight">主要用处</td>
                                                            <td>'.$row['neirong'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="weight">调用渠道</td>
                                                            <td style="padding-bottom: 0;">
                                                                <div class="layui-btn-container">
                                                                    '.$java1.'
                                                                    <a href="javascript:;" onclick="inputOrder('.$row['id'].')" class="layui-btn btn-primary">接口反馈</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>';};
                                error_reporting(0);
                                if($pages>=2){
                                echo'<div style="margin:10px 0;" align="center">';
                                if($page==1){//处于首页的话
                                    echo '<span aria-current="page" class="page-numbers current"><i class="layui-icon layui-icon-prev"></i></span>';
                                    echo '<span aria-current="page" class="page-numbers current"><i class="layui-icon layui-icon-left"></i></span>';
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$page.'</div>';
                                    echo '/';
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$pages.'</div>';
                                    $tempx=$page+1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$tempx." '><i class='layui-icon layui-icon-right'></i></a>";
                                    echo "<a class='page-numbers' href='Home.php?page=".$pages."'><i class='layui-icon layui-icon-next'></i></a>";
                                }else if($page==$pages){//处于末页的话
                                    echo "<a class='page-numbers' href='Home.php?page=1'><i class='layui-icon layui-icon-prev'></i></a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$temps."'><i class='layui-icon layui-icon-left'></i></a>";
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$page.'</div>';
                                    echo '/';
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$pages.'</div>';
                                    echo '<span aria-current="page" class="page-numbers current"><i class="layui-icon layui-icon-right"></i></span>';
                                    echo '<span aria-current="page" class="page-numbers current"><i class="layui-icon layui-icon-next"></i></span>';
                                }else {
                                    echo "<a class='page-numbers' href='Home.php?page='1''><i class='layui-icon layui-icon-prev'></i></a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Home.php?page=".$temps."'><i class='layui-icon layui-icon-left'></i>/a>";
                                    $tempx=$page+1;
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$page.'</div>';
                                    echo '/';
                                    echo '<div aria-current="page" class="page-numbers current page-cur">'.$pages.'</div>';
                                    echo "<a class='page-numbers' href='Home.php?page=".$tempx." '><i class='layui-icon layui-icon-right'></i></a>";
                                    echo "<a class='page-numbers' href='Home.php?page=".$pages."'><i class='layui-icon layui-icon-next'></i></a>";
                                }
                                echo'</div>';
                                //echo "<div style='margin:10px;' align='center'>跳转到<input class='page-numbers current page-cur' style='width: 38px;text-align:  center;' id='tiao' type='text' value='".$page."'>页   <input style='border:none;' class='page-numbers' type='submit' value='GO' onclick='tiao()'></div>"; 
                                }
                            ?>
    </div>
  </div>
</div>
<script src="./assets/layuiadmin/layui/layui.js"></script>
<!--<script src="./assets/js/jquery-3.6.0.min.js"></script>-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
  layui.config({
    base: './assets/layuiadmin/' //静态资源所在路径
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
  
//反馈窗口
function inputOrder(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'Ajax.php?order',
		data : {"id":id},
		dataType : 'json',
		success : function(data){
			layer.close(ii);
			if(data.code == 0){
			    var width = $(window).width();
                if(width>400){var width='400px';}
                else{var width='98%';}
				layer.open({
				  type: 1,
				  shade: [0.6],
				  scrollbar: false,
				  title: '接口反馈',
				  area: width,
				  skin: 'none',
				  offset: '150px',
				  content: data.data
				});
			}else{
				layer.alert(data.msg,{offset:'150px'});
			}
		},
		error:function(data){
		    layer.close(ii);
			layer.msg('服务器错误');
			return false;
		}
	});
}

//反馈提交窗口
function saveOrder(id) {
	var inputlink=$("#inputlink").val();
	var inputnm=$("#inputnm").val();
	if(inputlink==''){layer.alert('请确保每项不能为空',{offset:'150px'});return false;}
	$('#save').val('Loading');
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : 'Ajax.php?order2',
		data : {id:id,inputlink:inputlink,inputnm:inputnm},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.alert('反馈成功,请等候管理员处理', {offset:'150px'});
			}else{
				layer.alert(data.msg,{offset:'150px'});
			}
			$('#save').val('提交信息');
			setTimeout(function(){window.location.reload();},1500);
		} 
	});
};

//接口调用窗口
function inclick(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'Ajax.php?interjk',
		data : {"id":id},
		dataType : 'json',
		success : function(data){
			layer.close(ii);
			if(data.code == 0){
			    var dd = '/API/index.php?channel='+data.msg+'&zid='+data.zid;
				var cou= layer.open({
                    title :'调用信息',
                    type: 2,
                    shade: false,
                    maxmin: true,
                    content: dd,
                    area: ['100%','100%'],
                });
                layer.full(cou);
			}else{
				layer.alert(data.msg,{offset:'150px'});
			}
		},
		error:function(data){
		    layer.close(ii);
			layer.msg('服务器错误');
			return false;
		}
	});
};
</script>
</body>
</html>