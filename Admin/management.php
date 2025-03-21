<?php 
include '../includes/comment.php';
include '../Comment.php';
$rowts=mysqli_query($con,"SELECT * from sc_config WHERE k='admin_ction'");
$user=mysqli_fetch_array($rowts);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户管理</title>
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
    @media screen and (max-width:532px){.width{width: 784px;}}
    .layui-table-body {width: 100%;}
    .layui-table td, .layui-table th {padding: 9px;}
</style>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">   
        <!-- 接口管理 -->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-fire icon"></i>
                    用户管理
                    <div style="display:-webkit-inline-box;float:right;">
                        <button class="layui-btn layui-btn-sm layui-btn-success easyadmin-export-btn edit-btn1" onclick="editOrder()" style="margin:6px;">编辑</button>
                        <button class="layui-btn layui-btn-primary layui-btn-sm editout-btn" style="display:none;margin:6px;" onclick="editout()"> 取消 </button>
                        <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" style="margin:6px 0;" onclick="btnOrder()"> 添加 </button>
                        <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn del-btn1" onclick="del()" style="margin:6px;"> 删除 </button>
                        <button class="layui-btn layui-btn-primary layui-btn-sm out-btn" style="display:none;margin:6px;" onclick="out()"> 取消 </button>
                    </div>
                </div>
                <div class="layui-table-body layui-table-main">
                    <table class="layui-table" style="margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td style="width:2%;border-left: none;">
                                    <div class="layui-table-cell" align="center">ID</div>
                                </td>
                                <td style="width:10%">
                                    <div class="layui-table-cell" align="center"><span>用户名称</span>
                                    </div>
                                </td>
                                <td style="width:13%">
                                    <div class="layui-table-cell" align="center">用户邮箱</div>
                                </td>
                                <td style="width:10%">
                                    <div class="layui-table-cell" align="center">用户QQ</div>
                                </td>
                                <td style="width:10%">
                                    <div class="layui-table-cell" align="center">用户积分</div>
                                </td>
                                <td style="width:2%">
                                    <div class="layui-table-cell" align="center">会员等级</div>
                                </td>
                                <td style="width:15%">
                                    <div class="layui-table-cell" align="center">总共调用</div>
                                </td>
                                <td style="width:15%">
                                    <div class="layui-table-cell" align="center">可调用</div>
                                </td>
                                <td style="width:13%">
                                    <div class="layui-table-cell" align="center">绑定IP</div>
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
                                $rs = mysqli_query($con,"select count(*) from sc_users");
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
                                $result = mysqli_query($con,"select * from `sc_users` order by id limit $offset,$pagesize");

                                while($row=mysqli_fetch_array($result)){
                                    if($row['user_status']=='1'){
                                        $offset = 'layui-form-onswitch';
                                    }else{
                                        $offset = '';
                                    }
                                    echo '<tr id="inter'.$row['id'].'">';
                                    echo '<td style="border-left: none;"><div class="layui-table-cell" align="center">'.$row['zid'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['display_name'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">
                                    '.$row['user_email'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['user_qq'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['user_money'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">
                                    '.$row['user_level'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['huoyuecs'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['user_counter1'].'</div></td>';
                                    echo '<td><div class="layui-table-cell" align="center" id="user'.$row['id'].'">'.$row['user_ip'].'</div></td>';
                                    echo '<td style="border-right: none;"><div class="layui-table-cell" align="center"><div class="layui-unselect layui-form-switch '.$offset.'" onclick="check('.$row['id'].')" style="margin-top:0;min-width:40px;width:40px;"><em>开</em><i></i></div><button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn del-btn" onclick="interdel('.$row['id'].')" style="display:none"> 删除 </button><button class="layui-btn layui-btn-sm layui-btn-success easyadmin-export-btn edit-btn" onclick="edit_Order('.$row['id'].')" style="display:none">编辑</button></div></td>';
                                    echo '</tr>';
                                };
                                error_reporting(0);
                                if($pages>=2){
                                echo "<table><div class='width' align='center'><div style='margin:10px 0;'>共 <span class='tiaopages'>".$pages."</span> 页（".$page."/".$pages."）</div>";
                                if($page==1){//处于首页的话
                                    echo '<div style="margin:10px 0;"><span aria-current="page" class="page-numbers current">首页</span>';
                                    echo '<span aria-current="page" class="page-numbers current">上一页</span>';
                                    $tempx=$page+1;
                                    echo "<a class='page-numbers' href='Inter.php?page=".$tempx." '>下一页</a>";
                                    echo "<a class='page-numbers' href='Inter.php?page=".$pages."'>末页</a>";
                                }else if($page==$pages){//处于末页的话
                                    echo "<div style='margin:10px 0;'><a class='page-numbers' href='Inter.php?page=1'>首页</a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Inter.php?page=".$temps."'>上一页</a>";
                                    echo '<span aria-current="page" class="page-numbers current">下一页</span>';
                                    echo '<span aria-current="page" class="page-numbers current">末页</span>';
                                }else {
                                    echo "<div style='margin:10px 0;'><a class='page-numbers' href='Inter.php?page='1''>首页</a>";
                                    $temps=$page-1;
                                    echo "<a class='page-numbers' href='Inter.php?page=".$temps."'>上一页</a>";
                                    $tempx=$page+1;
                                    echo "<a class='page-numbers' href='Inter.php?page=".$tempx." '>下一页</a>";
                                    echo "<a class='page-numbers' href='Inter.php?page=".$pages."'>末页</a>";
                                }
                                echo " 跳转到<input style='width:40px;margin:0 6px;text-align:center;color:#009688;border-radius:4px;border:1px solid;' id='tiao' type='text' value='".$page."'>页   <input style='border:none;' class='page-numbers' type='submit' value='跳转' onclick='tiao()'></div>"; 
                                echo '</div></table>';}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<div style="text-align:center;margin:20px 0 4px 0;"><a href="https://www.tzyx.site" target="_blank">台州驿宣网络</a></div>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

function btnOrder() {
    var width = $(window).width();
    if(width>1001){
        var width = '800px';
    }else if (width<1000&&width>801){
        var width = '600px';
    }else if (width<800&&width>400){
        var width = '90%';
    }else{
        var width = '98%';
    }
    layer.open({
	    type: 1,
	    title: '添加接口',
	    skin: 'none',
	    fixed: false,
	    area: width,
	    offset:'100px',
	    content: $("#xinxi-add").html()
    });
}

function edit_Order(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?',
		data : {"id":id},
		dataType : 'json',
		success : function(data){
			layer.close(ii);
			if(data.code == 0){
				var width = $(window).width();
                    if(width>1001){
                        var width = '800px';
                    }else if (width<1000&&width>801){
                        var width = '600px';
                    }else if (width<800&&width>400){
                        var width = '90%';
                    }else{
                        var width = '98%';
                    }  
                    layer.open({
	                    type: 1,
	                    title: '修改接口',
	                    skin: 'none',
	                    fixed: false,
	                    area: width,
	                    content: data.data,
	                    offset:'150px',
	                    btn: ['确认修改', '取消修改'],
                        yes:function(index){
                            layer.close(index);
                            editBtn(id);
                        }
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

function editBtn(id) {
    var editname = $("input[name='editname']").val();
    var editqudao = $("input[name='editqudao']").val();
    var editremark = $("textarea[name='editremark']").val();
	if(editname==''||editqudao==''||editremark==''){layer.msg('请确保每项不能为空',{offset:'150px'});return false;}
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	$.ajax({
		type : 'POST',
		url : 'ajax.php?',
		data : {'id':id,'editname':editname,'editqudao':editqudao,'editremark':editremark},
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg('修改成功', {offset:'150px'});
				$('#name'+id).html(editname);
				$('#neirong'+id).html(editremark);
				$('#channel'+id).html(editqudao);
			}else{
				layer.msg(data.msg,{offset:'150px'});
			}
		},
		end: function(index, layero){
	        layer.close(indxex);
	    }
	});
};

function check(id){
var ii = layer.load(2, {shade:[0.1,'#fff']});
$.ajax({
	type : "POST",
	url : 'ajax.php?usercheck',
	data : {id:id},
	dataType : 'json',
	success : function(data) {
		layer.close(ii);
		if(data.code == 0){
			layer.msg(data.msg, {offset:'150px'});
		}else{
			layer.alert(data.msg, {offset:'150px'});
		}
		setTimeout(function(){window.location.reload();},800);
	} 
});
};

function del() {
    $('.layui-unselect').css({"display":"none"});
    $('.edit-btn1').css({"display":"none"});
    $('.del-btn1').css({"display":"none"});
    $('.del-btn').css({"display":"block"});
    $('.out-btn').css({"display":"block"});
}
function out() {
    $('.layui-unselect').css({"display":"block"});
    $('.edit-btn1').css({"display":"block"});
    $('.del-btn1').css({"display":"block"});
    $('.del-btn').css({"display":"none"});
    $('.out-btn').css({"display":"none"});
}
function editOrder() {
    $('.edit-btn1').css({"display":"none"});
    $('.del-btn1').css({"display":"none"});
    $('.editout-btn').css({"display":"block"});
    $('.layui-unselect').css({"display":"none"});
    $('.edit-btn').css({"display":"block"});
}
function editout() {
    $('.edit-btn1').css({"display":"block"});
    $('.del-btn1').css({"display":"block"});
    $('.editout-btn').css({"display":"none"});
    $('.layui-unselect').css({"display":"block"});
    $('.edit-btn').css({"display":"none"});
}
  //删除用户
  function interdel(id) {
	var ii = layer.load(2, {shade:[0.1,'#fff']});
	layer.confirm("你确定要删除吗？",{
		btn: ['确定', '取消']
	}, function () {
		$.ajax({
		type : "POST",
		url : 'ajax.php?userdel',
		data : {id:id},
		offset:'100px',
		dataType : 'json',
		success : function(data) {
			layer.close(ii);
			if(data.code == 0){
				layer.msg(data.msg, {offset:'150px'});
				$('#inter'+id).remove();
			}else{
				layer.alert(data.msg, {offset:'150px'});
			}
		} 
	});
	}, function(){
	    layer.close(ii);
		return;
	});
	
};
</script>
<?php 
include 'undefinedcss/add.php';
?>
</body>
</html>