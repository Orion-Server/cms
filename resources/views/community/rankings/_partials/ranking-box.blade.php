@props([
    'title' => null,
    'icon' => null
])

<div class="w-full flex flex-col gap-4">
    <x-title-box
        icon="{{ $icon }}"
        title="{{ $title }}"
        description="This is customizable"
    />
    <div class="bg-white h-auto dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
        <div class="w-full flex flex-col p-2">
            @for ($j = 1; $j <= 10; $j++)
                <div @class([
                    "flex bg-white hover:bg-slate-100 hover:dark:bg-slate-700 odd:bg-gray-100 group first:rounded-t-lg last:rounded-b-lg border-b border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:odd:bg-slate-850",
                    "h-auto" => $j < 3,
                    "h-12" => $j >= 3
                ])>
                    <div class="w-14 h-full overflow-hidden flex items-center justify-center group-first:rounded-tl-lg group-last:rounded-bl-lg">
                        <div
                            class="w-[54px] h-14 bg-center bg-no-repeat"
                            style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=3&head_direction=2&size=m&headonly=1')"
                        ></div>
                    </div>
                    <div class="w-full h-auto flex divide-x dark:divide-slate-700 overflow-hidden">
                        <a
                            href="#"
                            @class([
                                "w-2/3 hover:text-blue-500 dark:text-slate-200  h-full flex justify-start pl-3 items-center truncate",
                                "font-medium" => $j <= 3,
                                "font-normal text-sm" => $j > 3
                            ])
                        >
                            <span @class([
                                "px-2 py-1 rounded-full text-white font-bold text-xs mr-2",
                                "bg-yellow-400" => $j == 1,
                                "bg-zinc-400" => $j == 2,
                                "bg-amber-500" => $j == 3,
                                "!text-slate-800 dark:!text-slate-200" => $j > 3,
                            ])>{{ str_pad($j, 2, '0', STR_PAD_LEFT) }}</span>
                            iNicollas
                        </a>
                        <div class="w-1/3 h-full flex text-sm font-bold justify-center items-center dark:text-slate-200">
                            {{ random_int(1000, 340000) }}
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
