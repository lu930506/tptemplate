<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>编辑管理员</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
  <style>
      .span-red{
          color: red;
      }
  </style>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
          
<blockquote class="layui-elem-quote layui-text">
  注意：带<span class="span-red"> * </span>的是必填项
</blockquote>
 
<form class="layui-form" action="" method="post" lay-filter="initForm">

    <div class="layui-form-item">
        <label class="layui-form-label">角色<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <select name="role_id">
                {{foreach $roleList as $item}}
                <option {{if $item['id'] eq $data['role_id']}} selected {{/if}} value="{{$item['id']}}">{{$item['name']}}</option>
                {{/foreach}}
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">账号<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="account" lay-verify="account" autocomplete="off" placeholder="请输入账号" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">邮箱<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="email" lay-verify="email" autocomplete="off"  class="layui-input">
        </div>
    </div>


    <input type="hidden" name="id" value="{{$data['id'] }}">

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit lay-filter="edit">确认提交</button>
        </div>
    </div>
</form>
          
<!-- jQuery 3 -->
<script src="/static/jquery/dist/jquery.min.js"></script>
<script src="/static/layui/layui.js" charset="utf-8"></script>


<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layer'], function(){
        var form = layui.form
        ,layer = layui.layer;

         //表单初始赋值
        form.val('initForm', {
             "account": '{{$data['account']}}' // "name": "value"
             ,"email": '{{$data['email']}}' // "name": "value"

        })

        //自定义验证规则
        form.verify({
            account: function(value){
                if(!value.length){
                    return '账号不能为空';
                }
            }
             ,password: function(value){
                if(!value.length){
                    return '密码不能为空';
                }
            }
            ,email: function(value){
                if(!value.length){
                    return '邮箱不能为空';
                }
            },

        });


        //监听提交
        form.on('submit(edit)', function(data){

            var fd = new FormData();
            for (var i in data.field) {
                fd.append(i, data.field[i]);
            }

            $.ajax({
                url: '/admin/admin/edit',
                type: 'post',
                processData: false,
                contentType: false,
                headers: {

                },
                dataType: 'json',
                data: fd,
                success: function(res) {
                    layer.msg(res.msg);
                    if (res.code == 0) {
                         setTimeout(function(){
                            parent.window.layer.close(parent.window.editindex);
                        }, 800);
                        parent.window.reloadTableFunction('');//1表示请求第一页
                    }
                },
                error: function (){
                    layer.msg('发生错误，请联系管理员');
                }
            })

            return false;
        });
        

    });
</script>

</body>
</html>