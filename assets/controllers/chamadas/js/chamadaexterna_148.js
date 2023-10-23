// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 27/09/2015
*/
$(document).ready(function(e) {
	
	$('#div-chamada-minimize').html('<div class="btn-minimize"></div>');
	
	//teste de layout --removido
	//var hash = $(location).attr('hash');
	//if (hash == '#codigo3') { 
		$('.div-chamada-box').css('display', 'block');
		$('#div-carregando-inicial').css('display', 'none');
		
	//}
	
	$('#div-chamada-minimize').click(function(e) {
		minMaxChamadoBox();
    });
	
	if ( $('#boxChamadoMinimizado').val() == 'true' ) {
		minMaxChamadoBox();
	}
	//boxInitialWidth = $('.div-chamada-box').css('width');
	//boxInitialHeight= $('.div-chamada-box').css('height');
});

var boxInitialWidth = "616px";
var boxInitialHeight = "340px";

function minMaxChamadoBox() {
	if ( $('#div-chamada-minimize').hasClass('minimized') ) {
		
		$('#div-chamada-minimize')
			.removeClass('minimized')
			.html('<div class="btn-minimize"></div>')
			.attr("title","Minimizar")
			.animate({paddingLeft: '100px'});
		
		$('.div-chamada-box').animate({
			width: boxInitialWidth,
			height: boxInitialHeight
		});
		atualizaStatusMinimizadoMaximizado('false');
	}
	else {
		
		$('#div-chamada-minimize')
			.addClass('minimized')
			.html('<div class="btn-maximize"></div>')
			.animate({paddingLeft: '10px'})
			.attr("title","Maximizar");
		
		$('.div-chamada-box').animate({
			width: "370px",
			height: '20px'
		});
		atualizaStatusMinimizadoMaximizado('true');
		
	}
}

//salva status maximizado /minimizado da box chamado na sessão
function atualizaStatusMinimizadoMaximizado(status) {
	$('#boxChamadoMinimizado').val(status);
	
	var url 	  = $('#url-address-default').val() + 'chamadaexterna/atualizaBoxMinimizadoMaximizado';
	var clientKey = $('#clientKey').val();
	var data	  = 'boxChamadoMinimizado=' + status + '&clientKey=' + clientKey;
	
	$.ajax({
		url: url,
		xhrFields: {
			withCredentials: true
		},
		type: "POST",
		data: data,
		crossDomain: true,
		async: true,
		beforeSend: function( xhr ) {
			xhr.withCredentials = true;
		},
		success: function(data) {
			
		},
		error: function (request, error) {
			
		}
	});
}


