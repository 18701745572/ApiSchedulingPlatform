<?php 
include '../includes/comment.php';
include '../Comment.php';
if($start['status']==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$rowts=mysqli_query($con,"SELECT * from sc_config WHERE k='admin_ction'");
$user=mysqli_fetch_array($rowts);
$calname=mysqli_query($con,"SELECT * from sc_config WHERE k='admin_user'");
$name=mysqli_fetch_array($calname);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>基本资料</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="css/layui-mini.css" media="all">
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" media="all">
<link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="//at.alicdn.com/t/font_2827587_e7db1paq2rd.css" media="all">
<link rel="stylesheet" href="css/public.css" media="all">
<script src="//at.alicdn.com/t/font_2827587_e7db1paq2rd.js"></script>
<?echo $ver_config['css'];?>
<style>
    .layui-form-item .layui-input-company {width: auto;padding-right: 10px;line-height: 38px;}
</style>
</head>
<body marginwidth="0" marginheight="0">
<div class="layuimini-container">
    <div class="layui-card-header"><i class="fa fa-user"></i> 基本资料</div>
    <div class="layuimini-main">
        <div class="layui-form layuimini-form">
            <div class="layui-form-item">
                <label class="layui-form-label required">登录账号</label>
                <div class="layui-input-block">
                    <input type="text" name="username" lay-verify="required" id="username" placeholder="请输入登录账号" value="<?php echo $name['v']?>" class="layui-input">
                    <tip>填写自己登录账号的名称。</tip>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label required">帐号身份</label>
                <div class="layui-input-block">
                    <input style="background:#f2f2f2;color:#000;font-weight:500;" type="text" name="usersf"  disabled="disabled" value="<?php echo $user['v']?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" onclick="ChangeName()" lay-filter="saveBtn">确认保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/layui.all.js"></script>
<script>
function ChangeName() {
	var name=$("#username").val();
	if(name==''){layer.alert('请输入登录帐号');return false;}
	var dd = layer.load(1, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "ajax.php?name",
		data : {"name":name},
		dataType : "json",
		success : function(data) {
			layer.close(dd);
			if(data.code == 0){
				layer.msg(data.msg);
				setTimeout(function(){window.parent.location.reload();},800);
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
</body>
</html>