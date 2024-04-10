<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Maintenance') }} - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    @vite(['resources/scss/app.scss'])

    @include('partials.js-parities')
</head>
<body
    class="bg-slate-900 maintenance"
    x-data='orion(@json(getSetting("default_cms_mode")))'
>
    <div class="w-screen bg-black/25 h-screen flex flex-col items-center gap-4 justify-center p-4">
        <div style="--logo-width: {{ $logoSize[0] }}px; --logo-height: {{ $logoSize[1] }}px; background-image: url({{ $logo }})" class="logo bg-center bg-no-repeat"></div>
        <span class="font-extrabold text-4xl lg:text-7xl bg-gradient-to-r from-blue-600 via-red-500 to-indigo-400 inline-block text-transparent bg-clip-text">
            {{ strtoupper(__('MAINTENANCE')) }}
        </span>
        <span class="font-lg text-sm text-center lg:text-lg text-slate-400 -mt-3">
            {{ getSetting('maintenance_reason') }}
        </span>

        <div class="flex gap-4 mt-8">
            <x-ui.buttons.redirectable
                href="{{ getSetting('discord_invite') }}"
                class="bg-slate-700 border-slate-850 hover:bg-slate-500 shadow-slate-600/75 py-2 text-white"
            >
                <i class="fa-brands fa-discord mr-1"></i>
                Discord
            </x-ui.buttons.redirectable>

            <div x-data="authentication">
                <x-ui.buttons.default
                    @click="showLoginModal = true"
                    class="bg-sky-500 border-sky-700 hover:bg-sky-500 dark:shadow-sky-500/75 shadow-sky-400/75 flex-1 text-white"
                >
                    <i class="fa-solid fa-right-to-bracket"></i>
                    {{ __('Staff Login') }}
                </x-ui.buttons.default>

                <x-ui.modal
                    alpine-model="showLoginModal"
                    title="{{ __('Staff Login') }}"
                    sub-title="{{ __('Only for authorities!') }}"
                >
                    <x-forms.login
                        :remove-register-button="true"
                        :remove-social-buttons="true"
                    />
                </x-ui.modal>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
