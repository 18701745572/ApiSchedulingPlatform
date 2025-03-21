<?php 
include '../includes/comment.php';
include '../Comment.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>接口页面</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="css/main-mini.css" media="all">
  <link rel="stylesheet" href="lib/layui-v2.5.5/css/layui.css" media="all">
  <?echo $ver_config['css'];?>
</head>
<body>
    <div class="layui-col-md12" style="padding: 0 20px;">
      <form id="tb">
      <div class="tile">
        <div class="row">
          <div class="col-lg-6">
			<div class="form-group">
              <label for="title">接口标题</label>
              <div class="layui-form" lay-filter="myDiv">
                <select name="intername" id="intername" lay-filter="mySelect">
                    <option value="0">请选择已有接口</option>
                    <?php
                        $query=mysqli_query($con,"SELECT * from sc_inter WHERE id");
                        while($res=mysqli_fetch_array($query)){
	                        echo '<option value="'.$res['zid'].'">'.$res['zid'].'. '.$res['name'].'</option>';
                        }
                      ?>
                </select>
            </div>
            </div>
            <div class="form-group">
              <label for="desc">简介说明</label>
              <input class="form-control" id="desc" type="text" aria-describedby="desc" name="desc" value="" placeholder="请选择已有接口" disabled>
            </div>      
            <div class="form-group">
              <label for="address">接口地址</label>
              <input class="form-control" id="address" type="text" aria-describedby="address" name="address" value="" placeholder="请选择已有接口" disabled>
            </div>    
            <div class="form-group">
              <label for="format">返回格式</label>
              <input class="form-control" id="format" type="text" aria-describedby="format" name="format" value="" placeholder="JSON">
            </div>   
            <div class="form-group">
              <label for="ask">请求方式</label>
              <input class="form-control" id="ask" type="text" aria-describedby="ask" name="ask" value="" placeholder="GET">
            </div>               
            <div class="form-group">
              <label for="askExample">请求示例</label>
              <input class="form-control" id="askExample" type="text" aria-describedby="askExample" name="askExample" value="" placeholder="https://<?= $_SERVER['HTTP_HOST'] ?>/API/BaiduSL/api.php?domain=qq.com">
            </div>                 
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="returnExample">返回示例</label>
              <textarea class="form-control" id="returnExample" name="returnExample" rows="9" placeholder='{"code":1,"domain":"qq.com","data":"100,000,000"}'></textarea>
            </div>
            <div class="form-group">
              <label for="codeExample">代码示例</label>
              <textarea class="form-control" id="codeExample" name="codeExample" rows="9" placeholder='https://v1.21lhz.cn/API/BaiduSL/api.php?domain=qq.com'></textarea>
            </div>   
          </div>
      </div>
      <div class="tile-footer">
        <p class="btn btn-primary" id="Aserve" style="width:100px;display:none">保存</p>
        <p class="btn btn-primary" id="Bserve" style="width:100px;">添加</p>
      </div> 
    </div>
     </form>
  </div>

<?php echo $ver_config['footer']?>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //下拉框渲染
    layui.use('form', function(){
        var form = layui.form; 
        form.render();
    }); 
    
	$('#Bserve').click(function(){
    var intername = $("#intername").val();
    var desc = $("#desc").val();
    var address = $("#address").val();
    var format = $("#format").val();
    var ask = $("#ask").val();
    var askExample = $("#askExample").val();
    var returnExample = $("#returnExample").val();
    var codeExample = $("#codeExample").val();
		$.ajax({
		  url:'ajax.php?interadd',
		  type:"POST",
		  timeout:"3000",
		  data:{'intername':intername,'desc':desc,'address':address,'format':format,'ask':ask,'askExample':askExample,'returnExample':returnExample,'codeExample':codeExample},
	      dataType : 'json',
		  success:function(data){
		    if(data.code=='0'){
		        layer.alert(data.msg, {yes:function(){setTimeout(function(){window.location.reload();},300);}, offset:'150px'});
		        return;
		    }
		    layer.msg(data.msg, {offset:'150px'});
		  },
		  error : function(data) {
			layer.msg(data.msg, {offset:'150px'});
		  }
		});
	});
	$('#Aserve').click(function(){
    var intername = $("#intername").val();
    var desc = $("#desc").val();
    var address = $("#address").val();
    var format = $("#format").val();
    var ask = $("#ask").val();
    var askExample = $("#askExample").val();
    var returnExample = $("#returnExample").val();
    var codeExample = $("#codeExample").val();
		$.ajax({
		  url:'ajax.php?interup',
		  type:"POST",
		  timeout:"3000",
		  data:{'intername':intername,'desc':desc,'address':address,'format':format,'ask':ask,'askExample':askExample,'returnExample':returnExample,'codeExample':codeExample},
	      dataType : 'json',
		  success:function(data){
		    if(data.code=='0'){
			    layer.alert(data.msg, {yes:function(index){setTimeout(function(){window.location.reload();},300)}, offset:'150px'});
		    }else{
		        layer.msg(data.msg, {offset:'150px'});
		    }
		  },
		  error : function(data) {
			layer.msg(data.msg, {offset:'150px'});
		  }
		});
	});
</script>
<script>
layui.use(['form', 'layer'], function () {
    var $ = layui.$,
            form = layui.form,
            step = layui.step;

    // select下拉框选中触发事件
    form.on("select(mySelect)", function(data){
        var val = data.value;
        if(val!=''){
            var ii = layer.load(2, {shade:[0.1,'#fff']});
            $.ajax({
	            type : "POST",
	            url : 'ajax.php?intercz',
	            data : {val:val},
	            dataType : 'json',
	            success : function(data) {
		            layer.close(ii);
		        	if(data.code == 1){
		        	    $('#desc').attr('value',data.content);
		        	    $('#address').attr('value',data.api_url);
		        	    $('#format').attr('value',data.return_format);
		        	    $('#ask').attr('value',data.http_mode);
		        	    $('#askExample').attr('value',data.http_case);
		        	    $('#returnExample').val(data.return_case);
		        	    $('#codeExample').val(data.code_case);
		        	    $('#Aserve').css({"display":"block"});
		        	    $('#Bserve').css({"display":"none"});
		        	}
		            if(data.code == 0){
		        	    $('#desc').attr('value',data.neirong);
		        	    $('#address').attr('value','https://<?= $_SERVER['HTTP_HOST'] ?>/API/'+data.channel+'/api.php');
		            }
		            if(data.code == -1){
		        	    $('#desc').attr('value','');
		        	    $('#address').attr('value','');
		        	    $('#format').attr('value','');
		        	    $('#ask').attr('value','');
		        	    $('#askExample').attr('value','');
		        	    $('#returnExample').val('');
		        	    $('#codeExample').val('');
		        	    $('#Aserve').css({"display":"none"});
		        	    $('#Bserve').css({"display":"block"});
		        	}
		            layer.msg(data.msg, {offset:'150px'});
	            } 
            });
        }
 
});
});
</script>
</body>
</html>