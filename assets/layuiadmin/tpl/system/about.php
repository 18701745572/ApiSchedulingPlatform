<?php 
include '../../../../Comment.php';
echo $ver_config['css'];
?>
<div class="layui-card-header">版本信息</div>
<div class="layui-card-body layui-text layadmin-about">
<script type="text/html" template>
<p>当前版本：<?php echo $ver_config['versions']; ?></p>
<p>基于框架：<?php echo $ver_config['LayuiVer']; ?></p>
</script>
<div class="layui-btn-container">
<a href="https://www.tzyx.site" target="_blank" class="layui-btn layui-btn-danger">台州驿宣网络</a>
</div>
</div>

<div class="layui-card-header">关于本站</div>
<div class="layui-card-body layui-text layadmin-about">
  
<blockquote class="layui-elem-quote" style="border: none;">
<?php echo $conf_config['site']; ?>，免费提供API接口服务,本站不收取任何费用,该API接口来源于网上收集如有侵权联系站长删除。
</blockquote>
</div>