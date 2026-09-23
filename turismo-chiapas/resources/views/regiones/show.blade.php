@extends('layouts.sitio')

@section('titulo', $region['nombre'])
@section('descripcion', 'Lugares turísticos de '.$region['nombre'].', Chiapas: '.($region['descripcion'] ?? ''))

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
@endpush

@php($porCategoria = collect($lugares)->groupBy(fn ($l) => $l['categorias'][0]['id'] ?? 0))

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="migas" style="color:var(--gris)"><a href="{{ route('regiones.index') }}">Regiones</a></div>
        <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">{{ $region['nombre'] }}</h1>
        <p style="color:var(--gris);max-width:60ch">{{ $region['descripcion'] }} · {{ $region['total_atomos'] }} lugares.</p>

        @if ($region['limites'])
            <div id="mapa-region" class="mapa-mini" style="height:380px;margin:1.5rem 0 2rem"
                 data-datos="{{ route('datos.mapa', ['region' => $region['slug']]) }}"
                 data-ficha="{{ route('lugares.show', '__slug__') }}"
                 data-limites="{{ json_encode([[$region['limites']['lat_min'], $region['limites']['lng_min']], [$region['limites']['lat_max'], $region['limites']['lng_max']]]) }}"></div>
        @endif

        @foreach ($categorias as $categoria)
            @continue(! $porCategoria->has($categoria['id']))
            <div style="margin-bottom:2.5rem">
                <h2 style="display:flex;align-items:center;gap:.6rem">
                    <span class="icono-circulo" style="display:inline-grid;place-items:center;width:40px;height:40px;border-radius:50%;background:{{ $categoria['color'] }};color:#fff">@include('parciales.icono', ['nombre' => $categoria['icono'], 'tamano' => 20])</span>
                    {{ $categoria['nombre'] }}
                </h2>
                <div class="rejilla">
                    @foreach ($porCategoria[$categoria['id']] as $lugar)
                        @include('parciales.tarjeta-lugar', ['lugar' => $lugar])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
    @if ($region['limites'])
        <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
        <script>
            (function () {
                var el = document.getElementById('mapa-region');
                var mapa = L.map(el, { scrollWheelZoom: false });
                mapa.fitBounds(JSON.parse(el.dataset.limites), { padding: [30, 30], maxZoom: 14 });
                L.tileLayer(@json(config('turismo.mapa.teselas')), { maxZoom: 19, attribution: @json(config('turismo.mapa.atribucion')) }).addTo(mapa);

                fetch(el.dataset.datos).then(function (r) { return r.json(); }).then(function (geojson) {
                    geojson.features.forEach(function (f) {
                        var p = f.properties;
                        var enlace = document.createElement('a');
                        enlace.href = el.dataset.ficha.replace('__slug__', encodeURIComponent(p.slug));
                        enlace.textContent = p.nombre;
                        L.circleMarker([f.geometry.coordinates[1], f.geometry.coordinates[0]], {
                            radius: 8, color: '#fff', weight: 2, fillColor: p.color || '#1c4a38', fillOpacity: 1
                        }).bindPopup(enlace).addTo(mapa);
                    });
                });
            })();
        </script>
    @endif
@endpush
