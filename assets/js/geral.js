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


