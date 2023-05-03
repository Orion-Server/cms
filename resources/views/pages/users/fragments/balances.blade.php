<div class="flex flex-col h-full">
    <x-title-box
        icon="balance"
        title="My Balance"
    />
    <div class="w-full flex h-full flex-col justify-between relative mt-4 p-3 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
        <div class="w-full h-11 flex justify-start items-center bg-yellow-400 rounded-lg">
            <div class="w-12 h-full bg-yellow-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/big/coins.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ random_int(5000, 100000) }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-blue-400 rounded-lg">
            <div class="w-12 h-full bg-blue-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/big/points.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ random_int(5000, 100000) }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-pink-400 rounded-lg">
            <div class="w-12 h-full bg-pink-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/big/pixels.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ random_int(5000, 100000) }}</span>
        </div>
        <div class="w-full h-11 flex justify-start items-center bg-green-400 rounded-lg">
            <div class="w-12 h-full bg-green-600 rounded-l-lg bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/icons/big/coins.png') }}')"></div>
            <span class="text-black/75 font-semibold text-sm flex-1 text-end pr-4">{{ random_int(5000, 100000) }}</span>
        </div>
    </div>
</div>
