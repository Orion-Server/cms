@php($inventoryNavigations = [
    'stickers' => __('Stickers'),
    'notes' => __('Notes'),
    'widgets' => __('Widgets'),
    'backgrounds' => __('Backgrounds'),
])

<ul class="divide-y divide-gray-300 dark:divide-gray-800">
    @foreach ($inventoryNavigations as $key => $label)
        <li
            class="pl-1 text-sm font-medium w-full text-left dark:text-slate-200 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer"
            :class="{ 'bg-slate-100 dark:bg-slate-800': currentInventoryTabIs('{{ $key }}') }"
            @click="inventoryStore.openTab('{{ $key }}')"
        >
            {{ $label }}
        </li>
    @endforeach
</ul>
