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

	//resetPassword -> via usuario
	case 'resetPasswordUsuario':
		if(isset($_POST['usuario'])){
			resetPasswordUsuario($_POST['usuario']);
		}
		break;

	//resetPassword -> via email
	case 'resetPasswordEmail':
		if(isset($_POST['email'])){
			resetPasswordEmail($_POST['email']);
		}
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

	//proyectos\
	case 'getProyectos':
		echo json_encode(getProyectos());
		break;

	case 'nuevoProyecto':
		if(isset($_POST['nombre']) && isset($_POST['descripcion'])){
			nuevoProyecto($_POST['nombre'], $_POST['descripcion']);
		}
		break;

	case 'menuProyectos':
		echo menuProyectos();
		break;
}

?>