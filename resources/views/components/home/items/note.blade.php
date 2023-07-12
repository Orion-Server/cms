<div
    class="select-none"
    :style="`position: absolute; top: ${item.y}px; left: ${item.x}px; z-index: ${item.z};`"
    @if($isMe)
    :class="{ 'home-draggable': editing, 'drag-handle': item.theme == 'default' }"
    @mouseDown="itemsStore.selectItem(item)"
    @mouseUp="itemsStore.selectItem(null)"
    @click="itemsStore.updateZIndex(item)"
    @endif
>
    <template x-if="editing">
        <x-home.items.partials.default-actions />
    </template>
    <div
        class="rounded-lg p-2 text-xs home-note themeable"
        :data-theme="item.theme"
    >
        <template x-if="item.theme != 'default'">
            <div class="heading drag-handle">
                <span>asdas</span>
            </div>
        </template>
        <div class="body">
            <div class="text" x-html="item.parsed_data"></div>
        </div>
    </div>
</div>
