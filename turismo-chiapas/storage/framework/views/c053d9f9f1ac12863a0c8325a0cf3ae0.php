<?php $__env->startSection('titulo', 'Página no encontrada'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor vacio">
        <h1 style="font-size:2rem">No encontramos esa página</h1>
        <p>Puede que el lugar haya cambiado de nombre o ya no esté disponible.</p>
        <p><a class="boton selva" href="<?php echo e(route('lugares.index')); ?>">Ver todos los lugares</a> <a class="boton contorno" href="<?php echo e(route('mapa')); ?>" style="color:var(--selva)">Ir al mapa</a></p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/errors/404.blade.php ENDPATH**/ ?>