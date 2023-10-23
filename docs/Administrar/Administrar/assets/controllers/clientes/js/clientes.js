function copiarRazaoSocial() {
	$('[name="nomefantasia"]').val($('[name="razaosocial"]').val());
}
function copiarDados() {
	$('[name="fat_endereco"]').val($('[name="endereco"]').val());
	$('[name="fat_endereco_numero"]').val($('[name="endereco_numero"]').val());
	$('[name="fat_endereco_complemento"]').val($('[name="endereco_complemento"]').val());
	$('[name="fat_endereco_bairro"]').val($('[name="endereco_bairro"]').val());
	$('[name="fat_endereco_cep"]').val($('[name="endereco_cep"]').val());
	$('[name="fat_endereco_cidade"]').val($('[name="endereco_cidade"]').val());
	$('[name="fat_endereco_estado"]').val($('[name="endereco_estado"]').val());
	$('[name="fat_responsavel"]').val($('[name="responsavel"]').val());
	$('[name="fat_telefone_ddd"]').val($('[name="responsavel_telefone_ddd"]').val());
	$('[name="fat_telefone"]').val($('[name="responsavel_telefone"]').val());
	$('[name="fat_celular_ddd"]').val($('[name="responsavel_celular_ddd"]').val());
	$('[name="fat_celular"]').val($('[name="responsavel_celular"]').val());
	$('[name="email_financeiro"]').val($('[name="email"]').val());
}
function replaceAll(string, token, newtoken) {	while (string.indexOf(token) != -1) { 		string = string.replace(token, newtoken);	}	return string;}
function adicionarServico() {	var countServs = $("#countServs").val();	var table = $("#servicosTable");	var modelo = $("#servicoModelo").html();	modelo = replaceAll(modelo, 'COUNT', countServs);	table.append(modelo);	countServs++;	$("#countServs").val(countServs);}
function removerServico(id) {	if(id > 0) {		var linha = $("#servico_" + id);		linha.remove();
		var linha_abaixo = $("#servico_baixo_" + id);		linha_abaixo.remove();	}}$("#cnpj").keydown(function(){    try {        $("#cnpj").unmask();    } catch (e) {}    var tamanho = $("#cnpj").val().length;    if(tamanho < 11){        $("#cnpj").mask("999.999.999-99");    } else {        $("#cnpj").mask("99.999.999/9999-99");    }                   });