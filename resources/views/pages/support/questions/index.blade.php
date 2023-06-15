@extends('layouts.app')

@section('title', 'Help Questions')

@section('content')
    <x-container class="mt-16 flex flex-col gap-8">
        <div class="flex flex-col justify-center items-center gap-2">
            <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
                Help Questions
            </span>
            <span class="text-sm dark:text-slate-400 text-slate-600">
                Here you can find answers to the most frequently asked questions.
            </span>
            <div class="lg:w-2/3 w-full space-y-2 mt-8">
                <x-ui.input
                    label="Ask a question"
                    autocomplete="questions"
                    id="question"
                    icon="fa-regular fa-circle-question"
                    placeholder="How can I get diamonds?"
                    type="text"
                />
                <small class="text-slate-400 dark:text-slate-500 block text-right">
                    Press enter to search</small>
            </div>
        </div>

        <div class="flex gap-2 flex-wrap justify-center">
            @foreach ($categories as $category)
                <x-ui.buttons.redirectable
                    class="bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white"
                >
                    <img src="{{ $category->icon }}" alt="{{ $category->name }}" loading="lazy" />
                    {{ $category->name }}
                </x-ui.buttons.redirectable>
            @endforeach
        </div>

        <div class="flex gap-3 mt-8 justify-between flex-col lg:flex-row">
            <div class="w-1/2">
                <x-title-box
                    title="Added Recent Questions"
                    icon="added-recent-questions"
                />
            </div>
            <div class="w-1/2">
                <x-title-box
                    title="Most Asked Questions"
                    icon="most-asked-questions"
                />

                <div class="flex flex-col gap-2">
                    @foreach ($mostAskedQuestions as $question)
                        <a
                            href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
                            class="underline underline-offset-4 text-blue-400 underline-blue-400 text-sm hover:underline-blue-600 hover:text-blue-600"
                        >
                            <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
                            {{ $question->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </x-container>
@endsection
