@php($navigations = \App\Models\Navigation::getNavigations())

<div class="bg-white dark:bg-slate-950 w-full z-[2] relative h-16 border-b-2 border-gray-200 dark:border-slate-800">
    <x-container class="h-full flex justify-center">
        <nav class="h-full w-1/2" @click.away="showMenu = null" x-data="{
            showMenu: null,
            theme: 'light',

            init() {
                if (localStorage.theme === 'dark') this.toggleTheme()
            },

            toggleTheme() {
                this.theme = this.theme == 'light' ? 'dark' : 'light'
                document.documentElement.classList.toggle('dark')

                localStorage.setItem('theme', this.theme)
            },

            isTheme(theme) {
                this.theme == theme
            },

            toggleMenu(id) {
                this.showMenu = this.showMenu == id ? null : id
            }
        }">
            <ul class="flex divide-x relative dark:divide-slate-800 justify-center text-slate-800 dark:text-white font-medium text-sm items-center h-full">
                @foreach ($navigations as $navigation)
                    <li @click="toggleMenu({{ $navigation->id }})" @class([
                        "relative group px-8 uppercase h-full cursor-pointer",
                        "text-blue-600 dark:text-blue-400 font-semibold border-b-2 border-blue-500" => \Route::current()->uri == $navigation->slug
                    ])>
                        <a
                            class="w-full h-full flex justify-center items-center gap-1"
                            @if ($navigation->subNavigations->isEmpty()) href="{{ $navigation->slug }}" @endif
                        >
                            <div class="bg-center bg-no-repeat w-[25px] h-[25px]" style="background-image: url('{{ $navigation->icon }}')"></div>
                            <span class="group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $navigation->label }}</span>
                            @unless ($navigation->subNavigations->isEmpty())
                                <span><i class="fa-solid fa-chevron-down text-xs dark:text-slate-500"></i></span>
                            @endunless

                            @unless ($navigation->subNavigations->isEmpty())
                                <div class="absolute left-0 top-full min-w-full w-auto dark:bg-slate-950 bg-white shadow-lg border-b-2 border-gray-200 dark:border-slate-800 rounded-b-md z-[1]"
                                    x-transition.origin.top.left
                                    x-show="showMenu == {{ $navigation->id }}"
                                    style="display: none"
                                >
                                    <ul class="flex divide-y dark:divide-slate-800 flex-col">
                                        @foreach ($navigation->subNavigations as $subItem)
                                            <a @if($subItem->new_tab) target="_blank" @endif href="{{ $subItem->slug }}" class="flex items-center gap-1 px-4 py-3 hover:text-blue-600 dark:hover:text-blue-400 w-full">
                                                <span>{{ $subItem->label }}</span>
                                                @if($subItem->new_tab)
                                                    <i class="fa-solid fa-up-right-from-square text-blue-300 text-[0.5rem]" data-tippy data-tippy-content="<small>Opened in a new tab</small>" data-tippy-placement="bottom"></i>
                                                @endif
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            @endunless
                        </a>
                    </li>
                @endforeach

                <div class="flex relative justify-center group gap-2 px-8 uppercase h-full cursor-pointer items-center">
                    <div
                        class="relative w-6 h-6 flex items-center justify-center rounded-md dark:bg-slate-800 bg-yellow-500"
                        @click="toggleTheme()"
                        data-tippy
                        data-tippy-content="<small>Toggle theme</small>"
                        data-tippy-placement="bottom"
                    >
                        <template x-if="theme == 'light'">
                            <i class="fa-solid fa-sun text-white"></i>
                        </template>
                        <template x-if="theme == 'dark'">
                            <i class="fa-solid fa-moon"></i>
                        </template>
                    </div>
                </div>
            </ul>
        </nav>
    </x-container>
</div>
