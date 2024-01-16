@extends('layouts.shop-app')

@section('content')
<div class="flex h-screen">
    <div class="w-2/6 xl:w-1/6 h-full bg-slate-850/75 border-r border-slate-800">
        <x-ui.buttons.redirectable
            href="{{ route('index') }}"
            class="dark:bg-transparent mx-auto mt-4 !w-1/2 border-blue-700 border hover:border-blue-500 shadow-blue-600/75 flex-1 py-3 text-white"
        >
            <i class="fa-solid fa-chevron-left"></i>
            {{ __('Back') }}
        </x-ui.buttons.redirectable>

        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full mt-8 bg-slate-900 border-y border-slate-800 text-slate-300 text-sm">
                <div class="flex items-center py-2 pl-4">
                    <div class="w-6 h-6 bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/6Z1Noci.gif')"></div>
                    <span class="px-2">{{ __(':a credits', ['a' => Auth::user()->currency(CurrencyType::Credits)]) }}</span>
                </div>
                <div class="flex items-center py-2 pl-4">
                    <div class="w-6 h-6 bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/ZRBOYoE.png')"></div>
                    <span class="px-2">{{ __(':a duckets', ['a' => Auth::user()->currency(CurrencyType::Duckets)]) }}</span>
                </div>
                <div class="flex items-center py-2 pl-4">
                    <div class="w-6 h-6 bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/7MyGvjK.png')"></div>
                    <span class="px-2">{{ __(':a diamonds', ['a' => Auth::user()->currency(CurrencyType::Diamonds)]) }}</span>
                </div>
                <div class="flex items-center py-2 pl-4">
                    <div class="w-6 h-6 bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/8p2Dqlw.png')"></div>
                    <span class="px-2">{{ __(':a points', ['a' => Auth::user()->currency(CurrencyType::Points)]) }}</span>
                </div>
            </div>

            <span class="text-xl font-medium text-center text-slate-100 mt-8 underline underline-offset-4 decoration-blue-500">{{ __('Categories') }}</span>
        </div>

        <ul class="w-full flex flex-col mt-8 border-t border-slate-800">
            @foreach ($categories as $category)
                <a href="{{ route('shop.show', [$category->id, Str::slug($category->name)]) }}">
                    <li class="p-4 border-b border-slate-800 flex items-center justify-start gap-2 hover:bg-slate-700">
                        <img src="{{ $category->icon }}" alt="{{ $category->name }}">
                        <span class="text-sm font-medium text-slate-100">{{ $category->name }}</span>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
    <div class="w-5/6 h-full">
    </div>
</div>
@endsection
