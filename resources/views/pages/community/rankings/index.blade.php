@extends('layouts.app')

@php($rankings = [
    'Top Diamonds' => 'diamonds',
    'Top Respects' => 'respects',
    'Top Credits' => 'coins',
    'Top Pixels' => 'pixels',
    'Top Points' => 'points',
    'Top Online Time' => 'online-time'
])

@section('content')
<x-container class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-2 gap-6">
    @foreach ($rankings as $title => $icon)
        @include('pages.community.rankings._partials.ranking-box', [
            'title' => $title,
            'icon' => $icon
        ])
    @endforeach
</x-container>
@endsection
