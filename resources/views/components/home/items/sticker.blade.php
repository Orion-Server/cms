<div
    class="select-none absolute"
    :style="`top: ${item.y}px; left: ${item.x}px; z-index: ${item.z};`"
    @if($isMe)
    :class="{ 'home-draggable drag-handle': editing }"
    @mouseDown="itemsStore.selectItem(item)"
    @mouseUp="itemsStore.selectItem(null)"
    @click="itemsStore.updateZIndex(item)"
    @endif
>
    @if($isMe)
    <template x-if="editing">
        <x-home.items.partials.default-actions />
    </template>
    @endif
    <img :src="item.home_item.image" alt="Item image" />
</div>
