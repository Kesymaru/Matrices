<?php 
	require_once("../db.php"); 
/*
	muestra una lista en el dialogo, con todas las categorias disponibles para agregar al proyecto
*/

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "/Matrices/login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

?>

<script type="text/javascript">

	$('#formularioListaProyectos button, input:reset, .controls button').button();

	$('input[placeholder]').placeholder();
	$('textarea[placeholder]').placeholder();

</script>

<div class="titulo">
	Proyectos
</div>

<div id="formularioListaProyectos">


	<div class="center">

	</div>

</div> 

<div class="controls">
	<button onclick="resetea();">Limpiar</button>
	<button onclick="enviarCategorias();">Seleccionar</button>
</div>