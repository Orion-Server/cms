@php($randomStories = random_int(12, 20))

<x-title-box
    icon="story-camera"
    title="{{ __('Friends Stories') }} ({{ $randomStories }})"
    description="{{ __('Stay on top of your friends latest activities') }}"
/>
<div class="flex gap-3 scroll-smooth scroll-x relative mt-4 p-2 pb-6 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
    @for ($i = 0; $i < $randomStories; $i++)
        <div
            data-tippy-singleton
            data-tippy-content="<small>2 minutes ago</small>"
            @class([
                "w-16 h-16 relative shrink-0 rounded-full bg-gray-100 dark:bg-slate-800 border-2 p-0.5 cursor-pointer",
                "border-green-500" => $i % 2 == 0,
                "border-gray-400 dark:border-slate-700" => $i % 2 == 1
            ])>
            <div class="w-full h-full rounded-full bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')"></div>
            <div class="absolute max-w-[100%] truncate text-xs -bottom-5 left-1/2 -translate-x-1/2 dark:text-slate-200">iNicollas</div>
        </div>
    @endfor
</div>
