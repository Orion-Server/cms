@extends('layouts.app')

@section('title', __('Photos'))

@section('content')
<x-container>
    <div class="w-full h-auto flex flex-col gap-4" x-data="photosPage('{{ route('community.photos.like', '%ID%') }}')">
        <div @class([
            "flex px-2",
            "justify-between" => $period && $rule,
            "justify-end" => ! $period && $rule
        ])>
            @if($period)
            <x-ui.buttons.redirectable
                href="{{ route('community.photos.index', ['rule' => $rule]) }}"
                class="dark:bg-red-500 bg-red-500 text-white py-2 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75"
            >
                <i class="fas fa-times mr-2"></i>
                {{ __('Reset Period') }}
            </x-ui.buttons.redirectable>
            @endif

            @if($rule)
            <x-ui.buttons.redirectable
                href="{{ route('community.photos.index', ['period' => $period]) }}"
                class="dark:bg-red-500 bg-red-500 text-white py-2 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75"
            >
                <i class="fas fa-times mr-2"></i>
                {{ __('Reset Rule') }}
            </x-ui.buttons.redirectable>
            @endif
        </div>

        <div class="w-full lg:h-16 h-auto p-2 flex flex-col lg:flex-row justify-between gap-8 lg:gap-2">
            <div class="w-full lg:w-1/2 flex flex-wrap justify-start items-center gap-2">
                @foreach ($filters['periods'] as $key => $label)
                    <x-ui.buttons.redirectable
                        href="{{ route('community.photos.index', ['period' => $key, 'rule' => $rule ]) }}"
                        @class([
                            "py-2 text-white",
                            "dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75" => $period != $key,
                            "dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75" => (!$period && $key === null) || $period == $key
                        ])
                    >
                        {{ $label }}
                    </x-ui.buttons.redirectable>
                @endforeach
            </div>

            @auth
            <div class="w-full lg:w-1/2 flex lg:justify-end items-center gap-2">
                @foreach ($filters['rules'] as $key => $label)
                <x-ui.buttons.redirectable
                    href="{{ route('community.photos.index', ['rule' => $key, 'period' => $period ]) }}"
                    @class([
                            "py-2 text-white",
                            "dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75" => $rule != $key,
                            "dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75" => $rule == $key
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
                        class="bg-center border border-slate-300 dark:border-slate-700 hover:scale-[1.05] transition-transform relative group lightgallery-image cursor-pointer flex items-end justify-center w-full h-48 bg-no-repeat rounded-t-lg"
                        data-src="{{ $photo->url }}"
                        @if($photo->user)
                        data-sub-html='<h4>{{ __("Photo by") }} <a href="{{ route('users.profile.show', $photo->user->username) }}" class="underline underline-offset-4">{{ $photo->user->username }}</a></h4><p>{{ __("Photo taken on") }} <b>{{ $photo->formattedDate }}</b>@if($photo->room) {{ __("in the room") }} <a href="#" class="underline underline-offset-4">{{ $photo->room->name }}</a>@endif</p>'
                        @endif
                        style="background-image: url('{{ $photo->url }}')"
                    >
                        <div class="w-full p-2 flex justify-end items-center gap-2 bg-black/75 h-10">
                            <span class="text-slate-200 flex-1 text-xs">
                                <i class="fa-regular fa-clock"></i>
                                {{ $photo->formattedDate }}
                            </span>
                            <span class="text-slate-200 text-end text-xs underline underline-offset-2">
                                {{ __('Likes') }} (<b x-ref="photoLikes{{ $photo->id }}">{{ $photo->likes->count() }}</b>)
                            </span>
                            @auth
                                @php($liked = $photo->likes->contains('user_id', auth()->id()))
                                <i
                                    data-tippy
                                    data-tippy-content="Like"
                                    @click.stop="likePhoto($event, {{ $photo->id }})"
                                    @class([
                                        "fa-regular text-slate-200" => ! $liked,
                                        "fa-solid text-blue-400" => $liked,
                                        "fa-thumbs-up mb-1 cursor-pointer hover:scale-125"
                                    ])
                                ></i>
                            @endauth
                        </div>
                    </div>
                    <div class="w-full flex justify-start items-center gap-3 p-1 bg-gray-100 rounded-b-lg border-t-2 border-gray-300 dark:border-slate-600 dark:bg-gray-900">
                        <div
                            @class([
                                "w-[50px] min-w-[50px] h-[50px] bg-no-repeat rounded-full bg-white border border-gray-200 dark:bg-gray-950 dark:border-black",
                                "bg-center" => !$usingNitroImager,
                                "bg-[-20px_-27px]" => $usingNitroImager
                            ])
                            @if($photo->user)
                            style="background-image: url('{{ getFigureUrl($photo->user->look, 'direction=2&head_direction=2&size=m&gesture=sml&headonly=1') }}')"
                            @endif
                        ></div>
                        @if($photo->user)
                        <a href="{{ route('users.profile.show', $photo->user->username) }}" class="text-sm dark:text-slate-200 grow font-medium underline underline-offset-2 truncate">{{ $photo->user->username }}</a>
                        @endif
                        {{-- <div class="dark:text-slate-200 text-end text-xs cursor-pointer">
                            <i class="fa-solid fa-comments"></i>
                            <span>(10)</span>
                        </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
        {{ $photos->withQueryString()->links() }}
    </div>
</x-container>
@endsection
