<?php $__env->startSection('titulo', 'Regiones'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Regiones</h1>
                <p>Cada región reúne los lugares documentados por un proyecto de investigación local.</p>
            </div>
        </div>
        <div class="rejilla" style="grid-template-columns:repeat(auto-fill,minmax(300px,1fr))">
            <?php $__currentLoopData = $regiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="region-tarjeta" href="<?php echo e(route('regiones.show', $region['slug'])); ?>">
                    <?php if($region['portada']): ?>
                        <img src="<?php echo e($region['portada']['url']); ?>" alt="" loading="lazy">
                    <?php endif; ?>
                    <div>
                        <h3><?php echo e($region['nombre']); ?></h3>
                        <span><?php echo e($region['total_atomos']); ?> lugares</span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/regiones/index.blade.php ENDPATH**/ ?>