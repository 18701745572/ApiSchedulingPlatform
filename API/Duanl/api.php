<?php
include '../../includes/Config.php';
include '../../API/inc.php';

header('Content-type:text/json');
$url = $_GET['url'];
if(!$url){
    $cxurl = array('code'=>201,'url'=>'请输入您的长网址');
    exit(json_encode($cxurl, JSON_UNESCAPED_UNICODE));
}
$number = $_GET['domain'];
$ch = curl_init();
curl_setopt_array($ch, array(
  CURLOPT_URL => "http://api.suowo.cn/api.htm?format=json&url=$url&key=62133fb4aee1e80f2cb41916@1e1aa576fee64eb90e8279630979c8ee&expireDate=2022-12-31&domain=$number",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
  ),
));
$churl = curl_exec($ch);
curl_close($ch);
$cx = json_decode($churl,true);
$dlurl = $cx['url'];
$cxurl = array('code'=>200,'url'=>$dlurl);
echo json_encode($cxurl, JSON_UNESCAPED_UNICODE);
?>