@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
            </li>

            @foreach (range(1, $paginator->lastPage()) as $page)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
            </li>
        </ul>
    </div>
@endif
