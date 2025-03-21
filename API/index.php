<?php 
//接口弹窗页面

include '../Comment.php';
include '../includes/Config.php';
$id = $_GET['zid'];
$channel = $_GET['channel'];
$coun = mysqli_query($con,"SELECT * FROM sc_content WHERE zid='$id'");
$count = mysqli_fetch_array($coun);
$status_qy = mysqli_query($con,"select * from sc_inter where channel='$channel'");
$status = mysqli_fetch_array($status_qy);
if($status['status']!='1'){
	exit('接口未开放,请联系管理员 QQ:'.$conf_config['kfqq']);
}
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $count['content_title'] ?></title>
    <meta name="keywords" content="<?php echo $conf_config['keywords']; ?>"/>
    <meta name="description" content="<?php echo $conf_config['description']; ?>">    
    <link rel="stylesheet" href="../assets/css/layer.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/layui/2.5.4/layui.all.js"></script>
    <style>.url{word-break:break-all;cursor:pointer;margin-left:5px;color:#777;border:none;border-radius:0;border-bottom:2px solid #5FB878;}.simpleTable{line-height:20px;padding-bottom:16px;}.linep{font-size:14px;font-weight:700;color:#555;padding-left:14px;height:16px;line-height:16px;margin-bottom:18px;position:relative;margin-top:15px;}.linep:before{content:'';width:4px;height:16px;background:#00aeff;border-radius:2px;position:absolute;left:0;top:0;}::-webkit-scrollbar{width:9px;height:9px}::-webkit-scrollbar-track-piece{background-color:#ebebeb;-webkit-border-radius:4px}::-webkit-scrollbar-thumb:vertical{height:32px;background-color:#ccc;-webkit-border-radius:4px}::-webkit-scrollbar-thumb:horizontal{width:32px;background-color:#ccc;-webkit-border-radius:4px}</style>
    <?echo $ver_config['css'];?>
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend><?php echo $count['content_title'] ?></legend>
        </fieldset>
        <blockquote class="layui-elem-quote"><?php echo $count['content'] ?></blockquote>
    </div>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title" style="text-align: center!important;">
            <li class="layui-this">API文档</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-black">接口地址：</span>
                    <span class="url" data-clipboard-text="<?php echo $count['api_url'] ?>"><?php echo $count['api_url'] ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-green">返回格式：</span>
                    <span class="url" data-clipboard-text="<?php echo $count['return_format'] ?>"><?php echo $count['return_format'] ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge">请求方式：</span>
                    <span class="url" data-clipboard-text="<?php echo $count['http_mode'] ?>"><?php echo $count['http_mode'] ?></span>
                </p>
                <p class="simpleTable">
                    <span class="layui-badge layui-bg-blue">请求示例：</span>
                    <span class="url" data-clipboard-text="<?php echo $count['http_case'] ?>"><?php echo $count['http_case'] ?></span>
                </p>
                  <p class="linep">请求参数说明：</p>
                <table class="layui-table" lay-size="sm">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>类型</th>
                        <th>说明</th>
                    </tr>
                    </thead>
                <tbody>
                    <?php
                        $a = mysqli_query($con,"select * from `sc_errturn` where errturn='1' and zid='$id' order by id");
                        $b = mysqli_fetch_array($a);
                        if($b['name']!=''){
                            $result = mysqli_query($con,"select * from `sc_errturn` where errturn='1' and zid='$id' order by id");
                            while($row=mysqli_fetch_array($result)){
                                echo '<tr>';
                                echo '<td>'.$row['name'].'</td>';
                                echo '<td>'.$row['type'].'</td>';
                                echo '<td>'.$row['explaina'].'</td>';
                                echo '</tr>';
                            };
                        }else{
                            echo '<tr><td>无</td><td>无</td><td>无</td></tr>';
                        }
                    ?>
                </table>
              <p class="linep">返回示例：</p>
                <pre class="layui-code"><?php echo $count['return_case'] ?></pre>
                <p class="linep">错误码格式说明：</p>
                <table class="layui-table" lay-size="sm">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>类型</th>
                        <th>说明</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $a = mysqli_query($con,"select * from `sc_errturn` where errturn='0' and zid='$id' order by id");
                            $b = mysqli_fetch_array($a);
                            if($b['name']!=''){
                                $result = mysqli_query($con,"select * from `sc_errturn` where errturn='0' and zid='$id' order by id");
                                while($row=mysqli_fetch_array($result)){
                                    echo '<tr>';
                                    echo '<td>'.$row['name'].'</td>';
                                    echo '<td>'.$row['type'].'</td>';
                                    echo '<td>'.$row['explaina'].'</td>';
                                    echo '</tr>';
                                };
                            }else{
                                echo '<tr><td>无</td><td>无</td><td>无</td></tr>';
                            }
                        ?>
                    </table>
                <p class="linep">代码示例：</p>
                <pre class="layui-code"><?php if($count['return_format']=='JSON'){ ?>&lt?php<br>$ch = curl_init();<br>curl_setopt_array($ch, array(<br>  CURLOPT_URL => "<?php echo $count['http_case'] ?>",<br>  CURLOPT_RETURNTRANSFER => true,<br>  CURLOPT_SSL_VERIFYPEER => false,<br>  CURLOPT_MAXREDIRS => 10,<br>  CURLOPT_TIMEOUT => 30,<br>  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,<br>  CURLOPT_HTTPHEADER => array(<br>    "Content-Type: application/x-www-form-urlencoded",<br>  ),<br>));<br>$url = curl_exec($ch);<br>$cx = json_decode($url,true);<br>curl_close($ch);<br>echo $cx['参数名'];<br>?&gt<?php }else{echo '本接口不返回JSON';}?></per>
            </div>
        </div>
    </div>
</div>
<script src="../assets/css/clipboard.min.js"></script>
<script>
    layui.use('code', function(){ //加载code模块
        layui.code(); //引用code方法
    });
    var clipboard = new ClipboardJS('.url');
    clipboard.on('success', function(e) {
        layer.msg('复制成功!');
    });
    clipboard.on('error', function(e) {
        layer.msg('复制成功!');
    });
</script>
<script type="text/javascript" src="../assets/css/main.js"></script>
</body>
</html>