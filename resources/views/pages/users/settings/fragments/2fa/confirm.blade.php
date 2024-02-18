<span class="w-full bg-slate-100 border border-slate-300 dark:bg-slate-800 dark:border-slate-700 col-span-2 p-2 text-slate-800 dark:text-slate-200 rounded-lg text-xs">
    <i class="fa-solid fa-triangle-exclamation mr-1 animate-bounce text-red-400"></i>
    {{ __("Store these recovery codes in a secure password manager. They can be used to recover access to your account if you lose your two-factor authentication device.") }}
</span>
<div class="flex flex-col md:flex-row gap-2">
    <div class="p-2 flex justify-center bg-slate-100 dark:bg-slate-700 rounded-lg border border-slate-300 dark:border-slate-600">
        {!! Auth::user()->twoFactorQrCodeSvg() !!}
    </div>
    <div class="flex-1 grid gap-2 grid-cols-1 sm:grid-cols-2 p-2 bg-slate-100 dark:bg-slate-700 rounded-lg border border-slate-300 dark:border-slate-600">
        @foreach (auth()->user()->recoveryCodes() as $code)
            <small
                class="flex font-bold dark:text-slate-200 rounded-lg justify-center items-center bg-white border border-slate-200 dark:bg-slate-850 dark:border-slate-600"
            >{{ $code }}</small>
        @endforeach
    </div>
</div>
<div class="flex flex-col">
    <x-ui.input
        label="{{ __('Confirmation Code') }}"
        autocomplete="code"
        id="confirm-code"
        icon="fa-solid fa-key"
        name="code"
        placeholder="{{ __('Code') }}"
        type="text"
    />
</div>

<div class="flex flex-col">
    <x-ui.buttons.default
        type="submit"
        class="dark:bg-blue-600 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 flex-1 py-3 text-white">
        <i class="fa-regular fa-square-check"></i>
        {{ __('Confirm') }}
    </x-ui.buttons.default>
</div>
