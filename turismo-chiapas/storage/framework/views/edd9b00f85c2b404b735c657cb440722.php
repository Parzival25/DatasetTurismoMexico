
<svg xmlns="http://www.w3.org/2000/svg" width="<?php echo e($tamano ?? 22); ?>" height="<?php echo e($tamano ?? 22); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
<?php switch($nombre ?? 'punto'):
    case ('sol'): ?>
        <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
        <?php break; ?>
    <?php case ('deporte'): ?>
        <circle cx="5.5" cy="17" r="3.5"/><circle cx="18.5" cy="17" r="3.5"/><path d="M15 6h2l1.5 11M5.5 17l4-7h6l-6.5 7"/><path d="M8 6h3"/>
        <?php break; ?>
    <?php case ('hoja'): ?>
        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.5 19 2c1 2 2 4.2 2 8 0 5.5-4.8 10-10 10z"/><path d="M2 21c0-3 1.9-5.4 5.1-6"/>
        <?php break; ?>
    <?php case ('columna'): ?>
        <path d="M3 21h18M5 21v-4h14v4M7 17v-4h10v4M9 13V9h6v4M11 9V5h2v4"/>
        <?php break; ?>
    <?php case ('engrane'): ?>
        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
        <?php break; ?>
    <?php case ('calendario'): ?>
        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M8 15h2M14 15h2"/>
        <?php break; ?>
    <?php case ('info'): ?>
        <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        <?php break; ?>
    <?php case ('pin'): ?>
        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
        <?php break; ?>
    <?php case ('ruta'): ?>
        <path d="M3 11l19-9-9 19-2-8-8-2z"/>
        <?php break; ?>
    <?php default: ?>
        <circle cx="12" cy="12" r="5"/>
<?php endswitch; ?>
</svg>
<?php /**PATH C:\Nuevo Proyecto turistico\turismo-chiapas\resources\views/parciales/icono.blade.php ENDPATH**/ ?>