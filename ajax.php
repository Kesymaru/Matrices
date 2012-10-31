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

	//busqueda
	case 'buscar':
		if( isset($_POST['id'])){
			buscar($_POST['id']);
		}
		break;

	//para loguear usuarios
	case 'logIn':
		if(isset($_POST['usuario']) && isset($_POST['password'])){
			//se encarga de la autentificacion del usuario
			logIn($_POST['usuario'], $_POST['password']);
		}
		break;

	//desloguear
	case 'logOut':
		logOut();
		break;

	//actualizaciones datos de usuario
	case 'nombre':
		if(isset($_POST['nuevo'])){
			setNombre($_POST['nuevo']);
		}
		break;

	case 'email':
		if(isset($_POST['nuevo'])){
			setEmail($_POST['nuevo']);
		}
		break;

	case 'telefono':
		if(isset($_POST['nuevo'])){
			setTelefono($_POST['nuevo']);
		}
		break;

	case 'skype':
		if(isset($_POST['nuevo'])){
			setSkype($_POST['nuevo']);
		}
		break;

	case 'password':
		if(isset($_POST['nuevo'])){
			setPassword($_POST['nuevo']);
		}
		break;
}

?>