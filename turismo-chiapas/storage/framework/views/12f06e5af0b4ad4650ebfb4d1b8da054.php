<?php $__env->startSection('titulo', 'Fiestas y ferias'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem">Fiestas y ferias</h1>
                <p>Festivales, ferias y celebraciones que se repiten cada año en Chiapas.</p>
            </div>
        </div>

        <?php if($proximo): ?>
            <div class="panel" style="margin-bottom:2rem;border-left:5px solid var(--atardecer)">
                <span class="etiqueta" style="color:var(--atardecer);font-weight:700;text-transform:uppercase;letter-spacing:.08em;font-size:.8rem">La próxima</span>
                <h2 style="margin:.2rem 0 .3rem"><a href="<?php echo e(route('eventos.show', $proximo['slug'])); ?>" style="color:inherit"><?php echo e($proximo['nombre']); ?></a></h2>
                <p style="margin:0;color:var(--gris)"><?php echo e(\Illuminate\Support\Carbon::parse($proximo['proxima_fecha'])->translatedFormat('l j \d\e F \d\e Y')); ?></p>
            </div>
        <?php endif; ?>

        <p style="color:var(--gris);font-size:.95rem">Las fechas son aproximadas y pueden variar cada año; confírmalas con los organizadores antes de viajar.</p>

        <?php $__currentLoopData = $porMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mes => $eventos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mes">
                <h2><?php echo e($mes); ?></h2>
                <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parciales.tarjeta-evento', ['evento' => $evento], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/eventos/index.blade.php ENDPATH**/ ?>