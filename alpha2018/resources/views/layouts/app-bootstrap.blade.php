<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<title>back</title>
{{--<link href="http://g.alicdn.com/sj/dpl/1.5.1/css/sui.min.css"
	rel="stylesheet">--}}
	<!-- bootstrap -->
	<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="//cdn.bootcss.com/metisMenu/2.5.2/metisMenu.min.css" rel="stylesheet">


<script type="text/javascript"
	src="http://g.alicdn.com/sj/lib/jquery/dist/jquery.min.js"></script>
{{--<script type="text/javascript"
	src="http://g.alicdn.com/sj/dpl/1.5.1/js/sui.min.js"></script>--}}
	<script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>

	<!-- bootstrap -->
	<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<script src="//cdn.bootcss.com/metisMenu/2.5.2/metisMenu.min.js"></script>



	<style type="text/css">
		/*css ie6最小高度
        min-height最小高度的实现（兼容IEie6/7/8/9、FF） */
		div.sidebar{

			width: 110px !important;
		}
		div.content{
			margin-left: 120px !important;

		}
	</style>

	<style type="text/css">
		.sidebar {
			display: block;
			float: left;
			width: 250px;
			background: #333;
		}
		.content {
			display: block;
			overflow: hidden;
			width: auto;
		}
		.sidebar-nav {
			border-bottom: 1px solid rgba(0, 0, 0, 0.3);
			background-image: -webkit-linear-gradient(left, color-stop(#333333 10px), color-stop(#222222 10px));
			background-image: linear-gradient(to right, #333333 10px, #222222 10px);
			background-repeat: repeat-x;
			filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ff333333', endColorstr='#ff222222', GradientType=1);
		}
		.sidebar-nav ul {
			padding: 0;
			margin: 0;
			list-style: none;
		}
		.sidebar-nav a, .sidebar-nav a:hover, .sidebar-nav a:focus, .sidebar-nav a:active {
			outline: none;
		}
		.sidebar-nav ul li, .sidebar-nav ul a {
			display: block;
		}
		.sidebar-nav ul a {
			padding: 10px 20px;
			color: #aaa;
			border-top: 1px solid rgba(0, 0, 0, 0.3);
			box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.05) inset;
			text-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5);
		}
		.sidebar-nav ul a:hover, .sidebar-nav ul a:focus, .sidebar-nav ul a:active {
			color: #fff;
			text-decoration: none;
		}
		.sidebar-nav ul ul a {
			padding: 10px 30px;
			background-color: rgba(255, 255, 255, 0.1);
		}
		.sidebar-nav ul ul a:hover, .sidebar-nav ul ul a:focus, .sidebar-nav ul ul a:active {
			background-color: rgba(255, 255, 255, 0.2);
		}
		.sidebar-nav-item {
			padding-left: 5px;
		}
		.sidebar-nav-item-icon {
			padding-right: 5px;
		}
		#rtlh3 small {
			transform: rotateY(180deg);
			display: inline-block;
		}
	</style>

</head>
<body id="app-layout">

	<div id="wrapper">

		<!-- #section:basics/navbar -->
		@include('backend::layouts.basics.navbar')
		<!-- /section:basics/navbar -->
		</div>

		<div >
			<!-- #section:basics/navbar -->

		<!-- /section:basics/navbar -->
		</div>


		<div class="clearfix">
			<!-- #section:basics/sidebar -->
			@include('backend::layouts.basics.sidebar')
			<!-- /section:basics/sidebar -->

			{{--<section class="content">--}}
				{{--<div class="col-xs-12">--}}
					{{--<h3>Auto Collapse--}}
						{{--<small>default</small>--}}
					{{--</h3>--}}
					{{--<div class="panel panel-default">--}}
						{{--<div class="panel-heading">--}}
							{{--Code--}}
							{{--<span class="pull-right"> <span class="fa fa-code"></span> </span>--}}
						{{--</div>--}}
						{{--<div class="panel-body">--}}


						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}

			{{--</section>--}}

				<div class="content" style="" id="pjax-container">
					@yield('content')

				</div>
		</div>


		<div class="sui-layout" id="layout-center">
			<div class="sui-container">
				<div class="sidebar sidebar-pjax" style="">

				</div>


				{{--
				<div class="sidebar">@include('layouts.basics.sidebar')</div>
				--}}
			</div>
		</div>



		<div class="footer" style="">
			<div class="sui-container">
				<!-- #section:basics/footer -->
				{{--@include('layouts.basics.footer')--}}
				<!-- /section:basics/footer -->
			</div>
		</div>
	</div>
	<!-- metisMenu -->
	<script>
		$(function () {
			$('#menu').metisMenu();
		});
	</script>
	<script>
 	$(document).ready(function () {
		$('ul.sidebar > li').click(function (e) {
			//e.preventDefault();
			$('ul.sidebar > li').removeClass('active');
			$(this).addClass('active');
		});
		$('ul.nav > li').click(function (e) {
			//e.preventDefault();
			$('ul.nav > li').removeClass('active');
			$(this).addClass('active');
		});

	});

	$(document).ready(function () {
		//console.log(window.location.pathname);

		var pathname = window.location.pathname;

		$('ul.sidebar > li').each(function () {
			console.log();
			var href = $(this).children().attr('href');

			//var text = $(this).children().text();

			if (href == pathname && href !== undefined) {
				$(this).addClass('active');
			}
		});
	});
	$(document).ready(function () {
		var s = urlArgs();

		if(!s){
			return false;
		}

		$.each(s, function (k, v) {
			$('input[name=' + k + ']').val(v);
		});

		var kw = s['kw'];
		console.log(kw);

		//console.log(kw);
		//var regText = kw;
		//var regS = new RegExp(regText,'gi');

		$('table > tbody td').each(function(){
			var text = $(this).text();
			//console.log(text);
			if(text != null && kw.trim() !='' && text != ''){
				if(text.indexOf(kw)  > -1){	//indexOf()对大小写敏感
					text = text.replace(eval('/'+kw+'/g'),'<span style="color:red">'+kw+'</span>');
					//text = text.replace(regS,'<span style="color:red">'+kw+'</span>');
					//console.log(text);
					$(this).html(text);
				}
			}
		});
	});

	function urlArgs() {
		var args = {};   //定义一个空对象
		var query = location.search.substring(1);//查找到查询串，并去掉‘？’
		var pairs = query.split('&');//根据”&”符号将查询字符串分隔开
		console.log(pairs.length);
		if(pairs.length < 1){
			return false;
		}
		for (var i = 0; i < pairs.length; i++) {    //对于每个片段
			var pos = pairs[i].indexOf('=');    //查找”name=value”
			if (pos == -i) continue;  //如果没有找到的话，就跳过
			var name = pairs[i].substring(0, pos); //ll提取name
			var value = pairs[i].substring(pos + 1); //ll提取value
			value = decodeURIComponent(value);    //／//／对value进行解码
			args[name] = value;   //／／存储为属性
		}
		return args;    //／／返回解析后的参数
	}

	//console.log(document.domain);
	</script>

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
    

	{{--<script>
	var loding = {};
	
	var div = document.createElement("div");
	
	div.setAttribute('id','loading');
	
	document.body.appendChild(div).innerHTML='<div id="loading-mask"></div><div class="sui-loading "id="loading-spin"> </div>';
	
	loding.load = function(){
		document.getElementById('loading-mask').style.cssText ='position: fixed; left: 0; top: 0; width: 100%; height: 100%; z-index: 20000; filter: alpha(opacity = 0); -moz-opacity: 0; -khtml-opacity: 0; opacity: 0;';
		document.getElementById('loading-spin').style.cssText ='position: fixed; top: 42%; left: 50%; z-index: 99999;';
		document.getElementById('loading-spin').innerHTML='<i class="sui-icon icon-pc-loading"></i> ';
	}
	loding.close = function(){
		document.getElementById('loading-mask').style.cssText ='';
		document.getElementById('loading-spin').style.cssText ='';
		document.getElementById('loading-spin').innerHTML='';
	}
    </script>--}}
    <script src="/plugins/layer/layer.js"></script>
    <script>
    var loding = {};
    loding.load = function(){
    	layer.load(2);
    }
    loding.close = function(){
    	layer.closeAll('loading');
    }
    </script>


</body>
</html>
