<?php if($paginator->hasPages()): ?>
    <nav class="paginacion" aria-label="Paginación">
        <?php if($paginator->onFirstPage()): ?>
            <span class="deshabilitado">‹ Anterior</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">‹ Anterior</a>
        <?php endif; ?>

        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span class="deshabilitado"><?php echo e($element); ?></span>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="actual" aria-current="page"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">Siguiente ›</a>
        <?php else: ?>
            <span class="deshabilitado">Siguiente ›</span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/parciales/paginacion.blade.php ENDPATH**/ ?>