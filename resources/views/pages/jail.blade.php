<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('You have been banned') }} - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    @vite(['resources/scss/app.scss'])
</head>
<body class="flex gap-6 flex-col lg:flex-row p-2 justify-center items-center bg-slate-950">
    <img src="{{ asset('assets/images/frank-jail.gif') }}" alt="frank-jail" />
    <div class="relative flex flex-col gap-6 max-w-lg">
        <span class="text-center text-white font-bold text-4xl animate__animated animate__pulse animate__infinite">
            <i class="fa-solid fa-skull mr-3"></i>{{ __('You have been banned') }}
        </span>
        <div class="bg-slate-800/50 border-b-4 border-slate-700/75 block rounded-lg p-4 text-white underline-offset-4">
            <div>
                <b class="underline">Banned by:</b>
                <span>{{ $ban->staff->username }}</span>
            </div>
            <div class="mt-2">
                <b class="underline">Ban Type:</b>
                <span>{{ Str::upper($ban->type) }}</span>
            </div>
            <div class="mt-2">
                <b class="underline">Reason:</b>
                <span>{{ $ban->ban_reason }}</span>
            </div class="mt-2">
            <div class="mb-8">
                <b class="underline">Expires at:</b>
                <span>{{ $ban->ban_expire == '0' ? 'Never' : date('Y-m-d H:i', $ban->ban_expire) }}</span>
            </div>
            <div class="text-xs block text-slate-200">
                If you want to protest or think this is a mistake, join our discord below.
            </div>
        </div>
        <div class="flex justify-end gap-4">
            @if ($ban->type == 'account')
                <form action="/logout" method="POST">
                    @csrf
                    <x-ui.buttons.default
                        class="bg-red-700 border-red-900 hover:bg-red-500 shadow-red-600/75 py-2 text-white">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>
                        {{ __('Logout') }}
                    </x-ui.buttons.default>
                </form>
            @endif
            <x-ui.buttons.redirectable
                href="{{ getSetting('discord_invite') }}"
                class="bg-slate-700 border-slate-850 hover:bg-slate-500 shadow-slate-600/75 py-2 text-white"
            >
                <i class="fa-brands fa-discord mr-1"></i>
                {{ __('Discord Contact') }}
            </x-ui.buttons.redirectable>
        </div>
    </div>
</body>
</html>
