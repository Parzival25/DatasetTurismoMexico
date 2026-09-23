@extends('layouts.portal')

@section('titulo', 'Inicio')

@section('contenido')
<section class="portada">
    <div class="contenedor">
        <p class="etiqueta">Datos abiertos · versión {{ $version }}</p>
        <h1>Conjunto de datos turísticos<br>del Estado de Chiapas</h1>
        <p class="lead">
            Información de los <strong>átomos turísticos</strong> de Chiapas: lugares, ubicación exacta, descripción,
            cómo llegar, actividades y fotos. Pensado para que desarrolladores, promotores y sistemas expertos
            creen contenido de difusión de forma rápida, sin importar qué tan conocido sea el lugar.
        </p>
        <div class="acciones">
            <a class="boton claro" href="#descargas">Descargar el dataset</a>
            <a class="boton secundario" href="{{ route('portal.documentacion') }}">Usar la API</a>
            <a class="boton secundario" href="{{ route('portal.explorar') }}">Explorar los datos</a>
        </div>

        <div class="cifras">
            <div class="cifra"><strong>{{ number_format($totales['atomos']) }}</strong><span>átomos turísticos</span></div>
            <div class="cifra"><strong>{{ number_format($totales['fotos']) }}</strong><span>fotografías</span></div>
            <div class="cifra"><strong>{{ $totales['eventos'] }}</strong><span>ferias y festivales</span></div>
            <div class="cifra"><strong>{{ $totales['subcategorias'] }}</strong><span>tipos de atractivo</span></div>
            <div class="cifra"><strong>{{ $totales['origenes'] }}</strong><span>proyectos de origen</span></div>
        </div>
    </div>
</section>

<section class="seccion" id="descargas">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>Descargas</h2>
            <p>Última actualización: {{ $actualizado ? \Illuminate\Support\Carbon::parse($actualizado)->translatedFormat('j \d\e F \d\e Y, H:i') : '—' }}</p>
        </div>
        <div class="rejilla">
            @foreach ($descargas as $descarga)
                <article class="tarjeta descarga">
                    <span class="formato">{{ $descarga['archivo'] }}</span>
                    <p>{{ $descarga['descripcion'] }}</p>
                    <span class="peso">{{ number_format($descarga['bytes'] / 1024, 0) }} KB · UTF-8</span>
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                        <a class="boton chico" href="{{ $descarga['url'] }}?descargar=1">Descargar</a>
                        <a class="boton chico secundario" href="{{ $descarga['url'] }}" target="_blank" rel="noopener">Ver</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="seccion">
    <div class="contenedor rejilla-2">
        <div>
            <div class="seccion-titulo"><h2>API pública</h2></div>
            <p>Consulta los datos en tiempo real, sin registro. Todas las respuestas son JSON y cada átomo incluye las URL de sus fotos.</p>
            <pre><code>GET {{ route('api.atomos.index', ['categoria' => 'ambiente-natural', 'q' => 'cascada']) }}</code></pre>
            @if ($ejemplo)
<pre><code>{
  "id": {{ $ejemplo['id'] }},
  "slug": "{{ $ejemplo['slug'] }}",
  "nombre": "{{ $ejemplo['nombre'] }}",
  "coordenadas": { "latitud": {{ $ejemplo['coordenadas']['latitud'] ?? 'null' }}, "longitud": {{ $ejemplo['coordenadas']['longitud'] ?? 'null' }} },
  "categorias": [ {!! collect($ejemplo['categorias'])->map(fn ($c) => '"'.e($c['nombre']).'"')->implode(', ') !!} ],
  "portada": { "url": "{{ $ejemplo['portada']['url'] ?? '' }}" },
  …
}</code></pre>
            @endif
            <a class="boton" href="{{ route('portal.documentacion') }}">Ver la documentación</a>
        </div>
        <div>
            <div class="seccion-titulo"><h2>Clasificación</h2></div>
            <div class="tarjeta">
                @foreach ($categorias as $categoria)
                    <a class="categoria-fila" href="{{ route('portal.explorar', ['categoria' => $categoria->slug]) }}" style="text-decoration:none;color:inherit">
                        <span class="punto" style="background:{{ $categoria->color }}"></span>
                        <span>{{ $categoria->nombre }}</span>
                        <span class="total">{{ $categoria->atomos_count }}</span>
                    </a>
                @endforeach
            </div>
            <h3 style="margin-top:1.5rem">Proyectos de origen</h3>
            <p style="color:var(--gris)">
                @foreach ($origenes as $origen)
                    <a class="chip" href="{{ route('portal.explorar', ['origen' => $origen->slug]) }}">{{ $origen->nombre }} · {{ $origen->atomos_count }}</a>
                @endforeach
            </p>
        </div>
    </div>
</section>
@endsection
