@extends('layouts.portal')

@section('titulo', $atomo->nombre)
@section('descripcion', \Illuminate\Support\Str::limit($atomo->descripcion ?? $atomo->nombre, 155))

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
@endpush

@section('contenido')
<header class="ficha-encabezado">
    <div class="contenedor">
        <div class="migas"><a href="{{ route('portal.explorar') }}">Explorar</a> / {{ $atomo->origen?->nombre }}</div>
        <h1>{{ $atomo->nombre }}</h1>
        <div>
            @foreach ($atomo->categorias as $categoria)
                <span class="chip" style="background:{{ $categoria->color }}1f;color:{{ $categoria->color }}">{{ $categoria->nombre }}</span>
            @endforeach
            @foreach ($atomo->subcategorias as $subcategoria)
                <span class="chip">{{ $subcategoria->nombre }}</span>
            @endforeach
            @unless ($atomo->activo)
                <span class="chip inactivo">inactivo</span>
            @endunless
        </div>
    </div>
</header>

<section class="seccion">
    <div class="contenedor rejilla-2">
        <div>
            @if ($atomo->fotos->isNotEmpty())
                <div class="dato">
                    <h3>Fotos ({{ $atomo->fotos->count() }})</h3>
                    <div class="galeria">
                        @foreach ($atomo->fotos as $foto)
                            <a href="{{ $foto->url() }}" target="_blank" rel="noopener"><img src="{{ $foto->urlMiniatura() }}" alt="{{ $atomo->nombre }}, foto {{ $loop->iteration }}" loading="lazy"></a>
                        @endforeach
                    </div>
                </div>
            @endif

            @foreach (['descripcion' => 'Descripción', 'localizacion' => 'Localización', 'como_llegar' => '¿Cómo llegar?'] as $campo => $titulo)
                <div class="dato">
                    <h3>{{ $titulo }}</h3>
                    <p>{{ $atomo->{$campo} ?? 'Sin información.' }}</p>
                </div>
            @endforeach

            @if ($atomo->actividades->isNotEmpty())
                <div class="dato">
                    <h3>Actividades</h3>
                    <ul class="lista-actividades">
                        @foreach ($atomo->actividades as $actividad)
                            <li>{{ $actividad->descripcion }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <aside>
            @if ($atomo->tieneCoordenadas())
                <div id="mapa" class="mapa-mini" data-lat="{{ $atomo->latitud }}" data-lng="{{ $atomo->longitud }}"></div>
            @endif
            <div class="tarjeta" style="margin-top:1rem">
                <dl class="metadatos">
                    <dt>ID</dt><dd class="mono">{{ $atomo->id }}</dd>
                    <dt>Slug</dt><dd class="mono">{{ $atomo->slug }}</dd>
                    <dt>Latitud</dt><dd class="mono">{{ $atomo->latitud ?? '—' }}</dd>
                    <dt>Longitud</dt><dd class="mono">{{ $atomo->longitud ?? '—' }}</dd>
                    <dt>C1</dt><dd class="mono">{{ $atomo->categorias->pluck('id')->implode(', ') ?: '—' }}</dd>
                    <dt>C2</dt><dd class="mono">{{ $atomo->subcategorias->pluck('id')->implode(', ') ?: '—' }}</dd>
                    <dt>Origen</dt><dd>{{ $atomo->origen?->nombre }} (#{{ $atomo->numero_original ?? '—' }})</dd>
                    <dt>Actualizado</dt><dd>{{ $atomo->updated_at?->translatedFormat('j M Y') }}</dd>
                </dl>
                <p style="margin:1rem 0 0;display:flex;gap:.5rem;flex-wrap:wrap">
                    <a class="boton chico" href="{{ route('api.atomos.show', $atomo->id) }}">Ver en JSON</a>
                    <a class="boton chico secundario" href="{{ route('api.atomos.cercanos', $atomo->id) }}">Cercanos (JSON)</a>
                </p>
            </div>
        </aside>
    </div>
</section>
@endsection

@push('scripts')
    @if ($atomo->tieneCoordenadas())
        <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
        <script>
            (function () {
                var el = document.getElementById('mapa');
                var punto = [parseFloat(el.dataset.lat), parseFloat(el.dataset.lng)];
                var mapa = L.map(el, { scrollWheelZoom: false }).setView(punto, 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(mapa);
                L.marker(punto).addTo(mapa);
            })();
        </script>
    @endif
@endpush
