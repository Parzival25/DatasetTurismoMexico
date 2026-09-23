{{-- Casillas de subcategorías agrupadas por categoría. Espera $categorias y $seleccionadas (ids). --}}
@foreach ($categorias as $categoria)
    <details @if ($categoria->subcategorias->pluck('id')->intersect($seleccionadas)->isNotEmpty()) open @endif style="margin-bottom:.6rem">
        <summary style="cursor:pointer;font-weight:600">
            <span class="punto" style="display:inline-block;background:{{ $categoria->color }}"></span>
            {{ $categoria->nombre }}
            <span style="color:var(--gris);font-weight:400">({{ $categoria->subcategorias->pluck('id')->intersect($seleccionadas)->count() }})</span>
        </summary>
        <div class="casillas" style="padding:.5rem 0 .3rem 1.2rem">
            @foreach ($categoria->subcategorias as $subcategoria)
                <label>
                    <input type="checkbox" name="subcategorias[]" value="{{ $subcategoria->id }}" @checked(in_array($subcategoria->id, $seleccionadas))>
                    <span>{{ $subcategoria->nombre }} <span class="mono" style="color:var(--gris-claro)">{{ $subcategoria->id }}</span></span>
                </label>
            @endforeach
        </div>
    </details>
@endforeach
