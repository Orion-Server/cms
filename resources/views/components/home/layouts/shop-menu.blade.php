@php($inventoryNavigations = [
    'home' => __('Home'),
    'categories' => __('Categories'),
    'notes' => __('Notes'),
    'widgets' => __('Widgets'),
    'backgrounds' => __('Backgrounds'),
])

<ul class="divide-y divide-gray-300 dark:divide-gray-800">
    @foreach ($inventoryNavigations as $key => $label)
        <li
            class="px-1 flex justify-between items-center text-sm w-full text-left dark:text-slate-200 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer"
            :class="{ 'bg-slate-100 dark:bg-slate-800': shopTab == '{{ $key }}' }"
            @click="openShopTab('{{ $key }}')"
        >
            {{ $label }}

            @if($key == 'categories')
                <i class="fa-solid fa-xs mt-1" :class="{ 'fa-chevron-down': !showCategoriesElement, 'fa-chevron-up': showCategoriesElement }"></i>
            @endif
        </li>

        @if ($key == 'categories')
            <div
                x-ref="categoriesElement"
                class="flex-col divide-y divide-gray-300 dark:divide-gray-800 bg-slate-100 dark:bg-slate-800"
                :class="{ 'hidden': !showCategoriesElement, 'flex': showCategoriesElement }"
            ></div>
        @endif
    @endforeach
</ul>
