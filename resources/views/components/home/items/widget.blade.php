<div
    class="select-none"
    :style="`position: absolute; top: ${item.y}px; left: ${item.x}px; z-index: ${item.z};`"
    @if($isMe)
    :class="{ 'home-draggable': editing }"
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
        class="rounded-lg p-2 text-xs themeable"
        :class="item.widget_type"
        :data-theme="item.theme"
    >
        <div class="heading drag-handle">
            <span x-text="item.home_item.name"></span>
        </div>
        <div class="body" x-html="$sanitize(item.content)"></div>
    </div>
</div>
