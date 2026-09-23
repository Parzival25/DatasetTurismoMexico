<?php

$busca=$_POST['buscador'];
mysql_connect("localhost", "root");
mysql_select_db("turismo_palenque");
mysql_query("SET NAMES 'utf8'");
if($busca!=""){

	$busqueda=mysql_query("SELECT * FROM buscar Where A_NOMBRE = '".$busca."'");
	while ($f=mysql_fetch_array($busqueda)) {
		echo $f['A_ID'].' => '.$f['A_NOMBRE'].' => '.$f['A_LATITUD'].' => '.$f['A_LONGITUD'];

	}

}
?>
