// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 19/09/2015
*/
var showConfirm = false;

$(document).ready(function() {
	
	/* Seleciona menu atual */
	//alert( $('#cssmenu ul ul ul .active').parent().parent().find('a:first').html() );
	if ( !$('#cssmenu ul ul ul .active').parent().is(':visible') )
		$('#cssmenu ul ul ul .active').parent().parent().find('a:first').trigger('click');
	
	inserePerfilNosLinksForms();
	
	//inserePerfilNosLinksAjax();

	// chosen
	$(".chosen-select").chosen();
	
	//cria componente calendário nos campos de data
	$(".datepicker").datepicker({
	    dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	});
	
	//necessário para que formulário possa validar select (devido ao uso do plugin chosen)
	$.validator.setDefaults({ ignore: ":hidden:not(select)" }); 
	
	//Mascara para valor em reais RS
	$('.mascara_reais').mask("#.##0,00", {reverse: true, placeholder: "0,00"});
	
	//Mascara para inputs de data
	$('.mascara_data').mask("##/##/####", {reverse: true, placeholder: "__/__/____"});

	//Mascara para inputs de telefone
	$('.mascara_telefone').mask("####-#####", {reverse: false});
	
	//Mascara para porcentagem em valores absolutos (sem decimal)
	$('.mascara_porcentagem_sem_decimal').mask("#.##0", {reverse: true, placeholder: "0%"});

	//Mascara para aceitar apenas numeros
	$('.mascara_so_numeros').mask("#", {reverse: true});
	
	//Mascara para porcentagem com duas casas decimais
	$('.mascara_porcentagem_2_decimais').mask("#.##0,00", {reverse: true, placeholder: "0,00%"});
	
	//Mascara para porcentagem com duas casas decimais
	//$('.mascara_porcentagem_3_decimais').mask("#.##0,000%", {reverse: true, placeholder: "0,000%"});
	$('.mascara_porcentagem_3_decimais').mask("#.##0,000", {reverse: true, placeholder: "0,000%"});
	
	//Mascara para números absolutos (sem casa decimal)
	$('.mascara_numero_sem_decimal').mask("#.##0", {reverse: true});

	$('.mascara_letra_num').mask('ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ', 
			{'translation': {Z: {pattern: /[A-Za-z0-9_]/}}});

	$('.mascara_letra_num_traco_arroba_ponto').mask('ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ', 
			{'translation': {Z: {pattern: /[A-Za-z0-9\_\-\.^\@]/}}});

	$('.mascara_letra_num_barra').mask('ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ', 
			{'translation': {Z: {pattern: /[A-Za-z0-9_/]/}}});
	
	$('.mascara_letra_num_espaco').mask('ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ', 
			{'translation': {Z: {pattern: /[A-Za-z0-9\s _]/}}});
	
	$('.mascara_float_3_digitos').mask("#.##0,000", {reverse: true});
	
	$('.alert-success').css({
			'opacity': 0, 
			'width':'300px',
			'position':'absolute',
			'top':'40px',
			'left':'0',
			'right':'0',
			'margin-left':'auto',
			'margin-right':'auto'
		}).show().animate({opacity:1},200).delay(5000).animate({opacity:0},200);
	
	window.onbeforeunload = confirmExit;
})

function converteMonetarioReais(num) {
	return parseFloat(num, 10).toFixed(2).replace('.',',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.").toString()
}

function convertePorcentSemDecimal(num) {
	return parseFloat(num, 10).toFixed(0).replace('.',',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.").toString()
}

function convertePorcent3Decimais(num) {
	return parseFloat(num, 10).toFixed(3).replace('.',',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.").toString()
}

function convertePorcent2Decimais(num) {
	return parseFloat(num, 10).toFixed(2).replace('.',',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.").toString()
}

function confirmExit() {
	if(showConfirm){
		return "Parece que você não salvou algum registro. Deseja realmente sair desta página?";
	}
}

function addConfirmExitToAllComponents(componentesPai) {
	var pais = componentesPai.split(',');
	pais.forEach(function(pai) {
		$(pai + ' input, textarea, select').on('inputchange', function() { showConfirm = true });
	});
}

function removeMensagemAlertaTopoPagina() {
	$(".container-fluid .span12:first .alert").remove();
}

function mostrarMensagemAlertaTopoPagina(tipo, mensagem) {
	if (tipo == 'error') tipo = 'danger';
	
	$(".container-fluid .span12:first .alert").remove();
	$(".container-fluid .span12:first").prepend(
		'<div class="alert alert-'+ tipo +'">'+
        '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
        mensagem+
        '</div>'
	);
}

/*utilizado apra verificar se o valor de um campo input foi alterado*/
$.event.special.inputchange = {
    setup: function() {
        var self = this, val;
        $.data(this, 'timer', window.setInterval(function() {
            val = self.value;
            if ( $.data( self, 'cache') != val ) {
                $.data( self, 'cache', val );
                $( self ).trigger( 'inputchange' );
            }
        }, 20));
    },
    teardown: function() {
        window.clearInterval( $.data(this, 'timer') );
    },
    add: function() {
        $.data(this, 'cache', this.value);
    }
};

//substitui os métodos de validação da biblioteca validate para aceitar vírgola em núm. decimais
jQuery.validator.methods.max = function( value, element, param ) {
	value = parseFloat(value.replace(".", "").replace(",", "."));
	return this.optional(element) || value <= param;
}
jQuery.validator.methods.min = function( value, element, param ) {
	value = parseFloat(value.replace(".", "").replace(",", "."));
	return this.optional(element) || value >= param;
}
jQuery.extend(jQuery.validator.messages, {
    required: "Campo obrigatório",
    remote: "Preencha este campo",
    email: "Endereço de e-mail inválido",
    url: "Endereço de URL inválida",
    date: "Data inválida",
    dateISO: "Informação ISO inválida",
    number: "Número inválido",
    digits: "Informe somente números",
    creditcard: "Número de cartão inválido",
    equalTo: "Informe o mesmo valor novamente",
    accept: "Informe um valor com extenção válida",
    maxlength: jQuery.validator.format("Informe no máximo {0} caracteres"),
    minlength: jQuery.validator.format("Informe no mínimo {0} caracteres"),
    rangelength: jQuery.validator.format("Informe um valor entre {0} e {1} caracteres"),
    range: jQuery.validator.format("Informe um valor entre {0} e {1}"),
    max: jQuery.validator.format("Valor máximo é {0}"),
    min: jQuery.validator.format("Valor mínimo é {0}")
});

/**
 * Insere idPerfil automaticamente a todos os links que não possuem
 */
function inserePerfilNosLinksForms() {
	/* aplica idPerfil aos links <a href= */
	$('#content a').each(function() {
		addPerfilToLink(this, 'href');
	});
	
	/* aplica idPerfil aos links <a href= */
	$('#content form').each(function() {
		addPerfilToLink(this, 'action');
	});
}
function addPerfilToLink(obj, attr) {

	var url = $(obj).attr(attr);
	var newUrl = getURLWithProfile(url);
	
	$(obj).attr(attr, newUrl);
}

function getURLWithProfile(url) {
	//var idPerfilURL = $('#idPerfilURL').val();
	var idPerfilURL = getProfileFromURL();

	/* se idPerfil existe */
	if (Number(idPerfilURL)) {
		if (typeof url !== typeof undefined && url.indexOf('http') > -1) {
			var parts = url.split('/');
	
			if(parts[4] == 'index.php') {
				parts.splice(4, 1);
			}
			
			if (parts.length > 4 && parts[4] != "" && !Number(parts[4])) {
				parts.splice(4, 0, idPerfilURL);
			}
			return parts.join('/');
		}
	}
	else return url;
}

function getProfileFromURL() {
	var url = window.location + '';
	
	if (typeof url !== typeof undefined && url.indexOf('http') > -1) {
		var parts = url.split('/');
		
		if(Number(parts[4])) {
			return parts[4];
		}
	}
	
	return false;
}

function inserePerfilNosLinksAjax() {
	$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		options.url = getURLWithProfile(options.url);
	});
}

function htmlGifCarregando() {

	var urlGif = '<img src="';
	
	urlGif += window.location.origin;
	urlGif += '/Administrar/img/spinner.gif" class="img-carregando">';
	
	return urlGif;
}

function onSubmitChangeCheckboxesToInput(form, elements) {
	
	$(form).submit(function() {

		$(form).find(elements).each(function() {
			var name = $(this).attr('name');
			var value = ($(this).is(":checked")) ? "on" : "";
			
			var newInput = '<input type="hidden" name="'+name+'" value="'+value+'">';
			$(form).append(newInput);
			$(this).attr('name', '');
			
		});
	});
}

