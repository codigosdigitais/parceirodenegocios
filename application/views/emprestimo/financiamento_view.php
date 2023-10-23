<!--
* @autor: Davi Siepmann
* @date: 25/09/2015
* @based on: views/cedentes/cedentes.php
*/
-->
<?php 
	$isset = false;
	if (isset($this->data['result'])) {
		$result = array_shift($this->data['result']);
		$isset = true;
	}
	
	$naoPermiteAlteracao = false;
	if ($isset && ($result->situacao == 'aprovado' || $result->situacao == 'liquidado')) $naoPermiteAlteracao = true;
?>
<meta charset="utf-8"><script type="text/javascript" src="<?php echo base_url()?>assets/controllers/emprestimo/js/param_financiamento.js?o3"></script>
<style type="text/css">
	.table-financiamento{max-width: 880px;}
	.table-financiamento tr:hover{background-color: transparent;}
	.widget-box{border: none;}
	.widget-title{background-color: #fff;border: none;}
	.widget-content{border: none;}
	/*.table-financiamento td{border: 1px solid;}*/
	.table-financiamento td{border: none;}
	.form-inline label {width: initial !important;}
	.tab-content{overflow: visible;}
</style>
<div class="row-fluid" style="margin-top:-30px">
    <div class="span12">
            <div class="widget-content">
            
		    	<form id="form_param" class="form-inline" method="post" action="<?php echo base_url('financiamento/gravarFinanciamento'); ?>">
            
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		<?php echo ($this->data['tipoEmprestimo'] == 'emprestimo') ? 'Empréstimo' : 'Financiamento'; ?>
            	</legend>
            
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                        
		                <input type="hidden" id="idParametro" name="idParametro">
		                <input type="hidden" id="idEmprestimo" name="idEmprestimo"
		                	   value="<?php if ($isset) echo $result->idEmprestimo ?>">
		                <input type="hidden" id="inserirAlterarRemover" name="inserirAlterarRemover" 
		                	   value="<?php echo ($isset) ? 'alterar' : 'inserir' ?>">
		    			<input type="hidden" id="tipoEmprestimo" name="tipoEmprestimo" 
		    				   value="<?php echo $this->data['tipoEmprestimo'] ?>">
                        <div class="widget-box">
                             <div class="widget-title">
                                <h5>&raquo; Simulação ou registro de 
                                <?php echo ($this->data['tipoEmprestimo'] == 'emprestimo') ? 'Empréstimo' : 'Financiamento'; ?>
                                 </h5>
                             </div>
							
                            <div class="widget-content nopadding">
	                            <table class="table table-bordered table-financiamento">
                                    <tbody>
                                        <tr style="backgroud-color: #2D335B">
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="situacao">Situação</label><br />
                                            	<select class="input-xlarge" name="situacao" id="situacao" required>
                                            		<option value="simulacao" 
                                            		<?php if ($isset && $result->situacao == 'simulacao') echo "selected" ?>
                                            		>Simulação</option>
                                            		<option value="aprovado" 
                                            		<?php if ($isset && $result->situacao == 'aprovado') echo "selected" ?>
                                            		>Aprovado</option>
                                            		<?php if ($isset) { ?>
                                            		<option value="liquidado" 
                                            		<?php if ($isset && $result->situacao == 'liquidado') echo "selected" ?>
                                            		>Liquidado</option>
                                            		<?php } ?>
                                            	</select>
                                            </td>
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="dataSolicitacao">Data da Solicitação</label><br />
                                            	<input class="input-small mascara_data datepicker" type="text" maxlength="10" 
	                            					name="dataSolicitacao" id="dataSolicitacao" required="required" 
	                            					<?php if ($naoPermiteAlteracao){ ?>	readonly="readonly" <?php } ?>
	                            					value="<?php echo ($isset && $result->dataSolicitacao) 
	                            										? conv_data_YMD_para_DMY($result->dataSolicitacao)
	                            										: date('d/m/Y'); ?>">
                                            </td>
                                            <td colspan="2" style="width: 50%;">
                                            <?php if ( $this->data['tipoEmprestimo'] == 'emprestimo' ) { ?>
                                            	<label for="idFornecedor">Selecione o fornecedor</label><br />
                                            	<select class="input-xlarge" name="idFornecedor" id="idFornecedor"
                                            	<?php if ($naoPermiteAlteracao){ ?>	disabled="disabled" <?php } ?>>
                                            		<option></option>
                                            		<?
                                            		if ($this->data['tipoEmprestimo'] == 'emprestimo') {
                                            			foreach ($this->data['fornecedores'] as $fornecedor) {
                                            				
                                            				if(!$isset || $result->localLancamento == 'interno' || $result->idFornecedor == $fornecedor->idFornecedor) { ?>
                                            					<option value="<?=$fornecedor->idFornecedor;?>"
						                                    	<?php
						                                    	if ($isset && $result->idFornecedor == $fornecedor->idFornecedor) echo "selected"
						                                    	?>
						                                    	> <?=$fornecedor->nomefantasia;?></option>
                                            				<?php }
                                            			}
                                            		}  	
				                                    ?>
                                            	</select>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                        <tr style="backgroud-color: #2D335B">
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="idFuncionario">Selecione o funcionário</label><br />
                                            	<select class="input-xlarge" name="idFuncionario" id="idFuncionario" required
                                            	<?php if ($naoPermiteAlteracao){ ?>	disabled="disabled" <?php } ?>>
                                            		<option></option>
                                            		<?
				                                        foreach($this->data['lista_funcionarios'] as $lista){
				                                        	//mostra apenas o funcionário do registro quando editando
				                                        	if(!$isset || $result->idFuncionario == $lista->idFuncionario) {
				                                    ?>
				                                    <option value="<?=$lista->idFuncionario;?>"
				                                    <?php
				                                    if ($isset && $result->idFuncionario == $lista->idFuncionario) echo "selected"
				                                    ?>
				                                    > <?=$lista->nome;?></option>
				                                    <? } } ?>
                                            	</select>
                                            </td>
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="idCedente">Parâmetro Cedente</label><br />
                                            	<select class="input-xlarge" name="idCedente" id="idCedente" required 
                                            	<?php if ($naoPermiteAlteracao){ ?>	disabled="disabled" <?php } ?>
                                            		role="<?php if ($isset) echo $result->idCedente ?>">
                                            		<option></option>
                                            		<?
				                                        foreach($this->data['lista_cedentes'] as $lista){
				                                        	//mostra apenas o funcionário do registro quando editando
				                                        	if($isset && $result->idCedente == $lista->idCedente) {
				                                    ?>
				                                    <option value="<?=$lista->idCedente;?>"
				                                    <?php
				                                    if ($isset && $result->idCedente == $lista->idCedente) echo "selected"
				                                    ?>
				                                    > <?=$lista->nomefantasia;?></option>
				                                    <? } } ?>
                                            	</select>
                                            </td>
                                            <td style="width: 10%;">
                                            	<label for="salario">Salário</label><br />
                                            	<input class="input-small mascara_reais" type="text" maxlength="14" 
                                            		title="Salário informado no cadastro do funcionário" readonly="readonly"
	                            					name="salario" id="salario" value="<?php if ($isset) echo $result->salarioAtual ?>" required>
                                            </td>
                                            
                                            <td style="">
	                            				<label for="comprometimento" title="Comprometimento salarial máximo">Comprometimento %</label>
	                            				<input class="input-small mascara_porcentagem_sem_decimal" type="text" maxlength="20" 
	                            					readonly="readonly"
	                            					name="comprometimento" id="comprometimento" value="<?php if ($isset) echo $result->comprometimento ?>">
                                            </td>
                                            
                                        </tr>
                                    	<tr>
	                            			<td style="width: 12.5%;">
	                            				<label for="valor">Valor Financiado</label><br />
	                            				<input class="input-small mascara_reais" type="text" maxlength="14" 
	                            				<?php if ($naoPermiteAlteracao){ ?>	readonly="readonly" <?php } ?>
	                            					name="valor" id="valor" value="<?php if ($isset) echo $result->valor ?>" required>
	                            			</td>
	                            			<td style="width: 12.5%; text-align: right;">
	                            				<label for="parcelas" style="margin-left: 25px;width: 100%;float: left;" id="lb_parcelas">Parcelas</label>
	                            				<input class="input-small mascara_numero_sem_decimal" type="text" maxlength="3"
	                            				<?php if ($naoPermiteAlteracao){ ?>	readonly="readonly" <?php } ?> 
	                            					name="parcelas" id="parcelas" value="<?php if ($isset) echo $result->parcelas ?>" required>
	                            			</td>
	                            			<td style="width: 12.5%;">
                                            	<label for="dataPrimParcela" id="lb_dataPrimParcela">1ª Parcela</label><br />
                                            	<input class="input-small mascara_data datepicker" type="text" maxlength="10" 
	                            					name="dataPrimParcela" id="dataPrimParcela" required="required"
	                            					<?php if ($naoPermiteAlteracao){ ?>	readonly="readonly" <?php } ?>
	                            					value="<?php echo ($isset && $result->dataPrimParcela) 
	                            										? conv_data_YMD_para_DMY($result->dataPrimParcela)
	                            										: date('d/m/Y', strtotime("+1 month")); ?>">
	                            			</td>
	                            			<td style="width: 12.5%; text-align: right;">
	                            				<label for="juros" style="padding-right: 35px;">Tx Juros %</label>
	                            				<input class="input-small mascara_porcentagem_3_decimais" type="text" maxlength="8" 
	                            				<?php if ($naoPermiteAlteracao){ ?>	readonly="readonly" <?php } ?>
	                            					name="juros" id="juros" value="<?php if ($isset) echo $result->juros ?>" required>
	                            			</td>
	                            			<td colspan="2" style="width: 50%;"></td>
	                            		</tr>
                                        <tr style="backgroud-color: #2D335B">
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="juros_periodo">Período pagamento /juros</label><br />
                                            	<select class="input-xlarge" name="juros_periodo" id="juros_periodo" required
                                            	<?php if ($naoPermiteAlteracao){ ?>	disabled="disabled" <?php } ?>>
	                                                <option value="diario"
	                                                <?php if ($isset && $result->juros_periodo == 'diario') echo "selected"; ?>
                                                		>Diário</option>
	                                            	<option value="mensal" 
	                                                <?php if ($isset && $result->juros_periodo == 'mensal') echo "selected"; ?>
	                                                	>Mensal</option>
                                            	</select>
                                            </td>
                                            <td colspan="2" style="width: 25%;">
                                            	<label for="juros_tipo">Aplicação juros</label><br />
                                            	<select class="input-xlarge" name="juros_tipo" id="juros_tipo" required
                                            	<?php if ($naoPermiteAlteracao){ ?>	disabled="disabled" <?php } ?>>
	                                                <option value="simples"
	                                                <?php if ($isset && $result->juros_tipo == 'simples') echo "selected"; ?>
	                                                >Simples</option>
                                            		<option value="compostos" 
                                                	<?php if ($isset && $result->juros_tipo == 'compostos') echo "selected"; ?>
	                                                >Compostos</option>
                                            	</select>
                                            </td>
                                            <td colspan="2" style="width: 50%;"></td>
                                        </tr>
	                            	</tbody>
	                            </table>
							</div>
						</div>
						<div class="widget-box">
                             <div class="widget-title">
                                <h5>Confirmar simulação</h5>
                             </div>
                            <?php if (!$naoPermiteAlteracao){ ?>
							<button type="button" class="btn btn-primary btn-simular" style="margin-left:10px;">
                            		Simular Financiamento</button>
                            <?php } ?>
                            
                            <?php if (!$isset && $this->permission->controllerManual('financiamento')->canInsert()
                            		|| $this->permission->controllerManual('financiamento')->canUpdate()) { ?>
							<button type="submit" class="btn btn-primary btn-gravar" style="margin-left:10px;">
                            		<i class="icon-ok icon-white"></i> Gravar</button>
                            <?php } ?>
                            
                            <?php if (!$naoPermiteAlteracao && $isset && $this->permission->controllerManual('financiamento')->canDelete()) { ?>
                            	<button type="button" class="btn btn-primary btn-remover-form" style="margin-left:10px;">                            		<i class="icon-trash"></i> Remover</button>
                            
		                        <div id="dialog-confirma-remover-registro" title="Deseja remover o registro?" style="display:none">
		                          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		                          		Confirma a remoção deste financiamento?
		                          </p>
		                        </div>
                            <?php } ?>
                            
                            <a href="<?php echo base_url()?>financiamento/<?php echo $this->data['tipoEmprestimo'] ?>" class="btn" style="margin-left:10px;">
	                            	<i class="icon-arrow-left"></i> Retornar</a>
	                            	
                            <div class="widget-content">
                            	<div id="exibir-simulacao" style="font-size: 14px"></div>
							</div>
						</div>
					</div>
			</div>
			</div>
		</fieldset>
		</form>
	</div>
</div>
</div>