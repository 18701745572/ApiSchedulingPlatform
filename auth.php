<?php
include './includes/comment.php';

// 检查用户是否已登录
if($ulogin['status'] != "1") {
    header("Location: login.php");
    exit();
}
?> 