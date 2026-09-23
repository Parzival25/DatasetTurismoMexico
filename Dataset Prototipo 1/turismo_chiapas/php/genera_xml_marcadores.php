<?php

// se consulta la base de datos de sitios tur�sticos para generar los campos necesarios para despliegue en el mapa
$con=mysqli_connect("localhost", "root", "1234", "Prototipo1");
 //Se selecciona la tabla
 
//Se realiza un recorrido por los 128 tipos de clasificacion de C2
  

  //Como el resultado se va leyendo linea por linea de la tabla, tenemos que hacer una llamada a la tabla en cada ocacion
  $resultado = mysqli_query($con, "Select * from atomos");

  //Se crea la instancia del documento y se utiliza UTF-8 para no saltar warning de acentos  Ñ
  $xml = new DOMDocument("1.0","UTF-8");

  //Se crea el nodo principal
  $nodo = $xml ->createElement("marcadores");

  //Se le añaden los nodos hijos
  $nodo_padre = $xml ->appendChild($nodo);

 //Se recorre la tabla de resultados leyendo linea por linea
  while($row=mysqli_fetch_array($resultado)){

    if($row['A_ACTIVO']==1){
      if($row['A_NUMERO_ORIGINAL']!=0){
        $nodo    =  $xml->createElement("marcador");
            $newnodo =  $nodo_padre->appendChild($nodo);
            $newnodo -> setAttribute("id", utf8_encode($row['A_ID']));
            $newnodo -> setAttribute("nombre", utf8_encode($row['A_NOMBRE']));
            $newnodo -> setAttribute("lat",utf8_encode($row['A_LATITUD']));
            $newnodo -> setAttribute("lng", utf8_encode($row['A_LONGITUD']));
            $newnodo -> setAttribute("or", utf8_encode($row['A_ORIGEN']));     
            $newnodo -> setAttribute("numOr", utf8_encode($row['A_NUMERO_ORIGINAL']));  
      }
    }
          

    
  }
  //Se guarda los cambios a la instancia del archivo
  echo "<xmp>".$xml->saveXML()."</xmp>";

  //Se guarda el documento cambiando el nombre dependiendo en que posicion del for nos encontremos
  $xml->save("Marcadores.xml");

?>
