<?php 
	require_once("../db.php"); 
/*
	para crear un nuevo proyecto
*/

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "/Matrices/login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

?>
<script type="text/javascript">

	$('#formularioNuevoProyecto button, input:reset, .controls button').button();

	$("#formularioNuevoProyecto").validationEngine({
		inlineValidation: true
	});
	$('input[placeholder]').placeholder();
	$('textarea[placeholder]').placeholder();

	/*$('#formularioNuevoProyecto').submit(function() {
		//return false;
	});
	*/
	function resetForm(){
		$('#formularioNuevoProyecto')[0].reset();
	}

</script>

<div class="titulo">
	Nuevo Proyecto
</div>

<form id="formularioNuevoProyecto">

	<div class="dialogoLeft">
		
		<!-- TODO imagen para proyecto -->
		<img id="proyectoImage" src="images/es.png">
		<br/>
		
	</div>

	<div class="dialogoRight">
		
		<table>
		<tr>
			<td>
				Nombre:
			</td>
			<td>
				<input type="text" class="validate[required]" id="proyecto" name="proyecto" placeholder="Nombre Proyecto">
			</td>
		</tr>
		</table>

	</div>

	<div class="center">
		<br/>
		Descripcion
		<br/>
		<textarea class="validate[optional,maxSize[600]]" id="descripcion" name="descripcion" placeholder="Descripcion Proyecto"></textarea>
	</div>

</form> 
<div class="controls">
	<input type="reset" value="Limpiar" onClick="resetForm()">
	<button onclick="nuevoProyecto();">Enviar</button>
</div>