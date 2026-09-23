-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2013 a las 21:57:48
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `turismo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomos_temporales`
--
CREATE DATABASE IF NOT EXISTS turismo;
use turismo;
CREATE TABLE IF NOT EXISTS `atomos_temporales` (
  `AT_ID` int(11) NOT NULL,
  `AT_NOMBRE` varchar(100) NOT NULL,
  `AT_C1` varchar(100) NOT NULL,
  `AT_C2` varchar(100) NOT NULL,
  `AT_C3` varchar(100) NOT NULL,
  `AT_C4` varchar(100) NOT NULL,
  `AT_C5` varchar(100) NOT NULL,
  `AT_C6` varchar(100) NOT NULL,
  `AT_C7` varchar(100) NOT NULL,
  `AT_LATITUD` float NOT NULL,
  `AT_LONGITUD` float NOT NULL,
  `AT_FECHA` date NOT NULL,
  `AT_PERIODO` varchar(100) NOT NULL,
  `AT_DESCRIPCION` text NOT NULL,
  `AT_COMO_LLEGAR` text NOT NULL,
  `AT_ACTIVIDADES` text NOT NULL,
  `AT_FOTOS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `atomos_temporales`
--

INSERT INTO `atomos_temporales` (`AT_ID`, `AT_NOMBRE`, `AT_C1`, `AT_C2`, `AT_C3`, `AT_C4`, `AT_C5`, `AT_C6`, `AT_C7`, `AT_LATITUD`, `AT_LONGITUD`, `AT_FECHA`, `AT_PERIODO`, `AT_DESCRIPCION`, `AT_COMO_LLEGAR`, `AT_ACTIVIDADES`, `AT_FOTOS`) VALUES
(4, 'Carrera Panamericana', '6.', '73.', '', '', '', '', '', 16.7841, -93.1784, '2013-10-30', '', '', '', '', ''),
(5, 'Festival Internacional de las Culturas y las Artes de Rosario Castellanos', '6.', '72.', '', '', '', '', '', 16.2524, -92.1348, '2013-08-16', '', '', '', '', ''),
(6, 'Festival Cervantino Barroco', '6.', '72.', '', '', '', '', '', 16.746, -93.1324, '2013-10-31', '', '', '', '', ''),
(7, 'Festival Maya Zoque', '6.', '72.', '', '', '', '', '', 16.7536, -93.1161, '2013-11-15', '', '', '', '', ''),
(8, 'Festival de la Cultura y las Artes de Fray Matías de Córdova', '6.', '72.', '', '', '', '', '', 14.9104, -92.2635, '2013-11-25', '', '', '', '', ''),
(9, 'Semana Santa Puerto Arista', '6.', '94.', '', '', '', '', '', 15.9372, -93.8097, '2013-03-24', '', '', '', '', ''),
(10, 'Feria de San Sebastian', '6.', '81,95.', '', '', '', '', '', 16.7076, -93.0173, '2013-01-12', '', '', '', '', ''),
(11, 'Feria Internacional de Tapachula', '6.', '93.', '', '', '', '', '', 14.8899, -92.2765, '2013-03-01', '', '', '', '', ''),
(12, 'Feria de la Primavera y la Paz', '6.', '95.', '', '', '', '', '', 16.7371, -92.6375, '2013-03-31', '', '', '', '', ''),
(13, 'Feria de San Marcos', '6.', '81,95.', '', '', '', '', '', 16.7531, -93.1158, '2013-04-20', '', '', '', '', ''),
(14, 'Feria de San Cristóbal Mártir', '6.', '81,95.', '', '', '', '', '', 16.738, -92.6385, '2013-07-17', '', '', '', '', ''),
(16, 'Feria de la Virgen de Asunción', '6.', '81,95.', '', '', '', '', '', 16.7616, -93.3771, '2013-08-10', '', '', '', '', ''),
(17, 'Feria de San Roque', '6.', '81,95.', '', '', '', '', '', 16.7505, -93.1135, '2013-08-14', '', '', '', '', ''),
(19, 'Feria de San Francisco', '6.', '81,95.', '', '', '', '', '', 16.0915, -93.7519, '2013-09-24', '', '', '', '', ''),
(22, 'Feria de la Concepción', '6.', '95.', '', '', '', '', '', 14.8627, -92.4488, '2013-12-08', '', '', '', '', ''),
(33, 'Fiesta de Santa María Candelaria', '6.', '81.', '', '', '', '', '', 14.9398, -92.1689, '2014-02-02', '', '', '', '', ''),
(34, 'Virgen de la Candelaria', '6.', '81.', '', '', '', '', '', 17.1307, -93.1612, '2014-02-02', '', '', '', '', ''),
(35, 'La Candelaria', '6.', '81.', '', '', '', '', '', 16.6892, -93.7224, '2014-02-02', '', '', '', '', ''),
(41, 'Fiestas del Señor de Tila', '6.', '81.', '', '', '', '', '', 16.8839, -92.7132, '2013-03-17', '', '', '', '', ''),
(42, 'Fiesta del Señor de las Tres Caídas', '6.', '81.', '', '', '', '', '', 14.6807, -92.1507, '2013-02-17', '', '', '', '', ''),
(43, 'Fiesta del Señor de las Cinco Llagas', '6.', '81.', '', '', '', '', '', 14.9113, -92.2779, '2013-03-17', '', '', '', '', ''),
(45, 'Fiesta de San Pedro', '6.', '81.', '', '', '', '', '', 14.9387, -92.1692, '2013-04-22', '', '', '', '', ''),
(48, 'Fiesta de San Isidro Labrador', '6.', '81.', '', '', '', '', '', 16.7117, -92.4525, '2013-05-13', '', '', '', '', ''),
(25, 'Feria del Señor de Esquipulas', '6.', '81.', '', '', '', '', '', 16.2441, -93.2715, '2014-01-06', '', '', '', '', ''),
(32, 'Feria de San Caralampio', '6.', '81.', '', '', '', '', '', 16.2552, -92.1329, '2014-02-10', '', '', '', '', ''),
(49, 'Fiesta de la Santa Cruz', '6.', '81.', '', '', '', '', '', 16.6231, -93.0995, '2013-05-03', '', '', '', '', ''),
(51, 'Día del Padre Eterno', '6.', '81.', '', '', '', '', '', 16.1172, -92.0557, '2013-06-15', '', '', '', '', ''),
(53, 'Fiesta de San Antonio de Padua', '6.', '81.', '', '', '', '', '', 17.1407, -92.7148, '2013-06-11', '', '', '', '', ''),
(55, 'Corpus Christi', '6.', '81.', '', '', '', '', '', 16.6217, -93.1053, '2013-06-01', '', '', '', '', ''),
(58, 'Fiesta de la Virgen del Carmen', '6.', '81.', '', '', '', '', '', 16.7337, -92.6382, '2013-07-16', '', '', '', '', ''),
(60, 'Santo Domingo', '6.', '81.', '', '', '', '', '', 16.2423, -92.1308, '2013-08-01', '', '', '', '', ''),
(61, 'Fiesta de Santo Domingo de Guzmán', '6.', '81.', '', '', '', '', '', 17.5072, -91.9814, '2013-07-29', '', '', '', '', ''),
(62, 'Fiesta Patronal de San Jacinto', '6.', '81.', '', '', '', '', '', 16.8964, -92.0902, '2013-08-05', '', '', '', '', ''),
(65, 'Fiesta Patronal de Santo Domingo', '6.', '81.', '', '', '', '', '', 15.3228, -92.6575, '2013-08-20', '', '', '', '', ''),
(66, 'Fiesta Patronal de San Agustín', '6.', '81.', '', '', '', '', '', 14.9126, -92.2669, '2013-08-28', '', '', '', '', ''),
(67, 'Fiesta de San Bartolomé', '6.', '81.', '', '', '', '', '', 15.23, -92.4015, '2013-08-24', '', '', '', '', ''),
(69, 'Fiesta de la Virgen de la Merced', '6.', '81.', '', '', '', '', '', 16.5429, -92.4726, '2013-09-13', '', '', '', '', ''),
(23, 'Feria Chiapas', '6.', '95.', '', '', '', '', '', 16.7842, -93.1786, '0000-00-00', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
