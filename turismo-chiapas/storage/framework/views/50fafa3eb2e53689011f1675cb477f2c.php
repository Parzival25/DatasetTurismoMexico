
<?php ($categoria = $lugar['categorias'][0] ?? null); ?>
<article class="lugar">
    <div class="imagen">
        <?php if(! empty($lugar['portada'])): ?>
            <img src="<?php echo e($lugar['portada']['miniatura']); ?>" alt="" loading="lazy">
        <?php else: ?>
            <div class="sin-foto" style="background:<?php echo e($categoria['color'] ?? '#1c4a38'); ?>"><?php echo $__env->make('parciales.icono', ['nombre' => $categoria['icono'] ?? 'pin', 'tamano' => 64], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
        <?php endif; ?>
        <?php if(isset($lugar['distancia_km'])): ?>
            <span class="distancia"><?php echo e($lugar['distancia_km'] < 1 ? round($lugar['distancia_km'] * 1000).' m' : number_format($lugar['distancia_km'], 1).' km'); ?></span>
        <?php endif; ?>
    </div>
    <div class="cuerpo">
        <span class="region"><?php echo e($lugar['origen']['nombre'] ?? ''); ?></span>
        <h3><a href="<?php echo e(route('lugares.show', $lugar['slug'])); ?>"><?php echo e($lugar['nombre']); ?></a></h3>
        <?php if(! empty($lugar['extracto'])): ?>
            <p><?php echo e(\Illuminate\Support\Str::limit($lugar['extracto'], 110)); ?></p>
        <?php endif; ?>
        <div style="margin-top:auto;padding-top:.3rem">
            <?php $__currentLoopData = array_slice($lugar['categorias'], 0, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="chip" style="background:<?php echo e($c['color']); ?>1f;color:<?php echo e($c['color']); ?>"><?php echo e($c['nombre']); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</article>
<?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/parciales/tarjeta-lugar.blade.php ENDPATH**/ ?>