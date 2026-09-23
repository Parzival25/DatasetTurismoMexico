// Mapa interactivo: carga el GeoJSON del dataset (a través de /datos/mapa),
// agrupa marcadores y filtra por categoría, subcategoría y nombre.
(function () {
  var el = document.getElementById('mapa');
  if (!el || typeof L === 'undefined') return;

  var mapa = L.map(el, { zoomControl: true }).setView(JSON.parse(el.dataset.centro), parseInt(el.dataset.zoom, 10));
  L.tileLayer(el.dataset.teselas, { maxZoom: 19, attribution: el.dataset.atribucion }).addTo(mapa);

  var grupo = L.markerClusterGroup({ showCoverageOnHover: false, maxClusterRadius: 45 });
  mapa.addLayer(grupo);

  var iconos = {};
  document.querySelectorAll('#iconos-categorias [data-icono]').forEach(function (span) {
    iconos[span.dataset.icono] = span.innerHTML;
  });

  var resumen = document.getElementById('resumen-mapa');
  var buscador = document.getElementById('buscar-mapa');
  var lugares = [];

  function normalizar(texto) {
    return (texto || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
  }

  function escapar(texto) {
    var div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
  }

  function crearMarcador(f) {
    var p = f.properties;
    var color = p.color || '#1c4a38';
    var icono = L.divIcon({
      className: '',
      html: '<div class="marcador" style="background:' + color + '">' + (iconos[p.icono] || '') + '</div>',
      iconSize: [34, 34],
      iconAnchor: [17, 34],
      popupAnchor: [0, -30]
    });
    var url = el.dataset.ficha.replace('__slug__', encodeURIComponent(p.slug));
    var html = '<div class="popup-lugar">'
      + (p.miniatura ? '<img src="' + p.miniatura + '" alt="" loading="lazy">' : '')
      + '<strong>' + escapar(p.nombre) + '</strong>'
      + '<a class="boton chico" href="' + url + '" style="color:#fff">Ver lugar</a></div>';
    var coords = f.geometry.coordinates;
    return L.marker([coords[1], coords[0]], { icon: icono, title: p.nombre }).bindPopup(html);
  }

  function seleccion(clase) {
    return Array.prototype.slice.call(document.querySelectorAll(clase + ':checked')).map(function (c) {
      return parseInt(c.value, 10);
    });
  }

  function filtrar() {
    var c1 = seleccion('.filtro-c1');
    var c2 = seleccion('.filtro-c2');
    var texto = normalizar(buscador.value.trim());

    var visibles = lugares.filter(function (l) {
      var p = l.feature.properties;
      if (texto && l.nombre.indexOf(texto) === -1) return false;
      if (c2.length) return p.subcategorias.some(function (s) { return c2.indexOf(s) !== -1; });
      return p.categorias.some(function (c) { return c1.indexOf(c) !== -1; });
    });

    grupo.clearLayers();
    grupo.addLayers(visibles.map(function (l) { return l.marcador; }));
    resumen.textContent = visibles.length === 1 ? '1 lugar en el mapa' : visibles.length + ' lugares en el mapa';
  }

  document.querySelectorAll('.filtro-c1, .filtro-c2').forEach(function (casilla) {
    casilla.addEventListener('change', function () {
      // Elegir un atractivo concreto marca también su categoría.
      if (casilla.classList.contains('filtro-c2') && casilla.checked) {
        var padre = document.querySelector('.filtro-c1[value="' + casilla.dataset.c1 + '"]');
        if (padre) padre.checked = true;
      }
      filtrar();
    });
  });

  var espera;
  buscador.addEventListener('input', function () {
    clearTimeout(espera);
    espera = setTimeout(filtrar, 150);
  });

  document.getElementById('limpiar-mapa').addEventListener('click', function () {
    document.querySelectorAll('.filtro-c1').forEach(function (c) { c.checked = true; });
    document.querySelectorAll('.filtro-c2').forEach(function (c) { c.checked = false; });
    buscador.value = '';
    filtrar();
    mapa.setView(JSON.parse(el.dataset.centro), parseInt(el.dataset.zoom, 10));
  });

  var alternar = document.getElementById('alternar-panel');
  alternar.addEventListener('click', function () {
    var panel = document.getElementById('panel-mapa');
    var plegado = panel.classList.toggle('plegado');
    alternar.setAttribute('aria-expanded', String(!plegado));
    setTimeout(function () { mapa.invalidateSize(); }, 50);
  });

  fetch(el.dataset.datos, { headers: { Accept: 'application/json' } })
    .then(function (r) {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(function (geojson) {
      lugares = geojson.features.map(function (f) {
        return { feature: f, nombre: normalizar(f.properties.nombre), marcador: crearMarcador(f) };
      });
      filtrar();
    })
    .catch(function () {
      resumen.textContent = 'No se pudieron cargar los lugares. Intenta de nuevo más tarde.';
    });
})();
