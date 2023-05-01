@extends('layouts.app')

@section('title', 'Photos')

@section('content')
<x-container>
    <div class="w-full h-auto flex flex-col gap-4" x-data="photosPage">
        <div class="w-full h-16 p-2 flex justify-between gap-2">
            <div class="w-full lg:w-1/2 flex justify-start items-center gap-2">
                @foreach (['All', 'Today', 'Last Week', 'Last Month'] as $buttonLabel)
                    <x-ui.buttons.loadable
                        alpine-model="loading"
                        @click="loading = !loading"
                        class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                    >
                        {{ $buttonLabel }}
                    </x-ui.buttons.loadable>
                @endforeach
            </div>
            <div class="w-full lg:w-1/2 flex justify-end items-center gap-2">
                @foreach (['Only my friends', 'Liked by me'] as $buttonLabel)
                <x-ui.buttons.loadable
                    alpine-model="loading"
                    @click="loading = !loading"
                    class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                >
                    {{ $buttonLabel }}
                </x-ui.buttons.loadable>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @for ($i = 0; $i < 40; $i++)
                <div class="bg-white dark:bg-slate-950 p-2 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg h-auto">
                    <div class="bg-center flex items-end w-full h-48 bf-no-repeat rounded-t-lg" style="background-image: url('{{ asset('assets/images/photo.png') }}')">
                        <div class="w-full p-2 flex justify-end items-center gap-2 bg-black/75 h-10">
                            <span class="text-slate-200 flex-1 text-xs">
                                <i class="fa-regular fa-clock"></i>
                                30/02/1920
                            </span>
                            <span class="text-slate-200 flex-1 text-end text-xs underline underline-offset-2">
                                Likes (10)
                            </span>
                            <i
                                data-tippy
                                data-tippy-content="Like"
                                class="fa-solid fa-thumbs-up text-slate-200 mb-1 cursor-pointer hover:scale-110 hover:animate-spin"
                            ></i>
                        </div>
                    </div>
                    <div class="w-full flex justify-start items-center gap-3 p-1 bg-gray-100 rounded-b-lg border-t-2 border-gray-300 dark:border-slate-600 dark:bg-gray-900">
                        <div
                            class="w-[50px] h-[50px] bg-center bg-no-repeat rounded-full bg-white border border-gray-200 dark:bg-gray-950 dark:border-black"
                            style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=2&head_direction=2&size=m&gesture=sml&headonly=1')"
                        ></div>
                        <a href="#" class="text-sm dark:text-slate-200 font-medium underline underline-offset-2 truncate">iNicollas</a>
                    </div>
                </div>
            @endfor
        </div>
        <div class="w-full flex justify-center items-center">
            <x-ui.buttons.loadable
                alpine-model="loading"
                @click="loading = !loading"
                class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
            >
                <i class="fa-solid fa-plus"></i>
                Load more
            </x-ui.buttons.loadable>
        </div>
    </div>
</x-container>
@endsection
