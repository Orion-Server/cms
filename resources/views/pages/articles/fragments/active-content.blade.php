@props([
    'activeArticle' => null
])

<div
    class="w-full !bg-cover !bg-no-repeat !bg-center h-16 flex rounded-lg shadow-lg justify-between border-b-2 border-gray-300 dark:border-slate-800"
    style="background: linear-gradient(to right, {{ $activeArticle->predominant_color }}, transparent), url('{{ $activeArticle->image }}')"
>
    <span class="w-full h-full font-semibold flex items-center justify-start py-2 px-4" style="color: {{ $activeArticle->titleColor }}">
        {{ $activeArticle->title }}
    </span>
</div>
<div>
    <div class="text-sm prose dark:prose-invert !max-w-full ck-content w-full dark:text-slate-200 mt-4 h-auto p-4 bg-white dark:bg-slate-950 rounded-t-lg shadow-lg">
        {!! $activeArticle->content !!}
    </div>
    <div class="w-full flex border-t dark:border-slate-700 flex-col lg:flex-row gap-4 lg:gap-0 h-auto lg:h-20 lg:divide-x dark:divide-slate-800 py-2 overflow-hidden px-4 bg-gray-100 dark:bg-slate-850 rounded-b-lg shadow-lg">
        <div class="w-full overflow-hidden lg:w-1/3 h-20 border-b dark:border-slate-800 lg:border-none lg:h-full relative flex justify-center flex-col items-center gap-1 pl-24">
            <div @class([
                "rounded-lg w-22 h-22 absolute border-4 shadow-inner bg-cover bg-center bg-no-repeat -bottom-8 lg:-bottom-10 left-0",
                "border-blue-300 shadow-blue-500" => true,
                "border-pink-300 shadow-pink-500" => false
            ]) style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')">
                <div class="w-[64px] h-[110px] absolute bottom-2 left-2" style="background-image: url('{{ getSetting('figure_imager') . $activeArticle->user->look }}&direction=2&head_direction=2&size=m&gesture=sml')"></div>
            </div>
            <a
                href="#"
                class="truncate w-full font-semibold underline underline-offset-2 text-blue-400"
            >
                {{ $activeArticle->user->username }}
            </a>
            <span class="text-xs w-full dark:text-slate-200"><b class="text-zinc-600 dark:text-slate-200">{{ __('Date') }}:</b> {{ $activeArticle->created_at->format('Y-m-d H:i') }}</span>
        </div>
        <div class="w-full lg:w-2/3 h-full flex-col lg:flex-row relative divide-y dark:divide-slate-800 pl-2">
            <div class="w-full h-10 lg:h-1/2 flex items-center">
                <x-ui.toggle label="{{ __('Always get notifications from this author') }}" />
            </div>
            <div class="w-full h-10 lg:h-1/2 py-1 flex gap-1 items-center justify-start flex-wrap">
                @forelse ($activeArticle->tags as $tag)
                    <span @class([
                        "text-xs font-medium rounded-lg px-2",
                        "text-slate-800" => !isDarkColor($tag->background_color),
                        "text-white" => isDarkColor($tag->background_color)
                    ]) style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                @empty
                    <span class="text-xs text-gray-900 dark:text-gray-400">
                        {{ __('No tags found.') }}
                    </span>
                @endforelse
            </div>
        </div>
    </div>
    @include('pages.articles.fragments.article-reactions')
</div>
@if ($activeArticle->allow_comments)
<div class="mt-8 w-full h-auto">
    @auth
        <div class="mb-8">
            <x-title-box
                title="{{ __('Comment this Article') }}"
                description="{{ __('Write your opinion below') }}"
                icon="comment"
            />
            <div class="bg-white w-full h-auto dark:bg-slate-950 p-1 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg mt-8">
                <x-ui.textarea
                    article-id="{{ $activeArticle->id }}"
                    article-slug="{{ $activeArticle->slug }}"
                />
            </div>
        </div>
    @endauth
    <div class="w-full h-auto" id="comments">
        <x-title-box
            title="{{ __('Article Comments') }}"
            description="{{ __('All comments of this article') }}"
            icon="users-comments"
        />
    </div>
    @include('pages.articles.fragments.article-comments')
</div>
@endif
