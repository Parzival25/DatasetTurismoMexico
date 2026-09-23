@extends('layouts.admin')

@section('titulo', 'Eventos')

@section('contenido')
<header>
    <h1>Eventos <span style="color:var(--gris);font-weight:400;font-size:1rem">({{ $eventos->count() }})</span></h1>
    <a class="boton" href="{{ route('admin.eventos.create') }}">+ Nuevo evento</a>
</header>

<div class="tabla-envoltura">
    <table>
        <thead><tr><th></th><th>Nombre</th><th>Fecha</th><th>Próxima</th><th>Estado</th><th>Fotos</th></tr></thead>
        <tbody>
            @forelse ($eventos as $evento)
                <tr>
                    <td>
                        @if ($foto = $evento->fotos->first())
                            <img class="miniatura" src="{{ $foto->urlMiniatura() }}" alt="" loading="lazy">
                        @else
                            <div class="miniatura"></div>
                        @endif
                    </td>
                    <td><a href="{{ route('admin.eventos.edit', $evento) }}"><strong>{{ $evento->nombre }}</strong></a></td>
                    <td class="num">{{ $evento->fecha?->translatedFormat('j \d\e F') ?? '—' }}</td>
                    <td class="num">{{ $evento->proximaFecha()?->translatedFormat('j M Y') ?? '—' }}</td>
                    <td><span @class(['chip', 'inactivo' => ! $evento->activo])>{{ $evento->activo ? 'activo' : 'inactivo' }}</span></td>
                    <td class="num">{{ $evento->fotos->count() }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay eventos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
