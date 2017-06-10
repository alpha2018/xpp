@extends('backend::layouts.app') @section('content')

<section class="data-section">
	<h2>你的数据，源源不断</h2>
	<p>
		直至今日，很多参与方式还停留在原始的纸和笔的基础上，以及随之而来数据输入和存储成本。而有了金数据可以让填写者直接通过PC或移动设备完成数据提交，并生成数据和报表。从而大大提高生产力。
	</p>
	<table class="sui-table table-bordered">
		<thead>
			<tr>
				<th>＃</th>
				<th>待付款</th>
				<th>宝宝数量</th>
				<th>交易金额</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>所有交易</td>
				<td>9999.00</td>
				<td>999</td>
				<td>99999.00</td>
				<td><button href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small" data-loading-text="Loading..." onclick="load()">默认</button> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-primary">首要</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-success">成功</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-info">信息</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-warning">警告</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-danger">危险</a></td>
			</tr>
			<tr>
				<td>待付款</td>
				<td>9999.00</td>
				<td>999</td>
				<td>99999.00</td>
				<td><a href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small">默认</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-primary">首要</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-success">成功</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-info">信息</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-warning">警告</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-danger">危险</a></td>
			</tr>
			<tr>
				<td>已发货</td>
				<td>9999.00</td>
				<td>999</td>
				<td>99999.00</td>
				<td><a href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small">默认</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-primary">首要</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-success">成功</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-info">信息</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-warning">警告</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-danger">危险</a></td>
			</tr>
			<tr>
				<td>已成功</td>
				<td>9999.00</td>
				<td>999</td>
				<td>99999.00</td>
				<td><a href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small">默认</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-primary">首要</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-success">成功</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-info">信息</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-warning">警告</a> <a
					href="javascript:void(0);"
					class="sui-btn btn-bordered btn-small btn-danger">危险</a></td>
			</tr>
		</tbody>
	</table>
</section>

<section class="data-section text-align-center center-block">
	<div class="container sui-container">
		<div class="section-text">
			<h2>你的数据，源源不断</h2>
			<p>
				直至今日，很多参与方式还停留在原始的纸和笔的基础上，以及随之而来数据输入和存储成本。而有了金数据可以让填写者直接通过PC或移动设备完成数据提交，并生成数据和报表。从而大大提高生产力。
			</p>
		</div>
		<img
			src="https://gd-prod-assets.b0.upaiyun.com/assets/site/home/data-6f6f938d04898b297d14c7276537f0d8.png"
			alt="Data" style="width: 80%">
	</div>
</section>
<script>

function load(){

	loding.load();
	setTimeout(function(){
		loding.close();
		}, 2000);

	
}

</script>
@endsection
