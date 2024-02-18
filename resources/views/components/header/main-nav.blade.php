@php($navigations = \App\Models\Navigation::getNavigations())

<div
    class="bg-white fixed top-0 dark:bg-slate-950 w-full z-50 lg:relative h-auto lg:h-16 dark:border-slate-800 lg:shadow-[0_20px_0_0_rgba(0,0,0,0.2)]"
    x-data="navigation"
    data-turbolinks-permanent
>
    <x-container class="h-full flex flex-col items-center justify-center lg:bg-transparent bg-white dark:bg-slate-950">
        <div
            :class="{ 'border-b dark:border-gray-800': showMobileMenu }"
            class="flex lg:hidden p-4 w-full dark:text-white justify-center items-center cursor-pointer"
            @click="showMobileMenu = !showMobileMenu"
        >
            <i class="fa-solid fa-bars" x-show="!showMobileMenu"></i>
            <i class="fa-solid fa-xmark" style="display: none" x-show="showMobileMenu"></i>
        </div>
        <nav class="h-full w-full lg:w-1/2" @click.away="showSubmenuId = null">
            <ul :class="{ 'hidden': !showMobileMenu, 'flex': showMobileMenu }"
                class="hidden lg:flex flex-col lg:flex-row divide-y relative dark:divide-slate-800 justify-center text-slate-800 dark:text-white font-medium text-sm items-center h-full"
            >
                @foreach ($navigations as $navigation)
                    <li @click="toggleMenu({{ $navigation->id }})" @class([
                        "relative group px-8 uppercase w-full lg:w-auto h-12 lg:h-full cursor-pointer",
                        "text-blue-600 dark:text-blue-400 font-semibold border-b-2 border-blue-500" => \Route::current()->uri == ($navigation->slug == '/' ? $navigation->slug : ltrim($navigation->slug, '/'))
                    ])>
                        <a
                            class="w-full h-full flex justify-center items-center gap-1"
                            @if ($navigation->subNavigations->isEmpty()) href="{{ $navigation->slug }}" @endif
                        >
                            <div class="bg-center bg-no-repeat w-[25px] h-[25px]" style="background-image: url('{{ asset($navigation->icon) }}')"></div>
                            <span class="group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $navigation->label }}</span>
                            @unless ($navigation->subNavigations->isEmpty())
                                <span class="ml-2"><i class="fa-solid fa-chevron-down text-xs dark:text-slate-500"></i></span>
                            @endunless

                            @unless ($navigation->subNavigations->isEmpty())
                                <div class="absolute left-0 top-full min-w-full w-auto dark:bg-slate-950 bg-white shadow-lg border-b-2 border-gray-200 dark:border-slate-800 rounded-b-md z-[1]"
                                    x-transition.origin.top.center
                                    x-show="showSubmenuId == {{ $navigation->id }}"
                                    style="display: none"
                                >
                                    <ul class="flex divide-y dark:divide-slate-800 flex-col">
                                        @foreach ($navigation->subNavigations as $subItem)
                                            <a @class([
                                                    "flex items-center gap-1 px-4 py-3 hover:text-blue-600 dark:hover:text-blue-400 w-full",
                                                    "!text-blue-500" => strtolower(\Route::current()->uri) == ltrim($subItem->slug, '/')
                                                ])
                                                @if($subItem->new_tab) target="_blank" @endif
                                                href="{{ $subItem->slug }}"
                                            >
                                                <span>{{ $subItem->label }}</span>
                                                @if($subItem->new_tab)
                                                    <i class="fa-solid fa-up-right-from-square text-blue-300 text-[0.7rem] ml-1" data-tippy data-tippy-content="<small>{{ __('Opened in a new tab') }}</small>" data-tippy-placement="bottom"></i>
                                                @endif
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            @endunless
                        </a>
                    </li>
                @endforeach

                <div class="flex relative justify-center w-full lg:w-auto group gap-2 px-8 uppercase h-12 lg:h-full items-center">
                    <x-ui.buttons.default
                        class="!py-0.5 !px-1 border border-slate-600 text-white dark:text-white"
                        @click="$dispatch('selectLanguageModal', true)"
                        data-tippy
                        data-tippy-content="<small>{{ __('Select Language') }}</small>"
                        data-tippy-placement="bottom"
                    >
                        <i class="icon border-none language {{ strtolower(app()->getLocale()) }}"></i>
                    </x-ui.buttons.default>

                    <x-ui.buttons.default
                        class="bg-blue-500 border border-blue-600 dark:border-slate-600 hover:bg-blue-400 dark:bg-slate-500 dark:hover:bg-slate-400 text-white dark:text-white"
                        @click="toggleTheme"
                        data-tippy
                        data-tippy-content="<small>{{ __('Toggle theme') }}</small>"
                        data-tippy-placement="bottom"
                    >
                        <template x-if="theme == 'light'">
                            <i class="fa-solid fa-sun text-white"></i>
                        </template>
                        <template x-if="theme == 'dark'">
                            <i class="fa-solid fa-moon"></i>
                        </template>
                    </x-ui.buttons.default>
                </div>
            </ul>
        </nav>
    </x-container>
</div>
