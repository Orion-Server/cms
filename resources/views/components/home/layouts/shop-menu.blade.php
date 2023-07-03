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
            class="px-1 flex justify-between items-center text-sm font-medium w-full text-left dark:text-slate-200 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer"
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
                x-transition
                class="flex-col divide-y divide-gray-300 dark:divide-gray-800 bg-slate-100 dark:bg-black/25"
                :class="{ 'hidden': !showCategoriesElement, 'flex': showCategoriesElement }"
            >
                <template x-for="shopCategory in shopCategories" :key="shopCategory.id">
                    <div
                        class="px-1 flex justify-start gap-2 items-center text-xs w-full text-left dark:text-slate-200 py-2 hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer"
                        :class="{ 'bg-slate-200 dark:bg-slate-700': categoryTabId == shopCategory.id }"
                        @click="openCategoryTab(shopCategory.id)"
                    >
                        <div class="w-[25px] h-[25px] bg-center bg-no-repeat no-pixelated" :style="{ backgroundImage: `url(${shopCategory.icon})` }"></div>
                        <span x-text="shopCategory.name"></span>
                    </div>
                </template>
            </div>
        @endif
    @endforeach
</ul>
