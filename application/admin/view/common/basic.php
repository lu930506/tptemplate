<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="__static__/font-awesome/css/font-awesome.min.css">
    <link href="__static__/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="__static__/layui/css/layui.css">
    {{block name="link"}} {{/block}}
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">某某科技管理后台</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{$adminName}}
                </a>

            </li>
            <li class="layui-nav-item"><a href="{{:url('login/logout')}}">退出</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            {{foreach $menuList as $key=>$menu }}
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item" >
                    <a class="" href="javascript:;"><i class="fa {{$menu.icon}}"></i> {{$menu.name}}</a>
                    {{if $menu.son}}
                        <dl class="layui-nav-child">
                            {{foreach $menu.son as $key=>$son }}
                            <dd {{if $path == $son.path}} class="layui-this" {{/if}}><a href="{{:url($son.path)}}" style="padding-left: 30px"><i class="fa {{$menu.icon}}"></i> {{$son.name}}</a></dd>
                            {{/foreach}}
                        </dl>
                    {{/if}}
                </li>

            </ul>
            {{/foreach}}
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">{{block name="conntet"}} {{/block}}</div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script src="__static__/jquery/dist/jquery.js"></script>
<script src="__static__/layui/layui.js"></script>
<script>

//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
});
</script>
<script>
   $('.layui-this').parents('li.layui-nav-item').addClass('layui-nav-itemed').siblings().removeClass('layui-nav-itemed')
    $('dl dd').click(function(){
        $(this).parents('li.layui-nav-item').addClass('layui-nav-itemed').siblings().removeClass('layui-nav-itemed')
     })

</script>
{{block name="script"}}

{{/block}}
</body>
</html>