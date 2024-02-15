@php($isCommonRoute = in_array(Route::current()->getName(), ['register', 'index', 'login']))
@php($registerButtonAction = $isCommonRoute ? "Turbolinks.visit('/register')" : 'showRegisterModal = true')

<nav class="w-full h-16 mt-16 lg:mt-20 relative flex justify-center items-center">
    <div
        class="flex relative h-full justify-center items-center px-1 lg:px-2 mt-1 bg-white dark:bg-slate-800 rounded-t-lg"
        x-data="authentication"
    >
        <div
            @openLoginModal.window="toggleToLoginModal()"
            @openRegisterModal.window="toggleToRegisterModal()"
        >
            <x-ui.buttons.default
                @click="showLoginModal = true"
                class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white"
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
        <span class="px-2 lg:px-4 font-bold text-slate-800 dark:text-white">{{ __('or') }}</span>
        <div>
            <x-ui.buttons.default
                @click="{{ $registerButtonAction }}"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3 text-white"
            >
                <i class="fa-solid fa-user-plus"></i>
                {{ __('Register now') }}
            </x-ui.buttons.default>

            @unless($isCommonRoute)
            <x-ui.modal
                max-width="max-w-2xl"
                alpine-model="showRegisterModal"
                title="{{ __('Register') }}"
                sub-title="{{ __('We are glad you are here!') }}"
            >
                <x-forms.register />
            </x-ui.modal>
            @endunless
        </div>
    </div>
</nav>
