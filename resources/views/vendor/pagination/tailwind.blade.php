<nav aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-end {{ isset($onlyCounter) ? '' : 'w-full' }} py-4 font-light" role="navigation">
    <div class="flex items-center gap-4">
        <div>
            <p class="tracking-wide">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>
        <span>·</span>
        @if ($paginator->hasPages() && (!isset($onlyCounter) || !$onlyCounter))
            <div class="flex items-center gap-4">
                {{-- Previous Page Link --}}
                @if (!$paginator->onFirstPage())
                    <a aria-label="{{ __('pagination.first') }}" class="font-semibold hover:underline tracking-wide" href="{{ \Request::url() . '?page=1' }}" rel="first">
                        First
                    </a>
                    <a aria-label="{{ __('pagination.previous') }}" class="font-semibold hover:underline tracking-wide" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        Previous
                    </a>
                @endif
                @if (!$paginator->onFirstPage() && $paginator->hasMorePages())
                    <span>|</span>
                @endif
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a aria-label="{{ __('pagination.next') }}" class="font-semibold hover:underline tracking-wide" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        Next
                    </a>
                    <a aria-label="{{ __('pagination.last') }}" class="font-semibold hover:underline tracking-wide" href="{{ \Request::url() . '?page=' . $paginator->lastPage() }}" rel="last">
                        Last
                    </a>
                @endif
            </div>
        @endif
    </div>
</nav>
