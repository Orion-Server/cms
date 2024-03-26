@props([
    'removeRegisterButton' => false,
    'removeSocialButtons' => false,
])

@if(session()->has('loginError'))
    @pushOnce('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            window.notyf.error("{{ session()->get('loginError') }}", 5000)
        });
    </script>
    @endpushOnce
@enderror

<form
    id="login-form"
    method="POST"
    @submit.prevent="onFormLoginSubmit"
>
    @csrf
    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="{{ __('Username') }}"
            autocomplete="username"
            id="login-username"
            icon="fa-solid fa-user"
            alpine-model="loginData.username"
            placeholder="{{ __('Username') }}"
            type="text"
        />
    </div>

    <div class="mt-4 flex flex-col">
        <x-ui.input
            label="{{ __('Password') }}"
            autocomplete="password"
            id="login-password"
            icon="fa-solid fa-key"
            alpine-model="loginData.password"
            placeholder="{{ __('Password') }}"
            type="password"
        />
    </div>

    <div class="mt-4 flex justify-center">
		@includeWhen(config('hotel.recaptcha.enabled'), 'components.ui.recaptcha')
		@includeWhen(config('hotel.turnstile.enabled'), 'components.ui.turnstile')
	</div>

    <div class="flex gap-4 mt-6">
        @if (!$removeRegisterButton)
        <x-ui.buttons.default
            type="button"
            @click="toggleToRegisterModal()"
            class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 flex-1 py-3 text-white"
        >
            <i class="fa-solid fa-user-plus"></i>
            {{ __('Register') }}
        </x-ui.buttons.default>
        @endif

        <x-ui.buttons.loadable
            type="submit"
            alpine-model="loading"
            class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white"
        >
            <i class="fa-solid fa-right-to-bracket"></i>
            {{ __('Login') }}
        </x-ui.buttons.loadable>
    </div>

    @if (!$removeSocialButtons)
    <div class="my-6 flex items-center justify-between">
        <span class="border-b dark:border-gray-700 w-1/5 md:w-1/4"></span>
        <span class="text-xs text-gray-500 uppercase dark:text-gray-100">{{ __('or join with') }}</span>
        <span class="border-b dark:border-gray-700 w-1/5 md:w-1/4"></span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
        <a href="{{ route('google.login') }}" class="flex gap-3 items-center justify-center dark:bg-slate-900 dark:shadow-xl dark:border-slate-800 dark:border text-white rounded-lg shadow-md hover:bg-gray-100 dark:hover:bg-slate-700">
            <div class="pl-4 py-3">
                <i class="fa-brands fa-google text-red-500"></i>
            </div>
            <h1 class="pr-4 py-3 text-center text-gray-600 dark:text-gray-400 font-bold">Google</h1>
        </a>
        <a href="{{ route('facebook.login') }}" class="flex gap-3 items-center justify-center dark:bg-slate-900 dark:shadow-xl dark:border-slate-800 dark:border text-white rounded-lg shadow-md hover:bg-gray-100 dark:hover:bg-slate-700">
            <div class="pl-4 py-3">
                <i class="fa-brands fa-facebook-f text-blue-500"></i>
            </div>
            <h1 class="pr-4 py-3 text-center text-gray-600 dark:text-gray-400 font-bold">Facebook</h1>
        </a>
        <a href="{{ route('discord.login') }}" class="flex gap-3 items-center justify-center dark:bg-slate-900 dark:shadow-xl dark:border-slate-800 dark:border text-white rounded-lg shadow-md hover:bg-gray-100 dark:hover:bg-slate-700">
            <div class="pl-4 py-3">
                <i class="fa-brands fa-discord text-gray-900 dark:text-slate-600"></i>
            </div>
            <h1 class="pr-4 py-3 text-center text-gray-600 dark:text-gray-400 font-bold">Discord</h1>
        </a>
    </div>
    @endif
</form>
