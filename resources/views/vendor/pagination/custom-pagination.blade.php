@if ($paginator->lastPage() > 1)
    <div class="pagination" style="justify-content: space-between; align-items: center;">
        <div class="results-range">
            Showing {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        <div class="d-flex">
            {{-- Previous Page Link --}}
            @if ($paginator->currentPage() > 1)
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @endif

            @php $added=[]; @endphp
            {{-- Display page numbers --}}
            @for ($i = 1; $i <= min(20, $paginator->lastPage()); $i++)
            @php $added[]=$i; @endphp
                <li class="page-item">
                    @if ($i == $paginator->currentPage())
                        <span class="page-link active" style="background-color: #e4e4e4!important;">{{ $i }}</span>
                    @else
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                </li>
            @endfor

            {{-- Ellipsis and Last Page --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <span class="page-link disabled">...</span>
                @endif
                @if(!in_array($paginator->lastPage(),$added))
                    <li class="page-item"><a class="page-link test" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                @endif
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </div>
    </div>
@endif
