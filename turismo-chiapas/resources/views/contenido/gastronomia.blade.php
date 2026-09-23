@extends('layouts.sitio')

@section('titulo', 'Gastronomía de Chiapas')
@section('descripcion', 'Recetas tradicionales de las nueve regiones de Chiapas: Centro, Altos, Fronteriza, Frailesca, Norte, Selva, Sierra, Soconusco y Costa.')

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Gastronomía</h1>
                <p>Un recetario por región, de la revista de gastronomía chiapaneca. Toca una imagen para verla completa.</p>
            </div>
        </div>
        <p>
            @foreach ($regiones as $region)
                <a class="chip" href="#{{ $region->slug }}" style="font-size:.95rem;padding:.35rem .9rem">{{ $region->nombre }}</a>
            @endforeach
        </p>

        @foreach ($regiones as $region)
            <article class="region-gastronomica" id="{{ $region->slug }}" style="scroll-margin-top:5rem">
                <div class="intro">
                    @if ($region->imagen)
                        <button type="button" class="pagina-revista" data-galeria="{{ $region->slug }}" data-src="{{ asset('img/gastronomia/'.$region->imagen) }}" data-alt="Región {{ $region->nombre }}">
                            <img src="{{ asset('img/gastronomia/'.$region->imagen) }}" alt="Presentación de la región {{ $region->nombre }}" loading="lazy">
                        </button>
                    @endif
                    <div>
                        <h2>Región {{ $region->nombre }}</h2>
                        <p style="color:var(--gris)">{{ $region->platillos->count() }} recetas</p>
                        <div class="platillos">
                            @foreach ($region->platillos as $platillo)
                                <button type="button" class="platillo" data-galeria="{{ $region->slug }}" data-src="{{ asset('img/gastronomia/'.$platillo->imagen) }}" data-alt="{{ $platillo->nombre }}">
                                    <img src="{{ asset('img/gastronomia/'.$platillo->imagen) }}" alt="" loading="lazy">
                                    <span>{{ $platillo->nombre }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
