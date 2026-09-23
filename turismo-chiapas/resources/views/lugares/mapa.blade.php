@extends('layouts.sitio')

@section('titulo', 'Mapa turístico')

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/markercluster/MarkerCluster.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/markercluster/MarkerCluster.Default.css') }}">
@endpush

@section('contenido')
<div class="pagina-mapa">
    <aside id="panel-mapa">
        <button type="button" class="boton chico selva alternar-panel" id="alternar-panel" aria-expanded="true" aria-controls="contenido-panel">Filtros</button>
        <div class="contenido-panel" id="contenido-panel">
            <label class="oculto-visual" for="buscar-mapa">Buscar en el mapa</label>
            <input type="search" id="buscar-mapa" class="buscar" placeholder="Buscar por nombre…">
            <p class="resumen-mapa" id="resumen-mapa" aria-live="polite">Cargando lugares…</p>

            @foreach ($categorias as $categoria)
                <div class="filtro-categoria">
                    <label>
                        <input type="checkbox" class="filtro-c1" value="{{ $categoria['id'] }}" checked>
                        <span class="punto" style="background:{{ $categoria['color'] }}"></span>
                        {{ $categoria['nombre'] }}
                        <span class="total">{{ $categoria['total_atomos'] }}</span>
                    </label>
                    @php($subs = collect($categoria['subcategorias'])->where('total_atomos', '>', 0))
                    @if ($subs->isNotEmpty())
                        <details>
                            <summary>Elegir atractivos</summary>
                            <div class="subs">
                                @foreach ($subs as $sub)
                                    <label><input type="checkbox" class="filtro-c2" data-c1="{{ $categoria['id'] }}" value="{{ $sub['id'] }}"> {{ $sub['nombre'] }} ({{ $sub['total_atomos'] }})</label>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>
            @endforeach
            <p style="margin-top:1rem"><button type="button" class="boton chico contorno" id="limpiar-mapa">Mostrar todo</button></p>
        </div>
    </aside>

    <div id="mapa"
         data-datos="{{ route('datos.mapa') }}"
         data-ficha="{{ route('lugares.show', '__slug__') }}"
         data-centro="{{ json_encode(config('turismo.mapa.centro')) }}"
         data-zoom="{{ config('turismo.mapa.zoom') }}"
         data-teselas="{{ config('turismo.mapa.teselas') }}"
         data-atribucion="{{ config('turismo.mapa.atribucion') }}"></div>
</div>

<template id="iconos-categorias">
    @foreach ($categorias as $categoria)
        <span data-icono="{{ $categoria['icono'] }}">@include('parciales.icono', ['nombre' => $categoria['icono'], 'tamano' => 18])</span>
    @endforeach
</template>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('vendor/markercluster/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('js/mapa.js') }}"></script>
@endpush
