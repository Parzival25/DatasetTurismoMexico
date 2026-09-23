<?php $__env->startSection('titulo', $lugar['nombre']); ?>
<?php $__env->startSection('descripcion', \Illuminate\Support\Str::limit($lugar['descripcion'] ?? $lugar['nombre'].' en Chiapas', 155)); ?>
<?php if(! empty($lugar['portada'])): ?>
    <?php $__env->startSection('imagen', $lugar['portada']['url']); ?>
<?php endif; ?>

<?php $__env->startPush('cabecera'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/leaflet/leaflet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php
    $coordenadas = $lugar['coordenadas'];
    $destino = $coordenadas ? $coordenadas['latitud'].','.$coordenadas['longitud'] : null;
?>

<?php $__env->startSection('contenido'); ?>
<header class="ficha-portada" style="background:<?php echo e($colorPrincipal); ?>">
    <?php if(! empty($lugar['portada'])): ?>
        <img src="<?php echo e($lugar['portada']['url']); ?>" alt="">
    <?php endif; ?>
    <div class="contenedor">
        <div class="migas">
            <a href="<?php echo e(route('lugares.index')); ?>">Lugares</a>
            <?php if($lugar['origen']): ?>
                / <a href="<?php echo e(route('regiones.show', $lugar['origen']['slug'])); ?>"><?php echo e($lugar['origen']['nombre']); ?></a>
            <?php endif; ?>
        </div>
        <h1><?php echo e($lugar['nombre']); ?></h1>
        <div>
            <?php $__currentLoopData = $lugar['categorias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="chip" href="<?php echo e(route('lugares.index', ['categoria' => $categoria['slug']])); ?>" style="background:<?php echo e($categoria['color']); ?>;color:#fff"><?php echo e($categoria['nombre']); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</header>

<section class="seccion">
    <div class="contenedor ficha">
        <div>
            <?php if($lugar['descripcion']): ?>
                <div class="bloque">
                    <h2>Sobre este lugar</h2>
                    <p style="font-size:1.08rem"><?php echo e($lugar['descripcion']); ?></p>
                </div>
            <?php endif; ?>

            <?php if(count($lugar['fotos']) > 1): ?>
                <div class="bloque">
                    <h2>Fotos</h2>
                    <div class="galeria">
                        <?php $__currentLoopData = $lugar['fotos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-galeria="lugar" data-src="<?php echo e($foto['url']); ?>" data-alt="<?php echo e($lugar['nombre']); ?>, foto <?php echo e($loop->iteration); ?>">
                                <img src="<?php echo e($foto['miniatura']); ?>" alt="<?php echo e($lugar['nombre']); ?>, foto <?php echo e($loop->iteration); ?>" loading="lazy">
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(count($lugar['actividades'])): ?>
                <div class="bloque">
                    <h2>Qué hacer</h2>
                    <ul class="actividades">
                        <?php $__currentLoopData = $lugar['actividades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($actividad); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(count($lugar['subcategorias'])): ?>
                <div class="bloque">
                    <h2>Ideal para</h2>
                    <?php $__currentLoopData = $lugar['subcategorias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="chip" href="<?php echo e(route('lugares.index', ['categoria' => collect($lugar['categorias'])->firstWhere('id', $sub['categoria_id'])['slug'] ?? null, 'subcategoria' => $sub['slug']])); ?>"><?php echo e($sub['nombre']); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <aside>
            <div class="panel">
                <h3>Cómo llegar</h3>
                <?php if($lugar['localizacion']): ?>
                    <p><strong>Ubicación:</strong> <?php echo e($lugar['localizacion']); ?></p>
                <?php endif; ?>
                <?php if($lugar['como_llegar']): ?>
                    <p><?php echo e($lugar['como_llegar']); ?></p>
                <?php endif; ?>
                <?php if($destino): ?>
                    <div id="mapa" class="mapa-mini" data-lat="<?php echo e($coordenadas['latitud']); ?>" data-lng="<?php echo e($coordenadas['longitud']); ?>" data-color="<?php echo e($colorPrincipal); ?>" style="margin-bottom:1rem"></div>
                    <div class="acciones">
                        <a class="boton chico" href="https://www.google.com/maps/dir/?api=1&amp;destination=<?php echo e($destino); ?>" target="_blank" rel="noopener"><?php echo $__env->make('parciales.icono', ['nombre' => 'ruta', 'tamano' => 16], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> Google Maps</a>
                        <a class="boton chico selva" href="https://waze.com/ul?ll=<?php echo e($destino); ?>&amp;navigate=yes" target="_blank" rel="noopener">Waze</a>
                    </div>
                <?php else: ?>
                    <p style="color:var(--gris)">Aún no tenemos la ubicación exacta de este lugar.</p>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</section>

<?php if(count($cercanos)): ?>
    <section class="seccion tenue">
        <div class="contenedor">
            <div class="seccion-titulo">
                <h2>Cerca de aquí</h2>
                <p>Aprovecha el viaje</p>
            </div>
            <div class="rejilla">
                <?php $__currentLoopData = $cercanos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cercano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parciales.tarjeta-lugar', ['lugar' => $cercano], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php if($destino): ?>
        <script src="<?php echo e(asset('vendor/leaflet/leaflet.js')); ?>"></script>
        <script>
            (function () {
                var el = document.getElementById('mapa');
                var punto = [parseFloat(el.dataset.lat), parseFloat(el.dataset.lng)];
                var mapa = L.map(el, { scrollWheelZoom: false }).setView(punto, 13);
                L.tileLayer(<?php echo json_encode(config('turismo.mapa.teselas'), 15, 512) ?>, { maxZoom: 19, attribution: <?php echo json_encode(config('turismo.mapa.atribucion'), 15, 512) ?> }).addTo(mapa);
                L.circleMarker(punto, { radius: 10, color: '#fff', weight: 3, fillColor: el.dataset.color, fillOpacity: 1 }).addTo(mapa);
            })();
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/lugares/show.blade.php ENDPATH**/ ?>