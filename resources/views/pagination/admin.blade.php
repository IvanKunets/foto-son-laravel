@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Страницы">
        @if ($paginator->onFirstPage())
            <span class="pagination__muted">← Назад</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Назад</a>
        @endif

        <span class="pagination__info">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Вперёд →</a>
        @else
            <span class="pagination__muted">Вперёд →</span>
        @endif
    </nav>
@endif
