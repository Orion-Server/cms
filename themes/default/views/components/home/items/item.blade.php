<div>
    <template x-if="item.home_item.type == 's'">
        @include('components.home.items.sticker')
    </template>
    <template x-if="item.home_item.type == 'n'">
        @include('components.home.items.note')
    </template>
    <template x-if="item.home_item.type == 'w'">
        @include('components.home.items.widget')
    </template>
</div>
