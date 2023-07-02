@extends('layouts.app')

@section('title', $user ? 'Profile of ' . $user->username : __('User not found.'))

@section('content')
    <x-container @class([
        "flex flex-col justify-center items-center"
    ]) x-data="userProfile('{{ route('api.profile.inventory', $user->username) }}')">
        @includeWhen(!$user, 'pages.users.profile.partials.user-not-found')

        @if ($user)
            @if(Auth::check() && $user->id == Auth::id())
            <div class="w-[928px] pb-2">
                <template x-if="editing">
                    <div class="flex justify-between">
                        <div class="flex gap-3">
                            <x-ui.buttons.default
                                class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                                @click="openInventory()"
                            >
                                <img src="https://i.imgur.com/vK1YFIt.png" alt="{{ __('Inventory') }}">
                                {{ __('Inventory') }}
                            </x-ui.buttons.default>
                            <x-ui.buttons.default
                                class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                                @click="openShop()"
                            >
                                <img src="https://i.imgur.com/MXWYY38.png" alt="{{ __('Shop') }}">
                                {{ __('Shop') }}
                            </x-ui.buttons.default>
                        </div>
                        <div class="flex gap-3">
                            <x-ui.buttons.default
                                class="dark:bg-red-500 bg-red-500 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75 py-2 text-white"
                                @click="editing = false"
                            >
                                <img src="https://i.imgur.com/9Q7dOd0.png" alt="{{ __('Cancel') }}">
                                {{ __('Cancel') }}
                            </x-ui.buttons.default>
                            <x-ui.buttons.default
                                class="dark:bg-emerald-500 bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white"
                                @click="saveInventory()"
                            >
                                <img src="https://i.imgur.com/c5GWgRv.png" alt="{{ __('Save') }}">
                                {{ __('Save') }}
                            </x-ui.buttons.default>
                        </div>

                        <x-ui.modal
                            alpine-model="showBagModal"
                            max-width="max-w-[800px]"
                        >
                            <x-home.inventory />
                        </x-ui.modal>
                    </div>
                </template>
                <template x-if="!editing">
                    <x-ui.buttons.default
                        class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                        @click="editing = true"
                    >
                        <img src="https://i.imgur.com/vK1YFIt.png" alt="{{ __('Edit') }}">
                        {{ __('Edit') }}
                    </x-ui.buttons.default>
                </template>
            </div>
            @else
            <span class="text-2xl underline underline-offset-4 font-bold mb-4 dark:text-slate-100">{{ __('Profile of :u', ['u' => $user->username]) }}</span>
            @endif

            <div class="border border-dashed border-slate-200 dark:border-slate-800 w-[928px] h-[1360px]">

            </div>
        @endif
    </x-container>
@endsection
