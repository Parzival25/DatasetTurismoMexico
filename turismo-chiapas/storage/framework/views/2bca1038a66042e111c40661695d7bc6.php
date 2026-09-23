<?php $__env->startSection('titulo', 'Ficha técnica de Chiapas'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="seccion">
    <div class="contenedor prosa">
        <h1 style="font-size:clamp(1.9rem,4vw,2.8rem)">Chiapas</h1>
        <p style="font-size:1.15rem">
            Chiapas se localiza al sureste de México; colinda al norte con Tabasco, al oeste con Veracruz y Oaxaca,
            al sur con el Océano Pacífico y al este con la República de Guatemala.
        </p>

        <div class="datos-ficha">
            <div><strong>74,415 km²</strong>de superficie: el octavo estado más grande del país (3.8 % del territorio nacional).</div>
            <div><strong>658.5 km</strong>de frontera sur, el 57.3 % de toda la frontera sur de México.</div>
            <div><strong>260 km</strong>de litoral sobre el Océano Pacífico.</div>
            <div><strong>12 pueblos</strong>originarios de los 62 reconocidos oficialmente en México.</div>
        </div>

        <h2>Ubicación</h2>
        <p>Al norte 17°59′, al sur 14°32′ de latitud norte; al este 90°22′, al oeste 94°14′ de longitud oeste.</p>

        <h2>Principales ciudades</h2>
        <p>Tuxtla Gutiérrez, San Cristóbal de Las Casas, Tapachula, Palenque, Comitán y Chiapa de Corzo.</p>

        <h2>Regiones fisiográficas</h2>
        <p>Llanura Costera del Pacífico, Sierra Madre de Chiapas, Depresión Central, Altiplano Central, Montañas del Norte, Montañas del Oriente y Llanura Costera del Golfo.</p>

        <h2>Pueblos originarios</h2>
        <p>Tseltal, Tsotsil, Ch’ol, Tojol-ab’al, Zoque, Chuj, Kanjobal, Mam, Jacalteco, Mochó, Cakchiquel y Lacandón o Maya Caribe.</p>

        <p style="margin-top:2rem">
            <a class="boton" href="<?php echo e(route('mapa')); ?>">Explorar el mapa</a>
            <a class="boton contorno" href="<?php echo e(route('gastronomia')); ?>" style="color:var(--selva)">Conocer su gastronomía</a>
        </p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sitio', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/contenido/chiapas.blade.php ENDPATH**/ ?>