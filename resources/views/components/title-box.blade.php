@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'buttonLabel' => null,
    'buttonLink' => null
])

<div class="w-full h-16 flex justify-between">
    <div class="w-2/3 h-full flex justify-start items-center">
        <div class="w-16 h-full flex justify-start items-center">
            <i class="icon big {{ $icon }}"></i>
        </div>
        <div class="flex flex-col">
            <span class="font-semibold dark:text-white">{{ $title }}</span>
            <span class="text-slate-700 dark:text-slate-400 text-sm">{{ $description }}</span>
        </div>
    </div>
    <div class="w-1/3 h-full">
        <div class="w-full h-full flex justify-end items-center gap-3">
            {{ $slot }}
        </div>
    </div>
</div>
