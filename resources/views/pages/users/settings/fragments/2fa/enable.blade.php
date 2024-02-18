<span class="w-full bg-slate-100 border border-slate-300 dark:bg-slate-800 dark:border-slate-700 col-span-2 p-2 text-slate-800 dark:text-slate-200 rounded-lg text-sm">
    <i class="fa-solid fa-triangle-exclamation mr-1 animate-bounce text-blue-400"></i>
    {{ __("Enabling two-factor authentication adds an additional layer of security, safeguarding your account against unauthorized access.") }}
    <br><br>
    {{ __("We recommend that you use this security feature to keep your account free from any type of threat!") }}
</span>
<div class="flex justify-end gap-4 items-center">
    <x-ui.buttons.default
        type="submit"
        class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 py-3 text-white"
        >
        <i class="fa-solid fa-key mr-2"></i>
        {{ __('Enable Two-Factor Authentication') }}
    </x-ui.buttons.default>
    <div class="flex-1 border-b border-dashed border-gray-300 dark:border-slate-800"></div>
</div>
