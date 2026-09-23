<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>Búsqueda</title> 
	
	<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style> 
	
	<script type="text/javascript" src="../jquery.js"></script>
	<link href="../bootstrap/bootstrap.css" rel="stylesheet"> 
	<script type="text/javascript" src="search2/ui/jquery-2.0.0.js"></script>
	<script type="text/javascript" src="search2/ui/jquery-ui.js"></script>
	<link href="search2/ui/jquery-ui.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="../jquery.js"></script>
	
	
	<script > 
		$(document).ready(function(){
    $( "#buscador" ).autocomplete({
        source: "searchautocomplete.php",
        minLength: 1
    });
});
	</script>
	
	
	
</head> 
 
<body>

<div class="clsVentanaTitulo"><strong>Buscar sitio en Palenque</strong></div>
<br />
 <li id="lupa"><a href="#mimodal" role="button" data-toggle="modal"><img src="./iconos/lupa.png"></a></li>
 <div  class="modal fade" id="mimodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <!-- div con fondo transparante detras de la ventana modal parte inferior -->
          <div class="modal-dilog"> <!-- div con fondo transparante detras de la ventana modal parte central superior -->

            <div class="modal-content" style="width:400px; padding:2px; background:white; margin-left:500px;margin-top:350px;">

              <div class="model-hader" style="padding:2px; background:white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <!--  <h3> Header Modal</h3> -->
              </div> 
                  <div class="modal-body" style=" margin:10px; padding:2px; color:white">            
                    <form class="form-search" name="form1" method="post" action="">
                    <!--
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      -->
                      <label style="color:#00561B;"> Buscar: </label>
                      <input id="buscador" type="text" style="color:#00561B;" name="buscador" class="search-query" placeHolder="¿Que deseas buscar?" autofocus>
                      
					  <input style="background-color:#00561B;border-color:white" class="btn btn-info btn-sm" type="submit" value="Buscar"/>
                      <input style="background-color:#00561B;border-color:white" class="btn btn-danger btn-sm" type="submit" value="Cancelar"/>
                    </form>         
                  </div>
                  <!--
                <div class="modal-foter">
                  <button type="button" class="btn btn-primary"> Buscar </button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                </div>
                -->
              
            </div>
          </div>
      </div>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script> 
		<script type="text/javascript" src="../js/bootstrap-modal.js"></script>


<br/>
<br/>
<br/>

 
</body> 
</html>