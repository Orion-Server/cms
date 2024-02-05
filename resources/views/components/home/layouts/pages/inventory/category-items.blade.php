<div class="flex flex-wrap gap-1 max-h-full overflow-y-auto px-2">
    <template x-if="inventoryStore.delay">
        <div class="h-[300px] w-full flex justify-center items-center">
            <div class="orion-loader"></div>
        </div>
    </template>
    <template x-if="!inventoryStore.delay">
        <template x-for="homeItemData in inventoryStore.getItemsForCurrentTab()" :key="homeItemData.home_item_id">
            <div
                class="flex flex-col w-22 h-28 border-2 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer hover:!border-blue-400 rounded-md"
                :class="{ '!border-blue-500': inventoryStore.activeItem?.home_item_id == homeItemData.home_item_id, '!border-green-500': false }"
                @click="inventoryStore.selectItem(homeItemData)"
            >
                <div
                    class="w-full h-22 bg-no-repeat bg-center rounded-t-md border-b-2 dark:border-slate-600"
                    :class="{ '!border-green-500': false, 'bg-cover no-pixelated': inventoryStore.currentTab == 'backgrounds', 'h-28': ['backgrounds', 'widgets'].includes(inventoryStore.currentTab) }"
                    :style="{ backgroundImage: `url(${homeItemData?.home_item.image})` }"
                ></div>
                <template x-if="['stickers', 'notes'].includes(inventoryStore.currentTab)">
                    <div
                        class="w-full h-6 px-1 flex justify-center items-center gap-1 bg-slate-100 dark:bg-slate-700 rounded-b-sm"
                        :class="{ '!bg-green-400': false }"
                    >
                        <span class="dark:text-white text-xs" :class="{ '!text-slate-800': false }" x-text="homeItemData?.item_ids?.length"></span>
                    </div>
                </template>
            </div>
        </template>
    </template>
</div>
