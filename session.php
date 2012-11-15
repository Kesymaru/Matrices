<?php
require_once("src/class/classDatabase.php");

class Session{

	public function __construct(){
		//session_start();
	}
	
	/**
	* SEGURIDAD USUARIO DEBE ESTAR LOGUEADO
	* return true si lo esta sino redirecciona al login.php
	*/
	public function logueado(){
		if( !isset($_SESSION['logueado']) ){
			$home = $_SESSION['home']."/login.php";
			header('Location: '.$home);
			exit;
		}else{
			return true;
		}
	}

	/**
	* SE ENCARGA DE LOGUEAR USUARIO
	*/
	public function login($usuario, $password){
		$base = new Database();

		$password = $base->encripta($password);
		$datos = array('usuario' => $usuario, 'contrasena' => $password);
		
		//existe el usuario
		if( $base->exits('clientes', '*', $datos) ){
			$this->iniciarSession($usuario, $password);
		}else{
			echo 'El usuario o la contraseña es incorrecta';
		}
	}

	/**
	* INICIALIZA LA SESSION DE UN USUARIO
	*/
	private function iniciarSession($usuario, $password){

		$base = new Database();
		
		$where = " usuario = '".$usuario."' AND contrasena = '".$password."'";
		
		$base->querySelect('clientes','',"*",$where,'','');

		$datos = $base->getRecordSet();

		$_SESSION['id'] = $datos['id'];
		$_SESSION['nombre'] = $datos['nombre'];
		$_SESSION['email'] = $datos['email'];
		$_SESSION['skype'] = $datos['skype'];
		$_SESSION['logueado'] = true;
		$_SESSION['bienvenida'] = false;
		$_SESSION['test'] = '2';

	}

	/**
	* LOGOUT PARA USUARIO
	*/
	public function logout(){
		session_unset($_SESSION['logueado']);
		$_SESSION = array();
		session_destroy ();
	}
}

?>