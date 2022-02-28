<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('clinic.app-name'))</title>
    @yield('head')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body class="tw-font-primary">
@yield('navbar',\View::make('partials.navbar'))
{{--@include('partials.navbar')--}}
@yield('body')

</body>
<script src="{{asset('js/app.js')}}"></script>
@yield('script')
@stack('child-script')
