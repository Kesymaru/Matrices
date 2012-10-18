<?php
/* Conexion y funcionalidades de la base de datos */

$host      =    "localhost";
$user      =    "root";
//$pass      =    "Trans123@";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());


//muestra todas las categorias en un select
function categorias(){
	$sql = 'SELECT * FROM categorias';
	$resultado = mysql_query($sql);
	
	echo '<select required="required">
	<option></option>';

	while($row = mysql_fetch_array($resultado)){
		echo '<option value="'.$row['id'].'" onClick="etiqueta(\''.$row['nombre'].'\')">'.$row['nombre'].'</option>';
	}

	echo '</select>';
}

//muestra todas las categorias en un select
function subcategorias(){
	$sql = 'SELECT * FROM subcategorias';
	$resultado = mysql_query($sql);
	
	echo '<select required="required">
	<option></option>';

	while($row = mysql_fetch_array($resultado)){
		echo '<option value="'.$row['id'].'" onClick="etiqueta(\''.$row['nombre'].'\')">'.$row['nombre'].'</option>';
	}

	echo '</select>';
}


?>