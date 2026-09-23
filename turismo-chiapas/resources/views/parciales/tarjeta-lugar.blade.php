{{-- Tarjeta de un lugar a partir del "resumen" de la API. Espera $lugar. --}}
@php($categoria = $lugar['categorias'][0] ?? null)
<article class="lugar">
    <div class="imagen">
        @if (! empty($lugar['portada']))
            <img src="{{ $lugar['portada']['miniatura'] }}" alt="" loading="lazy">
        @else
            <div class="sin-foto" style="background:{{ $categoria['color'] ?? '#1c4a38' }}">@include('parciales.icono', ['nombre' => $categoria['icono'] ?? 'pin', 'tamano' => 64])</div>
        @endif
        @isset($lugar['distancia_km'])
            <span class="distancia">{{ $lugar['distancia_km'] < 1 ? round($lugar['distancia_km'] * 1000).' m' : number_format($lugar['distancia_km'], 1).' km' }}</span>
        @endisset
    </div>
    <div class="cuerpo">
        <span class="region">{{ $lugar['origen']['nombre'] ?? '' }}</span>
        <h3><a href="{{ route('lugares.show', $lugar['slug']) }}">{{ $lugar['nombre'] }}</a></h3>
        @if (! empty($lugar['extracto']))
            <p>{{ \Illuminate\Support\Str::limit($lugar['extracto'], 110) }}</p>
        @endif
        <div style="margin-top:auto;padding-top:.3rem">
            @foreach (array_slice($lugar['categorias'], 0, 2) as $c)
                <span class="chip" style="background:{{ $c['color'] }}1f;color:{{ $c['color'] }}">{{ $c['nombre'] }}</span>
            @endforeach
        </div>
    </div>
</article>
