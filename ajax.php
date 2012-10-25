<?php
//base de datos
require_once("db.php");

switch ($_POST['func']){

	case 'listaNormas':
		if( isset($_POST['id']) ){
			listaNormas($_POST['id']);
		}
		break;

	case 'generalidades':
		generalidades();
		break;

	case 'descripcionNorma':
		if(isset($_POST['id'])){
			descripcionNorma($_POST['id']);
		}
		break;
	case 'seleccionaGeneralidad':
		if( isset($_POST['superId']) && isset($_POST['id'])){
			seleccionaGeneralidad( $_POST['superId'], $_POST['id'] );
		}
		break;
}

?>