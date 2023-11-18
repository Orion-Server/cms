@extends('layouts.app')

@section('title', __('My Settings'))

@section('content')
<x-container>
    <div class="w-full h-auto relative flex justify-start flex-col lg:flex-row items-start gap-6">
        <div
            class="flex flex-col gap-2 h-auto w-full lg:w-1/4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-2"
        >
        @forelse ($navigations as $navigation)
            <a href="{{ route("users.settings.index", $navigation['type']) }}" @class([
                "rounded font-semibold p-3 text-sm text-slate-800 dark:text-white",
                "border-b-2 bg-slate-100 border-blue-400 dark:bg-slate-800 !text-blue-400" => $page == $navigation['type'],
                "dark:hover:bg-slate-800 hover:bg-slate-100 hover:!text-blue-400" => $page != $navigation['type']
            ])>
                <i class="{{ $navigation['icon'] }} mr-1"></i>
                {{ $navigation['title'] }}
            </a>
        @empty
            <div class="text-slate-800 dark:text-white text-sm font-semibold p-3">
                {{ __('No navigation found.') }}
            </div>
        @endforelse
        </div>
        <div class="h-auto w-full flex flex-col lg:w-3/4">
            @includeWhen($page, "pages.users.settings.fragments.{$page}")
        </div>
</x-container>
@endsection
