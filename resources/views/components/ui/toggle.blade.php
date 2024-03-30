@props([
    'label' => null,
    'small' => true,
    'alpineModel' => null,
    'disabled' => false,
])

<label class="relative inline-flex items-start justify-start cursor-pointer">
    <input
        type="checkbox"
        class="sr-only peer"
        @if($alpineModel) x-model="{{ $alpineModel }}" @endif
        @if($alpineModel && $disabled) x-bind:disabled="{{ $disabled }}" @endif
        @if(!$alpineModel && $disabled) @disabled($disabled) @endif
    >
    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-400"></div>
    <div @class([
        "ml-3 text-gray-900 dark:text-gray-400",
        "text-xs" => $small,
        "text-sm" => !$small
    ])>
        {!! $label !!}
    </div>
</label>
