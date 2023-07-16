@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1">
            @if ($paginator->onFirstPage())
                <span class="text-xss uppercase text-black/25 font-semibold">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <span data-href="{{ $paginator->previousPageUrl() }}" class="cursor-pointer text-xss uppercase text-black/75 font-semibold">
                    {!! __('pagination.previous') !!}
                </span>
            @endif

            @if ($paginator->hasMorePages())
                <span data-href="{{ $paginator->nextPageUrl() }}" class="cursor-pointer text-xss uppercase text-black/75 font-semibold">
                    {!! __('pagination.next') !!}
                </span>
            @else
                <span class="text-xss uppercase text-black/25 font-semibold">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>
    </nav>
@endif
