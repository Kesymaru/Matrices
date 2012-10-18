/*
	JQUERY PARA ADMIN
*/

var opcionOld = 'dashboard';

$(document).ready(function(){

	$('#dashboard').addClass('seleccionada');
	$('#dashboard ul').slideDown();

});

//Ajax para admin
function contenido(func){
	var queryParams = { "func" : func};
	var cont = $("#contenido");
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajaxAdmin.php',
	        type:  'post',
	        beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },
	        success:  function (response) { 
	        		cont.load(response);
	        }
		});
}

function menu(opcion){

	if( $('#'+opcion).hasClass('seleccionada') ){
		$('#'+opcion).removeClass('seleccionada');
	}else{
		$('#'+opcionOld).removeClass('seleccionada');
		$('#'+opcionOld+' ul').slideUp();
		opcionOld = opcion;
	}

	$('#'+opcion).addClass('seleccionada');
	$('#'+opcion+' ul').slideDown();

}