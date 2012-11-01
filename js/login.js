$(document).ready(function(){
    	
    $( "input[type=submit], button, span" ).button();

    $('#nuevoUsuario').hide();
    $('#formRecuperacion').hide();
    $('#resetear').hide();

    $("#formID").validationEngine();
    $('input[placeholder]').placeholder();

});

function loginbox(cambio){

	if(cambio == 2){
		$('#nuevoUsuario').fadeOut(1000,function(){$('#usuarios').fadeIn();});
	}else{
		$('#usuarios').fadeOut(1000,function(){$('#nuevoUsuario').fadeIn();});
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

					if(response.length == 0){

						notifica('Se ha enviado un email con el password temporal.');
						return;

					}else{
					    notificaError(response);
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

				    if(response.length == 0){

				        notifica('Se ha enviado un email con el password temporal.');
				        return;
				    }else{
				        notificaError(response);
				    }
				        
				}
			});
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