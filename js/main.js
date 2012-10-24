
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
}