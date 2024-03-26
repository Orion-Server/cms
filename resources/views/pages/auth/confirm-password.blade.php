@php($cleanLayout = true)

@extends('layouts.app')

@section('title', __('Confirm your password'))

@section('content')
<x-container class="flex flex-col gap-4 justify-center items-center h-screen">
    <div class="fixed top-0 left-0 w-screen h-screen bg-black/25"></div>
    <div style="--logo-width: {{ $logoSize[0] }}px; --logo-height: {{ $logoSize[1] }}px; background-image: url({{ $logo }})" class="logo bg-center bg-no-repeat"></div>
    <div class="bg-white w-full lg:w-1/2 dark:bg-slate-850 overflow-hidden rounded-lg shadow relative border border-slate-300 dark:border-slate-600 p-4">
        <form class="space-y-4" method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="flex flex-col">
                <x-ui.input
                    label="{{ __('Please, confirm you password') }}"
                    autocomplete="password"
                    id="confirm-password"
                    icon="fa-solid fa-key"
                    name="password"
                    placeholder="{{ __('Password') }}"
                    type="password"
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
        </form>
    </div>
</x-container>
@endsection
