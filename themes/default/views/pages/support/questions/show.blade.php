@extends('layouts.app')

@section('title', __('Question: :title', ['title' => $question->title]))

@section('content')
    <x-container class="mt-10 flex flex-col gap-8">
        @include('pages.support.questions.partials.back-button')

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

@pushOnce('scripts')
<script src="{{ asset('assets/js/ckeditor.min.js') }}"></script>
@endpushOnce
