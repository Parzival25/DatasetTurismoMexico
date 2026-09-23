<?php
  $con = mysql_connect("localhost","root","");
  if (!$con) die('!!! Conexión fallida !!!: ' . mysql_error());
  
  mysql_select_db("mezcalapa", $con);

  // establece la salida de texto como xml
  header("Content-type: text/xml");
    
  // inicia el archivo XML, se crea el nodo padre
  $doc  = new DOMDocument("1.0", "UTF-8");
  $nodo = $doc->createElement("marcadores");
  $nodo_padre = $doc->appendChild($nodo);
  
  
  // se consulta la base de datos de sitios turísticos para generar los campos necesarios para despliegue en el mapa
  mysql_query("SET NAMES utf8");   // para reconocer acentos
  $sql = "select * from atomos_temporales";
  $resultado = mysql_query($sql);
  if (!$resultado) die('Instrucción inválida: ' . mysql_error());

  // se generan cada uno de los marcadores
  while ($row = @mysql_fetch_assoc($resultado))
  { 
    $cadena   = $row['AT_C1']; /* cadena de la categorías*/
    if(strpos($cadena, "6") !== false)
	{
	  $nodo    =  $doc->createElement("marcador");
      $newnodo =  $nodo_padre->appendChild($nodo);
      $newnodo -> setAttribute("id", $row['AT_ID']);
	  $newnodo -> setAttribute("nombre", $row['AT_NOMBRE']);
      $newnodo -> setAttribute("lat", $row['AT_LATITUD']);
      $newnodo -> setAttribute("lng", $row['AT_LONGITUD']);	
    } 
  }
  
  // imprime el documento
  echo $doc->saveXML();
?>
