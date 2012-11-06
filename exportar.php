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
	$logo = 'style="width: 200px;"';

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'];
	$result = mysql_query($sql);

	header("Content-Type: application/vnd.ms-excel");

	//rellena exell
	echo '<table>
		<tr>
			<td colspan="6" '.$titulo.'>Proyectos</td>
		</tr>
		<tr>
			<td '.$columnaTitulo.'>Nombre</td>
			<td colspan="3"'.$columnaTitulo.'>Descripcion</td>
			<td '.$columnaTitulo.'>Fecha</td>
			<td '.$columnaTitulo.'>Estado</td>
		</tr>';

	while( $row = mysql_fetch_array($result) ){
		
		echo '<tr>
			<td '.$columna.'>'.$row['nombre'].'</td>
			<td colspan="3"'.$columna.'>'.$row['descripcion'].'</td>
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
			<td colspan="6" '.$reporteInfo.'> Generado Automaticamente el '.date("d-m-Y").'
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
	$columnanInfo = 'style="background-color: #f4f4f4; color: #757374; font-size: 14pt; text-align: left;"';
	$logo = 'style="background-color: #f4f4f4; color: #757374; font-size: 14pt; text-align: center;"';
	
	//nombre por defecto, despues lo cambia
	$nombre = 'proyecto'.$id;
	$cuerpo = '';
	$detalles = '';//informacion detallada de las categorias, normas y sus detalles
	$home = 'http://localhost/Matrices/';

	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'].' AND id = '.$id;
	$result = mysql_query($sql);

	header("Content-Type: application/vnd.ms-excel");

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

	//informacion del informe
	$footer = '<tr>
			<td colspan="6" '.$tituloInfo.'> Generado Automaticamente</td>
			</tr>';

	$footer .= '<tr>
				<td '.$columnanInfo.'>Fecha:</td>
				<td colspan="4" '.$columnanInfo.'>'.date("F j Y - g:i a").'</td>
				<td rowspan="3" colspan="1" '.$logo.'>
					<img style="text-align: center; vertical-align: center; margin: 0 auto;" src="http://localhost/Matrices/images/logoExcel.png">
				</td>';

	$footer .= '<tr>
				<td '.$columnanInfo.'>Por:</td>
				<td colspan="5" '.$columnanInfo.'>'.$_SESSION['nombre'].'</td>
				</tr>';

	$footer .= '<tr>
			<td '.$columnanInfo.'>Generado en:</td>
			<td colspan="5" '.$columnanInfo.'> 
				<a href="'.$home.'">Escala.com</a>
			</td>
			</tr>
		</table>';

	//crea detalles del proyecto
	$detalles = detalles($id);
	
	//imprime el archivo 
	echo $encabezado.$cuerpo.$detalles.$footer;

	//descarga el archivo
	header("Content-disposition: attachment; filename=".$nombre.".xls");
}

/*
	crea la tabla de detalles
	@param return $detalle 
*/

function detalles($id){
	//estilos
	$titulo = 'style="background-color: #6fa414; font-bold: bold; color: #fff; font-size: 18pt; text-align: center;"';
	$columnaTitulo = 'style="background-color: #a1ca4a; color: #fff; font-bold: bold; font-size: 16pt; text-align: center;"';
	$tituloCategoria = 'style="background-color: #757374; font-bold: bold; color: #fff; font-size: 18pt; text-align: center;"';
	$columna = 'style="text-align: left; font-size: 14pt;"';

	$detalles = '
	<tr>
		<td colspan="6" '.$titulo.'>GENERALIDADES</td>
	</tr>
	<tr>
		<td '.$columnaTitulo.'>N DE NORMA</td>
		<td '.$columnaTitulo.'>NOMBRE DE NORMA</td>
		<td '.$columnaTitulo.'>REQUISITO LEGAL</td>
		<td '.$columnaTitulo.'>RESUMEN</td>
		<td '.$columnaTitulo.'>PERSIMOS</td>
		<td '.$columnaTitulo.'>ENTIDAD COMPETENTE</td>
	</tr>';

	$sql = 'SELECT DISTINCT categoria FROM registros WHERE proyecto = '.$id;
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){

		$detalles .= infoCategoria($row['categoria']);

		$sql2 = 'SELECT DISTINCT norma FROM registros WHERE categoria = '.$row['categoria'];
		$result2 = mysql_query($sql2);
		
		while($row2 = mysql_fetch_array($result2)){
			$detalles .= infoNorma($row2['norma']);
		}
	}

	return $detalles;
}

//para el titulo de la categoria
function infoCategoria($categoria){
	$tituloCategoria = 'style="background-color: #f4f4f4; font-bold: bold; color: #757374; font-size: 18pt; text-align: center;"';

	$sql = 'SELECT * FROM categorias WHERE id = '.$categoria;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	//titulo
	return '<tr><td colspan="6" '.$tituloCategoria.'>'.$row['nombre'].'</td></tr>';
}

//devuelve la informacion de todas las normas de una categoria
function infoNorma($id){
	$columna = 'style="text-align: left; font-size: 14pt; border: 1px solid #f4f4f4;"';

	$info = '';
	$sql = 'SELECT * FROM normas WHERE id = '.$id;
	$result = mysql_query($sql);
	
	$row = mysql_fetch_array($result);
		$info .= '<tr>';
		$info .= '<td '.$columna.'>'.$row['numero'].'</td>';
		$info .= '<td '.$columna.'>'.$row['nombre'].'</td>';
		$info .= '<td '.$columna.'>'.$row['resumen'].'</td>';
		$info .= '<td '.$columna.'>'.$row['requisito'].'</td>';
		$info .= '<td '.$columna.'>'.$row['permisos'].'</td>';
		$info .= '<td '.$columna.'>'.$row['entidad'].'</td>';
		$info .= '</tr>';

	return $info;
}

?>