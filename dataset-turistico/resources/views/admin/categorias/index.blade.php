@extends('layouts.admin')

@section('titulo', 'Clasificación')

@section('contenido')
<header>
    <h1>Clasificación C1 / C2</h1>
</header>

<p style="color:var(--gris)">Los códigos (id) son públicos: los usan la API y los sitios que consumen el dataset, por eso no se pueden cambiar ni borrar. Sí puedes renombrar, mover una subcategoría de grupo o crear nuevas.</p>

@foreach ($categorias as $categoria)
    <fieldset>
        <legend><span class="punto" style="display:inline-block;background:{{ $categoria->color }}"></span> C1 {{ $categoria->id }} · {{ $categoria->nombre }} <span style="font-weight:400;color:var(--gris)">({{ $categoria->atomos_count }} átomos)</span></legend>

        <form method="post" action="{{ route('admin.categorias.actualizar', $categoria) }}" class="filtros" style="margin-bottom:1rem">
            @csrf @method('put')
            <div class="campo"><label>Nombre</label><input type="text" name="nombre" value="{{ $categoria->nombre }}" required></div>
            <div class="campo" style="flex:2 1 280px"><label>Descripción</label><input type="text" name="descripcion" value="{{ $categoria->descripcion }}"></div>
            <div class="campo" style="flex:0 0 90px"><label>Color</label><input type="color" name="color" value="{{ $categoria->color }}" style="height:2.6rem;padding:.2rem"></div>
            <div class="campo" style="flex:0 1 150px">
                <label>Icono</label>
                <select name="icono">
                    @foreach ($iconos as $icono)
                        <option value="{{ $icono }}" @selected($categoria->icono === $icono)>{{ $icono }}</option>
                    @endforeach
                </select>
            </div>
            <button class="boton chico" type="submit">Guardar</button>
        </form>

        <details>
            <summary style="cursor:pointer">{{ $categoria->subcategorias->count() }} subcategorías C2</summary>
            <div class="tabla-envoltura" style="margin-top:.6rem">
                <table>
                    <thead><tr><th>C2</th><th>Nombre y grupo</th><th>Uso</th></tr></thead>
                    <tbody>
                        @foreach ($categoria->subcategorias as $subcategoria)
                            <tr>
                                <td class="mono">{{ $subcategoria->id }}</td>
                                <td>
                                    <form method="post" action="{{ route('admin.subcategorias.actualizar', $subcategoria) }}" style="display:flex;gap:.4rem;flex-wrap:wrap">
                                        @csrf @method('put')
                                        <input type="text" name="nombre" value="{{ $subcategoria->nombre }}" required style="flex:1 1 200px">
                                        <select name="categoria_id" style="flex:0 1 200px">
                                            @foreach ($categorias as $opcion)
                                                <option value="{{ $opcion->id }}" @selected($opcion->id === $subcategoria->categoria_id)>{{ $opcion->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <button class="boton chico secundario" type="submit">Guardar</button>
                                    </form>
                                </td>
                                <td class="num">{{ $subcategoria->atomos_count }} átomos · {{ $subcategoria->eventos_count }} eventos</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>
    </fieldset>
@endforeach

<fieldset>
    <legend>Nueva subcategoría</legend>
    <form method="post" action="{{ route('admin.subcategorias.crear') }}" class="filtros" style="margin:0">
        @csrf
        <div class="campo"><label for="nueva-nombre">Nombre</label><input type="text" id="nueva-nombre" name="nombre" required></div>
        <div class="campo">
            <label for="nueva-categoria">Categoría</label>
            <select id="nueva-categoria" name="categoria_id">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button class="boton" type="submit">Crear</button>
    </form>
</fieldset>
@endsection
