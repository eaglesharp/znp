@if ($paginator->lastPage() > 1)
    <div class="pagination" style="justify-content: space-between; align-items: center;">
        <div class="results-range">
            Showing {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        <div class="d-flex">
            @if ($paginator->currentPage() > 1)
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @endif

            {{-- Add first page arrow --}}
            @if ($paginator->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                @if ($paginator->currentPage() > 4)
                    <span class="page-link disabled">...</span>
                @endif
            @endif

            @for ($i = max(1, $paginator->currentPage() - 1); $i <= min($paginator->lastPage(), $paginator->currentPage() + 1); $i++)
                <li>
                    @if ($i == $paginator->currentPage())
                        <span class="page-link active" style="background-color: #e4e4e4!important;"> {{ $i }}</span>
                    @else
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                </li>
            @endfor

            {{-- Add last page arrow --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <span class="page-link disabled">...</span>
                @endif
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            @if ($paginator->currentPage() < $paginator->lastPage())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </div>
    </div>
@endif
