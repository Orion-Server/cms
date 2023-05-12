<x-title-box
    icon="online-friends"
    title="Online Friends ({{ $onlineFriends->count() }})"
    description="See which friends are online now"
/>
<div @class([
    "flex gap-3 scroll-smooth scroll-x relative mt-4 p-2 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950",
    "pb-6" => $onlineFriends->isNotEmpty()
]) x-data="onlineFriends('{{ route('hotel.rcon.follow-user', ':userId') }}')">
    @forelse ($onlineFriends as $onlineFriend)
        <div
            @click="followUser('{{ $onlineFriend->id }}')"
            data-tippy
            data-tippy-content="<small>{{ $onlineFriend->motto }}</small>"
            class="w-14 h-14 relative shrink-0 rounded-full dark:bg-slate-800 border border-gray-300 dark:border-slate-700 p-0.5 cursor-pointer"
        >
            <div class="w-full h-full rounded-full bg-center bg-no-repeat" style="background-image: url('{{ getSetting('figure_imager') . $onlineFriend->look }}&head_direction=3&gesture=sml&headonly=1')"></div>
            <div class="absolute max-w-[100%] truncate text-xs -bottom-5 left-1/2 -translate-x-1/2 dark:text-slate-200">{{ $onlineFriend->username }}</div>
        </div>
    @empty
    <span class="block text-xs text-slate-700 p-2 dark:text-slate-200">
        <i class="fa-regular fa-circle-xmark mr-2"></i>
        Not found
    </span>
    @endforelse
</div>
