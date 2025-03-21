<?php
include '../includes/comment.php';
session_start();

// 处理API发布
if(isset($_POST['publish_api'])) {
    $name = $_POST['name'];
    $channel = $_POST['channel'];
    $neirong = $_POST['neirong'];
    $status = $_POST['status'];
    $content_title = $_POST['content_title'];
    $api_url = $_POST['api_url'];
    $return_format = $_POST['return_format'];
    $http_mode = $_POST['http_mode'];
    $http_case = $_POST['http_case'];
    $return_case = $_POST['return_case'];
    $code_case = $_POST['code_case'];
    
    // 获取新的zid
    $coun = mysqli_query($con,"SELECT zid FROM sc_inter ORDER BY zid DESC LIMIT 1");
    $count = mysqli_fetch_array($coun);
    $new_zid = intval($count['zid']) + 1;
    
    // 插入到sc_inter表
    $sql1 = "INSERT INTO sc_inter (zid, name, channel, neirong, status) VALUES ('$new_zid', '$name', '$channel', '$neirong', '$status')";
    if(mysqli_query($con, $sql1)) {
        // 插入到sc_content表
        $sql2 = "INSERT INTO sc_content (zid, content_title, content, api_url, return_format, http_mode, http_case, return_case, code_case, ip) 
                 VALUES ('$new_zid', '$content_title', '$neirong', '$api_url', '$return_format', '$http_mode', '$http_case', '$return_case', '$code_case', '$ip')";
        if(mysqli_query($con, $sql2)) {
            echo "<script>alert('API发布成功!');window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('API内容添加失败!');history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('API基本信息添加失败!');history.go(-1);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>发布API - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css">
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">发布新API</div>
                <div class="layui-card-body">
                    <form method="post" class="layui-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label">API名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" required lay-verify="required" placeholder="请输入API名称" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">调用渠道</label>
                            <div class="layui-input-block">
                                <input type="text" name="channel" required lay-verify="required" placeholder="请输入调用渠道" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">接口说明</label>
                            <div class="layui-input-block">
                                <textarea name="neirong" required lay-verify="required" placeholder="请输入接口说明" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">接口标题</label>
                            <div class="layui-input-block">
                                <input type="text" name="content_title" required lay-verify="required" placeholder="请输入接口标题" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">接口地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="api_url" required lay-verify="required" placeholder="请输入接口地址" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">返回格式</label>
                            <div class="layui-input-block">
                                <input type="text" name="return_format" required lay-verify="required" placeholder="请输入返回格式(如JSON)" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">请求方式</label>
                            <div class="layui-input-block">
                                <input type="text" name="http_mode" required lay-verify="required" placeholder="请输入请求方式(如GET)" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">请求示例</label>
                            <div class="layui-input-block">
                                <textarea name="http_case" required lay-verify="required" placeholder="请输入请求示例" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">返回示例</label>
                            <div class="layui-input-block">
                                <textarea name="return_case" required lay-verify="required" placeholder="请输入返回示例" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">代码示例</label>
                            <div class="layui-input-block">
                                <textarea name="code_case" required lay-verify="required" placeholder="请输入代码示例" class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                <select name="status">
                                    <option value="1">启用</option>
                                    <option value="0">禁用</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="formDemo" name="publish_api">发布</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                <a href="../index.php" class="layui-btn layui-btn-primary">返回首页</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/layuiadmin/layui/layui.js"></script>
<script>
layui.use(['form'], function(){
    var form = layui.form;
});
</script>
</body>
</html> 