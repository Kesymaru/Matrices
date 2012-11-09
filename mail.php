<?php
	//require_once("db.php"); 
/*
	muestra una lista en el dialogo, con todas las categorias disponibles para agregar al proyecto
*/

//logueo

function mailRegistro($para, $usuario, $password){
	$headers .= 'From: andreyalfaro@gmail.com' . "\r\n";
	$headers .= 'Reply-To: webmaster@matricez.com' . "\r\n";
	$headers .= 'X-Mailer: Matricez' . "\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$tema = "Registro Matriz";

	$mensaje = '<!doctype html public>
<head>
	<meta charset="utf-8">
	<style type="text/css">
	
	html, body{
		background-color: #f4f4f4;
	}
	.tabla{
		border: 1px solid #747273;
		margin: 0 auto;
		border-collapse: collapse;
		box-shadow: 0 0 2px 1px #747273;
		padding: 0;
		min-width: 500px;
		font-size: 20px;
	}
	.tabla td{
		padding: 10px;
	}
	.titulo{
		background-color: #6FA414;
		text-align: center !important;
		font-size: 22px;
		font-weight: bold;
		color: #fff;
	}
	.link{
		background-color: #a1ca4a;
		text-align: center;
		vertical-align: middle;
	}
	.logo{
		float: right;
		height: 80px;
	}

	</style>
</head>

<body>
<br/>
<br/>
<br/>
<table class="tabla">
	<tr class="titulo">
		<td colspan="2">
			Registro Exitoso
		</td>
	</tr>
	<tr class="fila">
		<td>
			Usuario:
		</td>
		<td>
			'.$usuario.'
		</td>
	</tr>
	<tr class="fila">
		<td>
			Contrasena:
		</td>
		<td>
			'.$password.'
		</td>
	</tr>
	<tr>
		<td colspan="2" class="link">
			<a href="'.$_SESSION['home'].'/login.php?user=USER" >
				<img scr="'.$_SESSION['home'].'/images/mailIngresarBoton.png" title="Ingresar" alt="Ingresar">
			</a>
			<img class="logo" src="http://admin.77digital.com/Consilio/images/logoMail.png" title="Matriz" alt="Matriz">
		</td>
	</tr>	
</table>
<br/>
<br/>
<br/>
</body>
</html>';

	if(!mail($para, $tema, $mensaje, $headers)){
		$_SESSION['error'] = "El envio del email de registro ha fallado!<br/>Por favor comuniquese con ".$admin;
	}
}

function mailResetPassword($para, $usuario, $password){
	$headers .= 'From: andreyalfaro@gmail.com' . "\r\n";
	$headers .= 'Reply-To: webmaster@matricez.com' . "\r\n";
	$headers .= 'X-Mailer: Matricez' . "\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$tema = "Registro Matriz";

	$mensaje = '<!doctype html public>
<head>
	<meta charset="utf-8">
	<style type="text/css">
	
	html, body{
		background-color: #f4f4f4;
	}
	.tabla{
		border: 1px solid #747273;
		margin: 0 auto;
		border-collapse: collapse;
		box-shadow: 0 0 2px 1px #747273;
		padding: 0;
		min-width: 500px;
		font-size: 20px;
	}
	.tabla td{
		padding: 10px;
	}
	.titulo{
		background-color: #6FA414;
		text-align: center !important;
		font-size: 22px;
		font-weight: bold;
		color: #fff;
	}
	.link{
		background-color: #a1ca4a;
		text-align: center;
		vertical-align: middle;
	}
	.logo{
		float: right;
		height: 80px;
	}

	</style>
</head>

<body>
<br/>
<br/>
<br/>
<table class="tabla">
	<tr class="titulo">
		<td colspan="2">
			Registro Exitoso
		</td>
	</tr>
	<tr class="fila">
		<td>
			Usuario:
		</td>
		<td>
			'.$usuario.'
		</td>
	</tr>
	<tr class="fila">
		<td>
			Contrasena:
		</td>
		<td>
			'.$password.'
		</td>
	</tr>
	<tr>
		<td colspan="2" class="link">
			<a href="'.$_SESSION['home'].'/login.php?user=USER" >
				<img scr="'.$_SESSION['home'].'/images/mailIngresarBoton.png" title="Ingresar" alt="Ingresar">
			</a>
			<img class="logo" src="http://admin.77digital.com/Consilio/images/logoMail.png" title="Matriz" alt="Matriz">
		</td>
	</tr>	
</table>
<br/>
<br/>
<br/>
</body>
</html>';

	if(!mail($para, $tema, $mensaje, $headers)){
		$_SESSION['error'] = "El envio del email de registro ha fallado!<br/>Por favor comuniquese con ".$admin;
	}
}

?>