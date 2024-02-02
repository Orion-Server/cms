<x-title-box
    icon="story-camera"
    title="{{ __('Friends Stories') }}"
    description="{{ __('Stay on top of your friends latest activities') }}"
/>
<div
    x-data='friendStories(@json($friendStories))'
    class="flex justify-start gap-3 scroll-smooth scroll-x relative mt-4 p-2 pb-6 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950"
>
    @forelse ($friendStories as $friendName => $stories)
        <div
            @click="onStoryClick('{{ $friendName }}')"
            data-tippy-singleton
            data-tippy-content="<small>{{ $stories->first()->timestamp }}</small>"
            @class([
                "w-16 h-16 relative shrink-0 rounded-full bg-gray-100 dark:bg-slate-800 border-2 p-0.5 cursor-pointer"
            ])>
            <div class="w-full h-full rounded-full bg-center bg-no-repeat bg-cover" style="background-image: url('{{ $stories->first()->avatar_background ?? getSetting('default_avatar_background') }}')"></div>
            <div class="absolute max-w-[100%] truncate text-xs -bottom-5 left-1/2 -translate-x-1/2 dark:text-slate-200">{{ $friendName }}</div>
        </div>

    @empty
        <div class="flex items-center justify-center gap-2 w-full">
            <i class="fa-solid fa-camera-retro text-gray-300 dark:text-slate-600"></i>
            <span class="text-gray-400 dark:text-slate-500 text-sm py-5">{{ __('No stories available.') }}</span>
        </div>
    @endforelse

    <x-ui.story-modal x-if="currentStoryName" />
</div>
