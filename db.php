<?php
/* Conexion y funcionalidades de la base de datos */
session_start();

$host      =    "localhost";
$user      =    "root";
//$pass      =    "password";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

mysql_query("SET NAMES 'utf8'");

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
	<select id="seleccionaNorma" onChange="seleccionaNorma()">';

	while( $row = mysql_fetch_array($result) ){
		echo '<option id="'.$row['id'].'">'.$row['nombre'].'</option>';	
	}

	echo '</select>
	</div>';
}

//muestra las generalidades disponible
function generalidades(){
	$sql = 'SELECT * FROM generalidades WHERE status = 0';
	$result = mysql_query($sql);

	$c = 0;
	echo '<div id="generalidadesDisponibles">';
	echo '<div class="opciones" >';
	while($row = mysql_fetch_array($result)){

		if($c <= 3){
			echo '<input type="checkbox" id="generalidad'.$row['id'].'" />
			<label for="generalidad'.$row['id'].'" onClick="seleccionaGeneralidad('.$row['id'].')">'.$row['nombre'].'</label>';
		}
		$c++;

		if($c == 3){
			$c = 0;
			echo '</div>';
			echo '<div class="opciones" >';
		}
	}
	echo '</div>';
}

//carag la descripcion de la norma seleccionada
function descripcionNorma($id){
	$sql = 'SELECT * FROM categorias WHERE id ='.$id;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	echo '<div id="descripcionNorma">
	<div class="nombreNorma">';
	echo normaDato($row['normaId'],'nombre');
	echo '</div>';

	echo '<div class="numeroNorma">';
	echo normaDato($row['normaId'],'numero');
	echo '</div>
	</div>';

}

//muestra datos de la norma
function seleccionaGeneralidad($normaId, $generalidadId){
	$sql = 'SELECT * FROM categorias WHERE id ='.$normaId;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	echo '<div class="box" id="box'.$generalidadId.'">

		<div class="titulo">';
	echo generalidadDato($generalidadId,'nombre');
	echo '</div>';

	echo '<div class="content">';
	echo normaDato( $row['normaId'], generalidadDato($generalidadId,'consulta') );
	echo '</div>
		</div><!-- end box -->';
}

//consulta un dato especifico
function normaDato($normaId, $consulta){
	$sql = 'SELECT * FROM normas WHERE id = '.$normaId;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row[$consulta];
}

//consulta generalidad
function generalidadDato($id, $consulta){
	$sql = 'SELECT * FROM generalidades WHERE id = '.$id;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row[$consulta];
}

/*
	funciones para usuarios
*/

function logValida($nombre,$pass){
	$sql = 'SELECT * FROM clientes WHERE nombre ='.$nombre.' AND password = '.$pass;
	$result = mysql_query($sql);

	if(mysql_fetch_array($result)){
		//existe
		echo 'true';
	}else{
		echo 'false';
	}
}



/* busca en todas las tablas y devuelve el resultado formateado en html */
function buscar($buscar){
	$normas = buscarNormas($buscar);
	$categorias = buscarCategorias($buscar);
	$proyectos = buscarProyectos($buscar);
	
	if($normas == '' && $categorias == '' && $proyectos == ''){
		echo '<div id="mensajeInicial">
				No hay resultados para '.$buscar.'
			  </div>';
	}else{
		echo $normas;
		echo $categorias;
		echo $proyectos;
	}
}

//realiza busqueda en normas
function buscarNormas($busqueda){

	$consultas = array( 0 => 'nombre', 1 => 'numero', 2 => 'requisito', 3 => 'permisos', 4 => 'entidad', 5 => 'resumen');
	$resultadoTemp = '';
	$resultado = '';
	$contador = 0;

	foreach ($consultas as $key => $value) {

		$sql = "SELECT * FROM normas WHERE ".$consultas[$key]." LIKE '%".$busqueda."%' LIMIT 0, 30";
		$result = mysql_query($sql);

		$c = 0;
		while( $row = mysql_fetch_array($result)){
			$resultadoTemp .= '<div class="resultado">
			<ul class="etiqueta"><li><a href="#">';
			
			if($consultas[$key] == 'nombre'){
				$resultadoTemp .= 'Norma';
			} else if($consultas[$key] == 'numero'){
				$resultadoTemp .= 'N° Norma';
			}else{
				$resultadoTemp .= $consultas[$key];
			}

			$resultadoTemp .= '</a></li></ul>
			 '.$row[$consultas[$key]].'</div>';
			$contador++;
		}
	}
	if($contador > 0){
		$resultado .= '<div class="resultados">
					<div class="titulo">'.$contador.' Resultado';
		if($contador > 1){
			$resultado .='s'; //plural para resultados
		}
		$resultado .= ' para Normas</div>'.$resultadoTemp.'</div>';
	}

	$contador = 0;

	return $resultado;
}


//realiza busqueda en categoria
function buscarCategorias($busqueda){
	$resultadoTemp = '';
	$resultado = '';
	$contador = 0;

	$sql = "SELECT * FROM categorias WHERE nombre LIKE '%".$busqueda."%' LIMIT 0, 30";
	$result = mysql_query($sql);


	while($row = mysql_fetch_array($result)){
		$resultadoTemp .= '<div class="resultado"><ul class="etiqueta"><li><a href="#">';
		
		if($row['parentId'] > 0){
			$resultadoTemp .= 'Seccion';
		}else if($row['parentId'] == 0){
			$resultadoTemp .= 'Categoria';
		}else{
			$resultadoTemp .= 'Categoria';
		}

		$resultadoTemp .= '</a></li></ul>'.$row['nombre'].'</div>';
		$contador++;
	}

	if($contador > 0){
		$resultado .= '<div class="resultados">
					<div class="titulo">'.$contador.' Resultado';
		if($contador > 1){
			$resultado .='s'; //plural para resultado(s)
		}
		$resultado .= ' para Categoria';
		if($contador > 1){
			$resultado .='s'; //plural para Categoria(s)
		}
		$resultado .='</div>'.$resultadoTemp.'</div>';
	}

	$contador = 0;
	return $resultado;
}

//nusca en proyectos, presenta solo los del cliente logueado
function buscarProyectos($busqueda){
	$contador = 0;
	$resultadoTemp = '';
	$resultado = '';

	$sql = "SELECT * FROM proyectos WHERE cliente = ".$_SESSION['id']." AND nombre LIKE '%".$busqueda."%' LIMIT 0, 30";
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){
		$resultadoTemp .= '<div class="resultado"><ul class="etiqueta"><li><a href="#">Proyecto';
		$resultadoTemp .= '</a></li></ul>'.$row['nombre'].'</div>';
		$contador++;
	}

	if($contador > 0){
		$resultado .= '<div class="resultados">
					<div class="titulo">'.$contador.' Resultado';
		if($contador > 1){
			$resultado .='s'; //plural para resultado(s)
		}
		$resultado .= ' para Proyecto';
		if($contador > 1){
			$resultado .='s'; //plural para Categoria(s)
		}
		$resultado .='</div>'.$resultadoTemp.'</div>';
	}

	$contador = 0;
	return $resultado;
}

/*
	autentificaciones de usuarios
*/

function logIn($usuario, $password){
	$password = encripta($password);
	$sql = 'SELECT * FROM clientes WHERE usuario = \''.$usuario.'\' AND contrasena = \''.$password.'\' AND status = 1';
	$result = mysql_query($sql);

	if( $row = mysql_fetch_array($result) ){
		//existe
		$_SESSION['id'] = $row['id'];
		$_SESSION['nombre'] = $row['nombre'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['skype'] = $row['skype'];
		$_SESSION['logueado'] = true;
		$_SESSION['bienvenida'] = false;
	}else{
		//no es un usuario valido
		echo 'El usuario o la contraseña es incorrecta';
	}
}

//cierra session
function logOut(){
	session_unset();
	session_destroy();
	echo 'true';
}

//resetea password
function resetPasswordUsuario($usuario){
	$nuevoPassword = nuevoPassword();
	$sql = 'SELECT * FROM clientes WHERE usuario = \''.$usuario.'\'';
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){

	}else{
		echo 'Error el usuario no se encuentra registrado.';
	}
}

function resetPasswordEmail($email){
	$nuevoPassword = nuevoPassword();
	$sql = 'SELECT * FROM clientes WHERE email = \''.$email.'\'';
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){
		
	}else{
		echo 'Error el email no se encuentra registarado';
	}
}

//crea un nuevo usuario, datos minimos
function nuevoUsuario($usuario, $email, $password){
	$password = encripta($password);
	$fecha = date("d-m-Y");

	$sql = "INSERT INTO clientes (email, usuario, contrasena, fecha, status) VALUES ('".$email."', '".$usuario."', '".$password."', '".$fecha."', 0)";
	mysql_query($sql) or die('Error no se pudo crear nuevo usuario '.mysql_error());
}

/*
	MENUS
*/

//para el menu de proyectos del usuario
function menuProyectos(){
	if(isset($_SESSION['id'])){
		$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'];
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result)){
			//echo '<li>'.$row['nombre'].'</li>';
			echo '<li>'.$row['nombre'].'</li>';
		}
		echo '<li><button onClick="proyecto();">Crear Nuevo</button>';

	}
}

//menu usuario
function menuUsuario(){
	//TODO imagen del usuario
	echo '<li onClick="editar();"><img src="images/es.png"></li>';
	echo '<li><button onClick="editar();">Editar</button>';
	echo '<button onClick="logOut();">Salir</button></li>';
}


/*
	ACTUALIZAN DATOS USUARIO
*/

function setNombre($nombre){
	$sql = 'UPDATE clientes SET nombre = \''.$nombre.'\' WHERE id = '.$_SESSION['id'];
	mysql_query($sql);
	//actualiza en session
	$_SESSION['nombre'] = $nombre;
}

function setEmail($email){
	$sql = 'UPDATE clientes SET email = \''.$email.'\' WHERE id = '.$_SESSION['id'];
	mysql_query($sql);
	$_SESSION['email'] = $email;
}

function setTelefono($telefono){
	$sql = 'UPDATE clientes SET telefono = '.$telefono.' WHERE id = '.$_SESSION['id'];
	mysql_query($sql);
}

function setSkype($skype){
	$sql = 'UPDATE clientes SET skype = \''.$skype.'\' WHERE id = '.$_SESSION['id'];
	mysql_query($sql);
}

function setPassword($password){
	$password = encripta($password);
	$sql = 'UPDATE clientes SET contrasena = \''.$password.'\' WHERE id = '.$_SESSION['id'];
	if(mysql_query($sql)){
		echo 'pass actualizado';
	}
}

/*
	ACCESO A DATOS DEL USUARIO
*/

function getNombre(){
	$sql = 'SELECT * FROM clientes WHERE id = '.$_SESSION['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['nombre'];
}

function getEmail(){
	$sql = 'SELECT * FROM clientes WHERE id = '.$_SESSION['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['email'];
}

function getTelefono(){
	$sql = 'SELECT * FROM clientes WHERE id = '.$_SESSION['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['telefono'];
}

function getSkype(){
	$sql = 'SELECT * FROM clientes WHERE id = '.$_SESSION['id'];
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['skype'];
}

/*
	DATOS PROYECTOS
*/

//regresa los proyectos del usuario
//r@param eturn array
function getProyectos(){
	$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'];
	$result =  mysql_query($sql);

	$nombres = array();
	$c = 0;

	while($row = mysql_fetch_array($result)){
		$nombres[$c] = $row['nombre'];
		$c++;
	}

	return $nombres;
}

//registra nuevo proyecto
function nuevoProyecto($proyecto, $descripcion){
	$fecha = date("d-m-Y");
	$sql = "INSERT INTO proyectos (nombre, descripcion, fecha, cliente, status) VALUES ('".$proyecto."','".$descripcion."', '".$fecha."', '".$_SESSION['id']."', 1 )";

	mysql_query($sql);
}

/*
	ENCRIPTA EL PASSWORD
*/

//encrita o desencrita password
function encripta($text){
	//quita / y etiquetas html
	$text = stripcslashes($text);
	$text = strip_tags($text);
	$text = md5 ($text); 
	$text = crc32($text);
	$text = crypt($text, "xtemp"); 
	$text = sha1("xtemp".$text);
	return $text;
}

function nuevoPassword(){
	return 'temporal';
}

/*
	ENVIA EMAILS DEL SISTEMA
*/

function mailResetPassword($para, $password){

$admin = 'andreyalfaro@gmail.com';
$tema = "Contraseña Nueva";
$mensaje = "Su contraseña nueva es:
<br/>
Contraseña: $emailpassword
<br/><br/>
Para incresar http://localhost/Matrices/
<br/><br/>
Este correo ha sido generado automaticamente."; 
 
	if(!mail($para, $tema, $mensaje,  "FROM: $admin")){
		die ("Sending Email Failed, Please Contact Site Admin! ($admin)");
	}else{
		error('New Password Sent!.');
	} 

}

?>