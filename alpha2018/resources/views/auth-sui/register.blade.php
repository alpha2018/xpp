@extends('backend::layouts.app_auth') @section('content')

<div class="panel panel-default"
	style="width: 100%; height: 100%; border: 1px solid #28a3ef; margin: 0 auto">
	<div class="panel-heading"
		style="padding: 10px; border-bottom: 1px solid #28a3ef;">个人注册</div>
	<div class="panel-body" style="padding: 10px;">


		<form class="sui-form form-horizontal sui-validate" method="POST"
			action="{{ url('auth/register') }}">
			{!! csrf_field() !!}
			<div class="control-group ">
				@if ($errors->has('email')||$errors->has('password')||$errors->has('name'))
				<div class="sui-msg msg-error msg-clear help-block">
					<div class="msg-con">{{
						$errors->first('email').$errors->first('password').$errors->first('name') }}</div>
					<s class="msg-icon"></s>
				</div>
				@endif
			</div>
			<div class="control-group">
				<label for="inputName" class="control-label">用户名：</label>
				<div class="controls">
					<input type="text" id="inputName" name="name" placeholder="用户名"
						data-rules="required|minlength=4|maxlength=16">
				</div>
			</div>
			<div class="control-group">
				<label for="inputEmail" class="control-label">邮箱：</label>
				<div class="controls">
					<input type="text" id="inputEmail" name="email" placeholder="邮箱"
						data-rules="required|email">
				</div>
			</div>
			<div class="control-group">
				<label for="inputPassword" class="control-label">密码：</label>
				<div class="controls">
					<input type="password" id="inputPassword" name="password"
						placeholder="密码" data-rules="required|minlength=6|maxlength=16" title="密码">
				</div>
			</div>
			<div class="control-group">
				<label for="inputRepassword" class="control-label">重复密码：</label>
				<div class="controls">
					<input type="password" id="inputRepassword" name="password_confirmation"
						placeholder="重复密码" data-rules="required|match=password">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls">
					<button type="submit" class="sui-btn btn-primary">立即注册</button>
				</div>
			</div>
		</form>

	</div>
</div>



@endsection
