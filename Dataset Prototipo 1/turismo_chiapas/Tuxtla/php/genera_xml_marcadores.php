<?php
  $con = mysql_connect("localhost","root","");
  if (!$con) die('!!! Conexión fallida !!!: ' . mysql_error());
  
  mysql_select_db("turismo", $con);

  // establece la salida de texto como xml
  header("Content-type: text/xml");
 
  // inicia el archivo XML, se crea el nodo padre
  $doc  = new DOMDocument("1.0","UTF-8");
  $nodo = $doc->createElement("marcadores");
  $nodo_padre = $doc->appendChild($nodo);
  
  
  // se consulta la base de datos de sitios turísticos para generar los campos necesarios para despliegue en el mapa
  mysql_query("SET NAMES utf8");   // para reconocer acentos
  $sql = "select * from ATOMOS_TUXTLA_GUTIERREZ";
  $resultado = mysql_query($sql);
  if (!$resultado) die('Instrucción inválida: ' . mysql_error());

  // se generan cada uno de los marcadores
  while ($row = @mysql_fetch_assoc($resultado))
  { 
    $nodo    =  $doc->createElement("marcador");
    $newnodo =  $nodo_padre->appendChild($nodo);
    $newnodo -> setAttribute("id", $row['ATG_ID']);
	$newnodo -> setAttribute("nombre", $row['ATG_NOMBRE']);
    $newnodo -> setAttribute("lat", $row['ATG_LATITUD']);
    $newnodo -> setAttribute("lng", $row['ATG_LONGITUD']);	
  }
  
  // imprime el documento
  echo $doc->saveXML();
?>
