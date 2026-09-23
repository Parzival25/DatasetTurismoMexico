<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Inicio') · Dataset Turístico de Chiapas</title>
    <meta name="description" content="@yield('descripcion', 'Conjunto de datos abiertos de sitios turísticos del Estado de Chiapas: descargas en XML, JSON, CSV y GeoJSON, API pública y fotos.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dataset.css') }}">
    <link rel="icon" href="data:image/svg+xml,{{ rawurlencode(view('parciales.logo', ['tamano' => 32])->render()) }}">
    @stack('cabecera')
</head>
<body>
    <header class="encabezado">
        <div class="contenedor">
            <a class="marca" href="{{ route('portal.inicio') }}">
                @include('parciales.logo', ['tamano' => 34])
                <span>Dataset Turístico de Chiapas<small>Datos abiertos · ITTG</small></span>
            </a>
            <nav class="navegacion" aria-label="Principal">
                <a href="{{ route('portal.inicio') }}" @class(['activo' => request()->routeIs('portal.inicio')])>Inicio</a>
                <a href="{{ route('portal.explorar') }}" @class(['activo' => request()->routeIs('portal.explorar', 'portal.atomo')])>Explorar</a>
                <a href="{{ route('portal.documentacion') }}" @class(['activo' => request()->routeIs('portal.documentacion')])>API</a>
                <a href="{{ route('portal.acerca') }}" @class(['activo' => request()->routeIs('portal.acerca')])>Acerca de</a>
            </nav>
        </div>
    </header>

    <main>
        @if (session('aviso'))
            <div class="contenedor" style="padding-top:1rem"><div class="alerta aviso">{{ session('aviso') }}</div></div>
        @endif
        @yield('contenido')
    </main>

    <footer class="pie">
        <div class="contenedor">
            <span>Conjunto de datos turísticos del Estado de Chiapas · Instituto Tecnológico de Tuxtla Gutiérrez</span>
            <span><a href="{{ route('api.indice') }}">API v1</a> · <a href="{{ route('login') }}">Administración</a></span>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
