@extends('layouts.portal')

@section('titulo', 'Acerca de')

@section('contenido')
<section class="seccion">
    <div class="contenedor" style="max-width:820px">
        <h1>Acerca del dataset</h1>
        <p>
            Chiapas tiene destinos de clase mundial, pero también cientos de parajes naturales, zonas arqueológicas,
            playas y destinos gastronómicos que solo conoce la población local. La información sobre ellos estaba
            dispersa en páginas HTML de distintos proyectos, sin una forma clara de reutilizarla.
        </p>
        <p>
            Este conjunto de datos reúne esa información en un solo lugar, con una estructura común, para que cualquier
            persona, desarrollador o sistema experto pueda crear contenido de difusión turística de forma rápida,
            sencilla y económica.
        </p>

        <h2 style="margin-top:2rem">¿Qué es un átomo turístico?</h2>
        <p>
            Es un conjunto de datos sobre un lugar determinado y específico al que las personas llegan para conocer y
            realizar actividades de esparcimiento o recreación. Cada átomo tiene una descripción, su georreferencia,
            cómo llegar, las actividades que se pueden realizar y fotografías.
        </p>

        <h2 style="margin-top:2rem">Origen de la información</h2>
        <p>
            Los datos provienen de ocho proyectos de Mexmapa desarrollados por investigadores del Instituto Tecnológico
            de Tuxtla Gutiérrez (mapa estatal, Acacoyagua, región Mezcalapa, Palenque, San Cristóbal de las Casas,
            Yajalón, Tuxtla Gutiérrez y región Zoque Tsotsil). Fueron recuperados, depurados y consolidados en el reporte
            de residencia profesional <em>“Conjunto de datos turísticos del Estado de Chiapas”</em> (2022), y
            reconstruidos en esta versión con acentos restaurados, clasificación unificada y fotos normalizadas.
        </p>
        <p>Hoy el dataset contiene {{ number_format($totales['atomos']) }} átomos activos, {{ $totales['eventos'] }} eventos y {{ number_format($totales['fotos']) }} fotografías.</p>

        <h2 style="margin-top:2rem">Créditos</h2>
        <ul>
            <li>Eduardo Pérez Hernández y Pamela Durante Cruz: recuperación, depuración y consolidación del dataset.</li>
            <li>Dr. Héctor Guerra Crespo: asesoría y proyectos Mexmapa de origen.</li>
            <li>Dra. Aida Guillermina Cossío Martínez: revisión.</li>
            <li>Instituto Tecnológico de Tuxtla Gutiérrez (TecNM).</li>
        </ul>

        <h2 style="margin-top:2rem">Uso</h2>
        <p>
            El dataset es de uso público y sin fines de lucro. Al reutilizarlo, cita la fuente. Solo el equipo del
            proyecto puede modificar los datos; si encuentras un error, repórtalo al equipo.
        </p>
    </div>
</section>
@endsection
