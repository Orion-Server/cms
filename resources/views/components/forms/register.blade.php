<form
    method="POST"
    @submit.prevent="onFormRegisterSubmit"
>
    <template x-if="!! registerReferrerData.username">
        <div class="flex-1 mt-2 bg-green-500 border-b-4 border-green-600 p-2 text-white text-sm">
            You are being invited by <span class="font-semibold" x-text="registerReferrerData.username"></span>
        </div>
    </template>
    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="Username"
            autocomplete="username"
            id="register-username"
            icon="fa-solid fa-user"
            alpine-model="registerData.username"
            placeholder="Username"
            type="text"
        />
    </div>

    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="Email"
            autocomplete="email"
            id="register-email"
            icon="fa-solid fa-envelope"
            alpine-model="registerData.email"
            placeholder="Email"
            type="email"
        />
    </div>

    <div class="flex mt-4 justify-between gap-3 sm:flex-row flex-col bg-gray-100 dark:bg-transparent dark:border dark:border-slate-800 p-2 rounded-lg">
        <div class="flex flex-col">
            <x-ui.input
                label="Password"
                autocomplete="password"
                id="register-password"
                icon="fa-solid fa-key"
                alpine-model="registerData.password"
                placeholder="Password"
                type="password"
            />
        </div>
        <div class="flex flex-col">
            <x-ui.input
                label="Confirm Password"
                autocomplete="password"
                id="register-password-confirmation"
                icon="fa-solid fa-key"
                alpine-model="registerData.password_confirmation"
                placeholder="Password"
                @keyup.enter="onRegisterSubmit()"
                type="password"
            />
        </div>
    </div>

    <div class="flex-1 flex flex-col mt-4">
        <label class="text-gray-700 w-full text-left font-semibold mb-2 dark:text-gray-200 text-sm">
            <i class="fa-solid fa-venus-mars mr-1"></i>
            Gender
        </label>
        <div class="flex gap-2">
            <div class="flex-1">
                <x-ui.input-radio
                    id="register-gender"
                    title="Male"
                    image-icon="small male"
                    value="M"
                    alpine-model="registerData.gender"
                    selected-classes="peer-checked:!text-blue-400 peer-checked:border-blue-400"
                />
            </div>
            <div class="flex-1">
                <x-ui.input-radio
                    id="login-gender"
                    title="Female"
                    image-icon="small female"
                    value="F"
                    alpine-model="registerData.gender"
                    selected-classes="peer-checked:!text-pink-400 peer-checked:border-pink-400"
                    :render-input="false"
                />
            </div>
        </div>
    </div>

    <div class="flex gap-4 mt-6">
        <x-ui.buttons.loadable
            alpine-model="loading"
            type="submit"
            class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white">
            <i class="fa-solid fa-user-plus"></i>
            Register
        </x-ui.buttons.loadable>
    </div>

    <a class="text-gray-500 dark:text-gray-400 underline underline-offset-4 block text-center mt-6 text-sm" href="#" @click="toggleToLoginModal()">
        Click here if you already have an account
    </a>
</form>
