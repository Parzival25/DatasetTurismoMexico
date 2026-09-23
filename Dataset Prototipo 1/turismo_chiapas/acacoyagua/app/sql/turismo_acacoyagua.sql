create DATABASE turismo_acacoyagua;
use turismo_acacoyagua;
CREATE TABLE IF NOT EXISTS `atomos` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(100) NOT NULL,
  `A_C1` varchar(100)  NULL,
  `A_C2` varchar(100)  NULL,
  `A_C7` varchar(100)  NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL,
  `A_DESCRIPCION` text  NULL,
  `A_COMO_LLEGAR` text  NULL,
  `A_ACTIVIDADES` text  NULL,
  `A_FOTOS` text  NULL,
  `A_TIPO` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `atomos`
--
INSERT INTO atomos (A_ID, A_NOMBRE, A_C1, A_C2, A_C7, A_LATITUD, A_LONGITUD, A_DESCRIPCION, A_COMO_LLEGAR, A_ACTIVIDADES, A_FOTOS, A_TIPO) VALUES
(1, 'Aguas Termales de Ulapa', '3.', '55.', '', 15.397188,-92.808268, '', '', '', '','p'),
(2, 'Auto Hotel La Hacienda', '7.', '124.','media', 15.344772,-92.680367, '', '', '', '','p'),
(3, 'Casa de Descanso del Panteon Municipal', '4.', '87.', '', 15.333877,-92.68129, '', '', '', '','p'),
(4, 'Casa de La Cultura', '4.', '83.', '', 15.346622,-92.674939, '', '', '', '','p'),
(5, 'Cascadas Chicol', '1,3.', '1,2;42,47.', '', 15.382109,-92.647379, '', '', '', '','p'),
(6, 'Cascadas Salto de Agua', '1,3.', '1,2;42;47.', '', 15.377242,-92.630927, '', '', '', '','p'),
(7, 'Ceiba de la Colonia Hidalgo', '3.', '53.', '', 15.363247,-92.733368, '', '', '', '','p'),
(8, 'Cerro Ovando', '1,3.', '3,8,112;43,52,53,54.', '', 15.386414,-92.608639, '', '', '', '','p'),
(9, 'Cerro Tepalcatenco', '1,3.', '3,8,112;43,52,53,54.', '', 15.349645,-92.655991, '', '', '', '','p'),
(10, 'El Encuentro', '1,3.', '1,2;42,47.', '', 15.383423,-92.677662, '', '', '', '','p'),
(11, 'Feria del Coco', '6.', '72.', '',15.347258,-92.743378, '', '', '', '','t'),
(12, 'Feria Enomoto ', '6.', '72.', '',15.340618,-92.674981, '', '', '', '','t'),
(13, 'Feria San Marcos', '6.', '72,81.', '',15.340615,-92.675271, '', '', '', '','t'),
(14, 'Hotel Brisa', '7.', '124.', 'media', 15.342702,-92.677465, '', '', '', '','p'),
(15, 'Laguna Cantarrana', '3.', '46.', '', 15.35284,-92.739496, '', '', '', '','p'),
(16, 'Mercado Municipal ', '1,7.', '99;123.', '', 15.341765,-92.675622, '', '', '', '','p'),
(17, 'Nucleo II de la Reserva de la Biosfera el Triunfo', '3.', '49,52,53,54.', '', 15.478814,-92.657075, '', '', '', '','p'),
(19, 'Parque Central Enomoto', '1,4,7.', '98;87;107.', '', 15.340749,-92.67515, '', '', '', '','p'),
(20, 'Parque Hidalgo', '1.', '98.', '', 15.347408,-92.743716, '', '', '', '','p'),
(21, 'Parroquia Hidalgo', '4,6.', '86;81.', '', 15.350218,-92.740604, '', '', '', '','p'),
(22, 'Parroquia San Marcos', '4,6.', '86;81.', '', 15.33593,-92.674775, '', '', '', '','p'),
(23, 'Piedra La Huella', '4.', '87.', '', 15.373691,-92.743804, '', '', '', '','p'),
(24, 'Presidencia Municipal', '4,7.', '87; 108.', '', 15.340979,-92.674611, '', '', '', '','p'),
(25, 'Puente del Ferrocarril', '7.', '121.', '', 15.348594,-92.748015, '', '', '', '','p'),
(26, 'Restaurant Las Amazonas', '1,7.', '1;125.', 'media', 15.347546,-92.687891, '', '', '', '','p'),
(27, 'Restaurant Shirley', '7.', '125.', 'media', 15.340565,-92.678286, '', '', '', '','p'),
(29, 'Rio Cacaluta Puente de Hamaca', '1,3.', '1,2;47.', '', 15.376917,-92.698445, '', '', '', '','p'),
(30, 'Rio Madre Vieja El Salto', '1,3.', '1,2;47.', '',15.38252,-92.741634, '', '', '', '','p'),
(31, 'Rio Chaltete', '1,3.', '1,2;47.', '', 15.349135,-92.689763, '', '', '', '','p'),
(32, 'Unidad Deportiva de Acacoyagua', '1,2,6,7.', '7;21;73;109.', '', 15.33794,-92.679144, '', '', '', '','p'),
(33, 'Volcan Madre Vieja', '1,3.', '3,8,112;43,52,53,54.', '', 15.406051,-92.755265, '', '', '', '','p');

