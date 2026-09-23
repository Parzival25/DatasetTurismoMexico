-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-12-2021 a las 19:15:43
-- Versión del servidor: 5.6.51
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hgcrespo_turismo_sancristobal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomos`
--

CREATE TABLE `atomos` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(50) NOT NULL,
  `A_C1` varchar(100) NOT NULL,
  `A_C2` varchar(100) NOT NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `atomos`
--

INSERT INTO `atomos` (`A_ID`, `A_NOMBRE`, `A_C1`, `A_C2`, `A_LATITUD`, `A_LONGITUD`) VALUES
(1, 'Andador Eclesiástico  ', ' 1,4.  ', ' 3,6;62,64,83,102.   ', 16.7342, -92.6392),
(2, 'Andador Guadalupano', '1, 4. ', ' 3,6;62,64,83.', 16.7374, -92.637),
(3, 'Arco del Carmen', '1,4.', '6;87.', 16.734, -92.6382),
(4, 'Arcotete', '1,2,3,4.', '1,2,3,4,5,6,7,8,9,10;15, 21,30,33,37,38,39;43,47, 52,53,54,56,59,60;64.', 16.7459, -92.5765),
(5, 'Auditorio Facultad de Derecho', '1,4,5,6.', '6;65;89;70,72,78,80,82.', 16.7351, -92.6387),
(6, 'Auditorio Municipal Barón de Las Casas', '6.', '73.', 16.7311, -92.6397),
(7, 'Casa de las Artesanías', '4.', '62.', 16.7351, -92.6383),
(8, 'Casa de las sirenas', '1,4,7.', '6;65;124.', 16.7365, -92.6371),
(9, 'Centro Cultural del Carmen', '1,4,5,6.', '6;83;89;71,72,77,78,80,82.', 16.7342, -92.6382),
(10, 'Centro de Convenciones Casa Mazariegos', '1,5,6.', '6;89;70,71,72,74,75,76,7,78,79,80,82.', 16.7363, -92.6382),
(11, 'Centro de Convenciones El Carmen', '1,5,6.', '6;89;71,72,74,75,76,78,80,82.', 16.733, -92.6382),
(12, 'Centro de Textiles del Mundo Maya y Museo de los A', '1,4.', '6;62,65,83.', 16.7419, -92.6379),
(13, 'Cerrito de San Cristóbal', '1,3,4,6.', '6,7,98,112;52;86;95.', 16.7323, -92.648),
(14, 'Grutas de Rancho Nuevo', '1,2,3,4.', '2,3,4,6,7,8,9,10;15,21;43,52,53,54,56,59,60;62,64.', 16.6675, -92.565),
(15, 'Iglesia Catedral', '1,4,6.', '6;65,86;81.', 16.7376, -92.6381),
(16, 'Iglesia de Cuxtitali', '1,4,6.', '6;65,86;81.', 16.7432, -92.6205),
(17, 'Iglesia de Guadalupe', '1,4,6.', '6;65,86;81.', 16.7378, -92.6265),
(18, 'Iglesia de La Caridad', '1,4,6.', '6;65,86;81.', 16.7406, -92.6374),
(19, 'Iglesia de La Merced', '1,4,6.', '6;65,86;81.', 16.7363, -92.642),
(20, 'Iglesia de María Auxiliadora', '1,4,6.', '6;65,86;81.', 16.7097, -92.6318),
(21, 'Iglesia de Mexicanos', '1,4,6.', '6;65,86;81.', 16.7433, -92.639),
(22, 'Iglesia de San Antonio', '1,4,6.', '6;65,86;81.', 16.7319, -92.6424),
(23, 'Iglesia de San Cristóbal', '1,4,6.', '6;65,86;81.', 16.7346, -92.6368),
(24, 'Iglesia de San Diego', '1,4,6.', '6;65,86;81.', 16.7266, -92.6356),
(25, 'Iglesia de San Felipe', '1,4,6.', '6;65,86;81.', 16.7243, -92.673),
(26, 'Iglesia de San Francisco', '1,4,6.', '6;65,86;81.', 16.7346, -92.6371),
(27, 'Iglesia de Santa Lucia', '1,4,6.', '6;65,86;81.', 16.747, -92.6403),
(28, 'Iglesia de Santo Domingo', '1,4,6.', '6,65,86,81.', 16.7416, -92.6375),
(29, 'Iglesia del carmen', '1,4,6.', '6,65,86,81.', 16.7341, -92.6385),
(30, 'Iglesia del Cerrillo', '1,4,6.', '6;65,86;81.', 16.7412, -92.6356),
(31, 'Colegio “La enseñanza”', '1,4.', '3;65.', 16.7383, -92.6355),
(32, 'Iglesia San Nicolás', '1,4,6.', '6;65,86;81.', 16.7374, -92.637),
(33, 'Museo de la Medicina Maya', '1,4.', '6;83.', 16.7515, -92.6389),
(34, 'Museo de las Culturas Populares', '1,4.', '6;62,65,83.', 16.7372, -92.6407),
(35, 'Museo de Trajes Regionales', '1,4.', '6;62,65,83.', 16.7371, -92.6416),
(36, 'Museo del Ámbar', '1,4.', '6;62,65,83.', 16.736, -92.6422),
(37, 'Museo del Café', '1,4.', '6;83.', 16.7381, -92.6362),
(38, 'Museo del Jade', '1,4.', '6;62,83.', 16.7381, -92.6387),
(39, 'Museo del Kakaw, Chocolatería Cultural', '1,4.', '6;83.', 16.7385, -92.6395),
(40, 'Museo Na-Bolom', '4.', '61,65,83.', 16.7416, -92.6299),
(41, 'Palacio Municipal', '4,6.', '65,87;72,74,77,80,95.', 16.7363, -92.6354),
(42, 'Parque Central', '1,4,6,7.', '6;62,64,65,87;71,72,74,75,76,77,78,79,80,82;107.', 16.7335, -92.6384),
(43, 'Parque de los Arcos', '6.', '72,74,77,78,79,80,95.', 16.7437, -92.6154),
(44, 'Parque de los Humedales', '1,2,3,4.', '3,6,7,8,10,84;25;46,52,53,54,60;64.', 16.7098, -92.6168),
(45, 'Plaza de la Paz', '1,4,6.', '98;62,87;71,72,74,75,77,78,79,80,81,82.', 16.7376, -92.6386),
(46, 'Plazuela de Cuxtitali', '4,6.', '86;95.', 16.7432, -92.6208),
(47, 'Plazuela de Guadalupe', '1,4,6.', '6;86;72,74,78,80,95.', 16.7378, -92.6268),
(48, 'Plazuela de la Merced', '1,4,6.', '6;83,86;72,74,77,78,80,95.', 16.7361, -92.641),
(49, 'Plazuela de Mexicanos', '1,4,6.', '6;86;72,74,78,80,95.', 16.7432, -92.6391),
(50, 'Plazuela de San Antonio', '4,6.', '86;95.', 16.7318, -92.6426),
(51, 'Plazuela de San Diego', '4,6.', '86;95.', 16.7271, -92.6357),
(52, 'Plazuela de San Fransisco', '1,4,6.', '6;86;95.', 16.7346, -92.6368),
(53, 'Plazuela de Santo Domingo', '1,4.', '6,98;62,63,83,86,87.', 16.7416, -92.6377),
(54, 'Plazuela del Carmen', '1,4,6.', '6;65,86;95.', 16.7342, -92.6383),
(55, 'Plazuela del Cerrillo', '4,6.', '86;95.', 16.7412, -92.6357),
(56, 'Sala de Bellas Artes “Alberto Domínguez”', '1,4,6.', '6;65,83,102;70,71,72,77,78,79,80,82.', 16.7341, -92.6382),
(57, 'Teatro Daniel Zebadúa', '1,4,6.', '6;65,83,102;70,71,72,77,78,79,80,82.', 16.7386, -92.638),
(58, 'Teatro de la Ciudad Hnos. Domínguez', '1,4,6.', '6;65,83,102;70,71,72,77,78,79,80,82.', 16.7332, -92.6519),
(59, 'Convivencia Infantil', '1,3,4.', '3,5,6,7,98;53;87,102.', 16.7432, -92.6592),
(60, 'Museo de Historias y Curiosidades de San Cristóbal', '1,4.', '6;62,65,83.', 16.7364, -92.6419),
(61, 'Zoológico “San José Bocomtenelté”', '1,3.', '3,6,8,103;53,54,58.', 16.7243, -92.6987),
(62, 'Orquídeario Moxviquil', '1,3.', '6,8,98;52,53.', 16.7552, -92.6289),
(63, 'Grutas del Mamut', '1,2,3,4.', '1,2,3,4,5,6,7,8,9,10;15, 21,30,33,37,38,39;43,47, 52,53,54,56,59,60;64.', 16.7407, -92.5875),
(64, 'Casa Utrilla', '1,4.', '6;65.', 16.7406, -92.6369);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomos_temporales`
--

CREATE TABLE `atomos_temporales` (
  `AT_ID` int(11) NOT NULL,
  `AT_NOMBRE` varchar(50) NOT NULL,
  `AT_C1` varchar(100) NOT NULL,
  `AT_C2` varchar(100) NOT NULL,
  `AT_LONGITUD` float NOT NULL,
  `AT_LATITUD` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `atomos_temporales`
--

INSERT INTO `atomos_temporales` (`AT_ID`, `AT_NOMBRE`, `AT_C1`, `AT_C2`, `AT_LONGITUD`, `AT_LATITUD`) VALUES
(1, 'Exposición del Ámbar', '6.', '75.', -92.6381, 16.7365),
(2, 'Feria de Cuxtitali', '6.', '81,95.', -92.6205, 16.7432),
(3, 'Feria de Guadalupe', '6.', '81,95.', -92.6268, 16.738),
(4, 'Feria de La Merced', '6.', '81,95.', -92.642, 16.7357),
(5, 'Feria de La Primavera y de la Paz', '6.', '72,73,74,75,78,79,80,95.', -92.6427, 16.7241),
(6, 'Feria de María Auxiliadora', '6.', '81,95.', -92.6318, 16.7097),
(7, 'Feria de Mexicanos', '6.', '81,95.', -92.639, 16.7433),
(8, 'Feria de San Antonio', '6.', '81,95.', -92.6424, 16.7319),
(9, 'Feria de San Cristóbal', '6.', '81,95.', -92.6396, 16.7344),
(10, 'Feria de San Diego', '6.', '81.95.', -92.6356, 16.7265),
(11, 'Feria de San Felipe', '6.', '81,95.', -92.6724, 16.7241),
(12, 'Feria de San Francisco', '6.', '81,95.', -92.6368, 16.7346),
(13, 'Feria de Santa Lucia', '6.', '81,95.', -92.6419, 16.7454),
(14, 'Feria del Carmen', '6.', '81,95.', -92.6384, 16.7341),
(15, 'Feria del Cerrillo', '6.', '81,95.', -92.6356, 16.7412),
(16, 'Festival Internacional Cervantino Barroco', '6.', '72,77,78,79,80.', -92.6332, 16.7334);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infraestructura`
--

CREATE TABLE `infraestructura` (
  `IN_ID` int(11) NOT NULL,
  `IN_NOMBRE` varchar(100) NOT NULL,
  `IN_LATITUD` float NOT NULL,
  `IN_LONGITUD` float NOT NULL,
  `IN_C1` varchar(100) NOT NULL,
  `IN_C2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `infraestructura`
--

INSERT INTO `infraestructura` (`IN_ID`, `IN_NOMBRE`, `IN_LATITUD`, `IN_LONGITUD`, `IN_C1`, `IN_C2`) VALUES
(1, 'Banamex', 16.7356, -92.6371, '7.', '116.'),
(2, 'Bancomer', 16.7367, -92.6376, '7.', '116.'),
(3, 'Banorte', 16.738, -92.6385, '7.', '116.'),
(4, 'Bomberos', 16.726, -92.6408, '7.', '114.'),
(5, 'CEDEM', 16.7311, -92.6451, '7.', '109.'),
(6, 'Clínica de Campo', 16.732, -92.6545, '7.', '105.'),
(7, 'Clínica de la Mujer', 16.7339, -92.6494, '7.', '105.'),
(8, 'Correos de México', 16.7362, -92.6398, '7.', '118.'),
(9, 'Cruz Roja', 16.7272, -92.6409, '7.', '113.'),
(10, 'DIF Municipal', 16.7242, -92.6405, '7.', '108.'),
(11, 'Gasolinera Huitepec', 16.732, -92.6542, '7.', '106.'),
(12, 'Gasolinera Olín', 16.7299, -92.6597, '7.', '106.'),
(13, 'Hospital de Caridad', 16.737, -92.6325, '7.', '105.'),
(14, 'Hospital de las Culturas', 16.7233, -92.6517, '7.', '105.'),
(15, 'HSBC', 16.7367, -92.6386, '7.', '116.'),
(16, 'IMSS', 16.7349, -92.6485, '7.', '105.'),
(17, 'Café La Parola', 16.7346, -92.6382, '7.', '125.'),
(18, 'Mercado de Dulces y Artesanías', 16.7343, -92.6371, '7.', '123.'),
(19, 'Mercado José Castillo Tielemans', 16.7435, -92.6368, '7.', '123.'),
(20, 'Merposur', 16.7194, -92.637, '7.', '123.'),
(21, 'Instituto Nacional de Migración', 16.7325, -92.6535, '7.', '108.'),
(22, 'Ministerio Público', 16.724, -92.637, '7.', '108.'),
(23, 'Namandí', 16.7366, -92.6392, '7.', '125.'),
(24, 'Plaza de Toros La Coleta', 16.7243, -92.6404, '7.', '110.'),
(25, 'Policía Municipal', 16.7306, -92.6416, '7.', '115.'),
(26, 'Café Praga', 16.7363, -92.6381, '7.', '125.'),
(27, 'Restaurant Continental', 16.7362, -92.6424, '7.', '126.'),
(28, 'Santander', 16.7366, -92.6381, '7.', '116.'),
(29, 'Santé Café', 16.7364, -92.6388, '7.', '125.'),
(30, 'Scotiabank', 16.7369, -92.6388, '7.', '116.'),
(31, 'Secretaría de Turismo', 16.7373, -92.6381, '7.', '108.'),
(32, 'Telégrafos', 16.7382, -92.6388, '7.', '118.'),
(33, 'Terminal Autobuses AEXA', 16.7296, -92.6372, '7.', '111.'),
(34, 'Terminal de Transportes a Chamula', 16.7443, -92.6368, '7.', '111.'),
(35, 'Terminal de Transportes a Zinacantán', 16.7447, -92.6359, '7.', '111.'),
(36, 'Terminal OCC', 16.7298, -92.6371, '7.', '111.'),
(37, 'Restaurant Tuluc', 16.7358, -92.6371, '7.', '126.'),
(38, 'Unidad Administrativa', 16.7217, -92.6371, '7.', '108.'),
(39, 'Yik Café', 16.7391, -92.638, '7.', '125.'),
(40, 'Panteón Municipal', 16.727, -92.6536, '7.', '127.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
