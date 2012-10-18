<?php
require_once("dbAdmin.php");

switch ($_POST['func']){
	case 'bienvenida':
		echo 'compania/bienvenida.html';
		break;
		
	//clientes
	case 'verClientes':
		verClientes();
		break;
	case 'clienteNombre':
		if( isset($_POST['param']) && isset($_POST['id']) ){
			actualizaNombre($_POST['id'], $_POST['param']);
		}
		break;
	case 'clienteEmail':
		if( isset($_POST['param']) && isset($_POST['id']) ){
			actualizaEmail($_POST['id'], $_POST['param']);
		}
		break;
	case 'clienteTelefono':
		if( isset($_POST['param']) && isset($_POST['id']) ){
			actualizaTelefono($_POST['id'], $_POST['param']);
		}
		break;
	case 'clienteSkype':
		if( isset($_POST['param']) && isset($_POST['id']) ){
			actualizaSkype($_POST['id'], $_POST['param']);
		}
		break;

	//proyectos
	case 'verProyectos':
		verProyectos();
		break;
	case 'verProyectosActivos':
		verProyectosActivos();
		break;
	case 'verProyectosFinalizados':
		verProyectosFinalizados();
		break;
}
?>