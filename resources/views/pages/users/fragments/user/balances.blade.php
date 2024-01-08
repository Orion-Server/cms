@props([
    'isShopComponent' => false
])

<div class="flex justify-start h-12 bg-white dark:bg-slate-950 dark:border-slate-800 border-b-2 border-gray-200 shadow">
    <x-container class="grid grid-cols-4 divide-x-2 divide-slate-200 dark:divide-slate-800 select-none">
        <div class="flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-850">
            <div class="rounded-l-lg w-6 h-full bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/6Z1Noci.gif')"></div>
            <span class="px-2 dark:text-slate-300 text-sm">{{ __(':a credits', ['a' => Auth::user()->currency(CurrencyType::Credits)]) }}</span>
        </div>
        <div class="flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-850">
            <div class="rounded-l-lg w-6 h-full bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/ZRBOYoE.png')"></div>
            <span class="px-2 dark:text-slate-300 text-sm">{{ __(':a duckets', ['a' => Auth::user()->currency(CurrencyType::Duckets)]) }}</span>
        </div>
        <div class="flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-850">
            <div class="rounded-l-lg w-6 h-full bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/7MyGvjK.png')"></div>
            <span class="px-2 dark:text-slate-300 text-sm">{{ __(':a diamonds', ['a' => Auth::user()->currency(CurrencyType::Diamonds)]) }}</span>
        </div>
        <div class="flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-850">
            <div class="rounded-l-lg w-6 h-full bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/8p2Dqlw.png')"></div>
            <span class="px-2 dark:text-slate-300 text-sm">{{ __(':a points', ['a' => Auth::user()->currency(CurrencyType::Points)]) }}</span>
        </div>
    </x-container>
</div>
