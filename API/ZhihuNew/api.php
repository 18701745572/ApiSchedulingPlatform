<?php
include '../../includes/Config.php';
include '../../API/inc.php';

 header('Content-type:application/json; charset=utf-8');
 $size = readfile('http://news-at.zhihu.com/api/2/news/latest');
 echo $size;
?>