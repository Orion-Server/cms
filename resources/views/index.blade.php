@extends('layouts.app')

@section('content')
<x-container>
    @guest
        <div class="w-full mb-4 text-gray-50 py-4 px-2 border text-sm border-red-500 rounded-lg bg-red-400 flex flex-col justify-center items-star gap-3">
            <span class="font-bold">
                <i class="fa-solid fa-circle-info mr-2"></i>
                OrionCMS is under development. Join our <a href="https://discord.com/invite/Kb7USXupCT" class="underline underline-offset-4 hover:animate-pulse" target="_blank">discord</a>.
            </span>
            <ul class="flex flex-col lg:flex-row gap-2 underline underline-offset-2">
                <li class="px-1"><a href="/login">Login</a></li>
                <li class="px-1"><a href="/register">Register</a></li>
                <li class="px-1"><a href="{{ route('articles.index') }}">Article Page</a></li>
                <li class="px-1"><a href="{{ route('community.photos.index') }}">Photos Page</a></li>
                <li class="px-1"><a href="{{ route('community.staff.index') }}">Staff Page</a></li>
                <li class="px-1"><a href="{{ route('community.rankings.index') }}">Rankings Page</a></li>
            </ul>
        </div>

        @include('pages.users.guest-me')
    @endguest

    @includeWhen(Auth::check(), 'pages.users.auth-me')
</x-container>
@endsection
