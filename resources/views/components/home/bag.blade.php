<div class="flex justify-start items-start mb-3">
    <x-ui.buttons.default
        @click="openInventory()"
        x-bind:disabled="bagTab == 'inventory'"
        class="dark:bg-blue-600 rounded-r-none bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 text-white"
    >
        {{ __('Inventory') }}
        <template>
            <span class="px-1 rounded-full font-bold text-xs bg-blue-400">2</span>
        </template>
    </x-ui.buttons.default>

    <x-ui.buttons.default
        @click="openShop()"
        x-bind:disabled="bagTab == 'shop'"
        class="dark:bg-orange-600 rounded-l-none bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-500 dark:shadow-orange-700/75 shadow-orange-600/75 text-white"
    >
        {{ __('Shop') }}
    </x-ui.buttons.default>
</div>
<div class="flex justify-around h-[350px] divide-x dark:divide-slate-800">
    <div class="w-1/4 h-full overflow-y-auto">
        <template x-if="currentBagTabIs('inventory')">
            <x-home.layouts.inventory-menu />
        </template>

        <template x-if="currentBagTabIs('shop')">
            <x-home.layouts.shop-menu />
        </template>
    </div>
    <div
        class="h-full"
        :class="{ 'w-2/4': !shopStore.isHomepage(), 'w-3/4': shopStore.isHomepage() }"
    >
        <template x-if="shopStore.isHomepage()">
            <x-home.layouts.pages.shop.homepage />
        </template>

        <template x-if="!shopStore.isHomepage() && currentBagTabIs('inventory')">
            <x-home.layouts.pages.inventory.category-items />
        </template>

        <template x-if="!shopStore.isHomepage() && currentBagTabIs('shop')">
            <x-home.layouts.pages.shop.category-items />
        </template>
    </div>
    <div
        class="h-full w-1/4"
        :class="{ 'flex': !shopStore.isHomepage(), 'hidden': shopStore.isHomepage() }"
    >
        <template x-if="shopStore.activeItem">
            <x-home.layouts.pages.shop.active-item />
        </template>
        <template x-if="inventoryStore.activeItem">
            <x-home.layouts.pages.inventory.active-item />
        </template>
    </div>
</div>
