<div class="flex flex-col h-full">
    <div class="h-16">
        <x-title-box
            icon="balance"
            title="My Balance"
            description="Riches are on display."
        />
    </div>

    <div class="grid h-full min-h-[230px] text-sm text-black/75 font-semibold grid-rows-4 gap-1.5 relative mt-4 p-3 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
        <div class="flex justify-start items-center bg-yellow-400 rounded-lg">
            <div class="w-12 h-full bg-yellow-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/6Z1Noci.gif')"></div>
            <span class="flex-1 text-end pr-4">{{ Auth::user()->credits }}</span>
        </div>
        <div class="flex justify-start items-center bg-pink-400 rounded-lg">
            <div class="w-12 h-full bg-pink-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/ZRBOYoE.png')"></div>
            <span class="flex-1 text-end pr-4">{{ Auth::user()->currency(CurrencyType::Duckets) }}</span>
        </div>
        <div class="flex justify-start items-center bg-blue-400 rounded-lg">
            <div class="w-12 h-full bg-blue-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/7MyGvjK.png')"></div>
            <span class="flex-1 text-end pr-4">{{ Auth::user()->currency(CurrencyType::Diamonds) }}</span>
        </div>
        <div class="flex justify-start items-center bg-green-400 rounded-lg">
            <div class="w-12 h-full bg-green-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('https://i.imgur.com/8p2Dqlw.png')"></div>
            <span class="flex-1 text-end pr-4">{{ Auth::user()->currency(CurrencyType::Points) }}</span>
        </div>
    </div>
</div>
