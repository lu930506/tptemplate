<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>新增角色</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">

    <style>
        .span-red {
            color: red;
        }

        .jstree-icon{
            display: inline-block;
            background-position: -132px -4px;
            width: 24px;
            height: 24px;
            line-height: 24px;
            background-image: url(/static/img/32px.png);
        }
        .jstree-icon-shu{
            background-position: -68px -4px;
        }
        .t1, .t2, .t3{
            min-height: 32px;
        }

        .t3, .center{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
        }
        #tree .layui-form-checkbox{
            margin-top: 0px;
        }

    </style>
</head>
<body>
          
<blockquote class="layui-elem-quote layui-text">
  注意：带<span class="span-red"> * </span>的是必填项
</blockquote>
 
<form class="layui-form" action="" method="post" lay-filter="initForm">


    <div class="layui-form-item">
        <label class="layui-form-label">角色名称<span class="span-red"> *</span></label>
        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="请输入角色名称" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">权限<span class="span-red"> *</span></label>
        <div class="layui-input-block">
            <div id="tree">
                <button type="button" class="layui-btn layui-btn-xs layui-btn-normal all_select" data-type="1">全选</button>
                <button type="button" class="layui-btn layui-btn-xs layui-btn-primary all_select" data-type="0">取消全选</button>

                <br /><br />
                {{foreach $authList as $item}}
                <div class="t1">
                    <div class="center">
                        <span class="jstree-icon" style="margin-right: 8px;"></span>
                        <div data-id="{{$item['id']}}" class="operate1 layui-unselect layui-form-checkbox" lay-skin="primary">
                            <span>{{$item['name']}}</span>
                            <i class="layui-icon layui-icon-ok"></i>
                        </div>
                    </div>


                    {{if $item['son']}}
                    {{foreach $item['son'] as $ite}}

                    <div class="t2">
                        <div class="center">
                            <span class="jstree-icon jstree-icon-shu"></span>
                            <span class="jstree-icon"  style="margin-right: 8px;"></span>
                            <div data-id="{{$ite['id']}}" class="operate2 layui-unselect layui-form-checkbox" lay-skin="primary">
                                <span>{{$ite['name']}}</span>
                                <i class="layui-icon layui-icon-ok"></i>
                            </div>
                        </div>
                        {{if $ite['son']}}

                        <div class="t3">
                            <span class="jstree-icon jstree-icon-shu"></span>
                            <span class="jstree-icon jstree-icon-shu"></span>
                            <span class="jstree-icon" style="margin-right: 8px;"></span>
                            {{foreach $ite['son'] as $it}}

                            <div data-id="{{$it['id']}}" class="operate3 layui-unselect layui-form-checkbox" lay-skin="primary">
                                <span>{{$it['name']}}</span>
                                <i class="layui-icon layui-icon-ok"></i>
                            </div>
                           {{/foreach}}
                        </div>
                        {{/if}}
                    </div>
                    {{/foreach}}
                    {{/if}}
                </div>
                {{/foreach}}
            </div>
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit lay-filter="add">确认提交</button>
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

        //自定义验证规则
        form.verify({
            name: function(value){
                if(!value.length){
                    return '权限名不能为空';
                }
            }
        });

          function getPermissions(){
                var str = '';
                $('.layui-form-checked').each(function(){
                    str =  str + ',' +$(this).attr('data-id');
                })
                return str.substr(1);
            }

        //监听提交
        form.on('submit(add)', function(data){
            data.field.permissions = getPermissions();

            $.ajax({
                url: '/admin/role/add',
                type: 'post',
                dataType: 'json',
                data: data.field,
                success: function(res) {
                    layer.msg(res.msg);
                    if (res.code == 0) {
                         setTimeout(function(){
                            parent.window.layer.close(parent.window.addindex);
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

       $('.operate1').on('click', function(data){
                var dom = $(this).parents('.t1').find('.t2');
                if (!$(this).hasClass('layui-form-checked')) {
                    $(this).addClass('layui-form-checked');
                    dom.find('.layui-form-checkbox').addClass('layui-form-checked');
                }
                else {
                    $(this).removeClass('layui-form-checked');
                    dom.find('.layui-form-checkbox').removeClass('layui-form-checked');
                }

         });

             $('.operate2').on('click', function(data){
                operate2_function($(this));
            });

            /* 第二级，点击的时候 */
            function operate2_function(this_dom, sonUse=false)
            {
                var dom = this_dom.parents('.t2').find('.t3');
                if (sonUse) {
                    if (!this_dom.parents('.t1').find('.t2 > .center div[class$="layui-form-checked"]').length) { //如果没找到勾中的,全部取消
                        this_dom.parents('.t1').find('.center').eq(0).find('div').removeClass('layui-form-checked');
                    }
                    if (this_dom.parents('.t1').find('.t2 > .center div[class$="layui-form-checked"]').length) { //如果找到有√中的，存在选中
                        this_dom.parents('.t1').find('.center').eq(0).find('div').addClass('layui-form-checked');
                    }
                    return;
                }
                if (!this_dom.hasClass('layui-form-checked')) {
                    this_dom.addClass('layui-form-checked');
                    dom.find('.layui-form-checkbox').addClass('layui-form-checked');
                  //  if (this_dom.parents('.t1').find('.t2 > .center div[class$="layui-form-checked"]').length) { //如果找到有√中的
                        this_dom.parents('.t1').find('.center').eq(0).find('div').addClass('layui-form-checked');
                   // }
                }
                else {
                    this_dom.removeClass('layui-form-checked');
                    dom.find('.layui-form-checkbox').removeClass('layui-form-checked');
                    if (!this_dom.parents('.t1').find('.t2 > .center div[class$="layui-form-checked"]').length) { //如果没找到勾中的
                        this_dom.parents('.t1').find('.center').eq(0).find('div').removeClass('layui-form-checked');
                    }
                }
            }

              /* 第三级，点击的时候 */
             $('.operate3').on('click', function(data){

                if (!$(this).hasClass('layui-form-checked')) {
                    $(this).addClass('layui-form-checked');
                    if ($(this).parents('.t3').find('div[class$="layui-form-checked"]').length) { //如果找到有勾中的
                        $(this).parents('.t2').find('.center').eq(0).find('div').addClass('layui-form-checked');
                    }
                }
                else {
                    $(this).removeClass('layui-form-checked');
                    if (!$(this).parents('.t3').find('div[class$="layui-form-checked"]').length) { //如果没找到勾中的
                        $(this).parents('.t2').find('.center').eq(0).find('div').removeClass('layui-form-checked');
                    }

                }

                //最后找到他的上级
                operate2_function($(this).parents('.t2').find('.operate2').eq(0), true);
            });

            $('.all_select').on('click', function(){
                var type = $(this).attr('data-type');
                // console.log(type)
                if (type == 1) {
                    $('#tree').find('.layui-form-checkbox').addClass('layui-form-checked');
                } else {
                    $('#tree').find('.layui-form-checkbox').removeClass('layui-form-checked');
                }
            })

</script>

</body>
</html>