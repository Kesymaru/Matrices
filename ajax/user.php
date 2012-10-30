<?php 

	session_start();
/*
	para que el usuario edite sus datos
*/

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

?>
<script type="text/javascript">
	$('#cambiarPassword').hide();

	$('#formularioUsuario button, input:reset, .controls button').button();

	$('#cambiar').click( function(){
		if( $('#cambiarPassword').is(':visible')){
			$('#cambiarPassword').slideUp();
		}else{
			$('#cambiarPassword').slideDown();
		}
		//$('input[placeholder]').placeholder();
	});

	$("#formularioUsuario").validationEngine();
	$('input[placeholder]').placeholder();

	$('#formularioUsuario').submit(function() {
		//return false;
	});

</script>

<div class="titulo">
	Cambiar Datos
</div>

<form id="formularioUsuario">

	<div class="dialogoLeft">
		
		<!-- TODO user image -->
		<img id="userImage" src="images/es.png">
		<br/>
		<button onClick="alert('alerta');"> Cambiar Imagen</button>

	</div>

	<div class="dialogoRight">
		
		<table>
		<tr>
			<td>
				Nombre:
			</td>
			<td>
				<input type="text" class="validate[required]" name="nombre" value="<?php echo $_SESSION['nombre']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				Email:
			</td>
			<td>
				<input type="text" class="validate[required]" name="email" value="<?php echo $_SESSION['email']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				Tel:
			</td>
			<td>
				<input type="text" name="telefono" value="<?php echo 123;?>">
			</td>
		</tr>
		<tr>
			<td>
				Skype:
			</td>
			<td>
				<input type="text" name="telefono" value="<?php echo $_SESSION['skype'];?>">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button id="cambiar">Cambiar Password</button>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="cambiarPassword">
					Cambiar Password
					<br/>
					<input class="validate[required]" type="password" id="nuevoPassword1" placeholder="Nuevo Password">
					<br/>
					<input class="validate[required,equals[nuevoPassword1]]"  id="nuevoPassword2" type="password" placeholder="Confirmar Password">
				</div>
			</td>
		</tr>
		</table>
	    
	</div>

</form> 
<div class="controls">
	<input type="reset" value="Limpiar">
	<button>Enviar</button>
</div>