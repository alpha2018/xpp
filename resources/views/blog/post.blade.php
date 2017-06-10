@extends('layouts.blog')
@section('content')
    <div class="blog-post">
        <iframe src="http://jbt.github.io/markdown-editor/" width="100%" height="100%"></iframe>
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