<?php
include '../includes/comment.php';
@header('Content-Type: application/json; charset=UTF-8');
switch($url){
//添加返回参数
case 'addreturn':
    $name=$_POST['name'];
    $type=$_POST['type'];
    $explain=$_POST['explain'];
    $intername=$_POST['intername'];
    if(!empty($name)&&!empty($type)&&!empty($explain)&&!empty($intername)){
        $zhu="INSERT INTO `sc_errturn` (zid,name,type,explaina,date,errturn) VALUES ('$intername','$name','$type','$explain','$date','1')";
        mysqli_query($con,$zhu);
        $result = array('code'=>0, 'msg'=>'添加成功');
    }else{
    	$result = array('code'=>-1, 'msg'=>'数据不完整，请检查！');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//添加错误参数
case 'adderror':
    $name=$_POST['name'];
    $type=$_POST['type'];
    $explain=$_POST['explain'];
    $intername=$_POST['intername'];
    if(!empty($name)&&!empty($type)&&!empty($explain)&&!empty($intername)){
        $zhu="INSERT INTO `sc_errturn` (zid,name,type,explaina,date,errturn) VALUES ('$intername','$name','$type','$explain','$date','0')";
        mysqli_query($con,$zhu);
        $result = array('code'=>0, 'msg'=>'添加成功');
    }else{
    	$result = array('code'=>-1, 'msg'=>'数据不完整，请检查！');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//添加接口
case 'add':
    $name=$_POST['name'];
    $qudao=$_POST['qudao'];
    $remark=$_POST['remark'];
    $status=$_POST['emo'];
    if(!empty($name)&&!empty($qudao)&&!empty($remark)&&!empty($status)){
        $coun = mysqli_query($con,"SELECT name FROM sc_inter");
        $count=mysqli_num_rows($coun);
        $count+=1;
        $zhu="INSERT INTO `sc_inter` (zid,name,channel,neirong,status) VALUES ('$count','$name','$qudao','$remark','$status')";
        mysqli_query($con,$zhu);
        $result = array('code'=>0, 'msg'=>'添加成功');
    }else{
    	$result = array('code'=>-1, 'msg'=>'数据不完整，请检查！');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//添加接口页面
case 'interadd':
	$zid = $_POST['intername'];
	$coun = mysqli_query($con,"SELECT * FROM sc_inter WHERE zid='$zid'");
    $count = mysqli_fetch_array($coun);
    $countN = $count['name']; //接口标题
	$desc = $_POST['desc'];//接口简介说明
	$address = $_POST['address'];//接口地址
	$format = $_POST['format'];//接口返回格式
	$ask = $_POST['ask'];//接口请求方式
	$askExample = $_POST['askExample'];//接口请求示例
	$returnExample = $_POST['returnExample'];//接口返回示例
    $codeExample = $_POST['codeExample'];//接口代码示例
    
    $query_coun = mysqli_query($con,"SELECT * FROM sc_content WHERE zid='$zid'");
    $query = mysqli_fetch_array($query_coun);
    if($query){
        $result = array('code'=>-1, 'msg'=>'请检查已经添加');
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
	if (empty($countN)||empty($desc)||empty($address)||empty($askExample)||empty($returnExample)){
		$result = array('code'=>-1, 'msg'=>'请检查是否有空');
		exit(json_encode($result, JSON_UNESCAPED_UNICODE));
	}
	if($codeExample==''){$codeExample = $askExample;}
	if($format==''){$format = 'JSON';}
	if($ask==''){$ask = 'GET';}
	$sql = mysqli_query($con,"INSERT INTO sc_content (zid,content_title,content,api_url,return_format,http_mode,http_case,return_case,code_case,ip) VALUES ('$zid','$countN','$desc','$address','$format','$ask','$askExample','$returnExample','$codeExample','$ip')");
	if ($sql) {
		$result = array('code'=>0, 'msg'=>'添加成功');
	}else{
		$result = array('code'=>-1, 'msg'=>'添加失败');
		
	}
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//修改接口页面
case 'interup':
	$zid = $_POST['intername'];
	$coun = mysqli_query($con,"SELECT * FROM sc_inter WHERE zid='$zid'");
    $count = mysqli_fetch_array($coun);
    $countN = $count['name']; //接口标题
	$desc = $_POST['desc'];//接口简介说明
	$address = $_POST['address'];//接口地址
	$format = $_POST['format'];//接口返回格式
	$ask = $_POST['ask'];//接口请求方式
	$askExample = $_POST['askExample'];//接口请求示例
	$returnExample = $_POST['returnExample'];//接口返回示例
    $codeExample = $_POST['codeExample'];//接口代码示例
    
	if (empty($countN)||empty($desc)||empty($address)||empty($askExample)||empty($returnExample)){
		$result = array('code'=>-1, 'msg'=>'请检查是否有空');
		exit(json_encode($result, JSON_UNESCAPED_UNICODE));
	}
	
	$query_coun = mysqli_query($con,"SELECT * FROM sc_content WHERE zid='$zid'");
    $query = mysqli_fetch_array($query_coun);
    if($query){
        $sql = mysqli_query($con,"UPDATE sc_content SET content='$desc',api_url='$address',return_format='$format',http_mode='$ask',http_case='$askExample',return_case='$returnExample',code_case='$codeExample',ip='$ip' where zid='$zid'");
	    if ($sql) {
		    $result = array('code'=>0, 'msg'=>'修改成功');
	    }else{
		    $result = array('code'=>-1, 'msg'=>'修改失败');
	    }
    }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//后台登录
case 'login':
    $se=$_POST['session']; //验证码
    $user=$_POST['user']; //帐号
    $pass=$_POST['pass']; //密码
    $re=mysqli_query($con,"select * from sc_config where v='$user' limit 1"); //登录帐号
    $res=mysqli_fetch_array($re);
    $pw=mysqli_query($con,"select * from sc_config where k='admin_pwd'"); //登录密码
    $pwd=mysqli_fetch_array($pw);
    $admin = $pwd['v'];
    if($res&&password_verify($pass, $admin)===true&&isset($se)){ //password_verify验证密码跟数据库表里的密码是否为true
    	session_start(); 
    	if(strtolower($se)==strtolower($_SESSION['session'])){ 
            $result = array('code'=>0, 'msg'=>'登录成功');
            $yh=mysqli_query($con,"select * from sc_users where user_login='$user'"); //检查帐号
            $yhs=mysqli_fetch_array($yh);
            $yhpass = password_hash($pass, PASSWORD_DEFAULT,['cost' => 12]); //password_hash给密码加盐，需通过password_verify解密
            if(!$yhs){
                mysqli_query($con,"INSERT INTO sc_users (zid,display_name,user_login,user_pass,user_email,user_qq,user_url,user_money,user_level,user_counter,user_counter1,user_ip,user_date,user_status) VALUES ('1','$user','$user','$yhpass','','','','0','2','0','10000','$ip','$date','1')");
            }
            $del="DELETE FROM sc_logs";
            mysqli_query($con,$del);
            $zhu="INSERT INTO sc_logs (action,param,addtime,status) VALUES ('后台登录','$ip','$date','1')";
            mysqli_query($con,$zhu);
            
            $re=mysqli_query($con,"select * from sc_login where zid='1'"); //登录帐号
            $res=mysqli_fetch_array($re);
            if(!$res){
                $zhu="INSERT INTO sc_login (zid,login,date,enddate,ip,status) VALUES ('1','$user','$date','0000-00-00 00:00:00','$ip','1')";
                mysqli_query($con,$zhu);
            }else{
                $zhu="UPDATE sc_login SET login='$user',date='$date',enddate='0000-00-00 00:00:00',ip='$ip',status='1' WHERE zid='1'";
                mysqli_query($con,$zhu);
            }
	    }else{ 
            $result = array('code'=>-1, 'msg'=>'验证码错误');
    	}
    }else{
    	$result = array('code'=>-1, 'msg'=>'帐号或密码错误');
    };
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//后台密码修改
case 'change':
        $used = $_POST['old']; //旧密码
        $new = $_POST['newP']; //新密码
        $pwd = $_POST['again']; //重复新密码
        $oldpwd=mysqli_query($con,"select * from sc_config where k='admin_pwd'");
        $oldpwd2 = mysqli_fetch_array($oldpwd);
        $admin = $oldpwd2['v']; //数据表里的加盐密码
        if(password_verify($used, $admin)===true&&$new==$pwd){ //验证提交密码跟数据表的密码是否为true
            $new = password_hash($new, PASSWORD_DEFAULT,['cost' => 12]); //password_hash给密码加盐，需通过password_verify解密
      	    mysqli_query($con,"UPDATE sc_config SET v='$new' where k='admin_pwd'");
      	    mysqli_query($con,"UPDATE sc_users SET user_pass='$new' where zid='1'");
      	    mysqli_query($con,"UPDATE sc_login SET status='0' where zid='1'");
      	    $result = array('code'=>0, 'msg'=>'修改密码成功');
      	    $del="DELETE FROM sc_logs";
            mysqli_query($con,$del);
         }elseif($used==$new){
      	    $result = array('code'=>-1, 'msg'=>'新密码不能跟旧密码相同');
         }elseif($new!=$pwd){
      	    $result = array('code'=>-1, 'msg'=>'两次输入的密码不一致');
         }else{
      	    $result = array('code'=>-1, 'msg'=>'旧密码不正确');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//修改后台登录帐号
case 'name':
        $name = $_POST['name'];
        $oldname = "select * from sc_config where k='admin_user'";
        $newname = mysqli_query($con,$oldname);
        $newname2 = mysqli_fetch_array($newname);
        $admin = $newname2['v'];
        if($name!=''&&$admin!=$name){
      	    mysqli_query($con,"UPDATE sc_config SET v='$name' where k='admin_user'");
      	    mysqli_query($con,"UPDATE sc_users SET display_name='$name',user_login='$name' where zid='1'");
      	    mysqli_query($con,"UPDATE sc_login SET status='0' where zid='1'");
      	    $result = array('code'=>0, 'msg'=>'修改成功');
      	    $del="DELETE FROM sc_logs";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'修改失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//退出登录
case 'close':
    $status_look="select * from sc_logs";
    $status_reg=mysqli_query($con,$status_look);
    $status=mysqli_fetch_array($status_reg);
    if($status['status'] == '1'){ 
        $result = array('code'=>0, 'msg'=>'退出成功');
        mysqli_query($con,"UPDATE sc_login SET status='0' where zid='1'");
        $del="DELETE FROM sc_logs";
        mysqli_query($con,$del);
	}else{ 
        $result = array('code'=>-1, 'msg'=>'退出失败');
    }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//删除反馈问题
case 'del':
        $id = $_POST['id'];
        if($id!=''){
      	    $result = array('code'=>0, 'msg'=>'删除成功');
      	    $del="DELETE FROM sc_reg WHERE id='$id'";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'删除失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//用户帐户开通情况
case 'usercheck':
        $id = $_POST['id'];
        $query = mysqli_query($con,"select * from sc_users where id='$id'");
        $query_id = mysqli_fetch_array($query);
        if($id!=''&&$query_id['user_status']=='1'){
      	    mysqli_query($con,"UPDATE sc_users SET user_status='0' where id='$id'");
      	    $result = array('code'=>0, 'msg'=>'账户开通关闭');
         }elseif($id!=''&&$query_id['user_status']=='0'){
      	    mysqli_query($con,"UPDATE sc_users SET user_status='1' where id='$id'");
      	    $result = array('code'=>0, 'msg'=>'账户开通成功');
         }else{
            $result = array('code'=>-1, 'msg'=>'请检查账户是否存在！');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//接口开关
case 'check':
        $id = $_POST['id'];
        $query = mysqli_query($con,"select * from sc_inter where id='$id'");
        $query_id = mysqli_fetch_array($query);
        if($id!=''&&$query_id['status']=='1'){
      	    mysqli_query($con,"UPDATE sc_inter SET status='0' where id='$id'");
      	    $result = array('code'=>0, 'msg'=>'关闭成功');
         }elseif($id!=''&&$query_id['status']=='0'){
      	    mysqli_query($con,"UPDATE sc_inter SET status='1' where id='$id'");
      	    $result = array('code'=>0, 'msg'=>'开启成功');
         }else{
            $result = array('code'=>-1, 'msg'=>'数据错误！');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//删除接口
case 'interdel':
        $id = $_POST['id'];
        $query_id = mysqli_query($con,"select * from `sc_inter` WHERE id='$id'");
        $query = mysqli_fetch_array($query_id);
        $zid = $query['zid'];
        $query_zid = mysqli_query($con,"select * from `sc_content` WHERE zid='$zid'");
        $content = mysqli_fetch_array($query_zid);
        if($id!=''){
            if($content) mysqli_query($con,"DELETE FROM sc_content WHERE zid='$zid'");
      	    $result = array('code'=>0, 'msg'=>'删除成功');
      	    $del="DELETE FROM sc_inter WHERE id='$id'";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'删除失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//删除返回参数
case 'returndel':
        $id = $_POST['id'];
        $query_id = mysqli_query($con,"select * from `sc_errturn` WHERE id='$id'");
        $query = mysqli_fetch_array($query_id);
        if($id!=''){
      	    $result = array('code'=>0, 'msg'=>'删除成功');
      	    $del="DELETE FROM sc_errturn WHERE id='$id'";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'删除失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//删除错误参数
case 'errordel':
        $id = $_POST['id'];
        $query_id = mysqli_query($con,"select * from `sc_errturn` WHERE id='$id'");
        $query = mysqli_fetch_array($query_id);
        if($id!=''){
      	    $result = array('code'=>0, 'msg'=>'删除成功');
      	    $del="DELETE FROM sc_errturn WHERE id='$id'";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'删除失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//删除用户
case 'userdel':
        $id = $_POST['id'];
        if($id!=''){
      	    $result = array('code'=>0, 'msg'=>'删除成功');
      	    $del="DELETE FROM sc_users WHERE id='$id'";
            mysqli_query($con,$del);
         }else{
      	    $result = array('code'=>-1, 'msg'=>'删除失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//修改接口
case 'edit': 
	$id = $_POST['id'];
    $query = mysqli_query($con,"select * from `sc_inter` WHERE id='$id'");
    $query_id = mysqli_fetch_array($query);
	if(empty($query_id)){
	    exit('{"code":-1,"msg":"请检查是否已经删除！"}');
	}else{
	    $data= '
	    <div class="layuimini-main" id="edit-add">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">接口名称</label>
            <div class="layui-input-block">
                <input type="text" name="editname" lay-verify="required" lay-reqtext="接口名称不能为空" placeholder="'.$query_id['name'].'" value="'.$query_id['name'].'" class="layui-input">
                <tip>填写接口的名称方便用户查看。</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">调用渠道</label>
            <div class="layui-input-block">
                <input type="text" name="editqudao" lay-verify="required" lay-reqtext="请输入调用渠道" placeholder="'.$query_id['channel'].'" value="'.$query_id['channel'].'" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">主要用处</label>
            <div class="layui-input-block">
                <textarea name="editremark" class="layui-textarea" placeholder="'.$query_id['neirong'].'">'.$query_id['neirong'].'</textarea>
            </div>
        </div>
    </div>
</div>
	    ';
	    $result=array("code"=>0,"msg"=>"succ","data"=>$data);
	}
	exit(json_encode($result));
break;

//修改接口-2
case 'edit2':
        $editid = $_POST['id'];
        $editname = $_POST['editname'];
        $editqudao = $_POST['editqudao'];
        $editremark = $_POST['editremark'];
        if(!empty($editname)&&!empty($editqudao)&&!empty($editremark)&&!empty($editid)){
      	    mysqli_query($con,"UPDATE sc_inter SET name='$editname',channel='$editqudao',neirong='$editremark' where id='$editid'");
      	    $result = array('code'=>0, 'msg'=>'修改成功');
         }else{
      	    $result = array('code'=>-1, 'msg'=>'修改失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//添加接口页面获取接口数据
case 'intercz':
        $zid = $_POST['val'];
        $query = mysqli_query($con,"select * from `sc_inter` WHERE zid='$zid'");
        $query_inter = mysqli_fetch_array($query);
        $neirong = $query_inter['neirong'];
        $channel = $query_inter['channel'];
        $name = $query_inter['name'];
        $query1 = mysqli_query($con,"select * from `sc_content` WHERE zid='$zid'");
        $query_content = mysqli_fetch_array($query1);
        $title = $query_content['content_title'];
        if($title==$name&&$zid!='0'){
                $result = array('code'=>1, 'msg'=>'查找成功', 'content_title'=>$query_content['content_title'], 'content'=>$query_content['content'], 'api_url'=>$query_content['api_url'], 'return_format'=>$query_content['return_format'], 'http_mode'=>$query_content['http_mode'], 'http_case'=>$query_content['http_case'], 'return_case'=>$query_content['return_case'], 'code_case'=>$query_content['code_case']);
        }elseif(!empty($neirong)&&!empty($channel)){
      	    $result = array('code'=>0, 'msg'=>'获取数据成功', 'neirong'=>$neirong, 'channel'=>$channel);
        }else{
      	    $result = array('code'=>-1, 'msg'=>'请选择已有接口');
        }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;

//修改返回参数
case 'errturnedit': 
	$id = $_POST['id'];
    $query = mysqli_query($con,"select * from `sc_errturn` WHERE id='$id'");
    $query_id = mysqli_fetch_array($query);
	if(empty($query_id)){
	    exit('{"code":-1,"msg":"请检查是否已经删除！"}');
	}else{
	    $data= '
	    <div class="layuimini-main" id="edit-add">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">参数名</label>
            <div class="layui-input-block">
                <input type="text" name="editname" lay-verify="required" lay-reqtext="参数名" placeholder="'.$query_id['name'].'" value="'.$query_id['name'].'" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">参数类型</label>
            <div class="layui-input-block">
                <input type="text" name="editqudao" lay-verify="required" lay-reqtext="参数类型" placeholder="'.$query_id['type'].'" value="'.$query_id['type'].'" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">参数说明</label>
            <div class="layui-input-block">
                <textarea name="editremark" class="layui-textarea" placeholder="'.$query_id['explaina'].'">'.$query_id['explaina'].'</textarea>
            </div>
        </div>
    </div>
</div>
	    ';
	    $result=array("code"=>0,"msg"=>"succ","data"=>$data);
	}
	exit(json_encode($result));
break;

//修改返回参数-2
case 'errturnedit2':
        $editid = $_POST['id'];
        $editname = $_POST['editname'];
        $editqudao = $_POST['editqudao'];
        $editremark = $_POST['editremark'];
        if(!empty($editname)&&!empty($editqudao)&&!empty($editremark)&&!empty($editid)){
      	    mysqli_query($con,"UPDATE sc_errturn SET name='$editname',type='$editqudao',explaina='$editremark' where id='$editid'");
      	    $result = array('code'=>0, 'msg'=>'修改成功');
         }else{
      	    $result = array('code'=>-1, 'msg'=>'修改失败');
         }
exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
default:
    $result = array('code'=>-4, 'msg'=>'json返回失败');
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
break;
};
?>