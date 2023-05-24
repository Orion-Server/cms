@extends('layouts.app')

@section('content')
    <x-container>
        @includeWhen(!Auth::check(), 'pages.guest.index')
        @includeWhen(Auth::check(), 'pages.users.index')
    </x-container>
@endsection
