<div
    class="absolute top-full min-w-full z-[1000] cursor-default"
    x-show="opened"
    x-transition.origin.top.center
    style="display: none"
>
    <div class="w-96 max-w-full max-h-96 relative bg-white dark:bg-slate-800 rounded-lg shadow-lg mt-2">
        <div class="absolute h-2 w-2 bg-white dark:bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>

        <div class="flex flex-col max-h-96">
            <template x-if="loading">
                <div class="h-[300px] w-full flex justify-center items-center">
                    <div class="orion-loader"></div>
                </div>
            </template>

            <template x-if="!loading && notifications.length">
                <div class="py-1 px-2 flex justify-between mb-1 border-b dark:border-slate-700">
                    <span
                        class="cursor-pointer text-sm hover:underline underline-offset-2 text-blue-500 hover:text-blue-400"
                        @click="markAllAsRead"
                    >
                        <i class="fa-solid fa-check"></i>
                        {{ __('Mark All as Read') }}
                    </span>
                    <span
                        class="cursor-pointer text-sm hover:underline underline-offset-2 text-red-500 hover:text-red-400"
                        @click="deleteAllNotifications"
                    >
                        <i class="fa-solid fa-trash"></i>
                        {{ __('Delete All') }}
                    </span>
                </div>
            </template>

            <div class="h-full overflow-y-auto">
                <template x-if="!loading && notifications.length">
                    <template x-for="notification of notifications" :key="notification.id">
                        <div
                            x-on:click="visitNotification(notification)"
                            x-bind:class="{
                                'cursor-pointer': notification.url,
                                'bg-slate-100 dark:bg-slate-700': notification.state === 'read',
                                'hover:bg-slate-100 dark:hover:bg-slate-700': notification.state === 'seen',
                            }"
                            class="first-of-type:rounded-t-lg h-16 py-1 flex gap-2 overflow-hidden border-b dark:border-slate-700 group"
                        >
                            <template x-if="notification.sender !== null">
                                <div
                                    class="w-[64px] -mt-4 h-[110px] bg-center bg-no-repeat"
                                    x-bind:style="{ backgroundImage: getAvatarFigure(notification.sender.look, 'direction=2&head_direction=2&size=m&gesture=sml') }"
                                ></div>
                            </template>
                            <template x-if="notification.sender === null">
                                <div
                                    class="w-[64px] h-[64px] bg-center bg-no-repeat"
                                    style="background-image: url({{ getSetting('staff_notification_image') }})"
                                ></div>
                            </template>
                            <div class="flex-1 flex flex-col h-full justify-center max-w-72">
                                <span class="text-sm text-slate-600 dark:text-slate-100 font-medium flex gap-1 group-hover:underline underline-offset-2">
                                    <span class="w-full leading-4">
                                        <template x-if="notification.sender !== null">
                                            <a
                                                class="hover:underline underline-offset-2 cursor-pointer"
                                                @click.stop="Turbolinks.visit('/profile/' + notification.sender.username)"
                                                x-bind:class="{ 'text-blue-500': notification.sender.gender === 'M', 'text-pink-400': notification.sender.gender === 'F' }"
                                                x-text="notification.sender.username"
                                            ></a>
                                        </template>
                                        <span x-text="notification.message"></span>
                                    </span>
                                </span>
                                <div class="flex gap-1 items-center mt-1">
                                    <span class="max-w-60 truncate text-xs text-slate-500 dark:text-slate-400" x-text="notification.formatted_date"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
                <template x-if="!loading && !notifications.length">
                    <div class="rounded-t-lg h-16 py-1 flex justify-center items-center gap-1">
                        <i class="fa-regular fa-bell"></i>
                        <span class="text-slate-500 text-sm dark:text-slate-400">{{ __('Your notification box is empty!') }}</span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
