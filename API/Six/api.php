<?php
include '../../includes/Config.php';
include '../../API/inc.php';

header('Content-type:text/json');
if($_GET['type'] === 'json') {
$ch = curl_init();
curl_setopt_array($ch, array(
  CURLOPT_URL => "https://www.tzyx.site/cdn/api/json/test.json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
  ),
));
$url = curl_exec($ch);
curl_close($ch);
print_r($url);
}else {
    $content = array('code'=>-1,'imgurl'=>'请求数据失败！');
    print_r($$content);
}
?>