<?php
/* Conexion y funcionalidades de la base de datos */
session_start();
$_SESSION['superParent'] = 0;

$host      =    "localhost";
$user      =    "root";
//$pass      =    "password";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());

//muestra todos los clientes
function verClientes(){

	$sql = 'SELECT * FROM clientes';
	$result = mysql_query($sql);

	echo '<h1>Clientes</h1>';
	echo '<div id="muestraClientes">';

	while( $row = mysql_fetch_array($result) ){

		echo '<h3>'.$row['nombre'].'</h3>';

		echo '<div id="'.$row['id'].'">
			<table class="datos">
			<tr>
				<td>
					Nombre:
				</td>
				<td>
					<input type="text" name="nombre" disabled="disabled" required="required" value="'.$row['nombre'].'">
				</td>
			</tr>
			<tr>
				<td>
					Email:
				</td>
				<td>
					<input type="email" name="email" disabled="disabled" required="required" value="'.$row['email'].'">
				</td>
			</tr>
			<tr>
				<td>
					Telefono:
				</td>
				<td>
					<input type="number" name="telefono" disabled="disabled" required="required" value="'.$row['telefono'].'">
				</td>
			</tr>
			<tr>
				<td>
					Fecha Ingreso:
				</td>
				<td>
					'.$row['fecha'].'
				</td>
			</tr>
			';

		if($row['skype'] !== ''){
		echo '
			<tr>
				<td>
					Skype:
				</td>
				<td>
					<input type="text" name="skype" disabled="disabled" required="required" value="'.$row['skype'].'">
				</td>
			</tr>
		';
		}

		echo '
			<tr>
				<td>
					Id:
				</td>
				<td>
					'.$row['id'].'
				</td>
			</tr>
			</table>
			<div class="edicion">
				<button id="editarCliente'.$row['id'].'" onClick="editarCliente(\''.$row['id'].'\')">Editar</button>
			</div>
		</div>';
	}
	echo '</div>';
}

/* muestra un cliente */
function verCliente($id){
	$sql = 'SELECT * FROM clientes WHERE id = '.$id;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	return $row['nombre'];
}

/*
	funciones paa actualizar los datos del cliente
*/
function actualizaNombre($id, $nombre){

	$sql = 'UPDATE clientes SET nombre = \''.$nombre.'\' WHERE id = '.$id;
	echo $sql;
	if( mysql_query($sql)){
		echo 'actualizado';
	}

}

function actualizaEmail($id, $email){

	$sql = 'UPDATE clientes SET email = \''.$email.'\' WHERE id = '.$id;
	echo $sql;
	if( mysql_query($sql)){
		echo 'actualizado';
	}

}

function actualizaTelefono($id, $telefono){

	$sql = 'UPDATE clientes SET telefono = '.$telefono.' WHERE id = '.$id;
	echo $sql;
	if( mysql_query($sql)){
		echo 'actualizado';
	}

}

function actualizaSkype($id, $skype){

	$sql = 'UPDATE clientes SET skype = \''.$skype.'\' WHERE id = '.$id;
	echo $sql;
	if( mysql_query($sql)){
		echo 'actualizado';
	}

}

/* muestra todos los proyectos */
function verProyectos(){

	$sql = 'SELECT * FROM proyectos';
	$result = mysql_query($sql);

	echo '<h1>Proyectos</h1>';
	echo '<div id="muestraProyectos">';

	while( $row = mysql_fetch_array($result) ){

		echo '<h3>'.$row['nombre'].'</h3>';

		echo '<div>
			<table class="datos">
			<tr>
				<td>
					Nombre:
				</td>
				<td>
					'.$row['nombre'].'
				</td>
			</tr>
			<tr>
				<td>
					Cliente:
				</td>
				<td>
					'.verCliente($row['id']).'
				</td>
			</tr>
			<tr>
				<td>
					Estado:
				</td>
				<td>
					';
		if($row['status'] == 0){
			echo 'Activo';
		}else{
			echo 'Finalizado';
		}
		echo '
				</td>
			</tr>
			</table>
			Descripcion
			<p>
				'.$row['descripcion'].'
			</p>
			</div>';
	}
	echo '</div>';
}

/* muestra proyectos activos */
function verProyectosActivos(){

	$sql = 'SELECT * FROM proyectos WHERE status = 0';
	$result = mysql_query($sql);

	echo '<h1>Proyectos Activos</h1>';
	echo '<div id="muestraProyectos">';

	while( $row = mysql_fetch_array($result) ){

		echo '<h3>'.$row['nombre'].'</h3>';

		echo '<div>
			<table class="datos">
			<tr>
				<td>
					Nombre:
				</td>
				<td>
					'.$row['nombre'].'
				</td>
			</tr>
			<tr>
				<td>
					Cliente:
				</td>
				<td>
					'.verCliente($row['id']).'
				</td>
			</tr>
			<tr>
				<td>
					Estado:
				</td>
				<td>
					';
		if($row['status'] == 0){
			echo 'Activo';
		}else{
			echo 'Finalizado';
		}
		echo '
				</td>
			</tr>
			</table>
			Descripcion
			<p>
				'.$row['descripcion'].'
			</p>
			</div>';
	}
	echo '</div>';
}

/* muestra proyectos activos */
function verProyectosFinalizados(){

	$sql = 'SELECT * FROM proyectos WHERE status = 1';
	$result = mysql_query($sql);

	echo '<h1>Proyectos Finalizados</h1>';
	echo '<div id="muestraProyectos">';

	while( $row = mysql_fetch_array($result) ){

		echo '<h3>'.$row['nombre'].'</h3>';

		echo '<div>
			<table class="datos">
			<tr>
				<td>
					Nombre:
				</td>
				<td>
					'.$row['nombre'].'
				</td>
			</tr>
			<tr>
				<td>
					Cliente:
				</td>
				<td>
					'.verCliente($row['id']).'
				</td>
			</tr>
			<tr>
				<td>
					Estado:
				</td>
				<td>
					';
		if($row['status'] == 0){
			echo 'Activo';
		}else{
			echo 'Finalizado';
		}
		echo '
				</td>
			</tr>
			</table>
			Descripcion
			<p>
				'.$row['descripcion'].'
			</p>
			</div>';
	}
	echo '</div>';
}

/* 
	CATEGORIAS 
*/

/* muestra todas la categorias anidadas */
function muestraCategorias(){
	$hijo = 0;
	$nivel = 0;
	$sql = 'SELECT * FROM categorias WHERE parentId = 0';
	$result = mysql_query($sql);

	echo '<h1>Categorias</h1>';

	echo '<div id="muestraCategorias">';

	while( $row = mysql_fetch_array($result) ){
		echo '<h3>'.$row['nombre'].'
			<button onClick="categoriaEditar('.$row['id'].')" class="categoriaEditar">Editar</button>
		</h3>';
		echo '<div>';

		echo '<table class="categorias" id="categoria'.$row['id'].'">';

		if( tieneHijos($row['id']) ){
			$nivel++;
			
			echo '
			<tr id="tabla'.$row['id'].'">	

			<td id="categoria'.$row['id'].'">
				<div class="hijos" id="hijos'.$row['id'].'">
					<h3>Nivel '.$nivel.'</h3><br/>
				';
			echo muestraHijos($row['id']);
			echo'	
				</div> <!-- ends hijos -->

				<div class="edicion" id="agregar'.$row['id'].'">
					<input type="text" name="nuevo" id="nuevo'.$row['id'].'" placeholder="Nueva categoria">
				</div> <!-- ends agregar -->

				<div class="edicion" id="edicion'.$row['id'].'">
					<button onClick="">Editar</button>
					<button onClick="nuevoHijo('.$row['id'].')">Agregar</button><br/>
				</div> <!-- ends edicion -->
				
			</td>
			</tr>
			';

		}else{
			echo '
			<tr id="'.$row['id'].'">
			<td>
				<div class="hijos" id="hijos'.$row['id'].'">
					Esta categoria no tiene Hijos
				</div> <!-- ends hijos -->

				<div class="edicion" id="agregar'.$row['id'].'">
					<input type="text" name="nuevo" id="nuevo'.$row['id'].'" placeholder="Nueva categoria">
					<button onClick="nuevoHijo('.$row['id'].')">Agregar</button><br/>
				</div> <!-- ends agregar -->

			</td>
			</tr>
			';
		}
		
		echo '
			</table> <!-- ends table -->
		</div>';
		$hijo = 0;
		$nivel = 0;
	}
	echo '</div>';
}

//muesta los hijos desplegados
function categoriaHija($superParent,$parentId){
	if( tieneHijos($parentId) ){

			echo '
				<div class="hijos" id="hijos'.$parentId.'">
					<h3>
			';

			echo nombrePadre($parentId).'
					</h3><br/>
			';

			echo subCategorias($superParent,$parentId);

			echo'	
				</div> <!-- ends hijos -->

				<div class="edicion" id="agregar'.$parentId.'">
					<input type="text" name="nuevo" id="nuevo'.$parentId.'" placeholder="Nueva categoria">
				</div> <!-- ends agregar -->

				<div class="edicion" id="edicion'.$parentId.'">
					<button onClick="">Editar</button>
					<button onClick="nuevoHijo('.$parentId.')">Agregar</button><br/>
				</div> <!-- ends edicion -->
			';
		}else{
			echo '
				<div class="hijos" id="hijos'.$parentId.'">
				<h3>';
			echo nombrePadre($parentId).' </h3>
			<br/>No tiene Hijos
				</div> <!-- ends hijos -->

				<div class="edicion" id="agregar'.$parentId.'">
					<input type="text" name="nuevo" id="nuevo'.$parentId.'" placeholder="Nueva categoria">
				</div> <!-- ends agregar -->

				<div class="edicion" id="edicion'.$parentId.'">
					<button onClick="">Editar</button>
					<button onClick="nuevoHijo('.$parentId.')">Agregar</button><br/>
				</div> <!-- ends edicion -->
			';
		}
}

//muestra hijos de id para ajax
function subCategorias($superParent,$id){
	$sql = 'SELECT * FROM categorias WHERE parentId = '.$id;
	$result = mysql_query($sql);

	echo '<select id="'.$id.'" onChange="subCategoria('.$superParent.','.$id.')">'; //parentId
	echo '<option id="null" ></option>';

	while( $row = mysql_fetch_array($result) ){
		//id del hijo
		echo '<option id="'.$row['id'].'">'.$row['nombre'].'</option>';
	}

	echo '</select>';
}

//muestra hijos de un parent
function muestraHijos($id){
	$sql = 'SELECT * FROM categorias WHERE parentId = '.$id;
	$result = mysql_query($sql);

	echo '<select id="'.$id.'" onChange="seleccionaCategoria('.$id.')">'; //parentId
	echo '<option></option>';
	while( $row = mysql_fetch_array($result) ){
		//id del hijo
		echo '<option id="'.$row['id'].'">'.$row['nombre'].'</option>';
	}
	echo '</select>';
}

//determina si la categoria tiene hijos, return true si tiene
function tieneHijos($id){
	$sql = 'SELECT * FROM categorias WHERE parentId = '.$id;
	$result = mysql_query($sql);

	if( mysql_fetch_array($result) ){
		return true; //hay hijos
	}else{
		return false; //no tiene hijos
	}
}

function nombrePadre($parentId){
	$sql = 'SELECT * FROM categorias WHERE id = '.$parentId;
	$result = mysql_query($sql);

	if( $row = mysql_fetch_array($result) ){
		echo $row['nombre'];
	}
}

//formulario para categoria nueva
function formularioCategoriaNueva(){
	echo 'Hola formulario';
}

//para mostrar todo el arbol de categorias
function verCategorias(){
	echo 'TODO: verCategorias en dbAdmin.php';
}

/* 
	Funciones para actualiza la categorias y sus subcategorias
*/

//crea un nuevo hijo de una categoria
function nuevoHijo($parentId, $nombre){
	$sql = "INSERT INTO categorias (nombre, parentId) VALUES ('".$nombre."', '".$parentId."')";
	echo $sql;
	mysql_query($sql);
}