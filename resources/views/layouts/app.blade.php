<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="20x20" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @vite(['resources/scss/app.scss'])
</head>
<body class="bg-gray-100 dark:bg-slate-900 pt-12 lg:pt-0">
    <x-header.main-nav />

    <header class="relative flex justify-start items-center py-5 border-b-2 border-blue-500 bg-blue-400 shadow-md dark:shadow-none">
        <x-container class="flex lg:flex-row flex-col justify-between gap-4 lg:gap-0 items-center">
            <span class="text-4xl lg:w-1/2 w-full text-center font-semibold text-white drop-shadow-lg">
                Welcome,
                <b @class([
                    'text-white' => !\Auth::check(),
                    'text-blue-300' => \Auth::user()?->isBoy(),
                    'text-pink-300' => \Auth::user()?->isGirl(),
                ])>
                    {{ \Auth::check() ? \Auth::user()->username : 'guest' }}
                </b>!
            </span>
            <x-header.user-box />
        </x-container>
    </header>

    @guest
        <x-header.auth-nav />
    @endguest

    <main class="mt-4">
        @yield('content')
    </main>

    @include('layouts.footer')
    @vite(['resources/js/app.js'])
</body>
</html>
