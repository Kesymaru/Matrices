<?php
/* Conexion y funcionalidades de la base de datos */
session_start();

$host      =    "localhost";
$user      =    "matrizroot";
$pass      =    "Matriz159!!";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user,$pass);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

mysql_query("SET NAMES 'utf8'");

//direccion de home
$_SESSION['home'] = 'http://'.$_SERVER['HTTP_HOST'].'/Consilio';

//muestra el menu de categorias padre
//TODO agregar imagenes en ves de texto para cada una
function menu($id){
	$sql = 'SELECT DISTINCT categoria FROM registros WHERE proyecto = '.$id;
	$result = mysql_query($sql);
	$c = 0;
	while($row = mysql_fetch_array($result)){
		$sql2 = 'SELECT * FROM categorias WHERE id = '.$row['categoria'];
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2)){
			echo '<li id="'.$row2['id'].'" onClick="menu('.$row2['id'].')"> <img src="images/es.png"><br/>'.$row2['nombre'].'</li>';
			$c++;
		}
		$c++;
	}

	if($c == 0){
		echo '<span>Seleccione Categorias.</span>';
	}
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

//busca en proyectos, presenta solo los del cliente logueado
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
		$password = resetPassword();
		echo 'Se ha enviado el nuevo password al email. '.$password;

		//lo guarda en la base de datos
		$password = encripta($password);
		$sql = 'UPDATE clientes SET contrasena = \''.$password.'\' WHERE usuario = \''.$usuario.'\'';
		mysql_query($sql) or die('Error no se pudo resetaer el password.');
	}
}

function resetPasswordEmail($email){
	$nuevoPassword = nuevoPassword();
	$sql = 'SELECT * FROM clientes WHERE email = \''.$email.'\'';
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){
		$password = resetPassword();
		echo 'Se ha enviado el nuevo password al email. '.$password;
		
		//lo guarda en la base de datos
		$password = encripta($password);
		$sql = 'UPDATE clientes SET contrasena = \''.$password.'\' WHERE email = \''.$email.'\'';
		mysql_query($sql) or die('Error no se pudo resetaer el password.');
	}
}

//resetea el password por uno aleatoria
function resetPassword(){
	$passwordAleatorio = md5(uniqid(rand()));
 
	//toma los primeros 8 digitas
	$password = substr($passwordAleatorio, 0, 8);

	return $password;
}

//crea un nuevo usuario, datos minimos
function registro($usuario, $email, $password){

	if(!existeUsuario($usuario, $email)){
		$password = encripta($password);
		$fecha = date("d-m-Y");

		$sql = "INSERT INTO clientes (email, usuario, contrasena, fecha, status) VALUES ('".$email."', '".$usuario."', '".$password."', '".$fecha."', 1)";
		mysql_query($sql) or die('Error no se pudo crear nuevo usuario '.mysql_error());
		
		//envia correo
		$password = encripta($password);

		//mailRegistro($email, $usuario, $password);
	}else{
		echo 'Error el usuario o el email ya estan en usu.';
	}
	
}

//determina si el usuario existe, esto con el email o el usuario
function existeUsuario($usuario, $email){
	$sql = 'SELECT * FROM clientes WHERE usuario = \''.$usuario.'\'';
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){
		return true;
	}

	$sql = 'SELECT * FROM clientes WHERE email = \''.$email.'\'';
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){
		return true;
	}
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
			echo '<li onClick="proyecto('.$row['id'].')">'.$row['nombre'].'</li>';
		}
		echo '<li><button id="botonNuevoProyecto" onClick="proyectoNuevo();">Crear Nuevo</button>';
	}
}

/*
	PROYECTOS
*/

//busca proyecto
function buscarProyecto($buscar){
	$sql = "SELECT * FROM proyectos WHERE cliente = ".$_SESSION['id']." AND nombre LIKE '%".$buscar."%' LIMIT 0, 30";
	$result = mysql_query($sql);
	$c = 0;

	while($row = mysql_fetch_array($result)){
		echo '<li onClick="proyecto('.$row['id'].')">'.$row['nombre'].'</li>';
		$c++;
	}

	if($c == 0){
		echo 'No hay resultados para:<br/>'.$buscar;
	}
}


//muestra el toolbar del los proyectos
function proyectoControls($id){

	echo '<div id="proyectoControls" >';
	
	//resumen -> seleccionado por defecto
	echo '<input type="radio" id="resumenProyecto" checked="checked" name="radio"/>
		<label for="resumenProyecto" onClick="resumenProyecto('.$id.')">
		Resumen
		</label>';

	//editar
	echo '<input type="radio" id="editarProyecto" name="radio"/>
		<label for="editarProyecto" onClick="editarProyecto('.$id.')">
		Editar
		</label>';
	//exportar
	echo '<input type="radio" id="exportarProyecto" name="radio"/>
		<label for="exportarProyecto" onClick="exportarProyecto('.$id.')">
		Exportar
		</label>';
	
	echo '</div>';
}

function nuevaNota($proyecto, $nota){
	$nota = nl2br($nota);
	$fecha = date("d-m-Y - g:i a");
	$sql = "INSERT INTO notas (nota, proyecto, fecha, cliente) VALUES ('".$nota."', '".$proyecto."', '".$fecha."', '".$_SESSION['id']."')";
	mysql_query($sql) or die('Error al guardar nueva nota. '.mysql_error());
}

function removeNota($nota){
	$sql = 'DELETE FROM notas WHERE id = '.$nota;
	mysql_query($sql) or die( 'Error no se podo borrar la nota. '.mysql_error());
}

function proyectoNotas($id){

	$sql = 'SELECT * FROM notas WHERE proyecto = '.$id;
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_array($result)){
		echo '<div class="nota">'.$row['nota'].'</div>';
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
//r@param return array
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

function getProyectoNombre($id){
	$sql = 'SELECT * FROM proyectos WHERE id = '.$id;
	$result = mysql_query($sql);
	$row =  mysql_fetch_array($result);
	return $row['nombre'];
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
	REGISTRA LA ACTIVIDAD DEL PROYECTO AUTOGUARDADO
*/

function actividadRegistrar($proyecto, $categoria, $norma, $generalidad){
	if(actividadRegistrada($proyecto, $categoria, $norma, $generalidad)){
		//elimina la actividad
		$sql = 'DELETE FROM registros WHERE proyecto = '.$proyecto.' AND categoria = '.$categoria.' AND norma = '.$norma.' AND  generalidad = '.$generalidad;
		mysql_query($sql);
		echo 'Eliminado';
	}else{
		//registra la actividad
		$sql = "INSERT INTO registros (proyecto, categoria, norma, generalidad) VALUES ( ".$proyecto.", ".$categoria.", ".$norma.", ".$generalidad.")";
		mysql_query($sql) or die ('Error al incresar registro de actividad.'.mysql_error());
		echo 'Registrado';
	}
}

//determina si ya esta la actividad registrada
function actividadRegistrada($proyecto, $categoria, $norma, $generalidad){
	$sql = 'SELECT * FROM registros WHERE proyecto = '.$proyecto.' AND categoria = '.$categoria.' AND norma = '.$norma.' AND generalidad = '.$generalidad;
	$result = mysql_query($sql);

	if($row = mysql_fetch_array($result)){
		return true;
	}else{
		return false;
	}
}


/*
	DATOS DE PROYECTO SELECCIONADO
*/

//muestra el menu del proyecto seleccionado con las categorias seleccionadas del proyecto
function menuDatos($proyecto){
	$c = 0;
	$sql = 'SELECT DISTINCT categoria FROM registros WHERE proyecto = '.$proyecto;
	$result = mysql_query($sql);
 	
	while( $row = mysql_fetch_array($result) ){

		$sql2 = 'SELECT * FROM categorias WHERE id = '.$row['categoria'];
		$result2 = mysql_query($sql2);

		echo '<ul>';
		while( $row2 = mysql_fetch_array($result2)){
			echo '<li id="'.$row2['id'].'" ';
			
			if($c == 0){
				//mustra como seleccionada la primera
				echo 'class="seleccionada"';
				$c++;
			}

			echo 'onClick="menu('.$row2['id'].')"> <img src="images/es.png"><br/>'.$row2['nombre'].'</li>';
		}
		echo '</ul>';
	}
}

//MUESTRA LA LISTA DE NORMAS
function listaNormasDatos($id){

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

function cargarCategorias($categorias){
	foreach ($categorias as $key => $value) {
		$sql = 'SELECT * FROM categorias WHERE id = '.$value;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		echo '<li id="'.$row['id'].'" ';

		echo 'onClick="menu('.$row['id'].')"> <img src="images/es.png"><br/>'.$row['nombre'].'</li>';
	}
}

//categorias para el lista de seleccion
function categorias(){
	$sql = 'SELECT * FROM categorias WHERE parentId = 0';
	$result = mysql_query($sql);
		
	while($row = mysql_fetch_array($result)){
		echo '<div class="seleccion-option" id="seleccion'.$row['id'].'" onClick="selecciona('.$row['id'].')" >'.$row['nombre'].'</div>';
	}
}

function buscarCategoriasSeleccion($buscar){
	$sql = "SELECT * FROM categorias WHERE parentId = 0 AND nombre LIKE '%".$buscar."%' LIMIT 0, 30";
	$result = mysql_query($sql);
	
	$c = 0;

	while($row = mysql_fetch_array($result)){
		echo '<div class="seleccion-option" id="seleccion'.$row['id'].'" onClick="selecciona('.$row['id'].')" >'.$row['nombre'].'</div>';
		$c++;
	}
	if($c == 0){
		echo 'No hay resultados para:<br/>'.$buscar;
	}
}

?>
