@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'image' => null,
    'small' => false,
    'imageIsBadge' => false,
    'titleClasses' => "font-semibold dark:text-white",
    'descriptionClasses' => "text-slate-700 dark:text-slate-400",
])

<div class="w-full lg:h-16 flex-col lg:flex-row flex justify-between">
    <div @class([
        "h-full flex justify-start items-center",
        'w-full lg:w-2/3' => $slot->isNotEmpty(),
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
                        "w-12 h-12 rounded-full" => !$imageIsBadge
                    ])>
                </i>
            @endif
        </div>
        <div class="flex flex-col">
            <span @class([
                $titleClasses,
                "text-sm" => $small,
            ])>{!! $title !!}</span>
            <span @class([
                $descriptionClasses,
                "text-xs" => $small,
                "text-sm" => !$small
            ])>{!! $description !!}</span>
        </div>
    </div>
    @if ($slot->isNotEmpty())
    <div class="lg:w-1/3 h-full mt-2 lg:mt-0">
        <div class="w-full h-full flex justify-end items-center gap-3">
            {{ $slot }}
        </div>
    </div>
    @endif
</div>
