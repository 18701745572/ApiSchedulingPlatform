<?php
include '../../includes/Config.php';
include '../../API/inc.php';

if(!$_GET['type']){
    $str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx='.rand(0,6).'&n=1'); //读取必应api，获得相应数据
    $str = json_decode($str,true);
    $imgurl = 'http://cn.bing.com'.$str['images'][0]['url'];    //获取图片url
    header("Location: $imgurl");    //header跳转
}elseif ($_GET['type'] === 'json') {
    header('Content-type:text/json');
    $str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx='.rand(0,6).'&n=1'); //读取必应api，获得相应数据
    $str = json_decode($str,true);
    $imgurl = 'http://cn.bing.com'.$str['images'][0]['url']; 
    $content = array('code'=>200,'imgurl'=>$imgurl,'startdate'=>$str['images'][0]['startdate'],'enddate'=>$str['images'][0]['enddate']);
    echo json_encode($content, JSON_UNESCAPED_UNICODE);
}