<x-title-box
    title="{{ __('Your In-game Preferences') }}"
    description="{{ __('All settings below are automatically applied in-game if you are online.') }}"
    icon="security-settings"
/>

<div
    x-data="ingameSettings(
        '{{ route('users.settings.index', 'ingame') }}',
        '{{ $user->motto }}',
        @json(! $user->settings->block_friendrequests),
        @json(! $user->settings->block_following),
        @json(! $user->settings->block_roominvites),
        @json(!! $user->settings->old_chat),
        @json(!! $user->settings->block_camera_follow)
    )"
>
    <form
        class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg"
        action="{{ route('users.settings.index', 'ingame') }}"
        method="POST"
        @submit.prevent="submitForm"
    >
        @unless (config('hotel.rcon.enabled'))
        <span class="w-full text-center py-3 bg-sky-400 text-white rounded-lg border border-b-2 border-sky-500 text-sm font-bold">
            <i class="fa-solid fa-info-circle mr-1"></i>
            {{ __('You need to be offline to apply these changes.') }}
        </span>

        <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
        @endunless

        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Motto') }}"
                autocomplete="motto"
                id="current-motto"
                icon="fa-solid fa-pen-to-square"
                placeholder="..."
                alpine-model="data.motto"
                type="text"
            />
        </div>

        <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>

        <div class="flex flex-col gap-1">
            <x-ui.toggle
                label="{{ __('Receive friend requests') }}"
                alpine-model="data.receiveFriendRequests"
                :small="false"
            />
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.toggle
                alpine-model="data.allowFriendsFollow"
                label="{{ __('Allow other users to follow you') }}"
                :small="false"
            />
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.toggle
                alpine-model="data.allowRoomInvites"
                label="{{ __('Receive room invites') }}"
                :small="false"
            />
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.toggle
                alpine-model="data.oldChat"
                label="{{ __('Use old chat version') }}"
                :small="false"
            />
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.toggle
                alpine-model="data.blockCameraFollow"
                label="{{ __('Block the camera from following your avatar') }}"
                :small="false"
            />
        </div>

        <div class="flex justify-end gap-4 items-center">
            <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
            <x-ui.buttons.loadable
                alpine-model="loading"
                type="submit"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 py-3 text-white"
            >
                <i class="fa-solid fa-gamepad mr-2"></i>
                {{ __('Update Settings') }}
            </x-ui.buttons.loadable>
        </div>
    </form>
</div>
