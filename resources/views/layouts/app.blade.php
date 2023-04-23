<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/scss/app.scss'])
</head>
<body class="bg-gray-100 dark:bg-slate-950">
    <header class="relative min-h-[--header-height] border-b-2 dark:border-slate-800 border-blue-500 dark:bg-slate-900 bg-blue-400 shadow-lg dark:shadow-none">
        <div class="w-full h-2 bg-blue-400"></div>
        <nav class="w-full h-16 bg-white border-b-2 border-gray-200 shadow">

        </nav>
        <x-container>
            <div class="w-full flex flex-col lg:flex-row gap-4 py-8">

                <x-header.header-box
                    title="Last Registered Users"
                    description="The last 15 to register at Hotel"
                    icon="big users"
                >
                    @for ($i = 0; $i < 18; $i++)
                        <div
                            data-tippy-singleton
                            data-tippy-content="<small><strong>{{ \Arr::random(['ferraz', 'nick', 'joelma', 'sail', 'laravel']) }}</strong></small>"
                            data-tippy-placement="bottom"
                            class="dark:bg-slate-950 shadow-md dark:shadow-none bg-white border dark:border-slate-800 border-blue-400 rounded-lg flex justify-center items-center bg-no-repeat bg-center w-[50px] h-[50px]"
                            style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=ferrazmatheus&direction=2&head_direction=2&size=m&headonly=1')"
                        ></div>
                    @endfor
                </x-header.header-box>

                <x-header.header-box
                    title="Last Hotel Articles"
                    icon="big comment"
                    extra-box-classes="grid grid-cols-1 lg:grid-cols-2 grid-rows-2"
                    button-label="View all"
                    button-classes="dark:bg-green-600 bg-orange-500 hover:bg-orange-400 dark:hover:bg-green-500 text-white shadow-lg dark:shadow-green-700/75 shadow-orange-600/75"
                >
                    @php
                        $images = [
                            'https://images.habbo.com/c_images/Top_Story_Images/BR_TopStory_zodiaco_01.gif',
                            'https://images.habbo.com/c_images/Top_Story_Images/ts_runway_01.gif',
                            'https://static.wikia.nocookie.net/habbo/images/1/1d/Habbohood_2011_Topstory.png/revision/latest?cb=20110619121215&path-prefix=pt',
                            'https://www.habbobites.com/uploads/1568a6791c45b3_kmnqgjhoflipe.png'
                        ];
                    @endphp
                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="dark:bg-slate-950 border shadow-md dark:shadow-none dark:border-slate-800 bg-white border-blue-400 rounded-lg p-1"
                            data-tippy-singleton
                            data-tippy-content="<small>Posted by <strong>{{ \Arr::random(['ferraz', 'nick', 'joelma', 'sail', 'laravel']) }}</strong><br>A minute ago</small>"
                            data-tippy-placement="bottom"
                        >
                            <div class="relative flex justify-start items-center bg-center bg-no-repeat w-full h-10 rounded-lg" style="background-image: url('{{ $images[$i] }}')">
                                <div class="w-full h-full bg-black absolute bg-opacity-50 rounded-lg"></div>
                                <a class="font-semibold relative text-white truncate w-full p-2 text-sm" href="#">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                </a>
                            </div>
                        </div>
                    @endfor
                </x-header.header-box>
                <x-header.header-box />
            </div>
        </x-container>
    </header>
    <main>
        @yield('content')
    </main>
    @vite(['resources/js/app.js'])
</body>
</html>
