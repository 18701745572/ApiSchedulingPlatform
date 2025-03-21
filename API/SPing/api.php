<?php
include '../../includes/Config.php';
include '../../API/inc.php';

header('Access-Control-Allow-Origin:*');
header('Content-type:application/json; charset=utf-8');
error_reporting(0);
function randIp()
{
    return mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
}
function Curl_POST($url,$post_data){
    $header=[
        'X-FORWARDED-FOR:'.randIp(),
        'CLIENT-IP:'.randIp()
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");   // 伪造ua
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
!empty($_GET['host']) ? $host=$_GET['host'] : exit(json_encode([
    "code"=>-1,
    "msg"=>"请输入网址或者IP"
],JSON_UNESCAPED_UNICODE));
$post_data = [
    "node"=>3,
    "host"=>$host
];
$array =json_decode(Curl_POST("https://www.wepcc.com/check-ping.html",$post_data));
function GetIP($node,$host){
    $post_data = [
        "node"=>$node,
        "host"=>$host
    ];
    $array =json_decode(Curl_POST("https://www.wepcc.com/check-ping.html",$post_data));
    if ($array->code==0){
        return [
            "code"=>-1,
            "msg"=>"解析失败,请检查输入是否正确。"
        ];
    } else {
        return [
            "time"=>$array->data->time,
            "ttl"=>$array->data->ttl
        ];
    }
}
 
if ($array->code==0){
    $data = [
        "code"=>-1,
        "msg"=>"解析失败,请检查输入是否正确。"
    ];
} else {
    $data=[
        "code"=>1,
        "msg"=>"获取成功！",
        "ip"=>$array->data->ip,
        "ipaddress"=>$array->data->ipaddress,
        "data"=>[
            "telecom"=>[
                "time"=>$array->data->time,
                "ttl"=>$array->data->ttl
            ],
            "Unicom"=>GetIP(1,$host),
            "move"=>GetIP(8,$host),
            "Hong Kong"=>GetIP(7,$host),
        ]
    ];
}
exit(json_encode($data,JSON_UNESCAPED_UNICODE));