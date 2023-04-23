@props([
    'title' => '',
    'description' => '',
    'icon' => 'users',
    'color' => 'slate-400',
    'extraBoxClasses' => '',
    'buttonLabel' => '',
    'buttonLink' => '#',
    'buttonClasses' => 'bg-slate-800 hover:bg-slate-900 text-white',
])

<div class="flex flex-col w-full lg:max-w-1/3">
    <div class="w-full flex justify-start items-center gap-3">
        <i class="icon {{ $icon }}"></i>
        <div class="flex flex-col">
            <span class="text-white font-semibold">{{ $title }}</span>
            @if (!empty($description))
            <span class="dark:text-slate-200 text-gray-100 font-normal text-xs">{{ $description }}</span>
            @endif
        </div>
        @if (!empty($buttonLabel))
            <div class="flex flex-col ml-auto">
                <a href="{{ $buttonLink }}" class="p-2 text-xs font-semibold rounded-lg {{ $buttonClasses }}">{{ $buttonLabel }}</a>
            </div>
        @endif
    </div>
    <div class="w-full flex justify-start items-start gap-1 overflow-hidden flex-wrap mt-4 {{ $extraBoxClasses }}">
        {{ $slot }}
    </div>
</div>
