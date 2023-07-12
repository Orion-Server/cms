<div class="absolute -top-2 right-0 flex z-10">
    <template x-if="item.home_item.type == 'n'">
        <i
            class="icon home note-edit cursor-pointer hover:brightness-125"
            @click="itemsStore.editNote(item)"
        ></i>
    </template>
    <template x-if="['n', 'w'].includes(item.home_item.type)">
        <i
            class="icon home theme-edit cursor-pointer hover:brightness-125"
            @click="itemsStore.openThemeModal(item)"
        ></i>
    </template>
    <i
        class="icon home delete cursor-pointer hover:brightness-125"
        @click="itemsStore.backToInventory(item)"
    ></i>
</div>
