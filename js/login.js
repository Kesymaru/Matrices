$(document).ready(function(){
    	
    $( "input[type=submit], button, span" ).button();

    $('#registroUsuarios').hide();
    $('#formRecuperacion').hide();
    $('#resetear').hide();
    $('.etiquetas').hide();

    $("#formID").validationEngine();
    $('input[placeholder]').placeholder();

    //compatibilidad opera -> es el unico browser que no permite color en placeholder
    if($.browser.opera){
    	$('.etiquetas').show();
    }

});

function loginbox(cambio){

	if(cambio == 2){
		$('#registroUsuarios').fadeOut(1000,function(){$('#usuarios').fadeIn();});
	}else{
		$('#usuarios').fadeOut(1000,function(){$('#registroUsuarios').fadeIn();});
	}

}

function formRecuperacion(){

	if( $('#formRecuperacion').is(':visible')){
			$('#formRecuperacion').slideUp(500);
			$('#login').slideDown(500);

			$('#resetear').fadeOut(500, function(){ $('#entrar').fadeIn(500); });
	}else{
			$('#formRecuperacion').slideDown(500);
			$('#login').slideUp(500,function(){ $('#login').hide();});

			$('#entrar').fadeOut(500, function(){ $('#resetear').fadeIn(500); });
	}

}

//loguear
function logIn(){
	//si son validos los datos
	if ( $('#formID').validationEngine('validate') ){

		var usuario = $('#usuario').val();
		var password = $('#password').val();

		var queryParams = { "func" : 'logIn', "usuario" : usuario, "password" : password};
			$.ajax({
			data:  queryParams,
			url:   'ajax.php',
			type:  'post',
			success:  function (response) { 

				if(response.length > 0){
					notificaError(response);
				}else{
				    top.location.href = 'index.php';
				}
			}
		});
	}

}

//resetea password
function resetar(){

	var usuario = $('#usuarioRecuperacion').val();
	var email = $('#emailRecuperacion').val();

	if(usuario != ''){

			var queryParams = { "func" : 'resetPasswordUsuario', "usuario" : usuario};
			$.ajax({
				data:  queryParams,
				url:   'ajax.php',
				type:  'post',
				success:  function (response) { 
					if(response.length > 0){
						notifica(response);
						return;
					}
				}
			});
	}

	if(email != ''){
			
		var queryParams = { "func" : 'resetPasswordEmail', "email" : email};
		$.ajax({
			data:  queryParams,
			url:   'ajax.php',
			type:  'post',
			success:  function (response) { 
				if(response.length > 0){
					notifica(response);
					return;  
				}
			}
		});
	}

	if(usuario != '' && email != ''){
		notificaError('Error usuario y email no registrados.');
	}else if(usuario != ''){
		notificaError('Error usuario no registrado.');
	}else if(email != ''){
		notificaError('Error email no registrado.');
	}
}

/*
	REGISTRO
*/
function registro(){
	//si los datos son validos
	if( $('#formID').validationEngine('validate') ){

		//ya estan validadas
		var usuario = $('#registroUsuario').val();
		var email = $('#registroEmail').val();
		var password = $('#registroPassword1').val();
		
		//AJAX
		var queryParams = { "func" : 'registro', "usuario" : usuario, "email" : email, "password" : password};
		$.ajax({
			data:  queryParams,
			url:   'ajax.php',
			type:  'post',
			success:  function (response) { 

				if(response.length == 0){

				    
				    setTimeout(function() {
  						window.location.href = "login.php?usuario="+usuario;
					}, 4000);

					notifica('Se ha registrado exitosamente.');
				}else{
				    notificaError(response);
				}
				        
			}
		});
	}else{
		notificaError('Error datos invalidos.')
	}
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
		},3000);
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
		},3000);
}

