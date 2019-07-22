<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新增权限</title>
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
        <label class="layui-form-label">父级<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <select name="pid">
                <option value="0">无</option>
                {{foreach $authList as $item}}
                <option {{if $item['id'] eq $data['pid']}} selected {{/if}} value="{{$item['id']}}">{{$item['name']}}</option>
                {{/foreach}}
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">权限名称<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="name" autocomplete="off" value="{{$data['name']}}" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">路径<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="path" lay-verify="path" autocomplete="off" value="{{$data['path']}}" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">图标<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="icon" lay-verify="icon" autocomplete="off" value="{{$data['icon']}}" class="layui-input">
        </div>
        <a type="button" href="http://fontawesome.dashgame.com/" class="layui-btn" target="_blank" >搜索图标</a>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">权重<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="level" lay-verify="level" autocomplete="off" value="{{$data['level']}}" class="layui-input">
        </div>

    </div>

    <input type="hidden" name="id" value="{{$data['id']}}">

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

<!--          //表单初始赋值-->
<!--        form.val('initForm', {-->
<!--             "pid": {{$data['pid']}} // "name": "value"-->
<!--             ,"path": {{$data['path']}} // "name": "value"-->
<!--             ,"icon": {{$data['icon']}} // "name": "value"-->
<!---->
<!--        })-->

        //自定义验证规则
        form.verify({
            name: function(value){
                if(!value.length){
                    return '权限名不能为空';
                }
            }

        });


        //监听提交
        form.on('submit(edit)', function(data){

            var fd = new FormData();
            for (var i in data.field) {
                fd.append(i, data.field[i]);
            }
            $.ajax({
                url: '/admin/auth/edit',
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
                        parent.window.reloadTableFunction(false);//1表示请求第一页
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