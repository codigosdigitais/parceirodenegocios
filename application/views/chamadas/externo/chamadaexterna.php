<?php 
$cors = new Cors_headers();
$cors->_PRINT_CORS_HEADERS(NULL);

$idAcessoExterno = $this->session->userdata('idAcessoExterno');
$nomeUsuario = $this->session->userdata('nome');
$nomeEmpresa = ($this->session->userdata('nomeEmpresaVinculo')) ? $this->session->userdata('nomeEmpresaVinculo') : $this->session->userdata('razaosocial');

if (isset($this->data['idEmpresaWebsite'])) {
	$this->session->set_userdata($this->data['idEmpresaWebsite']);
	$clientKey = $this->data['clientKey'];
}
else $clientKey = NULL;

$integracao = ($this->session->userdata('idEmpresaWebsite')) ? true : false;
$ehClienteExterno = ($this->session->userdata('nomeEmpresaVinculo')) ? true : false;

#echo "<pre>";
#var_dump($integracao);
#var_dump($ehClienteExterno);
#print_r($this->session->userdata);
#echo "</pre>";
//die();
?>


<?php
/*
	@modify: André Baill
	@date: 16/10/2020
	@description: alteração dos campos e textos para inclusão de cartão de crédito
	
	@date: 02/12/2020
	@description: modificação do action do login - verificarLoginAjax para verificarLoginAjaxBox
*/
?>

<meta charset="utf-8">
<?php if ($integracao) { ?>
	<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
<?php } ?>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/chamadas/js/chamadaexterna.js?4"></script>

<?php if (!$integracao) { ?>
<script type="text/javascript">
$(document).ready(function(){
	showItinerarios(<?php echo $idAcessoExterno; ?>);
	$('#idClienteFreteItinerario').on('change', '', function(){ 
		selecionouItinerario(true);
	});
	<?php if ($propaganda) { ?>
        $('.propaganda').jGalley({'criarNavegacao': false});
	<?php } ?>
});
</script>
<?php if ($propaganda) { ?>
        <script type="text/javascript" src="<?php echo base_url("assets/jGalley/jGalley-1.0.9.js"); ?>"></script>
<?php } } ?>


<?php if ($integracao) { ?>

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/chamadas/js/chamadaexterna_<?php echo $this->session->userdata('idEmpresaWebsite') ?>.js"></script>

<link href='https://fonts.googleapis.com/css?family=Merriweather+Sans|Raleway' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Signika:400,300,600,700" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/chamadas/css/chamadaexterna_integracao.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/chamadas/css/chamadaexterna_integracao_<?php echo $this->session->userdata('idEmpresaWebsite') ?>.css" />

<?php } else { ?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/chamadas/css/chamadaexterna.css" />
<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css" />
<?php } ?>

<style>
	.icon-address-enabled{background: url("<?php echo base_url();?>/img/chamada/map-marker-azul.png") no-repeat !important;}
	.icon-address-disabled{background: url("<?php echo base_url();?>/img/chamada/map-marker-cinza.png") no-repeat !important;}
	.icon-change-order{background: url("<?php echo base_url();?>/img/chamada/change-order.png") no-repeat !important; margin-left: 10px;}
	.div-box-component input[type="checkbox"] + label  {background:url("<?php echo base_url();?>/img/chamada/check_radio_sheet.png") left top no-repeat;}
	.div-box-component input[type="checkbox"]:checked + label{background:url("<?php echo base_url();?>/img/chamada/check_radio_sheet.png") -19px top no-repeat;}
	.btn-minimize { background-image:url(<?php echo base_url(); ?>img/chamada/minimize.png);}
	.btn-maximize { background-image:url(<?php echo base_url(); ?>img/chamada/maximize.png);}
	.div-chamada-title .sub-title{font-size: 17px;color: #888888;font-weight: 600;margin-top: 5px;}
	.div-cliente-fornecedor{margin: 0 0 25px 32px;}
	.div-cliente-fornecedor #idCliente{width: 368px}
	.select-funcionario {margin: 0;}
	.container-fluid{padding-left: 0 !important;padding-right: 0 !important;}
	.propaganda{float: right;margin-top: 10px;width: 33%;height: 320px;}
	.div-idClienteFreteItinerario{margin: 0 0 5px 32px;}
<?php if (!$integracao) { ?>
	.div-chamada-overflow{max-height: none !important;}
<?php } ?>
</style>

<?php if (!$integracao) { ?>
<div class="row-fluid" style="margin-top:-30px">
    <div class="span12">
            <div class="widget-content">
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Abertura de Chamados
            	</legend>           

                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                        <?php
                            if ($propaganda) {
                                echo '<div class="propaganda">';
                                foreach ($propaganda as $p) {
                                    echo '<img src="'.base_url($p->url).'">';
                                }
                             }
                             echo '</div>';
                        ?>

<?php } ?>

<div class="div-chamada-page">


<input type="hidden" id="url-address-default" value="<?php echo base_url(); ?>">
<input type="hidden" id="clientKey" value="<?php echo $clientKey; ?>">

	<div id="div-carregando-inicial" style="text-align:center;width:100%;background-color:#fff;padding:5px;border-radius:4px;color:#3ea4aa;">
    	<img src="<?php echo base_url();?>img/spinner.gif" class="img-carregando"> Carregando chamados...
    </div>

	<div class="div-chamada-box" style="display:none;">
	<div class="div-chamada-title">
	<?php 

		if (!null ==  $idAcessoExterno || $this->session->userdata('logadoExterno')) {
			echo "<div>Bem vindo(a) " . $nomeUsuario . "</div>";
			echo '<div class="sub-title">'.$nomeEmpresa.'</div>';
		}

		else echo "Realize uma chamada e pague com Cartão de Crédito"
	?>
   
    <input type="hidden" name="boxChamadoMinimizado" id="boxChamadoMinimizado" 
    		value="<?php echo $this->session->userdata('boxChamadoMinimizado'); ?>" />
	</div>
	
		<div class="div-chamada-overflow">
		<form id="form-chamado" action="chamadaexterna/registrachamada">

			<?php 
				if($ehClienteExterno==true)
				{
					echo "<input type='hidden' name='ehClienteExterno' id='ehClienteExterno' value='1'>";
				}
			?>

			<?php if (!$integracao && !$ehClienteExterno) { ?>
			<div class="div-cliente-fornecedor">
				<div class="div-box-component">
					<label for="idCliente">Selecione o Cliente</label>
					<select name="idCliente" id='idCliente' class="input-xlarge">
						<?php 
						foreach ($this->data['clientes'] as $cliente) {
							echo '<option value="'. $cliente->idCliente.'">'. $cliente->nome .'</option>';
						}
						?>
					</select>
				</div>

                <div class="div-box-component">
                    <a href="<?php echo base_url('clientes/adicionarviaexterno/chamadaexterna') ?>" id="add-novo-cliente" type="button" class="btn btn-default">Novo</a>
                </div>
				
				<div class="div-box-component select-funcionario" >
					<label for="idFuncionario">Selecione o Funcionário</label>
					<select name="idFuncionario" id='idFuncionario' class="input-xlarge">
						<?php 
						foreach ($this->data['funcionarios'] as $funcionario) {
							echo '<option value="'. $funcionario->idFuncionario.'">'. $funcionario->nome .'</option>';
						}
						?>
					</select>
				</div>
			</div>
			<?php } ?>

			<?php if (!$integracao) { ?>
			<div class="div-idClienteFreteItinerario" style="margin-bottom: 10px;display: none;">
	        	<label for="idClienteFreteItinerario" style="text-align: left;">Itinerários</label>
	            <select id="idClienteFreteItinerario" name="idClienteFreteItinerario" class="input-xlarge">
	            </select>
            </div>
            <?php } ?>
                        		
			<!-- addresses bloc -->
			<div id="div-box-addresses">

				

				<!-- first address bloc -->

				<div class="div-box-line">

					

					<div class="div-box-component">

						<i class="icon-address icon-address-disabled"></i>

					</div>

					<div class="div-box-component">

						<div class="div-address-city">

							<select name="city[]" id='city' class="input-long inpCity" autofocus="autofocus">

								<?php 

								foreach ($this->data['cidades'] as $cidade) {

									$selected = ($cidade->cidade == 'Curitiba') ? 'selected class="optionDefault"' : '';

									echo '<option value="'. $cidade->idCidade .'" '.$selected.'>'. $cidade->cidade .'</option>';

								}

								?>

							</select>

						</div>

					</div>

					<div class="div-box-component">
						<div class="div-address-street"><input type="text" name="address[]" id="address" placeholder="Rua/Avenida" class="input-long inpAddress" maxlength="200" minlength="3"></div>
					</div>

					<div class="div-box-component">
						<div class="div-address-number"><input type="text" name="number[]" id="number" placeholder="Nº" class="input-short inpNumber" maxlength="6" minlength="1"></div>
					</div>

					<div class="div-box-component">
						<div class="div-address-neighbor">
							<select name="neightbor[]" id="neightbor" class="input-long inpNeightbor">
								<option>Bairro</option>
							</select>
						</div>
					</div>

					<div class="div-box-component">
						<div class="div-address-talkto">
							<input type="text" name="talkto[]" id="talkto" class="inpTalkto" style="width:70px" placeholder="Falar com">
						</div>
					</div>

					<div class="div-box-component div-box-component-last">
						<div class="div-address-remove">X</div>
					</div>

					<!-- change order bloc -->
					<div class="div-box-change-address">
						<div class="div-box-component component-address-change">
							<i class="icon-change-order"></i>
							<span>Alternar endereços</span>
						</div>
					</div>
				</div>		

			</div> <!-- div-box-addresses -->

			<div class="div-box-options"> 
                <div id="div-address-vehicle">
                    <select name="vehicle" id='vehicle' class="input-long" autofocus="autofocus">
                        <option value="1">Base - Moto</option>
                        <option value="2">Médio - Carro</option>
                        <option value="3">Intermediário - Van</option>
                        <option value="4">Grande Porte - Caminhão</option>
                    </select>
                </div> 

                <?php
                    $obsWitdh = ($this->session->userdata('idAcessoExterno')) ? '519px' : '421px';
                 ?>
                
                <div class="div-box-component">
            	    <input type="text" id="observation" name="observation" class="input-long" placeholder="Observação">
            	</div>
			</div>           

            <div class="div-box-options">
				<div class="div-box-component component-add-address">
					<div class="div-address-add">Adicionar mais um destino</div>
					<div class="div-address-return-source">
						<input type="checkbox" name="retornar-origem" id="retornar-origem">
						<label for="retornar-origem"></label>
						<label for="retornar-origem">Retornar à origem ao final</label>	
					</div>
				</div>          
            </div>
		</form>

		</div> <!-- div-chamada-overflow -->

		
		<div class="div-chamada-footer">
			<div class="component-footer-center">
				<div class="div-box-component">
					<div class="div-valor">
						<div class="span-title">Valor: </div>
						<div class="span-result">R$ 0,00</div>
                        <div class="span-update-value" onclick="verificaPreenchimentoCalculaValorMostraErros()">
                        <img src="<?php echo base_url();?>img/chamada/change-order.png" width="12px" />
                        </div>
					</div>
				</div>
			</div>			

			<!-- Div de acesso para efetuar pagamento ou efetuar login (link) -->
			<div class="div-box-component" id="component-btn-realizar-cadastro">
				<div class="div-login-cadastro div-btn-chamado-apos-pre-cadastro">Abrir Chamado</div>
				<?php if ($this->session->userdata('logadoExterno') || !null==$idAcessoExterno ) { ?>				

					<div class="div-login-cadastro btn btn-primary" id="div-btn-registrar-chamada">
	                    <div class="div-box-component">
	                    	<?php if($ehClienteExterno==true){ ?>
								Registrar Chamada
							<?php } else { ?>
								Efetuar Pagamento
							<?php } ?>
                        </div>
					</div>
					

                    <div class="component-footer-center">
						<div class="div-box-component">
							<div id="div-btn-logoff"><span>sair do sistema</span></div>
						</div>
					</div>                    

				<?php } else { ?>		

                    <div class="component-footer-center">
                        <div class="div-login-cadastro" id="div-btn-realizar-cadastro">
                            Cadastre-se para efetuar o pagamento
                        </div>
					</div>

					<div class="component-footer-center">
						<div class="div-box-component">
							<div id="div-btn-login">ou <span>faça o login</span>
								<div style="color: #FF8011;">
								<?php 
									if ($integracao && $this->session->userdata('logadoExterno')) 
									echo "Usuário atual não possui cliente vinculado!"; 
								?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>	

				<div id="result-abertura-chamado"></div>
			</div>
		</div>
	</div>
</div>


<div id="div-pre-cadastro-confirm" title="Novo cadastro" style="display:none">

<p>

	Confirma a realização do Cadastro?

	<div id="result-pre-cadastro"></div>

    

    <hr />

    <div class="dialog-buttons-component">

        <div class="dialog-button" id="pre-cad-button-confirma">Enviar</div>

        <div class="dialog-button button-cancel">Cancelar</div>

    </div>

</p>

</div>



<div id="div-chamado-confirm" title="Registrar chamado" style="display:none">

    <p>

        Confirma o registro do chamado?

    </p>



    <hr />

    <div class="dialog-buttons-component">

        <div class="dialog-button" id="chamado-button-confirma">Confirma</div>

        <div class="dialog-button button-cancel">Cancelar</div>

    </div>

</div>


<div id="div-login" title="Realizar Login" style="display:none">
	<p>Informe usuário e senha para acessar o sistema</p>
	<p>
	<form id="formLogin" method="post" action="entrega/verificarLoginExterno">
		<input name="idEmpresa" type="hidden" value="<?php if ($this->session->userdata('idEmpresaWebsite')) echo $this->session->userdata('idEmpresaWebsite'); ?>" required="required" />
		<div>
			<label for="email">Nome de Usuário</label>
			<input type="text" name="login" id="login" placeholder="Usuário" required="required">
		</div>

		<div>
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" placeholder="Senha" required="required">
		</div>
		<div id="resposta-login"></div>
	</form>
	</p>    

    <hr />
    <div class="dialog-buttons-component-login">
        <div class="dialog-button" id="div-login-enviar">Efetuar Login</div>
        <div class="dialog-button button-cancel">Cancelar</div>
    </div>
</div>


<div id="div-pre-cadastro-dialog" title="Novo cadastro" style="display:none;">
<p>
	<div class="div-pre-cadastro">
		<div id="sucesso-pre-cadastro">
			Seu cadastro foi realizado com sucesso! <br> <b><font color='red'>Faça login para efetuar chamada.</font></b>
			<p>
				Deseja registrar o chamado? <br>
				<span>Após a confirmação do registro do chamado, você será direcionado a tela de pagamento e após o pagamento seu chamado será atendido por nossa equipe imediatamente.</span>			
			</p>
			</div>		
		
		<div class="div-pre-cadastro-title">Efetue seu cadastro para abrir uma chamada</div>
		<div class="div-pre-cadastro-form">
			<form id="form-pre-cadastro" action="chamadaexterna/form_pre_cadastro">
				<div>
					<label for="razaoSocial">Nome ou Razão Social</label>
					<input type="text" name="razaoSocial" id="razaoSocial" placeholder="Nome Completo ou Razão Social" required="required" maxlength="200" minlength="5">
				</div>				

				<div>
				<label for="cnpj">CPF ou CNPJ</label>
					<input type="text" style="display:none" id="cpf" class="mascara_cpf" placeholder="CPF ou CNPJ" required="required" maxlength="14" minlength="12">
	                <input type="text" name="cnpj" id="cnpj" class="mascara_cnpj" placeholder="CPF ou CNPJ" required="required" maxlength="19" minlength="17">
				</div>				

				<div>
					<label for="telefone">Telefone</label>
					<input type="text" name="telefone" id="telefone" class="mascara_telefone" placeholder="(41) 99999-9999" required="required" maxlength="15" minlength="14">
				</div>		

				<div>
					<label for="email">E-mail</label>
					<input type="email" name="email" id="email" class="mascara_email"  placeholder="E-mail: este será seu usuário" required="required" maxlength="50" minlength="5">
				</div>	

				<div>
					<label for="senha">Senha</label>
					<input type="password" name="senha" id="senha" placeholder="Senha" required="required" maxlength="30" minlength="6">
				</div>			

			</form>
		</div>

			

		<div class="div-pre-cadastro-footer">
			<p>Ao efetuar seu cadastro, e realizar sua chamada, você será direcionado ao pagamento. Você poderá efetuar seu pagamento através do cartão de crédito.</p>
			<p>Em caso de dúvidas, entre em contato conosco: <br><strong>(41) 3367-6167 - www.jcentregasrapidas.com.br</strong></p>
		</div>	

		<div id="resultado-pre-cadastro"></div>        

        <hr />
        <div class="dialog-buttons-component">
        	<div class="dialog-button btn-primary" id="pre-cad-button-ok">Enviar</div>
        	<div class="dialog-button button-cancel">Cancelar</div>
        </div>

	</div>

</p>

<?php if (!$integracao) { ?>

						</div>

    				</div>

            	</div>

            	</fieldset>

            </div>

		</div>

	</div>

<?php } ?>

</div>
<?php if (!$integracao) { ?>
<div id="div-itinerario-servicos" role="<?php echo base_url('chamadas/get_itinerarios_cliente_ajax'); ?>" style="display: none;">
<?php } ?>