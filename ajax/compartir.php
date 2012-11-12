<?php
	require_once("../db.php"); 

/*
	Muestra un vista amigable y con opciones para la exportacion 
	muestra opciones de compartir el informe del proyecto
*/

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = $_SESSION['home']."/login.php";
	header('Location: '.$home);
	exit;
}

if(isset($_GET['proyecto'])){
	compartirMenu($_GET['proyecto']);
}

//muestra el dashboard
// @param $proyecto -> id del proyecto
function compartirMenu($proyecto){

	echo '<div class="box">
			<div class="titulo">Exportar</div>
		<br/>
		Puedes exportar el informe en archivo excel o pdf.
		<br/><br/>
		Seleccione un formato para exportar.
		<br/><br/>

		<button onClick="exportarProyecto('.$proyecto.')" >Excel</button>
		<button onClick="exportarProyectoPdf('.$proyecto.')">PDF</button>

		<br/><br/>
	</div>';

	echo '<div class="box">
		<div class="titulo">Compartir</div>
		<br/>
		Puedes compartir el informe por medio de un enlace.
		<br/><br/>
		Las personas podran ver y descargar el informe pero no editarlo.
		<br/><br/>

		<button>Compartir con link</button>
		
		<br/><br/>
	</div>';
}


?>