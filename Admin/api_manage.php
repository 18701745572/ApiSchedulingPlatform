<?php
include '../includes/comment.php';
session_start();

// 检查管理员权限
if(!isset($_SESSION['admin_id'])) {
    echo "<script>alert('请先登录!');window.location.href='../login.php';</script>";
    exit;
}

// 处理API添加
if(isset($_POST['add_api'])) {
    $name = $_POST['name'];
    $channel = $_POST['channel'];
    $neirong = $_POST['neirong'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO sc_inter (zid, name, channel, neirong, status) VALUES ('1', '$name', '$channel', '$neirong', '$status')";
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('API添加成功!');window.location.reload();</script>";
    } else {
        echo "<script>alert('API添加失败!');history.go(-1);</script>";
    }
}

// 处理API编辑
if(isset($_POST['edit_api'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $channel = $_POST['channel'];
    $neirong = $_POST['neirong'];
    $status = $_POST['status'];
    
    $sql = "UPDATE sc_inter SET name='$name', channel='$channel', neirong='$neirong', status='$status' WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('API更新成功!');window.location.reload();</script>";
    } else {
        echo "<script>alert('API更新失败!');history.go(-1);</script>";
    }
}

// 处理API删除
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM sc_inter WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('API删除成功!');window.location.reload();</script>";
    } else {
        echo "<script>alert('API删除失败!');history.go(-1);</script>";
    }
}

// 获取API列表
$sql = "SELECT * FROM sc_inter ORDER BY id DESC";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>API管理 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css">
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    API管理
                    <button class="layui-btn layui-btn-sm" style="float:right;" onclick="showAddForm()">添加API</button>
                </div>
                <div class="layui-card-body">
                    <table class="layui-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>渠道</th>
                                <th>说明</th>
                                <th>状态</th>
                                <th>调用次数</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['channel']; ?></td>
                                <td><?php echo $row['neirong']; ?></td>
                                <td><?php echo $row['status'] == 1 ? '启用' : '禁用'; ?></td>
                                <td><?php echo $row['counter']; ?></td>
                                <td>
                                    <button class="layui-btn layui-btn-xs" onclick="showEditForm(<?php echo $row['id']; ?>)">编辑</button>
                                    <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteApi(<?php echo $row['id']; ?>)">删除</button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 添加API表单 -->
<div id="addForm" style="display:none; padding: 20px;">
    <form method="post">
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
            <label class="layui-form-label">说明</label>
            <div class="layui-input-block">
                <textarea name="neirong" required lay-verify="required" placeholder="请输入API说明" class="layui-textarea"></textarea>
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
                <button class="layui-btn" lay-submit lay-filter="formDemo" name="add_api">添加</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<!-- 编辑API表单 -->
<div id="editForm" style="display:none; padding: 20px;">
    <form method="post">
        <input type="hidden" name="id" id="edit_id">
        <div class="layui-form-item">
            <label class="layui-form-label">API名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" id="edit_name" required lay-verify="required" placeholder="请输入API名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">调用渠道</label>
            <div class="layui-input-block">
                <input type="text" name="channel" id="edit_channel" required lay-verify="required" placeholder="请输入调用渠道" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">说明</label>
            <div class="layui-input-block">
                <textarea name="neirong" id="edit_neirong" required lay-verify="required" placeholder="请输入API说明" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <select name="status" id="edit_status">
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo" name="edit_api">保存</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script src="../assets/layuiadmin/layui/layui.js"></script>
<script>
layui.use(['layer', 'form'], function(){
    var layer = layui.layer;
    var form = layui.form;
});

// 显示添加表单
function showAddForm() {
    layer.open({
        type: 1,
        title: '添加API',
        area: ['500px', '400px'],
        content: $('#addForm')
    });
}

// 显示编辑表单
function showEditForm(id) {
    // 获取API信息
    $.get('get_api.php?id=' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_channel').val(data.channel);
        $('#edit_neirong').val(data.neirong);
        $('#edit_status').val(data.status);
        
        layer.open({
            type: 1,
            title: '编辑API',
            area: ['500px', '400px'],
            content: $('#editForm')
        });
    });
}

// 删除API
function deleteApi(id) {
    layer.confirm('确定要删除这个API吗？', {
        btn: ['确定','取消']
    }, function(){
        window.location.href = '?delete=' + id;
    });
}
</script>
</body>
</html> 