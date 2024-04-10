@props([
    'exclusive' => false
])

<button
    {{ $attributes->merge(['class' => $exclusive && "transition-colors p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4" ]) }}
    data-tippy
    type="button"
    data-tippy-trigger="click"
    data-tippy-interactive="true"
    data-tippy-content='{{ $confirmation }}'
>
    {{ $label }}
</button>
