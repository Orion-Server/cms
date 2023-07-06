<div class="w-full flex h-full flex-col pl-2 gap-2">
    <div class="border border-slate-200 py-2 bg-slate-100 dark:bg-slate-800 dark:border-black/50 flex gap-1 rounded-md justify-center items-center px-2">
        <span class="dark:text-white text-xs" x-text="shopStore.activeItem?.name"></span>
    </div>
    <div
        class="flex flex-col w-full h-40 border dark:border-slate-800 rounded-md bg-no-repeat bg-center transition-[background-image]"
        :style="{ backgroundImage: `url(${shopStore.activeItem?.image})` }"
    ></div>
    <div class="border border-slate-300 dark:border-black/50 bg-gradient-to-r from-slate-100 dark:from-slate-800 dark:to-slate-850 to-slate-200 from-50% to-50% flex gap-1 rounded-md justify-center items-center px-2">
        <div class="flex items-center w-1/2 justify-around h-full py-2">
            <img :src="shopStore.getCurrencyIcon()" alt="Coin">
            <span class="dark:text-white text-xs" x-text="shopStore.activeItem?.price"></span>
        </div>
        <div class="flex items-center w-1/2 justify-around h-full py-2">
            <img :src="shopStore.getCurrencyIcon()" alt="Coin">
            <span class="dark:text-white text-xs font-medium" x-text="shopStore.totalPrice"></span>
        </div>
    </div>
    <di class="flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <x-ui.input
                label='<i class="fa-solid fa-arrow-up-wide-short fa-xl"></i>'
                label-classes="!mb-0"
                alpine-model="shopStore.purchaseQuantity"
                placeholder="{{ __('Quantity') }}"
                type="number"
                :small="true"
            />
        </div>
        <x-ui.buttons.loadable
            class="dark:bg-green-600 w-full bg-green-500 !py-2 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 text-white"
            alpine-model="shopStore.buttonDelay"
            @click="shopStore.buyItem()"
        >
            {{ __('Buy') }}
        </x-ui.buttons.loadable>
    </div>
</div>
