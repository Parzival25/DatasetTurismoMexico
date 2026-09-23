@extends('layouts.sitio')

@section('titulo', $lugar['nombre'])
@section('descripcion', \Illuminate\Support\Str::limit($lugar['descripcion'] ?? $lugar['nombre'].' en Chiapas', 155))
@if (! empty($lugar['portada']))
    @section('imagen', $lugar['portada']['url'])
@endif

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
@endpush

@php
    $coordenadas = $lugar['coordenadas'];
    $destino = $coordenadas ? $coordenadas['latitud'].','.$coordenadas['longitud'] : null;
@endphp

@section('contenido')
<header class="ficha-portada" style="background:{{ $colorPrincipal }}">
    @if (! empty($lugar['portada']))
        <img src="{{ $lugar['portada']['url'] }}" alt="">
    @endif
    <div class="contenedor">
        <div class="migas">
            <a href="{{ route('lugares.index') }}">Lugares</a>
            @if ($lugar['origen'])
                / <a href="{{ route('regiones.show', $lugar['origen']['slug']) }}">{{ $lugar['origen']['nombre'] }}</a>
            @endif
        </div>
        <h1>{{ $lugar['nombre'] }}</h1>
        <div>
            @foreach ($lugar['categorias'] as $categoria)
                <a class="chip" href="{{ route('lugares.index', ['categoria' => $categoria['slug']]) }}" style="background:{{ $categoria['color'] }};color:#fff">{{ $categoria['nombre'] }}</a>
            @endforeach
        </div>
    </div>
</header>

<section class="seccion">
    <div class="contenedor ficha">
        <div>
            @if ($lugar['descripcion'])
                <div class="bloque">
                    <h2>Sobre este lugar</h2>
                    <p style="font-size:1.08rem">{{ $lugar['descripcion'] }}</p>
                </div>
            @endif

            @if (count($lugar['fotos']) > 1)
                <div class="bloque">
                    <h2>Fotos</h2>
                    <div class="galeria">
                        @foreach ($lugar['fotos'] as $foto)
                            <button type="button" data-galeria="lugar" data-src="{{ $foto['url'] }}" data-alt="{{ $lugar['nombre'] }}, foto {{ $loop->iteration }}">
                                <img src="{{ $foto['miniatura'] }}" alt="{{ $lugar['nombre'] }}, foto {{ $loop->iteration }}" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($lugar['actividades']))
                <div class="bloque">
                    <h2>Qué hacer</h2>
                    <ul class="actividades">
                        @foreach ($lugar['actividades'] as $actividad)
                            <li>{{ $actividad }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (count($lugar['subcategorias']))
                <div class="bloque">
                    <h2>Ideal para</h2>
                    @foreach ($lugar['subcategorias'] as $sub)
                        <a class="chip" href="{{ route('lugares.index', ['categoria' => collect($lugar['categorias'])->firstWhere('id', $sub['categoria_id'])['slug'] ?? null, 'subcategoria' => $sub['slug']]) }}">{{ $sub['nombre'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <aside>
            <div class="panel">
                <h3>Cómo llegar</h3>
                @if ($lugar['localizacion'])
                    <p><strong>Ubicación:</strong> {{ $lugar['localizacion'] }}</p>
                @endif
                @if ($lugar['como_llegar'])
                    <p>{{ $lugar['como_llegar'] }}</p>
                @endif
                @if ($destino)
                    <div id="mapa" class="mapa-mini" data-lat="{{ $coordenadas['latitud'] }}" data-lng="{{ $coordenadas['longitud'] }}" data-color="{{ $colorPrincipal }}" style="margin-bottom:1rem"></div>
                    <div class="acciones">
                        <a class="boton chico" href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $destino }}" target="_blank" rel="noopener">@include('parciales.icono', ['nombre' => 'ruta', 'tamano' => 16]) Google Maps</a>
                        <a class="boton chico selva" href="https://waze.com/ul?ll={{ $destino }}&amp;navigate=yes" target="_blank" rel="noopener">Waze</a>
                    </div>
                @else
                    <p style="color:var(--gris)">Aún no tenemos la ubicación exacta de este lugar.</p>
                @endif
            </div>
        </aside>
    </div>
</section>

@if (count($cercanos))
    <section class="seccion tenue">
        <div class="contenedor">
            <div class="seccion-titulo">
                <h2>Cerca de aquí</h2>
                <p>Aprovecha el viaje</p>
            </div>
            <div class="rejilla">
                @foreach ($cercanos as $cercano)
                    @include('parciales.tarjeta-lugar', ['lugar' => $cercano])
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection

@push('scripts')
    @if ($destino)
        <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
        <script>
            (function () {
                var el = document.getElementById('mapa');
                var punto = [parseFloat(el.dataset.lat), parseFloat(el.dataset.lng)];
                var mapa = L.map(el, { scrollWheelZoom: false }).setView(punto, 13);
                L.tileLayer(@json(config('turismo.mapa.teselas')), { maxZoom: 19, attribution: @json(config('turismo.mapa.atribucion')) }).addTo(mapa);
                L.circleMarker(punto, { radius: 10, color: '#fff', weight: 3, fillColor: el.dataset.color, fillOpacity: 1 }).addTo(mapa);
            })();
        </script>
    @endif
@endpush
