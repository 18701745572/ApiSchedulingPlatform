<?php
include '../../includes/Config.php';
include '../../API/inc.php';

/*
Plugin Name: XY-百度收录量
Description: XY-根据域名返回百度收录量
*/
header('Content-type:text/json');
$domain = (isset($_GET['domain']))?$_GET['domain']:$_POST['domain'];
if(empty($domain)){
    $result=array(
    'code'=>-1,
    'domain'=>'查询域名不能为空',
    );
    print_r(json_encode($result,JSON_UNESCAPED_UNICODE));
    return;
}

$count = baiduSL ($domain);

if(!isset($count))  showjson(array('code'=>200502,'msg'=>'查询失败，请重试！'));
if(!$count)  $count = 0;
$result=array(
    'code'=>1,
    'domain'=>$domain,
    'data'=>$count
);
print_r(json_encode($result));

unset($domain,$result,$ch);
function baiduSL ($domain) {
     $baidu='https://www.baidu.com/s?ie=utf-8&tn=baidu&wd=site%3A'.$domain; 
     $bdsite=BD_curl($baidu); 
     $bdsite = str_replace(array("\r\n", "\r", "\n", '    '), '', $bdsite); 
     if (!$count) preg_match('/找到相关结果数约(.*?)个/i',$bdsite,$count);
     $baiduSL=strip_tags($count[1]); 
     unset($count);
     return $baiduSL;
}
function BD_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
?>