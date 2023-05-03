<x-container class="relative h-auto !px-0">
    <div class="flex flex-col-reverse lg:flex-row gap-8 lg:gap-0">
        <div class="w-full lg:w-2/3 h-auto flex flex-col lg:pr-8 gap-8">
            <div class="flex lg:gap-4 h-auto">
                <div class="w-full lg:w-1/2">
                    @include('pages.users.fragments.referrals')
                </div>
                <div class="w-full lg:w-1/2">
                    @include('pages.users.fragments.balances')
                </div>
            </div>
            <div>
                @include('pages.users.fragments.stories')
            </div>
            <div>
                @include('pages.users.fragments.online-friends')
            </div>
        </div>
        <div class="w-full h-auto lg:w-1/3 flex flex-col">
            <div class="w-full mb-4">
                <x-title-box
                    icon="articles"
                    title="Latest Articles"
                />
            </div>
            <div class="relative flex flex-col p-1.5 rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
                <div class="swiper w-full h-44 relative" id="latestArticles">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < 5; $i++)
                        <div @class([
                            "swiper-slide relative bg-center bg-no-repeat bg-cover",
                            "bg-[url('/assets/images/user-box-bg.gif')]" => $i == 0 || $i == 2 || $i == 4,
                            "bg-[url('/assets/images/user-box-bg2.gif')]" => $i == 1 || $i == 3,
                        ])>
                            <div class="absolute w-full h-full bg-black/50 top-0 left-0"></div>
                            <div class="w-full h-full flex flex-col relative p-4">
                                <a href="#" class="text-white font-semibold">{{ fake()->sentence(5) }}</a>
                                <span class="text-slate-300 mt-2 text-xs w-full line-clamp-5">{{ fake()->sentence(50) }}</span>
                            </div>
                        </div>
                        @endfor
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
                @for ($i = 0; $i < 5; $i++)
                    <div class="odd:bg-gray-50 p-2 dark:odd:bg-slate-900 flex gap-1 h-14 hover:bg-gray-100 dark:hover:bg-slate-850">
                        <div class="w-14 h-full rounded bg-no-repeat bg-right-bottom" style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')"></div>
                        <div class="h-full w-full flex flex-col truncate">
                            <a href="" class="underline underline-offset-2 text-slate-700 dark:text-slate-200 text-sm font-semibold">{{ fake()->sentence(5) }}</a>
                            <span class="text-xs text-slate-600 dark:text-slate-300 mt-1">Posted by <a href="#" class="font-medium text-blue-400">iNicollas</a></span>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-container>
