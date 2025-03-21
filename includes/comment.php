<?php
session_start();
header('Content-type: text/html; charset=UTF8');
$date=date('Y-m-d H:i:s');
$thtime=date("Y-m-d").' 00:00';
$chatdate=date("dS H:i");
$yesterday= date('Y-m-d H:i:s',strtotime('yesterday'));
$domain=addslashes($_SERVER['HTTP_HOST']);
$url = $_SERVER["QUERY_STRING"];
$preurl = $_SERVER["PHP_SELF"];
function get_client_ip(){
if ($_SERVER['REMOTE_ADDR']) {
    $cip = $_SERVER['REMOTE_ADDR'];
} elseif (getenv("REMOTE_ADDR")) {
    $cip = getenv("REMOTE_ADDR");
} elseif (getenv("HTTP_CLIENT_IP")) {
    $cip = getenv("HTTP_CLIENT_IP");
} else {
    $cip = "unknown";
}return $cip;};
$ip=get_client_ip();

require('Config.php');

//管理员登录记录
$log="select * from sc_logs where param='$ip' and addtime>='$thtime' and addtime<='$date'";
$logs=mysqli_query($con,$log);
$start=mysqli_fetch_array($logs);

//用户登录记录
$userlog=mysqli_query($con,"select * from sc_login where ip='$ip' and status='1'");
$ulogin=mysqli_fetch_array($userlog);

// 如果session中有用户ID，但登录记录不存在，则更新登录记录
if(isset($_SESSION['user_id']) && !$ulogin) {
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO sc_login (zid,login,date,enddate,ip,status) VALUES ('$user_id', '".$_SESSION['username']."', '$date', '0000-00-00 00:00:00', '$ip', '1')";
    mysqli_query($con, $sql);
    $ulogin = array('status' => '1');
}

$regs=mysqli_query($con,"select * from sc_logs where id");
$resu=mysqli_fetch_array($regs);
$result=$resu['result'];
?>