@extends('layouts.admin')

@section('titulo', 'Átomos')

@section('contenido')
<header>
    <h1>Átomos <span style="color:var(--gris);font-weight:400;font-size:1rem">({{ number_format($atomos->total()) }})</span></h1>
    <a class="boton" href="{{ route('admin.atomos.create') }}">+ Nuevo átomo</a>
</header>

<form class="filtros" method="get">
    <div class="campo"><label for="q">Buscar</label><input type="search" id="q" name="q" value="{{ request('q') }}"></div>
    <div class="campo">
        <label for="origen">Origen</label>
        <select id="origen" name="origen">
            <option value="">Todos</option>
            @foreach ($origenes as $origen)
                <option value="{{ $origen->id }}" @selected(request('origen') == $origen->id)>{{ $origen->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="campo">
        <label for="estado">Estado</label>
        <select id="estado" name="estado">
            <option value="">Todos</option>
            <option value="activos" @selected(request('estado') === 'activos')>Activos</option>
            <option value="inactivos" @selected(request('estado') === 'inactivos')>Inactivos</option>
        </select>
    </div>
    <div class="campo">
        <label for="pendiente">Pendiente</label>
        <select id="pendiente" name="pendiente">
            <option value="">—</option>
            <option value="sin_fotos" @selected(request('pendiente') === 'sin_fotos')>Sin fotos</option>
            <option value="sin_coordenadas" @selected(request('pendiente') === 'sin_coordenadas')>Sin coordenadas</option>
            <option value="sin_descripcion" @selected(request('pendiente') === 'sin_descripcion')>Sin descripción</option>
            <option value="sin_clasificacion" @selected(request('pendiente') === 'sin_clasificacion')>Sin clasificación</option>
        </select>
    </div>
    <button class="boton" type="submit">Filtrar</button>
</form>

<div class="tabla-envoltura">
    <table>
        <thead><tr><th></th><th>Nombre</th><th>Origen</th><th>Clasificación</th><th>Estado</th><th>Fotos</th></tr></thead>
        <tbody>
            @forelse ($atomos as $atomo)
                <tr>
                    <td>
                        @if ($foto = $atomo->fotos->first())
                            <img class="miniatura" src="{{ $foto->urlMiniatura() }}" alt="" loading="lazy">
                        @else
                            <div class="miniatura"></div>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.atomos.edit', $atomo) }}"><strong>{{ $atomo->nombre }}</strong></a><br><span class="mono" style="color:var(--gris-claro)">#{{ $atomo->id }}</span></td>
                    <td>{{ $atomo->origen?->nombre }}</td>
                    <td>
                        @foreach ($atomo->categorias as $categoria)
                            <span class="chip" style="background:{{ $categoria->color }}1f;color:{{ $categoria->color }}">{{ $categoria->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span @class(['chip', 'inactivo' => ! $atomo->activo])>{{ $atomo->activo ? 'activo' : 'inactivo' }}</span>
                        @unless ($atomo->tieneCoordenadas())<span class="chip aviso">sin coordenadas</span>@endunless
                    </td>
                    <td class="num">{{ $atomo->fotos_count }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay resultados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $atomos->links() }}
@endsection
