<div
    class="select-none"
    :style="`position: absolute; top: ${item.y}px; left: ${item.x}px; z-index: ${item.z};`"
    @if($isMe)
    :class="{ 'home-draggable': editing }"
    @mouseDown="itemsStore.selectItem(item)"
    @mouseUp="itemsStore.selectItem(null)"
    @click="itemsStore.updateZIndex(item)"
    @endif
>
    <template x-if="editing">
        <x-home.items.partials.sticker-menu />
    </template>
    <img :src="item.home_item.image" alt="Item image" />
</div>
