
$(function(){
	$('#tipo').chosen({
    	placeholder_text_single : 'Selecione o Tipo'
	});
	
	$('#idFuncionario').chosen({
    	placeholder_text_single : 'Selecione o Funcionário'
	});
});


$(function(){

    // ColorBox em tempo real
    $(document).delegate('.colorbox','click', function(){
        url = this.href;
        $.fn.colorbox({
            href: url
        });
        return false;
    });

    // Faz a mensagem de sucesso sumir apÃ³s 3 segundos
    setTimeout(function() {
        $('#resultado').fadeAndRemove();
    }, 3000);

    // Desabilita o botÃ£o no modal
    $(document).delegate('.block-footer button[type=button]','click', function(){
        $('.block-footer button[type=button]').disableBt();
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


var cidadesSource = new Bloodhound({
			  datumTokenizer: function(d) { 
			      return Bloodhound.tokenizers.whitespace(d.cidade); 
			  },
			  queryTokenizer: Bloodhound.tokenizers.whitespace,
			  prefetch: 'ajax/cidades',
			  remote: 'ajax/cidades'
		});
		
		var bairrosSource = new Bloodhound({
			  datumTokenizer: function(d) { 
			      return Bloodhound.tokenizers.whitespace(d.nome); 
			  },
			  queryTokenizer: Bloodhound.tokenizers.whitespace,
			  remote: 'ajax/bairros/%QUERY'
		});
			 
cidadesSource.initialize();
bairrosSource.initialize();

function email(id) {
	bootbox.dialog({
		message: "Enviar email dessa chamada?",
		title: "Enviar Email",
		buttons: {
			yes: {
				label: "Enviar",
				className: "btn-success",
				callback: function() {
					window.location.href = "chamadas/enviaremail/" + id;
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

function remover(id) {
	removerDialog('Deseja remover a chamada?', 'chamadas/remover/' + id);
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
		source: cidadesSource.ttAdapter(),
		cache:true
	});
	
	$("[name='servicos[" + countServs + "].bairro']").typeahead(null, {
		displayKey: function(d) {
		    return d.nome;        
		},
		source: bairrosSource.ttAdapter(),
		cache:true
	});
	
	countServs++;
	
	$("#countServs").val(countServs);
}
