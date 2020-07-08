<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{--csrf token--}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title',config('app.name'))</title>

  {{--css样式,mix()会根据webpack.mix.js来配置css的链接,这里主要是为了解决浏览器缓存问题--}}
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">



</head>
<body>
<div id="app" class="{{ route_class() }}-page">

  @include('layouts._header')

  <div class="container">
    {{--消息提示--}}
    @include('share.message')

    @yield('content')

  </div>

  @include('layouts._footer')

</div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
@yield('js')
</html>
