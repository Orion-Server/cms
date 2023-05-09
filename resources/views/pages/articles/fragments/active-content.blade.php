@props([
    'activeArticle' => null
])

<div
    class="w-full !bg-cover !bg-no-repeat !bg-center h-16 flex rounded-lg shadow-lg justify-between border-b-2 border-gray-300 dark:border-slate-800"
    style="background: linear-gradient(to right, blue 50%, transparent), url('{{ asset('assets/images/user-box-bg.gif') }}')"
>
    <span class="w-full h-full font-semibold text-white flex items-center justify-start py-2 px-4">
        {{ $activeArticle->title }}
    </span>
</div>
<div>
    <div class="w-full break-words text-sm leading-relaxed dark:text-slate-200 text-justify mt-4 h-auto p-4 bg-white dark:bg-slate-950 rounded-t-lg shadow-lg">
        {!! $activeArticle->content !!}
    </div>
    <div class="w-full flex border-t dark:border-slate-700 flex-col lg:flex-row gap-4 lg:gap-0 h-auto lg:h-20 lg:divide-x dark:divide-slate-800 py-2 overflow-hidden px-4 bg-gray-100 dark:bg-slate-850 rounded-b-lg shadow-lg">
        <div class="w-full overflow-hidden lg:w-1/3 h-20 border-b dark:border-slate-800 lg:border-none lg:h-full relative flex justify-center flex-col items-center gap-1 pl-24">
            <div @class([
                "rounded-lg w-22 h-22 absolute border-4 shadow-inner bg-cover bg-center bg-no-repeat -bottom-8 lg:-bottom-10 left-0",
                "border-blue-300 shadow-blue-500" => true,
                "border-pink-300 shadow-pink-500" => false
            ]) style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')">
                <div class="w-[64px] h-[110px] absolute bottom-2 left-2" style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=2&head_direction=2&size=m&gesture=sml')"></div>
            </div>
            <a
                href="#"
                class="truncate w-full font-semibold underline underline-offset-2 text-blue-400"
            >
                {{ $activeArticle->user->username }}
            </a>
            <span class="text-xs w-full dark:text-slate-200"><b class="text-zinc-600 dark:text-slate-200">Date:</b> {{ $activeArticle->created_at->format('Y-m-d H:i') }}</span>
        </div>
        <div class="w-full lg:w-2/3 h-full flex-col lg:flex-row relative divide-y dark:divide-slate-800 pl-2">
            <div class="w-full h-10 lg:h-1/2 flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    <div class="ml-3 text-xs font-medium text-gray-900 dark:text-gray-400">
                        Always get notifications from this author
                    </div>
                </label>
            </div>
            <div class="w-full h-10 lg:h-1/2 py-1 flex gap-1 items-center justify-start flex-wrap">
                @forelse ($activeArticle->cmsTags as $tag)
                    <span class="text-xs font-medium rounded-lg text-white px-2" style="background-color: {{ $tag->background_color }}">{{ $tag->name }}</span>
                @empty
                    <span class="text-xs text-gray-900 dark:text-gray-400">
                        No tags found.
                    </span>
                @endforelse
            </div>
        </div>
    </div>
    <div class="mt-8 flex items-center h-auto relative w-full flex-wrap gap-2">
        <x-ui.buttons.confirmable
            data-tippy-placement="top"
            class="group flex w-12 h-12 items-center justify-center bg-blue-300 dark:bg-blue-600 dark:text-white border-b-2 border-blue-500 rounded-lg"
            :exclusive="true"
        >
            <x-slot:confirmation>
                <div class="flex gap-2">
                    <x-ui.buttons.default
                        class="w-8 h-8 bg-green-400 hover:bg-green-500 text-green-800 !border-b-2 border-green-600 rounded-lg">
                        <i class="fa-solid fa-thumbs-up"></i>
                    </x-ui.buttons.defaultclass>
                    <x-ui.buttons.default
                        class="w-8 h-8 bg-red-400 hover:bg-red-500 text-red-800 !border-b-2 border-red-600 rounded-lg"
                    >
                        <i class="fa-solid fa-thumbs-down"></i>
                    </x-ui.buttons.defaultclass>
                </div>
            </x-slot:confirmation>

            <x-slot:label>
                <i class="fa-solid fa-plus text-white text-lg"></i>
            </x-slot:label>
        </x-ui.buttons.confirmable>
        @for ($i = 0; $i < 15; $i++)
            <a
                href="#"
                data-tippy-singleton
                data-tippy-content="<small>iNicollas</small>"
                @class([
                    "w-12 h-12 shadow-lg rounded-lg bg-center bg-no-repeat border-b-2 cursor-pointer",
                    "bg-green-400 border-green-600" => $i % 2 == 0,
                    "bg-red-400 border-red-600" => $i % 2 == 1,
                ])
                style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=4&head_direction=2&size=m&gesture=sml&action=sit,wav&headonly=1')"
            ></a>
        @endfor
    </div>
</div>
<div class="mt-8 w-full h-auto">
    <x-title-box
        title="Comment this Article"
        description="Write your opinion below"
        icon="comment"
    />
    <div class="bg-white w-full h-auto dark:bg-slate-950 p-1 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg mt-8">
        <form method="POST">
            <x-ui.textarea />
        </form>
    </div>
    <div class="my-8 w-full h-auto">
        <x-title-box
            title="Article Comments ({{ random_int(5, 100) }})"
            description="All comments of this article"
            icon="users-comments"
        />
    </div>
    <div class="w-full flex flex-col gap-4">
        @for ($i = 0; $i < 2; $i++)
        <div class="bg-white relative w-full flex flex-col overflow-hidden justify-between h-auto dark:text-slate-200 dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
            <div class="p-2 w-full">
                <div class="w-full flex justify-between text-sm pb-0.5 mb-2 border-b border-gray-100 dark:border-gray-800">
                    <span class="w-1/2 font-medium"><a href="#" class="font-bold underline underline-offset-2 text-blue-400">iNicollas</a> commented:</span>
                    <span class="w-1/2 text-end text-xs text-slate-400">
                        <i class="fa-regular fa-clock"></i>
                        12 hours ago
                    </span>
                </div>
                <div class="w-full text-sm text-justify dark:text-light-200 mb-4">
                    {{ fake()->sentence(random_int(10, 100)) }}
                </div>
            </div>
            <div class="w-full h-14 p-1 bg-gray-100 dark:bg-slate-800 rounded-b-lg border-t dark:border-gray-700">
                <div class="w-full relative rounded-lg h-full bg-right-bottom bg-no-repeat">
                    <div class="absolute -bottom-8 left-2 w-[73px] h-[57px] bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/stage.png') }}')"></div>
                    <div
                        class="absolute -bottom-6 left-2 w-[64px] h-[110px] bg-center bg-no-repeat"
                        style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=2&head_direction=2&size=m&gesture=sml&action=sit,wav')"
                    ></div>
                    <div class="w-full h-full items-center pl-20 flex gap-2">
                        @for ($j = 0; $j < 5; $j++)
                            <div class="w-[48px] bg-center bg-no-repeat h-[48px] rounded-lg bg-white dark:bg-slate-700 dark:border-slate-600 border" style="background-image: url('{{ asset('assets/images/default_badge.gif') }}')"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
