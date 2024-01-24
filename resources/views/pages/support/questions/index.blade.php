@extends('layouts.app')

@section('title', __('Help Questions'))

@php($hasSearch = request()->has('search'))

@section('content')
    <div class="flex -mt-4 bg-white border-y dark:border-slate-800 shadow py-4 dark:bg-slate-950">
        <x-container class="flex flex-col justify-center items-center gap-8">
            <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                {{ __('Help & Tricks') }}
            </span>
            <span class="text-sm dark:text-slate-400 text-slate-600">
                {{ __('Here you can find answers to the most frequently asked questions and advanced tricks.') }}
            </span>
            <div
                class="lg:w-2/3 w-full space-y-2 mt-4"
                x-data="automaticSearch('{{ route('support.questions.index') }}')"
            >
                <x-ui.input
                    label="{{ __('Find your question') }}"
                    autocomplete="search"
                    id="search"
                    icon="fa-regular fa-circle-question"
                    placeholder="{{ __('Search') }}"
                    alpine-model="search"
                    type="text"
                    ref="search"
                />
                <small class="text-slate-400 dark:text-slate-500 block text-right">
                    {{ __('This search is automatic, you just need to type something.') }}
                </small>
            </div>
        </x-container>
    </div>
    <x-container class="mt-10 flex flex-col gap-8">
        @includeWhen($hasSearch, 'pages.support.questions.partials.back-button')

        @includeWhen(! $hasSearch, 'pages.support.questions.partials.default-content')
        @includeWhen($hasSearch, 'pages.support.questions.partials.researched-content')
    </x-container>
@endsection
