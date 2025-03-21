<?php 
include 'includes/Config.php';
header('Content-type: text/json; charset=UTF8');
$thtime=date("Y-m-d").' 00:00';
$time=date("Y-m-d H:i");
$total_con=mysqli_query($con,"select * from `sc_total`");
$total_tj=mysqli_fetch_array($total_con);
$jt = $total_tj['today'];
$zt = $total_tj['yesterday'];
$zong = $total_tj['total'];
$ll = $total_tj['visit'];
//更新数据需要用到宝塔的计划任务！

if($thtime!=$time){
    $result = array('code'=>-1, 'msg'=>'更新失败,当前时间:'.$time.' 请稍后再试');
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    return;
}
if($jt==''&&$zt==''&&$zong==''&&$ll==''){
    mysqli_query($con,"INSERT INTO sc_total (today,yesterday,total,visit) VALUES ('1','1','1','1')");
}

//总共统计
$qiuhe=mysqli_query($con,"SELECT SUM(counter) AS heji FROM sc_inter");
$total=mysqli_fetch_array($qiuhe);
$heji=$total['heji'];
$result = array('code'=>0, 'msg'=>'数据已更新,当前总调用次数为:'.$heji);

//昨日统计
$yesday = $heji - intval($zong);

//主页被访问
$zhucoun = intval(file_get_contents("counter.dat")); 

//总共统计
$userCoun=mysqli_query($con,"SELECT * FROM sc_users");
$userCoun1=mysqli_fetch_array($userCoun);
$user_counter=$userCoun1['user_counter'];
$user_counter1=$userCoun1['huoyuecs'];
$Count=$user_counter+$user_counter1;

mysqli_query($con,"UPDATE sc_users SET user_counter='0',huoyuecs='$Count'");//更新数据到数据库
mysqli_query($con,"UPDATE sc_total SET today='0',yesterday='$yesday',total='$heji',visit='$zhucoun'");//更新数据到数据库
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
?>