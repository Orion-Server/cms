<x-title-box
    icon="online-friends"
    title="{{ __('Online Friends') }} ({{ $onlineFriends->count() }})"
    description="{{ __('See which friends are online now') }}"
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
            class="w-14 hover:bg-gray-100 dark:hover:bg-slate-700 h-14 relative shrink-0 rounded-full dark:bg-slate-800 border border-gray-300 dark:border-slate-700 p-0.5 cursor-pointer"
        >
            <div @class([
                "w-full h-full rounded-full bg-no-repeat",
                "bg-center" => !$usingNitroImager,
                "bg-[-20px_-27px]" => $usingNitroImager
            ]) style="background-image: url('{{ getFigureUrl($onlineFriend->look, 'head_direction=3&gesture=sml&headonly=1') }}')"></div>
            <div class="absolute max-w-[100%] truncate text-xs -bottom-5 left-1/2 -translate-x-1/2 dark:text-slate-200">{{ $onlineFriend->username }}</div>
        </div>
    @empty
        <div class="flex items-center justify-center gap-2 w-full">
            <i class="fa-solid fa-users-slash text-gray-300 dark:text-slate-600"></i>
            <span class="text-gray-400 dark:text-slate-500 text-sm py-5">{{ __('No friends online') }}</span>
        </div>
    @endforelse
</div>
