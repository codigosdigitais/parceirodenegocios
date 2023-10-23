
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Tabela de Frete por Cliente</h5>
            </div>
            <div class="widget-content">
		    <form id="form-todos-clientes" method="post" action="<?php echo base_url('tabelafretecliente/copiarEmSelecionados'); ?>">
		    	
		    			<div class="line">
		    				<button type="button" class="btn btn-success" id="btn-novo-cliente"><i class="icon-plus icon-white"></i> Vincular novo Cliente</button>
		    				<button type="button" class="btn btn-primary" id="btn-copia-selecionados"><i class="icon-plus icon-white"></i> Nova vigência aos selecionados</button>
		    			</div>
		    			
		    			<script type="text/javascript">
		    				$(document).ready(function(){
								$('#check-all').click(function(){
									$( '#form-todos-clientes input[type="checkbox"]' ).prop('checked', this.checked)
								});
		    				});
		    			</script>
		    			
				    	<div class="div-info-small">Clique sobre o nome do cliente para editar</div>
				    	
				    	<style>
				    	.table th, .table td{line-height: 20px;padding-left: 3px;}
				    	.table th, .table label{font-size: 11px;}
				    	</style>
						<table class="table table-striped table-frete-cliente">
							<thead>
								<tr>
									<th rowspan="2" style="padding: 0;"><label for="check-all">Sel. Tudo</label><input type='checkbox' id='check-all'></th>
									<th rowspan="2">Cliente</th>
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
				    if ($historico) {
						foreach ($historico as $h) {
							
							echo ($h->vigencia_final == "") ? "<tr>" : "<tr style='background-color:#FFB5B5;'>";
							echo "<td><input type='checkbox' name='tabFreteCheck[]' value='".$h->idClienteFrete."'></td>";
							echo "<td style='text-align:left;'><div style='max-width:200px;height:25px;overflow:hidden;'>";
							echo "<a href='".base_url()."tabelafretecliente/editar/". $h->idClienteFrete ."'>";
							echo $h->nomefantasia;
							echo "</a></div></td>";
							echo "<td style='text-align:left;font-weight:bold;width:100px;'>". conv_data_YMD_para_DMY($h->vigencia_inicial) . " ";
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
				    
	    	</form>
			</div>
        
    </div>
    
    
	<script type="text/javascript">
		$(document).ready(function(){

			$('#btn-novo-cliente').click(function(){
				$( "#dialog-add-cliente" ).dialog( "open" );
			});
			
			$( "#dialog-add-cliente" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  heigth: 500,
			  buttons: {
				"Criar": {
					className: 'btn-criar-tabela',
					text: 'Criar Tabela',
					click: function() {
						$(".ui-dialog-buttonpane button:contains('Criar Tabela')").attr("disabled", true).addClass("ui-state-disabled");
						$('#form-add-cliente').submit();
					}
				},
				"Retornar": function() {
					$( this ).dialog( "close" );
				}
			  }
			});


			

			$('#btn-copia-selecionados').click(function(){
				$('#form-copia-selecionados #info').html('');
				$( "#dialog-copia-selecionados" ).dialog( "open" );
			});
			
			$( "#dialog-copia-selecionados" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  heigth: 500,
			  buttons: {
				"Criar": {
					className: 'btn-copiar-tabelas',
					text: 'Criar Tabelas',
					click: function() {
						if ( $('#form-todos-clientes input[type=checkbox]:checked' ).length) {

							$(".ui-dialog-buttonpane button:contains('Criar Tabelas')").attr("disabled", true).addClass("ui-state-disabled");
							$('#form-copia-selecionados #info').html('<font color="green">Realizando cópia. Por favor aguarde...</font>');
							
							$('#form-copia-selecionados select, #form-copia-selecionados input').clone(true, true).appendTo( "#form-todos-clientes" ).hide();;
							$('#form-todos-clientes #idClienteFrete').val( $('#form-copia-selecionados #idClienteFrete').val() );
							$('#form-todos-clientes').submit();
						}
						else {
							$('#form-copia-selecionados #info').html('Selecione pelo menos uma tabela para substituir!');
						}
					}
				},
				"Retornar": function() {
					$( this ).dialog( "close" );
				}
			  }
			});
			
		});
	</script>
	<div id="dialog-add-cliente" title="Selecione um cliente" style="display:none">
		
			<form id="form-add-cliente" method="post" action="<?php echo base_url('tabelafretecliente/criarNovaTabela'); ?>">
				
				<div class="">Selecione um cliente que ainda não possui tabela de frete:</div>
				<div class="">
					<select id="idCliente" name="idCliente" class="input-xlarge">
					<?php 
					if (0 < count($clienteSemTabela)) {
						foreach ($clienteSemTabela as $c) {
							echo "<option value='". $c->idCliente ."'>". substr($c->nomefantasia, 0, 60) ."</option>";
						}
					}
					?>
					</select>
				</div>
				<br>
				<div class="">Selecione tabela de origem (cópia ou nova)</div>
				<div class="">
					<select id="idClienteFrete" name="idClienteFrete" class="input-xlarge">
						<option value="">Nova Tabela</option>
					<?php 
					if (0 < count($historico)) {
						foreach ($historico as $h) {
							echo "<option value='".$h->idClienteFrete ."'>". substr($h->nomefantasia, 0, 60) ."</option>";
						}
					}
					?>
					</select>
				</div>
			</form>
		</p>
	</div>
	
	<div id="dialog-copia-selecionados" title="Informe vigências" style="display:none">
		
			<form id="form-copia-selecionados" method="post" action="<?php echo base_url('tabelafretecliente/copiarEmSelecionados'); ?>">
				<br>
				<div class="">Informe a tabela de origem/modelo para aplicar aos demais clientes</div>
				<div class="">
					<select id="idClienteFrete" name="idClienteFrete" class="input-xlarge">
					<?php 
					if (0 < count($historico)) {
						foreach ($historico as $h) {
							echo "<option value='".$h->idClienteFrete ."'>". substr($h->nomefantasia, 0, 60) ."</option>";
						}
					}
					?>
					</select>
				</div>
				<br><br>
				<?php 
					$hoje = date_create();
    				$hoje = date_format($hoje,"d/m/Y");
				?>
				<div class="">Informe <b>Vigência Final</b> para Selecionados</div>
				<input class="input-large mascara_data datepicker" type="text" maxlength="10" minlength="10" placeholder="__/__/____" name="vigencia_final" id="vigencia_final" value="<?php echo $hoje; ?>" >
				<br><br>
				<div style="color: red;" id="info"></div>
			</form>
		</p>
	</div>
	
	
</div>
</div>
