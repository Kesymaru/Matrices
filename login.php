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
	$(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });

	function loginbox(){

		
		if( $('#nuevoUsuario').hasClass('oculto') ){
			$('#nuevoUsuario').removeClass('oculto');
			$('#usuarios').addClass('oculto').fade();
		}else{
			$('#usuarios').removeClass('oculto');
			$('#nuevoUsuario').addClass('oculto').fade();
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
	<form method="post">

		<div id="usuarios">
			<div class="titulo">Ingresar</div>
			<div>
				<input type="text" placeholder="Usuario" name="usuario"><br/>
				<input type="password" placeholder="Password" name="password"><br/>
				<button onClick="loginbox()">Registrarse</button>
				<input type="submit" value="Entrar" name="entrar"><br/>
			</div>
		</div>

		<div id="nuevoUsuario" class="oculto">
			<div class="titulo">
				Regristro
			</div>
			<div>
				<input type="text" placeholder="Usuario" name="nuevoUsuario"><br/>
				<input type="email" placeholder="Email" name="nuevoEmail"><br/>
				<input type="password" placeholder="Password" name="nuevoPassword1"><br/>
				<input type="password" placeholde="Repita el password" name="nuevoPassword2"><br/>
				<button onClick="loginbox()">Usuarios</button>
				<input type="submit" value="Registrarse" name="registrar"><br/>
			</div>
		</div>

	</form>

	</div>

</body>
</html>