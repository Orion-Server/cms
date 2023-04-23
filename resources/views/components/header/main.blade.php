<div class="bg-slate-950/75 w-1/2 z-[1] relative rounded-b-lg h-12 mx-auto">
    <nav class="h-full cursor-pointer">
        <ul class="grid grid-cols-4 text-gray-50 text-sm font-normal justify-around items-center h-full">
            @foreach (['Home', 'Community', 'Fórum', 'Help'] as $item)
                <a @class([
                    "flex justify-center h-full rounded-b-md transition transition-colors duration-500 items-center",
                    "bg-orange-400" => $loop->first,
                    "hover:bg-orange-400" => ! $loop->first,
                ]) href="#">
                    <span>{{ $item }}</span>
                </a>
            @endforeach
        </ul>
    </nav>
</div>
