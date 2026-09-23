// Panel de administración: confirmaciones y selector de coordenadas.
(function () {
  document.querySelectorAll('form[data-confirmar]').forEach(function (form) {
    form.addEventListener('submit', function (evento) {
      if (!window.confirm(form.dataset.confirmar)) {
        evento.preventDefault();
      }
    });
  });

  var contenedor = document.getElementById('selector-mapa');
  if (!contenedor || typeof L === 'undefined') {
    return;
  }

  var lat = document.getElementById('latitud');
  var lng = document.getElementById('longitud');
  var centroChiapas = [16.5, -92.5];
  var mapa = L.map(contenedor).setView(centroChiapas, 7);
  var marcador = null;

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(mapa);

  function colocar(latlng, centrar) {
    if (!marcador) {
      marcador = L.marker(latlng, { draggable: true }).addTo(mapa);
      marcador.on('dragend', function () { escribir(marcador.getLatLng()); });
    } else {
      marcador.setLatLng(latlng);
    }
    if (centrar) {
      mapa.setView(latlng, 14);
    }
  }

  function escribir(latlng) {
    lat.value = latlng.lat.toFixed(6);
    lng.value = latlng.lng.toFixed(6);
  }

  function leer() {
    var a = parseFloat(lat.value);
    var b = parseFloat(lng.value);
    return isNaN(a) || isNaN(b) ? null : L.latLng(a, b);
  }

  var inicial = leer();
  if (inicial) {
    colocar(inicial, true);
  }

  mapa.on('click', function (e) {
    colocar(e.latlng, false);
    escribir(e.latlng);
  });

  [lat, lng].forEach(function (campo) {
    campo.addEventListener('change', function () {
      var punto = leer();
      if (punto) {
        colocar(punto, true);
      }
    });
  });
})();
