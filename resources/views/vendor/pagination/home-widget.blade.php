@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center flex-col justify-between">
        <p class="text-xss text-black/75">
            @if ($paginator->firstItem())
                <span>{{ $paginator->firstItem() }}</span>
                -
                <span>{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            /
            <span>{{ $paginator->total() }}</span>
        </p>

        <div class="flex w-full justify-center gap-3 flex-1">
            @if ($paginator->onFirstPage())
                <span class="text-sm uppercase text-black/25">
                    <<
                </span>
            @else
                <span data-href="{{ $paginator->previousPageUrl() }}" class="hover:font-semibold cursor-pointer underline text-sm uppercase text-black/75">
                    <<
                </span>
            @endif

            @if ($paginator->hasMorePages())
                <span data-href="{{ $paginator->nextPageUrl() }}" class="hover:font-semibold cursor-pointer underline text-sm uppercase text-black/75">
                    >>
                </span>
            @else
                <span class="text-sm uppercase text-black/25">
                    >>
                </span>
            @endif
        </div>
    </nav>
@endif
