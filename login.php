<?php 
	require_once("db.php"); 
?>
<!doctype html public>
<!--[if lt IE 7]> <html lang="en-us" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us"> <!--<![endif]-->
<html>

<head>
	<title>Escala Login</title>
	
	<meta charset="utf-8">
	<link rel="shortcut icon" href="images/favicon.ico"> 

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css">
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css">

	<!-- <script src="js/jquery-1.8.2.js"></script> -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>

	<script src="js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.placeholder.js"></script>

	<script type="text/javascript">

    $(document).ready(function(){

    	$( "input[type=submit], button, span" ).button();

        $('#nuevoUsuario').hide();

        $('#entrar').click(function(){
        	logIn();
        });

        $("#formID").validationEngine();
        $('input[placeholder]').placeholder();
   	});

	function loginbox(cambio){

		if( cambio == 2 ){
			$('#nuevoUsuario').fadeOut(1000,function(){
				$('#usuarios').fadeIn();
			});
		}else{
			$('#usuarios').fadeOut(1000,function(){
				$('#nuevoUsuario').fadeIn();
			});
		}
		
	}

	function logIn(){

	var usuario = $('#usuario').val();
	var password = $('#password').val();

	var queryParams = { "func" : 'logIn', "usuario" : usuario, "password" : password};
	//var cont = $("#"+lugarCarga);
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 

	        	if(response.length > 0){
	        		alert(response);
	        		//TODO nice notification
	        	}else{
	        		top.location.href = 'index.php';
	        	}
	        }
		});
	}
	</script>
</head>

<body>

	<header>
		<img src="images/logo.png" class="logo">

		<div class="toolbar">
			
		</div>

	</header>

	<div class="loginbox">
	<form method="post" id="formID">

		<div id="usuarios">
			<div class="titulo">Ingresar</div>
			<div class="contenido">
				<input type="text" class="validate[required]" placeholder="Usuario" required="required" id="usuario" name="usuario"><br/>
				<input type="password" class="validate[required]" required="required" placeholder="Password" id="password" name="password"><br/>
				
				<span class=".boton" onClick="loginbox(1)">Registrarse</span>
				<input type="submit" value="Entrar" name="entrar" id="entrar"><br/>

			</div>
		</div>

		<div id="nuevoUsuario" >
			<div class="titulo">
				Regristro
			</div>
			<div class="contenido">

				<input type="text" class="validate[required]" required="required" placeholder="Usuario" name="nuevoUsuario"><br/>

				<input type="email" class="validate[required,custom[email]]" required="required" placeholder="Email" name="nuevoEmail"><br/>

				<input class="validate[required]" required="required" id="nuevoPassword1" placeholder="Password" name="nuevoPassword1" type="password"><br/>

				<input class="validate[required,equals[nuevoPassword1]]" required="required" placeholder="Confirmar password" name="nuevoPassword2" type="password"><br/>

				<span class=".boton" onClick="loginbox(2)">Usuarios</span>
				<input type="submit" value="Registrarse" name="registrar"><br/>

			</div>
		</div>

	</form>

	</div>

</body>
</html>