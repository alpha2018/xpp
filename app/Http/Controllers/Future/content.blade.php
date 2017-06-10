@extends('layouts.app') @section('content')
    <section class="data-section">
        <h2>@@title@@</h2>
        <p>sui前端组件库+vue库+laravel框架实现</p>
        <form class="sui-form form-dark" method="get">

            <div class="input-control">
                <input type="text" class="input-medium" name="kw"><i class="sui-icon icon-touch-magnifier"></i>
                <button type="submit" class="sui-btn btn-primary btn-">Search</button>
            </div>

        </form>
        <table class="sui-table table-bordered table-hover">

            <thead>
            @@thead@@
            </thead>
            <tbody>
            @@tbody@@

            </tbody>
        </table>
        <div class="sui-pagination">
            @@pager@@
        </div>

        <!- dialog ->
        <div id="J_Dialog" tabindex="-1" role="dialog"
             class="sui-modal hide fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true"
                                class="sui-close">×
                        </button>
                        <h4 id="myModalLabel" class="modal-title">供应商收编</h4>
                    </div>
                    <div class="modal-body sui-form form-horizontal">
                        <div class="sui-msg msg-block msg-default msg-tips">
                            <div class="msg-con">以下为供销平台上已经获得小二授权经营您的品牌但还未被您进行收编的供应商</div>
                            <s class="msg-icon"></s>
                        </div>

                        <form id="user_form"
                              class="ui-form form-horizontal
		sui-validate" role="form">
                            <input type="hidden" name="id" value="">
                            <div class="control-group">
                                <label for="inputName" class="control-label">用户名：</label>
                                <div class="controls">
                                    <input type="text" id="inputName" name="name" placeholder="用户名"
                                           data-rules="required|minlength=4|maxlength=16" Value="">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-/dialog ->

    </section>

    @@javascript@@

    <script>
        function ajaxDel(_this) {
            if (!confirm('是否确认删除？')) {
                return false;
            }

            var id = $(_this).attr('data-id')
            console.log(_this);

            console.log(id);

            $.ajax({
                url: '$this->pathInfo/' + id,
                type: 'POST',
                headers: {
                    'X-HTTP-Method-Override': 'DELETE',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {},
                beforeSend: function () {
                    loding.load();
                },
                success: function (res) {

                    if (res.code == 200) {
                        location.replace(document.URL);
                    }

                },
                complete: function () {
                    loding.close();
                }
            });
        }
    </script>
@endsection