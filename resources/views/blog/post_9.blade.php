@extends('layouts.blog')
@section('content')
    <div class="blog-post">
        <h2 class="blog-post-title"><a href="/post/{{ $post['slug'] }}">{{ $post['title'] }}</a></h2>
        <p class="blog-post-meta">
            December 14, 2013 by <a href="#">Chris</a>
        </p>

        <p>{{ $post['content'] }}</p>
        <textarea id="text-input" oninput="this.editor.update()"
                  rows="6" cols="60">Type **Markdown** here.</textarea>
        <div id="preview"> </div>
    </div>
@endsection

@section('after-scripts')
    <script src="https://cdn.bootcss.com/markdown.js/0.6.0-beta1/markdown.min.js"></script>
    <script>
        function Editor(input, preview) {
            this.update = function () {
                preview.innerHTML = markdown.toHTML(input.value);
            };
            input.editor = this;
            this.update();
        }
        var $ = function (id) { return document.getElementById(id); };
        new Editor($("text-input"), $("preview"));
    </script>
@stop