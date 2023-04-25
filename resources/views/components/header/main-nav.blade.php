@php
    $navigations = \App\Models\Navigation::getNavigations();
@endphp

<x-container class="flex justify-center items-end">
    <div class="bg-white w-1/2 z-[1] relative h-12 rounded-lg">
        <nav class="h-full cursor-pointer">
            <ul class="flex divide-x divide-blue-500 justify-between border-b-4 border-blue-500 text-blue-500 font-semibold text-sm items-center h-full">
                @foreach ($navigations as $item)
                    <a @class([
                        "flex-1 flex justify-center gap-2 px-8 h-full transition transition-colors duration-500 items-center",
                        "rounded-tl-lg" => $loop->first,
                        "rounded-tr-lg" => $loop->last,
                        "bg-blue-600 text-white" => \Route::current()->uri == $item->slug,
                        "hover:bg-blue-600 hover:text-white" => \Route::current()->uri != $item->slug,
                    ]) href="#">
                        <img src="{{ $item->icon }}" />
                        <span>{{ $item->label }}</span>
                        @if (! $item->subNavigations->isEmpty())
                            <span><i class="fa-solid fa-chevron-down text-xs"></i></span>
                        @endif
                    </a>
                @endforeach
            </ul>
        </nav>
    </div>
</x-container>
