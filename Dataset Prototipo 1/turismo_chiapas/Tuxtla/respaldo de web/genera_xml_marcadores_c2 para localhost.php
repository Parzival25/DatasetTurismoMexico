<?php
  $con = mysql_connect("localhost","root","");
  if (!$con) die('!!! Conexión fallida !!!: ' . mysql_error());
  
  mysql_select_db("turismo", $con);

  
    
  // inicia el archivo XML, se crea el nodo padre
  $doc  = new DOMDocument("1.0", "UTF-8");
  $nodo = $doc->createElement("marcadores");
  $nodo_padre = $doc->appendChild($nodo);
  
  
  // se consulta la base de datos de sitios turísticos para generar los campos necesarios para despliegue en el mapa
  mysql_query("SET NAMES utf8");   // para reconocer acentos
  //$sql = "select * from ATOMOS_TUXTLA_GUTIERREZ where ATG_C2 like '2'";
   $sql = "select * from ATOMOS_TUXTLA_GUTIERREZ";
  $resultado = mysql_query($sql);
  if (!$resultado) die('Instrucción inválida: ' . mysql_error());

  $b=0;  /* bandera para resultados = 0 */
  //while ($row = @mysql_fetch_assoc($resultado))
 // { 
    //$cadena = $row['ATG_C2']; /* cadena de la categorías*/
	//echo "<pre>";
	//print_r($row);
	//echo "</pre>";
 // }	
 // exit;
  // se generan cada uno de los marcadores
  while ($row = @mysql_fetch_assoc($resultado))
  { 
    $cadena = $row['ATG_C2']; /* cadena de la categorías*/
		
	$i=0; /* empieza la cadena */
	$j=0; /* empieza la subcadena */
    while($cadena[$i]!=".")
	{
	  while($cadena[$i]!="," and $cadena[$i]!=";")  /* enviar la clasificación de manera individual a la subcadena para después compararla */
	  {
	    if ($cadena[$i]!=".")
		{
  	      $subcadena[$j]=$cadena[$i];
		  $j++;
		  $i++;
		}
		else
		{
		  $i--;  /* para terminar el ciclo */
		  break;
		}
	  }
	  
	  $categoria = "";  /* "declara" $categoria como string */
	  //foreach ($subcadena AS $valor) /* convertir a cadena el arreglo extraido */
      //  $categoria .= $valor;
	  for($k=0;$k<$j;$k++) /* convertir a cadena el arreglo extraido */
	    $categoria .= $subcadena[$k];
		
	 /* echo "<pre>";
	  print_r($categoria);
	  echo "</pre>";*/
	  	  
	  if(strcmp($categoria, $_GET["q"]) == 0)
	  {
        $nodo    =  $doc->createElement("marcador");
        $newnodo =  $nodo_padre->appendChild($nodo);
        $newnodo -> setAttribute("id", $row['ATG_ID']);
	    $newnodo -> setAttribute("nombre", $row['ATG_NOMBRE']);
        $newnodo -> setAttribute("lat", $row['ATG_LATITUD']);
        $newnodo -> setAttribute("lng", $row['ATG_LONGITUD']);	
		$b=1;
      }
      $i++;  /* desplazar al punto y coma o a la coma */
	  $j=0;  /* reiniciar la subcadena */
	}
  }
  
  if ($b==0)  /* no hubo resultados */
  {
    $nodo    =  $doc->createElement("marcador");
    $newnodo =  $nodo_padre->appendChild($nodo);
    $newnodo -> setAttribute("id", "0");
	$newnodo -> setAttribute("nombre", "No existen sitios en esta categoría");
    $newnodo -> setAttribute("lat", "16.75352");
    $newnodo -> setAttribute("lng", "-93.116292");	
  }  
   
  // establece la salida de texto como xml
  header("Content-type: text/xml");
  // imprime el documento
  echo $doc->saveXML();
?>
