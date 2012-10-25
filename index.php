<?php 
	require_once("db.php"); 
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

	<link rel="stylesheet" href="css/style.css" TYPE="text/css">
	<link href="css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.0.custom.js"></script>
	<script src="js/main.js"></script>
</head>

<body>

	<header>
		<img src="images/logo.png" class="logo">

		<div class="toolbar">
			<div id="cliente">
				<span>Cliente Nombre</span>
				<ul id="proyectos">
					<li>
						Proyectos
					</li>
				</ul>
			</div>
			<div id="search">
				<input type="text" placeholder="hacer busqueda" required="requiered">
				<button>Send</button>
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

			<div id="nivel1">

				<div id="listaNormas">
					<div class="norma"></div>
				</div>
				<div id="generalidades">
					<div>TODO ajac para generalidades de Categoria</div>
				</div>

			</div><!-- end nivel 1-->

			<div id="nivel2">
				<div id="columna1">
					<div id="descripcionNorma">
						<!--
						<div class="nombreNorma">
							TODO titulo ajax categoria
						</div>
						<div>
							TODO descripcion
						</div>
						end estructura ejemplo-->
					</div>
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