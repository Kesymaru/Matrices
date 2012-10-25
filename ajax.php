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
		
}

?>