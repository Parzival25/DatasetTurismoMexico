<?php
  $con = mysql_connect("localhost","root","");
  if (!$con) die('!!! Conexión fallida !!!: ' . mysql_error());
  
  mysql_select_db("turismo_acacoyagua", $con);

  // establece la salida de texto como xml
  header("Content-type: text/xml");
 
  // inicia el archivo XML, se crea el nodo padre
  $doc  = new DOMDocument("1.0","UTF-8");
  $nodo = $doc->createElement("marcadores");
  $nodo_padre = $doc->appendChild($nodo);
  
  
  // se consulta la base de datos de sitios turísticos para generar los campos necesarios para despliegue en el mapa
  mysql_query("SET NAMES utf8");   // para reconocer acentos
  $sql = "select * from atomos where A_TIPO='t' order by A_ID";
  $resultado = mysql_query($sql);
  if (!$resultado) die('Instrucción inválida: ' . mysql_error());

  // se generan cada uno de los marcadores
  while ($row = @mysql_fetch_assoc($resultado))
  { 
    $nodo    =  $doc->createElement("marcador");
    $newnodo =  $nodo_padre->appendChild($nodo);
    $newnodo -> setAttribute("id", $row['A_ID']);
	$newnodo -> setAttribute("nombre", $row['A_NOMBRE']);
    $newnodo -> setAttribute("lat", $row['A_LATITUD']);
    $newnodo -> setAttribute("lng", $row['A_LONGITUD']);	
  }
  
  // imprime el documento
  echo $doc->saveXML();
?>
