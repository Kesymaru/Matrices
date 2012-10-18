<!DOCTYPE html>
<html>

<head>
	<title>Registro</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="css/style.css" TYPE="text/css">
	<link rel="stylesheet" href="css/formulario.css" TYPE="text/css">
	<link rel="stylesheet" href="css/jquery.tagsinput.css" TYPE="text/css">
	<link href="css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>
	<script src="js/jquery.tagsinput.js"></script>
	<script src="js/main.js"></script>
</head>

<body>

<?php
/*
	
*/

//base de datos
require_once("bd.php");

session_start();


if(loguado()){
	echo '<div id="contenido"></div>';

	echo '<SCRIPT TYPE="text/javascript">
	contenido(\'loginbox\')
	</SCRIPT>';
}else{

}
?>

<div class="barraProgreso">

</div>
<form id="formulario">
	<hr><h1>Datos Proyecto</h1><hr>

	<div class="contenedor">
		<div class="left">
			Nombre:<br/>
			<input id="nombre" type="text"  required="required" placeholder="Nombre">
			<br/>
			Fecha:<br/>
			<input type="text" id="datepicker" />
		</div>
		<div class="right">
			<div class="categoria">
				Categoria<br/>
				<?php 
					categorias();
				?>
			</div>
			<div class="sub-categoria">
				Sub-categoria<br/>
				<?php 
					subcategorias();
				?>
			</div>
			<div class="sub-categoria">
				Sub-sub-categoria<br/>
				<?php 
					subcategorias();
				?>
			</div>
		</div>
	</div>

	<div class="bottom">
		<input id="cats" type="text" class="tags" value="" />
		<input id="tags" type="text" class="tags" value="" />
		Notas<br/>
		<textarea placeholder="Notas"></textarea>
	</div>
	
	<button onClick="imprimir()">Seguiente</button>
</form>


</body>

</html>

<?php

//determina si el usuario esta logueado
function loguado(){
	if( !isset($_SESSION['logueado']) ) {
		return false;
	}else{
		return true;
	}
}

?>