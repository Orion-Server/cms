@extends('layouts.app')

@php($rankingTitle = [
    'diamonds' => __('Top Diamonds'),
    'respects' => __('Top Respects'),
    'coins' => __('Top Credits'),
    'duckets' => __('Top Duckets'),
    'pixels' => __('Top Pixels'),
    'points' => __('Top Points'),
    'online-time' => __('Top Online Time')
])

@php($rankingDescription = [
    'diamonds' => __('The richest users in diamonds'),
    'respects' => __('The richest users in respects'),
    'coins' => __('The richest users in coins'),
    'duckets' => __('The richest users in duckets'),
    'pixels' => __('The richest users in pixels'),
    'points' => __('The richest users in points'),
    'online-time' => __('Users who play the most')
])

@section('title', __('Leaderboards'))

@section('content')
<x-container class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-2 gap-6">
    @foreach ($rankings as $title => $rankingUnity)
        @include('pages.community.rankings._partials.ranking-box', [
            'icon' => $title,
            'title' => $rankingTitle[$title],
            'description' => $rankingDescription[$title],
            'rankings' => $rankingUnity,
            'isUserModel' => $title == 'coins'
        ])
    @endforeach
</x-container>
@endsection
