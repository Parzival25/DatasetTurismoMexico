<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fuentes del importador
    |--------------------------------------------------------------------------
    |
    | El importador reconstruye la base a partir del DataSetA.xml publicado en
    | datasetturistico.mexmapa.com y de la carpeta del Prototipo 1
    | (turismo_chiapas), de donde se toman las fotos, los eventos y el
    | vocabulario para restaurar los acentos que se perdieron en el XML.
    |
    */

    'fuente_xml' => env('DATASET_FUENTE_XML', database_path('fuentes/DataSetA.xml')),

    'fuente_legado' => env('DATASET_FUENTE_LEGADO', base_path('../Dataset Prototipo 1/turismo_chiapas')),

    /*
    | Carpeta (relativa a fuente_legado) donde vive la ficha HTML de cada
    | átomo según su origen. La ficha es {carpeta}/{numero_original}.html.
    */
    'carpetas_origen' => [
        1 => 'atomos',
        2 => 'acacoyagua/app/atomos',
        3 => 'mezcalapa/app/atomos',
        4 => 'Palenque/app/atomos',
        5 => 'SanCristobal/app/atomos',
        6 => 'Yajalon/app/atomos',
        7 => 'Tuxtla/atomos',
        8 => 'Zoque/app/atomos',
    ],

    'eventos_sql' => 'respaldo sql/20130610/atomos_temporales.sql',
    'eventos_carpeta' => 'atomos_temporales',

    /*
    | Límites aproximados del estado de Chiapas para validar coordenadas.
    */
    'limites' => [
        'lat_min' => 14.4,
        'lat_max' => 18.0,
        'lng_min' => -94.4,
        'lng_max' => -90.3,
    ],

    'fotos' => [
        'ancho_maximo' => 1920,
        'ancho_miniatura' => 480,
        'calidad' => 82,
    ],

    'api' => [
        'por_pagina' => 24,
        'por_pagina_maximo' => 500,
    ],

];
