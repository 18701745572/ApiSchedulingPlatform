layui.define(function (exports) { //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
 
    var obj = {
        commonName:'我是common;一个公共的js，主要用于建立约束，类似config'
        //自定义请求字段
        ,request: {
            tokenName: "access_token"//自动携带 token 的字段名（如：access_token）。可设置 false 不携带。
        }
        //自定义响应字段
        , response: {
            statusName: 'code' //数据状态的字段名称
            , statusCode: {
                  ok: 1 //数据状态一切正常的状态码 0:失败，1：成功
                , logout: 0 //登录状态失效的状态码
            }
            , msgName: 'msg' //状态信息的字段名称
            , dataName: 'data' //数据详情的字段名称
 
        }
 
    };
 
    //输出common接口
    exports('common', obj);
});  
