<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/notify.min.js"></script>

<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">

<!-- new layout and improvements -->
<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css" />

<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/chosen.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/geral.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/formularios.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/global_functions.js"/></script>

<title>Funções e Parâmetros</title>

<?php if ($funcao) $Funcao = array_shift($funcao); ?>
<?php if ($permissoes) $Permissao = array_shift($permissoes); ?>


<script type="text/javascript">
$(document).ready(function() {
	
	$('.form-parametros input, .form-parametros select').change(function() {
		$(this).parent().attr('changed', '1');
	});

	$('#btn-gravar-parametros').click(function() {
		$(this).attr('disabled', true);
		
		submitFormulariosAjax(0);
		
	});

});
function submitFormulariosAjax(formIndex) {

	if ($('.form-parametros:eq('+formIndex+')').length) {
		$('.form-parametros:eq('+formIndex+')').after(function() {
			if ( $(this).attr('changed') ) {
				
				$('#resposta-forms').html(htmlGifCarregando() + ' Aguarde, gravando parâmetros!');
				
				submitFormAjax($(this), formIndex);
			}
			//garante que irá chamar próximo form mesmo que o atual não estiver sido alterado
			else {
				submitFormulariosAjax(formIndex += 1);
			}
		});
	}
	//volta status do botão apra ativo
	else {
		$('#btn-gravar-parametros').attr('disabled', false);
		$('#resposta-forms').html('Parâmetros armazenados!');
	}
}
function submitFormAjax(form, formIndex) {

	$.ajax({
        url:  $(form).attr('action'),
        data: $(form).serialize(),
        type: "POST",
        dataType: "json",
        beforeSend: function( xhr ) {
        	$(form).parent().removeClass('success, error');
        	$(form).parent().find('.error-message').remove();
        },
        success: function(data) {
        	if (data.success) {
        		$(form).parent().addClass('success');

        		if (data.idPerfilFuncaoParametro) {
        			$(form).find('#idPerfilFuncaoParametro').val(data.idPerfilFuncaoParametro);
        		}
        	}
        	else {
        		$(form).parent().addClass('error');
        		$(form).parent().append('<div class="error-message">' + data.mensagem + "</div>");
        	}
        },
        error: function (request, error) {
        	$('#resposta-forms').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
        },
        complete: function(){
        	//garante que irá chamar próximo form mesmo que o atual não estiver sido alterado
        	submitFormulariosAjax(formIndex += 1);
		}
    });	
}
</script>


<style type="text/css">
body{background-color: #fff;padding: 0 5px;}
.sub-title{font-size: 16px;color: #494949;text-indent: 28px;}
.line{height: auto !important;}

input[type="checkbox"]{display: none; }
input[type="checkbox"] + label  {background:url("<?php echo base_url();?>/img/chamada/check_radio_sheet.png") left top no-repeat;}
input[type="checkbox"]:checked + label{background:url("<?php echo base_url();?>/img/chamada/check_radio_sheet.png") -19px top no-repeat;}
input[type="checkbox"] + label {display: inline-block;width: 19px;height: 19px;margin: -1px 4px 0 0;vertical-align: middle;cursor: pointer;}
.inline{display: inline-block; }
.blockPermission{width: 100px; display: inline-block;} 

.detail-permissao{font-size: 14px; color: $595959;margin: 0 0 10px 0;}
.btn{padding: 5px 10px;}
.error{background-color: #DE3C02;}
.success{background-color: #D8FFD1;}
</style>
</head>
<body>

<?php if($this->session->flashdata('error') != null){?>
	<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $this->session->flashdata('error');?>
	</div>
<?php }?>

<?php if($this->session->flashdata('success') != null){?>
	<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $this->session->flashdata('success');?>
	</div>
<?php }?>
                      
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Manutenção de Parâmetros da Função</h5>
            </div>
            
            <div class="widget-content">
            
	            <fieldset>
	            	<legend>
		            	<i class="icon-tags"></i> Perfil: <?php echo $Funcao->nomePerfil; ?>
		            	<div class="sub-title">
		            		Função: <b> <?php echo $Funcao->nomeModulo .' :: '. $Funcao->nomeFuncao ?> </b>
		            	</div>
	            	</legend>
	            	
	            	
	    			<div class="line">
									
						<form id="form-permissoes" action="<?php echo base_url($this->permission->getIdPerfilAtual().'/sis_perfil/gravar_perfil_funcao_permissoes'); ?>" method="post">
							<input class="input-large" type="hidden" id="idPerfilFuncao" name="idPerfilFuncao" value="<?php echo $Funcao->idPerfilFuncao; ?>">
							<input class="input-large" type="hidden" id="idUsuario" name="idUsuario">
								
							<fieldset>
				            	<legend>
					            	<i class="icon-indent-right"></i> Permissões
				            	</legend>
				            	
				            	<div class="line">
				            		<div class="detail-permissao">Usuários deste perfil possuem permissão para:</div>
				            		
				            		<div class="blockPermission">
           								<input type="checkbox" name="canSelect" id="canSelect" <?php if ($Permissao->canSelect) echo 'checked="checked"'; ?>>
										<label for="canSelect"></label>
										<label for="canSelect" class="inline">Visualizar</label>
				            		</div>
				            		
				            		<div class="blockPermission">
           								<input type="checkbox" name="canInsert" id="canInsert" <?php if ($Permissao->canInsert) echo 'checked="checked"'; ?>>
										<label for="canInsert"></label>
										<label for="canInsert" class="inline">Inserir</label>
				            		</div>
				            		
				            		<div class="blockPermission">
           								<input type="checkbox" name="canUpdate" id="canUpdate" <?php if ($Permissao->canUpdate) echo 'checked="checked"'; ?>>
										<label for="canUpdate"></label>
										<label for="canUpdate" class="inline">Atualizar</label>
				            		</div>
				            		
				            		<div class="blockPermission">
           								<input type="checkbox" name="canDelete" id="canDelete" <?php if ($Permissao->canDelete) echo 'checked="checked"'; ?>>
										<label for="canDelete"></label>
										<label for="canDelete" class="inline">Remover</label>
				            		</div>
				            	</div>
				            	
								<br>
							 	<button class="btn btn-default">Gravar Permissões</button>
				        	</fieldset>
						</form>
				    </div>
	            	
					<br><br>
	            	
	    			<div class="line">
							
							<fieldset>
				            	<legend>
					            	<i class="icon-list"></i> Parâmetros
				            	</legend>
				    			
					    		<div class="table-responsive">
								    <table class="table table-bordered" id="table-parametros"><thead><tr>
								    	<th>Parâmetro</th>
								    	<th>Tipo</th>
								    	<th>Padrão Sistema</th>
								    	<th>Editável</th>
								    	<th>Valor</th>
								    </tr></thead>
								    <tbody>
								    
								    <?php 
								    if ($parametros) {
										foreach ($parametros as $p) {
											
											$parametro = new ParametroClass();
											
											$tipo = $parametro->getDescricaoTipo($p->tipo);
											$acesso = $parametro->getDescricaoAcesso($p->acesso);
											$inputValor = $parametro->getInputInformarValor($p->tipo, $p->valorPerfil, unserialize($p->valor));
											$padrao = $parametro->getDescricaoValPadraoSistema($p->tipo, unserialize($p->valor), $p->padrao);
											
											echo "<tr>";
											//echo "<td style='display:none'><input type='hidden' name='idPerfilFuncaoParametro[]' value='". $p->idPerfilFuncaoParametro ."'></td>";
											echo "<td>". $p->nome ."</td>";
											echo "<td>". $tipo ."</td>";
											echo "<td>". $padrao ."</td>";
											echo "<td>". $acesso ."</td>";
											echo "<td>";
												echo '<form class="form-parametros" action="'. base_url('sis_perfil/gravar_perfil_funcao_parametros_ajax') .'" method="post">';
												echo '<input type="hidden" id="idPerfilFuncaoParametro" name="idPerfilFuncaoParametro" value="'. $p->idPerfilFuncaoParametro .'">';
												echo '<input type="hidden" name="idPerfilFuncao" value="'. $Funcao->idPerfilFuncao .'">';
												echo '<input type="hidden" name="idFuncaoParam" value="'. $p->idFuncaoParam .'">';
												echo $inputValor;
												echo '</form>';
											echo "</td>";
											echo "</tr>";
										}
								    }
								    ?>
									
									</tbody></table>
								</div>
								<button type="button" class="btn btn-default" id="btn-gravar-parametros">Gravar Parâmetros</button>
								<div style="display: inline-block;color: #248398;font-size: 14px;" id="resposta-forms"></div>
				    		</fieldset>
							 
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
</body>
</html>