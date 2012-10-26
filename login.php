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

	<link rel="stylesheet" href="css/style.css" TYPE="text/css">
	<link href="css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">

    $(document).ready(function(){

    	$( "input[type=submit], button, span" ).button();

        $('#nuevoUsuario').hide();

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
	</script>
</head>

<body>

	<header>
		<img src="images/logo.png" class="logo">

		<div class="toolbar">
			
		</div>

	</header>

	<div class="loginbox">
	<form method="post" id="formulario">

		<div id="usuarios">
			<div class="titulo">Ingresar</div>
			<div>
				<p>Usuario<p>
				<input type="text" required="required" placeholder="Usuario" name="usuario"><br/>
				<p>Password<p>
				<input type="password" required="required" placeholder="Password" name="password"><br/>
				<span class=".boton" onClick="loginbox(1)">Registrarse</span>
				<input type="submit" value="Entrar" name="entrar"><br/>
			</div>
		</div>

		<div id="nuevoUsuario" >
			<div class="titulo">
				Regristro
			</div>
			<div>
				<p>Usuario<p>
				<input type="text" required="required" placeholder="Usuario" name="nuevoUsuario"><br/>
				<p>Email<p>
				<input type="email" required="required" placeholder="Email" name="nuevoEmail"><br/>
				<p>Password<p>
				<input type="password" required="required" placeholder="Password" name="nuevoPassword1"><br/>
				<p>Confirme password<p>
				<input type="password" required="required" placeholder="Confirmar password" name="nuevoPassword2"><br/>
				<span class=".boton" onClick="loginbox(2)">Usuarios</span>
				<input type="submit" value="Registrarse" name="registrar"><br/>
			</div>
		</div>

	</form>

	</div>

</body>
</html>

<?php

function isLogged(){

}

function logIn(){

}

?>