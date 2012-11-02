<?php
/* EXPORTA PROYECTO PARA EXCEL */
session_start();

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

$host      =    "localhost";
$user      =    "root";
//$pass      =    "password";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

mysql_query("SET NAMES 'utf8'");

if(isset($_GET['id'])){
	exportarProyecto($_GET['id']);
}else{
	//exporta todos los proyectos del usuario
	exportar();
}

//exporta todos los proyectos del usuario, informacion general
function exportar(){
	$titulo = 'style="background-color: yellow; font-bold: bold; text-align: center;"';
	$columnaTitulo = 'style="background-color: blue; color: #fff; font-bold: bold; text-align: center;"';
	$columna = 'style="text-align: left;"';
	$reporteInfo = 'style="background-color: red; color: #fff;"';
	$columnaLogo = 'style="text-align: center;"';
	$logo = 'style="width: 200px;"';

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'];
	$result = mysql_query($sql);

	header("Content-Type: application/vnd.ms-excel");

	//rellena exell
	echo '<table>
		<tr>
			<td colspan="4" '.$titulo.'>Proyectos</td>
		</tr>
		<tr>
			<td '.$columnaTitulo.'>Nombre</td>
			<td '.$columnaTitulo.'>Descripcion</td>
			<td '.$columnaTitulo.'>Fecha</td>
			<td '.$columnaTitulo.'>Estado</td>
		</tr>';

	while( $row = mysql_fetch_array($result) ){
		
		echo '<tr>
			<td '.$columna.'>'.$row['nombre'].'</td>
			<td '.$columna.'>'.$row['descripcion'].'</td>
			<td '.$columna.'>'.$row['fecha'].'</td>
			<td '.$columna.'>';

		if($row['status'] == 0){
			echo 'Activo';
		}else{
			echo 'Finalizado';
		}

		echo '</td>
		</tr>';
	}

	echo '
		<tr>
			<td colspan="4" '.$reporteInfo.'> Generado Automaticamente el '.date("d-m-Y").'
			</td>
		</tr>
		</table>';

	//descarga el archivo
	header("Content-disposition: attachment; filename=proyectos.xls");
}

//exporta un proyecto
function exportarProyecto($id){
	$tabla = 'style="border: 0px; width: 100%;"';
	$titulo = 'style="background-color: #6fa414; font-bold: bold; color: #fff; font-size: 18pt; text-align: center;"';
	$columnaTitulo = 'style="background-color: #a1ca4a; color: #fff; font-bold: bold; font-size: 16pt; text-align: center;"';
	$columna = 'style="text-align: left; font-size: 14pt;"';
	$tituloInfo = 'style="background-color: #a1ca4a; color: #fff; font-size: 16pt; text-align: center;"';
	$columnanInfo = 'style="background-color: #757374; color: #fff; font-size: 14pt; text-align: left;"';
	
	//nombre por defecto, despues lo cambia
	$nombre = 'proyecto'.$id;
	$cuerpo = '';
	$home = 'http://localhost/Matrices/index.php';

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'].' AND id = '.$id;
	$result = mysql_query($sql);

	header("Content-Type: application/vnd.ms-excel");

	while( $row = mysql_fetch_array($result) ){
		$nombre = $row['nombre'];

		$cuerpo .= '<tr>
			<td '.$columna.'>'.$row['nombre'].'</td>
			<td '.$columna.'>'.$row['descripcion'].'</td>
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
			<td colspan="4" '.$titulo.'>Resumen de '.$nombre.'</td>
		</tr>
		<tr>
			<td '.$columnaTitulo.'>Nombre</td>
			<td '.$columnaTitulo.'>Descripcion</td>
			<td '.$columnaTitulo.'>Fecha</td>
			<td '.$columnaTitulo.'>Estado</td>
		</tr>';

	//informacion del informe
	$footer = '<tr>
			<td colspan="4" '.$tituloInfo.'> Generado Automaticamente</td>
			</tr>';

	$footer .= '<tr>
				<td '.$columnanInfo.'>Fecha:</td>
				<td colspan="3" '.$columnanInfo.'>'.date("F j Y - g:i a").'</td>';

	$footer .= '<tr>
				<td '.$columnanInfo.'>Por:</td>
				<td colspan="3" '.$columnanInfo.'>'.$_SESSION['nombre'].'</td>
				</tr>';

	$footer .= '<tr>
			<td '.$columnanInfo.'>Generado en:</td>
			<td colspan="3" '.$columnanInfo.'> 
				<a style="color: #fff;" href="'.$home.'">Escala.com</a>
			</td>
			</tr>
		</table>';

	//imprime el archivo 
	echo $encabezado.$cuerpo.$footer;

	//descarga el archivo
	header("Content-disposition: attachment; filename=".$nombre.".xls");
}

?>