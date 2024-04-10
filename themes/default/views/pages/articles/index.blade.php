@extends('layouts.app')

@section('title', $activeArticle?->title ?? __('Articles'))

@section('content')
<x-container>
    <div class="w-full h-auto relative flex justify-start flex-col lg:flex-row items-start gap-6">
        <div class="h-auto w-full lg:w-1/4">
            <x-title-box
                title="{{ __('Articles') }}"
                description="{{ __('All recent articles') }}"
                icon="articles"
            />
            <div class="w-full max-h-72 lg:h-auto lg:max-h-none overflow-y-auto flex flex-col p-3 mt-4 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                @foreach ($latestArticlesWithCategories as $category => $latestArticles)
                    <div class="border-b uppercase font-semibold pb-2 mb-4 [&:not(:first-of-type)]:mt-4 text-sm text-slate-800 dark:text-white border-dashed border-slate-400 dark:border-slate-800">
                        {{ __($category) }}
                    </div>

                    @forelse ($latestArticles as $lastArticle)
                        @php($isActive = $activeArticle?->id == $lastArticle->id)
                        <a
                            href="{{ route('articles.show', [$lastArticle->id, $lastArticle->slug]) }}"
                            data-tippy-singleton
                            data-tippy-content="<small>Posted by <b>{{ $lastArticle->user->username }}</b></small>"
                            @class([
                                "dark:text-slate-300 text-sm py-1.5 border-l border-slate-300 dark:border-slate-600 pl-3 decoration-slate-400 hover:!text-blue-400",
                                "!border-blue-400 !text-blue-400 border-l-2" => $isActive,
                                "hover:!border-slate-400" => !$isActive,
                                "!border-lime-400" => !$isActive && $lastArticle->is_promotion && $lastArticle->promotion_ends_at->gt(now())
                            ])
                        >
                            {{ $lastArticle->title }} <span @class([
                                "!text-blue-400" => $isActive,
                                "text-lime-400" => !$isActive && $lastArticle->is_promotion && $lastArticle->promotion_ends_at->gt(now())
                            ])">»</span>
                        </a>
                    @empty
                        <span class="text-sm text-slate-800 dark:text-white">{{ __('No articles found.') }}</span>
                    @endforelse

                @endforeach
            </div>
        </div>
        <div class="h-auto w-full flex flex-col lg:w-3/4" id="article-content">
            @if ($activeArticle)
                @include('pages.articles.fragments.active-content', ['activeArticle' => $activeArticle])
            @else
                <div class="w-full lg:w-3/4 flex flex-col lg:flex-row items-center lg:mt-20 mt-4 justify-center gap-4">
                    <img width="250" src="{{ asset('assets/images/frank-not-found.gif') }}" alt="frank-not-found" />
                    <div class="flex flex-col gap-3 dark:text-slate-200 text-center lg:text-left">
                        <p class="text-4xl font-bold text-red-500">{{ __('No articles found.') }}</p>
                        <p class="text-md">{{ __('Select an article or wait for the team to create a new one.') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-container>
@endsection

@pushOnce('scripts')
<script src="{{ asset('assets/js/ckeditor.min.js') }}"></script>
@endpushOnce

