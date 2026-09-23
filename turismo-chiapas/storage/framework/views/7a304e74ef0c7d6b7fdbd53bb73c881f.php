<?php $__env->startSection('titulo', 'Mapa turístico'); ?>

<?php $__env->startPush('cabecera'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/leaflet/leaflet.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/markercluster/MarkerCluster.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/markercluster/MarkerCluster.Default.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="pagina-mapa">
    <aside id="panel-mapa">
        <button type="button" class="boton chico selva alternar-panel" id="alternar-panel" aria-expanded="true" aria-controls="contenido-panel">Filtros</button>
        <div class="contenido-panel" id="contenido-panel">
            <label class="oculto-visual" for="buscar-mapa">Buscar en el mapa</label>
            <input type="search" id="buscar-mapa" class="buscar" placeholder="Buscar por nombre…">
            <p class="resumen-mapa" id="resumen-mapa" aria-live="polite">Cargando lugares…</p>

            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="filtro-categoria">
                    <label>
                        <input type="checkbox" class="filtro-c1" value="<?php echo e($categoria['id']); ?>" checked>
                        <span class="punto" style="background:<?php echo e($categoria['color']); ?>"></span>
                        <?php echo e($categoria['nombre']); ?>

                        <span class="total"><?php echo e($categoria['total_atomos']); ?></span>
                    </label>
                    <?php ($subs = collect($categoria['subcategorias'])->where('total_atomos', '>', 0)); ?>
                    <?php if($subs->isNotEmpty()): ?>
                        <details>
                            <summary>Elegir atractivos</summary>
                            <div class="subs">
                                <?php $__currentLoopData = $subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label><input type="checkbox" class="filtro-c2" data-c1="<?php echo e($categoria['id']); ?>" value="<?php echo e($sub['id']); ?>"> <?php echo e($sub['nombre']); ?> (<?php echo e($sub['total_atomos']); ?>)</label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </details>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <p style="margin-top:1rem"><button type="button" class="boton chico contorno" id="limpiar-mapa">Mostrar todo</button></p>
        </div>
    </aside>

    <div id="mapa"
         data-datos="<?php echo e(route('datos.mapa')); ?>"
         data-ficha="<?php echo e(route('lugares.show', '__slug__')); ?>"
         data-centro="<?php echo e(json_encode(config('turismo.mapa.centro'))); ?>"
         data-zoom="<?php echo e(config('turismo.mapa.zoom')); ?>"
         data-teselas="<?php echo e(config('turismo.mapa.teselas')); ?>"
         data-atribucion="<?php echo e(config('turismo.mapa.atribucion')); ?>"></div>
</div>

<template id="iconos-categorias">
    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span data-icono="<?php echo e($categoria['icono']); ?>"><?php echo $__env->make('parciales.icono', ['nombre' => $categoria['icono'], 'tamano' => 18], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</template>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/leaflet/leaflet.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/markercluster/leaflet.markercluster.js')); ?>"></script>
    <script src="<?php echo e(asset('js/mapa.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/lugares/mapa.blade.php ENDPATH**/ ?>