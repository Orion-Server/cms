<div class="absolute -top-2 right-0 flex z-10">
    <template x-if="item.home_item.type == 'n'">
        <i
            class="icon home note-edit cursor-pointer hover:brightness-125"
            @click="itemsStore.editNote(item)"
        ></i>
    </template>
    <template x-if="['n', 'w'].includes(item.home_item.type)">
        <div
            @click="itemsStore.toggleThemeDropdown(item)"
            @click.stop.outside="itemsStore.closeThemeDropdown()"
        >
            <i class="icon home theme-edit cursor-pointer hover:brightness-125"></i>

            <div
                x-show="itemsStore.showChangeThemeDropdown && itemsStore.activeThemeableItem?.id == item.id"
                x-transition
                class="absolute left-1/2 top-full flex flex-col gap-1"
            >
                <ul class="list-none border border-slate-300 dark:border-slate-700 divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-950 rounded p-1">
                    <template x-for="theme in itemsStore.themes">
                        <li
                            class="text-xs p-1 text-slate-800 dark:text-slate-200 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700"
                            :class="{ '!text-blue-400 font-semibold': itemsStore.activeThemeableItem?.theme == theme }"
                            @click="itemsStore.selectThemeForActiveThemeableItem(theme)"
                            x-text="theme"
                        ></li>
                    </template>
                </ul>
            </div>
        </div>
    </template>
    <i
        class="icon home delete cursor-pointer hover:brightness-125"
        @click="itemsStore.backToInventory(item)"
    ></i>
</div>
