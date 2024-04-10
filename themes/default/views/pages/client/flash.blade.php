@php($showCmsToggleButton = config('hotel.client.flash.cms_toggle_button'))
@php($showOnlineCountButton = config('hotel.client.flash.online_count_button'))
@php($baseFlashUrl = config('app.url') . config('hotel.client.flash.relative_files_path'))

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>Flash Client - {{ getSetting('hotel_name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    @vite(['resources/scss/app.scss'])
    <script src="{{ asset('assets/js/swfobject.js') }}"></script>

    <script>
        var flashvars = {
            "external.texts.txt": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_external_flash_texts')) }}",
            "connection.info.host": "{{ config('hotel.client.flash.emulator_host') }}",
            "connection.info.port": "{{ config('hotel.client.flash.emulator_port') }}",
            "furnidata.load.url": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_furnidata')) }}",
            "external.variables.txt": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_external_variables')) }}",
            "client.allow.cross.domain": "1",
            "url.prefix": "",
            "external.override.texts.txt": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_external_flash_override_texts')) }}",
            "external.figurepartlist.txt": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_figuredata')) }}",
            "flash.client.origin": "popup",
            "client.starting": "Please wait, the client is loading...",
            "processlog.enabled": "0",
            "client.reload.url": @json(route('hotel.flash')),
            "client.fatal.error.url": @json(route('hotel.client-errors')),
            "client.connection.failed.url": @json(route('hotel.client-errors')),
            "has.identity": "1",
            "productdata.load.url": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_productdata')) }}",
            "flash.dynamic.avatar.download.configuration": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_figuremap')) }}",
            "client.starting.revolving": @json(implode('/', config('hotel.client.flash.loading_phrases'))),
            "external.override.variables.txt": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_external_override_variables')) }}",
            "sso.ticket": "{{ $authTicket }}",
            "account_id": @json(auth()->user()->id),
            "flash.client.url": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_production')) }}",
            "unique_habbo_id": @json("hhbr-" . \Str::random(20)),
        };

        var params = {
            "base": "{{ sprintf('%s%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_production')) }}",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };

        document.addEventListener('alpine:init', () => {
            if(!swfobject.hasFlashPlayerVersion("1")) {
                location.href = "{{ route('index') }}?unsupported_flash=1";
                return;
            }

            swfobject.embedSWF(
                "{{ sprintf('%s%s/%s', $baseFlashUrl, config('hotel.client.flash.external_files.flash_production'), 'Habbo.swf') }}",
                'flash-container',
                '100%',
                '100%',
                '11.1.0',
                '',
                flashvars, params, null, null
            );
        })
    </script>
</head>
<body
    class="w-full h-full dark:bg-slate-950 overflow-x-hidden"
    x-data="client(
        '{{ $showOnlineCountButton ? route('api.hotel.online-count') : null }}'
    )"
>
    <main>
        <div class="fixed z-50 top-0 left-0 pl-2 pt-2 h-12 flex gap-2">
            @if ($showCmsToggleButton)
            <x-ui.buttons.default
                class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                @click="toggleCms"
            >
                <template x-if="!showCmsFrame">
                    <i class="fa-solid fa-house-user"></i>
                </template>

                <template x-if="showCmsFrame">
                    <i class="fa-solid fa-rotate-left"></i>
                </template>
            </x-ui.buttons.default>
            @endif

            @if ($showOnlineCountButton)
            <div
                x-transition.duration.1000ms
                x-show="!showCmsFrame"
            >
                <x-ui.buttons.default
                    class="dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75 py-2 text-white"
                    @click="reloadOnlineCount()"
                >
                    <i class="fa-solid fa-users relative">
                        <i class="fa fa-solid fa-circle text-green-400 absolute right-0 bottom-0 fa-2xs"></i>
                    </i>
                    <span x-text="onlineCount"></span>
                </x-ui.buttons.default>
            </div>
            @endif
        </div>

        <div
            x-transition.origin.left.center
            class="relative"
            x-bind:class="{ 'left-full': showCmsFrame }"
        >
            <div>
                <div id="flash-wrapper" style="z-index: 2; overflow: hidden; position: absolute; top: 0; left: 0; width: 100vw; height: 100vh">
                    <div id="flash-container"></div>
                </div>
            </div>
        </div>

        @if ($showCmsToggleButton)
        <div
            x-show="showCmsFrame"
            style="display: none"
        >
            <iframe
                src="/?fromClient=1"
                class="overflow-hidden dark:bg-slate-950 left-0 top-0 w-screen h-screen border-none m-0 p-0 z-20"
            >
            </iframe>
        </div>
        @endif

        <div class="fixed z-[150] bg-black/[0.9] top-0 left-0 w-full h-full flex justify-center items-center flex-col gap-4"
            x-transition
            x-show="isDisconnected"
            style="display: none"
        >
            <span class="text-4xl text-center text-white font-bold flex gap-2 animate__animated animate__pulse animate__infinite">
                {{ __('You have been disconnected.') }}
            </span>

            <div class="flex gap-4">
                <x-ui.buttons.redirectable
                    class="dark:bg-emerald-500 bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white"
                    href="{{ route('hotel.nitro') }}"
                >
                    {{ __('Reload') }}
                </x-ui.buttons.redirectable>

                <x-ui.buttons.redirectable
                    class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                    href="{{ route('index') }}"
                >
                    {{ __('Back to website') }}
                </x-ui.buttons.redirectable>
            </div>
        </div>
    </main>
    @vite(['resources/js/client.js'])
</body>
</html>
