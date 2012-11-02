<?php
/* EXPORTA PROYECTO PARA EXCEL */
session_start();

$host      =    "localhost";
$user      =    "root";
//$pass      =    "password";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

mysql_query("SET NAMES 'utf8'");

if(isset($_GET['proyecto'])){

}

/*
	ESTILO
*/

exportar();

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

//exporta un reporte del proyecto, toda la info del proyecto
function exportarProyecto(){

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'].' ADN nombre = '.$proyecto;

	$result = mysql_query($sql);

	header("Content-Type: application/vnd.ms-excel");

	//llena el archivo
	echo 'Nombre'."\t".'Descripcion'."\t".'Fecha'."\t".'Estado'."\n";

	while( $row = mysql_fetch_array($result) ){
		
		echo $row['nombre']."\t";
		echo $row['descripcion']."\t";
		echo $row['fecha']."\t";
		echo $row['status']."\n";

	}

	//descarga el archivo
	header("Content-disposition: attachment; filename=proyectos.xls");
}

?>