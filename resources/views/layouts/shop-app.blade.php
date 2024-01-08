<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="turbolinks-cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="{{ config('hotel.meta.author') }}">
    <meta name="title" content="{{ config('hotel.meta.title') }}">
    <meta name="description" content="{{ config('hotel.meta.description') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Shop') }} - {{ config('app.name') }}</title>

    <meta name="keywords" content="{{ config('hotel.meta.keywords') }}">
    <meta name="rating" content="Geral">
    <meta name="robots" content="index,follow">

    <meta property="og:title" content="{{ config('hotel.meta.title') }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image" content="{{ asset(config('hotel.meta.image')) }}">

    <meta name="theme-color" content="#478dde">
    <meta name="msapplication-navbutton-color" content="#478dde">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{ config('hotel.meta.twitter') }}">
    <meta name="twitter:title" content="{{ config('hotel.meta.title') }}">
    <meta name="twitter:description" content="{{ config('hotel.meta.description') }}">

    <meta name="twitter:image" content="{{ asset(config('hotel.meta.image')) }}" />

    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="20x20" type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    @vite(['resources/scss/app.scss'])
</head>
<body class="shop">
    <main>
        @yield('content')
    </main>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
