-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-12-2021 a las 19:18:45
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
-- Base de datos: `hgcrespo_turismo_yajalon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomos2`
--

CREATE TABLE `atomos2` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(100) NOT NULL,
  `A_C1` varchar(100) NOT NULL,
  `A_C2` varchar(100) NOT NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL,
  `icono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `atomos2`
--

INSERT INTO `atomos2` (`A_ID`, `A_NOMBRE`, `A_C1`, `A_C2`, `A_LATITUD`, `A_LONGITUD`, `icono`) VALUES
(1, 'Pulpitillo', '1,3.', '1,10;47.', 17.1746, -92.3307, 1),
(2, 'Puente Hidalgo', '1,3.', '1,3,10;47.', 17.2269, -92.3494, 1),
(3, 'Lumilia Los Patos', '1,3.', '1,10;47.', 17.2113, -92.3763, 1),
(4, 'Rio Grande', '1,3.', '1;47.', 17.2651, -92.4172, 1),
(5, 'Cascada Joloniel', '1,3.', '2,3,6,10;42,46, 52.', 17.3594, -92.3178, 1),
(6, 'La Preciosa', '1,3.', '1;47.', 17.4187, -92.4014, 1),
(7, 'Nuevo Limar', '1,3.', '1;47.', 17.4132, -92.3975, 1),
(8, 'Parque de Limar', '1,4.', '98,86.', 17.4138, -92.4028, 1),
(9, 'Poza Azul', '1,3.', '1,10;47.', 17.5561, -92.3491, 1),
(10, 'Cuevas de Salto de Agua', '1.', '3,6,112.', 17.5559, -92.3492, 1),
(11, 'Xanil', '1,3.', '1,6,10,112;42,47,52.', 17.2156, -92.1053, 1),
(12, 'Cascadas de Agua Azul', '1,3,4.', '2,6,10;33,42,52,60;62.', 17.2591, -92.1145, 1),
(13, 'Agua Clara', '1,2,3.', '2,3,6,9,84;13,25,33;60.', 17.244, -92.04, 1),
(14, 'Campo Loma Bonita', '1,2,3,6.', '7,112;21,124;52;73.', 17.1715, -92.3246, 2),
(15, 'Balneario Loma Bonita', '1.', '1,6,10.', 17.1718, -92.3249, 1),
(16, 'Futbol Rapido', '1,2,6.', '7;21;73.', 17.1715, -92.3266, 2),
(17, 'Agua Fria', '1,3.', '1,3;47.', 17.1655, -92.322, 1),
(18, 'Unidad Deportiva', '1,2,6,7.', '1,6,10;21,124,125;73;109,128.', 17.1672, -92.3272, 3),
(19, 'Parque Infantil', '1.', '7,10,98.', 17.168, -92.3263, 1),
(20, 'Los Tibios', '1,3.', '1,6;47,52.', 17.1652, -92.3301, 1),
(21, 'Museo Clemencia Pérez Cruz', '4.', '83.', 17.1719, -92.3339, 1),
(22, 'Museo Sellschopp', '4.', '83.', 17.1739, -92.3338, 1),
(23, 'Auditorio Municipal', '2,6,7.', '124;73;127.', 17.1781, -92.3314, 3),
(24, 'Parroquia Santiago Apostol', '4.', '86.', 17.1741, -92.3336, 1),
(25, 'Parque Central', '6,7.', '72,80,95;107.', 17.174, -92.3341, 3),
(26, 'Fiesta Patronal de Santiago Apostol', '6.', '78,80,82,95.', 17.1783, -92.3383, 2),
(27, 'Fiesta en honor a la Virgen del Rosario', '6.', '78,81,95.', 17.1764, -92.3384, 2),
(28, 'Celebración de la Virgen de Guadalupe', '6.', '81,95.', 17.1742, -92.3338, 2),
(30, 'Hospital', '7.', '105.', 17.1714, -92.3364, 3),
(31, 'Centro de Salud', '7.', '105.', 17.1717, -92.3362, 3),
(32, 'Cueva Jolja', '1.', '3,6,112.', 17.2797, -92.3176, 1),
(33, 'Takiukum', '1,3.', '2,3,6;42,46,52.', 17.1721, -92.3014, 1),
(34, 'Manantial el Ocot', '1,3.', '1,3,6;46.', 17.1723, -92.2831, 1),
(35, 'Hospital General', '7.', '105.', 17.1774, -92.3398, 3),
(36, 'Ram-Mart', '7.', '126.', 17.1728, -92.3306, 3),
(37, 'Monte Libano', '7.', '126.', 17.1747, -92.3367, 3),
(38, 'Los Comelones', '7.', '129.', 17.1734, -92.3346, 3),
(39, 'Pizzeria Burguer World', '7.', '129.', 17.1734, -92.3346, 3),
(40, 'El Rincón del Sabor', '7.', '129.', 17.1754, -92.3345, 3),
(41, 'Barba Roja', '7.', '129.', 17.1729, -92.3338, 3),
(42, 'Campestre', '7.', '129.', 17.1769, -92.3323, 3),
(43, 'Presidencia Municipal', '7.', '108.', 17.1737, -92.3338, 3),
(44, 'Biblioteca Pública', '7.', '108.', 17.1754, -92.3345, 3),
(45, 'Ministerio Público', '7.', '108.', 17.1741, -92.3349, 3),
(46, 'Sitio de Taxis Central', '7.', '120.', 17.1738, -92.3345, 3),
(47, 'Sitio de Taxis Central 2', '7.', '120.', 17.1744, -92.3336, 3),
(48, 'Sitio de Taxis', '7.', '120.', 17.1745, -92.3351, 3),
(49, 'Mercado Público', '7.', '123.', 17.1735, -92.3353, 3),
(51, 'Banamex', '7.', '116.', 17.1736, -92.3351, 3),
(52, 'Bancomer', '7.', '116.', 17.1751, -92.3341, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `test` varchar(80) NOT NULL,
  `indice` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregunta`, `test`, `indice`) VALUES
(1, 'Te gusto la pagina?', 1),
(2, 'La información presentada te fue utili?', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id_respuesta` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `opcion` varchar(80) NOT NULL,
  `imagen` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id_respuesta`, `id_pregunta`, `opcion`, `imagen`) VALUES
(1, 1, 'SI', 'si.jpg'),
(1, 2, 'SI', 'si.jpg'),
(2, 1, 'NO', 'no.jpg'),
(2, 2, 'NO', 'no.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_usuarios`
--

CREATE TABLE `respuestas_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atomos2`
--
ALTER TABLE `atomos2`
  ADD PRIMARY KEY (`A_ID`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id_respuesta`,`id_pregunta`),
  ADD KEY `fk_respuestas_preguntas_idx` (`id_pregunta`);

--
-- Indices de la tabla `respuestas_usuarios`
--
ALTER TABLE `respuestas_usuarios`
  ADD PRIMARY KEY (`id_usuario`,`id_respuesta`,`id_pregunta`),
  ADD KEY `fk_usuarios_has_respuestas_respuestas1_idx` (`id_respuesta`,`id_pregunta`),
  ADD KEY `fk_usuarios_has_respuestas_usuarios1_idx` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `fk_respuestas_preguntas` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `respuestas_usuarios`
--
ALTER TABLE `respuestas_usuarios`
  ADD CONSTRAINT `fk_usuarios_has_respuestas_respuestas1` FOREIGN KEY (`id_respuesta`,`id_pregunta`) REFERENCES `respuestas` (`id_respuesta`, `id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_respuestas_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
