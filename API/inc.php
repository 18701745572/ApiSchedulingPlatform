<?php
function get_client_ip(){
    if ($_SERVER['REMOTE_ADDR']){
        $cip = $_SERVER['REMOTE_ADDR'];
    }elseif(getenv("REMOTE_ADDR")){
        $cip = getenv("REMOTE_ADDR");
    }elseif(getenv("HTTP_CLIENT_IP")){
        $cip = getenv("HTTP_CLIENT_IP");
    }else{
        $cip = "unknown";
    }
    return $cip;
};
$ip=get_client_ip();
//接口是否开启
$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
$tokens = explode('/', $url);
$channel = $tokens[sizeof($tokens)-2];
if(empty($channel)){
    $channel = $tokens[sizeof($tokens)-4];
}
$status_qy = mysqli_query($con,"select * from sc_inter where channel='$channel'");
$status = mysqli_fetch_array($status_qy);
if($status['status']!='1'){
    header('Content-type:text/json');
    $result=array("code"=>-1,"msg"=>"接口未开启,请联系管理员");
	exit(json_encode($result, JSON_UNESCAPED_UNICODE));
}

//接口调用数量
$sql = mysqli_query($con,"select counter from sc_inter where channel='$channel'");
$arr = mysqli_fetch_array($sql);
$arr = $arr[0]+1;
mysqli_query($con,"UPDATE sc_inter SET counter='$arr' where channel='$channel'");

//用户调用次数
$usersql = mysqli_query($con,"select user_counter from sc_users where user_ip='$ip'");
$userarr = mysqli_fetch_array($usersql);
$userarr = $userarr[0]+1;

//用户可调用次数
$usrquery = mysqli_query($con,"select * from sc_users where user_ip='$ip'");
$usrcount = mysqli_fetch_array($usrquery);
$usr=$usrcount['user_counter1'];

//用户
$usersql = mysqli_query($con,"select display_name from sc_users where user_ip='$ip'");
$userip = mysqli_fetch_array($usersql);

/*if($userarr>$usr){
    header('Content-type:text/json');
    $result=array("code"=>-1,"msg"=>"今日可用次数已达上限");
	exit(json_encode($result, JSON_UNESCAPED_UNICODE));
}elseif($userip){
    mysqli_query($con,"UPDATE sc_users SET user_counter='$userarr' where user_ip='$ip'");
}else{*/
    mysqli_query($con,"UPDATE sc_users SET user_counter='$userarr' where user_ip='$ip'");

?>