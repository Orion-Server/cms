@method('DELETE')

<span class="w-full bg-slate-100 border border-slate-300 dark:bg-slate-800 dark:border-slate-700 col-span-2 p-2 text-slate-800 dark:text-slate-200 rounded-lg text-sm">
    <i class="fa-solid fa-triangle-exclamation mr-1 animate-bounce text-warning-400"></i>
    {{ __("Disabling two-factor authentication removes an extra security measure, potentially increasing the vulnerability of your account to unauthorized entry.") }}
</span>
<div class="flex justify-end gap-4 items-center">
    <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
    <x-ui.buttons.default
        type="submit"
        class="dark:bg-red-600 bg-red-500 border-red-700 hover:bg-red-400 dark:hover:bg-red-500 dark:shadow-red-700/75 shadow-red-600/75 py-3 text-white"
        >
        <i class="fa-solid fa-key mr-2"></i>
        {{ __('Disable Two-Factor Authentication') }}
    </x-ui.buttons.default>
    <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
</div>
