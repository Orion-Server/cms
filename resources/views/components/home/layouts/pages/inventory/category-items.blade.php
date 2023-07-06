<div class="flex flex-wrap gap-2 max-h-full overflow-y-auto px-2">
    <template x-if="inventoryStore.delay">
        <div class="h-[300px] w-full flex justify-center items-center">
            <div class="orion-loader"></div>
        </div>
    </template>
    <template x-if="!inventoryStore.delay">
        <div>
            inventory
        </div>
    </template>
</div>
