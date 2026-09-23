@extends('layouts.sitio')

@section('titulo', $evento['nombre'])
@section('descripcion', \Illuminate\Support\Str::limit($evento['descripcion'] ?? $evento['nombre'], 155))

@php
    $proxima = $evento['proxima_fecha'] ? \Illuminate\Support\Carbon::parse($evento['proxima_fecha']) : null;
    $coordenadas = $evento['coordenadas'];
@endphp

@section('contenido')
<header class="ficha-portada" style="background:var(--selva)">
    @if (! empty($evento['portada']))
        <img src="{{ $evento['portada']['url'] }}" alt="">
    @endif
    <div class="contenedor">
        <div class="migas"><a href="{{ route('eventos.index') }}">Fiestas y ferias</a></div>
        <h1>{{ $evento['nombre'] }}</h1>
        @if ($proxima)
            <span class="chip" style="background:var(--cempasuchil);color:var(--tinta)">{{ $proxima->translatedFormat('j \d\e F \d\e Y') }}</span>
        @endif
    </div>
</header>

<section class="seccion">
    <div class="contenedor ficha">
        <div>
            @if ($evento['descripcion'])
                <div class="bloque">
                    <h2>La celebración</h2>
                    <p style="font-size:1.08rem">{{ $evento['descripcion'] }}</p>
                </div>
            @endif

            @if ($evento['actividades'])
                <div class="bloque">
                    <h2>Qué verás</h2>
                    <ul class="actividades"><li>{{ $evento['actividades'] }}</li></ul>
                </div>
            @endif

            @if (count($evento['fotos']) > 1)
                <div class="bloque">
                    <h2>Fotos</h2>
                    <div class="galeria">
                        @foreach ($evento['fotos'] as $foto)
                            <button type="button" data-galeria="evento" data-src="{{ $foto['url'] }}" data-alt="{{ $evento['nombre'] }}, foto {{ $loop->iteration }}">
                                <img src="{{ $foto['miniatura'] }}" alt="{{ $evento['nombre'] }}, foto {{ $loop->iteration }}" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <aside>
            <div class="panel">
                <h3>Cuándo y dónde</h3>
                @if ($proxima)
                    <p><strong>Próxima fecha:</strong> {{ $proxima->translatedFormat('l j \d\e F') }}@if ($evento['periodo']) ({{ $evento['periodo'] }})@endif</p>
                @endif
                @if ($evento['localizacion'])
                    <p><strong>Lugar:</strong> {{ $evento['localizacion'] }}</p>
                @endif
                @if ($evento['como_llegar'])
                    <p>{{ $evento['como_llegar'] }}</p>
                @endif
                @if ($coordenadas)
                    <a class="boton chico" href="https://www.google.com/maps/dir/?api=1&amp;destination={{ $coordenadas['latitud'] }},{{ $coordenadas['longitud'] }}" target="_blank" rel="noopener">@include('parciales.icono', ['nombre' => 'ruta', 'tamano' => 16]) Cómo llegar</a>
                @endif
            </div>
        </aside>
    </div>
</section>
@endsection
