
$(document).ready(function(){
	$('#idClienteFreteItinerario').on('change', '', function(){ 
		selecionouItinerario();
	});
	
	$('#servicosTable').on('change', 'select.selectCidade', function(){ 
		getSelectCidade(this);
	});
	
	adicionarServico();
	
	$('#alterar_valor').change(function(){
		if ($(this).prop('checked') == true) {
			$("[name='valor_empresa'], [name='valor_funcionario']").prop('disabled', false);
			$('#calcula_automatico').prop('checked', false);
		}
		else {
			$("[name='valor_empresa'], [name='valor_funcionario']").prop('disabled', true);
		}
	});
	$('#calcula_automatico').change(function(){
		if ($('#alterar_valor').prop('checked') == true) {
			$(this).prop('checked', false);
		}
	});
});

$(function(){
	$('#idFuncionario').chosen({
    	placeholder_text_single : 'Selecione o Funcionário'
	});	
});


( function( $ ) {
	$(document).ready(function() {
		var erros = $("#divErros");
		
		if(erros.length) {
			var msg = "<ul>";
			
			erros.children('input').each(function () {
				msg += "<li>" + this.value + "</li>";
			});
			
			msg += "</ul>";
			
			bootbox.dialog({
				message: msg,
				title: "Aviso",
				buttons: {
					ok: {
						label: "OK",
						className: "btn-primary",
						callback: function() {
						}
					}
				}
			});
		}
	});
})(jQuery);

function maskTime(elm) {
	$(elm).mask("99:99");
}

function maskNum(elm) {
	$("[name='" + elm + "']").keypress(function(event) {
		return MascaraNumero(event);
	});
}

function maskVal(elm) {
	$("[name='" + elm + "']").keypress(function(event) {
		return MascaraValor(event);
	});
}

function maskValor(elm) {
	$(elm).keypress(function(event) {
		return MascaraValor(event);
	});
}

function MascaraNumero(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function mascaraData(campoData){
	campoData.maxLength = 10;
	var v = campoData.value;
	v=v.replace(/\D/g,"");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    campoData.value = v;
}

function MascaraValor(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 44)
		return false;
	
	return true;
}


function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

function removerServico(id) {
	if($('#servicosTable:first tr').length > 2) {

		var linha = $("#servico_" + id);
		
		if ($(linha).find('[name="cham_tiposervico[]"] option').length > 1) {
			var options = $(linha).find('[name="cham_tiposervico[]"]').html();
			$(linha).next('tr').find('[name="cham_tiposervico[]"]').html(options);
		}

		linha.remove();
	}
}

function servicoChange(id) {
	var index = $('[name="servicos[' + id + '].tipo_servico"]').val();
	
	if(index == 2) {
		$('[name="servicos[' + id + '].endereco"]').val($('[name="servicos[0].endereco"]').val());
		$('[name="servicos[' + id + '].numero"]').val($('[name="servicos[0].numero"]').val());
		$('[name="servicos[' + id + '].bairro"]').val($('[name="servicos[0].bairro"]').val());
		$('[name="servicos[' + id + '].cidade"]').val($('[name="servicos[0].cidade"]').val());
		$('[name="servicos[' + id + '].falar_com"]').val($('[name="servicos[0].falar_com"]').val());
	}
}

function adicionarServico() {
	var countServs = $("#countServs").val();
	var table = $("#servicosTable");
	var modelo = $("#servicoModelo").html();
	modelo = replaceAll(modelo, 'COUNT', countServs);
	table.append(modelo);
	$("[name='servicos[" + countServs + "].cidade']").typeahead(null, {
		displayKey: function(d) {
		    return d.cidade;        
		},
//		source: cidadesSource.ttAdapter(),
		cache:true
	});
	$("[name='servicos[" + countServs + "].bairro']").typeahead(null, {
		displayKey: function(d) {
		    return d.nome;        
		},
//		source: bairrosSource.ttAdapter(),
		cache:true
	});
	countServs++;
	$("#countServs").val(countServs);
}

function getSelectCidade(_this){
    var selectBairro = jQuery(_this).parents('tr').find('select.selectBairro');
    selectBairro.html('<option value="0">Carregando...</option>');
    $.post("/Administrar/bairros.ajax.php",
        {cidade:jQuery(_this).val()},
        function(valor){
            selectBairro.html(valor).after(function(){
            	if (selectBairro.attr('rule')) {
            		idBairro = selectBairro.attr('rule');
            		selectBairro.val(idBairro);
            		selectBairro.removeAttr('rule');
            	}
            });
        }
    );
}

function clienteChange() {

	
//	$('#servicosTable tr:not(:first)').remove();
	var id = $('#idCliente').val();
	
//	if ($('[name^="cham_endereco[]"]:first').val() == '') {
		
		$.ajax( 
		{ 
			url:"/Administrar/chamadas/ajax/endereco/" + id, 
			dataType : 'json', 
			success:function(result) {
				$('[name^="cham_endereco[]"]:first').val(result.endereco); 
				$('[name^="cham_numero[]"]:first').val(result.numero); 
				$('[name^="cham_cidade"]:first').val(result.cidade); 
				if(result.cidade){
					$(".selectCidade:first").trigger('change');
				}
				$('[name^="cham_bairro"]:first').attr('rule',result.bairro);
			} 
		});
//	}

	
	$(".selectSolicitante").append('<option value="0">Carregando...</option>');
	$.post("/Administrar/clientes.solicitante.php?idCliente=" + id,
		{solicitante:jQuery(id).val()},
		function(valor){
			 $(".selectSolicitante").html(valor);
		}
	);
	
	showItinerarios(id);
}

function showItinerarios(idCliente) {
	var url = $('#div-itinerario-servicos').attr('role');
	$('#div-itinerario-servicos').html('');
	$('#idClienteFreteItinerario').html('').append('<option></option>');
	$('.div-idClienteFreteItinerario').hide();
	
	$.ajax({ 
		url: url + '/' +idCliente, 
		//dataType : 'json', 
		success:function(result) {
			$('#div-itinerario-servicos').html(result);
			
			var itinerarios = JSON.parse(result);
			var itinerarioAtual = -1;
			$.each(itinerarios, function(key, value) {
				if (itinerarioAtual != value.idClienteFreteItinerario) {
					itinerarioAtual = value.idClienteFreteItinerario;
					$('.div-idClienteFreteItinerario').show();
					
					var option  = '<option value="'+value.idClienteFreteItinerario +'" ';
						option += 'tipo_veiculo="'+value.tipo_veiculo+'" retorno="'+value.retorno+'"'
						option += '>'+value.nome+'</option>';
					$('#idClienteFreteItinerario').append(option);
				}
			});
		} 
	});
}

function selecionouItinerario() {
	if ( $('#idClienteFreteItinerario').val() != '') {
		
		var servicosJson = JSON.parse( $('#div-itinerario-servicos').html() );

		$('#servicosTable tr').find('input').val('');
		$('#servicosTable tr').find('.selectBairro').html('');
		
		var lineServico = $('#servicosTable tr:first').clone(true, true);
		$(lineServico).find('input').val('');
		$(lineServico).find('.selectBairro').html('');
		
		$('#servicosTable tr').remove();
		
		var id = $('#idClienteFreteItinerario').val();
		var tipo_veiculo = $('#idClienteFreteItinerario option:selected').attr('tipo_veiculo');
		var retorno = $('#idClienteFreteItinerario option:selected').attr('retorno');
		retorno = (retorno == 0) ? false : true;
		
		$('select[name="tipo_veiculo"]').val(tipo_veiculo);
		$('#retornar-origem').prop('checked', retorno);
		
		$.each(servicosJson, function(key, value) {
			if (value.idClienteFreteItinerario == id) {
				lineServico = $(lineServico).clone(true, true);

//				lineServico.find('input[name="cham_idClienteFreteItinerarioServico[]"]').val(value.idClienteFreteItinerarioServico);
				lineServico.find('select[name="cham_tiposervico[]"]').val(value.tiposervico);
				lineServico.find('input[name="cham_endereco[]"]').val(value.endereco);
				lineServico.find('input[name="cham_numero[]"]').val(value.numero);
				lineServico.find('select[name="cham_cidade[]"]').val(value.cidade).trigger('change');
				lineServico.find('select[name="cham_bairro[]"]').attr('rule', value.bairro);
				lineServico.find('input[name="cham_falarcom[]"]').val(value.falarcom);

				$('#servicosTable').append(lineServico);
				getSelectCidade(lineServico.find('select[name="cham_cidade[]"]'));
			}
		});
	}
}