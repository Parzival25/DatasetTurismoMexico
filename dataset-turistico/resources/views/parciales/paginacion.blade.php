@if ($paginator->hasPages())
    <nav class="paginacion" aria-label="Paginación">
        @if ($paginator->onFirstPage())
            <span class="deshabilitado">‹ Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="deshabilitado">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="actual" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente ›</a>
        @else
            <span class="deshabilitado">Siguiente ›</span>
        @endif
    </nav>
@endif
