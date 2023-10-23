
//#box-funcionario-externo
var clicado = false;
$(document).ready(function() {
		
	$('#box-funcionario-externo').show();
	
	createInicialDialog('#div-cadastro-confirm', 300);
	
	$("#btn-cadastrar-funcionario").click(function(){
		verificaPreenchimento();
		
		if ( $('.cad-error').length == 0 ) {
			openDialog('#div-cadastro-confirm');
		}
	});
	$("#btn-cadastro-confirm-ok").click(function(){
		
		if (!clicado) {
			clicado = true;
			var url = $('#url-address-default').val();
			
			$(this).html('<img src="'+url+'img/spinner.gif" class="img-carregando">');
			cadastrarFuncionario();
		}
	});
	
	$(".button-cancel").click(function(){
		closeDialog('#div-cadastro-confirm');
	});
	
	$('#temSmartphoneSim').click(function() {
		$('#tipoSmartphone').prop('disabled', false);
	});
	$('#temSmartphoneNao').click(function() {
		$('#tipoSmartphone').prop('disabled', true);
	});
	
	$('#telefone').mask("(00) 0000-00000", {reverse: false, placeholder: "Telefone"});
});

function verificaPreenchimento() {
	
	//var retorno = true;
	
	$('input[type=text], input[type=password], input[type=email]').each(function(){
		if ($(this).val() == '' || $(this).val().length > $(this).attr('maxlength') || $(this).val().length < $(this).attr('minlength')) {
			//retorno = false;
			$(this).css('border-bottom', '2px solid #E60A0A').addClass('cad-error');;
		}
		else {
			$(this).css('border-bottom', '1px solid #ababab').removeClass('cad-error');
		}
	});
	
	if ($('.cad-error').length > 0) {
		$('html, body').animate({
            scrollTop: $(".cad-error:first").offset().top -10
        }, 500);
	}
	
	//return retorno;
	
}

function limparForm() {
	$('input[type=text], input[type=password], input[type=email]').each(function(){
		$(this).val('');
	});
}
	
function cadastrarFuncionario() {
	var url = $('#url-address-default').val();
	var data = $('#form-pre-cadastro').serialize();
	
	$.ajax({
        url: url + $('#form-pre-cadastro').attr('action'),
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
        data: data,// + '&clientKey=' + clientKey,
        dataType: "json",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        	$('#resultado-pre-cadastro').html('<img src="'+url+'img/spinner.gif" class="img-carregando"> Aguarde...');
        },
        success: function(data) {
        	clicado = false;
        	$("#btn-cadastro-confirm-ok").html('Confirma')
        	
        	//$('#resultado-pre-cadastro').html(data);
        	closeDialog('#div-cadastro-confirm');
        	
        	if (data.resposta == 'success') {
        		$('#resultado-pre-cadastro').html('<div class="cad-success">Cadastro efetuado. Por favor, aguarde nosso contato.</div>');
        		limparForm();
        	}
        	else
        		$('#resultado-pre-cadastro').html( '<div class="cad-error">Não foi possível inserir. '+data.error+'</div>' );
        	
        	$('html, body').animate({
                scrollTop: $("#resultado-pre-cadastro").offset().top -10
            }, 500);
        },
        error: function (request, error) {
        	clicado = false;
        	$("#btn-cadastro-confirm-ok").html('Confirma')
        	closeDialog('#div-cadastro-confirm');
        	$('#resultado-pre-cadastro').html('<div class="cad-error">Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error +'</div>');
        	$('html, body').animate({
                scrollTop: $("#resultado-pre-cadastro").offset().top -10
            }, 500);
        }
    });
}

/**
 * 
 */

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
function openDialog(dialogSelector) {
	var zIndex = $('.customDialog:visible, .dialog-background:visible').length + 1001;
	
	var backDialog = $('<div class="dialog-background" style="z-index:'+zIndex+'"></div>');
	$('body').append(backDialog);
		
	$(backDialog).show();
	
	var x1 = $(window).width() /2;
	var x2 = $(dialogSelector).width() /2;
	var diagLeft = x1 - x2;
	
	var y1 = $(window).height() /2;
	var y2 = $(dialogSelector).height() /2;
	var diagTop = y1 - y2;
	
	zIndex++;
	
	$(dialogSelector)
		.css({
			'left' : diagLeft,
			'top'  : diagTop,
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
function closeDialog(dialogSelector) {
	$(dialogSelector).hide();
	var backDialog = $(dialogSelector).data( "backDialog" )
	$(backDialog).hide();
}