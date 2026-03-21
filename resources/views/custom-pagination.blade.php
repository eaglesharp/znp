{{-- resources/views/custom-pagination.blade.php --}}
<div class="pagination" style="justify-content: space-between; align-items: center;">
    <div class="results-range">
        Showing
        {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} to
        {{ ($paginator->currentPage() - 1) * $paginator->perPage() + sizeof($paginator->items()) }}
    </div>
    <div class="d-flex">
        @if ($paginator->onFirstPage())
            <li class="disabled page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    aria-label="@lang('pagination.previous')">&laquo;</a>
            </li>
        @endif


        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array of Links --}}
            {{-- {{ dd($paginator) }} --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class=" page-item active" aria-current="page"><span
                                class="page-link">{{ $page }}</span></li>
                    @else
                        @if ($page == $paginator->currentPage() - 1)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == $paginator->currentPage() + 1)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                        @if ($paginator->currentPage() == 1 && $page == $paginator->currentPage() + 2)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($paginator->currentPage() == $paginator->lastPage() && $page == $paginator->lastPage() - 2)
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                    aria-label="@lang('pagination.next')">&raquo;</a>
            </li>
        @else
            <li class=" page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&raquo;</span>
            </li>
        @endif
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.pagination .d-flex li.disabled:not(.page-item)').addClass('d-none');
        });
    </script>
@endpush
