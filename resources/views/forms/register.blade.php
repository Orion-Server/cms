<form method="POST" @submit.prevent="onFormRegisterSubmit">
    @csrf
    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="Username"
            autocomplete="username"
            alpine-model="registerData.username"
            placeholder="Username"
            type="text"
        />
    </div>
    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="Email"
            autocomplete="email"
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
                alpine-model="registerData.password"
                placeholder="Password"
                type="password"
            />
        </div>
        <div class="flex flex-col">
            <x-ui.input
                label="Confirm Password"
                autocomplete="password"
                alpine-model="registerData.password_confirmation"
                placeholder="Password"
                @keyup.enter="onRegisterSubmit()"
                type="password"
            />
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
