@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginacion">
        @if ($paginator->onFirstPage())
            <span class="muted">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
        @endif

        <span class="muted">Pagina {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
        @else
            <span class="muted">Siguiente</span>
        @endif
    </nav>
@endif
