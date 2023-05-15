@extends('layouts.app')

@section('title', $activeArticle->title)

@section('content')
<x-container>
    <div class="w-full h-auto relative flex justify-start flex-col lg:flex-row items-start gap-6">
        <div class="h-auto w-full lg:w-1/4">
            <x-title-box
                title="Articles"
                description="All recent articles"
                icon="articles"
            />
            <div class="w-full max-h-72 lg:h-auto lg:max-h-none overflow-y-auto flex flex-col p-3 mt-4 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                @foreach ($latestArticlesWithCategories as $category => $articles)
                    <div class="border-b uppercase font-semibold pb-2 mb-4 [&:not(:first-of-type)]:mt-4 text-sm text-slate-800 dark:text-white border-dashed border-slate-400 dark:border-slate-800">
                        {{ $category }}
                    </div>

                    @forelse ($articles as $article)
                        @include('pages.articles.fragments.article-url', ['article' => $article, 'isActive' => $activeArticle?->id == $article->id])
                    @empty
                        <span class="text-sm text-slate-800 dark:text-white">No articles found.</span>
                    @endforelse

                @endforeach
            </div>
        </div>
        <div class="h-auto w-full flex flex-col lg:w-3/4">
            @if ($activeArticle)
                @include('pages.articles.fragments.active-content', ['activeArticle' => $activeArticle])
            @else
                <div class="w-full lg:w-3/4 flex flex-col lg:flex-row items-center lg:mt-20 mt-4 justify-center gap-4">
                    <img width="250" src="{{ asset('assets/images/frank-not-found.gif') }}" alt="frank-not-found" />
                    <div class="flex flex-col dark:text-slate-200 text-center lg:text-left">
                        <p class="text-4xl font-bold text-red-500">No article selected.</p>
                        <p class="text-md">Select an article or wait for the team to create a new one.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-container>
@endsection

@once
    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/super-build/ckeditor.js" data-turbolinks-eval="false"></script>
    @endpush
@endonce
