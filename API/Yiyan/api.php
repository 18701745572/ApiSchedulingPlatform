<?php
include '../../includes/Config.php';
include '../../API/inc.php';

// 存储数据的文件
$filename = 'data.dat';        
 
// 指定页面编码
if(!file_exists($filename)) {
    die($filename . ' 数据文件不存在');
}

if($_GET['type'] === 'json'){
header('Content-type:text/json');
// 读取整个数据文件
$data = file_get_contents($filename);
// 按换行符分割成数组
$data = explode(PHP_EOL, $data);
// 随机获取一行索引
$result = $data[array_rand($data)];
// 去除多余的换行符（保险起见）
$result = str_replace(array("\r","\n","\r\n"), '', $result);
//echo $result;
$content = array('code'=>1,'text'=>$result);
echo json_encode($content, JSON_UNESCAPED_UNICODE);
}else {
header('Content-type: text/html; charset=utf-8');
$data = array();
// 打开文档
$fh = fopen($filename, 'r');
// 逐行读取并存入数组中
while (!feof($fh)) {
    $data[] = fgets($fh);
}
// 关闭文档
fclose($fh);
// 随机获取一行索引
$result = $data[array_rand($data)];
echo $result;
}