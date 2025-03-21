<?php
include './includes/comment.php';
session_start();

if(isset($_POST['submit'])) {
    $user_login = $_POST['user_login'];
    $user_pass = $_POST['user_pass'];
    $user_pass2 = $_POST['user_pass2'];
    $captcha = $_POST['captcha'];
    
    // 验证验证码
    if(strtolower($captcha) != strtolower($_SESSION['session'])) {
        echo "<script>alert('验证码错误!');history.go(-1);</script>";
        exit;
    }
    
    // 验证密码
    if($user_pass != $user_pass2) {
        echo "<script>alert('两次密码输入不一致!');history.go(-1);</script>";
        exit;
    }
    
    // 检查用户名是否已存在
    $check_sql = "SELECT * FROM sc_users WHERE user_login='$user_login'";
    $check_result = mysqli_query($con, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('用户名已存在!');history.go(-1);</script>";
        exit;
    }
    
    // 密码加密
    $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);
    
    // 插入用户数据
    $sql = "INSERT INTO sc_users (user_login, user_pass, user_status) VALUES ('$user_login', '$hashed_password', '1')";
    
    if(mysqli_query($con, $sql)) {
        $user_id = mysqli_insert_id($con);
        
        // 记录登录日志
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // 插入登录记录
        $login_sql = "INSERT INTO sc_login (zid, login, ip, status) VALUES ('$user_id', '$user_login', '$ip', '1')";
        mysqli_query($con, $login_sql);
        
        // 设置session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_login;
        $_SESSION['user_zid'] = $user_id;
        $_SESSION['user_name'] = $user_login;
        
        // 注册成功，跳转到首页
        echo "<script>alert('注册成功!'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('注册失败: " . mysqli_error($con) . "');history.go(-1);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css">
    <link rel="stylesheet" href="./assets/css/modern-login.css">
</head>
<body>
<div class="layui-container">
    <div class="layui-card">
        <div class="layui-card-header">
            用户<br>注册
        </div>
        <div class="layui-card-body">
            <form method="post" action="">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="text" name="user_login" required lay-verify="required" placeholder="请输入用户名" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="password" name="user_pass" required lay-verify="required" placeholder="请输入密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="password" name="user_pass2" required lay-verify="required" placeholder="请再次输入密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <input type="text" name="captcha" required lay-verify="required" placeholder="请输入验证码" class="layui-input">
                        <img src="Admin/code.php" onclick="this.src='Admin/code.php?'+Math.random()">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo" name="submit">立即注册</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        <a href="login.php" class="layui-btn layui-btn-link">返回登录</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./assets/layuiadmin/layui/layui.js"></script>
<script>
layui.use(['form'], function(){
    var form = layui.form;
});
</script>
</body>
</html> 