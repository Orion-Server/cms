@props([
    'alpineModel' => null,
    'small' => false,
])

<button
    x-bind:disabled="{{ $alpineModel }}"
    {{ $attributes->merge(['class' => "transition-colors disabled:!bg-slate-500 disabled:border-slate-700 p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4" ]) }}
>
    <span x-show="!({{ $alpineModel }})">
        {{ $slot }}
    </span>
    <span x-show="{{ $alpineModel }}" style="display: none">
        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i>
        @if(!$small)
        {{ __('Loading') }}...
        @endif
    </span>
</button>
