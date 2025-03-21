<?php
include '../../includes/Config.php';
include '../../API/inc.php';

$url = $_GET["url"];
$str = file_get_contents('https://api.qqsuu.cn/api/icp?url='.$url);
$data = json_decode($str,true);
$a = $data['name']; //主办名称
$b = $data['nature']; //主办类型
$c = $data['icp']; //备案号码
$d = $data['sitename']; //网站名称
$e = $data['siteindex']; //网站首页
$f = $data['time']; //审核时间
$g = $data['img']; //网站查询
if($url!=''){
    header('Content-type:text/json');
    $content = array('code'=>1,'msg'=>'查询成功','data'=>['name'=>$a,'siteindex'=>$e,'nature'=>$b,'icp'=>$c,'sitename'=>$d,'info'=>$g,'time'=>$f]);
    echo json_encode($content, JSON_UNESCAPED_UNICODE);
}else{
    header('Content-type:text/json');
    $content = array('code'=>-1,'tips'=>'未输入要查询的域名!');
    echo json_encode($content, JSON_UNESCAPED_UNICODE);
}
?>