<nav class="w-full h-16 relative bg-white dark:bg-slate-950 dark:border-slate-800 border-b-2 border-gray-200 shadow flex justify-center items-center">
    <div class="absolute w-2/3 xl:w-1/3 mx-auto inset-x-0 h-px -translate-y-1/2 dark:bg-slate-900 bg-gray-300 top-1/2"></div>
    <div
        class="flex relative h-full justify-center items-center bg-white dark:bg-slate-950 px-2"
        x-data="authentication"
    >
        <div
            @openLoginModal.window="toggleToLoginModal()"
            @openRegisterModal.window="toggleToRegisterModal()"
        >
            <x-ui.buttons.default
                @click="showLoginModal = true"
                class="border-blue-500 border hover:bg-blue-500 hover:text-white dark:shadow-blue-500/75 shadow-blue-400/75 flex-1 py-3 text-blue-500"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In
            </x-ui.buttons.default>

            <x-ui.modal
                alpine-model="showLoginModal"
                title="Login"
                sub-title="Welcome back!"
            >
                <x-forms.login />
            </x-ui.modal>
        </div>
        <span class="px-4 font-bold text-blue-400">or</span>
        <div>
            <x-ui.buttons.default
                @click="showRegisterModal = true"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3 text-white"
            >
                <i class="fa-solid fa-user-plus"></i>
                Register now
            </x-ui.buttons.default>

            <x-ui.modal
                alpine-model="showRegisterModal"
                title="Register"
                sub-title="We are glad you are here!"
            >
                <x-forms.register />
            </x-ui.modal>
        </div>
    </div>
</nav>
