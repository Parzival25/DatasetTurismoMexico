{{-- Gestión de fotos de un átomo o evento. Espera $modelo y $tipo ('atomo' | 'evento'). --}}
<fieldset>
    <legend>Fotos ({{ $modelo->fotos->count() }})</legend>

    @if ($modelo->fotos->isNotEmpty())
        <div class="fotos-admin" style="margin-bottom:1rem">
            @foreach ($modelo->fotos as $foto)
                <figure>
                    <a href="{{ $foto->url() }}" target="_blank" rel="noopener"><img src="{{ $foto->urlMiniatura() }}" alt="Foto {{ $loop->iteration }}" loading="lazy"></a>
                    <figcaption>
                        <form method="post" action="{{ route('admin.fotos.actualizar', $foto) }}" style="display:flex;gap:.3rem;align-items:center;flex-wrap:wrap">
                            @csrf @method('put')
                            <label class="mono" style="font-size:.8rem">#<input type="number" name="orden" value="{{ $foto->orden }}" min="0" max="999" aria-label="Orden"></label>
                            <input type="text" name="credito" value="{{ $foto->credito }}" placeholder="Crédito" aria-label="Crédito" style="flex:1 1 100%;padding:.3rem .4rem;font-size:.85rem">
                            <button class="boton chico secundario" type="submit">Guardar</button>
                        </form>
                        <form method="post" action="{{ route('admin.fotos.eliminar', $foto) }}" data-confirmar="¿Eliminar esta foto? No se puede deshacer.">
                            @csrf @method('delete')
                            <button class="boton chico peligro" type="submit">Eliminar</button>
                        </form>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @endif

    <form method="post" action="{{ route('admin.fotos.subir', [$tipo, $modelo->id]) }}" enctype="multipart/form-data" class="filtros" style="margin:0">
        @csrf
        <div class="campo">
            <label for="fotos">Agregar fotos</label>
            <input type="file" id="fotos" name="fotos[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple required>
            <span class="ayuda">JPG, PNG, WebP o GIF, hasta 12 MB cada una. Se reducen a 1920 px y se genera la miniatura.</span>
        </div>
        <div class="campo">
            <label for="credito">Crédito (opcional)</label>
            <input type="text" id="credito" name="credito" placeholder="Autor o fuente">
        </div>
        <button class="boton" type="submit">Subir</button>
    </form>
</fieldset>
