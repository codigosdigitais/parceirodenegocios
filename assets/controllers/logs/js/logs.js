/**
 * 
 */

$(document).ready(function(){
	
	$('#tabela').chosen({
    	placeholder_text_single : 'Selecione uma função'
	});
	$('#operacao').chosen({
    	placeholder_text_single : 'Operação'
	});
	$('#usuario').chosen({
    	placeholder_text_single : 'Usuário'
	});
	
	$('#btn-aplicar-filtro').click(function() {
		$('#pagina').val(0);
		atualizaRegistroPeloFiltro();
	});

	$( "#dialog-show-details" ).dialog({
	  autoOpen: false,
	  modal: true,
	  show: {
		effect: "blind",
		duration: 100
	  },
	  hide: {
		effect: "blind",
		duration: 10
	  },
	  buttons: {
		"Retornar": function() {
		  $( this ).dialog( "close" );
		}
	  }
	});

});

function setDivPagesOnClick() {
	$('.div-pages-registros').click(function() {
		var index = Number($(this).html()) -1;
		$('#pagina').val( index );
		atualizaRegistroPeloFiltro();
	});
}

function atualizaRegistroPeloFiltro() {
	
	//if ( $('#tabela').val() || $('#usuario').val() ) {
			
		var url 	  = $('#url-address-default').val();
		
		$.ajax({
	        url: url + 'logs_acesso/getLogsPeloFiltro',
	        type: "POST",
	        data: $('#form-filtros').serialize(),
	        //dataType: "json",
	        beforeSend: function( xhr ) {
	        	$('#div-result-ajax').html(htmlGifCarregando() + ' Aguarde...');
	        },
	        success: function(data) {
	        	$('#div-result-ajax').html(data);

	        	$('.btn-log-data-show').click(function() {
	        		$('#div-show-detail-record').html( $(this).find(".log-data-show").html() );
	        		$('#dialog-show-details').dialog( "open" );
	        	});
	        	
	        	setDivPagesOnClick();
	        },
	        error: function (request, error) {
	        	$('#div-result-ajax').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
	        }
	    });
	/*}
	else {
		$('#div-result-ajax').html('Selecione um módulo /função ou um usuário');
	}*/
}
