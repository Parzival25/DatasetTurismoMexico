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
  `A_FOTOS` text  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `atomos`
--

INSERT INTO atomos (A_ID, A_NOMBRE, A_C1, A_C2, A_C7, A_LATITUD, A_LONGITUD, A_DESCRIPCION, A_COMO_LLEGAR, A_ACTIVIDADES, A_FOTOS) VALUES

(1, 'Parque Central', '7.', '107.', '',16.871560, -93.206494, '', '', '', ''),
(2, 'Presidencia Mnicipal', '7.', '107.', '',16.871560, -93.206494, '', '', '', ''),
(3, 'Presa Hidroelectrica Manuel Moreno', '2,3.', '13,29;46,54,92,85.', '',16.940998, -93.102248, '', '', '', ''),
(4, 'MIrador Cañon el Sumidero', '1,3.', '3,6,8,10.', '',16.914889, -93.104990, '', '', '', ''),
(5, 'Gasolinera San fernando', '7.', '106.', '',16.863534, -93.204058, '', '', '', ''),

(6, 'Presa Hidroelectrica Manuel Moreno', '2,3,6.', '13,29;46,54,92;85.', '',16.940998, -93.102248, '', '', '', ''),
(7, 'Embarcadero Cañon el Sumidero', '1,2,3.', '1,2,3,4,6,8,84,99,112;13,16,26,38;42,47,60,85.', '',16.933427, -93.103837, '', '', '', ''),
(8, 'Arquitectura Verenacula del Pueblo', '4.', '86,91.', '',16.966077, -93.104326, '', '', '', ''),
(9, 'Rio Grijalva Chico', '1.', '1,2,6,10.', '',16.967497, -93.107070, '', '', '', ''),
(10, 'Parque Central Chicoasen', '7.', '107.', '',16.967056, -93.105222, '', '', '', ''),
(11, 'Cascada Francisco Sarabia', '1,2.', '1,2,3,4,6,7,8,9,10;17.', '',16.966726, -93.099436, '', '', '', ''),

(12, 'Centro Neurologico Ladera de Monos', '1,2,3,4.', '1,2,3,4,6,7,84;25,38,30;60;66.', '',16.933060, -93.095878, '', '', '', ''),

(13, 'Parque Copainala', '7.', '107.', '',17.092592, -93.211481, '', '', '', ''),
(14, 'Presidencia Municipal', '7.', '108.', '',17.092769, -93.211152, '', '', '', ''),
(15, 'Ex Convento Colonial San Miguel', '4.', '61,86.', '',17.091858, -93.210851, '', '', '', ''),

(16, 'Presidencia Municipal', '7.', '108.', '',17.130890, -93.160890, '', '', '', ''),
(17, 'Parque Coapilla', '7.', '107.', '',17.130890, -93.160890, '', '', '', ''),
(18, 'Templo Colonial del siglo XVII', '4.', '61,86.', '',17.130856, -93.160216, '', '', '', ''),
(19, 'La laguna encantada verde', '1.', '1,2,3,4,6,7,10.', '',17.132434, -93.163748, '', '', '', ''),

(20, 'Presidencia Municipal', '7.', '107.', '',17.136443, -93.311157, '', '', '', ''),
(21, 'Centro de Salud', '7.', '113.', '',17.134354, -93.310286, '', '', '', ''),
(22, 'Lienzo Charro', '7,2,6.', '110,115.', '',17.140082, -93.315601, '', '', '', ''),
(23, 'Cerro Santo', '2.', '12,15,26,33.', '',17.142705, -93.351437, '', '', '', ''),
(24, 'Cuevas El Azufre', '3.', '56.', '',17.154584, -93.302442, '', '', '', ''),
(25, 'Balneario el Azufre', '1.', '1,2,3,4,6,7.', '',17.154607, -93.302033, '', '', '', ''),
(26, 'Malecon La Huarta', '1,2.', '1,2,3,4,6,7,8,9,10;17.', '',17.137722, -93.312842, '', '', '', ''),
(27, 'Aguas Termales El Azufre', '1.', '1,2,3,4,6,7.', '',17.155718, -93.301436, '', '', '', ''),
(28, 'Rio Tecpatan', '1,2.', '1,2,3,4,6,7,8,9,10;17.', '',17.144287, -93.309693, '', '', '', ''),
(29, 'Rio La Canastilla', '1.', '1,2,3,4,6,7.', '',17.127262, -93.319269, '', '', '', ''),
(30, 'Ex Convento Santo Domingo de Guzman', '4.', '61,65,87,91,.', '',17.136587, -93.312631, '', '', '', ''),
(31, 'Encajonado El Azufre', '1.', '3,6.', '',17.155175, -93.301833, '', '', '', ''),
(32, 'Parque La Amistad', '7.', '107.', '',17.136148, -93.310975, '', '', '', ''),
(33, 'Parque Infantil', '7.', '109.', '',17.139552, -93.314615, '', '', '', ''),
(34, 'Ex Convento Santiago', '1,2,4.', '1,6,8,84;29;61,87.', '',17.015849, -93.318287, '', '', '', ''),
(35, 'Museo Zoque', '4.', '83.', '',17.137676, -93.314582, '', '', '', ''),
(36, 'Casa de la Cultura', '4.', '83.', '',17.137988, -93.314625, '', '', '', ''),
(37, 'Cascada de Zapata', '1,2.', '1,2,3,4,6,7,8,9,10;17.', '',17.169377, -93.335985, '', '', '', ''),
(38, 'Museo Joel Robledo', '4.', '83.', '',17.134995, -93.309936, '', '', '', ''),

(39, 'Presidencia Municipal', '7.', '108.', '',17.189143, -93.605349, '', '', '', ''),
(40, 'Puente Chiapas', '1,3.', '1,2,6,84,112;56.', '',17.130978, -93.595187, '', '', '', ''),
(41, 'Cueva de las Cotorras', '1,2,3.', '1,2,84;18,19;38,57.', '',17.126989, -93.484039, '', '', '', ''),

(42, 'Presidencia Municipal', '7.', '108.', '',16.762323, -93.374972, '', '', '', ''),
(43, 'Parque Central', '7.', '107.', '',16.762188, -93.375909, '', '', '', ''),
(44, 'Cima de las Cotorras', '1,2,3.', '3,6,8,112;18,19,30;56.', '',16.807534, -93.474981, '', '', '', ''),
(45, 'Parque Educativo Laguna Belgica', '1.', '1,2,3,6,7.', '',16.880645, -93.457521, '', '', '', ''),
(46, 'Cañon La Venta', '1.', '3,6,8.', '',17.010154, -93.795973, '', '', '', '');


CREATE TABLE IF NOT EXISTS `atomos_temporales` (
  `AT_ID` int(11) NOT NULL,
  `AT_NOMBRE` varchar(100) NOT NULL,
  `AT_C1` varchar(100)  NULL,
  `AT_C2` varchar(100)  NULL,
  `AT_C6` varchar(100)  NULL,
  `AT_LATITUD` float NOT NULL,
  `AT_LONGITUD` float NOT NULL,
  `AT_DESCRIPCION` text  NULL,
  `AT_COMO_LLEGAR` text  NULL,
  `AT_ACTIVIDADES` text  NULL,
  `AT_FOTOS` text  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO atomos_temporales (AT_ID, AT_NOMBRE, AT_C1, AT_C2, AT_C6,AT_LATITUD, AT_LONGITUD, AT_DESCRIPCION, AT_COMO_LLEGAR, AT_ACTIVIDADES, AT_FOTOS) VALUES
(47, 'Feria de la Candelaria', '6.', '72,81.', '',16.870189, -93.208885, '', '', '', ''),
(48, 'Feria de Santa Cruz ', '6.', '72,81.', '',16.873742, -93.208306, '', '', '', ''),
(49, 'Feria Señor de Misericordia ', '6.', '72,81.', '',16.937211, -93.090165, '', '', '', ''),
(50, 'Feria Señor de San Lucas', '6.', '72,81.', '',16.937211, -93.090165, '', '', '', ''),
(51, 'Feria de Copainala', '6.', '72,81,93.', '',17.094567, -93.210024, '', '', '', ''),
(52, 'Feria de Santisima trinidad ', '6.', '72,81.', '',17.090834, -93.209724, '', '', '', ''),
(53, 'Virgen de Guadalupe', '6.', '72,81.', '',17.095264, -93.211826, '', '', '', ''),
(54, 'Feria de Candelaria', '6.', '72,81.', '',17.129935, -93.157976, '', '', '', ''),
(55, 'Feria Señor de Misericordia ', '6.', '72,81.', '',17.129361, -93.161324, '', '', '', ''),
(56, 'Feria Santo Domingo', '6.', '72,81.', '',17.135799, -93.310305, '', '', '', ''),
(57, 'Feria de San Marcos', '6.', '72,81,93,73.', '',17.137275, -93.310112, '', '', '', ''),
(58, 'Torneo Charro San Marcos ', '6.', '73,93.', '',17.140015, -93.316151, '', '', '', ''),
(59, 'Rodeos', '6.', '73.', '',17.140323, -93.315440, '', '', '', ''),
(60, 'Carnaval Zoque Coiteco', '6.', '72,81,93,73.', '',16.765225, -93.378259, '', '', '', ''),
(61, 'Virgen de la Asuncion', '6.', '73,93.', '',16.755526, -93.373109, '', '', '', ''),
(62, 'Torneo Charro', '6.', '73.', '',16.770278, -93.386544, '', '', '', '');
