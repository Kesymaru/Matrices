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

//MUESTRA LA LISTA DE NORMAS
function listaNormas($id){
	$sql = 'SELECT * FROM categorias WHERE parentId = '.$id;
	$result = mysql_query($sql) or die( $sql.mysql_error() );

	echo '<div class="norma">
	<select id="cargaNorma" onChange="cargaNorma()">';

	while( $row = mysql_fetch_array($result) ){
		echo '<option id="'.$row['id'].'">'.$row['nombre'].'</option>';	
	}

	echo '</select>
	</div>';
}

function generalidades(){
	$sql = 'SELECT * FROM generalidades';
	$result = mysql_query($sql);
	
	echo '<div>';
	while($row = mysql_fetch_array($result)){
		echo '<span>'.$row['nombre'].'</span>';
	}
	echo '</div>';
}

?>