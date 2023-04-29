@extends('layouts.app')

@section('title', 'Article Page')

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
                @for ($i = 0; $i < 3; $i++)
                    <div @class([
                        "border-b font-semibold pb-2 mb-4 text-sm text-slate-800 dark:text-white border-dashed border-slate-400 dark:border-slate-800",
                        "mt-4" => $i != 0
                    ])>
                        Latest week
                    </div>
                    @for ($j = 0; $j < random_int(5, 10); $j++)
                        <a
                            data-tippy-singleton
                            data-tippy-content="<small>Posted by <b>iNicollas</b></small>"
                            @class([
                                "dark:text-slate-300 text-sm py-1.5 border-l border-slate-300 hover:!border-slate-400 hover:border-l dark:border-slate-600 pl-3 decoration-slate-400 hover:!text-blue-400",
                                "!border-blue-400 !text-blue-400 border-l" => $j == 3,
                                "!border-lime-400" => $j == 2
                            ])
                            href=""
                        >
                            {{ fake()->sentence() }} <span class="text-blue-400">»</span>
                        </a>
                    @endfor
                @endfor
            </div>
        </div>
        <div class="h-auto w-full flex flex-col lg:w-3/4">
            <div
                class="w-full !bg-cover !bg-no-repeat !bg-center h-16 flex rounded-lg shadow-lg justify-between border-b-2 border-gray-300 dark:border-slate-800"
                style="background: linear-gradient(to right, blue 50%, transparent), url('{{ asset('assets/images/user-box-bg.gif') }}')"
            >
                <span class="w-full h-full font-semibold text-white flex items-center justify-start py-2 px-4">
                    {{ fake()->sentence() }}
                </span>
            </div>
            <div class="divide-y divide-gray-300 dark:divide-slate-700">
                <div class="w-full break-words text-sm leading-relaxed dark:text-slate-200 text-justify mt-4 h-auto p-4 bg-white dark:bg-slate-950 rounded-t-lg shadow-lg">
                    {{ fake()->paragraphs(10, true) }}
                </div>
                <div class="w-full flex flex-col lg:flex-row gap-4 lg:gap-0 h-auto lg:h-20 lg:divide-x dark:divide-slate-800 py-2 overflow-hidden px-4 bg-gray-100 dark:bg-slate-850 rounded-b-lg shadow-lg">
                    <div class="w-full overflow-hidden lg:w-1/3 h-20 border-b dark:border-slate-800 lg:border-none lg:h-full relative flex justify-center flex-col items-center gap-1 pl-24">
                        <div @class([
                            "rounded-lg w-22 h-22 absolute border-4 shadow-inner bg-cover bg-center bg-no-repeat -bottom-8 lg:-bottom-10 left-0",
                            "border-blue-300 shadow-blue-500" => true,
                            "border-pink-300 shadow-pink-500" => false
                        ]) style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')">
                            <div class="w-[64px] h-[110px] absolute bottom-2 left-2" style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=ferrazmatheus&direction=2&head_direction=2&size=m&gesture=sml')"></div>
                        </div>
                        <a
                            href="#"
                            class="truncate w-full font-semibold underline underline-offset-2 text-blue-400"
                        >
                            iNicollas
                        </a>
                        <span class="text-xs w-full dark:text-slate-200"><b class="text-zinc-600 dark:text-slate-200">Date:</b> 23/03/2020 10:40</span>
                    </div>
                    <div class="w-full lg:w-2/3 h-full flex-col lg:flex-row relative divide-y dark:divide-slate-800 pl-2">
                        <div class="w-full h-10 lg:h-1/2 flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <div class="ml-3 text-xs font-medium text-gray-900 dark:text-gray-400">
                                    Always get notifications from this author
                                </div>
                            </label>
                        </div>
                        <div class="w-full h-10 lg:h-1/2 py-1 flex gap-1 items-center justify-start flex-wrap">
                            @for ($i = 0; $i < 15; $i++)
                                <div
                                    data-tippy-singleton
                                    data-tippy-content="iNicollas"
                                    @class([
                                        "w-7 h-full rounded-full bg-center bg-no-repeat hover:scale-110 transition-all duration-300 cursor-pointer",
                                        "bg-green-400" => $i % 2 == 0,
                                        "bg-red-400" => $i % 2 == 1,
                                    ])
                                    style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=ferrazmatheus&direction=4&head_direction=2&size=s&gesture=sml&action=sit,wav&headonly=1')"
                                ></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 w-full h-auto">
                <x-title-box
                    title="Article Comments ({{ random_int(5, 100) }})"
                    description="All comments of this article"
                    icon="comment"
                />
                <div class="bg-white w-full h-auto dark:bg-slate-950 p-1 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg mt-8">
                    <form>
                        <x-ui.textarea />
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-container>
@endsection
