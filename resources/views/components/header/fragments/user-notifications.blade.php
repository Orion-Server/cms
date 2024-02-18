<div
    class="absolute top-full min-w-full z-[20] cursor-default"
    x-show="opened"
    x-transition.origin.top.center
    style="display: none"
>
    <div class="w-72 h-96 relative bg-white dark:bg-slate-800 rounded-lg shadow-lg mt-2">
        <div class="absolute h-2 w-2 bg-white dark:bg-gray-800 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>

        <div class="flex flex-col gap-1">
            <template x-if="loading">
                <div class="h-[300px] w-full flex justify-center items-center">
                    <div class="orion-loader"></div>
                </div>
            </template>
            <template x-if="!loading" x-for="notification of notifications" :key="notification.id">
                <div class="hover:bg-slate-100 dark:hover:bg-slate-750 rounded-lg h-12">

                </div>
            </template>
        </div>
    </div>
</div>
