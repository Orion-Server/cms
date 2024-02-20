@props([
    'icon' => null,
    'title' => null,
    'description' => null,
    'rankings' => null,
])

@php($getUser = fn ($property) => $property instanceof \App\Models\User
    ? $property
    : $property->user
)

<div class="w-full flex flex-col gap-4">
    <x-title-box
        icon="{{ $icon }}"
        title="{{ $title }}"
        description="{{ $description }}"
    />
    <div class="bg-white h-auto dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
        <div class="w-full flex flex-col p-2 min-h-[523px]">
            @foreach ($rankings as $index => $ranking)
                <div @class([
                    "flex bg-white hover:bg-slate-100 hover:dark:bg-slate-700 odd:bg-gray-100 group first:rounded-t-lg last:rounded-b-lg border-b border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:odd:bg-slate-850",
                    "h-auto" => $index < 3,
                    "h-12" => $index >= 3
                ])>
                    <div class="w-14 h-full overflow-hidden flex items-center justify-center group-first:rounded-tl-lg group-last:rounded-bl-lg">
                        <div
                            @class([
                                "w-[54px] h-14 bg-no-repeat",
                                "bg-center" => !$usingNitroImager,
                                "bg-[-18px_-25px]" => $usingNitroImager
                            ])
                            style="background-image: url('{{ $getUser($ranking)->figure_path }}&direction=3&head_direction=2&size=m&headonly=1')"
                        ></div>
                    </div>
                    <div class="w-full h-auto flex divide-x dark:divide-slate-700 overflow-hidden">
                        <a
                            href="{{ route('users.profile.show', $getUser($ranking)->username) }}"
                            @class([
                                "w-2/3 hover:text-blue-500 dark:text-slate-200  h-full flex justify-start pl-3 items-center truncate",
                                "font-medium" => $index < 3,
                                "font-normal text-sm" => $index > 2
                            ])
                        >
                            <span @class([
                                "px-2 py-1 rounded-full text-white font-bold text-xs mr-2",
                                "bg-yellow-400" => $index == 0,
                                "bg-zinc-400" => $index == 1,
                                "bg-amber-500" => $index == 2,
                                "!text-slate-800 dark:!text-slate-200" => $index > 2,
                            ])>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            {{ $getUser($ranking)->username }}
                        </a>
                        <div class="w-1/3 h-full flex text-sm font-bold justify-center items-center dark:text-slate-200">
                            {{ $icon != 'online-time'
                                ? $ranking->value
                                : __(':m minutes', ['m' => round(CarbonInterval::seconds($ranking->value)->totalMinutes)]) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
