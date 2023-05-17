<x-title-box
    title="Your Security Settings"
    icon="security-settings"
/>

<div class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg">
    <div class="flex flex-col gap-1">
        <x-ui.input
            label="Current Password"
            autocomplete="password"
            id="current-password"
            icon="fa-solid fa-key"
            placeholder="Current Password"
            type="password"
        />
        <small class="text-slate-500">
            You need to enter your current password to update your password.
        </small>
    </div>

    <div class="flex flex-col gap-1">
        <x-ui.input
            label="New Password"
            autocomplete="password"
            id="new-password"
            icon="fa-solid fa-key"
            placeholder="New Password"
            type="password"
        />
        <small class="text-slate-500">
            Your password must be at least 8 characters long.
        </small>
    </div>

    <div class="flex flex-col gap-1">
        <x-ui.input
            label="Confirm Password"
            autocomplete="password"
            id="confirm-password"
            icon="fa-solid fa-key"
            placeholder="Confirm Password"
            type="password"
        />
        <small class="text-slate-500">
            Confirm your new password.
        </small>
    </div>

    <div class="flex justify-end gap-4 items-center">
        <div class="flex-1 border-b-2 border-dashed border-gray-300 dark:border-slate-800"></div>
        <x-ui.buttons.default
            @click="showRegisterModal = true"
            class="dark:bg-green-600 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-500 dark:shadow-green-700/75 shadow-green-600/75 py-3 text-white"
        >
            <i class="fa-solid fa-check"></i>
            Update Security
        </x-ui.buttons.default>
    </div>

</div>
