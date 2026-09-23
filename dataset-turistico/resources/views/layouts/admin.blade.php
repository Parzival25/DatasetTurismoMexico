<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('titulo') · Administración del dataset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dataset.css') }}">
    @stack('cabecera')
</head>
<body>
<div class="admin-cuerpo">
    <aside class="admin-lateral">
        <a class="marca" href="{{ route('admin.inicio') }}">
            @include('parciales.logo', ['tamano' => 30])
            <span>Dataset<small>Administración</small></span>
        </a>
        <nav aria-label="Administración">
            <a href="{{ route('admin.inicio') }}" @class(['activo' => request()->routeIs('admin.inicio')])>Resumen</a>
            <a href="{{ route('admin.atomos.index') }}" @class(['activo' => request()->routeIs('admin.atomos.*')])>Átomos</a>
            <a href="{{ route('admin.eventos.index') }}" @class(['activo' => request()->routeIs('admin.eventos.*')])>Eventos</a>
            <a href="{{ route('admin.categorias.index') }}" @class(['activo' => request()->routeIs('admin.categorias.*')])>Clasificación</a>
            <a href="{{ route('portal.inicio') }}" target="_blank">Ver portal ↗</a>
        </nav>
        <form method="post" action="{{ route('admin.salir') }}">
            @csrf
            <button class="boton chico secundario" type="submit" style="color:#cfe0d9">Salir ({{ auth()->user()->name }})</button>
        </form>
    </aside>

    <main class="admin-principal">
        @if (session('exito'))
            <div class="alerta exito" role="status">{{ session('exito') }}</div>
        @endif
        @if ($errors->any())
            <div class="alerta error" role="alert">
                <strong>Revisa el formulario:</strong>
                <ul style="margin:.3rem 0 0;padding-left:1.2rem">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('contenido')
    </main>
</div>
@stack('scripts')
</body>
</html>
