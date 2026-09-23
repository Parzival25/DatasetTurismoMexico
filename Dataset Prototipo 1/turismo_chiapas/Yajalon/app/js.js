var markersArray = []; /* marcadores */

function marcadores_c2(c2,icono) 
	{
		console.log(c2);
		console.log(icono);
		
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","php/genera_xml_marcadores_c2.php?q="+c2,false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic1'+icono+'.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
	  
	  /* verifica si hay sitios */
	  if (x[0].getAttribute("id") == "0")
	  {
	    imagen = 'imagenes/no_hay.png';
		id = x[0].getAttribute("id");
	    lat = parseFloat(x[0].getAttribute("lat"));
        lng = parseFloat(x[0].getAttribute("lng"));
		nombre = x[0].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		markersArray.push(marker);
		return;
	  }
	  
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		infoMarkers(marker, id);
        markersArray.push(marker);
	  }
    }

    function infoMarkers(markers, address)
    {
      google.maps.event.addListener(markers, 'click', function() 
	  {
	    $.fancybox.open({href : 'atomos/'+address+'.html', type : 'iframe'});
	  });
    }

    // Deletes all markers in the array by removing references to them
    function borrar_mapa() 
	{
      if (markersArray) 
	  {
        for (i in markersArray) 
		{
          markersArray[i].setMap(null);
        }
        markersArray.length = 0;
      }
    }