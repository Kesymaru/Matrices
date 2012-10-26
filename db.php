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
	/*$consultas = array(0 => 'normas', 1 => 'categorias', 2 => 'proyectos' );

	foreach ($consultas as $key => $value) {
			
		$sql = "SELECT * FROM ".$consultas[$key]." WHERE nombre LIKE '%".$buscar."%' LIMIT 0, 30 ";
		$result = mysql_query($sql);
		
		$contador = 0;	
		$busqueda = '';

		while ($row = mysql_fetch_array($result)){
			$busqueda .= '<div class="resultado">'.$row['nombre'].'</div>';
			$contador++;
		}
		if($contador > 0){
			echo 
		$contador = 0;
	}*/
	echo buscarNormas($buscar);
	echo buscarCategorias($buscar);
	echo buscarProyectos($buscar);
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

?>