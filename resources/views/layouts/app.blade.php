<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Index') - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="20x20" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    @vite(['resources/scss/app.scss'])
</head>
<body class="bg-gray-100 dark:bg-slate-900 pt-12 lg:pt-0">
    <x-header.main-nav />

    <header class="relative flex justify-start items-center py-7 border-b-2 border-blue-500 bg-blue-400 shadow-md dark:shadow-none">
        <x-container class="flex lg:flex-row flex-col justify-between gap-4 lg:gap-0 items-center">
            <div class="lg:w-1/2 w-full flex flex-col justify-center items-center lg:items-start">
                <span class="text-4xl font-semibold text-white text-center lg:text-left drop-shadow-lg">
                    Welcome,
                    <b @class([
                        'text-white' => !\Auth::check(),
                        'text-lime-500' => \Auth::user()?->isBoy(),
                        'text-rose-500' => \Auth::user()?->isGirl(),
                    ])>
                        {{ \Auth::check() ? \Auth::user()->username : 'guest' }}
                    </b>!
                </span>
                @auth
                    <div class="mt-2 flex gap-3 flex-wrap">
                        <x-ui.buttons.redirectable
                            href="#"
                            class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                        >
                            Join (Flash)
                        </x-ui.buttons.redirectable>
                        <x-ui.buttons.redirectable
                            href="#"
                            class="dark:bg-gray-500 bg-gray-500 border-gray-700 hover:bg-gray-400 dark:hover:bg-gray-400 dark:shadow-gray-700/75 shadow-gray-600/75 py-2 text-white"
                        >
                            Join (Nitro HTML5)
                        </x-ui.buttons.redirectable>
                    </div>
                @endauth
            </div>
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

    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    @vite(['resources/js/app.js'])
</body>
</html>
