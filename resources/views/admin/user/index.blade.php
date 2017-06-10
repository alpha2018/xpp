        
@extends('backend::layouts.app') @section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Basic Data Tables example with responsive plugin</h5>
            <div class="ibox-tools">
                @include('admin.user.includes.box-tools')
            </div>
        </div>
        <div class="ibox-content">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>确认</th>
                        <th>角色</th>
                        <th>创建时间</th>
                        <th>登录时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>确认</th>
                        <th>角色</th>
                        <th>创建时间</th>
                        <th>登录时间</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@stop

@section('after-styles')
    <link href="{{ asset('assets/css/plugins/dataTables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/dataTables/jquery.dataTables.min.css') }}" rel="stylesheet">

    @stop

@section('after-scripts')
    <script src="assets/js/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/dataTables/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
    $(document).ready(function(){
        console.log('a');
        $('.dataTables-example').DataTable({
            //autoWidth: false,
            //scrollX: true,
            pageLength: 25,
            //responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('user.all') }}',
                type: 'post',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                data: {status: 1, trashed: false}
            },
            columns: [
                {data: 'id', name: 'users.id'},
                {data: 'name', name: 'users.name', render: $.fn.dataTable.render.text()},
                {data: 'email', name: 'users.email', render: $.fn.dataTable.render.text()},
                {data: 'confirmed', name: 'users.confirmed_at'},
                {data: 'roles', name: 'roles.name', sortable: false},
                {data: 'created_at', name: 'users.created_at'},
                {data: 'actived_at', name: 'users.actived_at'},
                {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ],
            order: [[0, "asc"]],
            searchDelay: 500

        });
    });

    </script>
    <script src="/assets/js/plugins/layer/layer.js"></script>
    <script>
        function addDeleteForms(){
            $("[data-method]").append(function(){
                return !$(this).find("form").length>0 ?
                "\n<form action='"+$(this).attr("href")+"' method='POST' name='delete_item' style='display:none'>\n   " +
                "<input type='hidden' name='_method' value='"+$(this).attr("data-method")+"'>\n   " +
                "<input type='hidden' name='_token' value='"+$('meta[name="csrf-token"]').attr("content")+"'>\n</form>\n" : ""
            }).removeAttr("href").attr("style","cursor:pointer;").attr("onclick",'$(this).find("form").submit();')
        }

        $(document).ajaxComplete(function(){addDeleteForms()});

        $("body").on("submit","form[name=delete_item]",function(e){
            e.preventDefault();
            var t=this,
                    n=$('a[data-method="delete"]'),
                    r=n.attr("data-trans-button-cancel")?n.attr("data-trans-button-cancel"):"Cancel",
                    i=n.attr("data-trans-button-confirm")?n.attr("data-trans-button-confirm"):"Yes, delete",
                    o=n.attr("data-trans-title")?n.attr("data-trans-title"):"Warning";
            n.attr("data-trans-text")?n.attr("data-trans-text"):"Are you sure you want to delete this item?";

            layer.confirm('你确定要删除这条记录吗？', {
                title: '警告',
                btn: ['确认','取消'] //按钮
            }, function(index){
                t.submit();
                layer.close(index);
            }, function(){

            });
        });
    </script>
    @stop
