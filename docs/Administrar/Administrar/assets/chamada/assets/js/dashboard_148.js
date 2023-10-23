(function($) {
	'use strict';
		$(function() {

			/* Estrutura simples para exibição da listagem de chamadas pendentes/finalizadas */
			$('.lista-chamadas-finalizadas').DataTable({
				"aLengthMenu": [
					[20, 30, 50, -1],
					[20, 30, 50, "Todos"]
				],
				"order": [[ 0, "ASC" ]],
				"iDisplayLength": 20,
			    "language" : {
			        "sEmptyTable": "Nenhum registro encontrado",
			        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
			        "sInfoPostFix": "",
			        "sInfoThousands": ".",
			        "sLengthMenu": "_MENU_ resultados por página",
			        "sLoadingRecords": "Carregando...",
			        "sProcessing": "Processando...",
			        "sZeroRecords": "Nenhum registro encontrado",
			        "sSearch": "Pesquisar",
			        "oPaginate": {
			            "sNext": "Próximo",
			            "sPrevious": "Anterior",
			            "sFirst": "Primeiro",
			            "sLast": "Último"
			        },
			        "oAria": {
			            "sSortAscending": ": Ordenar colunas de forma ascendente",
			            "sSortDescending": ": Ordenar colunas de forma descendente"
			        }
			    }
			});

			/* Escolha do Período */
			$(".escolher-periodo").on('click', function(){
				var periodo = $(this).attr('data-periodo');
				window.location = BASE_URL + '/chamadas/chamado/'+periodo;
			});



			/* Select 2 Para formulários */
		    $('.select2-lista').select2();


		});
})(jQuery);