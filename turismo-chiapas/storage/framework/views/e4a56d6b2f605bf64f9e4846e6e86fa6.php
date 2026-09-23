<?php $__env->startSection('titulo', $evento['nombre']); ?>
<?php $__env->startSection('descripcion', \Illuminate\Support\Str::limit($evento['descripcion'] ?? $evento['nombre'], 155)); ?>

<?php
    $proxima = $evento['proxima_fecha'] ? \Illuminate\Support\Carbon::parse($evento['proxima_fecha']) : null;
    $coordenadas = $evento['coordenadas'];
?>

<?php $__env->startSection('contenido'); ?>
<header class="ficha-portada" style="background:var(--selva)">
    <?php if(! empty($evento['portada'])): ?>
        <img src="<?php echo e($evento['portada']['url']); ?>" alt="">
    <?php endif; ?>
    <div class="contenedor">
        <div class="migas"><a href="<?php echo e(route('eventos.index')); ?>">Fiestas y ferias</a></div>
        <h1><?php echo e($evento['nombre']); ?></h1>
        <?php if($proxima): ?>
            <span class="chip" style="background:var(--cempasuchil);color:var(--tinta)"><?php echo e($proxima->translatedFormat('j \d\e F \d\e Y')); ?></span>
        <?php endif; ?>
    </div>
</header>

<section class="seccion">
    <div class="contenedor ficha">
        <div>
            <?php if($evento['descripcion']): ?>
                <div class="bloque">
                    <h2>La celebración</h2>
                    <p style="font-size:1.08rem"><?php echo e($evento['descripcion']); ?></p>
                </div>
            <?php endif; ?>

            <?php if($evento['actividades']): ?>
                <div class="bloque">
                    <h2>Qué verás</h2>
                    <ul class="actividades"><li><?php echo e($evento['actividades']); ?></li></ul>
                </div>
            <?php endif; ?>

            <?php if(count($evento['fotos']) > 1): ?>
                <div class="bloque">
                    <h2>Fotos</h2>
                    <div class="galeria">
                        <?php $__currentLoopData = $evento['fotos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-galeria="evento" data-src="<?php echo e($foto['url']); ?>" data-alt="<?php echo e($evento['nombre']); ?>, foto <?php echo e($loop->iteration); ?>">
                                <img src="<?php echo e($foto['miniatura']); ?>" alt="<?php echo e($evento['nombre']); ?>, foto <?php echo e($loop->iteration); ?>" loading="lazy">
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <aside>
            <div class="panel">
                <h3>Cuándo y dónde</h3>
                <?php if($proxima): ?>
                    <p><strong>Próxima fecha:</strong> <?php echo e($proxima->translatedFormat('l j \d\e F')); ?><?php if($evento['periodo']): ?> (<?php echo e($evento['periodo']); ?>)<?php endif; ?></p>
                <?php endif; ?>
                <?php if($evento['localizacion']): ?>
                    <p><strong>Lugar:</strong> <?php echo e($evento['localizacion']); ?></p>
                <?php endif; ?>
                <?php if($evento['como_llegar']): ?>
                    <p><?php echo e($evento['como_llegar']); ?></p>
                <?php endif; ?>
                <?php if($coordenadas): ?>
                    <a class="boton chico" href="https://www.google.com/maps/dir/?api=1&amp;destination=<?php echo e($coordenadas['latitud']); ?>,<?php echo e($coordenadas['longitud']); ?>" target="_blank" rel="noopener"><?php echo $__env->make('parciales.icono', ['nombre' => 'ruta', 'tamano' => 16], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> Cómo llegar</a>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/eventos/show.blade.php ENDPATH**/ ?>