<?php 
$cors = new Cors_headers();
$cors->_PRINT_CORS_HEADERS(NULL);

if ($idEmpresaWebsite)
	$this->session->set_userdata(array('idEmpresaWebsite' => $idEmpresaWebsite));

?>
<meta charset="utf-8">

<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>

<link rel="stylesheet" href="<?php echo base_url();?>css/custom_dialog.css" />

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/funcionarios/js/funcionarioexterno_integracao.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/funcionarios/js/funcionarioexterno_integracao_<?php 
echo $idEmpresaWebsite ?>.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/funcionarios/css/funcionarioexterno_integracao_<?php 
echo $idEmpresaWebsite .'_'. $layout ?>.css" />

<style>

</style>

<div id="box-funcionario-externo" style="display: none;">
	
	<div id="div-form">
	
		<form id="form-pre-cadastro" action="funcionarioexterno/form_pre_cadastro" method="post">
		<input type="hidden" id="url-address-default" value="<?php echo base_url(); ?>">
		
			<h3>Informações para Pré-cadastro</h3>
			
			<input type="text" name="nome" id="nome" maxlength="120" minlength="5" placeholder="Nome completo">
			<input type="email" name="email" id="email" maxlength="60" minlength="6" placeholder="Endereço de Email">
			<input type="password" name="senha" id="senha" maxlength="60" minlength="6" placeholder="Senha [mínimo 6 caracteres]">
			<input type="password" name="senha_conf" id="senha_conf" maxlength="60" minlength="6" placeholder="Confirmação de Senha">
			<input type="text" name="telefone" id="telefone" maxlength="15" minlength="14" placeholder="Telefone" value="">
			<input type="text" name="cidade" id="cidade" maxlength="60" minlength="3" placeholder="Cidade" value="Curitiba">
			
			<select name="estado" id="estado">
				<option value="AC">Acre</option>
				<option value="AL">Alagoas</option>
				<option value="AP">Amapá</option>
				<option value="AM">Amazonas</option>
				<option value="BA">Bahia</option>
				<option value="CE">Ceará</option>
				<option value="DF">Distrito Federal</option>
				<option value="ES">Espirito Santo</option>
				<option value="GO">Goiás</option>
				<option value="MA">Maranhão</option>
				<option value="MS">Mato Grosso do Sul</option>
				<option value="MT">Mato Grosso</option>
				<option value="MG">Minas Gerais</option>
				<option value="PA">Pará</option>
				<option value="PB">Paraíba</option>
				<option value="PR" selected="selected">Paraná</option>
				<option value="PE">Pernambuco</option>
				<option value="PI">Piauí</option>
				<option value="RJ">Rio de Janeiro</option>
				<option value="RN">Rio Grande do Norte</option>
				<option value="RS">Rio Grande do Sul</option>
				<option value="RO">Rondônia</option>
				<option value="RR">Roraima</option>
				<option value="SC">Santa Catarina</option>
				<option value="SP">São Paulo</option>
				<option value="SE">Sergipe</option>
				<option value="TO">Tocantins</option>
			</select>
			
			<h3>Informações Complementares</h3>
			
			<label for="temSmartphone">Possui Smartphone?</label>
			<input type="radio" name="temSmartphone" id="temSmartphoneSim" value="1">Sim
			<input type="radio" name="temSmartphone" id="temSmartphoneNao" value="0" checked="checked">Não
			
			<label for="tipoSmartphone">Tipo de Smartphone</label>
			<select name="tipoSmartphone" id="tipoSmartphone" disabled="disabled">
				<option value="Android">Android</option>
				<option value="IOS /Iphone">IOS /Iphone</option>
				<option value="Windows">Windows</option>
				<option value="Outro">Outro</option>
			</select>
			
			<label for="temBauInstalado">Possui baú instalado?</label>
			<input type="radio" name="temBauInstalado" id="temBauInstaladoSim" value="1">Sim
			<input type="radio" name="temBauInstalado" id="temBauInstaladoNao" value="0" checked="checked">Não
			
			<label for="temMEI">Possui empresa em seu nome (MEI)?</label>
			<input type="radio" name="temMEI" id="temMEI" value="1">Sim
			<input type="radio" name="temMEI" id="temMEI" value="0" checked="checked">Não
			
			<label for="temPlacaVermelha">Possui placa vermelha?</label>
			<input type="radio" name="temPlacaVermelha" id="temPlacaVermelhaSim" value="1">Sim
			<input type="radio" name="temPlacaVermelha" id="temPlacaVermelhaNao" value="0" checked="checked">Não
			
			<label for="temCondumoto">Possui certificado Condumoto?</label>
			<input type="radio" name="temCondumoto" id="temCondumotoSim" value="1">Sim
			<input type="radio" name="temCondumoto" id="temCondumotoNao" value="0" checked="checked">Não
			
			<div id="btn-cadastrar-funcionario">Cadastrar</div>
			
			<div id="resultado-pre-cadastro"></div>
		</form>
		
	</div>
	
</div>
<div id="div-cadastro-confirm" title="Registrar pré-cadastro" style="display:none">
    <p>
        Confirma o registro do pré-cadastro?
    </p>

    <hr />
    <div class="dialog-buttons-component">
        <div class="dialog-button" id="btn-cadastro-confirm-ok">Confirma</div>
        <div class="dialog-button button-cancel">Cancelar</div>
    </div>
</div>