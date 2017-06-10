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
<form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
    <input type="hidden"  name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile" name="file">
        <p class="help-block">Example block-level help text here.</p>
    </div>

    <button type="submit" class="btn btn-default">Submit</button>
</form>

<img src="/image/test">

</body>
</html>