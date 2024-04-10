<div
    class="select-none"
    :style="`position: absolute; top: ${item.y}px; left: ${item.x}px; z-index: ${item.z};`"
    @if($isMe)
    :class="{ 'home-draggable': editing, 'drag-handle': item.theme == 'default' }"
    @mouseDown.stop="itemsStore.selectItem(item)"
    @mouseUp.stop="itemsStore.selectItem(null)"
    @click.stop="itemsStore.updateZIndex(item)"
    @endif
>
    @if($isMe)
    <template x-if="editing">
        <x-home.items.partials.default-actions />
    </template>
    @endif
    <div
        class="rounded-lg p-2 text-xs home-note themeable"
        :data-theme="item.theme"
    >
        <template x-if="item.theme != 'default'">
            <div class="heading drag-handle"></div>
        </template>
        <div class="body">
            <div class="text" x-html="$sanitize(item.parsed_data)"></div>
        </div>
    </div>
</div>
