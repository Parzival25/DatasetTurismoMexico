var map;
	var markersArray = []; /* marcadores */
	
		
	var bmm=0;   // bandera men� mapas oculto por omisi�n
	var bmc=0;   // bandera men� categor�as oculto por omisi�n
    
	var bs=0;   // para verificar si hubo sitios en ambas bases de datos para la categor�a seis
	
	function inicio()
	{
      var centro_chiapas = new google.maps.LatLng(15.403045, -92.657028);
      var myOptions = { zoom: 12, 
	                    center: centro_chiapas, 
					    mapTypeControl: true,  
					    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					    zoomControl: true,
					    zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL, position: google.maps.ControlPosition.RIGHT_TOP},
						panControl: true,
                        panControlOptions: {position: google.maps.ControlPosition.RIGHT_TOP},
					    mapTypeId: google.maps.MapTypeId.ROADMAP
					  }
      map = new google.maps.Map(document.getElementById("mapa"),myOptions);
	  
	  // L�neas para definifir la activaci�n del men� de la izquierda, mapas
      var div_menu_mapas = document.createElement('DIV');
      var control_menu_mapas = new control_personalizado_mapas(div_menu_mapas, map);
      div_menu_mapas.index = 1;
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(div_menu_mapas);
	  
	  // L�neas para definifir la activaci�n del men� de la izquierda, categor�as
      var div_menu_categorias = document.createElement('DIV');
      var control_menu_categorias = new control_personalizado_categorias(div_menu_categorias, map);
      div_menu_categorias.index = 1;
      map.controls[google.maps.ControlPosition.LEFT_TOP].push(div_menu_categorias);
/*
	  // L�neas para definifir la activaci�n del men� de la izquierda abajo, tuxmapa
      var div_menu_pietuxmapa = document.createElement('DIV');
      var control_menu_pietuxmapa = new control_personalizado_pietuxmapa(div_menu_pietuxmapa, map);
      div_menu_pietuxmapa.index = 1;
      map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(div_menu_pietuxmapa);
	  */
	  	   // controles sobre el mapa
	  var div_mapas = document.createElement('DIV');
	  $(div_mapas).addClass().html
	   (
	    '<div class="menu_simple" id="id_menu_mapas">'+
          '<ul class="menu_simple">'+
		  
	        '<li class="menu_simple"> <a class="menu_simple" href="index.php"> <img src="imagenes/home.png" width="40" height="40" title="Inico"/></a></li>'+
	        
            ' <!--<li class="menu_simple"> <a class="menu_simple" href="#mimodal"><img src="imagenes/buscar.png" width="50" height="50" title="Search"/></a></li> -->'+	  
	        
            '<li class="menu_simple"> <a class="menu_simple" href="galery/"> <img src="imagenes/camara.png" width="50" height="50" title="Galeria"/></a></li>'+
            
			'<li class="menu_simple"> <a class="menu_simple" href="acacoyagua/"> <img src="imagenes/obelisco.png" width="40" height="50" title=" Turismo Acacoyagua"/></a></li>'+	
		 
			'<li class="menu_simple"> <a class="menu_simple" href="#nosotros" data-toggle="modal"> <img src="imagenes/team.png" width="50" height="40" title="Colaboradores"/></a></li>'+
			
			'<li class="menu_simple"> <a class="menu_simple" href="#turismo" data-toggle="modal"> <img src="imagenes/logotipo.png" width="40" height="40" title="Tur&iacute;smo Acacoyagua"/></a></li>'+
			
			'<li class="menu_simple"> <a class="menu_simple" href="#paginas" data-toggle="modal"> <img src="imagenes/paginas.png" width="50" height="40" title="Paginas Recomendadas"/></a></li>'+
		  
		  '</ul>'+
		'</div>' 	
      );
	  map.controls[google.maps.ControlPosition.TOP_CENTER].push(div_mapas);
	
	// men� nivel 1 de categorias 
	  var div_categorias = document.createElement('DIV');
	  $(div_categorias).addClass().html
	  (
        '<div class="menu_vertical_170" id="id_menu_categorias">'+
          '<ul class="menu_vertical">'+		    
			'<li onmouseover="desplegar(&#39id_menu_esparcimiento&#39)" onmouseout="ocultar(&#39id_menu_esparcimiento&#39)"><a class="menu_vertical">Esparcimiento</a>'+
              '<div class="menu_vertical_170_nivel_2" id="id_menu_esparcimiento">'+
			    '<a onclick="marcadores_C1(1)" class="menu_vertical" href="#"><p><b>Esparcimiento</b></p></a>'+'<hr />'+
                '<ul class="menu_vertical">'+
				  '<li onclick="marcadores_c2(1,1)"><a class="menu_vertical" href="#">Balneario</a></li>'+
                  '<li onclick="marcadores_c2(2,1)"><a class="menu_vertical" href="#">Ba&ntilde;os/Nadar</a></li>'+
				  '<li onclick="marcadores_c2(3,1)"><a class="menu_vertical" href="#">Caminatas/Expediciones</a></li>'+
				  '<li onclick="marcadores_c2(4,1)"><a class="menu_vertical" href="#">Cicloturismo</a></li>'+
				  '<li onclick="marcadores_c2(5,1)"><a class="menu_vertical" href="#">Circuitos/Expediciones</a></li>'+
				  '<li onclick="marcadores_c2(6,1)"><a class="menu_vertical" href="#">Fotograf&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2(7,1)"><a class="menu_vertical" href="#">Juegos</a></li>'+
				  '<li onclick="marcadores_c2(8,1)"><a class="menu_vertical" href="#">Observaci&oacute;n de flora y fauna</a></li>'+
				  '<li onclick="marcadores_c2(9,1)"><a class="menu_vertical" href="#">Paseos a caballo</a></li>'+
				  '<li onclick="marcadores_c2(10,1)"><a class="menu_vertical" href="#">Picnic</a></li>'+
				  '<li onclick="marcadores_c2(84,1)"><a class="menu_vertical" href="#">Recorrido en lancha</a></li>'+
				  '<li onclick="marcadores_c2(98,1)"><a class="menu_vertical" href="#">Parques p&uacute;blicos</a></li>'+
				  '<li onclick="marcadores_c2(99,1)"><a class="menu_vertical" href="#">Plaza comercial</a></li>'+
				  '<li onclick="marcadores_c2(103,1)"><a class="menu_vertical" href="#">Zoo</a></li>'+			
                  '<li onclick="marcadores_c2(112,1)"><a class="menu_vertical" href="#">Miradores</a></li>'+				  
                '</ul>'+
              '</div>'+
	        '</li>'+            
			
			'<li onmouseover="desplegar(&#39id_menu_deportivas&#39)" onmouseout="ocultar(&#39id_menu_deportivas&#39)"><a class="menu_vertical">Deportivas</a>'+
              '<div class="menu_vertical_170_nivel_2" id="id_menu_deportivas">'+
                '<a onclick="marcadores_C1(2)" class="menu_vertical" href="#"><p><b>Deportivas</b></p></a>'+'<hr />'+			    
                '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2(11,2)"><a class="menu_vertical" href="#">Alas deltas</a></li>'+
                  '<li onclick="marcadores_c2(12,2)"><a class="menu_vertical" href="#">Alta monta&ntildea</a></li>'+
				  '<li onclick="marcadores_c2(13,2)"><a class="menu_vertical" href="#">Bicliceta de monta&ntildea</a></li>'+
				  '<li onclick="marcadores_c2(14,2)"><a class="menu_vertical" href="#">Buceo</a></li>'+
				  '<li onclick="marcadores_c2(15,2)"><a class="menu_vertical" href="#">Cabalgata</a></li>'+
				  '<li onclick="marcadores_c2(16,2)"><a class="menu_vertical" href="#">Canoa</a></li>'+
				  '<li onclick="marcadores_c2(17,2)"><a class="menu_vertical" href="#">Decenso en r&iacute;os/Rafting</a></li>'+
				  '<li onclick="marcadores_c2(18,2)"><a class="menu_vertical" href="#">Escalada libre</a></li>'+
				  '<li onclick="marcadores_c2(19,2)"><a class="menu_vertical" href="#">Escalamiento</a></li>'+
				  '<li onclick="marcadores_c2(20,2)"><a class="menu_vertical" href="#">Esqu&iacute; acu&aacute;tico</a></li>'+
				  '<li onclick="marcadores_c2(21,2)"><a class="menu_vertical" href="#">Futbol</a></li>'+
				  '<li onclick="marcadores_c2(22,2)"><a class="menu_vertical" href="#">Globo aereoest&aacute;tico</a></li>'+
				  '<li onclick="marcadores_c2(23,2)"><a class="menu_vertical" href="#">Golf</a></li>'+
				  '<li onclick="marcadores_c2(24,2)"><a class="menu_vertical" href="#">Hidrotorneo</a></li>'+
				  '<li onclick="marcadores_c2(25,2)"><a class="menu_vertical" href="#">Kayak</a></li>'+
				  '<li onclick="marcadores_c2(26,2)"><a class="menu_vertical" href="#">Monta&ntildeismo/Hikking</a></li>'+
				  '<li onclick="marcadores_c2(27,2)"><a class="menu_vertical" href="#">Paraca&iacute;das</a></li>'+
				  '<li onclick="marcadores_c2(28,2)"><a class="menu_vertical" href="#">Parasailing</a></li>'+
				  '<li onclick="marcadores_c2(29,2)"><a class="menu_vertical" href="#">Pesca deportiva</a></li>'+
				  '<li onclick="marcadores_c2(30,2)"><a class="menu_vertical" href="#">Rapel</a></li>'+
				  '<li onclick="marcadores_c2(31,2)"><a class="menu_vertical" href="#">Remo</a></li>'+
				  '<li onclick="marcadores_c2(32,2)"><a class="menu_vertical" href="#">Sandboard</a></li>'+
				  '<li onclick="marcadores_c2(33,2)"><a class="menu_vertical" href="#">Senderesmio/Trekking</a></li>'+
				  '<li onclick="marcadores_c2(34,2)"><a class="menu_vertical" href="#">Sky</a></li>'+
				  '<li onclick="marcadores_c2(35,2)"><a class="menu_vertical" href="#">Snowboard</a></li>'+
				  '<li onclick="marcadores_c2(36,2)"><a class="menu_vertical" href="#">Surf</a></li>'+
				  '<li onclick="marcadores_c2(37,2)"><a class="menu_vertical" href="#">Tenis</a></li>'+
				  '<li onclick="marcadores_c2(38,2)"><a class="menu_vertical" href="#">Tirolesa</a></li>'+
				  '<li onclick="marcadores_c2(39,2)"><a class="menu_vertical" href="#">Todo terreno/Raid 4x4</a></li>'+
				  '<li onclick="marcadores_c2(40,2)"><a class="menu_vertical" href="#">Vela</a></li>'+
				  '<li onclick="marcadores_c2(41,2)"><a class="menu_vertical" href="#">Velero, Windsurf</a></li>'+
                '</ul>'+
              '</div>'+
	        '</li>'+					
			
			'<li onmouseover="desplegar(&#39id_menu_natural&#39)" onmouseout="ocultar(&#39id_menu_natural&#39)"><a class="menu_vertical">Ambiente Natural</a>'+
		 	  '<div class="menu_vertical_170_nivel_2" id="id_menu_natural">'+
			    '<a onclick="marcadores_C1(3)" class="menu_vertical" href="#"><p><b>Ambiente Natural</b></p></a>'+'<hr />'+
                '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2(42,3)"><a class="menu_vertical" href="#">Cascadas</a></li>'+
				  '<li onclick="marcadores_c2(43,3)"><a class="menu_vertical" href="#">Monta&ntilde;as y volcanes</a></li>'+
                  '<li onclick="marcadores_c2(44,3)"><a class="menu_vertical" href="#">Valles</a></li>'+
				  '<li onclick="marcadores_c2(45,3)"><a class="menu_vertical" href="#">Oasis</a></li>'+
				  '<li onclick="marcadores_c2(46,3)"><a class="menu_vertical" href="#">Lagos y lagunas</a></li>'+
				  '<li onclick="marcadores_c2(47,3)"><a class="menu_vertical" href="#">R&iacute;os y esteros</a></li>'+
				  '<li onclick="marcadores_c2(48,3)"><a class="menu_vertical" href="#">Costas, playas</a></li>'+
				  '<li onclick="marcadores_c2(49,3)"><a class="menu_vertical" href="#">Selva</a></li>'+
				  '<li onclick="marcadores_c2(50,3)"><a class="menu_vertical" href="#">Bosque</a></li>'+
				  '<li onclick="marcadores_c2(51,3)"><a class="menu_vertical" href="#">Desierto</a></li>'+
				  '<li onclick="marcadores_c2(52,3)"><a class="menu_vertical" href="#">Contemplaci&oacute;n del paisaje</a></li>'+
				  '<li onclick="marcadores_c2(53,3)"><a class="menu_vertical" href="#">Observaci&oacute;n de flora</a></li>'+
				  '<li onclick="marcadores_c2(54,3)"><a class="menu_vertical" href="#">Observaci&oacute;n de fauna</a></li>'+
				  '<li onclick="marcadores_c2(55,3)"><a class="menu_vertical" href="#">Termalismo</a></li>'+
				  '<li onclick="marcadores_c2(56,3)"><a class="menu_vertical" href="#">Turismo de aventura</a></li>'+
				  '<li onclick="marcadores_c2(57,3)"><a class="menu_vertical" href="#">Visita a exposiciones</a></li>'+
				  '<li onclick="marcadores_c2(58,3)"><a class="menu_vertical" href="#">Zool&oacute;gicos</a></li>'+
				  '<li onclick="marcadores_c2(59,3)"><a class="menu_vertical" href="#">Espeolog&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2(60,3)"><a class="menu_vertical" href="#">Ecoturismo</a></li>'+
				  '<li onclick="marcadores_c2(85,3)"><a class="menu_vertical" href="#">Ca&ntilde;ones</a></li>'+
				  '<li onclick="marcadores_c2(88,3)"><a class="menu_vertical" href="#">Cenotes</a></li>'+
				  '<li onclick="marcadores_c2(92,3)"><a class="menu_vertical" href="#">Centros ecotur&iacute;sticos</a></li>'+
                '</ul>'+
              '</div>'+
	        '</li>'+
			
			'<li onmouseover="desplegar(&#39id_menu_cultural&#39)" onmouseout="ocultar(&#39id_menu_cultural&#39)"><a class="menu_vertical">Hist&oacute;rico Cultural</a>'+
              '<div class="menu_vertical_170_nivel_2" id="id_menu_cultural">'+
			    '<a onclick="marcadores_c1(4)" class="menu_vertical" href="#"><p><b>Patrimonio Hist&oacute;rico Cultural</b></p></a>'+'<hr />'+
                '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2(61,4)"><a class="menu_vertical" href="#">Arqueol&oacute;gicos</a></li>'+
				  '<li onclick="marcadores_c2(62,4)"><a class="menu_vertical" href="#">Artesan&iacute;a</a></li>'+
                  '<li onclick="marcadores_c2(63,4)"><a class="menu_vertical" href="#">Etnoturismo</a></li>'+
				  '<li onclick="marcadores_c2(64,4)"><a class="menu_vertical" href="#">Gastronom&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2(65,4)"><a class="menu_vertical" href="#">Hist&oacute;ricos</a></li>'+
				  '<li onclick="marcadores_c2(83,4)"><a class="menu_vertical" href="#">Museos, centros culturales</a></li>'+
				  '<li onclick="marcadores_c2(86,4)"><a class="menu_vertical" href="#">Iglesias</a></li>'+
				  '<li onclick="marcadores_c2(87,4)"><a class="menu_vertical" href="#">Monumentos</a></li>'+
				  '<li onclick="marcadores_c2(91,4)"><a class="menu_vertical" href="#">Ciudad Colonial</a></li>'+
				  '<li onclick="marcadores_c2(96,4)"><a class="menu_vertical" href="#">Ciudad +50,000 habitantes</a></li>'+
				  '<li onclick="marcadores_c2(97,4)"><a class="menu_vertical" href="#">Ciudad rural sustentable</a></li>'+
				  '<li onclick="marcadores_c2(102,4)"><a class="menu_vertical" href="#">Teatros</a></li>'+			
                '</ul>'+
              '</div>'+
	        '</li>'+

			'<li onmouseover="desplegar(&#39id_menu_produccion&#39)" onmouseout="ocultar(&#39id_menu_produccion&#39)"><a class="menu_vertical">Producci&oacute;n</a>'+
	          '<div class="menu_vertical_170_nivel_2" id="id_menu_produccion">'+
			    '<a onclick="marcadores_c1(5)" class="menu_vertical" href="#"><p><b>Actividades vinculadas a la Producci&oacute;n</b></p></a>'+'<hr />'+
			    '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2(66,5)"><a class="menu_vertical" href="#">Agroturismo</a></li>'+
				  '<li onclick="marcadores_c2(67,5)"><a class="menu_vertical" href="#">Empresas forestales</a></li>'+
                  '<li onclick="marcadores_c2(68,5)"><a class="menu_vertical" href="#">Industria diversa</a></li>'+
				  '<li onclick="marcadores_c2(69,5)"><a class="menu_vertical" href="#">Miner&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2(89,5)"><a class="menu_vertical" href="#">Centro de convenciones</a></li>'+
				  '<li onclick="marcadores_c2(90,5)"><a class="menu_vertical" href="#">F&oacute;rum</a></li>'+
				  '<li onclick="marcadores_c2(100,5)"><a class="menu_vertical" href="#">Presas hidroel&eacute;ctricas</a></li>'+
				  '<li onclick="marcadores_c2(101,5)"><a class="menu_vertical" href="#">Puertos mar&iacute;timos</a></li>'+				 
                '</ul>'+
              '</div>'+
	        '</li>'+		
					
			'<li onmouseover="desplegar(&#39id_menu_eventos&#39)" onmouseout="ocultar(&#39id_menu_eventos&#39)"><a class="menu_vertical">Eventos programados</a>'+
			  '<div class="menu_vertical_170_nivel_2" id="id_menu_eventos">'+
			    '<a onclick="marcadores_c1(6)" class="menu_vertical" href="#"><p><b>Eventos programados</b></p></a>'+'<hr />'+
				'<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2_6(70,6)"><a class="menu_vertical" href="#">Congresos y seminarios</a></li>'+
				  '<li onclick="marcadores_c2_6(71,6)"><a class="menu_vertical" href="#">Eventos cient&iacute;ficos</a></li>'+
                  '<li onclick="marcadores_c2_6(72,6)"><a class="menu_vertical" href="#">Eventos culturales</a></li>'+
				  '<li onclick="marcadores_c2_6(73,6)"><a class="menu_vertical" href="#">Eventos deportivos</a></li>'+
				  '<li onclick="marcadores_c2_6(74,6)"><a class="menu_vertical" href="#">Eventos gastron&oacute;micos</a></li>'+
				  '<li onclick="marcadores_c2_6(75,6)"><a class="menu_vertical" href="#">Fiestas artesanales</a></li>'+
				  '<li onclick="marcadores_c2_6(76,6)"><a class="menu_vertical" href="#">Ferias industriales</a></li>'+
				  '<li onclick="marcadores_c2_6(77,6)"><a class="menu_vertical" href="#">Festivales de cine</a></li>'+
				  '<li onclick="marcadores_c2_6(78,6)"><a class="menu_vertical" href="#">Festivales de m&uacute;sica</a></li>'+
				  '<li onclick="marcadores_c2_6(79,6)"><a class="menu_vertical" href="#">Festivales de rock</a></li>'+
				  '<li onclick="marcadores_c2_6(80,6)"><a class="menu_vertical" href="#">Festivales folkl&oacute;ricos</a></li>'+
				  '<li onclick="marcadores_c2_6(81,6)"><a class="menu_vertical" href="#">Manifestaciones religiosas</a></li>'+
				  '<li onclick="marcadores_c2_6(82,6)"><a class="menu_vertical" href="#">&Oacute;pera, ballet</a></li>'+
				  '<li onclick="marcadores_c2_6(93,6)"><a class="menu_vertical" href="#">Ferias ganaderas</a></li>'+
				  '<li onclick="marcadores_c2_6(94,6)"><a class="menu_vertical" href="#"><i>Spring break</i></a></li>'+
				  '<li onclick="marcadores_c2_6(95,6)"><a class="menu_vertical" href="#">Fiesta popular</a></li>'+
                '</ul>'+
              '</div>'+
	        '</li>'+
			
			'<li onmouseover="desplegar(&#39id_menu_infraestructura&#39)" onmouseout="ocultar(&#39id_menu_infraestructura&#39)"><a class="menu_vertical">Infraestructura</a>'+
              '<div class="menu_vertical_170_nivel_2" id="id_menu_infraestructura">'+
			    '<a onclick="marcadores_c1(7)" class="menu_vertical" href="#"><p><b>Infraestructura</b></p></a>'+'<hr />'+
			    '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2(104,7)"><a class="menu_vertical" href="#">Distribuidores viales</a></li>'+
				  '<li onclick="marcadores_c2(105,7)"><a class="menu_vertical" href="#">Hospitales</a></li>'+
                  '<li onclick="marcadores_c2(106,7)"><a class="menu_vertical" href="#">Gasoliner&iacute;as</a></li>'+
				  '<li onclick="marcadores_c2(107,7)"><a class="menu_vertical" href="#">Parque central</a></li>'+
				  '<li onclick="marcadores_c2(108,7)"><a class="menu_vertical" href="#">Oficinas de gobierno</a></li>'+
				  '<li onclick="marcadores_c2(109,7)"><a class="menu_vertical" href="#">Parques deportivos</a></li>'+
				  '<li onclick="marcadores_c2(110,7)"><a class="menu_vertical" href="#">Plaza de toros</a></li>'+
				  '<li onclick="marcadores_c2(111,7)"><a class="menu_vertical" href="#">Central camionera</a></li>'+
				  '<li onclick="marcadores_c2(113,7)"><a class="menu_vertical" href="#">Cruz roja</a></li>'+
				  '<li onclick="marcadores_c2(114,7)"><a class="menu_vertical" href="#">Bomberos</a></li>'+
				  '<li onclick="marcadores_c2(115,7)"><a class="menu_vertical" href="#">Polic&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2(116,7)"><a class="menu_vertical" href="#">Bancos</a></li>'+
				  '<li onclick="marcadores_c2(117,7)"><a class="menu_vertical" href="#">Casas de cambio</a></li>'+
				  '<li onclick="marcadores_c2(118,7)"><a class="menu_vertical" href="#">Oficinas de correos</a></li>'+
				  '<li onclick="marcadores_c2(119,7)"><a class="menu_vertical" href="#">Aereopuertos</a></li>'+
				  '<li onclick="marcadores_c2(120,7)"><a class="menu_vertical" href="#">Taxis</a></li>'+
				  '<li onclick="marcadores_c2(121,7)"><a class="menu_vertical" href="#">Ferrocarril</a></li>'+
				  '<li onclick="marcadores_c2(122,7)"><a class="menu_vertical" href="#">Embarcadero</a></li>'+
				  '<li onclick="marcadores_c2(123,7)"><a class="menu_vertical" href="#">Mercados</a></li>'+
				  '<li onclick="marcadores_c2(124,7)"><a class="menu_vertical" href="#">Hoteles</a></li>'+
				  '<li onclick="marcadores_c2(125,7)"><a class="menu_vertical" href="#">Restaurantes</a></li>'+
                '</ul>'+
              '</div>'+
	        '</li>'+         	  
		  '</ul>'+
        '</div>'
      );
	  map.controls[google.maps.ControlPosition.LEFT_TOP].push(div_categorias);
	  
	  

	   
	  marcadores();
	  marcadores_temporales();
	  }
	  
 	
	function marcadores() //funcion para mostrar los iconos de la pantalla principal sin categorias
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
	function marcadores_temporales() //funcion para solo los atomos temporales
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
	function marcadores_1() //funcion para Actividades de ESPARCIMIENTO
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
      xmlhttp.open("GET","xml/marcadores_1.xml",false);
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
	function marcadores_2() //funcion para Actividades DEPORTIVAS
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
      xmlhttp.open("GET","xml/marcadores_2.xml",false);
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
	function marcadores_3() //funcion para Actividades VINCULADAS AL AMBIENTE NATURAL
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
      xmlhttp.open("GET","xml/marcadores_3.xml",false);
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
	function marcadores_4() //funcion para Actividades VINCULADAS AL PATRIMONIO HIST�RICO-CULTURAL
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
      xmlhttp.open("GET","xml/marcadores_4.xml",false);
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
	/*
	function marcadores_5() //funcion para Actividades VINCULADAS A LA PRODUCCI�N sera 
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
      xmlhttp.open("GET","xml/marcadores_5.xml",false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen = 'imagenes/ic15.png';
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
	*/
	function marcadores_6() //funcion para Actividades de ASISTENCIA A EVENTOS PROGRAMADOS
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
      xmlhttp.open("GET","xml/marcadores_6.xml",false);
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
		infoMarkers(marker, id);
        markersArray.push(marker);
	  }
    	
      // cargar los temporales		
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","xml/marcadores_temporales_6.xml",false);
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
	
	function marcadores_7() //funcion para Infraestructura
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
      xmlhttp.open("GET","xml/marcadores_7.xml",false);
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
		infoMarkers(marker, id);
        markersArray.push(marker);
	  }
    }
	
	function marcadores_c2(c2,icono) 
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
	function marcadores_c2_6(c2,icono) 
	{
	  borrar_mapa();
	  
	  marcadores_c2_6_temporales(c2,icono);	 
	  marcadores_c2_6_permanentes(c2,icono);
	}
	
	function marcadores_c2_6_permanentes(c2,icono) 
	{
	  // �tomos permanentes
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.open("GET","php/genera_xml_marcadores_c2_6_1.php?q="+c2,false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen;
	  var lat, lng;
	  
	  x=xmlDoc.getElementsByTagName("marcador");
	  
	  /* verifica si hay sitios */
	  if ((x[0].getAttribute("id") == "0") && (bs==0))    // en las dos bases de datos no hay sitios
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
	  
	  if (x[0].getAttribute("id") != "0") 
	  {
	     imagen='imagenes/ic1'+icono+'.png';
	  
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
      bs=0;  // bandera se reactiva a cero para la siguiente llamada	  
	}	  
    
	
	function marcadores_c2_6_temporales(c2,icono) 
	{
	  // �tomos temporales
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
	  xmlhttp.open("GET","php/genera_xml_marcadores_c2_6_2.php?q="+c2,false);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen='imagenes/geo_temporal.png';;
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
	  
	  /* verifica si hay sitios */
	  if (x[0].getAttribute("id") != "0")  // hay sitios
	  {
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
		 bs=1;
      }
	}  
	//funcion para posicionar los iconos por la busqueda
	function buscador(x) 
	{
	borrar_mapa();
	  // �tomos temporales
	  if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
	  xmlhttp.open("GET","search2/xml.php?q="+x);
      xmlhttp.send();
      xmlDoc=xmlhttp.responseXML;
	  
	  // tranferir datos del xml de marcadores a variables para el mapa
	  var imagen='imagenes/geo_temporal.png';;
	  var lat, lng;
	  x=xmlDoc.getElementsByTagName("marcador");
	  
	  /* verifica si hay sitios */
	  if (x[0].getAttribute("id") != "0")  // hay sitios
	  {
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
		 bs=1;
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
	
	function cargar_ficha_team()
    {
      $.fancybox.open({href : 'team.html', type : 'iframe'});  
    }
	
	function control_personalizado_mapas(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relaci�n al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = '';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '0px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver las opciones sobre el mapa de Tuxtla Guti�rrez';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = '<img src="imagenes/opcion.png" title="Opciones" width="30" height="30" />';
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
			controlUI.style.backgroundColor = '';
		  }
		}
      ); 		
    }
	
		  
	  function control_personalizado_categorias(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relaci�n al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = '';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '0px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver menu';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = '<img src="imagenes/categorias.png" title="Click para ver menu de categor&iacute;as" width="100" height="30" />';
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
			controlUI.style.backgroundColor = '';
		  }
		}
	  );
    }
	/*
	function control_personalizado_pietuxmapa(controlDiv, map)  
    {
      controlDiv.style.padding = '5px'; // distancia del control con relaci�n al borde del mapa

      // Set CSS for the control border
      var controlUI = document.createElement('DIV');
      controlUI.style.backgroundColor = 'white';
      controlUI.style.borderStyle = 'solid';
      controlUI.style.borderWidth = '2px';
      controlUI.style.cursor = 'pointer';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click para ver men� de pie de p�gina TuxMapa';
      controlDiv.appendChild(controlUI);

      // Set CSS for the control interior
      var controlText = document.createElement('DIV');
      controlText.style.fontFamily = 'Arial,sans-serif';
      controlText.style.fontSize = '12px';
      controlText.style.paddingLeft = '4px';
      controlText.style.paddingRight = '4px';
      controlText.innerHTML = '<img src="img/ficha.png" title="Que es Turismo Acacoyagua" width="30" height="30" />';
      controlUI.appendChild(controlText);

      // Setup the click event listeners: simply set the map to Chicago
      google.maps.event.addDomListener(controlUI, 'click', function() {cargar_ficha_tuxmapa()});
    }
	
	*/
	