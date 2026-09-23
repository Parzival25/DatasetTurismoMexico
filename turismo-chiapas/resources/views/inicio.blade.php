@extends('layouts.sitio')

@section('contenido')
<section class="portada">
    <div class="contenedor">
        <div>
            <span class="etiqueta">Chiapas, México</span>
            <h1>Más allá de los destinos de siempre</h1>
            <p class="lead">
                {{ number_format($totales['atomos'] ?? 0) }} lugares para descubrir: cascadas escondidas, zonas arqueológicas,
                pueblos, miradores, balnearios y las fiestas que los llenan de vida.
            </p>
            <form class="buscador" action="{{ route('lugares.index') }}" method="get" role="search">
                <label class="oculto-visual" for="buscar">Buscar un lugar</label>
                <input type="search" id="buscar" name="q" placeholder="Busca una cascada, un pueblo, un museo…">
                <button class="boton" type="submit">Buscar</button>
            </form>
            <p style="margin-top:1.2rem"><a class="boton contorno" href="{{ route('mapa') }}" style="color:#fff">@include('parciales.icono', ['nombre' => 'pin', 'tamano' => 18]) Ver el mapa</a></p>
        </div>

        @if (count($mosaico))
            <div class="mosaico" aria-label="Lugares destacados">
                @foreach ($mosaico as $lugar)
                    <a href="{{ route('lugares.show', $lugar['slug']) }}">
                        <img src="{{ $loop->first ? $lugar['portada']['url'] : $lugar['portada']['miniatura'] }}" alt="" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        <span>{{ $lugar['nombre'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>¿Qué quieres hacer?</h2>
            <p>Explora por tipo de experiencia</p>
        </div>
        <div class="categorias">
            @foreach ($categorias as $categoria)
                <a class="categoria-tarjeta" href="{{ route('lugares.index', ['categoria' => $categoria['slug']]) }}">
                    <span class="icono-circulo" style="background:{{ $categoria['color'] }}">@include('parciales.icono', ['nombre' => $categoria['icono']])</span>
                    <strong>{{ $categoria['nombre'] }}</strong>
                    <small>{{ $categoria['total_atomos'] }} lugares</small>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="seccion tenue">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>Lugares para conocer</h2>
            <a class="boton selva chico" href="{{ route('lugares.index') }}">Ver todos</a>
        </div>
        <div class="rejilla">
            @foreach ($destacados as $lugar)
                @include('parciales.tarjeta-lugar', ['lugar' => $lugar])
            @endforeach
        </div>
    </div>
</section>

@if (count($eventos))
    <section class="seccion">
        <div class="contenedor">
            <div class="seccion-titulo">
                <h2>Próximas fiestas y ferias</h2>
                <a class="boton selva chico" href="{{ route('eventos.index') }}">Calendario completo</a>
            </div>
            <div class="rejilla" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr))">
                @foreach ($eventos as $evento)
                    @include('parciales.tarjeta-evento', ['evento' => $evento])
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="seccion tenue">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>Recorre Chiapas por región</h2>
            <a class="boton selva chico" href="{{ route('regiones.index') }}">Todas las regiones</a>
        </div>
        <p>
            @foreach ($regiones as $region)
                <a class="chip" href="{{ route('regiones.show', $region['slug']) }}" style="font-size:.95rem;padding:.35rem .9rem">{{ $region['nombre'] }} · {{ $region['total_atomos'] }}</a>
            @endforeach
        </p>
    </div>
</section>
@endsection
