// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 27/09/2015
*/
var paramCedentes;

$(document).ready(function(e) {
		
	if ($('#idEmprestimo').val() != '') {
		buscaParamFuncionarioAjax(true);
	}
	
	$('#form_param').on('submit', function() {
	    $('select').each(function() {
	    	$(this).attr('disabled', false);
		});
	});
	
	//atualiza formulário para adequar a período de juros
	atualizaFormConformePeriodoJuros();
	$("#juros_periodo, #dataSolicitacao").on('change', function() {
		atualizaFormConformePeriodoJuros();
	});
	$("#dataSolicitacao, #parcelas").keyup(function() {
		atualizaFormConformePeriodoJuros();
	});
	function atualizaFormConformePeriodoJuros() {
		if ( $("#juros_periodo").val() == 'diario' ) {
			$("#lb_parcelas").html('Total dias');
			$("#lb_dataPrimParcela").html('Data Pagamento');
			
			var date1 = $('#dataSolicitacao').datepicker('getDate');
		    var date = new Date( Date.parse( date1 ) );
		    date.setDate( date.getDate() + Number($("#parcelas").val()) );
		    
		    var newDate = date.toDateString();
		    newDate = new Date( Date.parse( newDate ) );
		    
		    $('#dataPrimParcela').datepicker('setDate', newDate );
		    $('#dataPrimParcela').attr('readonly', true);
		}
		if ( $("#juros_periodo").val() == 'mensal' ) {
			$('#dataPrimParcela').attr('readonly', $('#dataSolicitacao').is('[readonly]'));
			$("#lb_parcelas").html('Parcelas');
			$("#lb_dataPrimParcela").html('1ª Parcela');
		}
	}

	//validar formulário
	$('.btn-simular').click(function(e) {
		if ($("#form_param").valid())
			realizaSimulacaoServidor();
	});
	$('.btn-gravar').click(function(e) {
		event.preventDefault();
		
		if ($("#form_param").valid()) {
			showConfirm = false;
			$("#form_param").submit();
		}
	});
	$('.btn-remover-form').click(function(e) {
		$( "#dialog-confirma-remover-registro" ).dialog( "open" );
	});
	
	$('#situacao').change(function(e) {
		alteraSituacaoLancamento();
	});
	$('#idCedente').change(function(e) {
		copiaParamCedente();
	});
	$('#idFuncionario').change(function(e) {
		buscaParamFuncionarioAjax(false);
	});
	
	//atribui validação no formulário para valores máximos e mínimos
	function alteraSituacaoLancamento() {
		//verifica quais parâmetros copiar
		var empFin = ( $('#tipoEmprestimo').val() == 'financiamento' ) ? 'financ' : 'emp';
		
		redefineFormMaxMin();
		
		var idCedente = $('#idCedente').val();

		//se situação = lançamento (força) inputs a receberem somente (máx /mín) do funcionário
		//será verificado no servidor também posteriormente
		if ($('#situacao').val() == 'aprovado' && idCedente) {
			
			$.each(paramCedentes.cedentes, function(key, val){
				
				if (idCedente == val['idCedente']) {
					$('#valor').attr			( 'max', val[empFin+'_max_valor'] );
					$('#parcelas').attr			( 'max', val[empFin+'_max_parcelas'] );
					//$('#comprometimento').attr	( 'max', val[empFin+'_max_comprometimento'] );
					$('#juros').attr			( 'min', val[empFin+'_tx_juros'] );
					
					//$('#juros_periodo option:not(:selected)').hide().trigger("chosen:updated");
					//$('#juros_tipo option:not(:selected)').hide().trigger("chosen:updated");
				}
			});
		}
	}
	
	//copia parametros vindos do servidor para os campos de edição
	function copiaParamCedente() {
		//verifica quais parâmetros copiar
		var empFin = ( $('#tipoEmprestimo').val() == 'financiamento' ) ? 'financ' : 'emp';
		
		alteraSituacaoLancamento();
		$('#idParametro').val('');
		
		var idCedente = $('#idCedente').val();
		
		$.each(paramCedentes.cedentes, function(key, val){
			if (idCedente == val['idCedente']) {
				$('#idParametro').val(val['idParametro']);
				
				//seta placeholder para mostrar valores padrão para funcionário
				$('#valor').attr			( 'placeholder', 'R$ ' + converteMonetarioReais(val[empFin+'_max_valor']));
				$('#salario').attr			( 'placeholder', 'R$ ' + converteMonetarioReais(val['salario']));
				$('#parcelas').attr			( 'placeholder', 'máx. ' + val[empFin+'_max_parcelas'] );
				$('#comprometimento').attr	( 'placeholder', 'máx. ' + convertePorcentSemDecimal(val[empFin+'_max_comprometimento']) +'%' );
				$('#juros').attr	 		( 'placeholder', convertePorcent3Decimais(val[empFin+'_tx_juros']) +'%' );
				
				if ($('#idEmprestimo').val() == '') {
					$('#salario').val			(converteMonetarioReais(val['salario']));
					//$('#comprometimento').val	(convertePorcentSemDecimal(val[empFin+'_max_comprometimento']));
					$('#juros').val	 			(convertePorcent3Decimais(val[empFin+'_tx_juros']));
					$("#juros_periodo").val		(val[empFin+'_periodo']).trigger("chosen:updated");
					$("#juros_tipo").val		(val[empFin+'_tipo']).trigger("chosen:updated");
				}

				//if ($('#idEmprestimo').val() == '') {
					//if ($('#valor').val() == '') 	$('#valor').val(converteMonetarioReais(val[empFin+'_max_valor']));
					//if ($('#parcelas').val() == '') $('#parcelas').val(val[empFin+'_max_parcelas']);
				//}
			}
		});
	}
	
	function redefineFormMaxMin() {
		$('#juros_periodo option, #juros_tipo option').show().trigger("chosen:updated");
		$('#valor, #parcelas, #comprometimento, #juros').removeAttr('max');
		$('#valor, #parcelas, #comprometimento, #juros').removeAttr('min');
	}
	
	$('#idFuncionario, #situacao, #juros_periodo, #juros_tipo, #idCedente, #idFornecedor').chosen({
    	placeholder_text_single : 'Selecione um registro'
	});
	
	function buscaParamFuncionarioAjax(realizaSimulacao) {
		var url = window.location.href; url = url.substring(0, url.indexOf("/financiamento/"));
		$.ajax({
	        url: url + "/financiamento/buscaParamFuncionarioAjax",
	        type: "POST",
	        data: {'idFuncionario': $('#idFuncionario').val(), 'tipoEmprestimo': $('#tipoEmprestimo').val()},
	        dataType: "json",
	        beforeSend: function( xhr ) {
	        	$('#idCedente').html('<option>Carregando...</option>');
				$('#idCedente').chosen().trigger("chosen:updated");
	        },
	        success: function(data) { //$('body').html(data);
	        	paramCedentes = data;
	        	
	        	if (0 == data.cedentes.length) 	$('#idCedente').html('<option>Não encontrado nenhum parâmetro</option>');
	        	else							$('#idCedente').html('');	
	        	
	        	$.each(data.cedentes, function(key, val){
	        		$('#idCedente').append($('<option>', { value : val['idCedente'] }).text(val['nomefantasia']));
	    		});
        		$('#idCedente').chosen().trigger("chosen:updated");
        		
        		if (1 < data.cedentes.length) $('#idCedente').trigger("chosen:open");
        			copiaParamCedente();
        		
        		if (realizaSimulacao) {
        			realizaSimulacaoServidor();
        		}
	        },
	        error: function (request, error) {
				console.log(arguments);
				$('#idCedente').html('<option>Problema ao buscar parâmetros</option>');
				$('#idCedente').chosen().trigger("chosen:updated");
	        }
	    });
		if ($('#idCedente ').attr('role'))
			$('#idCedente option[value="'+ $('#idCedente ').attr('role') +'"]').attr('selected', 'selected').trigger("chosen:updated");
	}
	
	function realizaSimulacaoServidor() {
    	$('select').each(function() { $(this).attr('disabled', false); });
    	var url = window.location.href; url = url.substring(0, url.indexOf("/financiamento/"));
		$.ajax({
	        url: url + "/financiamento/simularFinanciamento",
	        type: "POST",
	        data: $('#form_param').serialize(),
	        beforeSend: function( xhr ) {	        	$('#exibir-simulacao').html(htmlGifCarregando());	        },
	        success: function(data) {
	        	desabilitaSelects();
	        	$('#exibir-simulacao').html(data).after(function() {
	        		$('#comprometimento').val( $('#comprometimentoReal').val() );
        			addConfirmExitToAllComponents('#form_param');
	        	});
	        },
	         error: function (request, error) {
	        	desabilitaSelects();
				console.log(arguments);
	        	$('#exibir-simulacao').html('Não foi possível conectar ao servidor!');
	        }
	    });
	}
	function desabilitaSelects() {
		if ($('#situacao').val() != 'simulacao')
			$('select').each(function() { $(this).attr('disabled', true); });
	}
});
$(function() {
	$( "#dialog-confirma-remover-registro" ).dialog({
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
		"Sim": function() {
		  if ($("#inserirAlterarRemover").val('remover'))
			  $("#form_param").submit();
		  
		  $( this ).dialog( "close" );
		},
		"Retornar": function() {
		   $( this ).dialog( "close" );
		}
	  }
	});
  });
