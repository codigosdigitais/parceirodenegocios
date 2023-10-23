$(function(){
	$('#tipo').chosen({
    	placeholder_text_single : 'Selecione o Tipo'
	});
	
	$('#idFuncionario').chosen({
    	placeholder_text_single : 'Selecione o Funcionário'
	});
	
	$('#empresaregistro').chosen({
    	placeholder_text_single : 'Selecione a Empresa'
	});
	
	$('#localtrabalho').chosen({
    	placeholder_text_single : 'Selecione a Empresa'
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

function showAviso(msg) {
	showMessage("Aviso", msg);
}

function showMessage(title, msg) {

	bootbox.dialog({
		message: msg,
		title: title,
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

function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

function removerDialog(msg, link) {

	bootbox.dialog({
		message: msg,
		title: "ConfirmaÃ§Ã£o",
		buttons: {
			yes: {
				label: "Remover",
				className: "btn-danger",
				callback: function() {
					window.location.href = link;
				}
			},
			no: {
				label: "Cancelar",
				className: "btn-primary",
				callback: function() {
				}
			}
		}
	});

}



function removerServico(id) {
	if(id > 0) {
		var linha = $("#servico_" + id);

		linha.remove();
	}
}

function clienteChange() {
	var id = $('#cliente').val();
	
	$.ajax(
		{
			url:"ajax/endereco/" + id,
			success:function(result) {
				$('[name="servicos[0].endereco"]').val(result.endereco);
				$('[name="servicos[0].numero"]').val(result.numero);
				$('[name="servicos[0].bairro"]').val(result.bairro);
				$('[name="servicos[0].cidade"]').val(result.cidade);
			}
			
		}
		
	);
	
}






function adicionarVeiculo() {
	var countFunc = $("#countVei").val();
	var table = $("#veiculos");
	var modelo = $("#modelo").html();
	modelo = replaceAll(modelo, 'COUNT', countFunc);
	countFunc++;
	$("#countVei").val(countFunc);
	table.append(modelo);
}

function removerVeiculo(id) {
	var linha = $("#vei_" + id);

	linha.remove();
}

function remover(id) {
	removerDialog('Deseja remover o funcionário?', 'funcionarios/remover/' + id);
}


function adicionarContrato() {
	var countContrato = $("#countContrato").val();
	var table = $("#dadoscontrato");
	var modelo = $("#dadoscontratoModelo").html();
	modelo = replaceAll(modelo, 'COUNT', countContrato);
	table.append(modelo);
	countContrato++;
	$("#countContrato").val(countContrato);
}

function removerContrato(id) {
	var linha = $("#dados_" + id);
	linha.remove();
}
