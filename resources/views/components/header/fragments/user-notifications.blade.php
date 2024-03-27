<div
    class="absolute top-full min-w-full z-[20] cursor-default"
    x-show="opened"
    x-transition.origin.top.center
    style="display: none"
>
    <div class="w-96 max-w-full max-h-96 relative bg-white dark:bg-slate-800 rounded-lg shadow-lg mt-2">
        <div class="absolute h-2 w-2 bg-white dark:bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>

        <div class="flex flex-col max-h-96 overflow-y-auto">
            <template x-if="loading">
                <div class="h-[300px] w-full flex justify-center items-center">
                    <div class="orion-loader"></div>
                </div>
            </template>

            <template x-if="!loading">
                <template x-for="notification of notifications" :key="notification.id">
                    <div
                        x-on:click.self="notification.url && Turbolinks.visit(notification.url)"
                        x-bind:class="notification.url && 'cursor-pointer'"
                        class="hover:bg-slate-100 first-of-type:rounded-t-lg dark:hover:bg-slate-700 h-14 flex gap-2 overflow-hidden border-b dark:border-slate-700"
                    >
                        <div
                            class="w-[64px] -mt-4 h-[110px] bg-center bg-no-repeat"
                            x-bind:style="{ backgroundImage: getAvatarFigure(notification.sender.look, 'direction=2&head_direction=2&size=m&gesture=sml') }"
                        ></div>
                        <div class="flex-1 flex flex-col h-full justify-center max-w-72">
                            <span class="text-sm text-slate-600 dark:text-slate-100 font-medium flex gap-1">
                                <a
                                    x-bind:href="`/profile/${notification.sender.username}`"
                                    class="hover:underline underline-offset-2"
                                    x-bind:class="{ 'text-blue-500': notification.sender.gender === 'M', 'text-pink-400': notification.sender.gender === 'F' }"
                                    x-text="notification.sender.username"
                                ></a>
                                <span class="w-full truncate" x-text="notification.message"></span>
                            </span>
                            <div class="flex gap-1 items-center">
                                <span class="max-w-60 truncate text-xs text-slate-500 dark:text-slate-400" x-text="notification.formatted_date"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</div>
