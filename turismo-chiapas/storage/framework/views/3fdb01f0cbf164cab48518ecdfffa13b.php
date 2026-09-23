
<?php ($proxima = ! empty($evento['proxima_fecha']) ? \Illuminate\Support\Carbon::parse($evento['proxima_fecha']) : null); ?>
<a class="evento" href="<?php echo e(route('eventos.show', $evento['slug'])); ?>">
    <div class="fecha-caja">
        <?php if($proxima): ?>
            <strong><?php echo e($proxima->day); ?></strong>
            <span><?php echo e($proxima->translatedFormat('M')); ?></span>
        <?php else: ?>
            <strong>—</strong>
        <?php endif; ?>
    </div>
    <div>
        <h3><?php echo e($evento['nombre']); ?></h3>
        <p><?php echo e(\Illuminate\Support\Str::limit($evento['extracto'] ?? '', 90)); ?></p>
    </div>
</a>
<?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/parciales/tarjeta-evento.blade.php ENDPATH**/ ?>