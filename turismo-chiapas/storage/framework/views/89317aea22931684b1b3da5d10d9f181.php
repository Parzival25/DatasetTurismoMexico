<?php $__env->startSection('titulo', $categoriaActual['nombre'] ?? 'Lugares'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <div>
                <h1 style="font-size:clamp(1.9rem,4vw,2.8rem);margin-bottom:.2rem"><?php echo e($categoriaActual['nombre'] ?? 'Lugares de Chiapas'); ?></h1>
                <p><?php echo e($categoriaActual['descripcion'] ?? 'Todos los atractivos turísticos del estado.'); ?></p>
            </div>
            <a class="boton selva chico" href="<?php echo e(route('mapa')); ?>"><?php echo $__env->make('parciales.icono', ['nombre' => 'pin', 'tamano' => 16], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> Ver en el mapa</a>
        </div>

        <form class="filtros" method="get" action="<?php echo e(route('lugares.index')); ?>">
            <label>Buscar
                <input type="search" name="q" value="<?php echo e($filtros['q'] ?? ''); ?>" placeholder="Nombre o lugar">
            </label>
            <label>Tipo de experiencia
                <select name="categoria" onchange="this.form.subcategoria && (this.form.subcategoria.value = ''); this.form.submit()">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($categoria['slug']); ?>" <?php if(($filtros['categoria'] ?? '') === $categoria['slug']): echo 'selected'; endif; ?>><?php echo e($categoria['nombre']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <?php if($categoriaActual): ?>
                <label>Atractivo
                    <select name="subcategoria">
                        <option value="">Todos</option>
                        <?php $__currentLoopData = $categoriaActual['subcategorias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($sub['total_atomos'] > 0): ?>
                                <option value="<?php echo e($sub['slug']); ?>" <?php if(($filtros['subcategoria'] ?? '') === $sub['slug']): echo 'selected'; endif; ?>><?php echo e($sub['nombre']); ?> (<?php echo e($sub['total_atomos']); ?>)</option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            <?php endif; ?>
            <label>Región
                <select name="region">
                    <option value="">Todas</option>
                    <?php $__currentLoopData = $regiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region['slug']); ?>" <?php if(($filtros['region'] ?? '') === $region['slug']): echo 'selected'; endif; ?>><?php echo e($region['nombre']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <button class="boton" type="submit">Filtrar</button>
            <?php if($filtros): ?>
                <a class="boton contorno chico" href="<?php echo e(route('lugares.index')); ?>">Quitar filtros</a>
            <?php endif; ?>
        </form>

        <?php if($filtroInvalido): ?>
            <div class="aviso">Ese filtro no existe. Prueba con otra categoría o región.</div>
        <?php endif; ?>

        <p style="color:var(--gris)"><?php echo e(number_format($lugares->total())); ?> <?php echo e($lugares->total() === 1 ? 'lugar' : 'lugares'); ?></p>

        <?php if($lugares->count()): ?>
            <div class="rejilla">
                <?php $__currentLoopData = $lugares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parciales.tarjeta-lugar', ['lugar' => $lugar], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php echo e($lugares->links()); ?>

        <?php else: ?>
            <div class="vacio">
                <p>No encontramos lugares con esos filtros.</p>
                <a class="boton selva" href="<?php echo e(route('lugares.index')); ?>">Ver todos los lugares</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/lugares/index.blade.php ENDPATH**/ ?>