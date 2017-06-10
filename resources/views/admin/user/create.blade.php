@extends('backend::layouts.app') @section('content')

    <div class="ibox float-e-margins">
        <form class="form-horizontal" method="post" action="{{ route('user.create') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="ibox-title">
                <h5>新建用户</h5>
                <div class="ibox-tools">
                    @include('admin.user.includes.box-tools')
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group"><label class="col-lg-2 control-label">Email</label>

                    <div class="col-lg-10">
                        <input type="email" placeholder="Email" class="form-control" name="email" value="">
                        <span class="help-block m-b-none">Example block-level help text here.</span>
                    </div>
                </div>
                <div class="form-group"><label class="col-lg-2 control-label">用户名</label>

                    <div class="col-lg-10"><input type="text" placeholder="用户名" class="form-control" name="name" value=""></div>
                </div>
                <div class="form-group"><label class="col-lg-2 control-label">密码</label>

                    <div class="col-lg-10">
                        <input type="password" placeholder="" class="form-control" name="password" value="000000">
                    </div>
                </div>
                <div class="form-group"><label class="col-lg-2 control-label">确认密码</label>

                    <div class="col-lg-10">
                        <input type="password" placeholder="" class="form-control" name="password_confirmation" value="000000">
                    </div>
                </div>
            </div>
            <div class="ibox-footer">

                <a class="btn btn-danger btn-xs" href="" onclick="javascript:history.go(-1)">Cancel</a>

                <span class="pull-right">
                          <input class="btn btn-success btn-xs" type="submit" value="Update">
                    </span>
            </div>
        </form>
    </div>

@stop


