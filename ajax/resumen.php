<?php 
	require_once("../db.php"); 
/*
	muestra el resumen del proyecto y sus notas
*/

//logueo
if( !isset($_SESSION['logueado']) ){
	$home = "/Matrices/login.php";
	echo "<script type='text/javascript'>top.location.href = '$home';</script>";
	exit;
}

?>

<script type="text/javascript">

	$('#resumenProyecto button, input:reset, .controls button').button();

	$('input[placeholder]').placeholder();
	$('textarea[placeholder]').placeholder();

	$('#notaNuevaProyectos').hide();
	$('#edicionResumenProyecto').hide();
	$('#edicionNotaProyecto').hide();

	$('#editarResumenProyecto').click(function (){
		cambiaControlesResumenProyecto();
	});

	$('#enviarResumenProyecto').click(function (){
		//funcion para enviar y actualizar
	});

	$('#cancelarEditarResumenProyecto').click(function(){
		cambiaControlesResumenProyecto();
	})

	cargarResumenProyecto()

	function mostrarAgregarNota(){

		desactivaEdicionProyecto();

		if($('#notaNuevaProyectos').is(':visible')){
			$('#notaNuevaProyectos').slideUp(500, function (){
				$('#edicionResumenProyecto').hide();
				$('#edicionNotaProyecto').fadeOut(500, function(){
					$('#edicionNotaProyecto').hide();
					$('#editarResumenProyecto').fadeIn();
				});

			});
		}else{
			
			$('#notaNuevaProyectos').slideDown(500, function (){
				console.log('muestra');
				$('#edicionResumenProyecto').hide();
				$('#editarResumenProyecto').fadeOut(500,function(){
					$('#editarResumenProyecto').hide();
					$('#edicionNotaProyecto').fadeIn(500);
				})
				
			});
		}

	}

	function cambiaControlesResumenProyecto(){

		if($('#editarResumenProyecto').is(':visible')){
			//activa la edicion
			activaEdicionResumenProyecto()
			$('#editarResumenProyecto').fadeOut(500, function (){
				$('#editarResumenProyecto').hide();
				$('#edicionResumenProyecto').fadeIn(500);
			});
		}
		else{
			//desactiva la edicion
			desactivaEdicionProyecto();
			$('#edicionResumenProyecto').fadeOut(500, function (){
				$('#edicionResumenProyecto').hide();
				$('#editarResumenProyecto').fadeIn(500);
			});
		}
		
	}

	//activa edicion
	function activaEdicionResumenProyecto(){
		$('.editable').attr('disabled', false);
	}

	function desactivaEdicionProyecto(){
		$('.editable').attr('disabled', true);
	}

	function cargarResumenProyecto(){
		query = {'func': 'resumenProyecto', 'id': Proyecto};
		$.ajax({
			data: query,
			url: 'ajax.php',
			type: 'post',
			success: function(response){
				$('#cargaResumenProyecto').html(response);
				$("#fechaResumenProyecto").datepicker();
		        $("#fechaResumenProyecto").datepicker( "option", "showAnim", "slideDown");
			}
		});
	}

	function cargarNotasProyecto(){
		query = {'func': 'notasProyecto', 'id': Proyecto};
		$.ajax({
			data: query,
			url: 'ajax.php',
			type: 'post',
			success: function(response){
				$('#notaNuevaProyectos').html(response);
			}
		});
	}

</script>

	<div id="cargaResumenProyecto">

	</div>
	<div id="notasProyecto"
		
	</div>

	<button id="agregarNota" onclick="mostrarAgregarNota();">Agregar Nota</button>

	<div id="notaNuevaProyectos">
		Nota:<br/>
		<textarea nombre="nuevaNoteProyecto" id="nuevaNotaProyecto"></textarea>
	</div>

	<div class="controls">
		<button id="editarResumenProyecto">Editar</button>
		<div id="edicionResumenProyecto">
			<button id="cancelarEditarResumenProyecto">Cancelar</button>
			<button id="enviarResumenProyecto">Enviar</button>
		</div>
		<div id="edicionNotaProyecto">
			<button id="cancelarEditarNotaProyecto" onclick="mostrarAgregarNota();">Cancelar</button>
			<button id="enviarNuevaNotaProyecto">Agregar Nota</button>
		</div>
	</div>

</div><!-- end resumen -->



<?php

	
?>