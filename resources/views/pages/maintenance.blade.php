<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maintenance - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    @vite(['resources/scss/app.scss'])
</head>
<body
    class="bg-slate-900 bg-[url('/assets/images/maintenance-bg.png')] bg-no-repeat bg-[right_bottom_-1rem]"
>
    <div class="w-screen bg-black/25 h-screen flex flex-col items-center gap-4 justify-center p-4">
        <span class="font-extrabold text-7xl drop-shadow-lg text-slate-200">
            MAINTENANCE
        </span>
        <span class="font-lg text-lg text-slate-300">
            {{ getSetting('maintenance_reason') }}
        </span>

        <div class="flex gap-4">
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
                    class="bg-red-500 border-red-700 hover:bg-red-500 dark:shadow-red-500/75 shadow-red-400/75 flex-1 text-white"
                >
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Staff Login
                </x-ui.buttons.default>

                <x-ui.modal
                    alpine-model="showLoginModal"
                    title="Staff Login"
                    sub-title="Only for authorities!"
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
</body>
</html>
