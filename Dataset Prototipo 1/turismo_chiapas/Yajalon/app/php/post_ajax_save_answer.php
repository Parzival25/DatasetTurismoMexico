<?php
  /*$con = mysql_connect("localhost","hgcrespo_ty","yajalonlayev");
  if (!$con) die('!!! Conexión fallida !!!: ' . mysql_error());
  
  mysql_select_db("tesis", $con);

  // establece la salida de texto como xml
  header("Content-type: text/json");
 
  
  
  // se consulta la base de datos de sitios turísticos para generar los campos necesarios para despliegue en el mapa
  mysql_query("SET NAMES utf8");   // para reconocer acentos
  $sql = "select * from preguntas";
  $resultado = mysql_query($sql);
  if (!$resultado) die('Instrucción inválida: ' . mysql_error());

  // se generan cada uno de los marcadores
  while ($row = @mysql_fetch_assoc($resultado))
  { 
    $question[]=$row;	
  }
  
  // imprime el documento
  echo json_encode($question);
  */

  echo "ok";
?>
