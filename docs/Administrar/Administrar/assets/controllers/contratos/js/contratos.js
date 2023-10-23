$(function(){
	$('#idCliente').chosen({
    	placeholder_text_single : 'Selecione o Cliente'
	});
	
	$('#idCedente').chosen({
    	placeholder_text_single : 'Selecione o Cedente'
	});	
	

});


function adicionarFuncionario() {
	var countFunc = $("#countFunc").val();
	var table = $("#funcs");
	var modelo = $("#modelo").html();
	modelo = replaceAll(modelo, 'COUNT', countFunc);
	countFunc++;
	$("#countFunc").val(countFunc);
	table.append(modelo);
}

function removerFuncionario(id) {
	var linha = $("#func_" + id);
	linha.remove();
}

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


function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

