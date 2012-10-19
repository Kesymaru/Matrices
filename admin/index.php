<?php
	require_once("dbAdmin.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Panel de control</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="../css/admin.css" TYPE="text/css">
	<link rel="stylesheet" href="../css/jquery.tagsinput.css" TYPE="text/css">
	<link href="../css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="../js/jquery-ui-1.9.0.custom.js"></script>
	<script src="../js/jquery.tagsinput.js"></script>
	<script src="../js/admin.js"></script>
</head>

<body>

<header>
	<img class="logo" src="../images/escala.png">
</header>

<div class="columnas">

	<div id="menu">
		<ul>
			<li id="dashboard" onClick="menu('dashboard')">
				<a>Dashboard</a>
				<ul>
					<li>
						sub
					</li>
				</ul>
			</li>
			<li id="categorias" onClick="menu('categorias')">
				<a onClick="accion('muestraCategorias')">Categorias</a>
				<ul>
					<li onClick="accion('agregarCategoria')">
						Agregar Categorias
					</li>
					<li>
						Ver todas Categorias
					</li>
				</ul>
			</li>
			<li id="clientes" onClick="menu('clientes')">
				<a onClick="accion('verClientes')">Clientes</a>
				
			</li>
			<li id="proyectos" onClick="menu('proyectos')">
				<a onClick="accion('verProyectos')">Proyectos</a>
				<ul>
					<li onClick="accion('verProyectosActivos')">
						Proyectos Activos
					</li>
					<li onClick="accion('verProyectosFinalizados')">
						Proyectos Finalizados
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div id="contenido">
		
	</div>

</div>
<footer>
	footer
</footer>
</body>

</html>

<?php


?>