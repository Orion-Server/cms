@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'image' => null,
    'small' => false,
    'imageIsBadge' => false
])

<div class="w-full h-16 flex justify-between">
    <div @class([
        "h-full flex justify-start items-center",
        'w-2/3' => $slot->isNotEmpty(),
        'w-full' => $slot->isEmpty()
    ])>
        <div @class([
            "w-16 h-full flex items-center",
            "justify-start" => !$imageIsBadge,
            "justify-center" => $imageIsBadge
        ])>
            @if ($icon)
                <i class="icon big {{ $icon }}"></i>
            @elseif ($image)
                <i class="icon big">
                    <img src="{{ $image }}" alt="" @class([
                        "rounded-full",
                        "w-12 h-12" => !$imageIsBadge
                    ])>
                </i>
            @endif
        </div>
        <div class="flex flex-col">
            <span @class([
                "font-semibold dark:text-white",
                "text-sm" => $small,
            ])>{!! $title !!}</span>
            <span @class([
                "text-slate-700 dark:text-slate-400",
                "text-xs" => $small,
                "text-sm" => !$small
            ])>{!! $description !!}</span>
        </div>
    </div>
    @if ($slot->isNotEmpty())
    <div class="w-1/3 h-full">
        <div class="w-full h-full flex justify-end items-center gap-3">
            {{ $slot }}
        </div>
    </div>
    @endif
</div>
