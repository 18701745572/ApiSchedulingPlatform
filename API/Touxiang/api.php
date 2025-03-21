<?php
include '../../includes/Config.php';
include '../../API/inc.php';

if (($_GET['api'] === 'api-acg')){
    header('Content-type:text/json');
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => "https://api.muxiaoguo.cn/api/sjtx?method=pc",
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
    $a=json_decode($url,true);
    curl_close($ch);
    $url = $a['data']['imgurl']; //获取接口的图片链接
    print_r(json_encode($a, JSON_UNESCAPED_UNICODE));
    if($url=="") return false; //如果图片链接为空则不继续允行
    if($filename=="") {  
        $ext=strrchr($url,"."); //获取图片后缀
        if($ext!=".gif" && $ext!=".jpg" && $ext!=".png") return false; //如果不是图片则不继续运行
        $filename = substr($url, strrpos($url, '/')+1); //获取图片名
    }  
    ob_start();  //输出缓冲区
    readfile($url);  //读取文件，并写入到输出缓冲
    $img = ob_get_contents();  //返回输出缓冲区的内容
    ob_end_clean();  //清空缓冲区并关闭输出缓冲
    $dir_path = __DIR__ . '/images/';
    $fp2=@fopen($dir_path. '/'.$filename, "a");  //打开文件 a:写入方式打开
    $fp3=fwrite($fp2,$img);  //将内容写入文件夹中
    fclose($fp2); //关闭文件夹
}elseif (($_GET['api'] === 'tx-picture')){
    $localurl="images/*.{gif,jpg,png}"; //这将得到一个文件夹中的所有gif，jpg和png图片的数组
    $img_array=glob($localurl,GLOB_BRACE);
    $img=array_rand($img_array); //从数组中选择一个随机图片 
    $imgurl=$img_array[$img];
    $imgurl='https://'.$_SERVER['SERVER_NAME'].'/API/Touxiang/'.$imgurl;
    header("location:$imgurl"); //在页面显示图片地址
}
?>