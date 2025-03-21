<?php 
include '../includes/comment.php';
include '../Comment.php';
if($ulogin['status']==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$rowts=mysqli_query($con,"SELECT * from sc_config WHERE k='admin_ction'");
$user=mysqli_fetch_array($rowts);

$userid = $ulogin['zid'];
$users_con=mysqli_query($con,"select * from `sc_users` WHERE zid='$userid'");
$users_tj=mysqli_fetch_array($users_con);
$coun = mysqli_query($con,"SELECT name FROM sc_inter");
$count=mysqli_num_rows($coun);
$tj=$users_tj['huoyuecs'];

//活跃等级
$huoyelv=$tj/3000;
if($huoyelv<1) $huoyelv=1;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>首页</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../assets/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../Admin/css/layui-mini.css" media="all">
  <link rel="stylesheet" href="../Admin/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
  <link rel="stylesheet" href="../assets/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="//at.alicdn.com/t/font_2827587_e7db1paq2rd.css" media="all">
  <link rel="stylesheet" href="undefinedcss/css/chat.css" media="all">
  <link rel="stylesheet" href="undefinedcss/css/path.css" media="all">
  <?echo $ver_config['css'];?>
</head>
<body>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">   
        <!-- 数据统计 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-warning icon"></i>数据统计</div>
                <div class="layui-card-body">
                    <div class="welcome-module">
                        <div class="layui-row layui-col-space10">
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-blue">接口</span>
                                            <h5>今日已用</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $users_tj['user_counter']?></h1>
                                            <small>今日已调用接口次数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-cyan">接口</span>
                                            <h5>可用上限</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo (int)$users_tj['user_counter1']?></h1>
                                            <small>限制接口调用次数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-orange">接口</span>
                                            <h5>总共调用</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins"><?php echo $users_tj['huoyuecs']?></h1>
                                            <small>总共调用接口次数</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-xs6">
                                <div class="panel layui-bg-number">
                                    <div class="panel-body">
                                        <div class="panel-title">
                                            <span class="label pull-right layui-bg-green">等级</span>
                                            <h5>活跃等级</h5>
                                        </div>
                                        <div class="panel-content">
                                            <h1 class="no-margins">Lv.<?php echo (int)$huoyelv?></h1>
                                            <small>调用本站活跃程度</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  聊天室 -->
        <div class="layui-col-md6 layui-col-md6-chat">
            <div class="layui-card">
                <div class="layui-card-header">
                    <?php if(!empty($userid)){?>
                        <i class="fa fa-users icon"></i>公共聊天室
                    <?php }else{?>
                        请重新登录...
                    <?php }?>
                </div>
                <div class="layui-card-body layui-text" style="padding:0">
                    <div class="chat_box" id="chat_box">
                        <ul>
                        <?php 
                            //读取指定记录
                            $result = mysqli_query($con,"select * from `sc_text` order by id");
                            while($row=mysqli_fetch_array($result)){
                                $zid = $row['zid'];
                                $datetime = $row['time'];
                                $content = $row['content'];
                                $scuser = mysqli_query($con,"select * from `sc_users` where zid='$zid'");
                                $usertext = mysqli_fetch_array($scuser);
                                $datetime = date("jS H:i",strtotime("$datetime"));
                                
                                $content = htmlspecialchars_decode($content,ENT_QUOTES);//代码还原
                                if($usertext['user_image']==''){
                                    $userimage = '../assets/img/user.jpg';
                                }else{
                                    $userimage = $usertext['user_image'];
                                };
                                if($zid==$userid){
                                    echo'
                                    <li class="li-right">
                                        <p class="chat-right">'.$content.'</p>
                                        <img alt="'.$row['user'].'的头像" class="avatar" src="'.$userimage.'">
                                        <div class="chat-user-time chat-user-time-right"> <time class="date" datetime="'.$datetime.'">'.$datetime.'</time></div>
                                    </li>';
                                }else{
                                    echo'
                                    <li><div style="display: inline-block;">
                                        <a rel="nofollow" href="javascript:void(0);">
                                            <img alt="'.$row['user'].'的头像" class="avatar" src="'.$userimage.'">
                                            <dt class="user-name">'.$row['user'].'</dt>
                                            <div style="font-size:32px;" class="replymengban">@</div>
                                        </a>
                                        </div>
                                        <p class="chat-left">'.$content.'</p>
                                        <div class="chat-user-time"> <time class="date" datetime="'.$datetime.'">'.$datetime.'</time></div>
                                    </li>';
                                }
                            }
                        ?>
                        </ul>
                    </div>
                    <!--表情-->
                    <div class="dropdown-menu chat-img" id="chatopen" style="display:none">
                        <div id="chatdiv"></div>
                    </div>
                    <!--用户-->
                    <div class="dropdown-menu chat-user" style="display:none">
                        <div class="layui-card-header"><i class="fa fa-users icon"></i>用户列表</div>
                        <div id="chatuser">
                            <?php 
                            //读取指定记录
                            $result = mysqli_query($con,"select * from `sc_users` order by id");
                            while($row=mysqli_fetch_array($result)){
                                $uid = $row['zid'];
                                $newcontent=mysqli_query($con,"select * from `sc_text` where zid='$uid' order by time desc limit 1");
                                $newcon=mysqli_fetch_array($newcontent);
                                $date2 = $newcon['time']; 
                                $dcon = $newcon['content'];
                                if($dcon==''){$dcon='该用户最近还未发言...';};
                                echo'
                                <li class="user-li">
                                    <div class="user-li-div">
                                        <img alt="'.$row['display_name'].'的头像" src="'.$row['user_image'].'">
                                    </div>
                                    <div class="flex1">
                                        <span class="pull-right" title="'.$date1.'" data-placement="bottom">'.timeFormat($date2).'</span>
                                        <dt class="text-ellipsis font16">'.$row['display_name'].'</dt>
                                        <dd class="text-ellipsis font12">'.$dcon.'</dd>
                                    </div>
                                </li>';}
                                /*
                            *function:显示某一个时间相当于当前时间在多少秒前，多少分钟前，多少小时前
                            *timeInt:unix time时间戳
                            *format:时间显示格式
                            */
                            function timeFormat($the_time){
                                $now_time = date("Y-m-d H:i:s", time());
                                $now_time = strtotime($now_time);
                                $show_time = strtotime($the_time);
                                $dur = $now_time - $show_time;
                                if($dur<0){
                                 return $the_time;
                                }else{
                                 if ($dur<60){
                                     return $dur.'秒前';
                                 }else{
                                     if($dur<3600){
                                         return floor($dur/60).'分钟前';
                                     }else{
                                         if($dur<86400){
                                             return floor($dur/3600).'小时前';
                                         }else{
                                             if($dur<2592000){ // 3天内
                                                 return floor($dur/86400).'天前';
                                             }else{
                                                 if ($dur<2592000*12){ // 1年内
                                                     return floor($dur/2592000).'月前';
                                                 }else{
                                                     if($dur>2592000*12){ // 1年以上
                                                         return floor($dur/31104000).'年前';
                                                     }else{
                                                         return $the_time;
                                                     }
                                                 }
                                             }
                                         }
                                     }
                                 }
                             }
                            }
                            ?>
                        </div>
                    </div>
                    <!--图片-->
                    <div class="dropdown-menu chat-image" style="display:none">
                        <div id="image-tab">
                            <p>请填写图片地址：</p>
                            <textarea rows="2" tabindex="1" class="input-textarea" style="height:64px;" placeholder="http://..."></textarea>
                        </div>
                            <div class="text-right">
                                <span style="float:left;margin-top:8px;color:#14bdad;">提示：支持链接，不支持截图</span>
                                <a type="submit" class="but c-blue pw-1em" href="javascript:;">确认</a>
                            </div>
                        
                    </div>
                    <!--消息通知-->
                    <div class="tongzhi"><span>你有未读消息</span></div>
                    <div style="background: #fff;border-top: 1px solid #efefef;">
                        <a class="but" href="javascript:;" id="expression"><i class="fa fa-fw fa-smile-o"></i>表情</a>
                        <a class="but" href="javascript:;" id="image"><i class="fa fa-fw fa-image"></i>图片</a>
                        <a class="but" href="javascript:;" id="cqusers" style="float: right;"><i class="fa fa-fw fa-user-plus"></i>用户</a>
                    </div>
                    <div class="input_box">
                        <textarea placeholder="输入需要发送的信息(最多300字符)" class="form-textarea" name="receive" id="receive"></textarea>
                    </div>
                    <div class="btn-box">
                        <div style="display:inline;margin-right:14px;"><span class="number">0</span>/300</div>
                        <button class="layui-btn layui-btn-sm btn-send" id="btn-send"> 发送 </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 版本信息 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header"><i class="fa fa-fire icon"></i>版本信息</div>
                <div class="layui-card-body layui-text">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td>框架名称</td>
                                <td><?php echo $ver_config['LayuiVer']?></td>
                            </tr>
                            <tr>
                                <td>当前版本</td>
                                <td><?php echo $ver_config['versions']?></td>
                            </tr>
                            <tr>
                                <td>主要特色</td>
                                <td>零门槛/响应式/清爽/极简</td>
                            </tr>
                            <tr>
                                <td>服务特色</td>
                                <td>免费提供API接口服务</td>
                            </tr>
                            <tr>
                                <td>网站接口</td>
                                <td>当前共有<span style="color:#ff5722;font-weight:600;"> <?php echo $count?></span> 个接口</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<div style="text-align:center;margin:20px 0 4px 0;"><a href="https://www.tzyx.site" target="_blank">台州驿宣网络 ·<a target="_blank" href="https://beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img style="float:left;" src="https://xyblog-1259307513.cos.ap-guangzhou.myqcloud.com/wp-content/uploads/2021/09/0c9c2db33e96-1.png">粤ICP备19077511号</a>
</div>
<div style="text-align:center;color:#009688;margin:0 0 20px 0;">© Copyright 2022 - 2025 | 免费API调度平台 | All Rights Reserved </div>
<script src="../assets/layuiadmin/layui/layui.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="//at.alicdn.com/t/font_2827587_e7db1paq2rd.js"></script>
<script src="undefinedcss/js/chat.img.js"></script>
<script>
(function($){
    $.fn.extend({
        insertAtCaret: function(myValue){
            var $t=$(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                var HF_CONTENT=$.trim($("#receive").val());
                $(".number").html(HF_CONTENT.length);
            }else {
                this.value += myValue;
            }
        }
    })

})(jQuery);

/*textarea还剩余字数统计*/
$(function(){
 //监听textarea事件
   var el = document.getElementById('receive');
   el.addEventListener('input',function () {
       changeTextArea();
   });
   el.addEventListener('propertychange',function () {//兼容IE
       changeTextArea();
   });
})
 //文本域输入个数处理
 function changeTextArea(){
	  var HF_CONTENT=$.trim($("#receive").val());
	  if(HF_CONTENT==null || HF_CONTENT==""){
	     $(".number").html(0);
	  }else if(HF_CONTENT.length<=300){
	     $(".number").html(HF_CONTENT.length);
	  };
	  if(HF_CONTENT.length>300){
	    $('.number').css({"color":"red"});
	    $(".number").html(HF_CONTENT.length);
	  }else{
	      $('.number').css({"color":"#555"});
	  };
}

layui.use('carousel', function(){
  var carousel = layui.carousel;
  //建造实例
  carousel.render({
    elem: '#test-carousel-normal'
    ,width: '100%' //设置容器宽度
    ,height: '238px' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
});

  layui.config({
    base: '../assets/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');

$("#btn-send").click(function changeTextArea(){
    var time = 1;
    var HF_CONTENT=$.trim($("#receive").val());
    if(HF_CONTENT==null || HF_CONTENT==""){
	     layer.msg('请输入需要发送的内容...');
	     return false;
	}else if(HF_CONTENT.length>300){
	     layer.msg('最多只能输入300字符');
	     return false;
	}else{
	    $("#btn-send").attr("disabled",true);
	    $("#btn-send").html("稍等");
	    $('#btn-send').css({"background-color":"#555"});
	    var timer = setInterval(function () {
            if(time == 0){
                $("#btn-send").removeAttr("disabled");
                $("#btn-send").html("发送");
                $('#btn-send').css({"background-color":"#009688"});
                clearInterval(timer);
            }else {
                time--;
            }
        },1000);
        
        $('#receive').val('');
	    $(".number").html(0);
	    
        //表情包
	    var arrbox=HF_CONTENT;
        var pattern1 = /\$\{(.+?)\}/g;
        var pattern2 = /\$\{(.+?)\}/;
        var pattern3 = /<.+?>/;
        content=arrbox.match(pattern1);
        contentxss=arrbox.match(pattern3);
        var eee = unescape('%u7981%u6B62%u4F7F%u7528%u5F15%u5165%u4EE3%u7801%u5B57%u7B26%u4E32');
        if(contentxss!=null){
            layer.msg(eee);
            return false;
        }
        if(content!=null){
            for(i=0;i<content.length;i++){
                for(j=0;j<dataFace.length;j++){
                    if("${"+ dataFace[j].name +"}" == content[i]){
                        src = " <img src='"+dataFace[j].msrc+"' class='expression'> ";
                        break;
                    };
                }
                arrbox = arrbox.replace(pattern2,src);
            };
            $('#chat_box ul').append('<li class="li-right"><p class="chat-right">'+arrbox+'</p><img alt="<?php echo $users_tj['display_name']?>的头像" class="avatar" src="../assets/img/user.jpg"><div class="chat-user-time chat-user-time-right"> <time class="date" datetime="<?php echo $chatdate ?>"><?php echo $chatdate ?></time></div></li>');
        }else{
            $('#chat_box ul').append('<li class="li-right"><p class="chat-right">'+arrbox+'</p><img alt="<?php echo $users_tj['display_name']?>的头像" class="avatar" src="../assets/img/user.jpg"><div class="chat-user-time chat-user-time-right"> <time class="date" datetime="<?php echo $chatdate ?>"><?php echo $chatdate ?></time></div></li>');
        }
        
	    //页面滚动到底部
        var scrollHeight = $('#chat_box>ul').prop("scrollHeight");
        $('#chat_box>ul').scrollTop(scrollHeight,200);
        
        var content = arrbox;
        var user = '<?php echo $users_tj['display_name']?>';
        var zid = '<?php echo $userid?>';
        var dd = layer.load(1, {shade:[0.1,'#fff']});
	    $.ajax({
		    type : "POST",
		    url : "ajax.php?chat-text",
		    data : {"content":content,"user":user,"zid":zid},
		    dataType : "json",
		    success : function(data) {
			    layer.close(dd);
			    if(data.code == -1){
			        layer.msg(data.msg);
			    }
		    },
		    error : function(data) {
		        layer.close(dd);
                layer.msg('数据返回失败 ');
                console.log(data.msg);
            }
	    });
	}
});
window.onload=function(){
    //页面滚动到底部
    var scrollHeight = $('#chat_box>ul').prop("scrollHeight");
    $('#chat_box>ul').scrollTop(scrollHeight,200);
}

$(function () {
    $("#expression").click(function (e) {//
        $(".chat-user").hide(100);//隐藏速度
        $(".chat-image").hide(100);//隐藏速度
        $(".chat-img").show(100);//显示速度
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(".chat-img").click(function (e) {
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(document).click(function () {
        $(".chat-img").hide(100);//隐藏速度
    });
});

$(function () {
    $("#image").click(function (e) {//
        $(".chat-img").hide(100);//隐藏速度
        $(".chat-user").hide(100);//隐藏速度
        $(".chat-image").show(100);//显示速度
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(".chat-image").click(function (e) {
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(document).click(function () {
        $(".chat-image").hide(100);//隐藏速度
    });
});

$(function () {
    $("#cqusers").click(function (e) {//
        $(".chat-img").hide(100);//隐藏速度
        $(".chat-image").hide(100);//隐藏速度
        $(".chat-user").show(100);//显示速度
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(".chat-user").click(function (e) {
        /*阻止冒泡事件*/
        e = window.event || e;
        if (e.stopPropagation) {
            e.stopPropagation();
        } else {
            e.cancelBubble = true;
        }
    });
    $(document).click(function () {
        $(".chat-user").hide(100);//隐藏速度
    });
});

    $(function(){
        var editor = document.getElementById("dropdown-menu");
        var div = document.getElementById("chatdiv");
        var ulHtml = "";
        for(var i = 0,l= dataFace.length;i<l;i++){
            ulHtml +="<a class='smilie-icon' href='javascript:;' data-smilie='"+dataFace[i].name+"'><img class='lazyloaded' alt='"+dataFace[i].name+"' src='"+dataFace[i].msrc+"'  /></a>";
        }
        div.innerHTML=ulHtml;
        var as = div.getElementsByTagName("a");
        
        for(var i = 0, l = as.length; i<l;i++){
            as[i].onclick = new function(){
                var choose = as[i];
                return function(){
                    $("#chatopen").css("display","none");
                    var HF_CONTENT=$.trim($("#receive").val());
	                $(".number").html(HF_CONTENT.length);
	                $("#receive").insertAtCaret("${"+choose.getAttribute("data-smilie")+"}");
                }
            };
        }
    });
$(function () {
    setInterval(function () {
        var boxheight = $('#chat_box>ul').scrollTop();
        var userheight = $('#chat_box>ul').scrollTop();
        $("#chatuser").load(location.href + " #chatuser>*",  "");
        $("#chat_box>ul").load(location.href + " #chat_box>ul>*",  "");//注意后面DIV的ID前面的空格跟 id 后的>*，很重要！
        $('#chatuser').scrollTop(userheight);
        $('#chat_box>ul').scrollTop(boxheight);
    }, 5000);//5秒自动刷新
    
});

</script>
</body>
</html>