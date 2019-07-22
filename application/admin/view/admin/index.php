{{extend name="common:basic" /}}

{{block name="link"}}
{{/block}}

{{block name="conntet"}}
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <button class="layui-btn btn btn-layer" data-method="setTop">新建管理员</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="layui-hide" id="info" lay-filter="info_filter"></table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
{{/block}}



{{block name="script"}}

    <script type="text/html" id="infobar">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
    </script>

    <script type="text/html" id="checkboxTpl">
        <!-- 这里的 checked 的状态只是演示 -->
        <input type="checkbox" name="lock" value="{{d.status}}" title="禁用" lay-filter="changeStatus" {{d.status == 0 ? 'checked' : ''}}>
    </script>

<script type="text/html" id="toolbar">
    <div class="layui-btn-container">
        <div class="layui-form-item">
            <div class="layui-input-inline">
                <input class="form-control" type="text" name="searchName" value="" placeholder='按用户名搜索' />
            </div>
            <button class="layui-btn layui-btn-sm" lay-event="search">搜索</button>
        </div>
    </div>

    </div>
</script>

<script>
    layui.use("table", function() {
        var table = layui.table
        ,form = layui.form;

        var tableIns = table.render({
            elem: "#info",
            url: "/admin/admin/data",
            method: "post",
            toolbar: '#toolbar',
            height: 'full',
            cols: [[
                { field: "id", title: "ID", sort: true },
                { field: "account", title: "账号" },
                { field: "email", title: "邮箱" },
                { field: "status", title: "状态",
                     templet: function(d){
                          return d.status ? '<span style="color:red">禁用</span>' : '启用';
                     }
                },
                { field: "create_time", title: "创建时间", minWidth: 160 },
                {
                    fixed: "right",width: 120,align: "center",toolbar: "#infobar",title: '操作'
                },
                 {field:'status', title:'是否禁用', templet: '#checkboxTpl', unresize: true}
             ]],
             page: true,
         })


        //监听工具条
        table.on("tool(info_filter)", function(obj) {
            var data = obj.data;
            if (obj.event === "edit") {
                var that = this;
                //多窗口模式，层叠置顶
                window.editindex = layer.open({
                    type: 2 //此处以iframe举例
                    ,title: '编辑管理员'
                    ,area: ['80%', '80%']
                    ,shade: 0.2
                    ,maxmin: false
                    ,offset: [
                    '100px', '10%'
                    ]
                    ,content: '/admin/admin/edit/id/' + data.id
                    ,btn: ['关闭']
                    ,yes: function() {
                    layer.close(window.editindex);
                    }

                    ,zIndex: layer.zIndex //重点1
                    ,success: function(layero){
                      layer.setTop(layero); //重点2
                    }
                });
            } else if (obj.event === "delete") {
                console.log(obj)
                layer.confirm("确认删除管理员" + data.account + " ？", function(index) {
                    $.ajax({
                        url: '/admin/admin/delete/id/' + data.id,
                        type: 'post',
                        dataType: 'json',
                        data: {

                        },
                        success: function(data) {
                            layer.msg(data.msg);
                            if (data.code == 0) {
                                 obj.del();
                                 window.reloadTableFunction();//1表示请求第一页
                            }
                        },
                        error: function() {
                             layer.msg('删除失败');
                        }
                    })
                    layer.close(index);
                });
            }
        });

        //监听锁定操作
        form.on('checkbox(changeStatus)', function(obj){
            console.log(obj,8888)
            var dom = $(this);
            console.log(dom,999)
            var id = parseInt($(this).parents('tr').first().find('td').eq(0).text());
            console.log(obj,666)

            $.ajax({
                url: '/admin/admin/status/id/' + id,
                type: 'post',
                dataType: 'json',
                data: {

                },
                success: function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg);
                        window.reloadTableFunction();
                    } else {
                        window.reloadTableFunction();
                    }
                },
                error: function() {
                    //状态修改失败
                    layer.msg('状态修改失败');
                    window.reloadTableFunction();
                }
             })
        });


        //重载数据表格
        window.reloadTableFunction = function reloadTable(page=false, search=[],done='') {
            var setting = {
                where: { //设定异步数据接口的额外参数，任意设

                }
            };
            if (search) {
                setting.where.search = new Array();
                for (var i in search) {
                    setting.where.search[i] = {
                        name: search[i].name,
                        type: search[i].type,
                        value: search[i].value,
                    }
                }
            }
            if (done) {
            console.log(done,444)
            setting.done = done;
            }
            if(page !== false) {
                setting.page = {
                    curr: page
                };
            }
            tableIns.reload(setting);
        }


           /* 头部搜索模板 */
        //工具栏事件
        table.on('toolbar(info_filter)', function(obj){
            switch(obj.event){
                case 'search':
                    var searchName = $('input[name="searchName"]').val();
                    layui.giveValue = new Array();
                    layui.giveValue['name'] = searchName;
                    window.reloadTableFunction(1, [{name: 'name', type: 'like', value: searchName}], layui.giveValueFunction);
                break;
            };
        });


    });


      layui.giveValueFunction = function giveValueFunction(){
        var name = layui.giveValue['name'];
        $('input[name="searchName"]').val(name);
      }


        //触发事件
        var active = {
            setTop: function(){
                var that = this;
                //多窗口模式，层叠置顶
                window.addindex = layer.open({
                    type: 2 //此处以iframe举例
                    ,title: '新建管理员'
                    ,area: ['80%', '80%']
                    ,shade: 0.2
                    ,maxmin: false
                    ,offset: [ //为了演示，随机坐标
                        '20%', '10%'
                    ]
                    ,content: '/admin/admin/add'
                    ,btn: ['关闭'] //只是为了演示
                    ,yes: function() {
                        layer.close(window.addindex);
                    }
                    ,zIndex: layer.zIndex //重点1
                    ,success: function(layero){
                        layer.setTop(layero); //重点2
                    }
                });
            }
        };

        $('.btn-layer').on('click', function(){
            var othis = $(this), method = othis.data('method');
            active[method] ? active[method].call(this, othis) : '';
        });
</script>
{{/block}}