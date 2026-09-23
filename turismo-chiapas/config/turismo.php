<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API del Dataset Turístico de Chiapas
    |--------------------------------------------------------------------------
    |
    | Este sitio no tiene base de datos de lugares: todo lo consulta por HTTP al
    | sistema dataset-turistico. Las respuestas se guardan en caché; si la API
    | deja de responder, se sirve la última copia conocida.
    |
    */

    'api_url' => rtrim(env('DATASET_API_URL', 'http://127.0.0.1:8001/api/v1'), '/'),

    'timeout' => (int) env('DATASET_API_TIMEOUT', 8),

    'cache_minutos' => (int) env('DATASET_CACHE_MINUTOS', 10),

    'mapa' => [
        'centro' => [16.45, -92.45],
        'zoom' => 8,
        'teselas' => env('MAPA_TESELAS', 'https://tile.openstreetmap.org/{z}/{x}/{y}.png'),
        'atribucion' => '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    ],

    'dataset_portal' => env('DATASET_PORTAL_URL', 'http://127.0.0.1:8001'),

];
