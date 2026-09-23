@extends('layouts.portal')

@section('titulo', 'Documentación de la API')

@php
    $base = url('/api/v1');
    $id = $ejemplo?->id ?? 1;
    $slug = $ejemplo?->slug ?? 'agua-azul';
@endphp

@section('contenido')
<section class="seccion">
    <div class="contenedor doc">
        <nav aria-label="Contenido">
            <a href="#inicio">Introducción</a>
            <a href="#convenciones">Convenciones</a>
            <a href="#atomos">Listar átomos</a>
            <a href="#atomo">Un átomo</a>
            <a href="#cercanos">Lugares cercanos</a>
            <a href="#mapa">Mapa (GeoJSON)</a>
            <a href="#categorias">Categorías</a>
            <a href="#origenes">Orígenes</a>
            <a href="#eventos">Eventos</a>
            <a href="#fotos">Fotos</a>
            <a href="#descargas">Descargas</a>
            <a href="#errores">Errores</a>
            <a href="#ejemplos">Ejemplos de código</a>
            <a href="#catalogo">Catálogo C1 / C2</a>
        </nav>

        <div>
            <section id="inicio">
                <h1>API pública v1</h1>
                <p>La API es de <strong>solo lectura</strong>, no requiere registro y responde en JSON (UTF-8). Está pensada para sitios web, aplicaciones móviles, sistemas expertos o cualquier herramienta que necesite información turística de Chiapas.</p>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}</div>
                <p style="margin-top:.8rem">El índice devuelve la versión de los datos, totales y enlaces a todos los recursos.</p>
            </section>

            <section id="convenciones">
                <h2>Convenciones</h2>
                <ul>
                    <li>Los recursos se pueden pedir por <code>id</code> numérico o por <code>slug</code>: <code>/atomos/{{ $id }}</code> o <code>/atomos/{{ $slug }}</code>.</li>
                    <li>Los listados paginados responden con <code>datos</code>, <code>meta</code> (<code>pagina</code>, <code>por_pagina</code>, <code>total</code>, <code>paginas</code>) y <code>enlaces</code>. Usa <code>?pagina=2</code> y <code>?por_pagina=100</code> (máximo 500).</li>
                    <li>Por omisión solo se devuelven registros activos. Usa <code>activo=todos</code> para incluir los inactivos.</li>
                    <li>Las coordenadas están en grados decimales (WGS84). Las distancias, en kilómetros.</li>
                    <li>Las respuestas incluyen <code>ETag</code>: envía <code>If-None-Match</code> para recibir <code>304</code> si nada cambió. Se admiten peticiones desde cualquier origen (CORS). Límite: 240 peticiones por minuto por IP.</li>
                </ul>
            </section>

            <section id="atomos">
                <h2>Listar átomos</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/atomos</div>
                <div class="tabla-envoltura" style="margin-top:1rem">
                    <table>
                        <thead><tr><th>Parámetro</th><th>Ejemplo</th><th>Descripción</th></tr></thead>
                        <tbody>
                            <tr><td><code>q</code></td><td><code>cascada azul</code></td><td>Busca en nombre, localización y descripción, sin importar acentos ni mayúsculas.</td></tr>
                            <tr><td><code>categoria</code></td><td><code>3</code>, <code>ambiente-natural</code>, <code>1,3</code></td><td>Clasificación C1 (cualquiera de las indicadas).</td></tr>
                            <tr><td><code>subcategoria</code></td><td><code>42</code>, <code>cascadas</code></td><td>Clasificación C2 (cualquiera de las indicadas).</td></tr>
                            <tr><td><code>origen</code></td><td><code>5</code>, <code>san-cristobal</code></td><td>Proyecto del que proviene la información.</td></tr>
                            <tr><td><code>cerca</code> + <code>radio</code></td><td><code>16.75,-93.11</code> y <code>15</code></td><td>Átomos a menos de <code>radio</code> km (25 por omisión), ordenados por distancia. Agrega <code>distancia_km</code>.</td></tr>
                            <tr><td><code>bbox</code></td><td><code>-93.3,16.6,-92.9,16.9</code></td><td>Caja geográfica: <code>lng_min,lat_min,lng_max,lat_max</code>.</td></tr>
                            <tr><td><code>con_fotos</code></td><td><code>1</code></td><td>Solo átomos con al menos una foto.</td></tr>
                            <tr><td><code>orden</code></td><td><code>nombre</code>, <code>id</code>, <code>recientes</code></td><td>Orden del listado (se ignora si usas <code>cerca</code>).</td></tr>
                            <tr><td><code>incluir</code></td><td><code>completo</code></td><td>Agrega descripción, localización, cómo llegar, actividades y todas las fotos a cada elemento.</td></tr>
                            <tr><td><code>activo</code></td><td><code>1</code>, <code>0</code>, <code>todos</code></td><td>Filtra por estado.</td></tr>
                        </tbody>
                    </table>
                </div>
                <pre style="margin-top:1rem"><code>curl "{{ $base }}/atomos?subcategoria=cascadas&amp;con_fotos=1&amp;por_pagina=5"</code></pre>
            </section>

            <section id="atomo">
                <h2>Un átomo</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/atomos/{id|slug}</div>
                <p style="margin-top:.8rem">Devuelve el átomo completo. <a href="{{ route('api.atomos.show', $id) }}">Probar con #{{ $id }}</a>.</p>
@if ($json)
<pre><code>{{ $json }}</code></pre>
                @endif
            </section>

            <section id="cercanos">
                <h2>Lugares cercanos</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/atomos/{id|slug}/cercanos?limite=6&amp;radio=30</div>
                <p style="margin-top:.8rem">Los átomos activos más próximos, ordenados por distancia (<code>distancia_km</code>). <code>limite</code> máximo 50, <code>radio</code> máximo 500 km.</p>
            </section>

            <section id="mapa">
                <h2>Mapa (GeoJSON)</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/mapa</div>
                <p style="margin-top:.8rem">Todos los átomos con coordenadas como <code>FeatureCollection</code>, con propiedades ligeras (<code>nombre</code>, <code>slug</code>, <code>categorias</code>, <code>subcategorias</code>, <code>color</code>, <code>icono</code>, <code>miniatura</code>). Acepta los mismos filtros que <code>/atomos</code>. Ideal para dibujar marcadores en Leaflet o Mapbox.</p>
            </section>

            <section id="categorias">
                <h2>Categorías</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/categorias</div>
                <div class="endpoint" style="margin-top:.4rem"><span class="metodo">GET</span>{{ $base }}/categorias/{id|slug}</div>
                <p style="margin-top:.8rem">Las 7 categorías C1 con su color, icono sugerido, total de átomos activos y sus subcategorías C2 (con totales).</p>
            </section>

            <section id="origenes">
                <h2>Orígenes</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/origenes</div>
                <p style="margin-top:.8rem">Los proyectos (regiones o municipios) de los que proviene la información, con total de átomos, centro y límites geográficos para encuadrar un mapa.</p>
            </section>

            <section id="eventos">
                <h2>Eventos</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ $base }}/eventos?mes=1&amp;orden=proximos</div>
                <div class="endpoint" style="margin-top:.4rem"><span class="metodo">GET</span>{{ $base }}/eventos/{id|slug}</div>
                <p style="margin-top:.8rem">Ferias, festivales y fiestas (átomos temporales). Los eventos recurrentes incluyen <code>proxima_fecha</code>, calculada a partir del día y mes registrados. Filtros: <code>mes</code>, <code>q</code>; orden: <code>proximos</code>, <code>nombre</code>, <code>fecha</code>.</p>
            </section>

            <section id="fotos">
                <h2>Fotos</h2>
                <div class="endpoint"><span class="metodo">GET</span>{{ url('/fotos') }}/{id}</div>
                <div class="endpoint" style="margin-top:.4rem"><span class="metodo">GET</span>{{ url('/fotos') }}/{id}/miniatura</div>
                <p style="margin-top:.8rem">JPEG original (máximo 1920 px de ancho) y miniatura de 480 px. Las URL vienen listas en cada átomo y evento; se pueden usar directamente en <code>&lt;img&gt;</code>. Se cachean 7 días.</p>
            </section>

            <section id="descargas">
                <h2>Descargas del dataset completo</h2>
                <ul>
                    @foreach (\App\Exportacion\Exportador::ARCHIVOS as $archivo => $info)
                        <li><a href="{{ route('descargas', $archivo) }}"><code>{{ $archivo }}</code></a>: {{ $info['descripcion'] }}</li>
                    @endforeach
                </ul>
                <p>Agrega <code>?descargar=1</code> para forzar la descarga. También están disponibles en la raíz (<code>{{ url('/DataSetA.xml') }}</code>), como en el sitio original.</p>
            </section>

            <section id="errores">
                <h2>Errores</h2>
                <ul>
                    <li><code>404</code>: <code>{"mensaje": "Recurso no encontrado."}</code></li>
                    <li><code>422</code>: filtro inválido, con el detalle en <code>errors</code>. Ejemplo: <code>?categoria=inexistente</code>.</li>
                    <li><code>429</code>: se superó el límite de peticiones; espera un minuto.</li>
                </ul>
            </section>

            <section id="ejemplos">
                <h2>Ejemplos de código</h2>
                <h3>JavaScript</h3>
<pre><code>const respuesta = await fetch('{{ $base }}/atomos?categoria=ambiente-natural&amp;con_fotos=1');
const { datos, meta } = await respuesta.json();
datos.forEach(a =&gt; console.log(a.nombre, a.coordenadas, a.portada?.url));</code></pre>
                <h3>PHP (Laravel)</h3>
<pre><code>$atomo = Http::get('{{ $base }}/atomos/{{ $slug }}')-&gt;json('datos');
echo $atomo['nombre'].' tiene '.count($atomo['fotos']).' fotos';</code></pre>
                <h3>Python</h3>
<pre><code>import requests
cercanos = requests.get('{{ $base }}/atomos/{{ $id }}/cercanos', params={'limite': 5}).json()['datos']
for a in cercanos:
    print(a['nombre'], a['distancia_km'], 'km')</code></pre>
            </section>

            <section id="catalogo">
                <h2>Catálogo C1 / C2</h2>
                <p>Un átomo puede tener varias clasificaciones. La C1 agrupa por tipo de actividad y la C2 detalla el atractivo.</p>
                @foreach ($categorias as $categoria)
                    <h3 style="margin-top:1.2rem"><span class="punto" style="display:inline-block;background:{{ $categoria->color }}"></span> {{ $categoria->id }} · {{ $categoria->nombre }} <code>{{ $categoria->slug }}</code></h3>
                    <p style="font-size:.92rem">
                        @foreach ($categoria->subcategorias->sortBy('id') as $subcategoria)
                            <span class="chip" title="{{ $subcategoria->slug }}">{{ $subcategoria->id }} · {{ $subcategoria->nombre }}</span>
                        @endforeach
                    </p>
                @endforeach
                <h3 style="margin-top:1.2rem">Orígenes</h3>
                <p>
                    @foreach ($origenes as $origen)
                        <span class="chip">{{ $origen->id }} · {{ $origen->nombre }} <code>{{ $origen->slug }}</code></span>
                    @endforeach
                </p>
            </section>
        </div>
    </div>
</section>
@endsection
