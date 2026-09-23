<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('titulo')@yield('titulo') · @endif Turismo Chiapas</title>
    <meta name="description" content="@yield('descripcion', 'Descubre los atractivos turísticos de Chiapas: cascadas, zonas arqueológicas, pueblos, gastronomía y fiestas, con mapa interactivo y cómo llegar.')">
    <meta property="og:title" content="@yield('titulo', 'Turismo Chiapas')">
    <meta property="og:type" content="website">
    @hasSection('imagen')<meta property="og:image" content="@yield('imagen')">@endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/turismo.css') }}">
    <link rel="icon" href="data:image/svg+xml,{{ rawurlencode(view('parciales.logo', ['tamano' => 32])->render()) }}">
    @stack('cabecera')
</head>
<body>
    <a class="oculto-visual" href="#contenido">Saltar al contenido</a>
    <header class="encabezado">
        <div class="contenedor">
            <a class="marca" href="{{ route('inicio') }}">@include('parciales.logo', ['tamano' => 34]) Turismo Chiapas</a>
            <nav class="navegacion" aria-label="Principal">
                <a href="{{ route('mapa') }}" @class(['activo' => request()->routeIs('mapa')])>Mapa</a>
                <a href="{{ route('lugares.index') }}" @class(['activo' => request()->routeIs('lugares.*')])>Lugares</a>
                <a href="{{ route('regiones.index') }}" @class(['activo' => request()->routeIs('regiones.*')])>Regiones</a>
                <a href="{{ route('eventos.index') }}" @class(['activo' => request()->routeIs('eventos.*')])>Fiestas y ferias</a>
                <a href="{{ route('gastronomia') }}" @class(['activo' => request()->routeIs('gastronomia')])>Gastronomía</a>
                <a href="{{ route('chiapas') }}" @class(['activo' => request()->routeIs('chiapas')])>Chiapas</a>
            </nav>
        </div>
    </header>

    <main id="contenido">
        @yield('contenido')
    </main>

    @unless (request()->routeIs('mapa'))
        <footer class="pie">
            <div class="contenedor">
                <div>
                    <h3>Turismo Chiapas</h3>
                    <p>Lugares, fiestas y sabores de Chiapas, más allá de los destinos de siempre. La información proviene del
                        <a href="{{ config('turismo.dataset_portal') }}" target="_blank" rel="noopener">Conjunto de datos turísticos del Estado de Chiapas</a>
                        del Instituto Tecnológico de Tuxtla Gutiérrez.</p>
                </div>
                <div>
                    <h3>Explora</h3>
                    <ul>
                        <li><a href="{{ route('mapa') }}">Mapa interactivo</a></li>
                        <li><a href="{{ route('lugares.index') }}">Todos los lugares</a></li>
                        <li><a href="{{ route('regiones.index') }}">Regiones</a></li>
                        <li><a href="{{ route('eventos.index') }}">Fiestas y ferias</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Chiapas</h3>
                    <ul>
                        <li><a href="{{ route('chiapas') }}">Ficha técnica</a></li>
                        <li><a href="{{ route('gastronomia') }}">Gastronomía</a></li>
                        <li><a href="{{ route('acerca') }}">Acerca del sitio</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    @endunless

    @include('parciales.visor')
    <script src="{{ asset('js/sitio.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
