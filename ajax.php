<?php
//base de datos
require_once("bd.php");

switch ($_POST['func']){
	case 'loginbox':
		echo 'login.php';
		break;
	case 'subcategorias':
		if( isset($_POST['categoria']) ){
			subcategorias($_POST['categoria']);
		}
		break;
}

function subcategorias($categoria){
	$sql = 'SELECT * FROM subcategorias WHERE categoria = '.$categoria;
	$resultado = mysql_query($sql);
	
	echo '<select>
	<option></option>';

	while($row = mysql_fetch_array($resultado)){
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
	}

	echo '</select>';
}

?>