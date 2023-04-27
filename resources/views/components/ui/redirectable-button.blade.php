<a
    {{ $attributes->merge(['class' => "cursor-pointer transition-colors p-2 px-4 text-sm relative gap-2 justify-center items-center font-semibold flex rounded border-b-4" ]) }}
>
    {{ $slot }}
</a>
