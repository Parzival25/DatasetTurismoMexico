<?php

/*$buscador = $_GET['term'];
 
$conexion = new mysqli('localhost','root','','turismo_palenque_menu');
 
$consulta = "select A_ID, A_NOMBRE, A_LATITUD, A_LONGITUD from buscar where A_NOMBRE LIKE '%$buscador%'";

 
$result = $conexion->query($consulta);
//$result2 = $conexion->query($consulta2);
 
if($result->num_rows > 0){
    while($fila = $result->fetch_array()){
        $matriculas[] = $fila['A_NOMBRE'];
    }
	
echo json_encode($matriculas);
}

?>
*/

$buscador = $_GET['term'];
$bd_host = "localhost"; //localhost XD
$bd_usuario = "root"; //usuario
$bd_password = ""; //contraseña
$bd_base = "turismo_palenque"; //Nombre de la db
$con = mysql_connect($bd_host, $bd_usuario, $bd_password);
mysql_select_db($bd_base, $con);
mysql_query("SET NAMES 'utf8'");


//$consulta = "select A_ID, A_NOMBRE, A_LATITUD, A_LONGITUD from buscar where A_NOMBRE LIKE '%$buscador%'";

$consulta = mysql_query("select A_ID, A_NOMBRE, A_LATITUD, A_LONGITUD from buscar where A_NOMBRE LIKE '%$buscador%'");
//$result = mysql_query($consulta);
//$result2 = $conexion->query($consulta2);

if(mysql_num_rows($consulta) > 0){
    while($fila = mysql_fetch_row($consulta)){
        $matriculas[] = $fila[1];
    }
	
echo json_encode($matriculas);
}

?>

