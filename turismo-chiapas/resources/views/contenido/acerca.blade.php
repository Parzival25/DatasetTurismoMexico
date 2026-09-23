@extends('layouts.sitio')

@section('titulo', 'Acerca del sitio')

@section('contenido')
<section class="seccion">
    <div class="contenedor prosa">
        <h1 style="font-size:clamp(1.9rem,4vw,2.8rem)">Acerca de Turismo Chiapas</h1>
        <p>
            Chiapas tiene destinos de clase mundial, pero también cientos de lugares pequeños y hermosos que solo conoce
            la gente de la región. Este sitio los reúne en un mapa, con su descripción, cómo llegar, qué hacer y fotos,
            para que cualquiera pueda descubrirlos.
        </p>

        <h2>De dónde viene la información</h2>
        <p>
            Todo el contenido de lugares y eventos se consulta en tiempo real al
            <a href="{{ config('turismo.dataset_portal') }}" target="_blank" rel="noopener">Conjunto de datos turísticos del Estado de Chiapas</a>,
            un dataset abierto del Instituto Tecnológico de Tuxtla Gutiérrez que hoy reúne
            {{ number_format($totales['atomos'] ?? 0) }} lugares, {{ $totales['eventos'] ?? 0 }} eventos y
            {{ number_format($totales['fotos'] ?? 0) }} fotografías de ocho proyectos de investigación.
        </p>
        <p>
            Este sitio es un ejemplo de lo que se puede construir con ese dataset: no guarda su propia copia de los lugares,
            solo los muestra. Si algún dato está mal, se corrige una sola vez en el dataset y se actualiza aquí y en
            cualquier otra aplicación que lo use.
        </p>

        <h2>Créditos</h2>
        <p>
            Dataset: Eduardo Pérez Hernández y Pamela Durante Cruz, con la asesoría del Dr. Héctor Guerra Crespo,
            a partir de los proyectos Mexmapa del ITTG. Recetario de gastronomía: revista de gastronomía chiapaneca del Prototipo 1.
            Mapas: © colaboradores de OpenStreetMap.
        </p>
    </div>
</section>
@endsection
