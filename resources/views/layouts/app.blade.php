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

    <title>{{ config('app.name') }} - @yield('title', 'Index')</title>

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
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />

    @include('partials.js-parities')

    @if(Auth::check() && $unsupportedFlashClient)
        <script>
            document.addEventListener('alpine:init', () => {
                window.notyf.error('Your browser does not support Flash.', 8000)
            });
        </script>
    @endif

    @vite(['resources/scss/app.scss'])
</head>
<body class="pt-12 lg:pt-0 overflow-x-hidden">
    @if(!! getSetting('maintenance'))
        <span class="w-full h-12 flex justify-center items-center bg-red-500 text-red-800 font-bold">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>
            {{ __('The hotel is currently in maintenance mode.') }}
        </span>
    @endif

    @include('pages.users.fragments.change-username')

    <x-header.main-nav />

    <header @class([
        "relative pt-7 border-b border-slate-300 dark:border-slate-800 bg-blue-400 shadow-md dark:shadow-none bg-center bg-no-repeat-y",
        'h-[240px] lg:h-[180px] border-b-4 border-white' => ! Auth::check(),
        'h-[300px] lg:h-[240px]' => Auth::check(),
    ]) style="background-image: url({{ $headerBackground }})">
        <x-container class="flex flex-col lg:flex-row items-center justify-around h-full">
            <div class="flex flex-col gap-2 lg:gap-5">
                <div style="--logo-width: {{ $logoSize[0] }}px; --logo-height: {{ $logoSize[1] }}px; background-image: url({{ $logo }})" class="logo bg-center bg-no-repeat"></div>
                <div class="onlines-count bg-white w-auto px-4 rounded-lg h-10 relative dark:bg-gray-950 flex items-center justify-center">
                    <div class="absolute h-2 w-2 bg-white dark:bg-gray-950 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                    <span class="text-sm dark:text-slate-100">{{ __(":c connected habbo's", ['c' => User::whereOnline('1')->count()]) }}</span>
                </div>
            </div>
            @auth
            <div class="flex flex-col gap-2 lg:gap-4 items-start lg:min-w-[525px]">
                <x-header.user-box />
                @include('pages.users.fragments.user.client-buttons')
            </div>
            @endauth

            @guest
                <x-header.auth-nav />
            @endguest
        </x-container>
    </header>

    @auth
        @include('pages.users.fragments.user.balances')
    @endauth

    <main class="mt-4">
        @yield('content')
    </main>

    @include('layouts.footer')
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
