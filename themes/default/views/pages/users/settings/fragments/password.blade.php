<x-title-box
    title="{{ __('Your Security Settings') }}"
    icon="security-settings"
/>

<div
    x-data="passwordSettings('{{ route('users.settings.index', 'password') }}')"
>
    <form
        class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg"
        action="{{ route('users.settings.index', 'account') }}"
        method="POST"
        @submit.prevent="submitForm"
    >
        <span class="w-full text-center py-3 bg-red-500 text-white rounded-lg border border-b-2 border-red-700 text-sm font-bold">
            <i class="fa-solid fa-triangle-exclamation mr-1"></i>
            {{ __("Don't share your password with anyone. We will never ask for your password.") }}
        </span>
        <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Current Password') }}"
                autocomplete="password"
                id="current-password"
                icon="fa-solid fa-key"
                placeholder="{{ __('Current Password') }}"
                alpine-model="data.current_password"
                type="password"
            />
            <small class="text-slate-500">
                {{ __('You need to enter your current password to update your password.') }}
            </small>
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('New Password') }}"
                autocomplete="password"
                id="new-password"
                icon="fa-solid fa-lock-open"
                placeholder="{{ __('New Password') }}"
                alpine-model="data.password"
                type="password"
            />
            <small class="text-slate-500">
                {{ __('Your password must be at least 8 characters long.') }}
            </small>
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Confirm Password') }}"
                autocomplete="password"
                id="confirm-password"
                icon="fa-solid fa-lock"
                alpine-model="data.password_confirmation"
                placeholder="{{ __('Confirm Password') }}"
                type="password"
            />
            <small class="text-slate-500">
                {{ __('Confirm your new password.') }}
            </small>
        </div>

        <div class="flex justify-end gap-4 items-center">
            <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
            <x-ui.buttons.loadable
                alpine-model="loading"
                type="submit"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 py-3 text-white"
            >
                <i class="fa-solid fa-key mr-2"></i>
                {{ __('Update Settings') }}
            </x-ui.buttons.loadable>
        </div>

    </form>
</div>

