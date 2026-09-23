<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (! empty(trim($__env->yieldContent('titulo')))): ?><?php echo $__env->yieldContent('titulo'); ?> · <?php endif; ?> Turismo Chiapas</title>
    <meta name="description" content="<?php echo $__env->yieldContent('descripcion', 'Descubre los atractivos turísticos de Chiapas: cascadas, zonas arqueológicas, pueblos, gastronomía y fiestas, con mapa interactivo y cómo llegar.'); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('titulo', 'Turismo Chiapas'); ?>">
    <meta property="og:type" content="website">
    <?php if (! empty(trim($__env->yieldContent('imagen')))): ?><meta property="og:image" content="<?php echo $__env->yieldContent('imagen'); ?>"><?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/turismo.css')); ?>">
    <link rel="icon" href="data:image/svg+xml,<?php echo e(rawurlencode(view('parciales.logo', ['tamano' => 32])->render())); ?>">
    <?php echo $__env->yieldPushContent('cabecera'); ?>
</head>
<body>
    <a class="oculto-visual" href="#contenido">Saltar al contenido</a>
    <header class="encabezado">
        <div class="contenedor">
            <a class="marca" href="<?php echo e(route('inicio')); ?>"><?php echo $__env->make('parciales.logo', ['tamano' => 34], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> Turismo Chiapas</a>
            <nav class="navegacion" aria-label="Principal">
                <a href="<?php echo e(route('mapa')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('mapa')]); ?>">Mapa</a>
                <a href="<?php echo e(route('lugares.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('lugares.*')]); ?>">Lugares</a>
                <a href="<?php echo e(route('regiones.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('regiones.*')]); ?>">Regiones</a>
                <a href="<?php echo e(route('eventos.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('eventos.*')]); ?>">Fiestas y ferias</a>
                <a href="<?php echo e(route('gastronomia')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('gastronomia')]); ?>">Gastronomía</a>
                <a href="<?php echo e(route('chiapas')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['activo' => request()->routeIs('chiapas')]); ?>">Chiapas</a>
            </nav>
        </div>
    </header>

    <main id="contenido">
        <?php echo $__env->yieldContent('contenido'); ?>
    </main>

    <?php if (! (request()->routeIs('mapa'))): ?>
        <footer class="pie">
            <div class="contenedor">
                <div>
                    <h3>Turismo Chiapas</h3>
                    <p>Lugares, fiestas y sabores de Chiapas, más allá de los destinos de siempre. La información proviene del
                        <a href="<?php echo e(config('turismo.dataset_portal')); ?>" target="_blank" rel="noopener">Conjunto de datos turísticos del Estado de Chiapas</a>
                        del Instituto Tecnológico de Tuxtla Gutiérrez.</p>
                </div>
                <div>
                    <h3>Explora</h3>
                    <ul>
                        <li><a href="<?php echo e(route('mapa')); ?>">Mapa interactivo</a></li>
                        <li><a href="<?php echo e(route('lugares.index')); ?>">Todos los lugares</a></li>
                        <li><a href="<?php echo e(route('regiones.index')); ?>">Regiones</a></li>
                        <li><a href="<?php echo e(route('eventos.index')); ?>">Fiestas y ferias</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Chiapas</h3>
                    <ul>
                        <li><a href="<?php echo e(route('chiapas')); ?>">Ficha técnica</a></li>
                        <li><a href="<?php echo e(route('gastronomia')); ?>">Gastronomía</a></li>
                        <li><a href="<?php echo e(route('acerca')); ?>">Acerca del sitio</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <?php echo $__env->make('parciales.visor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="<?php echo e(asset('js/sitio.js')); ?>" defer></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/layouts/sitio.blade.php ENDPATH**/ ?>