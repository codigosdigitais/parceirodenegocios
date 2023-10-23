<?php 
$Funcionario = array_shift( $this->data['result'] );
?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar Vigência Atual: <?php echo $Funcionario->nome; ?></h5>
            </div>
            <div class="widget-content">
		    <form class="form-inline" id="form-update-tabela" method="post" action="<?php echo base_url('tabelafretefuncionario/gravartabela'); ?>">
		    	<input type="hidden" name="idFuncionarioFrete" value="<?php echo $Funcionario->idFuncionarioFrete; ?>" >
                
			    <fieldset>
					<legend class="form-title"><i class="icon-list-alt icon-title"></i> Vigência</legend>
					
					<div class="line">
						
						<label class="control-label" style="width: 75px !important;">Inicial</label>
						<input class="input-large mascara_data datepicker" type="text" maxlength="10" minlength="10" required="required" placeholder="__/__/____" name="vigencia_inicial" id="vigencia_inicial" value="<?php echo conv_data_YMD_para_DMY($Funcionario->vigencia_inicial); ?>" >
					
						<label class="control-label" style="width: 75px !important;">Final</label>
						<input class="input-large mascara_data datepicker" type="text" maxlength="10" minlength="10" placeholder="__/__/____" name="vigencia_final" id="vigencia_final" value="<?php echo conv_data_YMD_para_DMY($Funcionario->vigencia_final); ?>" >
						
					
					</div>
					
					
					
					
					<legend class="form-title"><i class="icon-list-alt icon-title"></i> Valores de Frete</legend>

					<div class="line">
						<label class="control-label" style="width: 75px !important;">Moto</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_normal" value="<? if(isset($result[0]->valor_moto_normal)){ echo conv_monetario_br($result[0]->valor_moto_normal); } ?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_metropolitano" value="<? if(isset($result[0]->valor_moto_metropolitano)){ echo conv_monetario_br($result[0]->valor_moto_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_depois_18" value="<? if(isset($result[0]->valor_moto_depois_18)){ echo conv_monetario_br($result[0]->valor_moto_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_km" value="<? if(isset($result[0]->valor_moto_km)){ echo conv_monetario_br($result[0]->valor_moto_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_moto_metropolitano_apos18" value="<? if(isset($result[0]->valor_moto_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_moto_metropolitano_apos18); } ?>" >
					</div>
					
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Carro</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_normal" value="<? if(isset($result[0]->valor_carro_normal)){ echo conv_monetario_br($result[0]->valor_carro_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_metropolitano" value="<? if(isset($result[0]->valor_carro_metropolitano)){ echo conv_monetario_br($result[0]->valor_carro_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_depois_18" value="<? if(isset($result[0]->valor_carro_depois_18)){ echo conv_monetario_br($result[0]->valor_carro_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_km" value="<? if(isset($result[0]->valor_carro_km)){ echo conv_monetario_br($result[0]->valor_carro_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_carro_metropolitano_apos18" value="<? if(isset($result[0]->valor_carro_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_carro_metropolitano_apos18); } ?>" >
					</div>
                    
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Van</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_normal" value="<? if(isset($result[0]->valor_van_normal)){ echo conv_monetario_br($result[0]->valor_van_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_metropolitano" value="<? if(isset($result[0]->valor_van_metropolitano)){ echo conv_monetario_br($result[0]->valor_van_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_depois_18" value="<? if(isset($result[0]->valor_van_depois_18)){ echo conv_monetario_br($result[0]->valor_van_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_km" value="<? if(isset($result[0]->valor_van_km)){ echo conv_monetario_br($result[0]->valor_van_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_van_metropolitano_apos18" value="<? if(isset($result[0]->valor_van_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_van_metropolitano_apos18); } ?>" >

					</div>
                    
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Caminhão</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_normal" value="<? if(isset($result[0]->valor_caminhao_normal)){ echo conv_monetario_br($result[0]->valor_caminhao_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_metropolitano" value="<? if(isset($result[0]->valor_caminhao_metropolitano)){ echo conv_monetario_br($result[0]->valor_caminhao_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_depois_18" value="<? if(isset($result[0]->valor_caminhao_depois_18)){ echo conv_monetario_br($result[0]->valor_caminhao_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_km" value="<? if(isset($result[0]->valor_caminhao_km)){ echo conv_monetario_br($result[0]->valor_caminhao_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_caminhao_metropolitano_apos18" value="<? if(isset($result[0]->valor_caminhao_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_caminhao_metropolitano_apos18); } ?>" >

					</div>
                    
				
					<div class="line"></div>
					
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">

                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        	
                        	<button type="button" class="btn btn-primary btn-remover-form" id="btn-remover-form" style="margin-left:10px;">
                            		<i class="icon-trash"></i> Remover</button>
                            		
                            <button type="button" class="btn btn-success" id="btn-nova-vigencia"><i class="icon-plus icon-white"></i> Nova Vigência</button>
                            
                        	<a href="<?php echo base_url() ?>tabelafretefuncionario" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
				    
				    <input type="checkbox" id="novaCompetencia" name="novaCompetencia" style="display: none;">
				    <script>
						$(document).ready(function(){
							$('#btn-nova-vigencia').click(function(){
								if ( $('#vigencia_inicial').val() == "" || $('#vigencia_final').val() == "") {
									mostrarMensagemAlertaTopoPagina('error', 'Para criar uma nova vigência, primeiramente informe a data final da vigência atual.')
								}
								else {
									$('#novaCompetencia').prop('checked', true);
									$('#form-update-tabela').submit();
								}
							});
						});
				    </script>
				    
					
					
					<legend class="form-title"><i class="icon-list-alt icon-title"></i> Histórico de Valores</legend>
				    
						<table class="table table-striped table-frete-funcionario">
							<thead>
								<tr>
									<th rowspan="2">Vigência</th>
									<th colspan="5">Moto</th>
									<th colspan="5">Carro</th>
									<th colspan="5">Van</th>
									<th colspan="5">Caminhão</th>
								</tr>
								<tr>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
								</tr>
				    <?php 
				    if (0 < count($historico)) {
						foreach ($historico as $h) { 
							
							echo "<tr>";
							echo "<td style='text-align:left;font-weight:bold;'>". conv_data_YMD_para_DMY($h->vigencia_inicial) . " ";
							echo ($h->vigencia_final != "") ? "à ".conv_data_YMD_para_DMY($h->vigencia_final) : "(atual)";
							echo "</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_carro_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_van_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_caminhao_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_metropolitano_apos18) ."</td>";
							echo "<tr>";
							
						}
				    }
				    ?>
				    		</thead>
				    	</table>
				    
		    	</fieldset>
	    	</form>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){
		
					$('#btn-remover-form').click(function(){
						$( "#dialog-remove-funcionario" ).dialog( "open" );
					});
					
					$( "#dialog-remove-funcionario" ).dialog({
					  autoOpen: false,
					  modal: true,
					  width: 500,
					  heigth: 500,
					  buttons: {
						"Remover": {
							text: 'Remover Tabela',
							click: function() {
								$(".ui-dialog-buttonpane button:contains('Remover Tabela')").attr("disabled", true).addClass("ui-state-disabled");
								$('#form-remover-tabela').submit();
							}
						},
						"Retornar": function() {
							$( this ).dialog( "close" );
						}
					  }
					});
					
				});
			</script>
			<div id="dialog-remove-funcionario" title="Selecione um funcionario" style="display:none">
	        	<form id="form-remover-tabela" method="post" action="<?php echo base_url('tabelafretefuncionario/removertabela'); ?>">
	        		<input type="hidden" name="idFuncionarioFrete" value="<?php echo $Funcionario->idFuncionarioFrete; ?>" >
	        		
	        		<div class="">
	        			Deseja realmente remover esta tabela de fretes?
	        		</div>
	        	</form>
	        </div>
    </div>
    
</div>
</div>
