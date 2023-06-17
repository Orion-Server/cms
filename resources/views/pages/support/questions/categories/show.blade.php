@extends('layouts.app')

@section('title', 'Category: ' . $category->name)

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
            <div class="flex gap-2 items-center">
                <div>
                    <img class="p-2 dark:bg-slate-950 bg-slate-300 rounded-full" src="{{ $category->icon }}" alt="{{ $category->name }}" loading="lazy" />
                </div>
                <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                    {{ $category->name }}
                </span>
            </div>

            <div class="lg:w-2/3 w-full space-y-2 mt-4">
                <form action="{{ route('support.questions.categories.show', $category->slug) }}" method="GET">
                    <x-ui.input
                        label="Ask a question for this category"
                        autocomplete="questions"
                        id="question"
                        icon="fa-regular fa-circle-question"
                        placeholder="..."
                        name="search"
                        type="text"
                    />
                    <small class="text-slate-400 dark:text-slate-500 block text-right">
                        Press enter to search
                    </small>
                </form>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            @forelse ($category->questions as $question)
                <a
                    href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
                    class="underline underline-offset-4 text-blue-400 underline-blue-400 text-sm hover:underline-blue-600 hover:text-blue-600"
                >
                    <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
                    {{ $question->title }}
                </a>
            @empty
            <span class="text-slate-400 dark:text-slate-500">
                No questions found for this category.
            </span>
            @endforelse
        </div>

        {!! $category->questions?->links() !!}
    </x-container>
@endsection
