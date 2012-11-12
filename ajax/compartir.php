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

if(isset($_SESSION['proyecto'])){
	exportar($_SESSION['proyecto']);
}

//muestra el dashboard
// @param $proyecto -> id del proyecto
function exportar($proyecto){
	echo '<div id="exportar">';

	echo '<div class="box">
			<div class="titulo">Exportar</div>
		
		Seleccione un formato para exportar.<br/>
		Formatos:<br/>

		<button onClick="exportarProyecto('.$proyecto.')" >Excel</button>
		<button>PDF</button>

	</div>';

	echo '<div class="box">
		<div class="titulo">Compartir</div>
		Puedes compartir el informe por medio de un email o link.<br/>
		Las personas podran ver y descargar el informe pero no editarlo.<br/>

		<button>Compartir con link</button>
		<button>Enviar por email</button>

	</div>';

	echo '</div><!-- end exportar -->';
}


?>