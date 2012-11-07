var Categoria;
var Norma;
var Proyecto;
var box = 0;

$(document).ready(function(){
	$('.dropMenu button').button();
	$('.dropMenu').hide();

	$('#proyectos').click(function(){
		if($('#menuProyectos').is(':visible')){
			$('#menuProyectos').slideUp();
			$('#proyectos').css({
				'background-color' : '#fff',
				'color' : '#000'
			});
		}else{
			$('#proyectos').css({
				'background-color' : '#a1ca4a',
				'color' : '#fff'
			});
			$('#menuProyectos').slideDown();
		}
	});

	$('#usuario').click(function(){
		if($('#menuUsuario').is(':visible')){
			$('#menuUsuario').slideUp();
			$('#usuario').css({
				'background-color' : '#fff',
				'color' : '#000'
			});
		}else{
			$('#usuario').css({
				'background-color' : '#a1ca4a',
				'color' : '#fff'
			});
			$('#menuUsuario').slideDown();
		}
	});

	$("#searchForm").validationEngine();
    $('input[placeholder]').placeholder();

    //oculta dialogo
    $('#dialogo').hide();

    //categorias
    $('#nuevaCategoria').click(function (){
    	nuevaCategoria();
    });

    $('#borrarCategoria').click(function (){
    	borrarCategoria();
    });

    $('#mensajeInicial button').button();
});

//menu
function menu(id){
	$('#mensajeInicial').hide();
	$('#resultadoBusqueda').hide();

	var menu = $('#'+id);
	//notifica(menu);

	$('#menu ul').children('li').removeClass('seleccionada');
	menu.css({
		'opacity':'0',
	});
	menu.addClass('seleccionada').animate({
		'opacity':1,
	},1000);

	Categoria = id;
	listaNormas(id);
	//reset();
}

/*
	carga de datos
*/

//normas de la categoria
function listaNormas(parentId){
	//accion1('listaNormas','listaNormas',parentId);
}

//carga la descripcion de la norma seleccionada
function descripcionNorma(normaId){
	accion1('columna1','descripcionNorma', normaId);
}

//carga generalidades
function generalidades(){
	accion1('generalidades','generalidades');
}

//para seleccionar una norma
function seleccionaNorma(){
	var normaId = $('#seleccionaNorma option:selected').attr('id');
	
	Norma = normaId;

	descripcionNorma(normaId);

	reset();
}

//registra la seleccion o deseleccion, autoguardado en la base de datos
function seleccionaGeneralidad(id){
	if( $('#box'+id).length > 0){
		$('#box'+id).remove();
	}else{
		accion2('columna2','seleccionaGeneralidad',Norma,id);
	}

	//registra accion en registros del proyecto
	var queryParams = { "func" : 'actividadRegistrar', "proyecto" : Proyecto, "categoria" : Categoria, "norma" : Norma, "id" : id };
	$.ajax({
		data:  queryParams,
		url:   'ajax.php',
		type:  'post',
		success:  function (response) { 
			notifica(response);
		}
	});
	notifica('Registrando actividad.<br/> Proyecto'+Proyecto+'<br/>Categoria: '+Categoria+'<br/>Norma '+Norma+'<br/>Generalidad '+id);

}

//limpia y resetea muestras de ajax
function reset(){

	$('#content #nivel1, #content #nivel2, #resumen').remove();
	//remueve consultas de generalidades
	$('.box').remove();
}

/*
	DATOS proyecto creado
*/

//se encarga de cargar los datos almacenados del proyecto seleccionado
function resumenProyecto(){
	//limpia
	reset();

	$('#content').append($('<div id="resumen">').load('ajax/resumen.php?proyecto='+Proyecto));
	
	notifica('Resumen del proyecto.');
}

//dialogo de nota
function nota(id){
	$( "#dialogoContenido" ).load('ajax/nuevaNota.php');
	$('#dialogo').hide();
	$('#dialogo').slideDown();
}

function nuevaNota(id){
	var nota = $('#nota').val();

	if($("#formularioNuevaNota").validationEngine('validate')){
		
		queryParams = {'func' : 'nuevaNota', 'proyecto' : Proyecto, 'nota' : nota};

		$.ajax({
			data: queryParams,
			url: 'ajax.php',
			type: 'post',
			success: function(response){
				notifica('Nota agregada exitosamente.');
				//resumenProyecto();
				closeDialogo();
			}
		});

	}else{
		notificaError('Por faveor escriba una nota.');
	}
}

function removeNota(nota){

	var queryParams = {'func' : 'removeNota', 'nota' : nota};
	$.ajax({
		data: queryParams,
		url: 'ajax.php',
		type: 'post',
		success: function(response){
			$('#nota'+nota).css({
				'background-color' : '#6fa414',
			});

			$('#nota'+nota).animate({
				height: 0,
				width: 0,
				fontSize: 0,
			}, 700, function(){
				$('#nota'+nota).remove();
			});

			notifica('Nota eleminada exitosamente.');
		}
	});
}

function listaNormasDatos(id){
	var queryParams = {"func" : 'listaNormasDatos'};
	$.ajax({
		data: queryParams,
		type: 'post',
		url: 'index.php',
		success: function(response){
			var normaId = $('#seleccionaNorma :first').attr('id');
	        Norma = normaId;
	        //se carga la descripcion de la norma
			descripcionNorma(normaId);
		}
	});
}

/*
	BUQUEDA 
*/

function buscar(busqueda){
	accion1('resultadoBusqueda', 'buscar',busqueda);
}

/*
	EDITAR DATOS USUARIO
*/

function editar(){
	$( "#dialogoContenido" ).load('ajax/user.php');
	$('#dialogo').hide();
	$('#dialogo').slideDown();
}

//solo es para el formulario de cambio de datos del usuario
function editarUsuario(){

	if ($('#formularioUsuario').validationEngine('validate')){ 
		nombre   = $('#nombre').val();
		email    = $('#email').val();
		telefono = $('#telefono').val();
		skype    = $('#skype').val();
		
		cambiar = 0;
		if( $('#cambiarPassword').is(':visible')){
			cambiar = 1;
			password    = $('#nuevoPassword1').val();
			actualizar('password',password);
		}

		actualizar('nombre',nombre);
		actualizar('email',email);
		actualizar('telefono',telefono);
		actualizar('skype',skype);

		if(cambiar == 1){
			notifica('Se ha cambiado el password exitosamente.');
		}
		notifica('Datos actualizados exitosamente.');
    }else{
    	notificaError('Error datos invalidos.')
    }
}


/*
	EDITAR PROYECTOS
*/

//proyecto nuevo
function proyectoNuevo(){
	$( "#dialogoContenido" ).load('ajax/nuevoProyecto.php');
	$('#dialogo').hide();
	$('#dialogo').slideDown();
}

//formulario nuevo proyecto
function nuevoProyecto(){
	//validacion datos
	if ($('#formularioNuevoProyecto').validationEngine('validate')){
		nombre = $('#proyecto').val();
		descripcion = $('#descripcion').val();

		//consulta proyectos del usuario
		proyectos = [];
		valido = false;

		var queryParams = { "func" : 'getProyectos'};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        	proyectos = jQuery.parseJSON(response);
	        	valido = validaProyectos(proyectos);

	        	if(valido){
					var queryParams = { "func" : 'nuevoProyecto', "nombre" : nombre, "descripcion" : descripcion};
				  	$.ajax({
				        data:  queryParams,
				        async: false,
				        url:   'ajax.php',
				        type:  'post',
				        success:  function (response) { 
				        	resetMenuProyectos();
				        	notifica('Proyecto creado exitosamente.');
				        }
					});
				}else{
					notificaError('Error el proyecto ya existe.');
				}
	        } 
		});

	}else{
		notificaError('Error datos invalidos.');
	}
}

//si el proyecto no esta registrado ya
//@param return true si no existe
function validaProyectos(proyectos){
	for(c = 0; c <= proyectos.length; c++){
		if( proyectos[c] == nombre){
			return false;
		}
	}
	return true;
}

//refresca el menu de proyectos con la lista actualizada
function resetMenuProyectos(){
	//limpia menu
	$('#menuProyectos li').remove();

	var queryParams = { "func" : 'menuProyectos' };
	$.ajax({
		data:  queryParams,
		async: false,
		url:   'ajax.php',
		type:  'post',
		success:  function (response) { 
			$('.dropMenu button').button();
			$('#menuProyectos').append(response, function(){
			});
		}
	});
	$('#botonNuevoProyecto').button({'refresh': true});
}


/*
	PROYECTOS
*/
function setProyecto(proyecto){
	Proyecto = proyecto;
	console.log(Proyecto);
}

//carga el proyecto
function proyecto(id){
	notifica('Proyecto seleccionado.');

	top.location.href = 'index.php?proyecto='+id;
}

//carga los controles del proyecto
function proyectoControls(id){

	$('#mensajeInicial').hide();
	$('#resultadoBusqueda').hide();
	
	var queryParams = { "func" : 'proyectoControls', "id": id};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        	$('#proyectoControls').html(response);
	        	$( "#proyectoControls" ).buttonset();
	        }
		});

}

//editar proyecto
function editarProyecto(id){
	//limpia
	reset();

	notificaAtencion('Edicion de proyecto.<br/>Seleccione categorias para mostrar informacion.')
	//top.location.href = 'index.php?id='+id;
}

//exportar proyecto seleccionado
function exportarProyecto(id){
	notificaAtencion('Exportando Proyecto.<br/>Asegurese de guardar el archivo en su disco duro.');
	top.location.href = 'exportar.php?id='+id;
}

//muestra la lista de proyectos en un dialogo
function verProyectos(){
	$( "#dialogoContenido" ).load('ajax/listaProyectos.php');
	$('#dialogo').hide();
	$('#dialogo').slideDown();
}

//cierra el dialogo
function closeDialogo(){
	$('#dialogo').slideUp();
}


/*
	CATEGORIAS
*/

function nuevaCategoria(){
	if(Proyecto != 0 && Proyecto != null){
		$( "#dialogoContenido" ).load('ajax/nuevaCategoria.php');
		$('#dialogo').hide();
		$('#dialogo').slideDown();
	}else{
		notificaError('Error:<br/>Debe crear o seleccionar un proyecto.')
	}
}

function borrarCategoria(){
	//notifica('borrar categoria');
	var borra = $('#menu .menu .seleccionada :first').attr('id');
	console.log(borra);
}

//resive el array con todas las selecciones
function cargarCategorias(categorias){

	$('#menu .menu span').hide();

	for(var i = 0; i <= categorias.length; i++){
		if($('#'+categorias[i]).length > 0){
			$('#'+categorias[i]).remove();
		}
	}

	var queryParams = {"func" : 'cargarCategorias', 'categorias': categorias};
	$.ajax({
		data: queryParams,
		url: 'ajax.php',
		type: 'post',
		success: function(response){
			$('#menu .menu ul').append(response);
		}
	});

}

/*
	NOTIFICACIONES
*/

//usa noty (jquery plugin) para notificar 
function notifica(text) {
  	var n = noty({
  		text: text,
  		type: 'alert',
    	dismissQueue: true,
  		layout: 'topCenter',
  		closeWith: ['button'], // ['click', 'button', 'hover']
  	});
  	console.log('html: '+n.options.id);
  	
  	//tiempo para desaparecerlo solo 
  	/*setTimeout(function (){
		n.close();
	},7000);
*/
}

//notificaciones de maxima priridad
function notificaAtencion(text) {
  	var n = noty({
  		text: text,
  		type: 'information',
    	dismissQueue: true,
  		layout: 'topCenter',
  		closeWith: ['button'], // ['click', 'button', 'hover']
  	});
  	console.log('html: '+n.options.id);
  	
  	//tiempo para desaparecerlo solo 
  	setTimeout(function (){
		n.close();
	},10000);
}


//notifica errores
function notificaError(text) {
  	var n = noty({
  		text: text,
  		type: 'error',
    	dismissQueue: true,
  		layout: 'topCenter',
  		closeWith: ['button'], // ['click', 'button', 'hover']
  	});
  	console.log('html: '+n.options.id);
  	
  	//tiempo para desaparecerlo solo 
  	setTimeout(function (){
		n.close();
	},7000);
}

/*
	AJAX
*/

/* 
	@params: lugarCarga id donde cargar datos
		   func funcion requerida
		   id idintificador de categoria a cargar
*/
function accion1(lugarCarga, func, id){
	var queryParams = { "func" : func, "id" : id};
	var cont = $("#"+lugarCarga);
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },
	        success:  function (response) { 
	        	//cont.html(response);
	        	cont.hide().html(response).fadeIn(1000);
	        	
	        	if(func == 'listaNormas'){
	        		var normaId = $('#seleccionaNorma :first').attr('id');
	        		Norma = normaId;
					descripcionNorma(normaId);
	        	}
	        	if(func == 'generalidades'){
	        		 $( ".opciones" ).buttonset();
	        		 //$( "#opcion" ).click(seleccionaGeneralidad());
	        	}
	        }
		});
}

function accion2(lugarCarga, func, superId, id){
	var queryParams = { "func" : func, "superId" : superId, "id" : id};
	var cont = $("#"+lugarCarga);
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        	//cont.html(response);
	        	cont.append(response).fadeIn(1000);
	        }
		});
}

//para actualizar datos
function actualizar(func, nuevo){
	var queryParams = { "func" : func, "nuevo" : nuevo};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        }
		});
}

//logOut
function logOut(){
	var queryParams = { "func" : 'logOut'};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        	top.location.href = 'login.php';
	        }
		});
}

