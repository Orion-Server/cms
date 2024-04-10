@if(!! getSetting('maintenance'))
    <span class="w-full h-12 flex justify-center items-center bg-red-500 text-red-800 font-bold">
        <i class="fa-solid fa-exclamation-circle mr-2"></i>
        {{ __('The hotel is currently in maintenance mode.') }}
    </span>
@endif

@include('pages.users.fragments.change-username')

<x-header.main-nav />

<header @class([
    "relative pt-7 border-b border-slate-300 dark:border-slate-800 bg-blue-400 shadow-md dark:shadow-none bg-center bg-no-repeat-y",
    'h-[240px] lg:h-[180px] border-b-4 border-white' => ! Auth::check(),
    'h-[300px] lg:h-[240px]' => Auth::check(),
]) style="background-image: url({{ $headerBackground }})">
    <x-container class="flex flex-col lg:flex-row items-center justify-around h-full">
        <div class="flex flex-col gap-2 lg:gap-5">
            <div style="--logo-width: {{ $logoSize[0] }}px; --logo-height: {{ $logoSize[1] }}px; background-image: url({{ $logo }})" class="logo bg-center bg-no-repeat"></div>
            <div class="onlines-count bg-white w-auto px-4 rounded-lg h-10 relative dark:bg-gray-950 flex items-center justify-center">
                <div class="absolute h-2 w-2 bg-white dark:bg-gray-950 rotate-45 -top-1 left-1/2 -translate-x-1/2"></div>
                <span class="text-sm dark:text-slate-100">{{ __(":c connected habbo's", ['c' => User::whereOnline('1')->count()]) }}</span>
            </div>
        </div>
        @auth
        <div class="flex flex-col gap-2 lg:gap-4 items-start lg:min-w-[525px]">
            <x-header.user-box />
            @include('pages.users.fragments.user.client-buttons')
        </div>
        @endauth

        @guest
            <x-header.auth-nav />
        @endguest
    </x-container>
</header>

@auth
    @include('pages.users.fragments.user.balances')
@endauth
