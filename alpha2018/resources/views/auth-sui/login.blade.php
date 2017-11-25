@extends('backend::layouts.app_auth') @section('content')

<div class="panel panel-default"
	style="width: 350px; height: 500px; border: 1px solid #28a3ef; margin: 0 auto">
	<div class="panel-header"
		style="padding: 10px; border-bottom: 1px solid #28a3ef;">帐号登录</div>
	<div class="panel-content" style="padding: 10px;">
		<form class="sui-form form-horizontal sui-validate" role="form"
			method="POST" action="{{ url('auth/login') }}">
			{!! csrf_field() !!}
			<div class="control-group ">
				@if ($errors->has('email')||$errors->has('password'))
				<div class="sui-msg msg-error msg-clear help-block">
					<div class="msg-con">{{
						$errors->first('email').$errors->first('password') }}</div>
					<s class="msg-icon"></s>
				</div>
				@endif
			</div>
			<div
				class="control-group {{ $errors->has('email') ? ' error' : '' }}">
				<div class="input-prepend input-append">
					<span class="add-on"><i class="sui-icon icon-tb-my"></i></span> <input
						name="email" type="text" class="span2 input-fat"
						value="{{ old('email') }}" placeholder="邮箱/用户名/已验证手机"
						data-rules="required">
				</div>

			</div>


			<div
				class="control-group {{ $errors->has('password') ? ' error' : '' }}">
				<div class="input-prepend input-append">
					<span class="add-on"><i class="sui-icon icon-tb-lock"></i></span> <input
						name="password" type="password" class="span2 input-fat"
						data-rules="required">
				</div>

			</div>



			<div class="control-group">
				<label data-toggle="checkbox"
					class="checkbox-pretty inline {{ old('remember') ?  'checked' : ''}}">
					<input type="checkbox" name="remember"
					{{ old('remember') ? 'checked="checked"' : ''}}><span>自动登录</span>
				</label>


			</div>

			<div class="form-group">

				<button type="submit"
					class="sui-btn btn-block btn-xlarge btn-primary">
					<i class="fa fa-btn fa-sign-in"></i>登陆
				</button>

				<a class="btn btn-link" href="{{ url('password/email') }}">忘记密码?</a>

			</div>
		</form>
	</div>
	<div class="panel-footer">
		<a class="sui-btn btn-primary btn-link  pull-right"
			href="{{ url('/auth/register') }}">立即注册</a>
	</div>
</div>

@endsection
