<?php 
	require_once("db.php"); 

//logueo
if( isset($_SESSION['logueado']) ){
	$home = "index.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

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
	<link rel="shortcut icon" href="/favicon.ico"> 

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css">
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css">

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>
	
	<!-- validacion de form -->
	<script src="js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

	<!-- placeholder para ie -->
	<script src="js/jquery.placeholder.js" type="text/javascript"></script>

	<!-- notificaciones -->
	<script src="js/noty/jquery.noty.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>
	<script type="text/javascript" src="js/noty/themes/default.js"></script>

	<script type="text/javascript">

    $(document).ready(function(){
    	
    	$( "input[type=submit], button, span" ).button();

        $('#nuevoUsuario').hide();
        $('#formRecuperacion').hide();
        $('#resetear').hide();

        $("#formID").validationEngine();
        $('input[placeholder]').placeholder();

        /*$('#entrar').click(function(){
        	logIn();
        });*/

        /*$('#recuperacion').submit(function() {
			return false;
		});*/

   	});

	function loginbox(cambio){

		if(cambio == 2){
			$('#nuevoUsuario').fadeOut(1000,function(){$('#usuarios').fadeIn();});
		}else{
			$('#usuarios').fadeOut(1000,function(){$('#nuevoUsuario').fadeIn();});
		}
		
	}

	function formRecuperacion(){

		if( $('#formRecuperacion').is(':visible')){
			$('#formRecuperacion').slideUp(500);
			$('#login').slideDown(500);

			$('#resetear').fadeOut(500, function(){ $('#entrar').fadeIn(500); });
		}else{
			$('#formRecuperacion').slideDown(500);
			$('#login').slideUp(500,function(){ $('#login').hide();});

			$('#entrar').fadeOut(500, function(){ $('#resetear').fadeIn(500); });
		}

	}

	function logIn(){

		if ( $('#formID').validationEngine('validate') ){

			var usuario = $('#usuario').val();
			var password = $('#password').val();

			var queryParams = { "func" : 'logIn', "usuario" : usuario, "password" : password};
				$.ajax({
				data:  queryParams,
				url:   'ajax.php',
				type:  'post',
				success:  function (response) { 

				        if(response.length > 0){
				        		notificaError(response);
				        }else{
				        		top.location.href = 'index.php';
				        }
				    }
				});
			}

	}

	//resetea password
	function resetar(){

		var usuario = $('#usuarioRecuperacion').val();
		var email = $('#emailRecuperacion').val();
			
		if(usuario != ''){

			var queryParams = { "func" : 'resetPasswordUsuario', "usuario" : usuario};
			$.ajax({
				data:  queryParams,
				url:   'ajax.php',
				type:  'post',
				success:  function (response) { 

					if(response.length == 0){

						notifica('Se ha enviado un email con el password temporal.');
						return;

					}else{
					    notificaError(response);
					}
				}
			});

		}
		if(email != ''){
			
			var queryParams = { "func" : 'resetPasswordEmail', "email" : email};
			$.ajax({
				data:  queryParams,
				url:   'ajax.php',
				type:  'post',
				success:  function (response) { 

				    if(response.length == 0){

				        notifica('Se ha enviado un email con el password temporal.');
				        return;
				    }else{
				        notificaError(response);
				    }
				        
				}
			});
		}

	}

	/*
		NOTIFICACIONES
	*/

	//usa noty (jquery plugin) para notificar 
	function notifica(text) {
	  	var n = noty({
	  		text: text,
	  		type: 'alert',
	    	dismissQueue: true,
	  		layout: 'topCenter',
	  		closeWith: ['click'], // ['click', 'button', 'hover']
	  	});
	  	console.log('html: '+n.options.id);
	  	
	  	//tiempo para desaparecerlo solo 
	  	setTimeout(function (){
			n.close();
		},3000);
	}

	//notifica errores
	function notificaError(text) {
	  	var n = noty({
	  		text: text,
	  		type: 'error',
	    	dismissQueue: true,
	  		layout: 'topCenter',
	  		closeWith: ['click'], // ['click', 'button', 'hover']
	  	});
	  	console.log('html: '+n.options.id);
	  	
	  	//tiempo para desaparecerlo solo 
	  	setTimeout(function (){
			n.close();
		},3000);
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
			<div class="contenido" id="login">
				<input type="text" class="validate[required,custom[onlyLetterSp]]" placeholder="Usuario" id="usuario" name="usuario"><br/>

				<input type="password" class="validate[required]" placeholder="Password" id="password" name="password"><br/>
				
			</div>

			<!-- recuperacion -->
			<br/>
			<span id="recuperacion" onClick="formRecuperacion()">¿Has olvidado tu contraseña?</span>
			<br/>
			<br/>

			<div id="formRecuperacion">
				<input type="text" class="validate[optional,custom[onlyLetterSp]]" placeholder="Usuario" id="usuarioRecuperacion" name="usuarioRecuperacion">
				
				<br/>
				O
				<br/>

				<input type="email" class="validate[optional,custom[email]]" placeholder="Email" id="emailRecuperacion" name="emailRecuperacion">
			</div>
			<!-- end formRecuperacion -->

			<div class="controls">

				<input type="submit" style="margin-right:-140px;" onClick="logIn()" id="entrar" value="Entrar">

				<span style="margin-right:-140px;" onClick="resetar()" id="resetear">Resetear</span>

				<span style="float:right;" onClick="loginbox(1)">Registrarse</span>
			</div>
		</div>
		<!-- end usuarios -->

		<div id="nuevoUsuario" >
			<div class="titulo">
				Regristro
			</div>
			<div class="contenido">

				<input type="text" class="validate[required]" placeholder="Usuario" name="nuevoUsuario"><br/>

				<input type="email" class="validate[required,custom[email]]" placeholder="Email" name="nuevoEmail"><br/>

				<input class="validate[required]" id="nuevoPassword1" placeholder="Password" name="nuevoPassword1" type="password"><br/>

				<input class="validate[required,equals[nuevoPassword1]]" placeholder="Confirmar password" name="nuevoPassword2" type="password"><br/>

			</div>

			<div class="controls">
				<input style="margin-right:-112px;" type="submit" value="Registrarse" name="registrar">
				<span style="float:right;	" onClick="loginbox(2)">Usuarios</span>
			</div>

		</div><!-- end nuevoUsuario -->

	</form>

	</div>

</body>
</html>