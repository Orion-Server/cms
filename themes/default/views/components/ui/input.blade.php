@props([
    'type' => null,
    'label' => null,
    'labelClasses' => null,
    'placeholder' => null,
    'autocomplete' => 'off',
    'alpineModel' => null,
    'icon' => null,
    'disabled' => false,
    'readonly' => false,
    'defaultValue' => null,
    'small' => false,
    'id' => null,
    'name' => null,
    'autofocus' => false,
    'ref' => null
])

@if ($label)
<label
    @if($id) for="{{ $id }}" @endif
    class="text-gray-700 text-left font-semibold mb-2 dark:text-gray-200 text-sm {{ $labelClasses }}"
>
    <i class="{{ $icon }} mr-1"></i>
    {!! $label !!}
</label>
@endif
<input
    type="{{ $type }}"
    autocomplete="{{ $autocomplete }}"
    placeholder="{!! $placeholder !!}"
    @if($alpineModel) x-model="{{ $alpineModel }}" @endif
    @if($defaultValue) value="{{ $defaultValue }}" @endif
    @if($name) name="{{ $name }}" @endif
    @if($autofocus) autofocus @endif
    @if($id) id="{{ $id }}" @endif
    @if($ref) x-ref="{{ $ref }}" @endif
    @disabled($disabled)
    @readonly($readonly)
    @class([
        "bg-gray-50 font-normal text-gray-700 focus:outline-none border-b-4 dark:border-gray-700 dark:text-white dark:bg-transparent border-gray-300 focus:border-blue-500 dark:focus:border-blue-500 border rounded-lg block w-full appearance-none",
        "py-2 px-4" => !$small,
        "py-2 px-2 text-sm" => $small
    ])
>
