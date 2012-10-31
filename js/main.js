var Categoria;
var Norma;
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
		
		alert(nombre+' '+email+' '+telefono);
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
			//TODO notifcacion del password
		}else{
			//TODO notificacion normal
		}
    }else{
    	//TODO notificacion de error, algun dato es invalido
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
				        url:   'ajax.php',
				        type:  'post',
				        success:  function (response) { 
				        	alert('Se ha creado tu proyecto.')
				        	//TODO notificacion
				        }
					});
				}else{
					alert('Este proyecto ya existe.');
					//TODO nice notification
				}
	        } 
		});

	}else{
		//TODO notificacion
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

function closeDialogo(){
	$('#dialogo').slideUp();
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
	        	//TODO notificacion
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

