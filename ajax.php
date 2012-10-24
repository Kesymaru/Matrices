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

?>