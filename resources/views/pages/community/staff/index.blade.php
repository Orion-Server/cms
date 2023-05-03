@extends('layouts.app')

@php($boxes = ['Orion Staff', 'Subscriptions', 'Identifications'])
@php($icons = ['hotel', 'comment', 'articles'])

@section('content')
    <x-container class="flex justify-between flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/4 h-auto flex flex-col gap-4">
            @foreach($boxes as $item)
            <div>
                <x-title-box
                    icon="{{ $icons[random_int(0, 2)] }}"
                    title="{{ $item }}"
                    description="This is customizable"
                />
                <div class="mt-4 p-4 text-xs font-medium dark:text-slate-200 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                    {{ fake()->sentence(random_int(10, 50)) }}
                </div>
            </div>
            @endforeach
        </div>
        <div class="w-full lg:w-3/4 flex flex-col gap-4">
            <div class="w-full h-auto flex lg:flex-row flex-wrap gap-2">
                <x-ui.buttons.redirectable
                    class="dark:bg-gray-500 bg-gray-500 border-gray-700 hover:bg-gray-400 dark:hover:bg-gray-400 dark:shadow-gray-700/75 shadow-gray-600/75 py-2 text-white"
                >
                    All
                </x-ui.buttons.redirectable>
                @foreach (['Founders', 'Developers', 'Managers', 'Administrators', 'Moderators', 'Helpers'] as $item)
                <x-ui.buttons.redirectable
                    class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                >
                    {{ $item }}
                </x-ui.buttons.redirectable>
                @endforeach
            </div>
            <div class="flex flex-col gap-8">
                @foreach (['Founders', 'Developers', 'Managers', 'Administrators', 'Moderators', 'Helpers'] as $item)
                    <div class="w-full rounded-lg shadow-lg">
                        <div class="w-full bg-gray-200 dark:bg-slate-850 dark:border-gray-700 border-b border-gray-300 flex p-2 rounded-t-lg">
                            <x-title-box
                                icon="{{ $icons[random_int(0, 2)] }}"
                                :small="true"
                                title="{{ $item }}"
                                description="This is customizable"
                            />
                        </div>
                        <div class="w-full grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 bg-white dark:bg-slate-800 h-auto rounded-b-lg p-2">
                            @for ($i = 0; $i < random_int(3, 6); $i++)
                                <div class="w-full h-auto flex flex-col border-b-2 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 rounded-lg">
                                    <div class="w-full overflow-hidden bg-slate-500 dark:bg-slate-850 border-b dark:border-slate-700 relative flex items-center justify-start p-2 h-10 bg-center bg-no-repeat rounded-t-md">
                                        <div class="w-full flex gap-2 justify-start items-center">
                                            <div @class([
                                                "w-3 h-3 rounded-full",
                                                "bg-green-400 animate-pulse" => $i % 2 == 0,
                                                "bg-red-500" => $i % 2 == 1
                                            ])></div>
                                            <a href="#" class="text-white font-bold truncate text-sm hover:underline underline-offset-4">iNicollas</a>
                                        </div>
                                        <div
                                            class="absolute -bottom-12 right-0 w-[64px] h-[110px] bg-center bg-no-repeat"
                                            style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=3&head_direction=2&size=m&gesture=sml')"
                                        ></div>
                                    </div>
                                    <div class="w-full h-auto flex flex-col p-1">
                                        <div class="flex-1 flex gap-1 text-slate-800 dark:text-slate-200">
                                            @for ($j = 0; $j < random_int(1, 5); $j++)
                                                <div class="w-[48px] h-[48px] bg-white border dark:border-none rounded-lg dark:bg-slate-800 bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/default_badge.gif') }}')"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-container>
@endsection
