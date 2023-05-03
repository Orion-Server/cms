@props([
    'type' => null,
    'label' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'alpineModel' => null,
    'icon' => null,
    'disabled' => false,
    'defaultValue' => null,
    'small' => false
])

@if ($label)
<label class="text-gray-700 text-left font-semibold mb-2 dark:text-gray-200 text-sm">
    <i class="{{ $icon }} mr-1"></i>
    {{ $label }}
</label>
@endif
<input
    type="{{ $type }}"
    autocomplete="{{ $autocomplete }}"
    placeholder="{{ $placeholder }}"
    @if($alpineModel) x-model="{{ $alpineModel }}" @endif
    @if($defaultValue) value="{{ $defaultValue }}" @endif
    @disabled($disabled)
    @class([
        "bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 dark:border-gray-700 dark:text-white dark:bg-transparent border-gray-300 focus:border-blue-500 dark:focus:border-blue-500 border rounded-lg block w-full appearance-none",
        "py-2 px-4" => !$small,
        "py-2 px-2 text-sm" => $small
    ])
>
