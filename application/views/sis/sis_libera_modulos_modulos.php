<?php 
if ($historico) $Cliente = array_shift($historico);
?>

<script type="text/javascript">
	$(document).ready(function(){

		$('form').submit(function(){
			if ( !$(this).valid() ) {
				event.preventDefault();
			}
		});
		$('.btn-copiar').click(function() {

			var idModulo = $(this).attr('role');
			var info = $(this).parent().parent().find('td:eq(1)').html();
			
			$('#form-copiar-modulo #idModulo').val(idModulo);
			$('#form-copiar-modulo #detail').html('Copiando módulo: <b>' + info + '</b>');
			
			$( "#dialog-copiar-modulo" ).dialog( "open" );
		});
		
		$( "#dialog-copiar-modulo" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Copiar": {
				text: 'Copiar Módulo',
				click: function() {
					if ( $('#idParceiroDestino').val() != '') {
						$(".ui-dialog-buttonpane button:contains('Copiar Módulo')").attr("disabled", true).addClass("ui-state-disabled");
						$('#form-copiar-modulo').submit();
					}
				}
			},
			"Retornar": function() {
				$('#form-copiar-modulo #idModulo').val('');
				$('#form-copiar-modulo #detail').html('');
				$( this ).dialog( "close" );
			}
		  }
		});


		$('.btn-remover').click(function() {

			var idModulo = $(this).attr('role');
			var info = $(this).parent().parent().find('td:eq(1)').html();
			
			$('#form-remover-modulo #idModulo').val(idModulo);
			$('#form-remover-modulo #detail').html('Remover módulo: <b>' + info + '</b>');
			
			$( "#dialog-remover-modulo" ).dialog( "open" );
		});
		
		$( "#dialog-remover-modulo" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Copiar": {
				text: 'Remover Módulo',
				click: function() {
					$(".ui-dialog-buttonpane button:contains('Remover Módulo')").attr("disabled", true).addClass("ui-state-disabled");
					$('#form-remover-modulo').submit();
				}
			},
			"Retornar": function() {
				$('#form-remover-modulo #idModulo').val('');
				$('#form-remover-modulo #detail').html('');
				$( this ).dialog( "close" );
			}
		  }
		});
	});
</script>

<style>
	input, select{margin-right: 15px;}
	input[type="text"]{margin-bottom: 0;}
	.btn{padding: 5px 10px;width: 90px;}
	fieldset{margin-bottom: 15px;}
	#btn-limpar-funcao{display: none;}
	.inline-bloc{display: inline-block;vertical-align: top;}
	.bloc-btns{margin-top: 25px;}
	.btn { margin-right: 2px;}
</style>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Liberação de Módulos</h5>
            </div>
            <div class="widget-content">
		    	
	            <fieldset>
	            	<legend>
		            	<?php if (isset($Cliente->nomefantasia)) echo $Cliente->nomefantasia; ?>
	            	</legend>
	            </fieldset>
	            
	            
	            <fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Novo Módulo
	            	</legend>
	            	
	    			<div class="line">
	    			
	    				<form id="form-unidade" action="<?php echo base_url('sis_libera_modulos/gravar_modulo'); ?>" method="post">
	    					<input type="hidden" id="idModuloCliente" name="idModuloCliente" value="<?php if (isset($Cliente->idModuloCliente)) echo $Cliente->idModuloCliente; ?>">
	    					<input type="hidden" id="idCliente" name="idCliente" value="<?php if (isset($Cliente->idCliente)) echo $Cliente->idCliente; ?>">
	    					
	    					<div class="inline-bloc">
			    				<label for="nomeModulo">Nome do Módulo</label>
			    				<input type="text" id="nomeModulo" name="nomeModulo" maxlength="60" minlength="3" placeholder="Nome de Menu" required="required"> 
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="ordemVisualizacao">Ordem</label>
			    				<input class="input-small mascara_numero_sem_decimal" type="text" id="ordemVisualizacao" name="ordemVisualizacao" maxlength="3" placeholder="ex. 10">
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="situacao">Situação</label>
			    				<select id="situacao" name="situacao" class="input-small" required="required">
			    					<option value="1">Ativo</option>
			    					<option value="0">Inativo</option>
			    				</select>
		    				</div>
		    				<div class="inline-bloc bloc-btns">
		    					<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Incluir</button>
		    				</div>
	    				</form>
	    			</div>
	            </fieldset>
	            
	            <div class="line"></div>
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered "><thead><tr>
				    	<th>ID</th>
				    	<th>Nome</th>
				    	<th>Ordem</th>
				    	<th>Situação</th>
				    	<th style="width: 238px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php 
				    if (0 < count($historico)) {
						foreach ($historico['modulos'] as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							
							echo "<tr>";
							echo "<td>". $h->idModuloCliente ."</td>";
							echo "<td>". $h->nome ."</td>";
							echo "<td>". $h->ordem ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							
							echo "<td>";
							echo "<a href='".base_url("sis_libera_modulos/edita_modulo/".$h->idModuloCliente)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i> Funções</a>";

							echo "<button class='btn btn-copiar' role='". $h->idModuloCliente ."'>";
							echo "<i class='icon-list-alt'></i> Copiar</button>";
							
							echo "<button class='btn btn-remover' role='". $h->idModuloCliente ."'>";
							echo "<i class='icon-trash'></i></button>";
							echo "</td>";
							echo "</tr>";
						}
				    }
				    ?>
					
					</tbody></table>
				</div>
				
	    		<div class="line">
	    			<a href="<?php echo base_url('sis_libera_modulos')?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
	            
	            <div id="dialog-copiar-modulo" title="Selecione o parceiro de destino" style="display:none">
		        	<form id="form-copiar-modulo" action="<?php echo base_url('sis_libera_modulos/copiar_modulo'); ?>" method="post">
		        		<input type="hidden" id="idCliente" name="idCliente" value="<?php if (isset($Cliente->idCliente)) echo $Cliente->idCliente; ?>">
		        		<input type="hidden" id="idModulo" name="idModulo">
		        		
		        		<div class="">
		        			Selecione o parceiro de destino (que receberá o módulo):
		        			<br><br>
		        			<div>
		        			<select id="idParceiroDestino" name="idParceiroDestino" class="input-xlarge">
		        				<option></option>
		        				<?php 
		        				if (isset($parceiros)) {
		        					foreach ($parceiros as $parceiro) {
		        						echo "<option value='".$parceiro->idCliente."'>".$parceiro->nomefantasia."</option>";
		        					}
		        				}
		        				?>
		        			</select>
		        			</div>
		        		</div>
		        		<br>
		        		<div id="detail"></div>
		        	</form>
		        </div>
		        
		        
		        
	            <div id="dialog-remover-modulo" title="Deseja remover o módulo?" style="display:none">
		        	<form id="form-remover-modulo" action="<?php echo base_url('sis_libera_modulos/remover_modulo'); ?>" method="post">
		        		<input type="hidden" id="idCliente" name="idCliente" value="<?php if (isset($Cliente->idCliente)) echo $Cliente->idCliente; ?>">
		        		<input type="hidden" id="idModulo" name="idModulo">
		        		
		        		<div class="">
		        			Deseja realmente remover o módulo selecionado?
		        			<br><br>
		        		</div>
		        		<br>
		        		<div id="detail"></div>
		        	</form>
		        </div>
			</div>
    </div>
</div>
</div>
