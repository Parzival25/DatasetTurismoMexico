<?php $__env->startSection('titulo', 'Gastronomía de Chiapas'); ?>
<?php $__env->startSection('descripcion', 'Recetas tradicionales de las nueve regiones de Chiapas: Centro, Altos, Fronteriza, Frailesca, Norte, Selva, Sierra, Soconusco y Costa.'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Gastronomía</h1>
                <p>Un recetario por región, de la revista de gastronomía chiapaneca. Toca una imagen para verla completa.</p>
            </div>
        </div>
        <p>
            <?php $__currentLoopData = $regiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="chip" href="#<?php echo e($region->slug); ?>" style="font-size:.95rem;padding:.35rem .9rem"><?php echo e($region->nombre); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </p>

        <?php $__currentLoopData = $regiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="region-gastronomica" id="<?php echo e($region->slug); ?>" style="scroll-margin-top:5rem">
                <div class="intro">
                    <?php if($region->imagen): ?>
                        <button type="button" class="pagina-revista" data-galeria="<?php echo e($region->slug); ?>" data-src="<?php echo e(asset('img/gastronomia/'.$region->imagen)); ?>" data-alt="Región <?php echo e($region->nombre); ?>">
                            <img src="<?php echo e(asset('img/gastronomia/'.$region->imagen)); ?>" alt="Presentación de la región <?php echo e($region->nombre); ?>" loading="lazy">
                        </button>
                    <?php endif; ?>
                    <div>
                        <h2>Región <?php echo e($region->nombre); ?></h2>
                        <p style="color:var(--gris)"><?php echo e($region->platillos->count()); ?> recetas</p>
                        <div class="platillos">
                            <?php $__currentLoopData = $region->platillos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platillo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" class="platillo" data-galeria="<?php echo e($region->slug); ?>" data-src="<?php echo e(asset('img/gastronomia/'.$platillo->imagen)); ?>" data-alt="<?php echo e($platillo->nombre); ?>">
                                    <img src="<?php echo e(asset('img/gastronomia/'.$platillo->imagen)); ?>" alt="" loading="lazy">
                                    <span><?php echo e($platillo->nombre); ?></span>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/contenido/gastronomia.blade.php ENDPATH**/ ?>