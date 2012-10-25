var Categoria;
var Norma;

$(document).ready(function(){


});

//menu
function menu(id){
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
	accion1('descripcionNorma','descripcionNorma', normaId);
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