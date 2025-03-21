<?php
include 'includes/Config.php';
$url = $_SERVER["QUERY_STRING"];
$ip = $_SERVER["REMOTE_ADDR"]; 
@header('Content-Type: application/json; charset=UTF-8');
switch($url){
case 'order': 
	$id = $_POST['id'];
	$query = mysqli_query($con,"select * from `sc_inter` WHERE id='$id'");
    $query_id = mysqli_fetch_array($query);
	if(empty($id)){exit('{"code":-1,"msg":"请检查是否已经删除！"}');}else{
	$data= '<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all"/><style>.layui-layer-content{padding:10px;}</style><div class="form-group"><div class="input-group"><div class="input-group-addon" id="inputname1">接口名称</div><input type="text" disabled="disabled" id="inputnm" value="'.$query_id['name'].'" class="form-control" required/></div></div>
		      <div class="form-group"><div class="input-group"><div class="input-group-addon" id="inputname">反馈信息</div><textarea type="text" autocomplete="off" style="width:352px;height:110px;padding:0 2px 0 6px;" id="inputlink" value="" class="form-control"></textarea></div></div>
        ';
	$data.= '<input type="submit" id="save" onclick="saveOrder('.$id.')" class="btn btn-primary btn-block" value="提交信息" style="margin:4px auto;width:98%;">';
	$result=array("code"=>0,"msg"=>"succ","data"=>$data);}
	exit(json_encode($result));
break;
case 'order2': 
	$id=intval($_POST['id']);
	$link=$_POST['inputlink'];
	$name=$_POST['inputnm'];
	if($link!=''&&$name!=''){
        mysqli_query($con,"INSERT INTO sc_reg (ip,name,problem) VALUES ('$ip','$name','$link')");
        $result=array("code"=>0,"msg"=>"提交成功");
	}else{
		$result=array("code"=>-1,"msg"=>"提交失败");
	}
	exit(json_encode($result));
break;
case 'interjk': 
	$id=$_POST['id'];
	$coun = mysqli_query($con,"SELECT * FROM sc_inter WHERE zid='$id'");
    $count=mysqli_fetch_array($coun);
    $countT=$count['channel'];
	if($id!=''&&$count!=''){
        $result=array("code"=>0,"msg"=>$countT,"zid"=>$id);
	}else{
		$result=array("code"=>-1,"msg"=>"在后台查看接口是否未添加调用渠道");
	}
	exit(json_encode($result));
break;
default:
    $result = array('code'=>-4, 'msg'=>'json返回失败');
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
};?>