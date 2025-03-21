<?php
include '../includes/comment.php';
session_start();

// 检查管理员权限
if(!isset($_SESSION['admin_id'])) {
    echo "<script>alert('请先登录!');window.location.href='../login.php';</script>";
    exit;
}

// 获取时间范围
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// 获取API调用统计
$sql = "SELECT i.name, COUNT(l.id) as total, COUNT(DISTINCT l.user_id) as user_count 
        FROM sc_inter i 
        LEFT JOIN sc_logs l ON i.id = l.api_id 
        WHERE l.addtime BETWEEN '$start_date' AND '$end_date 23:59:59'
        GROUP BY i.id 
        ORDER BY total DESC";
$result = mysqli_query($con, $sql);

// 获取每日调用统计
$sql = "SELECT DATE(addtime) as date, COUNT(*) as total 
        FROM sc_logs 
        WHERE addtime BETWEEN '$start_date' AND '$end_date 23:59:59'
        GROUP BY DATE(addtime)
        ORDER BY date ASC";
$daily_result = mysqli_query($con, $sql);

// 获取用户调用统计
$sql = "SELECT u.username, COUNT(l.id) as total 
        FROM sc_users u 
        LEFT JOIN sc_logs l ON u.id = l.user_id 
        WHERE l.addtime BETWEEN '$start_date' AND '$end_date 23:59:59'
        GROUP BY u.id 
        ORDER BY total DESC 
        LIMIT 10";
$user_result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>API调用统计 - <?php echo $conf_config['site']; ?></title>
    <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css">
    <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css">
    <script src="../assets/layuiadmin/layui/layui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">API调用统计</div>
                <div class="layui-card-body">
                    <!-- 时间范围选择 -->
                    <form class="layui-form" method="get">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">开始日期</label>
                                <div class="layui-input-inline">
                                    <input type="date" name="start_date" value="<?php echo $start_date; ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">结束日期</label>
                                <div class="layui-input-inline">
                                    <input type="date" name="end_date" value="<?php echo $end_date; ?>" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button class="layui-btn" lay-submit>查询</button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- API调用统计表格 -->
                    <table class="layui-table">
                        <thead>
                            <tr>
                                <th>API名称</th>
                                <th>调用次数</th>
                                <th>调用用户数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['total']; ?></td>
                                <td><?php echo $row['user_count']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <!-- 每日调用统计图表 -->
                    <div id="dailyChart" style="width:100%;height:400px;"></div>
                    
                    <!-- 用户调用排行 -->
                    <div class="layui-card">
                        <div class="layui-card-header">用户调用排行</div>
                        <div class="layui-card-body">
                            <table class="layui-table">
                                <thead>
                                    <tr>
                                        <th>用户名</th>
                                        <th>调用次数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_array($user_result)) { ?>
                                    <tr>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['total']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
layui.use(['form'], function(){
    var form = layui.form;
});

// 初始化每日调用统计图表
var dailyChart = echarts.init(document.getElementById('dailyChart'));
var dailyData = {
    dates: [],
    totals: []
};
<?php 
mysqli_data_seek($daily_result, 0);
while($row = mysqli_fetch_array($daily_result)) { 
?>
dailyData.dates.push('<?php echo $row['date']; ?>');
dailyData.totals.push(<?php echo $row['total']; ?>);
<?php } ?>

var option = {
    title: {
        text: '每日API调用统计'
    },
    tooltip: {
        trigger: 'axis'
    },
    xAxis: {
        type: 'category',
        data: dailyData.dates
    },
    yAxis: {
        type: 'value'
    },
    series: [{
        data: dailyData.totals,
        type: 'line',
        smooth: true
    }]
};

dailyChart.setOption(option);

// 响应式调整
window.addEventListener('resize', function() {
    dailyChart.resize();
});
</script>
</body>
</html> 