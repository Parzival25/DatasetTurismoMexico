@extends('layouts.admin')

@php($editando = $evento->exists)

@section('titulo', $editando ? $evento->nombre : 'Nuevo evento')

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
@endpush

@section('contenido')
<header>
    <h1>{{ $editando ? $evento->nombre : 'Nuevo evento' }}</h1>
    @if ($editando)
        <a class="boton secundario chico" href="{{ route('api.eventos.show', $evento->id) }}" target="_blank">JSON ↗</a>
    @endif
</header>

<form method="post" action="{{ $editando ? route('admin.eventos.update', $evento) : route('admin.eventos.store') }}">
    @csrf
    @if ($editando) @method('put') @endif

    <fieldset>
        <legend>Datos generales</legend>
        <div class="fila-formulario">
            <div class="campo" style="grid-column:span 2">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $evento->nombre) }}" required maxlength="255">
            </div>
            <div class="campo">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $evento->slug) }}" pattern="[A-Za-z0-9_\-]+" placeholder="Se genera solo">
            </div>
        </div>
        <div class="fila-formulario">
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $evento->fecha?->toDateString()) }}">
            </div>
            <div class="campo">
                <label for="periodo">Periodo</label>
                <input type="text" id="periodo" name="periodo" value="{{ old('periodo', $evento->periodo) }}" placeholder="Ej. del 8 al 23 de enero">
            </div>
        </div>
        <label style="display:flex;gap:.45rem;align-items:center">
            <input type="hidden" name="recurrente" value="0">
            <input type="checkbox" name="recurrente" value="1" @checked(old('recurrente', $evento->recurrente))> Se repite cada año en el mismo día y mes
        </label>
        <label style="display:flex;gap:.45rem;align-items:center;margin-top:.4rem">
            <input type="hidden" name="activo" value="0">
            <input type="checkbox" name="activo" value="1" @checked(old('activo', $evento->activo))> Activo
        </label>
    </fieldset>

    <fieldset>
        <legend>Contenido</legend>
        @foreach (['descripcion' => ['Descripción', 6], 'localizacion' => ['Localización', 2], 'como_llegar' => ['¿Cómo llegar?', 3], 'actividades' => ['Actividades', 3]] as $campo => [$etiqueta, $filas])
            <div class="campo">
                <label for="{{ $campo }}">{{ $etiqueta }}</label>
                <textarea id="{{ $campo }}" name="{{ $campo }}" rows="{{ $filas }}">{{ old($campo, $evento->{$campo}) }}</textarea>
            </div>
        @endforeach
    </fieldset>

    <fieldset>
        <legend>Ubicación</legend>
        <div class="fila-formulario">
            <div class="campo"><label for="latitud">Latitud</label><input type="number" step="any" id="latitud" name="latitud" value="{{ old('latitud', $evento->latitud) }}"></div>
            <div class="campo"><label for="longitud">Longitud</label><input type="number" step="any" id="longitud" name="longitud" value="{{ old('longitud', $evento->longitud) }}"></div>
        </div>
        <div id="selector-mapa" class="mapa-mini" style="height:300px"></div>
    </fieldset>

    <fieldset>
        <legend>Clasificación (C2)</legend>
        @include('admin.parciales.clasificacion', [
            'seleccionadas' => array_map('intval', old('subcategorias', $evento->exists ? $evento->subcategorias->pluck('id')->all() : [])),
        ])
    </fieldset>

    <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:2rem">
        <button class="boton" type="submit">{{ $editando ? 'Guardar cambios' : 'Crear evento' }}</button>
        <a class="boton secundario" href="{{ route('admin.eventos.index') }}">Volver</a>
    </div>
</form>

@if ($editando)
    @include('admin.parciales.fotos', ['modelo' => $evento, 'tipo' => 'evento'])

    <form method="post" action="{{ route('admin.eventos.destroy', $evento) }}" data-confirmar="¿Eliminar «{{ $evento->nombre }}» y todas sus fotos? No se puede deshacer.">
        @csrf @method('delete')
        <button class="boton peligro" type="submit">Eliminar evento</button>
    </form>
@endif
@endsection

@push('scripts')
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush
