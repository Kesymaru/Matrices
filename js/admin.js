/*
	JQUERY PARA ADMIN
*/

var opcionOld = 'dashboard';
var eCliente = 0;

$(document).ready(function(){

	$('#dashboard').addClass('seleccionada');
	$('#dashboard ul').slideDown();

});

//Ajax para admin
function accion(func){
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
	        	//cont.html(response);
	        	cont.hide().html(response).fadeIn(1000);
	        	//cont.hide().html(response).slideDown(1500);

	        	if(func == 'verClientes'){
	        		$( "#muestraClientes" ).accordion();
	        	}	 
	        	if(func == 'verProyectos' || func == 'verProyectosActivos' || func == 'verProyectosFinalizados'){
	        		$( "#muestraProyectos" ).accordion();
	        	}   
	        	if(func == 'muestraCategorias'){
	        		$( "#muestraCategorias" ).accordion();
	        	}
	        }
		});
}

//ajax para actualizar datos
function actualizar(func, id, param){
	var queryParams = { "func" : func, 'id' : id, 'param' : param};
	var cont = $("#contenido");
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajaxAdmin.php',
	        type:  'post',
	        /*beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },*/
	        success:  function (response) {
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

function editarCliente(id){

	$('#muestraClientes #'+id+' .datos :input').removeAttr('disabled');
	if(id !== eCliente){
		$('#muestraClientes #'+id+' .edicion').append('<input type="submit" id="enviarCliente'+id+'" onClick="enviarCliente('+id+')" value="Enviar">');
	}

	//anterior
	$('#muestraClientes #'+eCliente+' .datos :input').attr('disabled', 'disabled');

	$('#muestraClientes #'+eCliente+' .edicion #enviarCliente'+eCliente).remove();

	if(eCliente == id){
		eCliente = 0;
	}else{
		eCliente = id;
	}
}

function enviarCliente(id){

	var nombre = $('#muestraClientes #'+id+' .datos input[name=\'nombre\']').val();
	var email = $('#muestraClientes #'+id+' .datos input[name=\'email\']').val();
	var telefono = $('#muestraClientes #'+id+' .datos input[name=\'telefono\']').val();
	var skype = $('#muestraClientes #'+id+' .datos input[name=\'skype\']').val();
	
	if(nombre !== '' && nombre !== null){
		actualizar('clienteNombre', id, nombre);
	}
	if(email !== '' && email !== null){
		actualizar('clienteEmail', id, email);
	}
	if(telefono !== '' && telefono !== null){
		actualizar('clienteTelefono', id, telefono);
	}
	if(skype !== '' && skype !== null){
		actualizar('clienteSkype', id, skype);
	}
}


//funcion para seleccionar un padre y mostrar los hijos
function selecionaPadre(parentId, id){
	//alert('Usted selecciono: Padre: '+parentId+' Hijo:'+id);
	if( $('.nivel2').exists() ){
		$('.nivel2').remove();
	}
	$('#'+parentId).append('<td class="nivel2" id="'+id+'">Agregar '+id+'</td>');
}

//funcion que determina si existe
jQuery.fn.exists = function(){return this.length>0;}