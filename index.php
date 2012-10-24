<?php 
	require_once("db.php");
?>
<!DOCTYPE html>
<html>

<head>
	<title>Escala</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="css/style.css" TYPE="text/css">
	<link href="css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	<script src="js/jquery-1.8.2.js"></script>
	<!-- <script src="js/jquery-ui-1.9.0.custom.js"></script> -->
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
				<div id="categoriaTitulo">
					<div>TODO categoria Titulo</div>
				</div>
				<div id="subCategorias">
					<div>TODO ajac para subcategorias de Categoria</div>
				</div>
			</div><!-- end nivel 1-->

			<div id="nivel2">
				<div id="columna1">
					<div id="descripcion">
						<div class="titulo">
							TODO titulo ajax categoria
						</div>
						<div>
							TODO descripcion
						</div>
					</div>
				</div> <!-- end columna1-->

				<div id="columna2">

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

				</div><!--end columna2 -->

			</div><!-- end nivel 2-->

		</div><!-- end content -->

	</div><!-- end main -->

</body>

</html>