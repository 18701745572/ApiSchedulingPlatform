<?php
include '../../includes/Config.php';
include '../../API/inc.php';

header('Access-Control-Allow-Origin:*');
header('Content-type:application/json; charset=utf-8');
error_reporting(0);
!empty($_GET['url']) ? $url = $_GET['url'] : exit(json_encode([
    'code'=>-1,
    "msg"=>"请输入网址"
],JSON_UNESCAPED_UNICODE));
$json = jsonp_decode(Curl_GET("https://cgi.urlsec.qq.com/index.php?m=check&a=check&callback=jQuery11.306943167371763181_15671.3944271&url={$url}&_=".msectime()));
if ($json->reCode!==0){
    $arr=[
        "code"=>-1,
        "msg"=>$json->data,
    ];
}else{
    $type = $json->data->results->whitetype;
    $urls = $json->data->results->url;
    if ($type==1 || $type==3){
        $arr=[
            "code"=>1,
            "msg"=>"检测成功",
            "url"=>$urls,
            "type"=>"正常"
        ];
    }else{
        $arr=[
            "code"=>1,
            "msg"=>"检测成功",
            "url"=>$urls,
            "type"=>"拦截"
        ];
    }
}
exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
/**
 * @return string
 * Curl GET
 */
function Curl_GET($url){
    $ch = curl_init();     // Curl 初始化
    $header = [
        'X-FORWARDED-FOR:218.91.92.84',
        'CLIENT-IP:218.91.92.84',
        'Cookie: pgv_pvi=9897416704; RK=WI7w5+CMZn; ptcz=e383433090496e1f60381fd68733196426868ba1876249a6736bcc4a3eb8ec72; pgv_pvid=455855220; cid=89410138-a33a-4ea9-98f2-4436da89d67d; _tfpdata=yBRknXvS8CfrED0zD85NZfxCPzT5SW8KEY03rIziZmu9ogk9y%2B5%2FU4QrJBbfqfuVqr%2F6vw8nSWfqHR3fu2Jc0TPvszwmrMwXEdN%2B8bKKfHwNCcL%2F2%2Fbhmiu%2B%2F4IgK1DX'
    ];
    curl_setopt($ch, CURLOPT_URL, $url);              // 设置 Curl 目标
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      // Curl 请求有返回的值
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);     // 设置抓取超时时间
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);        // 跟踪重定向
    curl_setopt($ch, CURLOPT_ENCODING, "");    // 设置编码
    curl_setopt($ch, CURLOPT_REFERER, $url);   // 伪造来源网址
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  //伪造IP
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");   // 伪造ua
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); // 取消gzip压缩
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $content = curl_exec($ch);
    curl_close($ch);    // 结束 Curl
    return $content;    // 函数返回内容
}

/**
 * 返回当前毫秒
 */
function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
}

/**
 * @param $jsonp
 * @智云官方发布地址
 * @zhiyunzz.simplesite.com
 * jsonp转对象
 */
function jsonp_decode($jsonp, $assoc = false)
{
    $jsonp = trim($jsonp);
    if(isset($jsonp[0]) && $jsonp[0] !== '[' && $jsonp[0] !== '{') {
        $begin = strpos($jsonp, '(');
        if(false !== $begin)
        {
            $end = strrpos($jsonp, ')');
            if(false !== $end)
            {
                $jsonp = substr($jsonp, $begin + 1, $end - $begin - 1);
            }
        }
    }
    return json_decode($jsonp, $assoc);
}

?>
