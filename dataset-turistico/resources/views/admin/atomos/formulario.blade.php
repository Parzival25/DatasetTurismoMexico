@extends('layouts.admin')

@php($editando = $atomo->exists)

@section('titulo', $editando ? $atomo->nombre : 'Nuevo átomo')

@push('cabecera')
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
@endpush

@section('contenido')
<header>
    <h1>{{ $editando ? $atomo->nombre : 'Nuevo átomo' }}</h1>
    @if ($editando)
        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
            <a class="boton secundario chico" href="{{ route('portal.atomo', $atomo->slug) }}" target="_blank">Ver ficha ↗</a>
            <a class="boton secundario chico" href="{{ route('api.atomos.show', $atomo->id) }}" target="_blank">JSON ↗</a>
        </div>
    @endif
</header>

<form method="post" action="{{ $editando ? route('admin.atomos.update', $atomo) : route('admin.atomos.store') }}">
    @csrf
    @if ($editando) @method('put') @endif

    <fieldset>
        <legend>Datos generales</legend>
        <div class="fila-formulario">
            <div class="campo" style="grid-column:span 2">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $atomo->nombre) }}" required maxlength="255">
            </div>
            <div class="campo">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $atomo->slug) }}" pattern="[A-Za-z0-9_\-]+" placeholder="Se genera solo">
            </div>
            <div class="campo">
                <label for="origen_id">Origen</label>
                <select id="origen_id" name="origen_id">
                    <option value="">—</option>
                    @foreach ($origenes as $origen)
                        <option value="{{ $origen->id }}" @selected(old('origen_id', $atomo->origen_id) == $origen->id)>{{ $origen->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <label style="display:flex;gap:.45rem;align-items:center">
            <input type="hidden" name="activo" value="0">
            <input type="checkbox" name="activo" value="1" @checked(old('activo', $atomo->activo))> Activo (visible en la API y en los sitios que la consumen)
        </label>
        @if ($editando && $atomo->legado_activo !== null)
            <p class="ayuda" style="color:var(--gris-claro);font-size:.85rem;margin:.4rem 0 0">Valor «Activo» en el dataset original: {{ $atomo->legado_activo === '' ? 'vacío' : $atomo->legado_activo }} · número original #{{ $atomo->numero_original ?? '—' }}</p>
        @endif
    </fieldset>

    <fieldset>
        <legend>Contenido</legend>
        <div class="campo">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="6">{{ old('descripcion', $atomo->descripcion) }}</textarea>
        </div>
        <div class="campo">
            <label for="localizacion">Localización</label>
            <textarea id="localizacion" name="localizacion" rows="2">{{ old('localizacion', $atomo->localizacion) }}</textarea>
        </div>
        <div class="campo">
            <label for="como_llegar">¿Cómo llegar?</label>
            <textarea id="como_llegar" name="como_llegar" rows="4">{{ old('como_llegar', $atomo->como_llegar) }}</textarea>
        </div>
        <div class="campo">
            <label for="actividades">Actividades</label>
            <textarea id="actividades" name="actividades" rows="4">{{ old('actividades', $atomo->actividades?->pluck('descripcion')->implode("\n")) }}</textarea>
            <span class="ayuda">Una actividad por línea.</span>
        </div>
    </fieldset>

    <fieldset>
        <legend>Ubicación</legend>
        <div class="fila-formulario">
            <div class="campo">
                <label for="latitud">Latitud</label>
                <input type="number" step="any" id="latitud" name="latitud" value="{{ old('latitud', $atomo->latitud) }}">
            </div>
            <div class="campo">
                <label for="longitud">Longitud</label>
                <input type="number" step="any" id="longitud" name="longitud" value="{{ old('longitud', $atomo->longitud) }}">
            </div>
        </div>
        <div id="selector-mapa" class="mapa-mini" style="height:340px"></div>
        <span class="ayuda" style="color:var(--gris-claro);font-size:.85rem">Haz clic en el mapa o arrastra el marcador para fijar la ubicación.</span>
    </fieldset>

    <fieldset>
        <legend>Clasificación</legend>
        <p class="etiqueta-campo" style="margin-bottom:.4rem">Categorías C1</p>
        <div class="casillas" style="margin-bottom:1rem">
            @php($c1 = old('categorias', $atomo->exists ? $atomo->categorias->pluck('id')->all() : []))
            @foreach ($categorias as $categoria)
                <label><input type="checkbox" name="categorias[]" value="{{ $categoria->id }}" @checked(in_array($categoria->id, $c1))> {{ $categoria->id }} · {{ $categoria->nombre }}</label>
            @endforeach
        </div>
        <p class="etiqueta-campo" style="margin-bottom:.4rem">Subcategorías C2 <span style="font-weight:400;color:var(--gris)">(cada subcategoría agrega su categoría automáticamente)</span></p>
        @include('admin.parciales.clasificacion', [
            'seleccionadas' => array_map('intval', old('subcategorias', $atomo->exists ? $atomo->subcategorias->pluck('id')->all() : [])),
        ])
    </fieldset>

    <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:2rem">
        <button class="boton" type="submit">{{ $editando ? 'Guardar cambios' : 'Crear átomo' }}</button>
        <a class="boton secundario" href="{{ route('admin.atomos.index') }}">Volver</a>
    </div>
</form>

@if ($editando)
    @include('admin.parciales.fotos', ['modelo' => $atomo, 'tipo' => 'atomo'])

    <form method="post" action="{{ route('admin.atomos.destroy', $atomo) }}" data-confirmar="¿Eliminar «{{ $atomo->nombre }}» y todas sus fotos? No se puede deshacer. Si solo quieres ocultarlo, desmarca «Activo».">
        @csrf @method('delete')
        <button class="boton peligro" type="submit">Eliminar átomo</button>
    </form>
@endif
@endsection

@push('scripts')
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush
