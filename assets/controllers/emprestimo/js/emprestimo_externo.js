// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 27/09/2015
*/
var paramCedentes;

$(document).ready(function(e) {
	
	$('#idFuncionario').focus().focusout(function() {
		buscarFuncionarioServidor();
	}).keyup(function(){
		if ($(this).val().length >= 4) buscarFuncionarioServidor();
	});
	
	$('#idCedente').chosen({
    	placeholder_text_single : 'Selecione o local de trabalho'
	});

	$('#idCedente').change(function(e) {
		copiaParamCedente();
	});
	
	$('.btn-simular').click(function(e) {
		if ($("#form_param").valid()) 
			verificaDisponibilidadeServidor();
	});
	
	$('.btn-gravar').click(function(e) {
		event.preventDefault();
		
		if ($("#form_param").valid()) {
			$( "#dialog-solicita-senha-funcionario" ).dialog( "open" );
		}
	});
	
	function verificaDisponibilidadeServidor() {		    	var url = window.location.href; url = url.substring(0, url.indexOf("/financiamento/"));
		$.ajax({
	        url: url + "/financiamento/verificarEmprestimoExterno",
	        type: "POST",
	        data: $('#form_param').serialize(),
	        //dataType: "json",
	        beforeSend: function( xhr ) {
	        	$('#exibir-simulacao').html(htmlGifCarregando());
	        },
	        success: function(data) {
	        	$('#exibir-simulacao').html(data);
	        },
	         error: function (request, error) {
	        	$('#exibir-simulacao').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!');
	        }
	    });
	}
	
	function buscarFuncionarioServidor() {
    	var url = window.location.href; url = url.substring(0, url.indexOf("/financiamento/"));
		$.ajax({
	        url: url + "/financiamento/buscaParamFuncEmpExternoAjax",
	        type: "POST",
	        data: $('#form_param').serialize(),
	        dataType: "json",
	        beforeSend: function( xhr ) {
	        	$('#idCedente').html('<option>Carregando...</option>').trigger("chosen:updated");
	        },
	        success: function(data) {
	        	paramCedentes = data;
	        	
	        	if (0 == data.cedentes.length) {
	        		$('#idCedente').html('<option></option>').trigger("chosen:updated");
	        		$('#nomeFuncionario').val('')
	        		$('#idParametro').val('');
	        		$('#valor').attr			( 'placeholder', '0,00');
					$('#parcelas').attr			( 'placeholder', '');
	        		$('#exibir-simulacao').html(data.error);
	        	}
	        	else {
	        		$('#idCedente').html('');
	        		$('#exibir-simulacao').html('');
	        		$('#nomeFuncionario').val(data.funcionario[0].nome);
	        	
		        	$.each(data.cedentes, function(key, val){
		        		$('#idCedente').append($('<option>', { value : val['idCedente'] }).text(val['nomefantasia']));
		    		});
	        		$('#idCedente').chosen().trigger("chosen:updated");
	        		copiaParamCedente();
	        		
	        		if (1 < data.cedentes.length) $('#idCedente').trigger("chosen:open");
	        		else $('#valor').focus();
	        	}
	        },
	         error: function (request, error) {
	        	$('#exibir-simulacao').html('Não foi possível conectar ao servidor [cód: (ajaxGetDataEmployee)]!');
	        }
	    });
	}
	//copia parametros vindos do servidor para os campos de edição
	function copiaParamCedente() {
		var empFin = 'emp';
		
		$('#idParametro').val('');
		
		var idCedente = $('#idCedente').val();
		
		$.each(paramCedentes.cedentes, function(key, val){
			if (idCedente == val['idCedente']) {
				$('#idParametro').val(val['idParametro']);
				
				//seta placeholder para mostrar valores padrão para funcionário
				$('#valor').attr			( 'placeholder', 'R$ ' + converteMonetarioReais(val[empFin+'_max_valor']));
				$('#parcelas').attr			( 'placeholder', 'máx. ' + val[empFin+'_max_parcelas'] );

				$('#valor').attr			( 'max', val[empFin+'_max_valor'] );
				$('#parcelas').attr			( 'max', val[empFin+'_max_parcelas'] );
			}
		});
	}
});
$(function() {
	$( "#dialog-solicita-senha-funcionario" ).dialog({
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
		"Registrar": {
			className: 'btn-registrar',
			text: 'Registrar',
			click: function() {								if ($('#senha').val() != '') {
					var url = window.location.href; url = url.substring(0, url.indexOf("/financiamento/"));	
					$.ajax({	
				        url: url + "/financiamento/gravarEmprestimoExterno",	
				        type: "POST",	
				        data: $('#form_param').serialize() +"&senha=" + $('#senha').val(),	
				        dataType: "json",	
				        beforeSend: function( xhr ) {	
				        	$('#senha').val('');	
				        	$(".ui-dialog-buttonpane button:contains('Registrar')").attr("disabled", true);	
				        	$('#div-senha').hide();	
				        	$('#div-senha-result').html(htmlGifCarregando() + ' Verificando...').show();	
				        },	
				        success: function(data) {	
				        	if (data.sucesso) {	
					        	$('#exibir-simulacao, #div-senha-result').html(data.mensagem);	
					        	$(".ui-dialog-buttonpane button:contains('Registrar')").remove();	
					        	$( ".btn-simular, .btn-gravar" ).remove();	
				        	}	
				        	else {	
				        		$('#exibir-simulacao, #div-senha-result').html(data.mensagem);	
				        		$('#div-senha').show();	
				        		$(".ui-dialog-buttonpane button:contains('Registrar')").attr("disabled", false);	
				        	}	
				        },	
				         error: function (request, error) {	
				        	 $('#div-senha-result').html('Não foi possível conectar ao servidor [cód: (ajaxRecord)]!');	
				         	 $(".ui-dialog-buttonpane button:contains('Registrar')").attr("disabled", false);	
				        }
					});				}
			}
		},
		"Retornar": function() {
			$('#senha').val('');
			$('#div-senha').show();
			$('#div-senha-result').html('').hide();
			$( this ).dialog( "close" );
		}
	  }
	});
  });
