<button
    {{ $attributes->merge(['class' => "p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded-lg border-b-4 text-white" ]) }}
>
    {{ $slot }}
</button>
