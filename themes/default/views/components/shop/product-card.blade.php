@props([
    'product'
])

<div class="bg-white dark:bg-slate-950 w-full rounded-lg p-2 shadow-md flex flex-col justify-around">
    <div class="w-full h-24 bg-no-repeat bg-center rounded-lg" style="background-image: url('{{ $product->image }}')"></div>
    <div class="mt-4 flex flex-col gap-2">
        <span class="text-slate-700 dark:text-slate-200 font-semibold text-sm">{{ $product->name }}</span>
        <span class="text-slate-500 dark:text-slate-400 text-xs">{{ $product->description }}</span>
    </div>
    <div class="mt-4 flex justify-around">
        <x-ui.buttons.loadable
            alpine-model="loadingId === {{ $product->id }}"
            @click="openProductModal({{ $product->id }})"
            :small="true"
            class="dark:bg-blue-500 text-xs bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white rounded-full"
        >
            <i class="fa-regular fa-eye"></i>
            {{ __('View') }}
        </x-ui.buttons.loadable>
        <x-ui.buttons.redirectable
            x-bind:href="getProductOrderEndpoint('{{ $product->id }}')"
            data-turbolinks="false"
            class="dark:bg-emerald-500 text-xs bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 px-3 text-white rounded-full"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            {{ __('Buy') }} ({{ $product->formatted_price }})
        </x-ui.buttons.redirectable>
    </div>
</div>
