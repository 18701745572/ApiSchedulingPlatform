<?php
include './includes/comment.php';
session_start();

// 清除session
session_destroy();

// 清除本地缓存
echo "<script>
    localStorage.removeItem('user_zid');
    localStorage.removeItem('user_name');
    localStorage.removeItem('login_time');
    window.location.href = 'login.php';
</script>";
?> 