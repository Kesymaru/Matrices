<?php 
	require_once("../db.php"); 
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
	});

	$("#formularioUsuario").validationEngine();
	$('input[placeholder]').placeholder();

	/*$('#formularioUsuario').submit(function() {
		//return false;
	});
	*/
	function resetForm(){
		$('#formularioUsuario')[0].reset();
	}

</script>

<div class="titulo">
	Cambiar Datos
</div>

<form id="formularioUsuario">

	<div class="dialogoLeft">
		
		<!-- TODO user image -->
		<img id="userImage" src="images/es.png">
		<br/>
		<div id="imagenLoad">
		</div>

	</div>

	<div class="dialogoRight">
		
		<table>
		<tr>
			<td>
				Nombre:
			</td>
			<td>
				<input type="text" class="validate[required]" id="nombre" title="[*no]" name="nombre" value="<?php echo getNombre(); ?>">
			</td>
		</tr>
		<tr>
			<td>
				Email:
			</td>
			<td>
				<input type="text" class="validate[required,custom[email]]" id="email" name="email" value="<?php echo getEmail(); ?>">
			</td>
		</tr>
		<tr>
			<td>
				Tel:
			</td>
			<td>
				<input type="number" class="validate[custom[number]]" id="telefono" name="telefono" value="<?php echo getTelefono();?>">
			</td>
		</tr>
		<tr>
			<td>
				Skype:
			</td>
			<td>
				<input type="text" name="skype" id="skype" value="<?php echo getSkype();?>">
			</td>
		</tr>
		<tr>
			<td colspan="2" class="muestra">
				<button id="cambiar">Cambiar Password</button>
				<div id="cambiarPassword">
					<input class="validate[required,minSize[4]]" type="password" id="nuevoPassword1" placeholder="Nuevo Password">
					<br/>
					<input class="validate[required,equals[nuevoPassword1],minSize[4]]"  id="nuevoPassword2" type="password" placeholder="Confirmar Password">
				</div>
			</td>
		</tr>
		</table>
	    
	</div>

</form> 
<div class="controls">
	<input type="reset" value="Limpiar" onClick="resetForm()">
	<button onclick="editarUsuario();">Enviar</button>
</div>