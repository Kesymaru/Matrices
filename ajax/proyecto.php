<?php 

require_once("../db.php"); 


//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

?>

<div id="menu">
	<?php
		if( isset($_GET['id']) ){
			//muestra lista con uno seleccionado
			vistaProyectosId($_GET['id']);
			echo '<script type="text/javascript">muestraProyecto('.$_GET['id'].');</script>';
		}else{
			//muestra lista sin seleccionar uno
			vistaProyectos();
		}
	?>
</div><!-- end menu -->

		<div id="content">

			<div class="topControls" id="proyectoControls">
				
			</div>

			<div id="mensajeInicial">
				Seleccione un proyecto o cree uno nuevo.
			</div>

			<div id="nivel1">

				<div id="listaNormas">
					
				</div>
				<div id="generalidades">
					
				</div>

			</div><!-- end nivel 1-->

			<div id="nivel2">
				<div id="columna1">
					

				</div> <!-- end columna1-->

				<div id="columna2">
					
					
				</div><!--end columna2 -->

			</div><!-- end nivel 2-->

		</div><!-- end content -->