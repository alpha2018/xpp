
<div class="sui-navbar">

  <div class="navbar-inner"><a href="#" class="sui-brand">SUI</a>
    <ul class="sui-nav nav">
      <li class="active"><a href="#">首页</a></li>
      <li><a href="#">组件</a></li>
      <li class="sui-dropdown"><a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">其他 <i class="caret"></i></a>
        <ul role="menu" class="sui-dropdown-menu">
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">关于</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">版权申明</a></li>
        </ul>
      </li>
    </ul>
    <form class="sui-form sui-form pull-left">
      <input type="text" placeholder="宝贝/店铺名称...">
      <button class="sui-btn">搜索</button>
    </form>
    <ul class="sui-nav pull-right">
      
      
      
      <!-- Authentication Links -->
				@if (Auth::guest())
				<li><a href="{{ url('/auth/login') }}">登录</a></li>
				<li><a href="{{ url('/auth/register') }}">注册</a></li> @else
				<li class="sui-dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown" role="button" aria-expanded="false"> {{
						Auth::user()->name }} <span class="caret"></span>
				</a>

					<ul class="sui-dropdown-menu" role="menu">
						<li><a href="#">个人中心</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ url('/auth/logout') }}"><i
								class="fa fa-btn fa-sign-out"></i>退出</a></li>
					</ul></li> @endif
					<li><a href="#">帮助</a></li>
    </ul>
  </div>
</div>
