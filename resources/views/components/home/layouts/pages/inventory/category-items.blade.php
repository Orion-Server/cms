<div class="flex flex-wrap gap-2 max-h-full overflow-y-auto px-2">
    <template x-if="inventoryStore.delay">
        <div class="h-[300px] w-full flex justify-center items-center">
            <div class="orion-loader"></div>
        </div>
    </template>
    <template x-if="!inventoryStore.delay">
        <template>
            <div
                class="flex flex-col w-22 h-28 border-2 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer hover:!border-blue-400 rounded-md"
                :class="{ '!border-blue-500': false, '!border-green-500': false }"
            >
                <div
                    class="w-full h-22 bg-no-repeat bg-center rounded-t-md border-b-2 dark:border-slate-600"
                    :class="{ '!border-green-500': false, 'bg-cover no-pixelated': false }"
                    :style="{ backgroundImage: `url(${value.items[0].home_item.image})` }"
                ></div>
                <div
                    class="w-full h-6 px-1 flex justify-center items-center gap-1 bg-slate-100 dark:bg-slate-700 rounded-b-sm"
                    :class="{ '!bg-green-400': false }"
                >
                    <span class="dark:text-white text-xs" :class="{ '!text-slate-800': false }">2</span>
                </div>
            </div>
        </template>
    </template>
</div>
