<nav class="w-full h-16 relative bg-white border-b-2 border-gray-200 shadow flex justify-center items-center">
    <div class="absolute w-1/3 mx-auto inset-x-0 h-px -translate-y-1/2 bg-gray-300 top-1/2"></div>
    <div
        class="flex relative h-full justify-center items-center bg-white px-2"
        x-data="{
            showLoginModal: false,
            showRegisterModal: false,

            toggleToRegisterModal() {
                this.showLoginModal = false
                this.showRegisterModal = true
            },

            toggleToLoginModal() {
                this.showRegisterModal = false
                this.showLoginModal = true
            }
        }"
    >
        <div>
            <x-ui.button
                @click="showLoginModal = true"
                class="dark:bg-orange-600 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-500 dark:shadow-orange-700/75 shadow-orange-600/75 flex-1 py-3"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In
            </x-ui.button>

            <x-ui.modal alpine-model="showLoginModal">
                @include('forms.login')
            </x-ui.modal>
        </div>
        <span class="px-4 font-bold text-blue-400">or</span>
        <div>
            <x-ui.button
                @click="showRegisterModal = true"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3"
            >
                <i class="fa-solid fa-user-plus"></i>
                Register now
            </x-ui.button>

            <x-ui.modal alpine-model="showRegisterModal">
                @include('forms.register')
            </x-ui.modal>
        </div>
    </div>
</nav>
