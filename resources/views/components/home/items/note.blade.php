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
        <x-home.items.partials.default-actions />
    </template>
    <div
        class="bg-white rounded-lg shadow-lg p-2 text-xs themeable"
        :data-theme="item.theme"
        x-html="item.parsed_data"
    ></div>
</div>
