@props([
    'type' => null,
    'icon' => null,
    'before' => null,
    'after' => null,
])

<button type="button"
    data-tippy
    data-editor
    data-before="{{ $before }}"
    data-after="{{ $after }}"
    data-tippy-content="<small>{!! $type !!}</small>"
    class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
>
    <i class="{{ $icon }}"></i>
    <span class="sr-only">{!! $type !!}</span>
</button>
