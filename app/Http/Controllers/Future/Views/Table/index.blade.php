@extends('layouts.app_pjax') @section('content')

<div class="table-section">
	<div class="container">
		<div class="section-text">
			<h2>金数据 人人可用的数据平台</h2>
			<p>从超大规模的银行，到小的金融互联网创业团队；从保险、证券、物流等大型公司，到电台，旅行等创业团队； 金数据已经悄然间无处不在</p>
		</div>
		<table class="table table-hover table-condensed table-bordered">
			<caption>Optional table caption.</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Username</th>
					<th>method</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">1</th>
					<td>Mark</td>
					<td>Otto</td>
					<td>@mdo</td>
					<td>@twitter</td>
				</tr>
				<tr>
					<th scope="row">2</th>
					<td>Jacob</td>
					<td>Thornton</td>
					<td>@fat</td>
					<td>@twitter</td>
				</tr>
				<tr>
					<th scope="row">3</th>
					<td>Larry</td>
					<td>the Bird</td>
					<td>@twitter</td>
					<td>
						<button data-loading-text="loding..." type="button" class="btn btn-default btn-xs" onclick="edit()">编辑</button>
						<button data-loading-text="loding..." type="button" class="btn btn-default btn-xs" onclick="edit()">编辑</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script>

jsConfig.push('tmp');

</script>

<div class="hidden" id="template">
<form id="">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" Value="@{{d.name}}">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" Value="@{{d.password}}">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
@endsection
