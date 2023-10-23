// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 21/09/2015
*/

$(document).ready(function(e) {
	//previne ação do clique em "<a>" nos botões dentro das tabelas
	$(".table a").click(function(e) {
		event.preventDefault()
	});
	
	$('#idFuncionario').chosen({
    	placeholder_text_single : 'Selecione o Funcionário'
	});	
	
	addConfirmExitToAllComponents('.table-emprestimo, .table-financiamento');
	
	//exibe os inputs para alterar valores
	$('.a-btn-inputs-financiamento').click(function(e) {
		$( ".table-financiamento label" ).hide();
		$( ".table-financiamento input, .table-financiamento select" ).show();
		$( ".table-financiamento input:first" ).focus().select();
	});
	$('.a-btn-inputs-emprestimo').click(function(e) {
		$( ".table-emprestimo label" ).hide();
		$( ".table-emprestimo input, .table-emprestimo select" ).show();
		$( ".table-emprestimo input:first" ).focus().select();
	});
	
	//prepara submit do formulário, verifica se esqueceu de adicionar parâmetro por funcionário
	$("form :submit").click(function(e) {
		event.preventDefault();
		if ( $("#idFuncionario option:selected").index() > 0 ) {
			$( "#dialog-confirma-inclusao-funcionario" ).dialog( "open" );
		}
		else submitForm();
	});
	
	verificaAddBotaoSubmit();
});

//janela de confirmação de inserção de funcionário quando selecionado
//usuário não clica em Adicionar antes de gravar
$(function() {
	$( "#dialog-confirma-inclusao-funcionario" ).dialog({
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
		  adicionarFuncionario();
		  submitForm();
		  $( this ).dialog( "close" );
		},
		"Não": function() {
		  submitForm();
		  $( this ).dialog( "close" );
		},
		"Retornar": function() {
		   $( this ).dialog( "close" );
		}
	  }
	});
  });
	  
function adicionarFuncionario() {
	//cria linhas na tabela contendo os parâmetros por funcionário
	var naoExisteAidna = false;
	
	itemm = $('#param_func_group input[name^="tb_idFuncionario"]').filter(function(){
		return this.value == $("#idFuncionario").val()
	});
	if ($(itemm).val() === undefined) naoExisteAidna = true;
	
	if ( naoExisteAidna && ($("#idFuncionario option:selected").index() > 0 || $("#idCedente option:selected").index() > 0)) {
		removeMensagemAlertaTopoPagina();

		var modelo = '<tr style="backgroud-color: #2D335B">\n';
		
			modelo+= '<td style="text-align:left !important;">';
			
			if ($("#idCedente option:selected").index() > 0)
				modelo+= '<i>' + $("#idCedente option:selected").text() + '</i><br />';
			
			if ($("#idFuncionario option:selected").index() > 0)
				modelo+= $("#idFuncionario option:selected").text();
			
			modelo+= '<input type="hidden" name="tb_idParametro[]" value="">';
			modelo+= '<input type="hidden" name="tb_idFuncionario[]" value="'+ $("#idFuncionario").val() +'">';
			modelo+= '<input type="hidden" name="tb_action[]" value="inserir">';
			modelo+= '</td>\n';
			
			modelo+= '<td><label>' + $("#add_emp_max_valor").val() +'</label>';
			modelo+= '<input name="tb_emp_max_valor[]" type="hidden" value="'+ $("#add_emp_max_valor").val() +'" class="hideshow mascara_reais">';
			modelo+= '</td>\n';
			
			modelo+= '<td><label>' + $("#add_emp_max_comprometimento").val() +'</label>';
			modelo+= '<input name="tb_emp_max_comprometimento[]" type="hidden" value="'+ $("#add_emp_max_comprometimento").val() +'" class="hideshow mascara_porcentagem_sem_decimal">';
			modelo+= '</td>\n';
			
			modelo+= '<td><label>' + $("#add_emp_max_parcelas").val() +'</label>';
			modelo+= '<input name="tb_emp_max_parcelas[]" type="hidden" value="'+ $("#add_emp_max_parcelas").val() +'" class="hideshow mascara_numero_sem_decimal">';
			modelo+= '</td>\n';

			modelo+= '<td><label>' + $("#add_emp_tx_juros").val() +'</label>';
			modelo+= '<input name="tb_emp_tx_juros[]" type="hidden" value="'+ $("#add_emp_tx_juros").val() +'" class="hideshow mascara_porcentagem_3_decimais">';
			modelo+= '</td>\n';
			
			modelo+= '<td style="border-left: 1px solid #a1a1a1;"><label>' + $("#add_financ_max_valor").val() +'</label>';
			modelo+= '<input name="tb_financ_max_valor[]" type="hidden" value="'+ $("#add_financ_max_valor").val() +'" class="hideshow mascara_reais">';
			modelo+= '</td>\n';
			
			modelo+= '<td><label>' + $("#add_financ_max_comprometimento").val() +'</label>';
			modelo+= '<input name="tb_financ_max_comprometimento[]" type="hidden" value="'+ $("#add_financ_max_comprometimento").val() +'" class="hideshow mascara_porcentagem_sem_decimal">';
			modelo+= '</td>\n';
			
			modelo+= '<td><label>' + $("#add_financ_max_parcelas").val() +'</label>';
			modelo+= '<input name="tb_financ_max_parcelas[]" type="hidden" value="'+ $("#add_financ_max_parcelas").val() +'" class="hideshow mascara_numero_sem_decimal">';
			modelo+= '</td>\n';

			modelo+= '<td><label>' + $("#add_financ_tx_juros").val() +'</label>';
			modelo+= '<input name="tb_financ_tx_juros[]" type="hidden" value="'+ $("#add_financ_tx_juros").val() +'" class="hideshow mascara_porcentagem_3_decimais">';
			modelo+= '</td>\n';
			
			modelo+= '<td class="tb_acoes_ee">';
			modelo+= '<button class="btn btn-alterar" type="button" onclick="editarParametro(this)">';
			modelo+= '<i class="icon-list-alt"></i><label>Alterar</label></button> ';
			modelo+= '<button class="btn btn-remover" type="button" onclick="removeParametro(this)">';
			modelo+= '<i class="icon-trash"></i></button>';
			modelo+= '</td>\n';
			modelo+= '</tr>\n';
		$("#param_func_group").append(modelo);
		$("#idFuncionario option:selected").hide();
		$("#idFuncionario option:eq(0)").prop('selected', true).trigger("chosen:updated");
		
		verificaAddBotaoSubmit();
	}
}

//prepara form e submit
function submitForm() {
	showConfirm = false;
	$('.table-funcionarios').find('input[name^="tb_action"]').each(function(){
		//se action estiver em branco é pq não foi inserido, nem precisa editar ou remover...
		//então não envia para o servidor não precisar tratar
		if ($(this).val() == '') $(this).parent().parent().find('input').remove();
	})
	$( '#form_param' ).submit();
}

//prepara linha para edição de parâmetro
function editarParametro(removeButton) {
	if ( $(removeButton).find('label').text() == 'Alterar' ) {
		$(removeButton).parent().parent().addClass('tr_editando').after(function() {
			//envia para servidor apenas registros que já existem
			$(this).find('label').hide();
			$(this).find('.hideshow').attr('type', 'text');
			$(this).find(':text:first').focus().select();
			
			if ( $(this).find('input[name^="tb_action"]').val() == '') {
				$(this).find('input[name^="tb_action"]').val("alterar");
			}
		});
		$(removeButton).find('label').show().text('Cancelar')
		$(removeButton).find('i').removeClass('icon-list-alt').addClass('icon-repeat');
		showConfirm = true;
	}
	else {
		$(removeButton).parent().parent().removeClass('tr_editando').after(function() {
			//envia para servidor apenas registros que já existem
			$(this).find('label').show();
			$(this).find('.hideshow').attr('type', 'hidden');
			
			if ( $(this).find('input[name^="tb_action"]').val() == 'alterar') {
				$(this).find('input[name^="tb_action"]').val('');
			}
			else {
				$(this).find('.hideshow').text( $(this).prev('label').text() ); alert('aqui');
			}
		});
		$(removeButton).find('label').show().text('Alterar')
		$(removeButton).find('i').removeClass('icon-repeat').addClass('icon-list-alt');
	}
}

//remove linha contendo parâmetro
function removeParametro(removeButton) {
	$(removeButton).parent().parent().hide().after(function() {
		//envia para servidor apenas registros que já existem
		if ( $(this).find('input[name^="tb_idFuncionarioParam"]').val() != '') {
			$(this).find('input[name^="tb_action"]').val("remover");
		}
		else $(this).remove();
	});
	showConfirm = true;
}

function verificaAddBotaoSubmit() {
	//adiciona botão para gravar ao final do formulário
	if ($(".table-funcionarios").height() > 400) {
		var botao = $(":submit:first").clone(true, true);
		$(".button-form-end center").html( botao );
	}
	else $(".button-form-end center").html( "" );
}