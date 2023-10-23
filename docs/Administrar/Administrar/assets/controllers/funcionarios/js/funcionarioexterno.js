/*
 * 
 */

$(document).ready(function() {
	
	$('.btn-copiar-cad').click(function() {
		
		var id = $(this).closest('tr').find('#idFuncionarioExterno').val();
		
		copiarCadastroFuncionario(id);
		
	});
	
});

function copiarCadastroFuncionario(id) {
	
	var url = $('#url-address-default').val();
	var data = 'id=' + id;
	
	$.ajax({
        url: url + 'funcionarioexterno/copiarcadastro',
		xhrFields: {
			withCredentials: true
		},
        type: "POST",
        data: data,
        dataType: "json",
		crossDomain: true,
		async: true,
        beforeSend: function( xhr ) {
			xhr.withCredentials = true;
        },
        success: function(data) {
        	if (data.result == 'success')
        		location.reload();
        	else 
        		alert('Problemas ao copiar cadastro. Tente novamente.')
        },
        error: function (request, error) {
        	$('#resultado-pre-cadastro').html('<div class="error">Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error +'</div>');
        }
    });
	
}