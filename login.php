<?php
include './includes/comment.php';
session_start();

if(isset($_POST['submit'])) {
    $user_login = $_POST['user_login'];
    $user_pass = $_POST['user_pass'];
    $captcha = $_POST['captcha'];
    
    // 验证验证码
    if(strtolower($captcha) != strtolower($_SESSION['session'])) {
        echo "<script>alert('验证码错误!');history.go(-1);</script>";
        exit;
    }
    
    // 查询用户
    $sql = "SELECT * FROM sc_users WHERE user_login='$user_login'";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_array($result);
        // 验证密码
        if(password_verify($user_pass, $user['user_pass'])) {
            // 检查用户状态
            if($user['user_status'] != '1') {
                echo "<script>alert('账号已被禁用!');history.go(-1);</script>";
                exit;
            }
            
            // 登录成功
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['user_login'];
            $_SESSION['user_zid'] = $user['id'];
            $_SESSION['user_name'] = $user['user_login'];
            
            // 记录登录日志
            $ip = $_SERVER['REMOTE_ADDR'];
            
            // 先检查是否已有登录记录
            $check_sql = "SELECT * FROM sc_login WHERE zid='".$user['id']."'";
            $check_result = mysqli_query($con, $check_sql);
            
            if(mysqli_num_rows($check_result) > 0) {
                // 更新现有记录
                $sql = "UPDATE sc_login SET login='".$user['user_login']."', ip='$ip', status='1' WHERE zid='".$user['id']."'";
            } else {
                // 插入新记录
                $sql = "INSERT INTO sc_login (zid,login,ip,status) VALUES ('".$user['id']."', '".$user['user_login']."', '$ip', '1')";
            }
            
            if(mysqli_query($con, $sql)) {
                // 确保session已经写入
                session_write_close();
                
                // 添加调试信息
                error_log("登录成功 - 用户ID: " . $user['id'] . ", IP: " . $ip);
                
                // 登录成功，跳转到首页
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            } else {
                // 记录错误信息
                $error = mysqli_error($con);
                error_log("登录状态更新失败: " . $error);
                echo "<script>alert('登录状态更新失败: " . $error . "');history.go(-1);</script>";
                exit;
            }
        } else {
            echo "<script>alert('密码错误!');history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('用户名不存在!');history.go(-1);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css">
    <link rel="stylesheet" href="./assets/css/modern-login.css">
</head>
<body>
<div class="layui-container">
    <div class="layui-card">
        <div class="layui-card-header">
            用户<br>登录
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
                        <input type="text" name="captcha" required lay-verify="required" placeholder="请输入验证码" class="layui-input">
                        <img src="Admin/code.php" onclick="this.src='Admin/code.php?'+Math.random()">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo" name="submit">立即登录</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        <a href="register.php" class="layui-btn layui-btn-link">注册账号</a>
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