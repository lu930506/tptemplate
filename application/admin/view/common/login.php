<html>
<head>
    <title>登录1</title>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <style>
        body {
            background-color: #c3cdda;
            background: url(/static/img/login_bg.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow:hidden;
        }
        .m-login { width: 400px;height: 200px;padding: 30px;position: absolute;left: 0;margin: auto;top: 0;bottom: 0;right: 0;border-radius: 5px;border: 2px solid #009688;}
        .m-login .login-head { height:40px;line-height:40px; padding-left:10px; font-size:24px;  text-align:center; color:#009688;margin-bottom:10px; font-weight: 700;}
        .layui-btn{background:#009688d4;}
        .layui-form-item input:focus{
            border-style:solid;
            border-color: #009688;
            box-shadow: 0 0 30px #009688;
            outline: #009688;
        }
        .m-login .logo{margin-right:10px;display:none;}
        canvas{width:100%;}
        .ivu-col.ivu-col-span-24{display: none;}
        .layui-layer-content{background-color:#009688d4;color: #fff;}
        .power{color:#ffffff;position:fixed; bottom:0;}
    </style>
</head>
<div id="app"></div>
<div class="m-login">
    <div class="login-head">登录</div>
    <form  class="layui-form" id="_form" onsubmit="return false">
            <div class="layui-form-item field-loginform-username required">
                <input type="text" class="layui-input" name="account"  id="login-name" maxlength="256" placeholder="用户名" value="">
            </div>
            <div class="layui-form-item field-loginform-password required">
                <input type="password" id="login-password" class="layui-input" name="password" maxlength="256" placeholder="密码">
            </div>

            <div class="layui-form-item">
                <button type="submit" id="login" class="layui-btn layui-btn-fluid u-login-btn">登录</button>
            </div>
    </form>
<!--    <div class="power"></div>-->
</div>

<script src="/static/layui/layui.js"></script>
<script src="/static/js/login_canvas_1.js"></script>
<script src="/static/js/login_canvas_2.js"></script>
<script>
    layui.use(['layer','jquery'], function(){
        console.log('ok');
        var layer = layui.layer;
        var $ = layui.jquery;
        $('#login').click(function(){
            console.log(1111);
            $.ajax({
                url:"{{:url('login/login')}}",
                data:$('#_form').serialize(),
                type:'post',
                success:function(res) {
                    if(res.code == 0) {
                        layer.msg('登录成功 正在跳转中...',{offset: '200px',anim: 1});
                        setTimeout(function() {
                            location.href = "{{:url('admin/index')}}";
                        }, 1000);
                    }else{
                        layer.msg('用户名或密码错误',{offset: '200px',anim: 1});
                    }
                },
                error : function(){
                      layer.closeAll();
                      layer.msg('系统异常！请联系管理员！',{offset: '200px',anim: 1});
                }
            })
        })
    })
</script>
