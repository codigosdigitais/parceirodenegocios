<!--
* @autor: Davi Siepmann
* @date: 25/09/2015
* @based on: views/cedentes/cedentes.php
*/
-->
<?php 
	if (isset($this->data['dados_fornecedor']))	$fornecedor = array_shift($this->data['dados_fornecedor']);
?>
<meta charset="utf-8"><script type="text/javascript" src="<?php echo base_url()?>assets/controllers/emprestimo/js/param_financiamento_lista.js?o1"></script>

<style type="text/css">
	.tabela-lista-cedentes tr:hover, .tabela-emprestimos-globais tr:hover{background-color: transparent;}
	.emp-externo{background-color: #B3FFD8;}
	.emp-externo:hover{background-color: #A2DDC7;}
</style>

<div class="row-fluid" style="margin-top:-10px">
    <div class="span12">
            <div class="widget-content">
            
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Listagem de 
            		<?php 
            		if ($this->data['tipoEmprestimo'] == 'emprestimo' || $this->data['tipoEmprestimo'] == 'financiamento')
            			echo ($this->data['tipoEmprestimo'] == 'emprestimo') ? 'Empréstimos' : 'Financiamentos';
            		else if (isset($fornecedor->nomefantasia)) {
            			echo 'todos os registros ['. $fornecedor->nomefantasia .']';
					}
            		?>
            	</legend>
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                        <?php 
                        if($this->permission->controllerManual($this->data['tipoEmprestimo'])->canInsert()){
                        	
                        	$address = base_url() . 'financiamento/visualiza_financiamento/'. $this->data['tipoEmprestimo'];
                        	
                        	if ($this->data['tipoEmprestimo'] == 'emprestimo_externo')
                        		$address = base_url() . 'financiamento/empestimo_externo_view/';
                        
                        ?>
						<a href="<?php echo $address; ?>" class="btn" id="btn-novo-inserir">
							<i class="icon-plus icon-white"></i> Realizar 
							<?php 
		            		if ($this->data['tipoEmprestimo'] == 'emprestimo' || $this->data['tipoEmprestimo'] == 'financiamento')
		            			echo ($this->data['tipoEmprestimo'] == 'emprestimo') ? 'Empréstimos' : 'Financiamentos';
		            		else
		            			echo 'Consulta /Lançamento'
		            		?>
							</a>
						<?php } ?>
						<div class="widget-box">
                            <div class="widget-content nopadding">
								
					            <form id="form_param" class="form-inline" method="post" action="<?php echo base_url()?>financiamento/gravarFinanciamento">
						            <input type="hidden" id="idEmprestimo" name="idEmprestimo" value="">
						            <input type="hidden" id="inserirAlterarRemover" name="inserirAlterarRemover" value="">
					            </form>
					            
								<div class="widget-title">
	                                <h5>&raquo; Registros</h5>
	                            </div>
								<table class="table table-bordered tabela-lista-financiamentos">
								    <thead>
								        <tr>
								            <th style="width: 40px;">COD</th>
								            <th>Funcionário</th>
								            <th style="">Cedente</th>
								            <?php if ($this->data['tipoEmprestimo'] == 'emprestimo') { ?>
								            <th style="">Fornecedor</th>
								            <?php } ?>
								            <th style="width: 105px;">Data Solicitação</th>
								            <th style="width: 85px;">Total</th>
								            <th style="width: 65px;">Parcelas</th>
								            <?php 
								            	if ($this->data['tipoEmprestimo'] == 'emprestimo' || 
								            		$this->data['tipoEmprestimo'] == 'financiamento') {
								            ?>
								            <th style="width: 65px;">Mensal</th>
								            <th style="width: 75px;">Situação</th>
								            <th style="width: 148px;">Ações</th>
								            <?php } ?>
								        </tr>
								    </thead>
								    <tbody>
								        <?php 
								        if (0 < count($results)) {
								        	foreach ($results as $r) {
								        		if ($r->localLancamento == 'externo') $existeLancamentoExterno = true;
								        		
								        		$class = ($r->localLancamento == 'externo' && 
								        				$this->data['tipoEmprestimo'] != 'emprestimo_externo' ) ? 'class="emp-externo"' : '';
									            	
									            echo '<td '.$class.'><center>'.$r->idEmprestimo.'</center></td>';
									            echo '<td>'.$r->nome.'</td>';
									            echo '<td>'.$r->nomefantasia.'</td>';
									            if ($this->data['tipoEmprestimo'] == 'emprestimo') {
									            	echo '<td>'.$r->nomefornecedor.'</td>';
									            }
									            echo '<td style="text-align:center;">'.conv_data_YMD_para_DMY($r->dataSolicitacao).'</td>';
									            echo '<td style="text-align:right;">R$ '.conv_monetario_br($r->valor).'</td>';
									            echo '<td style="text-align:center;">'.$r->parcelas.'</td>';
									            
									            if ($this->data['tipoEmprestimo'] == 'emprestimo' ||
									            	$this->data['tipoEmprestimo'] == 'financiamento') {
										            echo '<td style="text-align:right;">R$ '.conv_monetario_br($r->valor_parcelas).'</td>';
										            echo '<td>';
										            if ($r->situacao == 'simulacao') echo 'Simulação';
										            if ($r->situacao == 'aprovado') echo 'Aprovado';
										            if ($r->situacao == 'liquidado') echo 'Liquidado';
										            echo '</td>';
										            echo '<td>';
										            if($this->permission->controllerManual($this->data['tipoEmprestimo'])->canUpdate()){
										            	echo '<a href="'.base_url().'financiamento/visualiza_financiamento/'.$r->idEmprestimo.'" ';
										            	echo 'class="btn btn-alterar a-btn-abre-financiamento" type="button">';
										            	echo '<i class="icon-list-alt"></i>Alterar</a>';
										            }
										            if($r->situacao == 'simulacao' && $this->permission->controllerManual($this->data['tipoEmprestimo'])->canDelete()){
			            	                            echo '<button type="button" class="btn btn-remover btn-remover-lista" style="margin-left:2px;">
	            												<input type="hidden" id="idEmp" value="'. $r->idEmprestimo .'">
			            	                            		<i class="icon-trash"></i></button>';
										            }
									            }
									            echo '</td>';
									            echo '</tr>';
								        	}
								        }
								       	?>
								        <tr>
								            
								        </tr>
								    </tbody>
								</table>
								<?php if (isset($existeLancamentoExterno) && $this->data['tipoEmprestimo'] != 'emprestimo_externo') { ?>
								<div style="float: left; margin-top: 10px;">
									<div class="emp-externo" style="float: left; width: 52px; height: 20px;border: 1px solid #dfdfdf;"></div>
									<span style="margin-left: 5px;">Lançamento Externo</span>
								</div>
								<?php } ?>
            			        <div id="dialog-confirma-remover-registro" title="Deseja remover o registro?" style="display:none">
		                        	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		                          		Confirma a remoção deste financiamento?
		                        	</p>
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