<!--
* @autor: Davi Siepmann
* @date: 22/10/2015
* @based on: views/emprestimo/financiamento_view.php
*/
-->
<?php
	$fornecedor = array_shift($this->data['dados_fornecedor']);
?>
<meta charset="utf-8">
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/emprestimo/js/emprestimo_externo.js?o3"></script>


<style type="text/css">
	.table-financiamento{max-width: 690px;}
	.table-financiamento tr:hover{background-color: transparent;}
	.widget-box{border: none;}
	.widget-title{background-color: #fff;border: none;}
	.widget-content{border: none;}
	/*.table-financiamento td{border: 1px solid;}*/
	.table-financiamento td{border: none;}	.form-inline label {width: initial !important;}

	.tab-content{overflow: visible;}
</style>
<div class="row-fluid" style="margin-top:-30px">
    <div class="span12">
            <div class="widget-content">
            
		    	<form id="form_param" class="form-inline" method="post" action="<?php echo base_url('financiamento/gravarEmprestimoExterno'); ?>">
            
            	<input type="hidden" id="idParametro" name="idParametro">
            	
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Consulta /Lançamento de Empréstimo
            	</legend>
            
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                        
                        <div class="widget-box">
                             <div class="widget-title">
                                <h5>Informe os dados para realizar a consulta</h5>
                             </div>
							
                            <div class="widget-content nopadding">
	                            <table class="table table-bordered table-financiamento">
                                    <tbody>
                                        <tr style="backgroud-color: #2D335B">
                                            <td colspan="4">
                                            	<label for="dataSolicitacao">Data da Solicitação</label><br />
                                            	<input class="input-small mascara_data datepicker" type="text" maxlength="10" 
	                            					name="dataSolicitacao" id="dataSolicitacao" required="required" readonly="readonly"
	                            					value="<?php echo date('d/m/Y'); ?>">
                                            </td>
                                        </tr>
                                        <tr style="backgroud-color: #2D335B">
                                            <td colspan="3" style="width: auto;">
                                            	<label for="idFuncionario">Informe o código</label><br />
                                            	<input type="text" class="input-small" name="idFuncionario" id="idFuncionario" required>
                                            	<input type="text" class="input-xlarge" name="nomeFuncionario" id="nomeFuncionario" disabled="disabled">
                                            </td>
                                            <td colspan="1" style="width: auto;">
                                            	<label for="idCedente">Local de trabalho</label><br />                                            	<select class="input-xlarge" name="idCedente" id="idCedente" required="required" >
                                            		<option></option>
                                            	</select>
                                            </td>
                                        </tr>
                                    	<tr>
	                            			<td style="width: auto;">
	                            				<label for="valor">Valor Solicitado</label><br />
	                            				<input class="input-small mascara_reais" type="text" maxlength="14"
	                            					name="valor" id="valor" required>
	                            			</td>
	                            			<td style="width: auto;">
	                            				<label for="parcelas" style="" id="lb_parcelas">Parcelas</label>
	                            				<br />
	                            				<input class="input-small mascara_numero_sem_decimal" type="text" maxlength="3"
	                            					name="parcelas" id="parcelas" required>
	                            			</td>
	                            			<td colspan="2"></td>
	                            		</tr>
	                            	</tbody>
	                            </table>
							</div>
						</div>
						<div class="widget-box">
                             <div class="widget-title">
                                <h5>Ações</h5>
                             </div>
							<button type="button" class="btn btn-primary btn-simular" style="margin-left:10px;">
                            		Verificar disponibilidade</button>
                            
							<button type="submit" class="btn btn-primary btn-gravar" style="margin-left:10px;">
                            		<i class="icon-ok icon-white"></i> Registrar</button>
                            		
                            <div id="dialog-solicita-senha-funcionario" title="Informe a senha" style="display:none">
		                          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		                          	<div id="div-senha">
		                          		Solicite digitação da senha:
		                          		<br />
		                          		<input type="password" id="senha" name="senha" required="required">
		                          	</div>
		                          	<div id="div-senha-result"></div>
		                          </p>
		                    </div>
                            
                            <a href="<?php echo base_url()?>emprestimo_externo/" class="btn" style="margin-left:10px;">
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