-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-12-2021 a las 19:20:29
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
-- Base de datos: `hgcrespo_turismo_zoquetsotsil`
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
(101, 'Cascadas Maravillas', '1,3.', '2,6,7,8,10;42.', 17.1131, -92.868),
(102, 'Cascadas San Martín', '1,3.', '2,6,7,8,10;42.', 17.0463, -92.855),
(103, 'Cerro el Calvario', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.0705, -92.8535),
(104, 'Cueva Rio Hondo|', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.1154, -92.8648),
(105, 'Dispensario', '1.', '6,10.', 17.0696, -92.8578),
(106, 'Ermita Guadalupe', '1,4.', '6,10;65,86.', 17.0691, -92.8534),
(107, 'Parque Jitotol', '1,6,7.', '6,98;72,78,80,81,95;98.', 17.0678, -92.8623),
(108, 'Parroquia San Juan', '1,4.', '6;65,86.', 17.0679, -92.8614),
(109, 'Rio Hondo', '1,3.', '2,6,7,8,10;47.', 17.1154, -92.8648),
(110, 'Sacramento', '1,3.', '2,6,7,8,10;47.', 17.1534, -92.9291),
(111, 'Siempre Verde', '1,2,3.', '3,6,7,8,10;15,21,38;50,53.', 17.1439, -92.8882),
(112, 'Tatasantos', '1,2.', '1,6,10;21.', 17.1534, -92.9291),
(201, '2 Arbolitos', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.2098, -92.8909),
(202, 'Cueva del León', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.1677, -92.8905),
(204, 'Grutas Soconusco', '1,2,3.', '3,6;30;43,52,56,59.', 17.2127, -92.8805),
(205, 'Iglesia San Pedro', '1,4.', '6;65,86.', 17.2118, -92.9535),
(207, 'La Caña', '1,3.', '2,6,7,8,10;47.', 17.1678, -92.9096),
(208, 'Mirador La Cumbre', '1,3.', '6,10,112;52.', 17.1733, -92.8803),
(209, 'Mirador Florida', '1,3.', '6,10,112;52.', 17.251, -92.9529),
(210, 'Monasterio', '1,3,4.', '6,112;52;129.', 17.1584, -92.9046),
(211, 'Parque Pueblo Nuevo', '1,6,7.', '6,98;72,78,80,81,95;98.', 17.1579, -92.8977),
(212, 'Parroquia San Dionisio', '1,4.', '6;65,86.', 17.1582, -92.8969),
(213, 'Reserva', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.1552, -92.9056),
(215, 'Rio San Felipe', '1,3.', '2,6,7,8,10;47.', 17.2026, -92.9674),
(216, 'Rivera Santa Rita', '1,3.', '2,6,7,8,10;47.', 17.1254, -92.7455),
(217, 'Universidad Linda Vista', '1,2,3,6.', '6,7,10;21;52;70,73,81.', 17.1679, -92.914),
(218, 'Yerbabuena', '1,2,3.', '6,7,10;21;52.', 17.1832, -92.9082),
(301, 'Cañada El Carrizal', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.1911, -92.9848),
(302, 'Capilla de la Santisima Trinidad', '1,4.', '6;65,86.', 17.2007, -93.0108),
(303, 'Cascada La Unión', '1,3.', '2,6,7,8,10;42.', 17.2117, -92.9931),
(304, 'Cerro El Gallo De Monte', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.1926, -93.0101),
(305, 'Cueva del Burro', '1,3.', '3,6,7,8,10;43,52,53,56.', 17.2052, -93.0384),
(307, 'Iglesia Señor de Esquipulas', '1,4.', '6;65,86.', 17.2042, -93.01),
(308, 'Mirador La Ventana', '1,3.', '6,10,112;52.', 17.1723, -93.0297),
(309, 'Mirador Pinabeto', '1,3.', '6,10,112;52.', 17.2163, -92.9639),
(310, 'Mirador San Antonio', '1,3.', '6,10,112;52.', 17.2022, -92.9627),
(311, 'Parque Rayón', '1,6,7.', '6,98;72,78,80,81,95;98.', 17.2008, -93.0115),
(312, 'Parroquia San Bartolomé', '1,4.', '6;65,86.', 17.2013, -93.0113),
(313, 'Selva Negra', '1,3.', '3,6,8;49,53,54,56.', 17.2142, -92.9607),
(401, 'Capilla de Guadalupe', '1,4.', '6,10;65,86.', 17.2562, -93.0162),
(402, 'Cascada El Chorro', '1,3.', '2,6,7,8,10;42.', 17.2374, -93.0056),
(403, 'Cascada El Sartén', '1,3.', '2,6,7,8,10;42.', 17.2575, -92.9784),
(405, 'Noviciado', '4.', '129.', 17.2551, -93.0198),
(406, 'Parque Tapilula', '1,6,7.', '6,98;72,78,80,81,95;98.', 17.2483, -93.0166),
(407, 'Parroquia San Bernardo Abad', '1,4.', '6;65,86.', 17.2482, -93.016),
(408, 'Puente El Salvador', '1,3.', '2,6,7,8,10;47.', 17.2681, -93.0258),
(409, 'Rio Jaconá', '1,3.', '2,6,7,8,10;47.', 17.2518, -93.0318),
(410, 'Río La Sangre', '1,3.', '2,6,7,8,10;47.', 17.2596, -92.9891);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomos_temporales`
--

CREATE TABLE `atomos_temporales` (
  `AT_ID` int(11) NOT NULL,
  `AT_NOMBRE` varchar(50) NOT NULL,
  `AT_C1` varchar(100) NOT NULL,
  `AT_C2` varchar(100) NOT NULL,
  `AT_LATITUD` float NOT NULL,
  `AT_LONGITUD` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `atomos_temporales`
--

INSERT INTO `atomos_temporales` (`AT_ID`, `AT_NOMBRE`, `AT_C1`, `AT_C2`, `AT_LATITUD`, `AT_LONGITUD`) VALUES
(1001, 'Feria de Jitotol', '6.', '72,73,78,80,81,95.', 17.0578, -92.8523),
(1002, 'Feria en honor a San Juan Bautista', '6.', '72,73,78,80,81,95.', 17.0658, -92.8583),
(1003, 'Carnaval de Jitotol', '6.', '72,95.', 17.065, -92.8613),
(2001, 'Feria en honor a la Virgen María', '6.', '72,73,78,80,81,95.', 17.1571, -92.8972),
(2002, 'Feria en honor a San Dionisio', '6.', '72,73,78,80,81,95.', 17.1568, -92.8971),
(2003, 'Carnaval de Pueblo Nuevo', '6.', '72,95.', 17.1574, -92.8969),
(2004, 'Torneo Decembrino', '6.', '73.', 17.1571, -92.8965),
(3001, 'Feria en honor al Señor de Esquipulas', '6.', '72,73,78,80,81,95.', 17.2001, -93.011),
(3002, 'Feria en honor a San Bartolomé', '6.', '72,73,78,80,81,95.', 17.2005, -93.0109),
(4001, 'Feria en honor a Santo Tomás', '6.', '72,73,78,80,81,95.', 17.2479, -93.0158),
(4002, 'Feria en honor a San Bernardo', '6.', '72,73,78,80,81,95.', 17.248, -93.0161);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infra`
--

CREATE TABLE `infra` (
  `IN_ID` int(11) NOT NULL,
  `IN_NOMBRE` varchar(100) NOT NULL,
  `IN_C1` varchar(100) NOT NULL,
  `IN_C2` varchar(100) NOT NULL,
  `IN_LATITUD` float NOT NULL,
  `IN_LONGITUD` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `infra`
--

INSERT INTO `infra` (`IN_ID`, `IN_NOMBRE`, `IN_C1`, `IN_C2`, `IN_LATITUD`, `IN_LONGITUD`) VALUES
(1, 'Gasolinera', '7.', '106.', 17.0527, -92.8571),
(2, 'Hospital', '7.', '105.', 17.1597, -92.8991),
(3, 'Farmacia', '7.', '124.', 17.1577, -92.897),
(4, 'Farmacia', '7.', '124.', 17.1589, -92.8989),
(5, 'Farmacia', '7.', '124.', 17.1597, -92.8984),
(6, 'Farmacia', '7.', '124.', 17.1592, -92.8965),
(7, 'Farmacia', '7.', '124.', 17.1609, -92.897),
(8, 'Auditorio', '7.', '131.', 17.1566, -92.8965),
(9, 'Policia Municipal', '7.', '115.', 17.1575, -92.897),
(10, 'SSyPC', '7.', '115.', 17.1601, -92.8947),
(11, 'DIF', '7.', '108.', 17.1574, -92.897),
(12, 'Banco Azteca', '7.', '116.', 17.1577, -92.8968),
(13, 'Estadio', '7.', '132.', 17.1605, -92.9037),
(15, 'Terminal de camiones', '7.', '111.', 17.1614, -92.8968),
(16, 'Terminal de camiones', '7.', '111.', 17.1611, -92.8963),
(17, 'Terminal de camiones', '7.', '111.', 17.1617, -92.8977),
(18, 'Hotel', '7.', '130.', 17.161, -92.8968),
(19, 'Hotel', '7.', '130.', 17.1598, -92.8972),
(20, 'Hotel', '7.', '130.', 17.1574, -92.897),
(21, 'Gasolinera', '7.', '106.', 17.2547, -93.0159),
(22, 'Terminal de camiones', '7.', '111.', 17.2531, -93.0167),
(23, 'Hotel', '7.', '130.', 17.2539, -93.0161),
(14, 'Bansefi', '7.', '116.', 17.1579, -92.8977);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
