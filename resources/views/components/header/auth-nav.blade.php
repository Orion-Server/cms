<nav class="w-full h-16 relative flex justify-center items-center">
    <div
        class="flex relative h-full justify-center items-center lg:px-2"
        x-data="authentication"
    >
        <div
            @openLoginModal.window="toggleToLoginModal()"
            @openRegisterModal.window="toggleToRegisterModal()"
        >
            <x-ui.buttons.default
                @click="showLoginModal = true"
                class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white rounded-full"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                {{ __('Sign In') }}
            </x-ui.buttons.default>

            <x-ui.modal
                alpine-model="showLoginModal"
                title="{{ __('Login') }}"
                sub-title="{{ __('Welcome back!') }}"
            >
                <x-forms.login />
            </x-ui.modal>
        </div>
        <span class="px-2 lg:px-4 font-bold text-white">{{ __('or') }}</span>
        <div>
            <x-ui.buttons.default
                @click="showRegisterModal = true"
                class="dark:bg-green-600 animate-pulse bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3 text-white rounded-full"
            >
                <i class="fa-solid fa-user-plus"></i>
                {{ __('Register now') }}
            </x-ui.buttons.default>

            <x-ui.modal
                alpine-model="showRegisterModal"
                title="{{ __('Register') }}"
                sub-title="{{ __('We are glad you are here!') }}"
            >
                <x-forms.register />
            </x-ui.modal>
        </div>
    </div>
</nav>
