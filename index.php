<?php 
	require_once("db.php"); 

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = $_SESSION['home']."/login.php";
	header('Location: '.$home);
	exit;
}

?>
<!doctype html public>
<!--[if lt IE 7]> <html lang="en-us" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us"> <!--<![endif]-->
<html>

<head>
	<title>Escala</title>
	
	<meta charset="utf-8">
	<link rel="shortcut icon" href="/favicon.ico"> 

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui-1.9.0.custom.css" type="text/css">
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800italic,800,600,400italic,600italic,700italic' rel='stylesheet' type='text/css'>

	<script type="text/javascript" src="js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.9.0.custom.js"></script>
	
	<!-- validacion de form -->
	<script type="text/javascript" src="js/languages/jquery.validationEngine-es.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery.validationEngine.js" charset="utf-8"></script>

	<!-- placeholder para ie -->
	<script src="js/jquery.placeholder.js" type="text/javascript"></script>

	<!-- notificaciones -->
	<script type="text/javascript" src="js/noty/jquery.noty.js" ></script>
	<script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>
	<script type="text/javascript" src="js/noty/themes/default.js"></script>

	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/style.js"></script>
	
</head>

<body >

<?php
	//muestra bienvenida una sola ves para cada logueo
	if(!$_SESSION['bienvenida']){
		echo '<script type="text/javascript">notifica(\'Bienvenido '.$_SESSION['nombre'].'\')</script>';
		$_SESSION['bienvenida'] = true;
	}
?>
	<!-- dialogo emerjente -->
	<div id="dialogo">
		<div id="dialogoPrincipal">
			<a href="#" id="closeDialogo" onClick="closeDialogo()">
				<img src="images/close.png">
			</a>
			<!-- close button -->
			<div id="dialogoContenido">
				<!-- contenido AJAX -->
				contenido
			</div>
		</div>
	</div>

	<header>
		<a href="index.php">
			<img src="images/logo.png" class="logo">
		</a>

		<div class="toolbar">
			<div id="cliente">
				<div id="usuario">
					<?php
						echo $_SESSION['nombre'];
					?>
					<ul class="dropMenu" id="menuUsuario">
						<?php
							menuUsuario();
						?>
					</ul>
				</div id="usuario">
				<div id="proyectos">
					Proyectos
					<ul class="dropMenu" id="menuProyectos">
						<?php
							menuProyectos();
						?>
					</ul>
				</div>
			</div>
			<div id="search">
				<form id="searchForm" method="get" action="index.php">
					<input type="text" class="validate[required]" data-prompt-position="bottomRight" placeholder="hacer busqueda" required="requiered" name="buscar">
					<input type="submit" name="accion">
				</form>
			</div>
		</div>


	</header>

	<div id="main">
		
		<div id="menu">
			<div class="menu">
				<ul>
					<?php
						//display las normas
					if(isset($_GET['proyecto'])){
						menu($_GET['proyecto']);
					}

					?>
				</ul>
			</div>
			<!-- menu -->

			<!-- super controles para categoria, agregar y borrar -->
			<div id="super" class="super" >
				<div>
					Categorias<br/>
					<!-- agrega categoria / borrar categoria seleccionada -->
					<button id="nuevaCategoria">+</button>
					<button id="borrarCategoria">-</button>
				</div>
			</div>
			<!-- end super -->

		</div>
		<!-- end menu -->

		<div id="content">
			
				<?php
				if(isset($_GET['buscar'])){
				?>
					<div id="resultadoBusqueda">
						<?php
							echo "<script language=javascript>buscar('".$_GET['buscar']."')</script>";
						?>
					</div>
				<?php
				}else if(!isset($_GET['proyecto'])){
				?>
					<div id="mensajeInicial">
						Selecione un proyecto o cree uno nuevo para empezar.
						<br/>
						<button onClick="proyectoNuevo()">Crear Proyecto</button>
						<?php
							//determina si el cliente tiene proyectos
							$sql = 'SELECT * FROM proyectos WHERE cliente = '.$_SESSION['id'];
							$result = mysql_query($sql);
							if($row = mysql_fetch_array($result)){
								echo '<button onClick="verProyectos()">Seleccionar Proyecto</button>';
							}
						?>
					</div>
				<?php 
				}

				//carga los datos de un proyecto
				if(isset($_GET['proyecto'])){
					echo '<div id="titulo">';
					echo getProyectoNombre($_GET['proyecto']);
					
					//controles del proyecto
					echo '</div>
						<div class="topControls" id="proyectoControls">
						</div>
						<script type="text/javascript">
							//fija el proyecto seleccionado
							setProyecto('.$_GET['proyecto'].');
							proyectoControls('.$_GET['proyecto'].');
							resumenProyecto();
						</script>';
				}

				?>
			<div id="nivel1">

				<div id="listaNormas">
					
				</div>
				<div id="generalidades">
					
				</div>

			</div><!-- end nivel 1-->

			<div id="nivel2">
				<div id="columna1">
					<!--
					<div id="descripcionNorma">
						
						<div class="nombreNorma">
							TODO titulo ajax categoria
						</div>
						<div>
							TODO descripcion
						</div>
						
					</div>
					-->
				</div> <!-- end columna1-->

				<div id="columna2">
					<!--
					<div class="box">
						TODO ajax para mostrar informacion de subcategorias<br/>
						TODO mansory para acomodar las columnas
					</div>
					<div class="box">
						TODO ajax para mostrar informacion de subcategorias<br/>
						TODO mansory para acomodar las columnas
						<br/>
						<br/>
					</div>
					<div class="box">
						TODO ajax para mostrar informacion de subcategorias<br/>
						TODO mansory para acomodar las columnas
						<br/>
						<br/>
						<br/>
						<br/>
					</div>
					<div class="box">
						TODO ajax para mostrar informacion de subcategorias<br/>
						TODO mansory para acomodar las columnas
					</div>
					MODELO PARA BOX -->
					
				</div><!--end columna2 -->

			</div><!-- end nivel 2-->

		</div><!-- end content -->

	</div><!-- end main -->

</body>

</html>