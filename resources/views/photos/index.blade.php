@extends('layouts.app')

@section('title', 'Photos')

@section('content')
<x-container>
    <div class="w-full h-auto flex flex-col">
        <div class="w-full h-16 bg-red-300">

        </div>
        <div class="w-full h-auto flex flex-wrap gap-2">
            @for ($i = 0; $i < 15; $i++)
                <div class="w-1/4 h-60 bg-green-300">

                </div>
            @endfor
        </div>
    </div>
</x-container>
@endsection
