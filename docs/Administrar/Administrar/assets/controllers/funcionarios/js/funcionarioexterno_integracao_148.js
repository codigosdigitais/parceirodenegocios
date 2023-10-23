/*
$(document).ready(function() {
	
	$('#div-box-chamado-integracao-funcionario').css('display', 'none');
	
	createInicialDialog('#div-box-chamado-integracao-funcionario', 800);
	
	$('#div-box-abre-cad-funcionario').click(function(e) {
		openDialog('#div-box-chamado-integracao-funcionario');
	});
});



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
}*/