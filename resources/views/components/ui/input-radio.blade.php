@props([
    'id' => null,
    'title' => null,
    'icon' => null,
    'imageIcon' => null,
    'value' => null,
    'alpineModel' => null,
    'selectedClasses' => null
])

<input type="radio" id="{{ $value }}" x-model="{{ $alpineModel }}" value="{{ $value }}" class="hidden peer" required>
<label
    for="{{ $value }}"
    class="inline-flex items-center justify-between w-full px-5 py-2 text-gray-500 border-b-4 border border-gray-300 rounded-lg cursor-pointer dark:hover:text-slate-300 dark:border-slate-700 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 dark:text-slate-400 dark:bg-slate-800 dark:hover:bg-slate-700"
    :class="{ '{{ $selectedClasses }}': {{ $alpineModel }} === '{{ $value }}' }"
    >
    <div class="block">
        <div class="w-full font-semibold">{!! $title !!}</div>
    </div>
    @if ($icon)
    <i class="{{ $icon }}"></i>
    @elseif ($imageIcon)
    <i class="icon border-none bg-transparent rounded-none {{ $imageIcon }}"></i>
    @endif
</label>
