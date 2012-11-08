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

//obtiene id
if(isset($_GET['proyecto'])){
	exportarProyecto($_GET['proyecto']);
}

?>
<script type="text/javascript">
	$('#nuevaNota').button();
</script>

<?php

//exporta un proyecto
function exportarProyecto($id){
	$tabla = 'class="tablaResumen"';
	$titulo = 'class="tituloResumen"';
	$columnaTitulo = 'class="columnaTituloResumen"';
	$columna = 'class="columnaResumen"';
	
	//nombre por defecto, despues lo cambia
	$nombre = 'proyecto'.$id;
	$cuerpo = '';
	$notas = '';

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'].' AND id = '.$id;
	$result = mysql_query($sql);

	//crea el resumen del proyecto
	while( $row = mysql_fetch_array($result) ){
		$nombre = $row['nombre'];

		$cuerpo .= '<tr>
			<td '.$columna.'>'.$row['nombre'].'</td>
			<td colspan="3"'.$columna.'>'.$row['descripcion'].'</td>
			<td '.$columna.'>'.$row['fecha'].'</td>
			<td '.$columna.'>';

		if($row['status'] == 1){
			$cuerpo .= 'Activo';
		}else{
			$cuerpo .= 'Finalizado';
		}

		$cuerpo .= '</td>
		</tr>';
	}

	//encabezados del exell
	$encabezado = '<table '.$tabla.'>
		<tr>
			<td colspan="6" '.$titulo.'>Resumen de '.$nombre.'</td>
		</tr>
		<tr>
			<td '.$columnaTitulo.'>Nombre</td>
			<td colspan="3"'.$columnaTitulo.'>Descripcion</td>
			<td '.$columnaTitulo.'>Fecha</td>
			<td '.$columnaTitulo.'>Estado</td>
		</tr>';

	//footer
	$footer = '</table>';
	
	$notas = notas($id);
	
	//crea el resumen
	echo $encabezado.$cuerpo.$notas.$footer;
}


function notas($id){
	$titulo = 'class="tituloResumen"';
	$columnaTitulo = 'class="columnaTituloResumen"';
	$columnaNota = 'class="columnaNotaResumen"';
	$columnaInfo = 'class="columnaInfoResumen"';
	$columnaControls = 'class="colunmaControlsResumen"';

	$sql = 'SELECT * FROM notas WHERE proyecto = '.$id;
	$result = mysql_query($sql);

	$notas = '';
	$c = 0;
	
	$notas .= '<tr>
			<td colspan="6" '.$titulo.'>
				Notas
			</td>
		</tr>';

	while($row = mysql_fetch_array($result)){
		$notas .= '<tr class="filaNotaResumen" id="nota'.$row['id'].'">
				<td colspan="4" '.$columnaNota.'>
					'.$row['nota'].'
				</td>
				<td colspan="2" '.$columnaInfo.'>
				<img src="images/close.png" class="removeNota" id="removeNota'.$row['id'].'" onClick="removeNota('.$row['id'].')">';
		$notas .= datosCliente($row['cliente']).'
				</td>
			</tr>';
		$c++;
	}

	$notas .= '<tr>
			<td colspan="6" '.$columnaControls.'>
				<button id="nuevaNota" onClick="nota('.$id.')">Agregar Nota</button>
			</td>
			</tr>';

	return $notas;
}

function datosCliente($id){
	$datos = '';
	$sql = 'SELECT * FROM clientes WHERE id = '.$id;
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){
		$datos .= '<img src="'.$_SESSION['home'].'/images/users/user.png" style="float: left; height: 50px;">';
		$datos .= $row['nombre'].'<br/>'.$row['fecha'];
	}

	return $datos;
}

?>