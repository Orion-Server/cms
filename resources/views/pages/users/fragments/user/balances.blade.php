<div class="flex flex-col">
    <x-title-box
        icon="balance"
        title="My Balance"
        description="Riches are on display."
    />
    <div class="w-full flex h-full flex-col gap-1.5 relative mt-4 p-3 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
        <div class="w-full h-11 flex justify-start items-center bg-yellow-400 rounded-lg">
            <div class="w-12 h-full bg-yellow-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/big/coins.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ \Auth::user()->credits }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-pink-400 rounded-lg">
            <div class="w-12 h-full bg-pink-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/balance/0.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ \Auth::user()->currency('duckets') }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-blue-400 rounded-lg">
            <div class="w-12 h-full bg-blue-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/balance/5.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ \Auth::user()->currency('diamonds') }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-green-400 rounded-lg">
            <div class="w-12 h-full bg-green-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/balance/101.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ \Auth::user()->currency('points') }}</span>
        </div>
    </div>
</div>
