// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 27/09/2015
*/
$(document).ready(function(e) {
	
	$('.div-chamada-box').css('display', 'block');
	
	atualizaBairrosPelaCidade($('#city'));

	$('#idCliente').change(function() {
		showItinerarios($(this).val());
	});

	$('.div-chamada-box select').change(function() {
		verificaPreenchimentoCalculaValor();
	});
	$('.div-chamada-box input').focusout(function() {
		if ($('.div-chamada-box .div-valor .span-result').html() == 'R$ 0,00') {
			verificaPreenchimentoCalculaValor();
		}
	});
	$('.inpCity').change(function(){
		atualizaBairrosPelaCidade($(this));
	});
	$('.div-chamada-box input[type="checkbox"]').change(function () {
		verificaPreenchimentoCalculaValor();
	});

	$('#div-btn-registrar-chamada').click(function(e) {
		if (verificaPreenchimentoChamado(true) && $('.div-chamada-box .div-valor .span-result').html() != 'Sem valor')
			openDialog('#div-chamado-confirm');
	});
	
	$('.div-btn-chamado-apos-pre-cadastro').click(function(e){
		if (verificaPreenchimentoChamado(true) && $('.div-chamada-box .div-valor .span-result').html() != 'Sem valor')
			calcValorRegistrarChamada(true);
		
		closeDialog('#div-pre-cadastro-dialog');
	});
	
	$('#div-btn-realizar-cadastro').click(function(){
		openDialog('#div-pre-cadastro-dialog');
		$('#div-pre-cadastro-dialog input:first').focus();
	});
	function openDialog(dialogSelector) {
		var zIndex = $('.customDialog:visible, .dialog-background:visible').length + 1001;
		
		var backDialog = $('<div class="dialog-background" style="z-index:'+zIndex+'"></div>');
		$('body').append(backDialog);
			
		$(backDialog).show();
		
		var x1 = $(window).width() /2;
		var x2 = $(dialogSelector).width() /2;
		var diagLeft = x1 - x2;
		
		var y1 = $(window).height() /2;
		var y2 = $(dialogSelector).outerHeight() /2;
		var diagTop = y1 - y2;
		
		zIndex++;
		
		$(dialogSelector)
			.css({
				'left' : '50%',
        		'top' : '50%',		
	    	    'margin-left' : -$(dialogSelector).outerWidth()/2,
		        'margin-top' : - ($(dialogSelector).outerHeight()/2) + $(dialogSelector).offset().top,
				'z-index'  : zIndex
			})
			.show()
			.data( "backDialog", backDialog );
		
		$('.dialog-background').css({
			'width'  : $(document).width(),
			'height' : $(document).height(),
			'top'	 : 0,
			'left'	 : 0
		});
	}

	$('#div-btn-login').click(function(){
		openDialog('#div-login');
	});
	
	$('#div-btn-logoff').click(function(){
		logoffSistema();
	});
	
	createInicialDialog('#div-pre-cadastro-dialog', 600);
	createInicialDialog('#div-pre-cadastro-confirm', 300);
	createInicialDialog('#div-chamado-confirm', 300);
	createInicialDialog('#div-login', 300);
	
	function createInicialDialog(dialogSelector, width) {
		$(dialogSelector).appendTo('body');
		$(dialogSelector).addClass('customDialog').width(width);
		$(dialogSelector).prepend('<div class="dialog-title">'
			+ $(dialogSelector).attr('title')
			+ '<div class="dialog-close">X</div>'
			+ '</div>');
		$(dialogSelector).find('.dialog-close').click(function(e) {
            closeDialog(  $(this).closest('.customDialog') );
        });
	}
	
	$('#pre-cad-button-ok').click(function(e) {
		if (validaPreenchimentoForm('#form-pre-cadastro')) {
			openDialog('#div-pre-cadastro-confirm');
		}
    });
	$('#pre-cad-button-confirma').click(function(e) {
        registrarPreCadastro();
		closeDialog( $(this).closest('.customDialog') );
    });
	
	$('.button-cancel').click(function(e) {
		closeDialog( $(this).closest('.customDialog') );
    });
	
	$('#chamado-button-confirma').click(function(e) {
        calcValorRegistrarChamada(true);
		closeDialog( $(this).closest('.customDialog') );
    });
	
	$('#div-login-enviar').click(function(e) {
        realizarLogin();
    });
	
	function closeDialog(dialogSelector) {
		$(dialogSelector).hide();
		var backDialog = $(dialogSelector).data( "backDialog" )
		$(backDialog).hide();
	}

	//Mascara para CPF ou CNPJ
	$('.mascara_cnpj').mask("000.000.000/0000-00", {reverse: true});
	$('.mascara_cpf').mask("000.000.000-00", {reverse: true});
	$('.mascara_cnpj, .mascara_cpf').keypress(function(){
		$('.mascara_cnpj:hidden, .mascara_cpf:hidden').val( $(this).val() );
		
		var length = $(this).val();
			length = length.replace(/\D/g, '');
			length = length.length;
			
		if (length <= 11) {
			$('.mascara_cnpj').attr('name', '').hide();
			$('.mascara_cpf').attr('name', 'cnpj').show().focus();
		}
		if (length >= 11 && event.which >= 48 && event.which <= 57) {
			$('.mascara_cpf').attr('name', '').hide();
			$('.mascara_cnpj').attr('name', 'cnpj').show().focus();
		}
	});

	//Mascara para Telefone
	$('.mascara_telefone').mask("(00) 0000-00000", {reverse: false});
	
	
	$('.div-address-add').click(function(){
		addAddressLine();
	});
	
}); /*$(document).ready(function(e) {*/

function addAddressLine() {
	$('.div-box-change-address:last').css('display', 'inline-block');
	
	var clone = $('#div-box-addresses .div-box-line:first').clone(true, false);
	$(clone).find('.div-box-change-address').css('display', 'none');
	$(clone).find('input').val('');
	$(clone).find(".inpNeighbor option:eq(0)").prop('selected', true).trigger("chosen:updated");
	$(clone).appendTo('#div-box-addresses');
	
	addListeners(clone);
	updateRemovers();
	
	if ( $('.div-box-line').length == 2 ) addListeners ( $('#div-box-addresses .div-box-line:first') );
}


function addListeners(component) {
	
	$(component).find('select').change(function() {
		verificaPreenchimentoCalculaValor();
	});

	$(component).find('.div-address-remove').click(function(){
		$(this).parent().parent().remove();
		
		updateRemovers();
	});
	
	$(component).find('input').focusout(function() {
		if ($('.div-chamada-box .div-valor .span-result').html() == 'R$ 0,00') {
			verificaPreenchimentoCalculaValor();
		}
	});
	$(component).find('.inpCity').change(function(){
		atualizaBairrosPelaCidade($(this));
	});
	
	$(component).find('.div-box-change-address').click(function(){
		var linhaAtual = $(this).parent();
		var proxLinha  = $(linhaAtual).next('.div-box-line');
		
		var city1 	  = $(linhaAtual).find('#city option:selected').index();
		var neightbor1= $(linhaAtual).find('#neightbor option:selected').index();
		var address1  = $(linhaAtual).find('#address').val();
		var number1	  = $(linhaAtual).find('#number').val();
		var talkto1	  = $(linhaAtual).find('#talkto').val();

		var city2 	  = $(proxLinha).find('#city option:selected').index();
		var neightbor2= $(proxLinha).find('#neightbor option:selected').index();
		var address2  = $(proxLinha).find('#address').val();
		var number2	  = $(proxLinha).find('#number').val();
		var talkto2	  = $(proxLinha).find('#talkto').val();

		$(linhaAtual).find('#city option:eq('+city2+')').prop('selected', true);
		$(linhaAtual).find('#neightbor option:eq('+neightbor2+')').prop('selected', true);
		$(linhaAtual).find('#address').val(address2);
		$(linhaAtual).find('#number').val(number2);
		$(linhaAtual).find('#talkto').val(talkto2);

		$(proxLinha).find('#city option:eq('+city1+')').prop('selected', true);
		$(proxLinha).find('#neightbor option:eq('+neightbor1+')').prop('selected', true);
		$(proxLinha).find('#address').val(address1);
		$(proxLinha).find('#number').val(number1);
		$(proxLinha).find('#talkto').val(talkto1);
	});
}

function updateRemovers() {
	//verificaPreenchimentoCalculaValor();
	$('.div-valor .span-result').html('R$ 0,00');
	
	if ($('.div-address-remove').length > 2) $('.div-address-remove').css('display', 'block');
	else									 $('.div-address-remove').css('display', 'none');

	$('.div-box-change-address:last').css('display', 'none');
}

function calcValorRegistrarChamada(registrarChamada) {

	 //if ($('.div-chamada-box .div-valor .span-result').html() == 'Sem valor') {
		var url 	  = $('#url-address-default').val();
		var clientKey = $('#clientKey').val();

		enableFields();

		var dados = $('#form-chamado').serialize() + '&registrarChamada=' + registrarChamada + '&clientKey=' + clientKey;

		$.ajax({
	        url: url + $('#form-chamado').attr('action'),
			xhrFields: {
				withCredentials: true
			},
	        type: "POST",
	        data: dados,
			crossDomain: true,
			async: true,
	        dataType: "json",
	        beforeSend: function( xhr ) {
	        	disableFields();
				xhr.withCredentials = true;
	        	$('#result-abertura-chamado').html('<img src="'+url+'img/spinner.gif" class="img-carregando"> Aguarde...');
	        },
	        success: function(data) {
	        	//$('#result-abertura-chamado').html(data);
	        	
	        	if (data.resposta == 'success') {
		        	$('.div-btn-chamado-apos-pre-cadastro').remove();
	        		redefineForm();
	        		
	        		if(data.id_chamada) 
	        			//window.location = '../paymentchamada/'+data.id_chamada
					
					$('#result-abertura-chamado').append(' Chamada: ' + data.id_chamada)
	        	}
	        	else if  (data.resposta == 'calculado_valor') {
	        		$('#result-abertura-chamado').html('');

	        		if (data.valor != '0,00') {
	        			$('.div-chamada-box .div-valor .span-result').html('R$ ' + data.valor);
	        		}
	        		else {
	        			$('.div-chamada-box .div-valor .span-result').html('Sem valor');
	        			$('#result-abertura-chamado').html('Este trecho não possui valor. <br>Favor entrar em contato conosco.');
	        		}

	        	}
	        	else
	        		$('#result-abertura-chamado').html('<span class="error">Erro ao inserir chamada! '+ data.error +'</span>');

	        },
	        error: function (request, error) {
	        	$('#result-abertura-chamado').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
	        }
	    });
	//}
}

function redefineForm() {
	enableFields();
	
	$('#result-abertura-chamado').html('Chamada registrada com sucesso!');
	$('.div-box-line:gt(1)').remove();
	updateRemovers();
	$('.div-box-line').find('input').val('');
	
	$('#retornar-origem').prop('checked', false);
	$('.div-valor .span-result').html('R$ 0,00');

	$('.div-box-line').find('.inpCity .optionDefault').prop('selected', true);
	$('.div-box-line').find('.inpCity').trigger("change");
	$('.div-box-line').find(".inpNeightbor option:eq(0)").prop('selected', true);
	
	$('#observation, #tempo_espera').val('');
	
	if ($('#idClienteFreteItinerario')) {
		$('#idClienteFreteItinerario').val('');
	}
}

function verificaPreenchimentoChamado(simulacao) {

	var retorno = true;
	
	$('.inpCity').each(function(){
		if ($(this).val() == null) {
			retorno = false;
			if (simulacao) $(this).css('border-bottom', '2px solid #E60A0A');
		}
		else
			$(this).css('border-bottom', '1px solid #ababab');
	});
	
	$('.inpNeightbor').each(function(){
		if ($(this).find('option:selected').index() < 1) {
			retorno = false;
			if (simulacao) $(this).css('border-bottom', '2px solid #E60A0A');
		}
		else
			$(this).css('border-bottom', '1px solid #ababab');
	});
	$('.inpAddress').each(function(){
		if ($(this).val().length < 3) {
			retorno = false;
			if (simulacao) $(this).css('border-bottom', '2px solid #E60A0A');
		}
		else
			$(this).css('border-bottom', '1px solid #ababab');
	});
	$('.inpNumber').each(function(){
		if ($(this).val().length < 2) {
			retorno = false;
			if (simulacao) $(this).css('border-bottom', '2px solid #E60A0A');
		}
		else
			$(this).css('border-bottom', '1px solid #ababab');
	});

	if (!retorno) $('.div-valor .span-result').html('R$ 0,00');

	return retorno;
}

/*
function registrarPreCadastro() {

	var url = $('#url-address-default').val();
	var clientKey = $('#clientKey').val();
	
	$.ajax({
        url: url + $('#form-pre-cadastro').attr('action'),
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
        data: $('#form-pre-cadastro').serialize() + '&clientKey=' + clientKey,
        dataType: "json",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        	$('#resultado-pre-cadastro').html('<img src="'+url+'img/spinner.gif" class="img-carregando"> Aguarde...');
        },
        success: function(data) {
        	
        	//$('#resultado-pre-cadastro').html(data);
        	
        	//return false;
        	// Inclusão somente do reload, para voltar a página anterior, fechando as divs abertas (modal)
        	if (data.resposta == 'success') {
       			$('#resultado-pre-cadastro').html( 'Cadastro efetuado. Faça login para registrar sua chamada.' );
        	}
        	else
        		$('#resultado-pre-cadastro').html( '<div class="error">Não foi possível inserir. '+data.error+'</div>' );

        },
        error: function (request, error) {
        	$('#resultado-pre-cadastro').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
        }
    });
}
*/



function registrarPreCadastro() {

	var url = $('#url-address-default').val();
	var clientKey = $('#clientKey').val();
	
	$.ajax({
        url: url + $('#form-pre-cadastro').attr('action'),
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
        data: $('#form-pre-cadastro').serialize() + '&clientKey=' + clientKey,
        dataType: "json",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        	$('#resultado-pre-cadastro').html('<img src="'+url+'img/spinner.gif" class="img-carregando"> Aguarde...');
        },
        success: function(data) {
        	//$('#resultado-pre-cadastro').html(data);
        	
        	if (data.resposta == 'success') {
        		$('#sucesso-pre-cadastro').show();
        		$('.div-btn-chamado-apos-pre-cadastro-2').show();
        		//$('#div-btn-realizar-cadastro').remove();
        		$('.div-pre-cadastro-form, .div-pre-cadastro-title, .div-pre-cadastro-footer, .dialog-buttons-component').hide();
        		$('#resultado-pre-cadastro').html('');
        		//$('#div-pre-cadastro-dialog').children('button:first').remove();
        		$(".dialog-buttons-component-login").show();

            	//$('#pre-cad-button-ok').remove();
        	}
        	else
        		$('#resultado-pre-cadastro').html( '<div class="error">Não foi possÃ­vel inserir. '+data.error+'</div>' );

        },
        error: function (request, error) {
        	$('#resultado-pre-cadastro').html('Não foi possÃ­vel conectar ao servidor [cod: (ajaxCheck)]!' + error);
        }
    });
}



function realizarLogin() {

	if ( validaPreenchimentoForm('#formLogin') ) {
		
		var url = $('#url-address-default').val();
		var dados = $('#formLogin').serialize();
		var clientKey = $('#clientKey').val();
		
		$.ajax({
			url: url + $('#formLogin').attr('action'),
			xhrFields: {
				withCredentials: true
			},
			type: "POST",
			data: dados + '&clientKey=' + clientKey,
			crossDomain: true,
			async: true,
			dataType : 'json',
			beforeSend: function( xhr ) {
				xhr.withCredentials = true;
				$('#resposta-login').html('<img src="'+url+'img/spinner.gif" class="img-carregando"> Aguarde...');
			},
			success: function(data) {
				if (data.error)
					$('#resposta-login').html( '<div class="error">' + data.mensagem + '</div>' );
				else {
					$('#resposta-login').html( 'Acesso liberado!' );
					location.reload();
				}
			},
			error: function (request, error) {
				$('#resposta-login').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
				location.reload();
			}
		});
	}
}

function atualizaBairrosPelaCidade(cityObj) {
	var idCidade = $(cityObj).val();
	var neighbor = $(cityObj).parent().parent().parent().find('#neightbor');
	
	var url = $('#url-address-default').val();
	var clientKey = $('#clientKey').val();
	
	$.ajax({
        url: url + 'chamadaexterna/retornaAjaxBairros',
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
        data: 'idCidade=' + idCidade + '&clientKey=' + clientKey,
        dataType: "json",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        	$(neighbor).html('<option>Carregando...</option>');
        },
        success: function(data) {
			//$('#result-abertura-chamado').html(data);
			
        	$(neighbor).html('<option>Bairro</option>');
        	
        	$.each(data, function(key, val){
        		$(neighbor).append($('<option>', { value : val['idBairro'] }).text(val['bairro']));
        	});
        	
        	//seleciona o bairro caso tenha sido definido anteriormente
        	if ($(neighbor).attr('rule')) {
        		$(neighbor).val($(neighbor).attr('rule'));
        	}
        	
        	if ( $('.div-box-line').length == 1 ) addAddressLine();
        },
        error: function (request, error) {
        	$(cityObj).next('#neighbor').html('<option>Selecione uma cidade</option>');
        }
    });
}

function verificaPreenchimentoCalculaValor() {
	$('.div-valor .span-result').html('R$ 0,00');
	if (verificaPreenchimentoChamado(false))
		calcValorRegistrarChamada(false);
}

function verificaPreenchimentoCalculaValorMostraErros() {
	if (verificaPreenchimentoChamado(true))
		calcValorRegistrarChamada(false);
}

function logoffSistema() {
	
	var url = $('#url-address-default').val();
	
	$.ajax({
        url: url + 'chamadaexterna/logoffexerno',
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        	$('#result-abertura-chamado').html('<option>Saindo...</option>');
        },
        success: function(data) {
			$('#result-abertura-chamado').html(data);
			location.reload();
        },
        error: function (request, error) {
        	//$('#result-abertura-chamado').html('Por favor, recarregue a página!');
			location.reload();
        }
    });
}

function validaPreenchimentoForm(elem) {
	var retorno = true;
	
	$(elem).find('input:visible').each(function(index, element) {
        if ( $(this).val().length < $(this).attr('minlength') 
			|| $(this).val().length > $(this).attr('maxlength') 
			|| ( $(this).val().length == 0 && $( this ).prop( 'required' ) ) )
		{
			$(this).css('border-bottom', '2px solid #E60A0A');
			retorno = false;
		}
		else $(this).css('border-bottom', '1px solid #ababab');
    });
	
	return retorno;
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

function selecionouItinerario(calcVal) {
	if ( $('#idClienteFreteItinerario').val() != '') {

		var servicosJson = JSON.parse( $('#div-itinerario-servicos').html() );

		$('#form-chamado').find('input:not("#retornar-origem")').val('');
		$('#form-chamado #city').val(1).trigger('change');
		
		var lineServico = $('#servicosTable tr:first').clone(true, true);
		
		$('.div-box-line:gt(1) .div-address-remove').trigger('click');

		var id = $('#idClienteFreteItinerario').val();
		var tipo_veiculo = $('#idClienteFreteItinerario option:selected').attr('tipo_veiculo');
		var retorno = $('#idClienteFreteItinerario option:selected').attr('retorno');
		retorno = (retorno == 0) ? false : true;

		$('#vehicle').val(tipo_veiculo);
		$('#retornar-origem').attr('checked', retorno);

		var index = 0;
		$.each(servicosJson, function(key, value) {
			if (value.idClienteFreteItinerario == id) {
				if (index > 1) addAddressLine();

				$('.div-box-line:eq('+ index +') #neightbor').attr('rule', value.bairro);
				$('.div-box-line:eq('+ index +') #address').val(value.endereco);
				$('.div-box-line:eq('+ index +') #number').val(value.numero);
				$('.div-box-line:eq('+ index +') #talkto').val(value.falarcom);
				$('.div-box-line:eq('+ index +') #city').val(value.cidade).trigger('change');
				
				index++;
			}
		});
		disableFields();
		
		if (calcVal) {
			setTimeout(verificaPreenchimentoCalculaValor, 500);
		}
	}
	else {
		redefineForm();
	}
}

function enableFields() {
	$('#form-chamado').find('input, select').attr('disabled', false);
}

function disableFields() {
	if ($('#idClienteFreteItinerario').length && $('#idClienteFreteItinerario').val() != '') {
		// $('#form-chamado #retornar-origem').attr('checked', false);
		$('#form-chamado').find('input:not("#observation, #talkto, #tempo_espera"), select:not("#idClienteFreteItinerario")').attr('disabled', true);
	}
}