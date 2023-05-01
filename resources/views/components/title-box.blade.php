@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'image' => null
])

<div class="w-full h-16 flex justify-between">
    <div @class([
        "h-full flex justify-start items-center",
        'w-2/3' => $slot->isNotEmpty(),
        'w-full' => $slot->isEmpty()
    ])>
        <div class="w-16 h-full flex justify-start items-center">
            @if ($icon)
                <i class="icon big {{ $icon }}"></i>
            @elseif ($image)
                <img src="{{ $image }}" alt="" class="w-12 h-12 rounded-full">
            @endif
        </div>
        <div class="flex flex-col">
            <span class="font-semibold dark:text-white">{{ $title }}</span>
            <span class="text-slate-700 dark:text-slate-400 text-sm">{{ $description }}</span>
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
