    var map;
	var markersArray = []; /* marcadores */
	
		
	var bmm=0;   // bandera menú mapas oculto por omisión
	var bmc=0;   // bandera menú categorías oculto por omisión
    
	var bs=0;   // para verificar si hubo sitios en ambas bases de datos para la categoría seis
	
	function inicio()
	{
      var centro_palenque = new google.maps.LatLng(17.508852,-91.981080);
      var myOptions = { zoom: 15, 
	                    center: centro_palenque, 
					    mapTypeControl: true,  
					    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					    zoomControl: true,
					    zoomControlOptions: {style: google.maps.ZoomControlStyle.LARGE, position: google.maps.ControlPosition.RIGHT_CENTER},
						panControl: true,
                        panControlOptions: {position: google.maps.ControlPosition.RIGHT_TOP},
					    mapTypeId: google.maps.MapTypeId.ROADMAP
					  }
      map = new google.maps.Map(document.getElementById("mapa"),myOptions);  
	  
	  marcadores();
	  marcadores_temporales();
	  marcadores_servicios();
    }
	
	function marcadores() 
	{
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/marcadores.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/geo.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function marcadores_temporales() 
	{
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/marcadores_temporales.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/geo_temporal.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		infoMarkers_temporal(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function marcadores_servicios() 
	{
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/marcadores_servicios.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/geo_servicios.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		//infoMarkers(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function bellezas_naturales() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/bellezas_naturales.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic13.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function balnearios() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/balnearios.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic11.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function museos() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/museos.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic14.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function historico() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/historico.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic14.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function andador() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/andador.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic12.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function servicios() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/servicios.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic17.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		//infoMarkers(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function feria() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/feria.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic16.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		infoMarkers_temporal(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function expoferia() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/expoferia.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic16.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
      for(i=0;i<x.length;i++)
      {
	    id = x[i].getAttribute("id");
	    lat = parseFloat(x[i].getAttribute("lat"));
        lng = parseFloat(x[i].getAttribute("lng"));
		nombre = x[i].getAttribute("nombre");
	    var location = new google.maps.LatLng(lat, lng);
        marker = new google.maps.Marker( {position:location, map:map, icon:imagen, title:nombre } );
		infoMarkers_temporal(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function buscar() 
	{
	  borrar_mapa();
	  
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","php/xml.php",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic12.png';
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
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
	
	function infoMarkers_temporal(markers, address)
    {
      google.maps.event.addListener(markers, 'click', function() 
	  {
	    $.fancybox.open({href : 'atomos_temporales/at'+address+'.html', type : 'iframe'});
	  });
    }
	 // controles personalizados sobre el mapa	
	function control_personalizado_mapas(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relación al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver las opciones sobre el mapa de Palenque';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = 'Opciones';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: 
      google.maps.event.addDomListener(controlUI, 'click', 
	    function() 
		{  
		  if (bmm==0) 
		  { 
		    document.getElementById("id_menu_mapas").style.visibility="visible";
			bmm=1;
			controlUI.style.backgroundColor = 'lightgreen';
		  }	
		  else
		  {
		    document.getElementById("id_menu_mapas").style.visibility="hidden";
			bmm=0;
			controlUI.style.backgroundColor = 'white';
		  }
		}
      ); 		
    }
	
	function cargar_historia()
    {
      $.fancybox.open({href : 'información/Historia_Palenque.htm', type : 'iframe'});
    }
	
	function cargar_estadisticas()
    {
      $.fancybox.open({href : 'información/estadistica.htm', type : 'iframe'});
    }
	
	function control_personalizado_categorias(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relación al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver menú de categorias';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = 'Categorías';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: simply set the map to Chicago
      google.maps.event.addDomListener(controlUI, 'click', 
	    function() 
		{
		  if (bmc==0) 
		  { 
		    document.getElementById("id_menu_categorias").style.visibility="visible";
			bmc=1;
			controlUI.style.backgroundColor = 'lightgreen';
		  }	
		  else
		  {
		    document.getElementById("id_menu_categorias").style.visibility="hidden";
			bmc=0;
			controlUI.style.backgroundColor = 'white';
		  }
		}
	  );
    }
	
	function desplegar_mapa() 
	{
      if (markersArray) 
	  {
        for (i in markersArray) 
		{
          markersArray[i].setMap(map);
        }
      }
    }
	
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
	
	function limpiar_mapa() 
    {
      if (markersArray) 
	  {
        for (i in markersArray) 
		{
          markersArray[i].setMap(null);
        }
      } 
    }
	  function control_personalizado_pietuxmapa(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relación al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver menú de pie de página GeoPalenque';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = 'GeoPalenque';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: simply set the map to Chicago
      google.maps.event.addDomListener(controlUI, 'click', function() {cargar_ficha_tuxmapa()});
    }
	
	function cargar_ficha_tuxmapa()
    {
      $.fancybox.open({href : 'información/ficha_palenque.htm', type : 'iframe'});  
    }
	
	function cargar_personajes()
    {
      $.fancybox.open({href : 'información/ficha_tecnica.htm', type : 'iframe'});  
    }
	
	function historia_arqueologica()
    {
      $j.fancybox.open({href : 'información/historia_zona.htm', type : 'iframe'});  
    }
	
	function estructuras()
    {
      $j.fancybox.open({href : 'información/estructuras.htm', type : 'iframe'});  
    }
	
	function cargar_ficha_tuxmapa_dos()
    {
      $j.fancybox.open({href : 'información/ficha_palenque.htm', type : 'iframe'});  
    }
	
	function cargar_personajes_dos()
    {
      $j.fancybox.open({href : 'información/ficha_tecnica.htm', type : 'iframe'});  
    }
	
	function cargar_estadisticas_dos()
    {
      $j.fancybox.open({href : 'información/estadistica.htm', type : 'iframe'});
    }
	
	function infor()
    {
      $j.fancybox.open({href : 'información/infor.html', type : 'iframe'});
    }