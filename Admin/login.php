<?php
include '../includes/comment.php';
include '../Comment.php';
if($start['status']!=1||$start['status']==""||$ip!=$start['ip']){};
if($start['status']==1)exit("<script language='javascript'>window.location.href='../Admin';</script>");
?>
<!doctype html>
<html lang="en" style="height:100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/layui.css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员后台登录</title>
    <link rel="shortcut icon" href="https://www.tzyx.site/wp-content/uploads/2021/08/favicon-1.png">
    <?echo $ver_config['css'];?>
</head>
<body style="background:url(../user/undefinedcss/images/loginbg.png) 0% 0% / cover no-repeat;padding-top: 8em;">
<div class="layui-container">
    <div class="layui-row layui-col-space8">
                        <div class="layui-col-xs12 layui-col-sm6 layui-col-sm-offset3">
            <div class="layui-card">
                <div class="layui-card-header" style="text-align: center;font-size: 1.2em;height: auto;background-color: none">
                    刀客源码源码专用登录器 <font color="#2e8b57">[独家]</font>
                </div>
            </div>
        </div>
        <div class="layui-col-xs12 layui-col-sm6 layui-col-sm-offset3">
            <div class="layui-card">
                <div v class="layui-card-header layui-bg-white">
                    管理系统后台<a href="javascript:void(0)" rel="external nofollow" style="float:right" onclick="document.getElementById('img').src='code.php'"><img id="img" border="1" src="code.php" class="verifyImg" id="verifyImg"></a>
                </div>
                <div class="layui-card-body" style="padding: 20px 15px;">
                    <div class="layui-form layui-form-pane">
                        <div class="layui-row layui-col-space8">
                            <div class="layui-col-xs12">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">帐号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="user" id="user" value="" required  lay-verify="required" placeholder="请输入您的登陆账户！" autocomplete="off" class="layui-input">
                                    </div></div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">密码</label>
                                    <div class="layui-input-block">
                                        <input type="password" name="pass" id="pass" value="" required  lay-verify="required" placeholder="请输入您的登陆密码！" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">验证码</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="code" id="code" maxlength="4" value="" required  lay-verify="required" placeholder="请输入验证码！" autocomplete="off" class="layui-input login_txtbx">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs12">
                                <button type="button" class="layui-btn layui-btn-fluid layui-btn-primary" id="login" onclick="loginOrder()">确定登陆</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
<script src="js/jquery.min.js"></script>
<script src="js/layui.all.js"></script>
<script>
function loginOrder() {
	var session=$("#code").val();
	var user=$("#user").val();
	var pass=$("#pass").val();
	if(user==''){layer.msg('请输入登录帐号');return false;}
	if(pass==''){layer.msg('请输入登录密码');return false;}
	if(session==''){layer.msg('验证码不能空');return false;}
	var dd = layer.load(1, {shade:[0.1,'#fff']});
	$.ajax({
		type : "POST",
		url : "ajax.php?login",
		data : {"session":session,"user":user,"pass":pass},
		dataType : "json",
		success : function(data) {
			layer.close(dd);
			if(data.code == 0){
				layer.msg(data.msg);
				setTimeout(function(){window.location.reload();},800);
			}else{
			    layer.msg(data.msg);
			    var a = document.getElementById('img').src='code.php';
			    a.click;
			}
		},
		error : function(data) {
		    layer.close(dd);
            layer.msg('数据返回失败 ');
            console.log(data.msg);
        }
	});
};
var user = document.getElementById("user");
var pass = document.getElementById("pass");
var code = document.getElementById("code");
user.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("login").click();
    }
});
pass.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("login").click();
    }
});
code.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("login").click();
    }
});
$("#code").focus(function(){
        layer.tips('这是验证码', '#img');
});
</script>
</body>
</html>