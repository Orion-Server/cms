<div class="absolute -top-2 -right-2 flex gap-0.5">
    <template x-if="item.home_item.type == 'n'">
        <i
            class="icon home note-edit cursor-pointer hover:brightness-125"
            @click="itemsStore.backToInventory(item)"
        ></i>
    </template>
    <i
        class="icon home delete cursor-pointer hover:brightness-125"
        @click="itemsStore.backToInventory(item)"
    ></i>
</div>
