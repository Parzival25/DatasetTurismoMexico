// Visor de fotos: cualquier botón con data-galeria="grupo" y data-src="url" lo abre.
(function () {
  var visor = document.getElementById('visor');
  if (!visor) return;

  var imagen = visor.querySelector('img');
  var contador = visor.querySelector('.contador');
  var fotos = [];
  var actual = 0;
  var origen = null;

  function mostrar(indice) {
    actual = (indice + fotos.length) % fotos.length;
    imagen.src = fotos[actual].src;
    imagen.alt = fotos[actual].alt;
    contador.textContent = fotos.length > 1 ? (actual + 1) + ' / ' + fotos.length : '';
    visor.querySelector('.anterior').hidden = fotos.length < 2;
    visor.querySelector('.siguiente').hidden = fotos.length < 2;
  }

  function abrir(boton) {
    var grupo = boton.dataset.galeria;
    var botones = Array.prototype.slice.call(document.querySelectorAll('[data-galeria="' + grupo + '"]'));
    fotos = botones.map(function (b) { return { src: b.dataset.src, alt: b.dataset.alt || '' }; });
    origen = boton;
    visor.hidden = false;
    document.body.style.overflow = 'hidden';
    mostrar(botones.indexOf(boton));
    visor.querySelector('.cerrar').focus();
  }

  function cerrar() {
    visor.hidden = true;
    imagen.src = '';
    document.body.style.overflow = '';
    if (origen) origen.focus();
  }

  document.addEventListener('click', function (e) {
    var boton = e.target.closest('[data-galeria]');
    if (boton) { e.preventDefault(); abrir(boton); return; }

    var accion = e.target.closest('[data-visor]');
    if (accion) {
      var tipo = accion.dataset.visor;
      if (tipo === 'cerrar') cerrar();
      if (tipo === 'anterior') mostrar(actual - 1);
      if (tipo === 'siguiente') mostrar(actual + 1);
      return;
    }

    if (e.target === visor) cerrar();
  });

  document.addEventListener('keydown', function (e) {
    if (visor.hidden) return;
    if (e.key === 'Escape') cerrar();
    if (e.key === 'ArrowLeft') mostrar(actual - 1);
    if (e.key === 'ArrowRight') mostrar(actual + 1);
  });
})();
