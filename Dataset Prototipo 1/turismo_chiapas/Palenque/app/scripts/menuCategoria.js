 var div_menu_categorias = document.createElement('DIV');
      var control_menu_categorias = new control_personalizado_categorias(div_menu_categorias, map);
      div_menu_categorias.index = 1;
      map.controls[google.maps.ControlPosition.LEFT_TOP].push(div_menu_categorias);
 
 var div_categorias = document.createElement('DIV');
	  $(div_categorias).addClass().html
	  (
        '<div class="menu_vertical_170" id="id_menu_categorias">'+
          '<ul class="menu_vertical">'+		    
			'<li onmouseover="desplegar(&#39id_menu_esparcimiento&#39)" onmouseout="ocultar(&#39id_menu_esparcimiento&#39)"><a class="menu_vertical">Esparcimiento</a>'+
              '<div class="menu_vertical_170_nivel_2" id="id_menu_esparcimiento">'+
			    '<a onclick="marcadores_1()" class="menu_vertical" href="#"><p><b>Esparcimiento</b></p></a>'+'<hr />'+
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
                '<a onclick="marcadores_2()" class="menu_vertical" href="#"><p><b>Deportivas</b></p></a>'+'<hr />'+			    
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
			    '<a onclick="marcadores_3()" class="menu_vertical" href="#"><p><b>Ambiente Natural</b></p></a>'+'<hr />'+
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
			    '<a onclick="marcadores_4()" class="menu_vertical" href="#"><p><b>Patrimonio Hist&oacute;rico Cultural</b></p></a>'+'<hr />'+
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
			    '<a onclick="marcadores_5()" class="menu_vertical" href="#"><p><b>Actividades vinculadas a la Producci&oacute;n</b></p></a>'+'<hr />'+
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
			    '<a onclick="marcadores_6()" class="menu_vertical" href="#"><p><b>Eventos programados</b></p></a>'+'<hr />'+
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
			    '<a onclick="marcadores_7()" class="menu_vertical" href="#"><p><b>Infraestructura</b></p></a>'+'<hr />'+
			    '<ul class="menu_vertical">'+
                  '<li onclick="marcadores_c2_servicios(104,7)"><a class="menu_vertical" href="#">Distribuidores viales</a></li>'+
				  '<li onclick="marcadores_c2_servicios(105,7)"><a class="menu_vertical" href="#">Hospitales</a></li>'+
                  '<li onclick="marcadores_c2_servicios(106,7)"><a class="menu_vertical" href="#">Gasoliner&iacute;as</a></li>'+
				  '<li onclick="marcadores_c2(107,7)"><a class="menu_vertical" href="#">Parque central</a></li>'+
				  '<li onclick="marcadores_c2_servicios(108,7)"><a class="menu_vertical" href="#">Oficinas de gobierno</a></li>'+
				  '<li onclick="marcadores_c2_servicios(109,7)"><a class="menu_vertical" href="#">Parques deportivos</a></li>'+
				  '<li onclick="marcadores_c2_servicios(110,7)"><a class="menu_vertical" href="#">Plaza de toros</a></li>'+
				  '<li onclick="marcadores_c2_servicios(111,7)"><a class="menu_vertical" href="#">Central camionera</a></li>'+
				  '<li onclick="marcadores_c2_servicios(113,7)"><a class="menu_vertical" href="#">Cruz roja</a></li>'+
				  '<li onclick="marcadores_c2_servicios(114,7)"><a class="menu_vertical" href="#">Bomberos</a></li>'+
				  '<li onclick="marcadores_c2_servicios(115,7)"><a class="menu_vertical" href="#">Polic&iacute;a</a></li>'+
				  '<li onclick="marcadores_c2_servicios(116,7)"><a class="menu_vertical" href="#">Bancos</a></li>'+
				  '<li onclick="marcadores_c2_servicios(117,7)"><a class="menu_vertical" href="#">Casas de cambio</a></li>'+
				  '<li onclick="marcadores_c2_servicios(118,7)"><a class="menu_vertical" href="#">Oficinas de correos</a></li>'+
				  '<li onclick="marcadores_c2_servicios(119,7)"><a class="menu_vertical" href="#">Aereopuertos</a></li>'+
				  '<li onclick="marcadores_c2_servicios(120,7)"><a class="menu_vertical" href="#">Taxis</a></li>'+
				  '<li onclick="marcadores_c2_servicios(121,7)"><a class="menu_vertical" href="#">Ferrocarril</a></li>'+
				  '<li onclick="marcadores_c2_servicios(122,7)"><a class="menu_vertical" href="#">Embarcadero</a></li>'+
				  '<li onclick="marcadores_c2_servicios(123,7)"><a class="menu_vertical" href="#">Mercados</a></li>'+
                '</ul>'+
              '</div>'+
	        '</li>'+         	  
		  '</ul>'+
        '</div>'
      );
	  map.controls[google.maps.ControlPosition.LEFT_TOP].push(div_categorias);
	  
	  
	  marcadores();
	  marcadores_temporales();
	  marcadores_servicios();