<div class="w-full flex h-full flex-col pl-2 gap-2">
    <div class="border border-slate-200 py-2 bg-slate-100 dark:bg-slate-800 dark:border-black/50 flex gap-1 rounded-md justify-center items-center px-2">
        <span class="dark:text-white text-xs" x-text="inventoryStore.activeItem?.home_item.name"></span>
    </div>
    <div
        class="flex flex-col w-full h-40 border dark:border-slate-800 rounded-md bg-no-repeat bg-center transition-[background-image]"
        :class="{'bg-cover no-pixelated': inventoryStore.currentTab == 'backgrounds'}"
        :style="{ backgroundImage: `url(${inventoryStore.activeItem?.home_item.image})` }"
    ></div>
    <di class="flex flex-col gap-2">
        <template x-if="inventoryStore.canPlaceMultipleItems()">
            <div class="flex gap-2 items-center">
                <x-ui.input
                    label='<i class="fa-solid fa-arrow-up-wide-short fa-xl"></i>'
                    label-classes="!mb-0"
                    alpine-model="inventoryStore.placeQuantity"
                    type="number"
                    :small="true"
                />
            </div>
        </template>
        <div class="flex flex-col gap-2">
            <x-ui.buttons.loadable
                alpine-model="inventoryStore.loadingPlacedItem"
                class="dark:bg-green-600 w-full !gap-0 bg-green-500 !py-2 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 text-white"
                @click="inventoryStore.placeActiveItem()"
            >
                {{ __('Place') }}
                (<span class="m-0" x-text="inventoryStore.placeQuantity"></span>)
            </x-ui.buttons.loadable>
            <template x-if="inventoryStore.canPlaceAllItems()">
                <x-ui.buttons.default
                    class="dark:bg-blue-600 w-full bg-blue-500 !py-2 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 text-white"
                    @click="inventoryStore.placeActiveItem(true)"
                >
                    {{ __('Place All') }}
                </x-ui.buttons.default>
            </template>
        </div>
    </div>
</div>
