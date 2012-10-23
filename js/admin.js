/*
	JQUERY PARA ADMIN
*/

var opcionOld = 'dashboard';
var eCliente = 0;
var superParent = 0;
var pasos = [];
var paso = 0;
var editando;

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
	        		$( "#muestraCategorias" ).accordion({
	        			 heightStyle: "content"
	        		});
	        	}
	        }
		});
}

//ajax para actualizar datos
function actualizar(func, id, param){
	var queryParams = { "func" : func, 'id' : id, 'param' : param};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajaxAdmin.php',
	        type:  'post',
	        /*beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },*/
	        success:  function (response) {
	        	//TODO: notificasion
	        }
		});
}

//ajax para mostrar una categoria datos
function categoria(func, superParent, id){
	var queryParams = { "func" : func, 'superParent' : superParent, 'id' : id};
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajaxAdmin.php',
	        type:  'post',
	        /*beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },*/
	        success:  function (response) {
	        	//animacion al mostrar
	        	$('#categoria'+id).hide().html(response).fadeToggle(1000);
	        }
		});
}

//menu principal
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

//selecciona una categoria padre y muestra sus hijos al lado derecho
function seleccionaCategoria(parentId) {

  	//limpia anidaciones anteriores
  	$('.subnivel').remove();

  	var hijo = $('#'+parentId+' option:selected').attr('id');

	superParent = parentId;

	$('#tabla'+parentId).append('<td class="noEditar subnivel nivel'+hijo+'" id="categoria'+hijo+'"></td>');

	categoria('muestraHijos',superParent, hijo);
	
	//resetea pasos
	pasos = [];
	paso = 0;

	pasos[paso] = hijo;
	paso++;
}

//selecciona una categoria padre y muestra sus hijos al lado derecho
function subCategoria(superId,parentId) {

  	var hijo = $('#categoria'+parentId+' option:selected').attr('id');

  	//determina si el camino se modifica y borra el camino restante
	for(var i = 0; i <= pasos.length-1; i++){
			
		if(parentId == pasos[i]){

			if(pasos[i+1] > 0){

				$('.nivel'+pasos[i+1]).remove();

			}else if( pasos[pasos.length-1] != parentId ){

				$('#categoria'+parentId).removeClass('nivel'+parentId);

				$('.nivel'+parentId).remove();
				
				$('#categoria'+parentId).addClass('nivel'+parentId);
				
			}

			limpiaCamino(i+1);
		}

	}

	//si es valida la seleccion
	if( !(hijo == "null") ){

		var nuevo = '<td id="categoria'+hijo+'" class="noEditar subnivel nivel'+hijo;

		//pone el camino en el columna de la tabla
		for(var i = 0; i <= pasos.length-1; i++){

			if(pasos[i] > 0 && pasos[i] != null){
				nuevo += ' nivel'+pasos[i];
			}
			
		}

		nuevo += '"></td>';

		$('#tabla'+superId).append(nuevo);

		categoria('muestraHijos',superId, hijo);

		//registra camino nuevo
		pasos[paso] = hijo;
		paso++;
	}

}

//limpia del array el camino modificado
function limpiaCamino(hasta){

	for(var i = pasos.length-1; hasta <= i; i-- ){
		//elimina del array el camnino modificado
		pasos.splice(i); 
	}

}

/*
	edicion de categorias
*/

function actualizarCategoria(parentId){

	var nuevo = $('#nuevo'+parentId).val();
	var nombre = $('#nombre'+parentId).val();

	if( validarTxt(nuevo) ){
		actualizar('nuevoHijo', parentId, nuevo);
		//TODO: notificacion

	}else{
		//TODO notficacion de invalidez
	}

	if( validarTxt(nombre)){
		actualizar('categoriaNombre', parentId, nombre);
		//TODO notificacion
	}else{
		//TODO notificacion
	}

	editarCategoria(parentId);

}

function nuevaCategoria(parentId){

	var nueva = $('#nueva'+parentId).val();

	if( validarTxt(nueva) ){
		actualizar('nuevoHijo', parentId, nueva);
		//TODO: notificacion
		alert('Ingresada la nueva categoria '+nueva);
	}else{
		//TODO notficacion de invalidez
	}
}


//toggle para editar un categoria
function editarCategoria(parentId){

	if( $('#categoria'+parentId).hasClass('editar') ){

		$('#categoria'+parentId).removeClass('editar');
		$('#categoria'+parentId).addClass('noEditar');

	}else{

		$('#categoria'+parentId).removeClass('noEditar');
		$('#categoria'+parentId).addClass('editar');

	}

}

/*funciones de validacion */
function validarTxt(txt){
	if( txt != null && txt != ''){
		return true;
	}else{
		return false;
	}
}


//funcion que determina si existe
jQuery.fn.exists = function(){return this.length>0;}

/*
	NOTIFICACIONES
*/

