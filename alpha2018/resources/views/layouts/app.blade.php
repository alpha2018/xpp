<!DOCTYPE html>
<html lang="zh">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('backend.name', '后台管理界面') }}</title>

	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

	<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

	<!-- Styles -->
	@yield('before-styles')

	@yield('after-styles')

</head>

<body>

	<div id="wrapper">

		<!-- #section:basics/navbar -->
		@include('backend::layouts.basics.navbar')
		<!-- /section:basics/navbar -->
		</div>

		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<!-- #section:basics/nav -->
				@include('backend::layouts.basics.nav')
				<!-- /section:basics/nav -->
			</div>
			<div class="row wrapper border-bottom white-bg page-heading">
				<!-- #section:basics/breadcrumb -->
				@include('backend::layouts.basics.breadcrumb')
				<!-- /section:basics/breadcrumb -->
			</div>

			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-12">
						@include('includes.partials.messages')
						@yield('content')
					</div>
				</div>
			</div>
			<div class="footer">
				<div class="pull-right">
					10GB of <strong>250GB</strong> Free.
				</div>
				<div>
					<strong>Copyright</strong> Example Company &copy; 2014-2017
				</div>
			</div>

		</div>
	</div>

	<!-- Mainly scripts -->
	<script src="{{ asset('assets/js/jquery-2.1.1.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

	<!-- Custom and plugin javascript -->
	<script src="{{ asset('assets/js/inspinia.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/pace/pace.min.js') }}"></script>

	<script src="//cdn.bootcss.com/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
	<script>
	//$(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax-container')
//

	</script>

	<script>
    /*
     * 初始化按钮的loading功能，点击后将显示Loading字样，并且按钮被disabled掉，无法连续点击，防止二次提交
     * 超过3秒后按钮将恢复原状
     */
    $(document).on('click','button[data-loading-text]',function () {
        //var btn = $(this).button('loading');
        var btn = $(this).attr('disabled','disabled')
        setTimeout(function () {
            btn.button('reset');
        	//var btn = $(this).attr('disabled','')
        }, 1000);
    });
    </script>
	<!-- JavaScripts -->
	@yield('before-scripts')

	@yield('after-scripts')

	<script>
		$(document).ready(function () {
			//console.log(window.location.pathname);

			var pathname = window.location.pathname;

			$('ul.nav > li').each(function () {
				console.log();
				var href = $(this).children().attr('href');

				//var text = $(this).children().text();

				if (href == pathname && href !== undefined) {
					$(this).addClass('active');

					var ul = $(this).parent();

					if(ul.hasClass('nav-second-level')){
						ul.addClass('in');
						var parentLi = ul.parent();
						parentLi.addClass('active');
					}
				}

			});
		});
	</script>
</body>
</html>
