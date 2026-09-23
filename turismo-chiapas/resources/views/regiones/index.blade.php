@extends('layouts.sitio')

@section('titulo', 'Regiones')

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Regiones</h1>
                <p>Cada región reúne los lugares documentados por un proyecto de investigación local.</p>
            </div>
        </div>
        <div class="rejilla" style="grid-template-columns:repeat(auto-fill,minmax(300px,1fr))">
            @foreach ($regiones as $region)
                <a class="region-tarjeta" href="{{ route('regiones.show', $region['slug']) }}">
                    @if ($region['portada'])
                        <img src="{{ $region['portada']['url'] }}" alt="" loading="lazy">
                    @endif
                    <div>
                        <h3>{{ $region['nombre'] }}</h3>
                        <span>{{ $region['total_atomos'] }} lugares</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
