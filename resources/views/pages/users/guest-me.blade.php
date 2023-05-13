<div class="w-full">
    <div class="w-full mx-auto gap-8 flex flex-col lg:flex-row h-auto p-1 justify-between items-start">
        <div class="w-full flex flex-col gap-2 lg:w-1/3">
            <x-title-box
                title="Fixed Articles"
                description="Articles to remember"
                icon="fixed-articles"
            />
            <div class="w-full flex flex-col gap-3">
                @foreach ($fixedArticles as $fixedArticle)
                    <a
                        href="{{ route('articles.show', [$fixedArticle->id, $fixedArticle->slug]) }}"
                        class="group w-full h-20 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg"
                    >
                        <div class="w-full h-full flex gap-2 p-1 pr-2">
                            <div
                                class="w-24 h-full flex justify-center items-center bg-right-bottom bg-no-repeat rounded-md"
                                style="background-image: url('{{ $fixedArticle->image }}')"
                            ></div>
                            <div class="flex w-2/3 flex-col">
                                <span class="w-full font-semibold dark:text-white group-hover:text-blue-400 text-sm truncate">{{ $fixedArticle->title }}</span>
                                <span class="w-full text-slate-700 max-h-[45px] overflow-hidden dark:text-slate-400 text-xs">{{ $fixedArticle->description }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-2/3">
            <div class="w-full flex flex-col gap-2">
                <x-title-box
                    title="Latest Articles"
                    description="Check out the latest articles below"
                    icon="articles"
                >
                    <x-ui.buttons.redirectable
                            href="{{ route('articles.index') }}"
                            class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                        >
                            View All
                    </x-ui.buttons.redirectable>
                </x-title-box>
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-2 gap-3">
                    @foreach ($defaultArticles as $defaultArticle)
                        <div class="w-full bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                            <div class="w-full h-full flex flex-col gap-2 p-1">
                                <div
                                    class="w-full h-24 flex justify-center items-center bg-right-bottom bg-no-repeat rounded-md"
                                    style="background-image: url('{{ $defaultArticle->image }}')"
                                ></div>
                                <div class="flex w-full flex-col">
                                    <a
                                        href="{{ route('articles.show', [$defaultArticle->id, $defaultArticle->slug]) }}"
                                        class="w-full font-semibold text-slate-900 dark:text-white hover:text-blue-400 dark:hover:text-blue-400 text-sm truncate"
                                    >{{ $defaultArticle->title }}</a>
                                    <span class="w-full mt-2 flex gap-2 justify-start items-center text-slate-700 max-h-[45px] overflow-hidden dark:text-slate-400 text-xs">
                                        <div
                                            class="w-[30px] h-[30px] bg-center bg-no-repeat rounded-full bg-gray-200 dark:bg-slate-900"
                                            style="background-image: url('{{ getSetting('figure_imager') . $defaultArticle->user->look }}&head_direction=2&size=s&headonly=1')"
                                        ></div>
                                        <a class="underline underline-offset-2 hover:text-blue-400" href="#">{{ $defaultArticle->user->username }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="w-full mx-auto gap-8 mt-8 flex flex-col lg:flex-row h-auto p-1 justify-between items-start">
        <div class="w-full flex flex-col gap-2 lg:w-1/3">
            <x-title-box
                title="Latest Users"
                description="The most recent users"
                icon="users"
            />
            <div class="w-full grid grid-cols-4 grid-rows-4 flex-wrap gap-3">
                @foreach ($latestUsers as $user)
                    <div
                        data-tippy-singleton
                        data-tippy-content="<small>{{ $user->username }}</small>"
                        class="h-16 bg-white rounded-lg shadow-lg border-b-2 border-gray-300 dark:border-slate-800 dark:bg-slate-950 bg-center bg-no-repeat"
                        style="background-image: url('{{ getSetting('figure_imager') . $user->look }}&head_direction=3&gesture=sml&headonly=1')"
                    ></div>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-2/3">
            <div class="w-full flex flex-col gap-2">
                <x-title-box
                    title="Latest User Photos"
                    description="Stay on top of what users are doing at the hotel"
                    icon="camera"
                >
                    <x-ui.buttons.redirectable
                        href="#"
                        class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                    >
                            View All
                    </x-ui.buttons.redirectable>
                </x-title-box>
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-2 gap-2">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="w-full bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg hover:scale-[1.05] transition-transform">
                            <div class="w-full h-35 relative flex flex-col p-1">
                                <a href="{{ route('community.photos.index') }}" class="w-full h-full flex justify-center items-center bg-center bg-no-repeat rounded-md" style="background-image: url('{{ asset('assets/images/photo.png') }}')"></a>
                                <span class="w-auto absolute bottom-2 left-2 flex gap-2 justify-start items-center text-slate-700 max-h-[45px] overflow-hidden dark:text-slate-400 text-xs">
                                    <div
                                        class="w-auto pr-3 max-w-[100px] h-[30px] bg-start pl-8 flex items-center bg-no-repeat rounded-full bg-gray-200 dark:bg-slate-900"
                                        style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=4&head_direction=2&size=s&gesture=sml&action=sit,wav&headonly=1')"
                                    >
                                        <a class="underline underline-offset-2 hover:text-blue-400" href="#">iNicollas</a>
                                    </div>
                                </span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
