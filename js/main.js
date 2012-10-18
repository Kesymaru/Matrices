
$(document).ready(function(){

	$( "#accordion" ).accordion();

	$( "button" ).button();

	$( "#datepicker" ).datepicker();

	$('#tags').tagsInput({
	   'height':'100px',
	   'width':'300px',
	   'interactive':false,
	   'defaultText':'Agregar',
	   'removeWithBackspace' : true,
	   'placeholderColor' : '#666666'
	});

	$('#cats').tagsInput({
	   'height':'100px',
	   'width':'300px',
	   'interactive':false,
	   'defaultText':'Agregar',
	   'removeWithBackspace' : true,
	   'placeholderColor' : '#666666'
	});
});

//carga el contenido
function contenido(func){
	var queryParams = { "func" : func};
	var cont = $("#contenido");
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },
	        success:  function (response) { 
	        		cont.load(response);
	        }
		});
}

//carga el formulario
function formulario(func){
	var queryParams = { "func" : func};
	var cont = $("#formulario");
	  	$.ajax({
	        data:  queryParams,
	        url:   'ajax.php',
	        type:  'post',
	        beforeSend: function () {
	                cont.html('<img class="loader" src="http://77digital.com/Desarrollo/dipo/images/loader.gif" alt="cargando" />');
	        },
	        success:  function (response) { 
	        		cont.load(response);
	        }
		});
}

//quita y pone categoria seleccionada
function categoria(etiqueta){
	if ($('#cats').tagExist(etiqueta)) { 

		$('#cats').removeCat(etiqueta);

	}else{

		$('#cats').addCat(etiqueta);
	}
}

//quita y pone las etiquetas seleccionadas
function etiqueta(etiqueta){
	if ($('#tags').tagExist(etiqueta)) { 

		$('#tags').removeTag(etiqueta);

	}else{

		$('#tags').addTag(etiqueta);

	}
}