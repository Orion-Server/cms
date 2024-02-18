<x-title-box
    title="{{ __('Two-Factor Authentication') }}"
    icon="security-settings"
/>

<form
    class="mt-4 bg-white dark:bg-slate-950 border-b-2 border-gray-300 dark:border-gray-800 rounded-lg p-4 flex flex-col gap-6 shadow-lg"
    action="{{ $twoFactorRoute }}"
    method="POST"
>
    @csrf

    @includeWhen(Auth::user()->needsEnableTwoFactorAuthentication(), 'pages.users.settings.fragments.2fa.enable')
    @includeWhen(Auth::user()->hasIncompleteTwoFactorAuthentication(), 'pages.users.settings.fragments.2fa.confirm')
    @includeWhen(Auth::user()->hasEnabledTwoFactorAuthentication(), 'pages.users.settings.fragments.2fa.disable')
</form>

@if(session()->has('error'))
    <script>
        document.addEventListener('alpine:init', () => {
            window.notyf.error("{{ session()->get('error') }}", 8000)
        });
    </script>
@endif
