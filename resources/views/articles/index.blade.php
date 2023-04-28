@extends('layouts.app')

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
                                "!border-blue-400 !text-blue-400 border-l" => $j == 3
                            ])
                            href=""
                        >
                            {{ fake()->sentence() }} <span class="text-blue-400">»</span>
                        </a>
                    @endfor
                @endfor
            </div>
        </div>
        <div class="h-48 w-full lg:w-3/4">
            <div
                class="w-full !bg-cover !bg-no-repeat !bg-center h-16 flex rounded-lg shadow-lg justify-between border-b-2 border-gray-300 dark:border-slate-800"
                style="background: linear-gradient(to right, blue 50%, transparent), url('http://localhost/assets/images/user-box-bg.gif')"
            >
                <span class="w-full h-full font-semibold text-white flex items-center justify-start py-2 px-4">
                    {{ fake()->sentence() }}
                </span>
            </div>
            <div class="w-full break-words text-sm leading-relaxed dark:text-slate-200 text-justify mt-4 h-auto p-4 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                {{ fake()->paragraphs(10, true) }}
            </div>
        </div>
    </div>
</x-container>
@endsection
