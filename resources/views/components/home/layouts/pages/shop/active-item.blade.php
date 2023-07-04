<div class="w-full flex h-full flex-col pl-2 gap-2">
    <div class="border border-slate-200 py-2 bg-slate-100 dark:bg-slate-800 dark:border-black/50 flex gap-1 rounded-md justify-center items-center px-2">
        <span class="dark:text-white text-xs" x-text="activeShopItem?.name"></span>
    </div>
    <div
        class="flex flex-col w-full h-40 border dark:border-slate-800 rounded-md bg-no-repeat bg-center transition-[background-image]"
        :style="{ backgroundImage: `url(${activeShopItem?.image})` }"
    ></div>
    <div class="border border-slate-300 dark:border-black/50 bg-gradient-to-r from-slate-100 dark:from-slate-800 dark:to-slate-850 to-slate-200 from-50% to-50% flex gap-1 rounded-md justify-center items-center px-2">
        <div class="flex w-1/2 justify-around h-full py-2">
            <img src="https://i.imgur.com/dijttdM.png" alt="Coin">
            <span class="dark:text-white text-xs" x-text="activeShopItem?.price"></span>
        </div>
        <div class="flex w-1/2 justify-around h-full py-2">
            <img src="https://i.imgur.com/dijttdM.png" alt="Coin">
            <span class="dark:text-white text-xs font-medium" x-text="totalPrice"></span>
        </div>
    </div>
    <div class="flex gap-2">
        <div class="w-1/3">
            <x-ui.input
                alpine-model="purchaseQuantity"
                placeholder="{{ __('Quantity') }}"
                type="number"
                :small="true"
            />
        </div>
        <div class="w-2/3">
            <x-ui.buttons.loadable
                class="dark:bg-green-600 w-full bg-green-500 !py-2 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 text-white"
                alpine-model="delay"
            >
                {{ __('Buy') }}
            </x-ui.buttons.loadable>
        </div>
    </div>
</div>
