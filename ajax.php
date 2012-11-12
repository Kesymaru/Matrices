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

	/*
		USUARIOS
	*/

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

	//registr usuario
	case 'registro':
		if( isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['password'])){
			registro($_POST['usuario'], $_POST['email'], $_POST['password']);
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

	/* 
		PROYECTOS 
	*/
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

	case 'buscarProyecto':
		if(isset($_POST['buscar'])){
			echo buscarProyecto($_POST['buscar']);
		}
		break;

	case 'nuevaNota':
		if(isset($_POST['proyecto']) && isset($_POST['nota'])){
			nuevaNota($_POST['proyecto'], $_POST['nota']);
		}
		break;

	case 'removeNota':
		if(isset($_POST['nota'])){
			removeNota($_POST['nota']);
		}
		break;

	/*
		AUTOGUARDADO DE ACTIVIDAD O CONSULTA DEL PROYECTO
	*/
	case 'actividadRegistrar':
		if(isset($_POST['proyecto']) && isset($_POST['norma']) && isset($_POST['id'])){
			actividadRegistrar($_POST['proyecto'], $_POST['categoria'], $_POST['norma'], $_POST['id']);
		}
		break;

	/*
		CARGA DE DATOS PROYECTO SELECCIONADO
	*/
	case 'menuDatos':
		if(isset($_POST['proyecto'])){
			menuDatos($_POST['proyecto']);
		}
		break;
	
	//menu normal
	case 'menu':
		menu();
		break;

	case 'listaNormasDatos':
		if(isset($_POST['id'])){

		}
		break;

	case 'proyectoControls':
		if(isset($_POST['id'])){
			echo proyectoControls($_POST['id']);
		}
		break;

	/*
		CATEGORIAS
	*/
	case 'cargarCategorias':
		if(isset($_POST['categorias'])){
			cargarCategorias($_POST['categorias']);
		}
		break;

	case 'buscarCategoriasSeleccion':
	if(isset($_POST['buscar'])){
		buscarCategoriasSeleccion($_POST['buscar']);
	}
	break;

	case 'categorias':
		categorias();
		break;
}

?>