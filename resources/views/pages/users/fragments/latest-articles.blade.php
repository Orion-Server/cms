<div class="w-full mb-4">
    <x-title-box
        icon="articles"
        title="Latest Articles"
    />
</div>
<div class="relative flex flex-col p-1.5 rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
    <div class="swiper w-full h-44 relative" id="latestArticles">
        <div class="swiper-wrapper">
            @forelse ($sliderArticles as $sliderArticle)
            <div class="swiper-slide relative bg-center bg-no-repeat" style="background-image: url({{ $sliderArticle->image }})">
                <div class="absolute w-full h-full bg-black/50 top-0 left-0"></div>
                <div class="w-full h-full flex flex-col relative p-4">
                    <a href="{{ route('articles.show', [$sliderArticle->id, $sliderArticle->slug]) }}" class="text-white font-semibold">{{ $sliderArticle->title }}</a>
                    <span class="text-slate-300 mt-2 text-xs w-full line-clamp-5">{{ $sliderArticle->description }}</span>
                </div>
            </div>
            @empty
            <span class="text-slate-700 dark:text-slate-200 text-xs flex items-center justify-center h-full w-full">Articles not found</span>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="relative flex justify-between items-center my-1">
        <span class="text-xs w-auto flex items-center gap-1 font-medium text-slate-500 text-end px-1">
            <i class="icon small w-[13px] h-[15px] border-none shadow-none rounded-none ifixed"></i>
            Fixed Articles
        </span>
        <div class="border-t border-gray-300 dark:border-slate-700 border-dotted flex-auto"></div>
    </div>
    @forelse ($fixedArticles as $fixedArticle)
        <div class="odd:bg-gray-50 p-2 dark:odd:bg-slate-900 flex gap-1 h-14 hover:bg-gray-100 dark:hover:bg-slate-850">
            <div class="w-14 h-full rounded bg-no-repeat bg-right-bottom" style="background-image: url('{{ $fixedArticle->image }}')"></div>
            <div class="h-full w-full flex flex-col truncate">
                <a href="{{ route('articles.show', [$fixedArticle->id, $fixedArticle->slug]) }}" class="underline underline-offset-2 text-slate-700 dark:text-slate-200 text-sm font-semibold">{{ $fixedArticle->title }}</a>
                <span class="text-xs text-slate-600 dark:text-slate-300 mt-1">Posted by <a href="#" class="font-medium text-blue-400">{{ $fixedArticle->user->username }}</a></span>
            </div>
        </div>
    @empty
        <span class="text-slate-700 dark:text-slate-200 text-xs p-2">Fixed articles not found</span>
    @endforelse
</div>
