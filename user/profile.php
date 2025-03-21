<?php
include '../includes/comment.php';
session_start();

// 检查是否登录
if(!isset($_SESSION['user_id'])) {
    echo "<script>alert('请先登录!');window.location.href='../login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// 获取用户信息
$sql = "SELECT * FROM sc_users WHERE id='$user_id'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_array($result);

// 获取用户API调用统计
$sql = "SELECT COUNT(*) as total FROM sc_logs WHERE user_id='$user_id'";
$result = mysqli_query($con, $sql);
$stats = mysqli_fetch_array($result);

// 处理头像上传
if(isset($_POST['upload_avatar'])) {
    $target_dir = "../uploads/avatars/";
    if(!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
    $new_filename = $user_id . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // 检查文件类型
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if(!in_array($file_extension, $allowed_types)) {
        echo "<script>alert('只允许上传JPG、JPEG、PNG和GIF格式的图片!');history.go(-1);</script>";
        exit;
    }
    
    // 上传文件
    if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar_url = 'uploads/avatars/' . $new_filename;
        $sql = "UPDATE sc_users SET avatar='$avatar_url' WHERE id='$user_id'";
        if(mysqli_query($con, $sql)) {
            echo "<script>alert('头像上传成功!');window.location.reload();</script>";
        } else {
            echo "<script>alert('头像更新失败!');history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('头像上传失败!');history.go(-1);</script>";
    }
}

// 处理密码修改
if(isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // 验证旧密码
    if(!password_verify($old_password, $user['password'])) {
        echo "<script>alert('旧密码错误!');history.go(-1);</script>";
        exit;
    }
    
    // 验证新密码
    if($new_password !== $confirm_password) {
        echo "<script>alert('两次输入的密码不一致!');history.go(-1);</script>";
        exit;
    }
    
    // 更新密码
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE sc_users SET password='$new_password' WHERE id='$user_id'";
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('密码修改成功!');window.location.reload();</script>";
    } else {
        echo "<script>alert('密码修改失败!');history.go(-1);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>个人中心 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css">
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">个人中心</div>
                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-md4">
                            <div class="layui-card">
                                <div class="layui-card-body">
                                    <div class="layui-upload">
                                        <div class="layui-upload-list">
                                            <img class="layui-upload-img" src="<?php echo $user['avatar'] ? '../'.$user['avatar'] : '../assets/img/default-avatar.png'; ?>" id="preview">
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <button type="button" class="layui-btn" id="upload">上传头像</button>
                                            <input type="file" name="avatar" id="avatar" style="display:none;">
                                            <button type="submit" name="upload_avatar" class="layui-btn">保存头像</button>
                                        </form>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">用户名</label>
                                        <div class="layui-input-block">
                                            <input type="text" value="<?php echo $user['username']; ?>" class="layui-input" readonly>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">邮箱</label>
                                        <div class="layui-input-block">
                                            <input type="email" value="<?php echo $user['email']; ?>" class="layui-input" readonly>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">注册时间</label>
                                        <div class="layui-input-block">
                                            <input type="text" value="<?php echo $user['register_time']; ?>" class="layui-input" readonly>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">API调用次数</label>
                                        <div class="layui-input-block">
                                            <input type="text" value="<?php echo $stats['total']; ?>" class="layui-input" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md8">
                            <div class="layui-card">
                                <div class="layui-card-header">修改密码</div>
                                <div class="layui-card-body">
                                    <form method="post">
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">旧密码</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="old_password" required lay-verify="required" placeholder="请输入旧密码" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">新密码</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="new_password" required lay-verify="required" placeholder="请输入新密码" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">确认密码</label>
                                            <div class="layui-input-block">
                                                <input type="password" name="confirm_password" required lay-verify="required" placeholder="请再次输入新密码" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <div class="layui-input-block">
                                                <button class="layui-btn" lay-submit lay-filter="formDemo" name="change_password">修改密码</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script>
layui.use(['upload', 'form'], function(){
    var upload = layui.upload;
    var form = layui.form;
    
    // 上传头像
    upload.render({
        elem: '#upload',
        url: '',
        auto: false,
        bindAction: '#upload',
        accept: 'images',
        acceptMime: 'image/*',
        done: function(res){
            $('#preview').attr('src', res.url);
        }
    });
});
</script>
</body>
</html> 