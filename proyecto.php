<?php
require_once("db.php"); 

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
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
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css?v=2.1.2" type="text/css" media="screen" />

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>

	<!-- fancy box -->
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.3"></script>
	
	<!-- validacion de form -->
	<script src="js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

	<!-- placeholder para ie -->
	<script src="js/jquery.placeholder.js" type="text/javascript"></script>

	<script src="js/main.js" type="text/javascript"></script>
	
</head>

<body>
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
			<?php
				menu();
			?>
		</div><!-- end menu -->

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
				}else{
				?>
					<div id="mensajeInicial">
						Seleccione una opcion.
					</div>
				<?php 
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