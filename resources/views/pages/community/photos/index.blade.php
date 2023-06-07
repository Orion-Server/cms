@extends('layouts.app')

@section('title', 'Photos')

@php($filters = [
    'left' => [
        'all' => 'All',
        'today' => 'Today',
        'last_week' => 'Last Week',
        'last_month' => 'Last Month',
    ],
    'right' => [
        'only_my_friends' => 'Only my friends',
        'liked_by_me' => 'Liked by me'
    ]
])

@section('content')
<x-container>
    <div class="w-full h-auto flex flex-col gap-4" x-data="photosPage">
        <div class="flex justify-between px-2">
            @if(request()->has('period'))
            <x-ui.buttons.redirectable
                href="{{ route('community.photos.index', ['filter' => request()->get('filter', null)]) }}"
                class="dark:bg-red-500 bg-red-500 text-white py-2 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75"
            >
                <i class="fas fa-times mr-2"></i>
                Reset Period
            </x-ui.buttons.redirectable>
            @endif

            @if(request()->has('filter'))
            <x-ui.buttons.redirectable
                href="{{ route('community.photos.index', ['period' => request()->get('period', null)]) }}"
                class="dark:bg-red-500 bg-red-500 text-white py-2 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75"
            >
                <i class="fas fa-times mr-2"></i>
                Reset Filter
            </x-ui.buttons.redirectable>
            @endif
        </div>

        <div class="w-full lg:h-16 h-auto p-2 flex flex-col lg:flex-row justify-between gap-8 lg:gap-2">
            <div class="w-full lg:w-1/2 flex flex-wrap justify-start items-center gap-2">
                @foreach ($filters['left'] as $key => $label)
                    <x-ui.buttons.redirectable
                        href="{{ route('community.photos.index', ['period' => $key, 'filter' => request()->get('filter', null) ]) }}"
                        @class([
                            "py-2 text-white",
                            "dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75" => request()->get('period', null) != $key,
                            "dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75" => request()->get('period', null) == $key
                        ])
                    >
                        {{ $label }}
                    </x-ui.buttons.redirectable>
                @endforeach
            </div>
            @auth
            <div class="w-full lg:w-1/2 flex lg:justify-end items-center gap-2">
                @foreach ($filters['right'] as $key => $label)
                <x-ui.buttons.redirectable
                    href="{{ route('community.photos.index', ['filter' => $key, 'period' => request()->get('period', null) ]) }}"
                    @class([
                            "py-2 text-white",
                            "dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75" => request()->get('filter', null) != $key,
                            "dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75" => request()->get('filter', null) == $key
                        ])
                    >
                    {{ $label }}
                </x-ui.buttons.redirectable>
                @endforeach
            </div>
            @endauth
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="lightgallery">
            @foreach ($photos as $photo)
                <div class="bg-white dark:bg-slate-950 p-2 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg h-auto">
                    <div
                        class="bg-center hover:scale-[1.05] transition-transform relative group lightgallery-image cursor-pointer flex items-end justify-center w-full h-48 bg-no-repeat rounded-t-lg"
                        data-src="{{ $photo->url }}"
                        data-sub-html='<h4>Photo by <a href="#" class="underline underline-offset-4">{{ $photo->user->username }}</a></h4><p>Photo taken on <b>{{ $photo->formattedDate }}</b> in the <a href="#" class="underline underline-offset-4">{{ $photo->room->name }}</a></p>'
                        style="background-image: url('{{ $photo->url }}')"
                    >
                        <div class="w-full p-2 flex justify-end items-center gap-2 bg-black/75 h-10">
                            <span class="text-slate-200 flex-1 text-xs">
                                <i class="fa-regular fa-clock"></i>
                                {{ $photo->formattedDate }}
                            </span>
                            <span class="text-slate-200 text-end text-xs underline underline-offset-2">
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
                            class="w-[50px] min-w-[50px] h-[50px] bg-center bg-no-repeat rounded-full bg-white border border-gray-200 dark:bg-gray-950 dark:border-black"
                            style="background-image: url('{{ getSetting('figure_imager') . $photo->user->username }}&direction=2&head_direction=2&size=m&gesture=sml&headonly=1')"
                        ></div>
                        <a href="#" class="text-sm dark:text-slate-200 grow font-medium underline underline-offset-2 truncate">{{ $photo->user->username }}</a>
                        <div class="dark:text-slate-200 text-end text-xs cursor-pointer">
                            <i class="fa-solid fa-comments"></i>
                            <span>(10)</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $photos->withQueryString()->links() !!}
    </div>
</x-container>
@endsection
