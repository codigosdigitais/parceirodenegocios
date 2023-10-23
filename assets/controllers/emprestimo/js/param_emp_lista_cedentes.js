// JavaScript Document
/*
* @autor: Davi Siepmann
* @date: 26/09/2015
*/

$(document).ready(function(e) {	
	//habilita /desabilita parametrizações para cedente
	$('.btn-on-disabled').click(function(e) {
		$(this).parent().find('input[name^="tb_habilitado"]').val('1');
		$(this).parent().submit();
	});
	$('.btn-off-disabled').click(function(e) {
		$(this).parent().find('input[name^="tb_habilitado"]').val('0');
		$(this).parent().submit();
	});
	
	$('.btn-on-enabled').click(function(e) {
		$(this).css('background-color', '#6CAEE6');
	});

	$('.btn-off-enabled').click(function(e) {
		$(this).css({'background-color': '#E80808', 'color': '#E2E2E2'});
	});
});
