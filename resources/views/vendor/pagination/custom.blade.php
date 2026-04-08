<div class="premium-pagination-container">
    {{-- Pagination Summary --}}
    <div class="premium-pagination-info">
        Showing 
        <span class="text-primary-dark">{{ $paginator->firstItem() ?? 0 }}</span>
        to 
        <span class="text-primary-dark">{{ $paginator->lastItem() ?? 0 }}</span>
        of 
        <span class="text-primary-dark">{{ $paginator->total() }}</span> 
        entries
    </div>

    @if ($paginator->hasPages())
    <nav class="flex items-center gap-1.5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="btn-pagination btn-pagination-disabled" disabled>
                <i class="bi bi-chevron-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn-pagination btn-pagination-inactive">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-2 text-gray-400 text-xs font-black">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="btn-pagination btn-pagination-active shadow-md ring-4 ring-primary-dark/10">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="btn-pagination btn-pagination-inactive">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn-pagination btn-pagination-inactive">
                <i class="bi bi-chevron-right"></i>
            </a>
        @else
            <button class="btn-pagination btn-pagination-disabled" disabled>
                <i class="bi bi-chevron-right"></i>
            </button>
        @endif
    </nav>
    @endif
</div>
