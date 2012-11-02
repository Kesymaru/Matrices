var Categoria;
var Norma;
var Proyecto = 1;
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

});

//menu
function menu(id){
	$('#mensajeInicial').hide();
	$('#resultadoBusqueda').hide();

	var menu = $('#menu'+id);
	
	$('#menu ul').children('li').removeClass('seleccionada');
	menu.css({
		'opacity':'0',
	});
	menu.addClass('seleccionada').animate({
		'opacity':1,
	},1000);

	Categoria = id;
	listaNormas(id);
	reset();
}

/*
	carga de datos
*/

//normas de la categoria
function listaNormas(parentId){
	accion1('listaNormas','listaNormas',parentId);
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

function seleccionaGeneralidad(id){
	if( $('#box'+id).length > 0){
		$('#box'+id).remove();
	}else{
		accion2('columna2','seleccionaGeneralidad',Norma,id);
	}

	//registra accion en registros del proyecto
	var queryParams = { "func" : 'actividad', "proyecto" : Proyecto, "norma" : Norma, "id" : id };
	$.ajax({
		data:  queryParams,
		url:   'ajax.php',
		type:  'post',
		success:  function (response) { 
			notifica(response);
		}
	});
	notifica('Registrando actividad.<br/> Proyecto'+Proyecto+'<br/>Norma '+Norma+'<br/>Generalidad '+id);

}

//limpia y resetea muestras de ajax
function reset(){
	generalidades();
	$('.box').remove();
}

/*
	BUQUEDA 
*/

function buscar(busqueda){
	accion1('resultadoBusqueda', 'buscar',busqueda);
}

/*
	EDITAR DATOS usuarios
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
	EDITAR proyectos
*/
function proyecto(){
	$( "#dialogoContenido" ).load('ajax/nuevoProyecto.php');
	$('#dialogo').hide();
	$('#dialogo').slideDown();
}

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
	VISTA PROYECTO
*/

//carga la vista de proyectos
function vistaProyecto(id){
	notifica('Vista de proyectos.');

	var queryParams = { "func" : 'vistaProyecto', "id": id};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        success:  function (response) { 
	        	$('#main').load(response);
	        }
		});
}

function muestraProyecto(id){

	$('#mensajeInicial').hide();
	$('#resultadoBusqueda').hide();

	var menu = $('#menu'+id);
	
	$('#menu ul').children('li').removeClass('seleccionada');
	menu.css({
		'opacity':'0',
	});
	menu.addClass('seleccionada').animate({
		'opacity':1,
	},1000);
	
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
	top.location.href = 'index.php?id='+id;
}

//exportar proyecto seleccionado
function exportarProyecto(id){
	
	notificaAtencion('Exportando Proyecto.<br/>Asegurese de guardar el archivo en su disco duro.');
	top.location.href = 'exportar.php?id='+id;
}

function closeDialogo(){
	$('#dialogo').slideUp();
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
  		closeWith: ['click'], // ['click', 'button', 'hover']
  	});
  	console.log('html: '+n.options.id);
  	
  	//tiempo para desaparecerlo solo 
  	setTimeout(function (){
		n.close();
	},7000);
}

//notificaciones de maxima priridad
function notificaAtencion(text) {
  	var n = noty({
  		text: text,
  		type: 'information',
    	dismissQueue: true,
  		layout: 'topCenter',
  		closeWith: ['click'], // ['click', 'button', 'hover']
  	});
  	console.log('html: '+n.options.id);
  	
  	//tiempo para desaparecerlo solo 
  	setTimeout(function (){
		n.close();
	},7000);
}


//notifica errores
function notificaError(text) {
  	var n = noty({
  		text: text,
  		type: 'error',
    	dismissQueue: true,
  		layout: 'topCenter',
  		closeWith: ['click'], // ['click', 'button', 'hover']
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

