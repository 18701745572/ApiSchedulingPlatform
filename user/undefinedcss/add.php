<style>
.layuimini-form {margin:10px 10px 10px 0;border:5px solid #ffffff;border-radius:5px;background-color:#ffffff}

/**必填红点 */
.layuimini-form>.layui-form-item>.required:after {content:'*';color:red;position:absolute;margin-left:4px;font-weight:bold;line-height:1.8em;top:6px;right:5px;}
.layuimini-form>.layui-form-item>.layui-input-block {margin-left:120px !important;}
.layuimini-form>.layui-form-item>.layui-input-block >tip {display:inline-block;margin-top:10px;line-height:10px;font-size:10px;color:#a29c9c;}
</style>
<div class="layuimini-main" id="xinxi-add" style="display:none">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">接口名称</label>
            <div class="layui-input-block">
                <input type="text" name="intername" lay-verify="required" lay-reqtext="接口名称不能为空" placeholder="请输入接口名称" value="" class="layui-input">
                <tip>填写接口的名称方便用户查看。</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required" id="off">开关</label>
            <div class="layui-input-block">
                <div class="layui-form-switch layui-form-onswitch" onclick="oncheck()">
                    <em id="emo" title="1">开</em><i></i>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">调用渠道</label>
            <div class="layui-input-block">
                <input type="text" name="qudao" lay-verify="required" lay-reqtext="请输入调用渠道" placeholder="例如：ICP" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">主要用处</label>
            <div class="layui-input-block">
                <textarea name="remark" class="layui-textarea" placeholder="请输入主要用处"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="saveBtn">确认添加</button>
            </div>
        </div>
    </div>
</div>
<script>
function oncheck(){
    layui.use(['form', 'table'], function () {
        var form = layui.form,
            layer = layui.layer,
            table = layui.table,
            $ = layui.$;
        var emo = $("#emo").attr("title");
        if(emo=='1'){
             $("#emo").attr('title','0');
　　　　    $(".layui-form-switch").removeClass("layui-form-onswitch");
        }else{
             $("#emo").attr('title','1');
            $(".layui-form-switch").addClass("layui-form-onswitch");
        }
    });
};
    layui.use(['form', 'table'], function () {
        var form = layui.form,
            layer = layui.layer,
            table = layui.table,
            $ = layui.$;
        //初始化表单，要加上，不然刷新部分组件可能会不加载
        form.render();
        // 当前弹出层，防止ID被覆盖
        var parentIndex = layer.index;
        //监听提交
        
        form.on('submit(saveBtn)', function (data) {
            var index = layer.alert(JSON.stringify(data.field), {
                title: '提交信息'
            }, function () {
                // 关闭弹出层
                layer.close(index);
                layer.close(parentIndex);
                var field = data.field;
                var name=field.intername;
	            var qudao=field.qudao;
	            var remark=field.remark;
	            var emo = $("#emo").attr("title");
	            var dd = layer.load(1, {shade:[0.1,'#fff']});
	            $.ajax({
		            type : "POST",
		            url : "../Admin/ajax.php?add",
		            data : {"name":name,"qudao":qudao,"remark":remark,"emo":emo},
		            dataType : "json",
		            success : function(data) {
			            layer.close(dd);
			            if(data.code == 0){
				            layer.msg(data.msg);
				            console.log(data.msg);
				            setTimeout(function(){window.location.reload();},800);
			            }else{
				            layer.msg(data.msg);
			            }
		            },
		            error : function(data) {
		                layer.close(dd);
                        layer.msg('数据返回失败 ');
                        console.log(data.msg);
                    }
	            });
            });
            return false;
        });
    });
</script>