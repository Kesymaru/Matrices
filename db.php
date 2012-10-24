<?php
/* Conexion y funcionalidades de la base de datos */

$host      =    "localhost";
$user      =    "root";
//$pass      =    "password";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

//muestra el menu de categorias padre
//TODO agregar imagenes en ves de texto para cada una
function menu(){
	$sql = 'SELECT * FROM categorias WHERE parentID = 0';
	$result = mysql_query($sql);

	echo '<ul>';
	while( $row = mysql_fetch_array($result)){
		echo '<li id="menu'.$row['id'].'" onClick="menu('.$row['id'].')"> <img src="images/es.png"><br/>'.$row['nombre'].'</li>';
	}
	echo '</ul>';
}

?>