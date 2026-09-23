{{-- Evento en forma de fila con fecha. Espera $evento (resumen de la API). --}}
@php($proxima = ! empty($evento['proxima_fecha']) ? \Illuminate\Support\Carbon::parse($evento['proxima_fecha']) : null)
<a class="evento" href="{{ route('eventos.show', $evento['slug']) }}">
    <div class="fecha-caja">
        @if ($proxima)
            <strong>{{ $proxima->day }}</strong>
            <span>{{ $proxima->translatedFormat('M') }}</span>
        @else
            <strong>—</strong>
        @endif
    </div>
    <div>
        <h3>{{ $evento['nombre'] }}</h3>
        <p>{{ \Illuminate\Support\Str::limit($evento['extracto'] ?? '', 90) }}</p>
    </div>
</a>
