@extends('layouts.sitio')

@section('titulo', 'Fiestas y ferias')

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Fiestas y ferias</h1>
                <p>Festivales, ferias y celebraciones que se repiten cada año en Chiapas.</p>
            </div>
        </div>

        @if ($proximo)
            <div class="panel" style="margin-bottom:2rem;border-left:5px solid var(--atardecer)">
                <span class="etiqueta" style="color:var(--atardecer);font-weight:700;text-transform:uppercase;letter-spacing:.08em;font-size:.8rem">La próxima</span>
                <h2 style="margin:.2rem 0 .3rem"><a href="{{ route('eventos.show', $proximo['slug']) }}" style="color:inherit">{{ $proximo['nombre'] }}</a></h2>
                <p style="margin:0;color:var(--gris)">{{ \Illuminate\Support\Carbon::parse($proximo['proxima_fecha'])->translatedFormat('l j \d\e F \d\e Y') }}</p>
            </div>
        @endif

        <p style="color:var(--gris);font-size:.95rem">Las fechas son aproximadas y pueden variar cada año; confírmalas con los organizadores antes de viajar.</p>

        @foreach ($porMes as $mes => $eventos)
            <div class="mes">
                <h2>{{ $mes }}</h2>
                @foreach ($eventos as $evento)
                    @include('parciales.tarjeta-evento', ['evento' => $evento])
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection
