<?php
?>
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/chosen.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/global_functions.js"/></script>


<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/logs/js/logs.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/controllers/logs/css/logs.css" />

<div class="row-fluid" style="margin-top:-30px">
<input type="hidden" id="url-address-default" value="<?php echo base_url(); ?>">
    <div class="span12">
		<div class="widget-content">
			<fieldset>
	        	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Logs de Acesso ao sistema
            	</legend>
            
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
	                        <div class="widget-box">
	                            <div class="widget-title">
	                                <h5>&raquo; Consulta de alterações no sistema</h5>
	                            </div>
	                            
                             	<div class="div-filtro-logs">
                             	
                             	<form id="form-filtros">
                             		<input type="hidden" id="pagina" name="pagina" value="0">
                             	
                             		<div class="div-filtro-box">
	                             		<span>Selecione o módulo /função</span>
	                             		<br>
			                        	<select name="tabela" id="tabela" class="input-xlarge">
			                        		<option value=""></option>
										<?php 
											foreach ($this->data['tabelascomlog'] as $tabela) {
												echo '<option value="'. $tabela->tabela .'">'. $tabela->descricao .'</option>';
											}
										?>
										</select>
									</div>
									
									<div class="div-filtro-box">
	                             		<span>Data Inicial</span>
	                             		<br>
			                        	<input type="text" name="dataInicial" id="dataInicial" class="input-small mascara_data datepicker">
			                        </div>
			                        
									<div class="div-filtro-box">
	                             		<span>Data Final</span>
	                             		<br>
			                        	<input type="text" name="dataFinal" id="dataFinal" class="input-small mascara_data datepicker">
			                        </div>
			                        
                             		<div class="div-filtro-box">
	                             		<span>Filtrar por operação</span>
	                             		<br>
			                        	<select name="operacao" id="operacao" class="input-medium">
			                        		<option value=""></option>
			                        		<option value="insert">Inserir</option>
			                        		<option value="update">Atualizar</option>
			                        		<option value="delete">Remover</option>
										</select>
									</div>
									
                             		<div class="div-filtro-box">
	                             		<span>Selecione um usuário</span>
	                             		<br>
			                        	<select name="usuario" id="usuario" class="input-xlarge">
			                        		<option value=""></option>
			                        		<?php 
											foreach ($this->data['usuarioscomlog'] as $usuario) {
												echo '<option value="'. $usuario->id .'">'. $usuario->nome .'</option>';
											}
											?>
										</select>
									</div>
								</div>
								</form>
								
								<div class="div-buttons">
									<button type="button" class="btn btn-primary" id="btn-aplicar-filtro" style="margin-left:10px;">
									Aplicar Filtros</button>
                            	</div>
                            		
								<div class="div-resultado-filtro">
									
									<div id="div-result-ajax">
									<span>Resultado da pesquisa</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>
<div id="dialog-show-details" title="Detalhes do registro" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>                          
	Detalhes do registro:
	<div id="div-show-detail-record"><</div>
</div>