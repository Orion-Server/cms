@extends('layouts.app')

@section('title', sprintf('%s: %s', __('Category'), $category->name))

@section('content')
    <x-container class="mt-10 flex flex-col gap-8">
        @include('pages.support.questions.partials.back-button')

        <div class="flex flex-col justify-center items-center gap-2">
            <div class="flex gap-2 items-center flex-wrap">
                <span class="text-3xl font-bold text-slate-800 dark:text-slate-200">
                    {{ __('Category') }}:
                </span>
                <div>
                    <img class="p-2 dark:bg-slate-950 bg-slate-300 rounded-full" src="{{ $category->icon }}" alt="{{ $category->name }}" loading="lazy" />
                </div>
                <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                    {{ $category->name }}
                </span>
            </div>

            <div
                class="lg:w-2/3 w-full space-y-2 mt-4"
                x-data="automaticSearch('{{ route('support.questions.categories.show', $category->slug) }}')"
            >
                <x-ui.input
                    label="{{ __('Search something in this category') }}"
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
        </div>

        <x-title-box
            title="{{ __('Category Questions') }}"
            icon="most-asked-questions"
        />

        <div class="flex flex-col divide-y dark:divide-slate-800">
            @forelse ($category->questions as $question)
                <a
                    href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
                    class="hover:underline py-3 text-blue-500 text-sm hover:text-blue-700"
                >
                    <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
                    {{ $question->title }}
                </a>
            @empty
            <span class="text-slate-400 dark:text-slate-500">
                {{ __('No questions were found for this :n.', ['n' => strtolower(__('Category'))]) }}
            </span>
            @endforelse
        </div>

        {{ $category->questions?->withQueryString()->links() }}
    </x-container>
@endsection
