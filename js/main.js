var Categoria;
var Norma;
var box = 0;

$(document).ready(function(){
	$('.dropMenu').hide();

	$('#proyectos').click(function(){
		if($('#menuProyectos').is(':visible')){
			$('#menuProyectos').slideUp();
		}else{
			$('#menuProyectos').slideDown();
		}
	});

	$('#usuario').click(function(){
		if($('#menuUsuario').is(':visible')){
			$('#menuUsuario').slideUp();
		}else{
			$('#menuUsuario').slideDown();
		}
	});

	$("#searchForm").validationEngine();
    $('input[placeholder]').placeholder();

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