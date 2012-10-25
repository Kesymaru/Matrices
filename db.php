<?php
/* Conexion y funcionalidades de la base de datos */

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

	echo '<div class="nombreNorma">';
	echo normaDato($row['normaId'],'nombre');
	echo '</div>';

	echo '<div class="numeroNorma">';
	echo normaDato($row['normaId'],'numero');
	echo '</div>';

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

	echo '<div>';
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

?>