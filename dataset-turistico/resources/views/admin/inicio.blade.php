@extends('layouts.admin')

@section('titulo', 'Resumen')

@section('contenido')
<header>
    <h1>Resumen</h1>
    <span class="mono" style="color:var(--gris)">versión de datos {{ $version }}</span>
</header>

<div class="rejilla" style="margin-bottom:2rem">
    <div class="tarjeta"><h3>{{ number_format($totales['atomos']) }}</h3><p>átomos activos ({{ $totales['atomos_inactivos'] }} inactivos)</p></div>
    <div class="tarjeta"><h3>{{ $totales['eventos'] }}</h3><p>eventos</p></div>
    <div class="tarjeta"><h3>{{ number_format($totales['fotos']) }}</h3><p>fotos</p></div>
    <div class="tarjeta"><h3>{{ $totales['subcategorias'] }}</h3><p>subcategorías en {{ $totales['categorias'] }} categorías</p></div>
</div>

<h2>Pendientes de calidad</h2>
<div class="rejilla" style="margin-bottom:2rem">
    @foreach ([
        'sin_fotos' => 'Átomos sin fotos',
        'sin_coordenadas' => 'Átomos sin coordenadas',
        'sin_descripcion' => 'Átomos sin descripción',
        'sin_clasificacion' => 'Átomos sin clasificación',
    ] as $clave => $texto)
        <a class="tarjeta" href="{{ route('admin.atomos.index', ['pendiente' => $clave]) }}" style="text-decoration:none;color:inherit">
            <h3 style="color:{{ $pendientes[$clave] ? 'var(--ambar)' : 'var(--verde)' }}">{{ $pendientes[$clave] }}</h3>
            <p>{{ $texto }} →</p>
        </a>
    @endforeach
</div>

<div class="seccion-titulo">
    <h2>Reporte de la última importación</h2>
    @if ($reporte)
        <p>{{ \Illuminate\Support\Carbon::parse($reporte['fecha'])->translatedFormat('j \d\e F \d\e Y, H:i') }} ·
            {{ $reporte['corregidos'] }} correcciones automáticas · {{ $reporte['por_revisar'] }} puntos por revisar</p>
    @endif
</div>

@if (! $reporte)
    <p>Aún no se ha ejecutado <code>php artisan dataset:importar</code>.</p>
@else
    <p>
        @foreach (['revisar' => 'Por revisar', 'corregido' => 'Corregidos automáticamente', 'todos' => 'Todos'] as $valor => $texto)
            <a class="boton chico {{ $nivel === $valor ? '' : 'secundario' }}" href="{{ route('admin.inicio', ['nivel' => $valor]) }}">{{ $texto }}</a>
        @endforeach
    </p>
    <div class="tabla-envoltura">
        <table>
            <thead><tr><th>Nivel</th><th>Tipo</th><th>Registro</th><th>Detalle</th></tr></thead>
            <tbody>
                @forelse ($entradas as $entrada)
                    <tr>
                        <td><span class="chip {{ $entrada['nivel'] === 'revisar' ? 'aviso' : '' }}">{{ $entrada['nivel'] }}</span></td>
                        <td>{{ $entrada['tipo'] }}</td>
                        <td>
                            @if ($entrada['tipo'] === 'atomo' && isset($idsExistentes[$entrada['id']]))
                                <a href="{{ route('admin.atomos.edit', $entrada['id']) }}">#{{ $entrada['id'] }} {{ $entrada['nombre'] }}</a>
                            @elseif ($entrada['tipo'] === 'evento' && $entrada['id'])
                                <a href="{{ route('admin.eventos.edit', $entrada['id']) }}">#{{ $entrada['id'] }} {{ $entrada['nombre'] }}</a>
                            @else
                                {{ $entrada['id'] ? '#'.$entrada['id'] : '' }} {{ $entrada['nombre'] }}
                            @endif
                        </td>
                        <td>{{ $entrada['mensaje'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Sin entradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <p style="margin-top:.8rem;color:var(--gris);font-size:.9rem">El reporte completo está en <code>storage/app/reportes/importacion.csv</code>.</p>
@endif
@endsection
