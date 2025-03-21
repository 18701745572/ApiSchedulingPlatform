<?php
include '../includes/comment.php';
session_start();
@header('Content-Type: application/json; charset=UTF-8');

// 获取URL参数
$url = '';
if(isset($_GET['outclose']) || isset($_POST['outclose'])) {
    $url = 'outclose';
} else {
    $url = $_SERVER["QUERY_STRING"];
}

switch($url){
case 'register':
    $se=$_POST['capt']; //验证码
    $user=$_POST['user']; //帐号
    $pass=$_POST['pass']; //密码
    $coun = mysqli_query($con,"SELECT * FROM sc_users");
    $count=mysqli_num_rows($coun);
    $count+=1;
    $new_user=mysqli_query($con,"select * from sc_users where user_login='$user'");
    $newuser = mysqli_fetch_array($new_user);
    if($newuser==''&&isset($se)){
    	session_start(); 
    	if(strtolower($se)==strtolower($_SESSION['session'])){ 
    	    $userpass = password_hash($pass, PASSWORD_DEFAULT,['cost' => 12]); //password_hash给密码加盐，需通过password_verify解密
            $result = array('code'=>0, 'msg'=>'注册成功');
            $zhu="INSERT INTO sc_users (zid,display_name,user_login,user_pass,user_email,user_qq,user_url,user_money,user_level,user_counter,user_counter1,user_ip,user_date,user_status) VALUES ('$count','$user','$user','$userpass','','','','0','0','0','500','$ip','$date','1')";
            mysqli_query($con,$zhu);
	    }else{ 
            $result = array('code'=>-1, 'msg'=>'验证码错误');
    	}
    }else{
    	$result = array('code'=>-1, 'msg'=>'该账户已注册');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
case 'login':
    $se=$_POST['capt']; //验证码
    $user=$_POST['user']; //帐号
    $pass=$_POST['pass']; //密码
    $coun = mysqli_query($con,"SELECT * FROM sc_login");
    $count=mysqli_num_rows($coun);
    $count+=1;
    $re=mysqli_query($con,"select * from sc_users where user_login='$user'"); //登录帐号
    $res=mysqli_fetch_array($re);
    $username = $res['user_login'];
    $userpass = $res['user_pass'];
    $userzid = $res['zid'];
    if($res['user_status']!='1') exit(json_encode(array('code'=>-1, 'msg'=>'帐号未开通'), JSON_UNESCAPED_UNICODE));
    if($res&&password_verify($pass, $userpass)===true&&isset($se)){ //password_verify验证密码跟数据库表里的密码是否为true
    	session_start(); 
    	if(strtolower($se)==strtolower($_SESSION['session'])){ 
            $result = array('code'=>0, 'msg'=>'登录成功');
            $re=mysqli_query($con,"select * from sc_login where zid='$userzid'"); //登录帐号
            $res=mysqli_fetch_array($re);
            if($res['zid']=='1'){
                $del="DELETE FROM sc_logs";
                mysqli_query($con,$del);
                $zhu="INSERT INTO sc_logs (action,param,addtime,status) VALUES ('后台登录','$ip','$date','1')";
                mysqli_query($con,$zhu);
            }
            if(!$res){
                $zhu="INSERT INTO sc_login (zid,login,date,enddate,ip,status) VALUES ('$count','$username','$date','0000-00-00 00:00:00','$ip','1')";
                mysqli_query($con,$zhu);
            }else{
                $zhu="UPDATE sc_login SET login='$username',date='$date',enddate='0000-00-00 00:00:00',ip='$ip',status='1' WHERE zid='$userzid'";
                mysqli_query($con,$zhu);
            }
	    }else{ 
            $result = array('code'=>-1, 'msg'=>'验证码错误');
    	}
    }else{
    	$result = array('code'=>-1, 'msg'=>'帐号或密码错误');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
//退出登录
case 'outclose':
    // 调试信息
    error_log("退出登录 - 请求方法: " . $_SERVER['REQUEST_METHOD']);
    error_log("退出登录 - GET数据: " . print_r($_GET, true));
    error_log("退出登录 - POST数据: " . print_r($_POST, true));
    
    $user = isset($_POST['user']) ? $_POST['user'] : ''; //帐号
    $zid = isset($_POST['zid']) ? $_POST['zid'] : ''; //帐号id
    
    // 调试信息
    error_log("退出登录 - 处理后的用户ID: " . $zid . ", 用户名: " . $user);
    
    // 验证参数
    if(empty($zid)) {
        error_log("退出登录 - 用户ID为空");
        $result = array('code'=>-1, 'msg'=>'无效的用户ID');
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
    
    if(empty($user)) {
        error_log("退出登录 - 用户名为空");
        $result = array('code'=>-1, 'msg'=>'无效的用户名');
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
    
    // 更新登录状态
    $sql = "UPDATE sc_login SET ip='000.000.000.000', status='0' WHERE zid='$zid'";
    error_log("退出登录 - SQL语句: " . $sql);
    
    $update = mysqli_query($con, $sql);
    
    if($update) {
        error_log("退出登录 - 更新成功");
        $result = array('code'=>0, 'msg'=>'退出成功');
    } else {
        error_log("退出登录 - 更新失败: " . mysqli_error($con));
        $result = array('code'=>-1, 'msg'=>'退出失败');
    }
    
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
//聊天发布
case 'chat-text':
    $user=$_POST['user']; //帐号
    $zid=$_POST['zid']; //帐号id
    $content=$_POST['content']; //聊天内容
    $content=htmlspecialchars($content, ENT_QUOTES); //代码转义
    $status_reg=mysqli_query($con,"select * from sc_users where user_login='$user'");
    $status=mysqli_fetch_array($status_reg);
    $timer=$status['jytime'];
    if($date>$timer&&$status['jinyan']==0){
        mysqli_query($con,"UPDATE sc_users SET jinyan='1' where zid='$zid'");
    }elseif($status['jinyan'] !=1){
        $result = array('code'=>-1, 'msg'=>'你已被禁言！解除时间：'.$timer);
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
    
    if($status){ 
        $zhu="INSERT INTO sc_text (zid,user,content,ip,time) VALUES ('$zid','$user','$content','$ip','$date')";
        mysqli_query($con,$zhu);
        $result = array('code'=>0, 'msg'=>'发送成功');
	}else{ 
        $result = array('code'=>-1, 'msg'=>'请先登录');
    }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
default:
    $result = array('code'=>-4, 'msg'=>'json返回失败');
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
};?>