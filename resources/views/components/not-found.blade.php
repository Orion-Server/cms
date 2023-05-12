@props([
    'message' => 'Not found'
])
<div class="text-sm text-gray-400 flex justify-center text-semibold items-center">
    <img src="{{ asset('assets/images/dog-not-found.png') }}" alt="Dog not found" />
    {{ $message }}
</div>
