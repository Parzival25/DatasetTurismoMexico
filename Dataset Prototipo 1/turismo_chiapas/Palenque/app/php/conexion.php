<?php
$bd_host = "localhost"; //localhost XD
$bd_usuario = "root"; //usuario
$bd_password = ""; //contraseña
$bd_base = "turismo_palenque"; //Nombre de la db
$con = mysql_connect($bd_host, $bd_usuario, $bd_password);
mysql_select_db($bd_base, $con);
mysql_query("SET NAMES 'utf8'");
?> 