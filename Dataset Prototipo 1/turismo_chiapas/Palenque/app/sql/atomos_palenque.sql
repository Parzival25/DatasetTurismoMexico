/*drop database if exist turismo_palenque;*/
create database turismo_palenque;
use turismo_palenque;

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
-- -----------------------------------------------------
-- Table `turismo_palenque`.`menu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `menu` (
  `ID_MENU` INT NOT NULL ,
  `NOMBRE` VARCHAR(100) NOT NULL ,
  `ENLACE` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`ID_MENU`) )
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`ID_MENU`, `NOMBRE`, `ENLACE`) VALUES
(1, 'Inicio', 'http://localhost:8080/turismo_palenque/index.php'),
(3, 'Festividades', '#'),
(4, 'Categorías', '#'),
(5, 'Zona Arqueológica', 'http://localhost:8080/turismo_palenque/zona_arqueologica.html');

-- -----------------------------------------------------
-- Table `turismo_palenque`.`submenu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `submenu` (
  `ID_SUBMENU` INT NOT NULL ,
  `NOMBRE` VARCHAR(100) NOT NULL ,
  `ENLACE` VARCHAR(100) NOT NULL ,
   `FOTOS` varchar(100) NOT NULL,
  `menu_ID_MENU` INT NOT NULL ,
  PRIMARY KEY (`ID_SUBMENU`, `menu_ID_MENU`) ,
  INDEX `fk_submenu_menu` (`menu_ID_MENU` ASC) ,
  CONSTRAINT `fk_submenu_menu`
    FOREIGN KEY (`menu_ID_MENU` )
    REFERENCES `menu` (`ID_MENU` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `submenu` (`ID_SUBMENU`, `NOMBRE`, `ENLACE`, `FOTOS`, `menu_ID_MENU`) VALUES
(3, 'Bellezas Naturales',  '', 'bellezas_naturales.jpg', 4),
(4, 'Balnearios',  '', 'balnearios.jpg', 4),
(5, 'Museos',  '', 'museos.jpg', 4),
(6, 'Histórico - Cultural',  '', 'historico_cultural.jpg', 4),
(7, 'Andador Turístico',  '', 'andador_turistico.jpg', 4),
(8, 'Servicios',  '', 'servicios.jpg', 4);
--
-- Estructura de tabla para la tabla `servicios`
--
CREATE TABLE IF NOT EXISTS `servicios` (
  `ID_SERVICIOS` int(11) NULL,
  `NOMBRE` varchar(100) NULL,
   `FOTOS` varchar(100) NOT NULL,
  `submenu_ID_SUBMENU` INT NOT NULL ,
  `submenu_menu_ID_MENU` INT NOT NULL ,
  PRIMARY KEY (`ID_SERVICIOS`) ,
  INDEX `fk_servicios_submenu1` (`submenu_ID_SUBMENU` ASC, `submenu_menu_ID_MENU` ASC) ,
  CONSTRAINT `fk_servicios_submenu1`
    FOREIGN KEY (`submenu_ID_SUBMENU` , `submenu_menu_ID_MENU` )
    REFERENCES `submenu` (`ID_SUBMENU` , `menu_ID_MENU` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

INSERT INTO `servicios` (`ID_SERVICIOS`, `NOMBRE`, `FOTOS`, `submenu_ID_SUBMENU`, `submenu_menu_ID_MENU`) VALUES
(1, 'Bancos','bancos.jpg', 8, 4),
(2, 'Transportes', 'transportes.jpg', 8, 4),
(3, 'Hospitales', 'hospitales.jpg', 8, 4),
(4, 'Centros Comerciales', 'centros_comerciales.jpg', 8, 4),
(5, 'Oficinas de gobierno', 'gobierno.jpg', 8, 4),
(6, 'Otros', 'otros.jpg', 8, 4);

-- Estructura de tabla para la tabla `atomos`
--

CREATE TABLE IF NOT EXISTS `atomos` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(100) NOT NULL,
  `A_C1` varchar(100) NOT NULL,
  `A_C2` varchar(100) NOT NULL,
  `A_C3` varchar(100) NOT NULL,
  `A_C4` varchar(100) NOT NULL,
  `A_C5` varchar(100) NOT NULL,
  `A_C6` varchar(100) NOT NULL,
  `A_C7` varchar(100) NOT NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL,
  `A_DESCRIPCION` text NOT NULL,
  `A_LOCALIZACIÓN` text NOT NULL,
  `A_COMO_LLEGAR` text NOT NULL,
  `A_ACTIVIDADES` text NOT NULL,
  `A_FOTOS` varchar(100) NOT NULL,
  `submenu_ID_SUBMENU` INT NOT NULL ,
  `submenu_menu_ID_MENU` INT NOT NULL ,
  PRIMARY KEY (`A_ID`, `submenu_ID_SUBMENU`, `submenu_menu_ID_MENU`) ,
  INDEX `fk_atomos_submenu1` (`submenu_ID_SUBMENU` ASC, `submenu_menu_ID_MENU` ASC) ,
  CONSTRAINT `fk_atomos_submenu1`
    FOREIGN KEY (`submenu_ID_SUBMENU` , `submenu_menu_ID_MENU` )
    REFERENCES `submenu` (`ID_SUBMENU` , `menu_ID_MENU` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `atomos` (`A_ID`, `A_NOMBRE`, `A_C1`, `A_C2`, `A_C3`, `A_C4`, `A_C5`, `A_C6`, `A_C7`, `A_LATITUD`, `A_LONGITUD`, `A_DESCRIPCION`, `A_LOCALIZACIÓN`,`A_COMO_LLEGAR`, `A_ACTIVIDADES`, `A_FOTOS`, `submenu_ID_SUBMENU`, `submenu_menu_ID_MENU`) VALUES
(2, 'Albercas Naturales De Montebello', '1,3.', '1,2;53,54,47.', '1,2,3.', '', '1,2,3.', '3.', '', 17.477415, -91.957591, '', '', '', '', 'albercas.jpg', 4, 4),
(3, 'Andador Ecológico', '1.', '3,6,8.', '1,2,3.', '', '1,2,3.', '3.', '', 17.487689, -92.048868, '', '', '', '', 'andador.jpg', 7, 4),
(9, 'Balneario Chacamax.', '1,3.', '1,2;47.', '1,2,3.', '', '1,2,3.', '3.', '', 17.496417, -91.954195, '', '', '', '', 'balneario.jpg', 4, 4),
(12, 'Casa De La Cultura.', '4.', '83.', '1,2.', '', '1,2,3,4.', '', '', 17.512502, -91.980399, '', '', '', '', 'casa.jpg', 6, 4),
(13, 'Cascada Agua Clara.', '1,2,3.', '2,3,9;13,25,33;60.', '1,2,3.', '', '1,2,3.', '2,3.', '', 17.25777778, -92.05250000, '', '', '', '', 'agua_clara.jpg', 3, 4),
(14, 'Cascada Agua Azul.', '1,2,3.', '2;33;42,52,60.', '1,2,3.', '', '1,2,3.', '2,3.', '', 17.259269, -92.114711, '', '', '', '', 'agua_azul.jpg', 3, 4),
(26, 'Iglesia Santo Domingo.', '4.', '86.', '1,2,3.', '', '1,2,3,4.', '', '', 17.508982, -91.980298, '', '', '', '', 'iglesia.jpg', 6, 4),
(30, 'Misol-Ha.', '1,3.', '1,2,8;42,53,54.', '1,2,3,4.', '', '1,2,3,4.', '3,4.', '', 17.392845, -92.00018, '', '', '', '', 'misol-ha.jpg', 3, 4),
(31, 'Monumento A La Madre Chol.', '4.', '87.', '1,2,3.', '', '1,2,3,4.', '', '', 17.504956, -91.992024, '', '', '', '', 'madre_chol.jpg', 6, 4),
(32, 'Monumento A La Cabeza Maya.', '4.', '87.', '1,2,3.', '1,2,3,4.', '', '', '', 17.508343, -91.989664, '', '', '', '', 'cabeza.jpg', 6, 4),
(34, 'Museo De Sitio.', '4.', '83,65.', '1,2,3.', '', '1,2,3,4.', '', '', 17.488467, -92.042066, '', '', '', '', 'museo.jpg', 5, 4),
(35, 'Museo Del Textil LAK PUJ KUL.', '4;5.', '62,83;68.', '1,2,3.', '', '1,2,3,4.', '', '', 17.508512, -91.981092, '', '', '', '', 'textil.jpg', 5, 4),
(36, 'Nututún.', '1;3.', '1,2;47.', '1,2,3.', '', '1,2,3,4.', '2,3,4.', '', 17.485438, -91.973433, '', '', '', '', 'nututun.jpg', 4, 4),
(39, 'Parque Central.', '1,6,7.', '98;72;107.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509085, -91.981135, '', '', '', '', 'parque.jpg', 6, 4),
(41, 'Plaza De Las Artesanías y Módulos De Información Turística.', '6.', '75.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509238, -91.982006, '', '', '', '', 'plaza.jpg', 6, 4),
(42, 'Plaza del Artesano.', '4;6.', '62;75.', '1,2,3.', '', '1,2,3,4.', '', '', 17.505524, -91.99195, '', '', '', '', 'artesano.jpg', 6, 4),
(53, 'Welib-Ha.', '1,2,3.', '1,2,8;38;42,48,53,54.', '1,2,3.', '', '1,2,3,4.', '3,4.', '', 17.374805, -91.799111, '', '', '', '', 'welib-ha.jpg', 3, 4),
(54, 'Zona Arqueológica.', '1;3;4.', '6,8;53,54;61.', '1,2,3.', '', '1,2,3,4.', '3,4.', '', 17.48337, -92.046186, '', '', '', '', 'zona.jpg', 3, 4),
(55, 'Zona Turística La Cañada.', '3.', '53,54.', '1,2,3.', '', '1,2,3,4.', '2,3.', '', 17.50888, -91.989358, '', '', '', '', 'turistica.jpg', 7, 4);


-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `atomos_servicios` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(100) NOT NULL,
  `A_C1` varchar(100) NOT NULL,
  `A_C2` varchar(100) NOT NULL,
  `A_C3` varchar(100) NOT NULL,
  `A_C4` varchar(100) NOT NULL,
  `A_C5` varchar(100) NOT NULL,
  `A_C6` varchar(100) NOT NULL,
  `A_C7` varchar(100) NOT NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL,
  `A_DESCRIPCION` text NOT NULL,
  `A_LOCALIZACIÓN` text NOT NULL,
  `A_COMO_LLEGAR` text NOT NULL,
  `A_ACTIVIDADES` text NOT NULL,
  `A_FOTOS` varchar(100) NOT NULL,
  `servicios_ID_SERVICIOS` INT NOT NULL ,
  PRIMARY KEY (`A_ID`) ,
  INDEX `fk_atomos_servicios_servicios1` (`servicios_ID_SERVICIOS` ASC) ,
  CONSTRAINT `fk_atomos_servicios_servicios1`
    FOREIGN KEY (`servicios_ID_SERVICIOS` )
    REFERENCES `servicios` (`ID_SERVICIOS` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `atomos_servicios` (`A_ID`, `A_NOMBRE`, `A_C1`, `A_C2`, `A_C3`, `A_C4`, `A_C5`, `A_C6`, `A_C7`, `A_LATITUD`, `A_LONGITUD`, `A_DESCRIPCION`, `A_LOCALIZACIÓN`,`A_COMO_LLEGAR`, `A_ACTIVIDADES`, `A_FOTOS`, `servicios_ID_SERVICIOS`) VALUES
(1, 'Aeropuerto', '7.', '119.', '1,2,3.', '', '1,2,3,4.', '', '', 17.533895, -91.985958, '', '', '', '', '', 2),
(4, 'Auditorio Municipal', '2,6.', '124,125;72,73.', '1,2.', '', '1,2,3,4.', '', '', 17.513796, -91.980273, '', '', '', '', '', 6),
(5, 'Aurrera', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.511783, -91.988671, '', '', '', '', '', 4),
(6, 'Autobuses Cristóbal Colón, ADO y Maya De Oro.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.507795, -91.987111, '', '', '', '', '', 2),
(7, 'Autobuses Lagos De Montebello.', '7.', '111.', '1.', '', '1,2,3,4.', '', '', 17.512349, -91.989057, '', '', '', '', '', 2),
(8, 'Autotransporte Aexa.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508062, -91.986911, '', '', '', '', '', 2),
(10, 'Banamex.', '7.', '116.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509218, -91.982735, '', '', '', '', '', 1),
(11, 'Bancomer.', '7.', '116.', '1,2,3.', '', '1,2,3,4.', '', '', 17.510507, -91.982325, '', '', '', '', '', 1),
(15, 'Centro Administrativo De Justicias.', '7.', '118.', '1,2.', '', '1,2,3.', '', '', 17.517605, -91.993641, '', '', '', '', '', 5),
(16, 'Chedraui.', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.511952, -91.991187, '', '', '', '', '', 4),
(17, 'Clínica IMSS.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.512123, -91.977006, '', '', '', '', '', 3),
(18, 'Clínica ISSSTE.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.507028, -91.987993, '', '', '', '', '', 3),
(19, 'Clínica ISSTECH.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.506742, -91.976448, '', '', '', '', '', 3),
(20, 'Coppel.', '7.', '99.', '1,2.', '', '1,2,3,4.', '', '', 17.511852, -91.989186, '', '', '', '', '', 4),
(21, 'Cruz Roja Mexicana.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.513975, -91.998697, '', '', '', '', '', 3),
(22, 'Estación Ferrocarril.', '7.', '121.', '1,2.', '', '1,2,3.', '', '', 17.543061, -91.989387, '', '', '', '', '', 6),
(23, 'Estación Gasolinera.', '7.', '106.', '1,2,3.', '', '1,2,3.', '', '', 17.508174, -91.988216, '', '', '', '', '', 6),
(24, 'Fiscalía Del Distrito La Selva.', '7.', '108.', '1,2.', '1,3.', '', '', '', 17.507836, -91.980942, '', '', '', '', '', 5),
(25, 'Hospital General.', '7.', '105.', '1,2,3.', '1,2,3,4.', '', '', '', 17.507765, -91.98842, '', '', '', '', '', 3),
(27, 'Italian Coffee.', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.510159, -91.980588, '', '', '', '', '', 4),
(28, 'Lienzo Charro.', '6,7.', '73,93;110.', '1,2.', '', '1,3.', '', '', 17.513172, -91.996433, '', '', '', '', '', 6),
(29, 'Mercado.', '7.', '123.', '1,2.', '', '1,2,3,4.', '', '', 17.511806, -91.986231, '', '', '', '', '', 6),
(33, 'Mujer Chol.', '4.', '87.', '1,2,3.', '1,2,3,4.', '', '', '', 17.50843, -91.98577, '', '', '', '', '', 6),
(37, 'Palacio Municipal.', '7.', '108.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509596, -91.980985, '', '', '', '', '', 5),
(38, 'Panteón Municipal.', '7.', '126.', '1,2.', '', '1,2,3,4.', '', '', 17.507785, -91.988946, '', '', '', '', '', 6),
(40, 'Parque De Feria.', '1,6.', '98;93.', '1,2,3.', '', '1,2,3,4.', '', '', 17.504225, -91.981156, '', '', '', '', '', 6),
(43, 'Prenda Mex.', '7.', '117.', '1,2.', '', '1,3,4.', '', '', 17.509279, -91.983624, '', '', '', '', '', 6),
(44, 'SECTUR.', '7.', '108.', '1,2.', '', '1,3.', '', '', 17.51198, -91.990817, '', '', '', '', '', 5),
(45, 'Telegráfos Nacionales.', '7.', '118.', '1,2.', '', '1,2,3,4.', '', '', 17.510139, -91.983764, '', '', '', '', '', 5),
(46, 'Tienda ISSSTE', '1.', '99.', '1,2,3.', '', '1,2,3.', '', '', 17.508102, -91.97665, '', '', '', '', '', 4),
(47, 'Transporte AJO.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508798, -91.984665, '', '', '', '', '', 2),
(48, 'Transporte Cascadas De Agua Azul.', '7.', '111.', '1,2,3.', '1,2,3.', '', '', '', 17.512737, -91.986693, '', '', '', '', '', 2),
(49, 'Transporte Chambalú.', '7.', '111.', '1,2.', '1,2,3,4.', '', '', '', 17.509576, -91.984912, '', '', '', '', '', 2),
(50, 'Transporte Chamoan.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.509729, -91.985008, '', '', '', '', '', 2),
(51, 'Transporte Chancalá.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508645, -91.985096, '', '', '', '', '', 2),
(52, 'Transporte Palenque.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508849, -91.984581, '', '', '', '', '', 2);


--
-- Estructura de tabla para la tabla `atomos_temporales`
--

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
  `AT_LOCALIZACIÓN` text NOT NULL,
  `AT_COMO_LLEGAR` text NOT NULL,
  `AT_ACTIVIDADES` text NOT NULL,
  `AT_FOTOS` varchar(100) NOT NULL,
  `menu_ID_MENU` INT NOT NULL ,
  PRIMARY KEY (`AT_ID`, `menu_ID_MENU`) ,
  INDEX `fk_atomos_temporales_menu1` (`menu_ID_MENU` ASC) ,
  CONSTRAINT `fk_atomos_temporales_menu1`
    FOREIGN KEY (`menu_ID_MENU` )
    REFERENCES `menu` (`ID_MENU` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Volcado de datos para la tabla `atomos_temporales`
--
INSERT INTO `atomos_temporales` (`AT_ID`, `AT_NOMBRE`, `AT_C1`, `AT_C2`, `AT_C3`, `AT_C4`, `AT_C5`, `AT_C6`, `AT_C7`, `AT_LATITUD`, `AT_LONGITUD`, `AT_FECHA`, `AT_PERIODO`, `AT_DESCRIPCION`, `AT_LOCALIZACIÓN`, `AT_COMO_LLEGAR`, `AT_ACTIVIDADES`, `AT_FOTOS`, `menu_ID_MENU`) VALUES
(1, 'Feria Santo Domingo De Guzmán', '6.', '75,81,93,95.', '1,2,3.', '', '1,2,3,4.', '', '', 17.503958, -91.98074, '2014-08-06', '', '', '', '', '', 'feria.jpg', 3),
(2, 'Expo Feria Internacional Mundo Maya', '6.', '72,80,95.', '1,2,3,4.', '', '1,2,3,4.', '', '', 17.509197, -91.980954, '2014-04-17', '', '', '', '', '', 'expo.jpg', 3);

CREATE TABLE IF NOT EXISTS `buscar` (
  `A_ID` int(11) NOT NULL,
  `A_NOMBRE` varchar(100) NOT NULL,
  `A_C1` varchar(100) NOT NULL,
  `A_C2` varchar(100) NOT NULL,
  `A_C3` varchar(100) NOT NULL,
  `A_C4` varchar(100) NOT NULL,
  `A_C5` varchar(100) NOT NULL,
  `A_C6` varchar(100) NOT NULL,
  `A_C7` varchar(100) NOT NULL,
  `A_LATITUD` float NOT NULL,
  `A_LONGITUD` float NOT NULL,
  `A_DESCRIPCION` text NOT NULL,
  `A_LOCALIZACIÓN` text NOT NULL,
  `A_COMO_LLEGAR` text NOT NULL,
  `A_ACTIVIDADES` text NOT NULL,
  `A_FOTOS` varchar(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
INSERT INTO `buscar` (`A_ID`, `A_NOMBRE`, `A_C1`, `A_C2`, `A_C3`, `A_C4`, `A_C5`, `A_C6`, `A_C7`, `A_LATITUD`, `A_LONGITUD`, `A_DESCRIPCION`, `A_LOCALIZACIÓN`,`A_COMO_LLEGAR`, `A_ACTIVIDADES`, `A_FOTOS`) VALUES
(1, 'Aeropuerto', '7.', '119.', '1,2,3.', '', '1,2,3,4.', '', '', 17.533895, -91.985958, '', '', '', '', ''),
(2, 'Albercas Naturales De Montebello', '1,3.', '1,2;53,54,47.', '1,2,3.', '', '1,2,3.', '3.', '', 17.477415, -91.957591, '', '', '', '', 'albercas.jpg'),
(3, 'Andador Ecológico', '1.', '3,6,8.', '1,2,3.', '', '1,2,3.', '3.', '', 17.487689, -92.048868, '', '', '', '', 'andador.jpg'),
(4, 'Auditorio Municipal', '2,6.', '124,125;72,73.', '1,2.', '', '1,2,3,4.', '', '', 17.513796, -91.980273, '', '', '', '', ''),
(5, 'Aurrera', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.511783, -91.988671, '', '', '', '', ''),
(6, 'Autobuses Cristóbal Colón, ADO y Maya De Oro.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.507795, -91.987111, '', '', '', '', ''),
(7, 'Autobuses Lagos De Montebello.', '7.', '111.', '1.', '', '1,2,3,4.', '', '', 17.512349, -91.989057, '', '', '', '', ''),
(8, 'Autotransporte Aexa.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508062, -91.986911, '', '', '', '', ''),
(9, 'Balneario Chacamax.', '1,3.', '1,2;47.', '1,2,3.', '', '1,2,3.', '3.', '', 17.496417, -91.954195, '', '', '', '', 'balneario.jpg'),
(10, 'Banamex.', '7.', '116.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509218, -91.982735, '', '', '', '', ''),
(11, 'Bancomer.', '7.', '116.', '1,2,3.', '', '1,2,3,4.', '', '', 17.510507, -91.982325, '', '', '', '', ''),
(12, 'Casa De La Cultura.', '4.', '83.', '1,2.', '', '1,2,3,4.', '', '', 17.512502, -91.980399, '', '', '', '', 'casa.jpg'),
(13, 'Cascada Agua Clara.', '1,2,3.', '2,3,9;13,25,33;60.', '1,2,3.', '', '1,2,3.', '2,3.', '', 17.25777778, -92.05250000, '', '', '', '', 'agua_clara.jpg'),
(14, 'Cascada Agua Azul.', '1,2,3.', '2;33;42,52,60.', '1,2,3.', '', '1,2,3.', '2,3.', '', 17.259269, -92.114711, '', '', '', '', 'agua_azul.jpg'),
(15, 'Centro Administrativo De Justicias.', '7.', '118.', '1,2.', '', '1,2,3.', '', '', 17.517605, -91.993641, '', '', '', '', ''),
(16, 'Chedraui.', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.511952, -91.991187, '', '', '', '', ''),
(17, 'Clínica IMSS.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.512123, -91.977006, '', '', '', '', ''),
(18, 'Clínica ISSSTE.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.507028, -91.987993, '', '', '', '', ''),
(19, 'Clínica ISSTECH.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.506742, -91.976448, '', '', '', '', ''),
(20, 'Coppel.', '7.', '99.', '1,2.', '', '1,2,3,4.', '', '', 17.511852, -91.989186, '', '', '', '', ''),
(21, 'Cruz Roja Mexicana.', '7.', '105.', '1,2,3.', '', '1,2,3,4.', '', '', 17.513975, -91.998697, '', '', '', '', ''),
(22, 'Estación Ferrocarril.', '7.', '121.', '1,2.', '', '1,2,3.', '', '', 17.543061, -91.989387, '', '', '', '', ''),
(23, 'Estación Gasolinera.', '7.', '106.', '1,2,3.', '', '1,2,3.', '', '', 17.508174, -91.988216, '', '', '', '', ''),
(24, 'Fiscalía Del Distrito La Selva.', '7.', '108.', '1,2.', '1,3.', '', '', '', 17.507836, -91.980942, '', '', '', '', ''),
(25, 'Hospital General.', '7.', '105.', '1,2,3.', '1,2,3,4.', '', '', '', 17.507765, -91.98842, '', '', '', '', ''),
(26, 'Iglesia Santo Domingo.', '4.', '86.', '1,2,3.', '', '1,2,3,4.', '', '', 17.508982, -91.980298, '', '', '', '', 'iglesia.jpg'),
(27, 'Italian Coffee.', '1.', '99.', '1,2,3.', '', '1,2,3,4.', '', '', 17.510159, -91.980588, '', '', '', '', ''),
(28, 'Lienzo Charro.', '6,7.', '73,93;110.', '1,2.', '', '1,3.', '', '', 17.513172, -91.996433, '', '', '', '', ''),
(29, 'Mercado.', '7.', '123.', '1,2.', '', '1,2,3,4.', '', '', 17.511806, -91.986231, '', '', '', '', ''),
(30, 'Misol-Ha.', '1,3.', '1,2,8;42,53,54.', '1,2,3,4.', '', '1,2,3,4.', '3,4.', '', 17.392845, -92.00018, '', '', '', '', 'misol-ha.jpg'),
(31, 'Monumento A La Madre Chol.', '4.', '87.', '1,2,3.', '', '1,2,3,4.', '', '', 17.504956, -91.992024, '', '', '', '', 'madre_chol.jpg'),
(32, 'Monumento A La Cabeza Maya.', '4.', '87.', '1,2,3.', '1,2,3,4.', '', '', '', 17.508343, -91.989664, '', '', '', '', 'cabeza.jpg'),
(33, 'Mujer Chol.', '4.', '87.', '1,2,3.', '1,2,3,4.', '', '', '', 17.50843, -91.98577, '', '', '', '', ''),
(34, 'Museo De Sitio.', '4.', '83,65.', '1,2,3.', '', '1,2,3,4.', '', '', 17.488467, -92.042066, '', '', '', '', 'museo.jpg'),
(35, 'Museo Del Textil LAK PUJ KUL.', '4;5.', '62,83;68.', '1,2,3.', '', '1,2,3,4.', '', '', 17.508512, -91.981092, '', '', '', '', 'textil.jpg'),
(36, 'Nututún.', '1;3.', '1,2;47.', '1,2,3.', '', '1,2,3,4.', '2,3,4.', '', 17.485438, -91.973433, '', '', '', '', 'nututun.jpg'),
(37, 'Palacio Municipal.', '7.', '108.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509596, -91.980985, '', '', '', '', ''),
(38, 'Panteón Municipal.', '7.', '126.', '1,2.', '', '1,2,3,4.', '', '', 17.507785, -91.988946, '', '', '', '', ''),
(39, 'Parque Central.', '1,6,7.', '98;72;107.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509085, -91.981135, '', '', '', '', 'parque.jpg'),
(40, 'Parque De Feria.', '1,6.', '98;93.', '1,2,3.', '', '1,2,3,4.', '', '', 17.504225, -91.981156, '', '', '', '', ''),
(41, 'Plaza De Las Artesanías y Módulos De Información Turística.', '6.', '75.', '1,2,3.', '', '1,2,3,4.', '', '', 17.509238, -91.982006, '', '', '', '', 'plaza.jpg'),
(42, 'Plaza del Artesano.', '4;6.', '62;75.', '1,2,3.', '', '1,2,3,4.', '', '', 17.505524, -91.99195, '', '', '', '', 'artesano.jpg'),
(43, 'Prenda Mex.', '7.', '117.', '1,2.', '', '1,3,4.', '', '', 17.509279, -91.983624, '', '', '', '', ''),
(44, 'SECTUR.', '7.', '108.', '1,2.', '', '1,3.', '', '', 17.51198, -91.990817, '', '', '', '', ''),
(45, 'Telegráfos Nacionales.', '7.', '118.', '1,2.', '', '1,2,3,4.', '', '', 17.510139, -91.983764, '', '', '', '', ''),
(46, 'Tienda ISSSTE', '1.', '99.', '1,2,3.', '', '1,2,3.', '', '', 17.508102, -91.97665, '', '', '', '', ''),
(47, 'Transporte AJO.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508798, -91.984665, '', '', '', '', ''),
(48, 'Transporte Cascadas De Agua Azul.', '7.', '111.', '1,2,3.', '1,2,3.', '', '', '', 17.512737, -91.986693, '', '', '', '', ''),
(49, 'Transporte Chambalú.', '7.', '111.', '1,2.', '1,2,3,4.', '', '', '', 17.509576, -91.984912, '', '', '', '', ''),
(50, 'Transporte Chamoan.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.509729, -91.985008, '', '', '', '', ''),
(51, 'Transporte Chancalá.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508645, -91.985096, '', '', '', '', ''),
(52, 'Transporte Palenque.', '7.', '111.', '1,2.', '', '1,2,3,4.', '', '', 17.508849, -91.984581, '', '', '', '', ''),
(53, 'Welib-Ha.', '1,2,3.', '1,2,8;38;42,48,53,54.', '1,2,3.', '', '1,2,3,4.', '3,4.', '', 17.374805, -91.799111, '', '', '', '', 'welib-ha.jpg'),
(54, 'Zona Arqueológica.', '1;3;4.', '6,8;53,54;61.', '1,2,3.', '', '1,2,3,4.', '3,4.', '', 17.48337, -92.046186, '', '', '', '', 'zona.jpg'),
(55, 'Zona Turística La Cañada.', '3.', '53,54.', '1,2,3.', '', '1,2,3,4.', '2,3.', '', 17.50888, -91.989358, '', '', '', '', 'turistica.jpg'),
(56, 'Feria Santo Domingo De Guzmán', '6.', '75,81,93,95.', '1,2,3.', '', '1,2,3,4.', '', '', 17.503958, -91.98074, '', '', '', '', 'feria.jpg'),
(57, 'Expo Feria Internacional Mundo Maya', '6.', '72,80,95.', '1,2,3,4.', '', '1,2,3,4.', '', '', 17.509197, -91.980954, '', '', '', '', 'expo.jpg');