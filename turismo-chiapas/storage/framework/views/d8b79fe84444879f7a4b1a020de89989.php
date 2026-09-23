<?php $__env->startSection('titulo', $region['nombre']); ?>
<?php $__env->startSection('descripcion', 'Lugares turísticos de '.$region['nombre'].', Chiapas: '.($region['descripcion'] ?? '')); ?>

<?php $__env->startPush('cabecera'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/leaflet/leaflet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php ($porCategoria = collect($lugares)->groupBy(fn ($l) => $l['categorias'][0]['id'] ?? 0)); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor">
        <div class="migas" style="color:var(--gris)"><a href="<?php echo e(route('regiones.index')); ?>">Regiones</a></div>
        <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem"><?php echo e($region['nombre']); ?></h1>
        <p style="color:var(--gris);max-width:60ch"><?php echo e($region['descripcion']); ?> · <?php echo e($region['total_atomos']); ?> lugares.</p>

        <?php if($region['limites']): ?>
            <div id="mapa-region" class="mapa-mini" style="height:380px;margin:1.5rem 0 2rem"
                 data-datos="<?php echo e(route('datos.mapa', ['region' => $region['slug']])); ?>"
                 data-ficha="<?php echo e(route('lugares.show', '__slug__')); ?>"
                 data-limites="<?php echo e(json_encode([[$region['limites']['lat_min'], $region['limites']['lng_min']], [$region['limites']['lat_max'], $region['limites']['lng_max']]])); ?>"></div>
        <?php endif; ?>

        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(! $porCategoria->has($categoria['id'])) continue; ?>
            <div style="margin-bottom:2.5rem">
                <h2 style="display:flex;align-items:center;gap:.6rem">
                    <span class="icono-circulo" style="display:inline-grid;place-items:center;width:40px;height:40px;border-radius:50%;background:<?php echo e($categoria['color']); ?>;color:#fff"><?php echo $__env->make('parciales.icono', ['nombre' => $categoria['icono'], 'tamano' => 20], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
                    <?php echo e($categoria['nombre']); ?>

                </h2>
                <div class="rejilla">
                    <?php $__currentLoopData = $porCategoria[$categoria['id']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('parciales.tarjeta-lugar', ['lugar' => $lugar], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php if($region['limites']): ?>
        <script src="<?php echo e(asset('vendor/leaflet/leaflet.js')); ?>"></script>
        <script>
            (function () {
                var el = document.getElementById('mapa-region');
                var mapa = L.map(el, { scrollWheelZoom: false });
                mapa.fitBounds(JSON.parse(el.dataset.limites), { padding: [30, 30], maxZoom: 14 });
                L.tileLayer(<?php echo json_encode(config('turismo.mapa.teselas'), 15, 512) ?>, { maxZoom: 19, attribution: <?php echo json_encode(config('turismo.mapa.atribucion'), 15, 512) ?> }).addTo(mapa);

                fetch(el.dataset.datos).then(function (r) { return r.json(); }).then(function (geojson) {
                    geojson.features.forEach(function (f) {
                        var p = f.properties;
                        var enlace = document.createElement('a');
                        enlace.href = el.dataset.ficha.replace('__slug__', encodeURIComponent(p.slug));
                        enlace.textContent = p.nombre;
                        L.circleMarker([f.geometry.coordinates[1], f.geometry.coordinates[0]], {
                            radius: 8, color: '#fff', weight: 2, fillColor: p.color || '#1c4a38', fillOpacity: 1
                        }).bindPopup(enlace).addTo(mapa);
                    });
                });
            })();
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/regiones/show.blade.php ENDPATH**/ ?>