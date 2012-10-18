<?php
	require_once("dbAdmin.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Registro</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="../css/admin.css" TYPE="text/css">
	<link rel="stylesheet" href="../css/jquery.tagsinput.css" TYPE="text/css">
	<link href="../css/jquery-ui-1.9.0.custom.css" rel="stylesheet">

	<script src="../js/jquery-1.8.2.js"></script>
	<script src="../js/jquery-ui-1.9.0.custom.js"></script>
	<script src="../js/jquery.tagsinput.js"></script>
	<script src="../js/admin.js"></script>
</head>

<body>

<header>
	Admin
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
				<a>Categorias</a>
				<ul>
					<li>
						Agregar Categorias
					</li>
					<li>
						Ver todas Categorias
					</li>
				</ul>
			</li>
			<li id="clientes" onClick="menu('clientes')">
				<a>Clientes</a>
				<ul>
					<li>
						Ver Clientes
					</li>
				</ul>
			</li>
			<li id="proyectos" onClick="menu('proyectos')">
				<a>Proyectos</a>
				<ul>
					<li>
						Ver Proyectos
					</li>
					<li>
						Proyectos Activos
					</li>
					<li>
						Proyectos Finalizados
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div id="contenido">
		contenido
	</div>

</div>
<footer>
	footer
</footer>
</body>

</html>

<?php


?>