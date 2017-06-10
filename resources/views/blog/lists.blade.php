@extends('layouts.blog')@section('title', 'Page Title')

@section('content')
@foreach($posts as $post)
<div class="blog-post">
	<h2 class="blog-post-title"><a href="/post/{{ $post['slug'] }}">{{ $post['title'] }}</a></h2>
	<p class="blog-post-meta">
		December 14, 2013 by <a href="#">Chris</a>
	</p>

	<p>{{ $post['content'] }}</p>
</div>
<!-- /.blog-post -->
@endforeach
<nav class="">

		{!! $posts->render() !!}
		{{--<li><a href="#">Older</a></li>--}}
		{{--<li class="disabled"><a href="#">Newer</a></li>--}}

</nav>
<!-- /.blog-post -->
@endsection
