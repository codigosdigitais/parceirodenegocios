// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 12/10/2015
*/
$(document).ready(function(e) {
	
	$('.btn-remover').click(function(e) {
		var idEmprestimo = $(this).find('#idEmp').val();
		$('#idEmprestimo').val( idEmprestimo );
		$( "#dialog-confirma-remover-registro" ).dialog( "open" );
	});
	
});

$(function() {
	$( "#dialog-confirma-remover-registro" ).dialog({
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
			$("#inserirAlterarRemover").val('remover');
			$("#form_param").submit();
			$( this ).dialog( "close" );
		},
		"Retornar": function() {
			$( this ).dialog( "close" );
		}
	  }
	});
  });
