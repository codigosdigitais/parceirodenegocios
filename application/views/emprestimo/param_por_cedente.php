<!--
* @autor: Davi Siepmann
* @date: 18/09/2015
* @based on: views/financeiro/view/chamada.php
*/
-->
<?php 
	$param_emprestimos = array_shift( $this->data['param_emprestimos'] );
?>

<meta charset="utf-8">

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/emprestimo/js/param_por_cedente.js?o1"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css?o1" />
<style type="text/css">
	label{text-align:center !important;line-height: 24px !important;}
	input{text-align:center !important;}
	.table-funcionarios td{text-align:center;}
	.table-funcionarios input, .table-funcionarios textarea {width:80px !important;}
	
	.tb-insere-param-funcionario {width:100%;max-width:1200px;}
	.tb-insere-param-funcionario tr:hover, .table-emprestimo tr:hover, .table-financiamento tr:hover{background-color:transparent;}
	.tb-insere-param-funcionario th{text-align:left;height:15px;margin:0;padding:0;}
	.tb-insere-param-funcionario td{width:270px;text-align:right;height:45px;}
	.tb-insere-param-funcionario select{width:310px;}
	.tb-insere-param-funcionario label{margin-right:5px !important;}
	.tb_acoes_ee {width:126px;}
</style>

<div class="row-fluid" style="margin-top:-30px">
    <div class="span12">
            <div class="widget-content">
		    	<form id="form_param" class="form-inline" method="post" action="<?php echo base_url('paramemprestimos/gravar_param_emprestimos'); ?>">
            
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Parâmetros
            		<?php 
            			if ($param_emprestimos->idCedente) echo 'Cedente: ' . $param_emprestimos->nomefantasia;
            			else 							   echo 'Globais: ' . $this->session->userdata('nome');
            		?>
            	</legend>
            
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                        
		                <input type="hidden" id="view" name="view" value="">
		                <input type="hidden" name="idParametro" value="<?=$param_emprestimos->idParametro?>">
		                <input type="hidden" name="idCedente" value="<?=$param_emprestimos->idCedente?>">
		    			
                        <div class="widget-box">
                             <div class="widget-title">
                                <h5>&raquo; EMPRÉSTIMO (externo)</h5>
                             </div>

                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-emprestimo">
                                    <thead>
                                        <tr style="backgroud-color: #2D335B">
                                            <th>Valor máximo por funcionário</th>
                                            <th>Comprometimento salarial</th>
                                            <th>Quantidade máx. parcelas</th>
                                            <th>Taxa de juros</th>
                                            <th>Período aplicação de juros</th>
                                            <th>Tipo de aplicação de juros</th>
                                            <th style="width: 30px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                            <td><center><label>R$ <? echo conv_monetario_br($param_emprestimos->emp_max_valor) ?></label>
											<input class="input-small mascara_reais" name="emp_max_valor"
	                                            maxlength="14"
											 		value="<? echo conv_monetario_br($param_emprestimos->emp_max_valor) ?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo conv_porcent_sem_decimal($param_emprestimos->emp_max_comprometimento)?>%</label>
											<input class="input-small mascara_porcentagem_sem_decimal" name="emp_max_comprometimento" 
                                            	maxlength="9"
											 		value="<? echo conv_porcent_sem_decimal($param_emprestimos->emp_max_comprometimento)?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo $param_emprestimos->emp_max_parcelas ?></label>
											<input class="input-small mascara_numero_sem_decimal" name="emp_max_parcelas"	
                                            	maxlength="3"
											 		value="<? echo $param_emprestimos->emp_max_parcelas ?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo conv_porcent_3_decimal($param_emprestimos->emp_tx_juros)?>%</label>
											<input class="input-small mascara_porcentagem_3_decimais" name="emp_tx_juros" 
                                            	maxlength="9"
											 		value="<? echo conv_porcent_3_decimal($param_emprestimos->emp_tx_juros)?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo ucfirst($param_emprestimos->emp_periodo) ?></label>
											<select name="emp_periodo" class="input-small" style="display:none">
                                                <option value="diario"
                                                <?php if ($param_emprestimos->emp_periodo == "diario") echo "selected"; ?>
                                                	>Diário</option>
                                            	<option value="mensal" 
                                                	<?php if ($param_emprestimos->emp_periodo == "mensal") echo "selected"; ?>
                                                	>Mensal</option>
                                            </select>
									  </center></td>
											
                                            <td><center><label><? echo ucfirst($param_emprestimos->emp_tipo) ?></label>
											<select name="emp_tipo" class="input-small" style="min-width:110px;display:none">
                                                <option value="simples"
                                                    <?php if ($param_emprestimos->emp_tipo == "simples") echo "selected"; ?>
                                                	>Simples</option>
                                            	<option value="compostos" 
                                                	<?php if ($param_emprestimos->emp_tipo == "compostos") echo "selected"; ?>
                                                	>Compostos</option>
                                            </select>
									  </center></td>
											
                                            <td>
											<? if($this->permission->controllerManual('paramemprestimos')->canUpdate()){ ?>
												 <button class="btn btn-alterar a-btn-inputs-emprestimo" type="button">
                                       				<i class="icon-list-alt"></i>Alterar</button>
											<? } ?>
											</td>
											
                                        </tr>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      
                        <div class="widget-box">
                             <div class="widget-title">
                                <h5>&raquo; FINANCIAMENTO (interno)</h5>
                             </div>

                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-financiamento">
                                    <thead>
                                        <tr style="backgroud-color: #2D335B">
                                            <th>Valor máximo por funcionário</th>
                                            <th>Comprometimento salarial</th>
                                            <th>Quantidade máx. parcelas</th>
                                            <th>Taxa de juros</th>
                                            <th>Período aplicação de juros</th>
                                            <th>Tipo de aplicação de juros</th>
                                            <th style="width: 30px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                            <td>
                                            	<center>
                                                <label>R$ <? echo conv_monetario_br($param_emprestimos->financ_max_valor) ?></label>
												<input class="input-small mascara_reais" name="financ_max_valor"
	                                                maxlength="14"
											 		value="<? echo conv_monetario_br($param_emprestimos->financ_max_valor) ?>" type="text" 
                                                    style="display:none" required="required">
												</center>
                                            </td>
											
                                            <td><center><label><? echo conv_porcent_sem_decimal($param_emprestimos->financ_max_comprometimento)?>%</label>
											<input class="input-small mascara_porcentagem_sem_decimal" name="financ_max_comprometimento" 
													maxlength="6"
											 		value="<? echo $param_emprestimos->financ_max_comprometimento?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo $param_emprestimos->financ_max_parcelas ?></label>
											<input class="input-small mascara_numero_sem_decimal" name="financ_max_parcelas" 
                                           		maxlength="3"
											 		value="<? echo $param_emprestimos->financ_max_parcelas ?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo conv_porcent_3_decimal($param_emprestimos->financ_tx_juros)?>%</label>
											<input class="input-small mascara_porcentagem_3_decimais" name="financ_tx_juros" 
                                            	maxlength="9"
											 		value="<? echo conv_porcent_3_decimal($param_emprestimos->financ_tx_juros)?>" type="text" style="display:none"
													required="required">
											</center></td>
											
                                            <td><center><label><? echo ucfirst($param_emprestimos->financ_periodo) ?></label>
											<select name="financ_periodo" class="input-small" style="display:none">
                                                <option value="diario"
                                                <?php if ($param_emprestimos->financ_periodo == "diario") echo "selected"; ?>
                                                	>Diário</option>
                                            	<option value="mensal" 
                                                	<?php if ($param_emprestimos->financ_periodo == "mensal") echo "selected"; ?>
                                                	>Mensal</option>
                                            </select>
									  </center></td>
											
                                            <td><center><label><? echo ucfirst($param_emprestimos->financ_tipo) ?></label>
											<select name="financ_tipo" class="input-small" style="min-width:110px;display:none">
                                                <option value="simples"
                                                    <?php if ($param_emprestimos->financ_tipo == "simples") echo "selected"; ?>
                                                	>Simples</option>
                                            	<option value="compostos" 
                                                	<?php if ($param_emprestimos->financ_tipo == "compostos") echo "selected"; ?>
                                                	>Compostos</option>
                                            </select>
									  </center></td>
											
                                            <td>
											<? if($this->permission->controllerManual('paramemprestimos')->canUpdate()){ ?>
												<button class="btn btn-alterar a-btn-inputs-financiamento" type="button">
                                       				<i class="icon-list-alt"></i>Alterar</button>
											<? } ?>
											</td>
                                            </tr>
										
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      
                        </div>
                      
                      
                      
                      	<legend class="form-title"><i class="icon-list-alt icon-title"></i> Parâmetros por Funcionário</legend>
                        
                        <div>
                      	<div class="div-insere-param-usuario">
                            <table class="tb-insere-param-funcionario">
                            <tr>
                                <td colspan="4" style="text-align: left;">
                                <select class="input-xxlarge" name="idFuncionario" id="idFuncionario">
                                    <option value="">Selecione o Funcionário</option>
                                    <?
                                        foreach($this->data['lista_funcionarios'] as $lista){
                                    ?>
                                    <option value="<?=$lista->idFuncionario;?>"> <?=$lista->nome;?></option>
                                    <? } ?>								
                                </select>
                                <script type="application/javascript">
									var ocultar = [<?
                                        foreach($this->data['lista_params'] as $lista) echo $lista->idFuncionario .',';
                                    ?>];
									for (var i = 0; i < ocultar.length; i++) {
										$('#idFuncionario option').filter(function(index) {
                                            return this.value == ocultar[i]
                                        }).hide();
									}
								</script>
                            	</td>
                            </tr>
                            <tr>
                            	<th colspan="4">
                                &raquo; EMPRÉSTIMO (externo)
                                </th>
                            </tr>
                            <tr>
                                <td>
									<!--ref. empréstimos-->
                                	<label for="add_emp_max_valor" class="control-label">Máx. Empréstimo</label>
                                	<input class="input-small mascara_reais"
											name="add_emp_max_valor" id="add_emp_max_valor"
											value="<? echo conv_monetario_br($param_emprestimos->emp_max_valor) ?>" type="text" required="required">
								</td>
                                <td>
									<label for="add_emp_max_comprometimento" class="control-label">Comprometimento</label>
									<input class="input-small mascara_porcentagem_sem_decimal" maxlength="4"
											name="add_emp_max_comprometimento" id="add_emp_max_comprometimento"
											value="<? echo conv_porcent_sem_decimal($param_emprestimos->emp_max_comprometimento)?>" type="text" required="required">
								</td>
                                <td>
									<label for="add_emp_max_parcelas" class="control-label">Máx. Parcelas</label>
									<input class="input-small mascara_numero_sem_decimal" maxlength="3"
											name="add_emp_max_parcelas" id="add_emp_max_parcelas"	
											value="<? echo $param_emprestimos->emp_max_parcelas ?>" type="text" required="required">        
                                </td>
                                <td>
									<label for="add_emp_tx_juros" class="control-label">Tx. Juros</label>
									<input class="input-small mascara_porcentagem_3_decimais" maxlength="7"
											name="add_emp_tx_juros"	id="add_emp_tx_juros"	
											value="<? echo conv_porcent_3_decimal($param_emprestimos->emp_tx_juros)?>" type="text" required="required">
								</td>
                            </tr>
                            <tr>
                            	<th colspan="4">
                                </th>
                            </tr>
                            <tr style="border-top: 1px solid #F5F5F5;">
                            	<th colspan="4">
                                </th>
                            </tr>
                            <tr>
                            	<th colspan="4">
                                &raquo; FINANCIAMENTO (interno)
                                </th>
                            </tr>
                            <tr>
                                <td>
									<!--ref. financiamento-->
									<label for="add_financ_max_valor" class="control-label">Máx. Financiamento</label>
									<input class="input-small mascara_reais"
											name="add_financ_max_valor"	id="add_financ_max_valor"	
											value="<? echo conv_monetario_br($param_emprestimos->financ_max_valor) ?>" type="text" required="required">
								</td>
                                <td>
									<label for="add_financ_max_comprometimento" class="control-label">Comprometimento</label>
									<input class="input-small mascara_porcentagem_sem_decimal" maxlength="4"
											name="add_financ_max_comprometimento"	id="add_financ_max_comprometimento"	
											value="<? echo conv_porcent_sem_decimal($param_emprestimos->financ_max_comprometimento)?>" type="text" required="required">
								</td>
                                <td>
									<label for="add_financ_max_parcelas" class="control-label">Máx. Parcelas</label>
									<input class="input-small mascara_numero_sem_decimal" maxlength="3"
											name="add_financ_max_parcelas"	id="add_financ_max_parcelas"	
											value="<? echo $param_emprestimos->financ_max_parcelas ?>" type="text" required="required">
								</td>
                                <td>
									<label for="add_financ_tx_juros" class="control-label">Tx. Juros</label>
									<input class="input-small mascara_porcentagem_3_decimais" maxlength="7"
											name="add_financ_tx_juros"	id="add_financ_tx_juros"	
											value="<? echo conv_porcent_3_decimal($param_emprestimos->financ_tx_juros)?>" type="text" required="required">
								</td>
                            </tr>
                            </table>
                            <hr />
                        </div>
                        </div>
                        
                        
                      	<?php if($this->permission->controllerManual('paramemprestimos')->canUpdate()){ ?>
                      	<div class="button-form">
                        	<center>
                            	<button class="btn" onclick="adicionarFuncionario()" type="button">
                            	<i class="icon-plus"></i> Adicionar Funcionário</button>
                                
								<button type="submit" class="btn btn-primary" style="margin-left:10px;">
                            		<i class="icon-ok icon-white"></i> Gravar Alterações</button>
                                
	                            <a href="<?php echo base_url()?>paramemprestimos" class="btn" style="margin-left:10px;">
	                            	<i class="icon-arrow-left"></i> Retornar</a>
                            </center>
				    	</div>
                      	<?php } ?>
                        
                        <div id="dialog-confirma-inclusao-funcionario" title="Deseja Adicionar Funcionário?" style="display:none">
                          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                          		Existe um funcionário selecionado para inclusão. Deseja adicioná-lo?
                          </p>
                        </div>
                        
                        <div style="margin-top:30px;">
                            <table class="table table-bordered table-funcionarios">
                                <thead>
                                    <tr style="backgroud-color: #2D335B">
                                        <th rowspan="2" style="vertical-align:middle;">Funcionário</th>
                                        <th colspan="4">Empréstimo</th>
                                        <th colspan="5" style="border-left: 1px solid #bbb;">Financiamento</th>
                                    </tr>
                                    <tr style="backgroud-color: #2D335B">
                                        <th style="max-width:110px;">Máx. Empréstimo</th>
                                        <th style="max-width:110px;">Comprometimento</th>
                                        <th style="max-width:70px;">Parcelas</th>
                                        <th style="max-width:80px;">Tx. Juros</th>
                                        <th style="max-width:130px;border-left: 1px solid #bbb;">Máx. Financiamento</th>
                                        <th style="max-width:110px;">Comprometimento</th>
                                        <th style="max-width:70px;">Parcelas</th>
                                        <th style="max-width:80px;">Tx. Juros</th>
                                        <th style="width: 150px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="param_func_group">
                                 	<?
                                 	if (0 < count($this->data['lista_params'])) 
                                 		foreach($this->data['lista_params'] as $lista){
                                 	?>
                                    
                                    <tr style="backgroud-color: #2D335B">
									<td style="text-align:left !important;"><?=$lista->nome;?>
                                    <input type="hidden" name="tb_idParametro[]" value="<?=$lista->idParametro;?>">
                                    <input type="hidden" name="tb_idFuncionario[]" value="<?=$lista->idFuncionario?>">
                                    <input type="hidden" name="tb_action[]" value="">
                                    </td>
                                    
                                    <td><label><?=conv_monetario_br($lista->emp_max_valor)?></label>
                                    <input name="tb_emp_max_valor[]" type="hidden" value="<?=conv_monetario_br($lista->emp_max_valor)?>" 
                                    	class="hideshow mascara_reais">
                                    </td>
                                    
                                    <td><label><?=conv_porcent_sem_decimal($lista->emp_max_comprometimento)?>%</label>
                                    <input name="tb_emp_max_comprometimento[]" type="hidden" value="<?=conv_porcent_sem_decimal($lista->emp_max_comprometimento)?>%" 
                                    	class="hideshow mascara_porcentagem_sem_decimal">
                                    </td>
                                    
                                    <td><label><?=$lista->emp_max_parcelas?></label>
                                    <input name="tb_emp_max_parcelas[]" type="hidden" value="<?=$lista->emp_max_parcelas?>" 
                                    	class="hideshow mascara_numero_sem_decimal">
                                    </td>
                                    
                                    <td><label><?=conv_porcent_3_decimal($lista->emp_tx_juros)?>%</label>
                                    <input name="tb_emp_tx_juros[]" type="hidden" value="<?=conv_porcent_3_decimal($lista->emp_tx_juros)?>%" 
                                    	class="hideshow mascara_porcentagem_3_decimais">
                                    </td>
                                    
                                    <td style="border-left: 1px solid #bbb;"><label><?=conv_monetario_br($lista->financ_max_valor)?></label>
                                    <input name="tb_financ_max_valor[]" type="hidden" value="<?=conv_monetario_br($lista->financ_max_valor)?>" 
                                    	class="hideshow mascara_reais">
                                    </td>
                                    
                                    <td><label><?=conv_porcent_sem_decimal($lista->financ_max_comprometimento)?>%</label>
                                    <input name="tb_financ_max_comprometimento[]" type="hidden" value="<?=conv_porcent_sem_decimal($lista->financ_max_comprometimento)?>%" 
                                    	class="hideshow mascara_porcentagem_sem_decimal">
                                    </td>
                                    
                                    <td><label><?=$lista->financ_max_parcelas?></label>
                                    <input name="tb_financ_max_parcelas[]" type="hidden" value="<?=$lista->financ_max_parcelas?>" 
                                    	class="hideshow mascara_numero_sem_decimal">
                                    </td>
                                    
                                    <td><label><?=conv_porcent_3_decimal($lista->financ_tx_juros)?>%</label>
                                    <input name="tb_financ_tx_juros[]" type="hidden" value="<?=conv_porcent_3_decimal($lista->financ_tx_juros)?>%" 
                                    	class="hideshow mascara_porcentagem_3_decimais">
                                    </td>
                                    
                                    <td class="tb_acoes_ee">
                                    <button class="btn btn-alterar" type="button" onclick="editarParametro(this)">
                                        <i class="icon-list-alt"></i><label>Alterar</label></button>
                                    <button class="btn btn-remover" type="button" onclick="removeParametro(this)">
                                        <i class="icon-trash"></i></button>
                                    </td>
                                    </tr>
                                    <? } ?>
                                </tbody>
                                </table>
                                <div class="button-form-end"><center></center></div>
                        </div>
                        
                    </div>
                    
                </div>
                      
                      
		    	</fieldset>
                
	    	</form>

        </div>
        
</div>
</div>