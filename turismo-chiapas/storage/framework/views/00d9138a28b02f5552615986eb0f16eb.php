<?php $__env->startSection('contenido'); ?>
<section class="portada">
    <div class="contenedor">
        <div>
            <span class="etiqueta">Chiapas, México</span>
            <h1>Más allá de los destinos de siempre</h1>
            <p class="lead">
                <?php echo e(number_format($totales['atomos'] ?? 0)); ?> lugares para descubrir: cascadas escondidas, zonas arqueológicas,
                pueblos, miradores, balnearios y las fiestas que los llenan de vida.
            </p>
            <form class="buscador" action="<?php echo e(route('lugares.index')); ?>" method="get" role="search">
                <label class="oculto-visual" for="buscar">Buscar un lugar</label>
                <input type="search" id="buscar" name="q" placeholder="Busca una cascada, un pueblo, un museo…">
                <button class="boton" type="submit">Buscar</button>
            </form>
            <p style="margin-top:1.2rem"><a class="boton contorno" href="<?php echo e(route('mapa')); ?>" style="color:#fff"><?php echo $__env->make('parciales.icono', ['nombre' => 'pin', 'tamano' => 18], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> Ver el mapa</a></p>
        </div>

        <?php if(count($mosaico)): ?>
            <div class="mosaico" aria-label="Lugares destacados">
                <?php $__currentLoopData = $mosaico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('lugares.show', $lugar['slug'])); ?>">
                        <img src="<?php echo e($loop->first ? $lugar['portada']['url'] : $lugar['portada']['miniatura']); ?>" alt="" loading="<?php echo e($loop->first ? 'eager' : 'lazy'); ?>">
                        <span><?php echo e($lugar['nombre']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>¿Qué quieres hacer?</h2>
            <p>Explora por tipo de experiencia</p>
        </div>
        <div class="categorias">
            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="categoria-tarjeta" href="<?php echo e(route('lugares.index', ['categoria' => $categoria['slug']])); ?>">
                    <span class="icono-circulo" style="background:<?php echo e($categoria['color']); ?>"><?php echo $__env->make('parciales.icono', ['nombre' => $categoria['icono']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
                    <strong><?php echo e($categoria['nombre']); ?></strong>
                    <small><?php echo e($categoria['total_atomos']); ?> lugares</small>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="seccion tenue">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>Lugares para conocer</h2>
            <a class="boton selva chico" href="<?php echo e(route('lugares.index')); ?>">Ver todos</a>
        </div>
        <div class="rejilla">
            <?php $__currentLoopData = $destacados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('parciales.tarjeta-lugar', ['lugar' => $lugar], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php if(count($eventos)): ?>
    <section class="seccion">
        <div class="contenedor">
            <div class="seccion-titulo">
                <h2>Próximas fiestas y ferias</h2>
                <a class="boton selva chico" href="<?php echo e(route('eventos.index')); ?>">Calendario completo</a>
            </div>
            <div class="rejilla" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr))">
                <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parciales.tarjeta-evento', ['evento' => $evento], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="seccion tenue">
    <div class="contenedor">
        <div class="seccion-titulo">
            <h2>Recorre Chiapas por región</h2>
            <a class="boton selva chico" href="<?php echo e(route('regiones.index')); ?>">Todas las regiones</a>
        </div>
        <p>
            <?php $__currentLoopData = $regiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="chip" href="<?php echo e(route('regiones.show', $region['slug'])); ?>" style="font-size:.95rem;padding:.35rem .9rem"><?php echo e($region['nombre']); ?> · <?php echo e($region['total_atomos']); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/inicio.blade.php ENDPATH**/ ?>