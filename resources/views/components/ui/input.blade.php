@props([
    'type' => null,
    'label' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'alpineModel' => null,
    'icon' => null
])

@if ($label)
<label class="text-gray-700 text-left text-sm font-semibold mb-2 dark:text-gray-200">
    <i class="{{ $icon }} mr-1"></i>
    {{ $label }}
</label>
@endif
<input
    @if($alpineModel) x-model="{{ $alpineModel }}" @endif
    autocomplete="{{ $autocomplete }}"
    placeholder="{{ $placeholder }}"
    class="bg-gray-50 font-semibold text-gray-700 focus:outline-none border-b-4 dark:border-gray-700 dark:text-white dark:bg-transparent border-gray-300 focus:border-blue-500 dark:focus:border-blue-500 border rounded-lg py-2 px-4 block w-full appearance-none"
    type="{{ $type }}"
>
