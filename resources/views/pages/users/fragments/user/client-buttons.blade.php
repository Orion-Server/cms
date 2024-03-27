@php
    $flashClientEnabled = config('hotel.client.flash.enabled');
    $hasHousekeepingAccess = Auth::user()->rank >= getSetting('min_rank_to_housekeeping_login');
@endphp

<div class="p-1 rounded-full bg-black/50 flex flex-col justify-center items-start">
    @if (!$fromClient)
        <div @class([
            "grid gap-3",
            match (true) {
                $flashClientEnabled && $hasHousekeepingAccess => 'grid-cols-3',
                $flashClientEnabled || $hasHousekeepingAccess => 'grid-cols-2',
                default => 'grid-cols-1',
            }
        ])>
            @if(config('hotel.client.nitro.enabled'))
                <x-ui.buttons.redirectable
                    href="{{ route('hotel.nitro') }}"
                    data-turbolinks="false"
                    class="dark:bg-blue-500 text-center truncate bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white rounded-full"
                >
                    {{ __('Join (Nitro HTML5)') }}
                </x-ui.buttons.redirectable>
            @endif

            @if($flashClientEnabled)
                <x-ui.buttons.redirectable
                    href="{{ route('hotel.flash') }}"
                    data-turbolinks="false"
                    class="dark:bg-orange-500 text-center truncate bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white rounded-full"
                >
                    {{ __('Join (Flash)') }}
                </x-ui.buttons.redirectable>
            @endif

            @if ($hasHousekeepingAccess)
                <x-ui.buttons.redirectable
                    href="/admin"
                    target="_blank"
                    class="dark:bg-indigo-500 text-center truncate bg-indigo-500 border-indigo-700 hover:bg-indigo-400 dark:hover:bg-indigo-400 dark:shadow-indigo-700/75 shadow-indigo-600/75 py-2 text-white rounded-full"
                >
                    <i class="fa-solid fa-chart-line mr-1"></i>
                    {{ __('Housekeeping') }}
                </x-ui.buttons.redirectable>
            @endif
        </div>
    @endif
</div>
