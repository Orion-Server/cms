<div class=" flex flex-wrap gap-2 max-h-full justify-start items-start overflow-y-auto px-2">
    <template x-if="delay">
        <div class="h-[300px] w-full flex justify-center items-center">
            <div class="orion-loader"></div>
        </div>
    </template>
    <template x-if="!delay">
        <template x-for="item in categoryTabItems">
            <div
                class="border-2 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer hover:!border-blue-400 w-22 h-22 bg-no-repeat bg-center dark:border-slate-800 rounded-md"
                :style="{ backgroundImage: `url(${item.image})` }"
            ></div>
        </template>
    </template>
</div>
