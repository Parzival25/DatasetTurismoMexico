@extends('layouts.portal')

@section('titulo', 'Explorar')

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h1>Explorar los átomos</h1>
            <p>{{ number_format($atomos->total()) }} resultados</p>
        </div>

        <form class="filtros" method="get" action="{{ route('portal.explorar') }}">
            <div class="campo">
                <label for="q">Buscar</label>
                <input type="search" id="q" name="q" value="{{ $filtros['q'] ?? '' }}" placeholder="Nombre, lugar o descripción">
            </div>
            <div class="campo">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->slug }}" @selected(($filtros['categoria'] ?? '') === $categoria->slug)>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="campo">
                <label for="origen">Origen</label>
                <select id="origen" name="origen">
                    <option value="">Todos</option>
                    @foreach ($origenes as $origen)
                        <option value="{{ $origen->slug }}" @selected(($filtros['origen'] ?? '') === $origen->slug)>{{ $origen->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button class="boton" type="submit">Filtrar</button>
            @if (array_filter($filtros))
                <a class="boton secundario" href="{{ route('portal.explorar') }}">Limpiar</a>
            @endif
        </form>

        <div class="tabla-envoltura">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Clasificación</th>
                        <th>Origen</th>
                        <th>Coordenadas</th>
                        <th>Datos</th>
                    </tr>
                </thead>
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
                            <td><a href="{{ route('portal.atomo', $atomo->slug) }}"><strong>{{ $atomo->nombre }}</strong></a><br><span class="mono" style="color:var(--gris-claro)">#{{ $atomo->id }}</span></td>
                            <td>
                                @foreach ($atomo->categorias as $categoria)
                                    <span class="chip" style="background:{{ $categoria->color }}1f;color:{{ $categoria->color }}">{{ $categoria->nombre }}</span>
                                @endforeach
                            </td>
                            <td>{{ $atomo->origen?->nombre }}</td>
                            <td class="num mono">
                                @if ($atomo->tieneCoordenadas())
                                    {{ number_format($atomo->latitud, 4) }}, {{ number_format($atomo->longitud, 4) }}
                                @else
                                    <span class="chip aviso">sin coordenadas</span>
                                @endif
                            </td>
                            <td class="num"><a class="mono" href="{{ route('api.atomos.show', $atomo->id) }}">JSON</a> · {{ $atomo->fotos->count() }} fotos</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No hay átomos con esos filtros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $atomos->links() }}
    </div>
</section>
@endsection
