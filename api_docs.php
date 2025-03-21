<?php
include './includes/comment.php';

// 获取API列表
$sql = "SELECT * FROM sc_inter WHERE status=1 ORDER BY id DESC";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>API文档 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="./assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="./assets/layuiadmin/style/admin.css">
    <style>
        .api-item {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e6e6e6;
            border-radius: 4px;
        }
        .api-item h3 {
            margin-top: 0;
            color: #009688;
        }
        .api-item pre {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 4px;
        }
        .api-item .method {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            color: #fff;
            font-size: 12px;
            margin-right: 10px;
        }
        .api-item .method.get {
            background-color: #009688;
        }
        .api-item .method.post {
            background-color: #1E9FFF;
        }
        .api-item .method.put {
            background-color: #FFB800;
        }
        .api-item .method.delete {
            background-color: #FF5722;
        }
        .api-item .params {
            margin: 15px 0;
        }
        .api-item .params table {
            width: 100%;
            border-collapse: collapse;
        }
        .api-item .params th,
        .api-item .params td {
            padding: 8px;
            border: 1px solid #e6e6e6;
            text-align: left;
        }
        .api-item .params th {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">API接口文档</div>
                <div class="layui-card-body">
                    <div class="layui-text">
                        <h2>接口说明</h2>
                        <p>本文档提供了所有可用的API接口信息。使用这些接口时，请注意以下几点：</p>
                        <ul>
                            <li>所有接口都需要进行身份验证</li>
                            <li>接口调用频率限制为每分钟100次</li>
                            <li>返回数据格式统一为JSON</li>
                            <li>所有时间戳均为Unix时间戳</li>
                        </ul>
                        
                        <h2>接口列表</h2>
                        <?php while($row = mysqli_fetch_array($result)) { ?>
                        <div class="api-item">
                            <h3><?php echo $row['name']; ?></h3>
                            <p><?php echo $row['neirong']; ?></p>
                            
                            <div class="method get">GET</div>
                            <div class="url">
                                <pre><?php echo $row['channel']; ?></pre>
                            </div>
                            
                            <div class="params">
                                <h4>请求参数</h4>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>参数名</th>
                                            <th>类型</th>
                                            <th>必填</th>
                                            <th>说明</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM sc_errturn WHERE zid='".$row['id']."'";
                                        $params = mysqli_query($con, $sql);
                                        while($param = mysqli_fetch_array($params)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $param['name']; ?></td>
                                            <td><?php echo $param['type']; ?></td>
                                            <td><?php echo $param['errturn'] == 1 ? '是' : '否'; ?></td>
                                            <td><?php echo $param['explaina']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="response">
                                <h4>返回示例</h4>
                                <pre><?php echo $row['return_case']; ?></pre>
                            </div>
                            
                            <div class="code">
                                <h4>调用示例</h4>
                                <pre><?php echo $row['code_case']; ?></pre>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./assets/layuiadmin/layui/layui.js"></script>
<script>
layui.use(['layer'], function(){
    var layer = layui.layer;
});
</script>
</body>
</html> 