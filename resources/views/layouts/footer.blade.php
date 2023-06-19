<div class="w-full mt-12 pb-4" x-data="footer">
    <x-ui.buttons.default
        class="bottom-3 right-3 z-10 bg-blue-400 border-blue-600 hover:bg-blue-300 text-white"
        x-bind:class="{ '!hidden': !showScrollButton, '!fixed': showScrollButton }"
        @click="scrollToTop"
    >
        <i class="fa-solid fa-chevron-up"></i>
    </x-ui.buttons.default>

    <x-container class="flex justify-center gap-1 items-center text-sm flex-col">
        <span class="dark:text-gray-200">
            {!! __('© OrionCMS 2023 - Development by :a. All rights reserved.', [
                    'a' => <<<HTML
                        <a
                            data-tippy
                            target="_blank"
                            href="https://github.com/nicollassilva"
                            data-tippy-content='<i class="fa-brands fa-discord mr-1"></i> inicollas'
                            class="underline underline-offset-4 text-blue-400"
                        >
                            iNicollas
                        </a>
                    HTML
                ])
            !!}</span>
        <span class="font-semibold dark:text-white">{{ __('This website is a not-for-profit educational project.') }}</span>
    </x-container>
</div>

@include('components.select-language-modal')
