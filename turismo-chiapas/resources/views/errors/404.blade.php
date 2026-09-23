@extends('layouts.sitio')

@section('titulo', 'Página no encontrada')

@section('contenido')
<section class="seccion">
    <div class="contenedor vacio">
        <h1 style="font-size:2rem">No encontramos esa página</h1>
        <p>Puede que el lugar haya cambiado de nombre o ya no esté disponible.</p>
        <p><a class="boton selva" href="{{ route('lugares.index') }}">Ver todos los lugares</a> <a class="boton contorno" href="{{ route('mapa') }}" style="color:var(--selva)">Ir al mapa</a></p>
    </div>
</section>
@endsection
