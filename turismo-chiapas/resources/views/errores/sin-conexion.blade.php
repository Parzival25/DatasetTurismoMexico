@extends('layouts.sitio')

@section('titulo', 'Información no disponible')

@section('contenido')
<section class="seccion">
    <div class="contenedor vacio">
        <h1 style="font-size:2rem">No pudimos cargar la información</h1>
        <p>El servicio de datos turísticos no responde en este momento. Intenta de nuevo en unos minutos.</p>
        <p><a class="boton selva" href="{{ url()->current() }}">Reintentar</a> <a class="boton contorno" href="{{ route('gastronomia') }}" style="color:var(--selva)">Mientras tanto, ver la gastronomía</a></p>
    </div>
</section>
@endsection
