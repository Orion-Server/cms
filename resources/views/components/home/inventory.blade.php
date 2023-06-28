<div class="flex justify-start items-start">
    <x-ui.buttons.default
        @click="openInventory()"
        disabled
        class="dark:bg-blue-600 px-1 py-2 rounded-r-none bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 text-white"
    >
        {{ __('Inventory') }}
    </x-ui.buttons.default>
    <x-ui.buttons.default
        @click="openShop()"
        class="dark:bg-orange-600 px-1 py-2 rounded-l-none bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-500 dark:shadow-orange-700/75 shadow-orange-600/75 text-white"
    >
        {{ __('Shop') }}
    </x-ui.buttons.default>
</div>
