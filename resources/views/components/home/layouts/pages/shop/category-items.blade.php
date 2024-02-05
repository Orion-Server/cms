<div class=" flex flex-wrap gap-1 max-h-full justify-start items-start overflow-y-auto px-2">
    <template x-if="shopStore.delay">
        <div class="h-[300px] w-full flex justify-center items-center">
            <div class="orion-loader"></div>
        </div>
    </template>
    <template x-if="!shopStore.delay">
        <template x-for="item in shopStore.categoryTabItems" :key="item.id">
            <div
                class="flex flex-col w-22 h-28 border-2 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer hover:!border-blue-400 rounded-md"
                :class="{ '!border-blue-500': item.id === shopStore.activeItem?.id }"
                @click="shopStore.selectItem(item)"
            >
                <div
                    class="w-full h-22 bg-no-repeat bg-center rounded-t-md border-b-2 dark:border-slate-600"
                    :style="{ backgroundImage: `url(${item.image})` }"
                ></div>
                <div class="w-full h-6 px-1 flex justify-end items-center gap-1 bg-slate-100 dark:bg-slate-700 rounded-b-sm">
                    <span class="dark:text-white text-[0.65rem]" x-text="item.price"></span>
                    <img :src="shopStore.getCurrencyIcon(item)" alt="Coin">
                </div>
            </div>
        </template>
    </template>
</div>
