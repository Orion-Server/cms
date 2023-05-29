@extends('layouts.app')

@php($rankingTitle = [
    'diamonds' =>'Top Diamonds',
    'respects' =>'Top Respects',
    'coins' =>'Top Credits',
    'pixels' =>'Top Pixels',
    'points' =>'Top Points',
    'online-time' =>'Top Online Time'
])

@php($rankingDescription = [
    'diamonds' =>'This is customizable',
    'respects' =>'This is customizable',
    'coins' =>'This is customizable',
    'pixels' =>'This is customizable',
    'points' =>'This is customizable',
    'online-time' =>'This is customizable'
])

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
