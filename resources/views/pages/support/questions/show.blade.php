@extends('layouts.app')

@section('title', 'Question: ' . $question->title)

@section('content')
    <x-container class="mt-10 flex flex-col gap-8">
        <div class="flex">
            <x-ui.buttons.redirectable
                href="{{ route('support.questions.index') }}"
                class="bg-red-500 border-red-700 hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75 py-2 text-white"
            >
                <i class="fa-solid fa-angle-left mr-1"></i>
                Back to Questions
            </x-ui.buttons.redirectable>
        </div>

        <div class="flex flex-col justify-center items-center gap-2">
            <span class="text-3xl leading-10 font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                <i class="fa-regular fa-circle-question mr-2"></i>
                {{ $question->title }}
            </span>
            <span class="flex gap-2 flex-wrap justify-center mt-3">
                @foreach ($question->categories as $category)
                    <x-ui.buttons.redirectable
                        class="bg-slate-300 border-slate-400 dark:bg-slate-400 dark:border-slate-500 text-slate-500 !cursor-not-allowed"
                        disabled
                    >
                        <img src="{{ $category->icon }}" alt="{{ $category->name }}" loading="lazy" />
                        {{ $category->name }}
                    </x-ui.buttons.redirectable>
                @endforeach
            </span>
        </div>

        <div class="prose !max-w-full dark:prose-invert ck-content dark:text-slate-200 h-auto p-4 bg-white dark:bg-slate-950 rounded-lg shadow-lg">
            {!! $question->content !!}
        </div>
    </x-container>
@endsection

@push
    <script src="{{ asset('assets/js/ckeditor.min.js') }}"></script>
@endpush
