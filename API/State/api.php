<?php
include '../../includes/Config.php';
include '../../API/inc.php';

if ($_GET['qq']) {
$qq = $_GET['qq'];
$data = file_get_contents("http://webpresence.qq.com/getonline?type=1&$qq:");
$data || $data = strlen(file_get_contents("http://wpa.qq.com/pa?p=2:$qq:45"));
if(!$data) { return 0; 
} 
switch((string)$data){
  case 'online[0]=0;': 
  exit('{"code":"-1","msg":"电脑离线"}');
  return;
  case 'online[0]=1;': 
  exit('{"code":"1","msg":"电脑在线"}') ;
  return; 
  }
}
echo '{"code":-1,"msg":"QQ不能为空!"}';
return 3;
?>