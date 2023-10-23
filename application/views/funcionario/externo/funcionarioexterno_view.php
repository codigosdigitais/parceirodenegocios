<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/global_functions.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/funcionarios/js/funcionarioexterno.js"></script>


<style type="text/css">
.tabela-lista-funcionarios-externo .cad-inserido {background-color: #BD0808;color: white;}
</style>

<div class="row-fluid" style="margin-top:-10px">

	<input type="hidden" id="url-address-default" value="<?php echo base_url(); ?>">

            <div class="widget-content">
            
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Cadastros de funcionários realizados via integração (website)
            	</legend>
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
                       
						<div class="widget-box">
                            <div class="widget-content nopadding">
								
					            <form id="form_param" class="form-inline" method="post" action="<?php echo base_url()?>financiamento/gravarFinanciamento">
						            <input type="hidden" id="idEmprestimo" name="idEmprestimo" value="">
						            <input type="hidden" id="inserirAlterarRemover" name="inserirAlterarRemover" value="">
					            </form>
					            
								<div class="widget-title">
	                                <h5>&raquo; Registros</h5>
	                            </div>
								<table class="table table-bordered tabela-lista-funcionarios-externo">
								    <thead>
								        <tr>
								            <th style="width: 40px;">COD</th>
								            <th>Data cadastro</th>
								            <th>Nome</th>
								            <th>Email</th>
								            <th>Telefone</th>
								            <th>Cidade</th>
								            <th>Smartphone</th>
								            <th>Baú</th>
								            <th>MEI</th>
								            <th>Placa</th>
								            <th>Condumoto</th>
								            <th style="width: 90px;"></th>
								        </tr>
								    </thead>
								    <tbody>
								        <?php 
								        if (is_array($results) && 0 < count($results)) {
								        	foreach ($results as $r) {
								        		echo '<tr>';
								        		$class = ($r->emailCadastrado == '') ? 'class="cad-inserido"' : '';
									            	
									            echo '<td '.$class.'><center>'.$r->id.'</center>';
									            echo '<input type="hidden" id="idFuncionarioExterno" value="'.$r->id.'">';
									            echo '</td>';
									            echo '<td>'.conv_data_YMDHMS_para_DMYHMS($r->dataHora).'</td>';
									            echo '<td>'.$r->nome.'</td>';
									            echo '<td>'.$r->email.'</td>';
									            echo '<td>'.$r->telefone.'</td>';
									            echo '<td>'.$r->cidade.' - '.$r->estado.'</td>';
									            echo ($r->temSmartphone) 	? '<td>'.$r->tipoSmartphone.'</td>' : '<td>Não</td>';
									            echo ($r->temBauInstalado) 	? '<td>Sim</td>' : '<td>Não</td>';
									            echo ($r->temMEI) 			? '<td>Sim</td>' : '<td>Não</td>';
									            echo ($r->temPlacaVermelha) ? '<td>Sim</td>' : '<td>Não</td>';
									            echo ($r->temCondumoto) 	? '<td>Sim</td>' : '<td>Não</td>';
									            
									            if ($class != '') {
									            	echo '<td><button type="button" class="btn btn-alterar btn-copiar-cad"><i class="icon-list-alt"></i>Copiar</button></td>';
									            }
									            else 
									            	echo '<td><a href="'.base_url().'funcionario/editar/'.$r->idFuncionario.'">Abrir</a></td>';
									            
									            echo '</tr>';
								        	}
								        }
								       	?>
								        <tr>
								            
								        </tr>
								    </tbody>
								</table>
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