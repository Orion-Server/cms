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
<body class="bg-gray-100 dark:bg-slate-950">
    @guest
        <x-header.guest-nav />
    @endguest
    <header class="relative flex justify-center items-center py-5 border-b-2 dark:border-slate-800 border-blue-500 dark:bg-slate-900 bg-blue-400 shadow-md dark:shadow-none">
        <x-header.main-nav />
    </header>
    <main>
        @yield('content')
    </main>
    @vite(['resources/js/app.js'])
</body>
</html>
