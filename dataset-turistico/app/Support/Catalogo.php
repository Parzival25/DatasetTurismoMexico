<?php

namespace App\Support;

/**
 * Catálogo base del dataset: orígenes, clasificación C1 (7 grupos) y C2.
 *
 * Los identificadores de C2 del 1 al 123 son los del menú del Prototipo 1.
 * Los del 124 al 129 se unificaron aquí porque cada subproyecto los usaba con
 * significados distintos (ver equivalenciasLegado()).
 */
class Catalogo
{
    public static function origenes(): array
    {
        return [
            1 => ['slug' => 'chiapas', 'nombre' => 'Chiapas', 'descripcion' => 'Mapa turístico estatal: atractivos principales de todo el estado.'],
            2 => ['slug' => 'acacoyagua', 'nombre' => 'Acacoyagua', 'descripcion' => 'Municipio de la región Soconusco, en las faldas de la Sierra Madre.'],
            3 => ['slug' => 'mezcalapa', 'nombre' => 'Región Mezcalapa', 'descripcion' => 'Chicoasén, Coapilla, Copainalá, Ocozocoautla, Osumacinta, San Fernando y Tecpatán.'],
            4 => ['slug' => 'palenque', 'nombre' => 'Palenque', 'descripcion' => 'Municipio de la región Selva, puerta a la zona arqueológica maya.'],
            5 => ['slug' => 'san-cristobal', 'nombre' => 'San Cristóbal de las Casas', 'descripcion' => 'Pueblo mágico de los Altos de Chiapas.'],
            6 => ['slug' => 'yajalon', 'nombre' => 'Yajalón', 'descripcion' => 'Municipio de la región Tulijá Tseltal Chol.'],
            7 => ['slug' => 'tuxtla', 'nombre' => 'Tuxtla Gutiérrez', 'descripcion' => 'Capital del estado.'],
            8 => ['slug' => 'zoque-tsotsil', 'nombre' => 'Región Zoque Tsotsil', 'descripcion' => 'Municipios de las regiones zoque y tsotsil del norte de Chiapas.'],
        ];
    }

    public static function categorias(): array
    {
        return [
            1 => ['slug' => 'esparcimiento', 'nombre' => 'Esparcimiento', 'color' => '#D98A1F', 'icono' => 'sol',
                'descripcion' => 'Lugares para descansar, pasear y convivir.'],
            2 => ['slug' => 'deportivas', 'nombre' => 'Deportivas', 'color' => '#C8423B', 'icono' => 'deporte',
                'descripcion' => 'Actividades deportivas y de aventura.'],
            3 => ['slug' => 'ambiente-natural', 'nombre' => 'Ambiente natural', 'color' => '#2E7D4F', 'icono' => 'hoja',
                'descripcion' => 'Cascadas, ríos, montañas, selva y otros atractivos naturales.'],
            4 => ['slug' => 'historico-cultural', 'nombre' => 'Patrimonio histórico cultural', 'color' => '#7B4B94', 'icono' => 'columna',
                'descripcion' => 'Zonas arqueológicas, museos, iglesias, artesanía y gastronomía.'],
            5 => ['slug' => 'produccion', 'nombre' => 'Actividades vinculadas a la producción', 'color' => '#8A6A3B', 'icono' => 'engrane',
                'descripcion' => 'Agroturismo, industria, presas y puertos.'],
            6 => ['slug' => 'eventos', 'nombre' => 'Eventos programados', 'color' => '#1F6FA8', 'icono' => 'calendario',
                'descripcion' => 'Ferias, festivales, congresos y fiestas populares.'],
            7 => ['slug' => 'infraestructura', 'nombre' => 'Infraestructura y servicios', 'color' => '#56626B', 'icono' => 'info',
                'descripcion' => 'Servicios útiles para el visitante: transporte, salud, bancos, mercados.'],
        ];
    }

    /**
     * @return array<int, array{0: int, 1: string}> id => [categoria_id, nombre]
     */
    public static function subcategorias(): array
    {
        return [
            1 => [1, 'Balneario'], 2 => [1, 'Baños / Nadar'], 3 => [1, 'Caminatas / Expediciones'],
            4 => [1, 'Cicloturismo'], 5 => [1, 'Circuitos / Expediciones'], 6 => [1, 'Fotografía'],
            7 => [1, 'Juegos'], 8 => [1, 'Observación de flora y fauna'], 9 => [1, 'Paseos a caballo'],
            10 => [1, 'Picnic'], 84 => [1, 'Recorrido en lancha'], 98 => [1, 'Parques públicos'],
            99 => [1, 'Plaza comercial'], 103 => [1, 'Zoológico'], 112 => [1, 'Miradores'],

            11 => [2, 'Ala delta'], 12 => [2, 'Alta montaña'], 13 => [2, 'Bicicleta de montaña'],
            14 => [2, 'Buceo'], 15 => [2, 'Cabalgata'], 16 => [2, 'Canoa'],
            17 => [2, 'Descenso en ríos / Rafting'], 18 => [2, 'Escalada libre'], 19 => [2, 'Escalamiento'],
            20 => [2, 'Esquí acuático'], 21 => [2, 'Fútbol'], 22 => [2, 'Globo aerostático'],
            23 => [2, 'Golf'], 24 => [2, 'Hidrotorneo'], 25 => [2, 'Kayak'],
            26 => [2, 'Montañismo / Hiking'], 27 => [2, 'Paracaidismo'], 28 => [2, 'Parasailing'],
            29 => [2, 'Pesca deportiva'], 30 => [2, 'Rapel'], 31 => [2, 'Remo'],
            32 => [2, 'Sandboard'], 33 => [2, 'Senderismo / Trekking'], 34 => [2, 'Esquí'],
            35 => [2, 'Snowboard'], 36 => [2, 'Surf'], 37 => [2, 'Tenis'],
            38 => [2, 'Tirolesa'], 39 => [2, 'Todo terreno / Raid 4x4'], 40 => [2, 'Vela'],
            41 => [2, 'Velero / Windsurf'], 124 => [2, 'Básquetbol'], 125 => [2, 'Voleibol'],

            42 => [3, 'Cascadas'], 43 => [3, 'Montañas y volcanes'], 44 => [3, 'Valles'],
            45 => [3, 'Oasis'], 46 => [3, 'Lagos y lagunas'], 47 => [3, 'Ríos y esteros'],
            48 => [3, 'Costas y playas'], 49 => [3, 'Selva'], 50 => [3, 'Bosque'],
            51 => [3, 'Desierto'], 52 => [3, 'Contemplación del paisaje'], 53 => [3, 'Observación de flora'],
            54 => [3, 'Observación de fauna'], 55 => [3, 'Termalismo'], 56 => [3, 'Turismo de aventura'],
            57 => [3, 'Visita a exposiciones'], 58 => [3, 'Zoológicos'], 59 => [3, 'Espeleología'],
            60 => [3, 'Ecoturismo'], 85 => [3, 'Cañones'], 88 => [3, 'Cenotes'],
            92 => [3, 'Centros ecoturísticos'],

            61 => [4, 'Zonas arqueológicas'], 62 => [4, 'Artesanía'], 63 => [4, 'Etnoturismo'],
            64 => [4, 'Gastronomía'], 65 => [4, 'Sitios históricos'], 83 => [4, 'Museos y centros culturales'],
            86 => [4, 'Iglesias'], 87 => [4, 'Monumentos'], 91 => [4, 'Ciudad colonial'],
            96 => [4, 'Ciudad de más de 50,000 habitantes'], 97 => [4, 'Ciudad rural sustentable'], 102 => [4, 'Teatros'],

            66 => [5, 'Agroturismo'], 67 => [5, 'Empresas forestales'], 68 => [5, 'Industria diversa'],
            69 => [5, 'Minería'], 89 => [5, 'Centro de convenciones'], 90 => [5, 'Fórum'],
            100 => [5, 'Presas hidroeléctricas'], 101 => [5, 'Puertos marítimos'],

            70 => [6, 'Congresos y seminarios'], 71 => [6, 'Eventos científicos'], 72 => [6, 'Eventos culturales'],
            73 => [6, 'Eventos deportivos'], 74 => [6, 'Eventos gastronómicos'], 75 => [6, 'Fiestas artesanales'],
            76 => [6, 'Ferias industriales'], 77 => [6, 'Festivales de cine'], 78 => [6, 'Festivales de música'],
            79 => [6, 'Festivales de rock'], 80 => [6, 'Festivales folclóricos'], 81 => [6, 'Manifestaciones religiosas'],
            82 => [6, 'Ópera y ballet'], 93 => [6, 'Ferias ganaderas'], 94 => [6, 'Vacaciones de primavera'],
            95 => [6, 'Fiesta popular'],

            104 => [7, 'Distribuidores viales'], 105 => [7, 'Hospitales'], 106 => [7, 'Gasolineras'],
            107 => [7, 'Parque central'], 108 => [7, 'Oficinas de gobierno'], 109 => [7, 'Parques deportivos'],
            110 => [7, 'Plaza de toros'], 111 => [7, 'Central camionera'], 113 => [7, 'Cruz Roja'],
            114 => [7, 'Bomberos'], 115 => [7, 'Policía'], 116 => [7, 'Bancos'],
            117 => [7, 'Casas de cambio'], 118 => [7, 'Oficinas de correos'], 119 => [7, 'Aeropuertos'],
            120 => [7, 'Taxis'], 121 => [7, 'Ferrocarril'], 122 => [7, 'Embarcadero'],
            123 => [7, 'Mercados'], 126 => [7, 'Hoteles'], 127 => [7, 'Auditorios'],
            128 => [7, 'Unidad deportiva / Estadio'], 129 => [7, 'Restaurantes'],
        ];
    }

    /**
     * Códigos C2 locales de cada subproyecto que no coinciden con el catálogo
     * estatal. origen => [codigo_legado => id_canonico].
     */
    public static function equivalenciasLegado(): array
    {
        return [
            2 => [124 => 126, 125 => 129],           // Acacoyagua: Hoteles, Restaurantes
            3 => [124 => 126, 125 => 129],           // Mezcalapa: Hoteles, Restaurantes
            4 => [124 => 124, 125 => 125],           // Palenque: auditorio con básquetbol y voleibol
            6 => [124 => 124, 125 => 125, 126 => 126, 127 => 127, 128 => 128, 129 => 129], // Yajalón
        ];
    }
}
