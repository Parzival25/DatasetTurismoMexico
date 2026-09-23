@extends('layouts.sitio')

@section('titulo', $categoriaActual['nombre'] ?? 'Lugares')

@section('contenido')
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">{{ $categoriaActual['nombre'] ?? 'Lugares de Chiapas' }}</h1>
                <p>{{ $categoriaActual['descripcion'] ?? 'Todos los atractivos turísticos del estado.' }}</p>
            </div>
            <a class="boton selva chico" href="{{ route('mapa') }}">@include('parciales.icono', ['nombre' => 'pin', 'tamano' => 16]) Ver en el mapa</a>
        </div>

        <form class="filtros" method="get" action="{{ route('lugares.index') }}">
            <label>Buscar
                <input type="search" name="q" value="{{ $filtros['q'] ?? '' }}" placeholder="Nombre o lugar">
            </label>
            <label>Tipo de experiencia
                <select name="categoria" onchange="this.form.subcategoria && (this.form.subcategoria.value = ''); this.form.submit()">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria['slug'] }}" @selected(($filtros['categoria'] ?? '') === $categoria['slug'])>{{ $categoria['nombre'] }}</option>
                    @endforeach
                </select>
            </label>
            @if ($categoriaActual)
                <label>Atractivo
                    <select name="subcategoria">
                        <option value="">Todos</option>
                        @foreach ($categoriaActual['subcategorias'] as $sub)
                            @if ($sub['total_atomos'] > 0)
                                <option value="{{ $sub['slug'] }}" @selected(($filtros['subcategoria'] ?? '') === $sub['slug'])>{{ $sub['nombre'] }} ({{ $sub['total_atomos'] }})</option>
                            @endif
                        @endforeach
                    </select>
                </label>
            @endif
            <label>Región
                <select name="region">
                    <option value="">Todas</option>
                    @foreach ($regiones as $region)
                        <option value="{{ $region['slug'] }}" @selected(($filtros['region'] ?? '') === $region['slug'])>{{ $region['nombre'] }}</option>
                    @endforeach
                </select>
            </label>
            <button class="boton" type="submit">Filtrar</button>
            @if ($filtros)
                <a class="boton contorno chico" href="{{ route('lugares.index') }}">Quitar filtros</a>
            @endif
        </form>

        @if ($filtroInvalido)
            <div class="aviso">Ese filtro no existe. Prueba con otra categoría o región.</div>
        @endif

        <p style="color:var(--gris)">{{ number_format($lugares->total()) }} {{ $lugares->total() === 1 ? 'lugar' : 'lugares' }}</p>

        @if ($lugares->count())
            <div class="rejilla">
                @foreach ($lugares as $lugar)
                    @include('parciales.tarjeta-lugar', ['lugar' => $lugar])
                @endforeach
            </div>
            {{ $lugares->links() }}
        @else
            <div class="vacio">
                <p>No encontramos lugares con esos filtros.</p>
                <a class="boton selva" href="{{ route('lugares.index') }}">Ver todos los lugares</a>
            </div>
        @endif
    </div>
</section>
@endsection
