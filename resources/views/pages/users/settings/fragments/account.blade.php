<x-title-box
    title="Your account settings"
    icon="account-settings"
/>

<div class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg">
    <div class="flex flex-col gap-1">
        <x-ui.input
            label="Your Email"
            autocomplete="email"
            id="settings-email"
            icon="fa-solid fa-envelope"
            name="email"
            default-value="{{ $user->mail }}"
            placeholder="Email"
            type="email"
            :autofocus="true"
        />
        <small class="text-slate-500">
            To change the email, make sure the access is viable. You will need it to change your account password in case you forget it.
        </small>
    </div>

    <div class="flex flex-col gap-1">
        <x-ui.input
            label="Referral Code"
            autocomplete="referral_code"
            id="referral-code"
            icon="fa-solid fa-user-plus"
            name="referral_code"
            default-value="{{ $user->referral_code }}"
            placeholder="Your referral code"
            type="text"
        />
        <small class="text-slate-500">
            Customize your referral code above. This is the code that you can share with your friends and family to earn rewards.
        </small>
    </div>

    <div class="flex justify-end gap-4 items-center">
        <div class="flex-1 border-b-2 border-dashed border-gray-300 dark:border-slate-800"></div>
        <x-ui.buttons.default
            @click="showRegisterModal = true"
            class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 py-3 text-white"
        >
            <i class="fa-solid fa-check"></i>
            Update Settings
        </x-ui.buttons.default>
    </div>

</div>
