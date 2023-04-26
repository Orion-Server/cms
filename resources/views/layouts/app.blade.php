<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @vite(['resources/scss/app.scss'])
</head>
<body class="bg-gray-100 dark:bg-slate-900">
    <x-header.main-nav />

    <header class="relative flex justify-start items-center py-5 border-b-2 border-blue-500 bg-blue-400 shadow-md dark:shadow-none">
        <x-container class="flex lg:flex-row flex-col justify-around gap-4 lg:gap-0 items-center">
            <span class="text-4xl font-semibold text-white drop-shadow-lg">Welcome, <b class="text-slate-200">guest</b>!</span>
            <x-header.user-box />
        </x-container>
    </header>

    @guest
        <x-header.auth-nav />
    @endguest

    <main>
        @yield('content')
    </main>
    @vite(['resources/js/app.js'])
</body>
</html>
