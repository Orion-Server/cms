<template x-if="product !== null">
    <div>
        <div class="text-xl h-14 rounded font-bold mt-4 bg-center bg-no-repeat" :style="{ 'backgroundImage': `url('${product.image}')` }">
            <div class="w-full flex items-center justify-center rounded h-full bg-black/75 text-white" x-html="$sanitize(product?.name)"></div>
        </div>
        <div
            class="text-sm text-slate-700 dark:text-slate-200 p-4"
            x-html="$sanitize(product.content)"
        ></div>
        <template x-if="product.items?.length">
            <div>
                <div class="bg-blue-500 w-full h-8 flex text-sm justify-center items-center text-white rounded-t border border-b-0 border-blue-600">
                    {{ __('It has the following items:') }}
                </div>
                <div class="p-3 flex flex-wrap gap-3 bg-slate-50 dark:bg-slate-950 rounded-b border dark:border-slate-800">
                    <template x-for="item of product.items" :key="item.id">
                        <div
                            class="w-[50px] p-1 border hover:bg-white dark:hover:bg-slate-700 dark:border-slate-800 relative h-[50px] bg-center bg-no-repeat rounded-full border-slate-200"
                            :style="{ 'backgroundImage': `url('${item.image}')` }"
                        >
                            <span
                                class="absolute tracking-wider -bottom-2 left-1/2 -translate-x-1/2 py-px px-1 bg-blue-500 text-xxs rounded-full text-white font-medium"
                                x-html="'x' + $sanitize(item.quantity)"
                            ></span>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <x-ui.buttons.redirectable
            class="mt-6 animate__animated animate__headShake animate__infinite animate__slow dark:bg-emerald-500 bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white rounded-full"
            x-bind:href="getProductOrderEndpoint(product.id)"
            data-turbolinks="false"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            {{ __('Buy') }} <span class="m-0 p-0" x-html="`(${product.formatted_price})`"></span>
        </x-ui.buttons.redirectable>
    </div>
</template>
