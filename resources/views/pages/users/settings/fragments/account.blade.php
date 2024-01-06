<x-title-box
    title="{{ __('Your account settings') }}"
    icon="account-settings"
/>

<div
    x-data="accountSettings('{{ route('users.settings.index', 'account') }}', '{{ $user->mail }}', '{{ $user->referral_code }}', '{{ $user->avatar_background }}')"
>
    <form
        class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg"
        action="{{ route('users.settings.index', 'account') }}"
        method="POST"
        @submit.prevent="submitForm"
    >
        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Email') }}"
                autocomplete="email"
                id="settings-email"
                icon="fa-solid fa-envelope"
                alpine-model="data.email"
                name="email"
                placeholder="{{ __('Email') }}"
                type="email"
            />
            <small class="text-slate-500">
                {{ __('To change the email, make sure the access is viable. You will need it to change your account password in case you forget it.') }}
            </small>
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Referral Code') }}"
                id="referral-code"
                icon="fa-solid fa-user-plus"
                alpine-model="data.referral_code"
                name="referral_code"
                placeholder="{{ __('Referral Code') }}"
                type="text"
            />
            <small class="text-slate-500">
                {{ __('Customize your referral code above. This is the code that you can share with your friends and family to earn rewards.') }}
            </small>
        </div>

        <div class="flex flex-col gap-1">
            <x-ui.input
                label="{{ __('Avatar Background') }}"
                id="referral-code"
                icon="fa-solid fa-user-plus"
                alpine-model="data.avatar_background"
                name="avatar_background"
                placeholder="{{ __('Avatar Background') }}"
                type="text"
            />
            <small class="text-slate-500 border-l-4 border-red-400 pl-2">
                {{ __('Any image that violates hotel standards or respect for others will be deleted and you will be punished.') }}
            </small>
        </div>

        <div class="flex justify-end gap-4 items-center">
            <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
            <x-ui.buttons.loadable
                alpine-model="loading"
                type="submit"
                class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 py-3 text-white"
            >
                <i class="fa-regular fa-address-card mr-2"></i>
                {{ __('Update Settings') }}
            </x-ui.buttons.loadable>
        </div>
    </form>
</divx-data=>
