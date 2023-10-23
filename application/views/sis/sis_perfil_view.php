
<?php 
if ($historico) $Perfil = array_shift($historico);
?>

<script type="text/javascript">
	$(document).ready(function(){

		$('#idModuloCliente').change(function(){
			var idModuloCliente = $(this).val();
			if (idModuloCliente > 0) {
				var newOptions = $('#idModuloClienteFuncaoOptions .options[rule='+idModuloCliente+']').html();
				$('#idModuloClienteFuncao').html(newOptions);
			}
			else $('#idModuloClienteFuncao').html('<option></option>');
		});

		$('.btn-alterar').click(function(){
			var idPerfilFuncao = $(this).parent().parent().find('td').eq(0).html();
			var idPerfilURL = $('#idPerfilURL').val();
			var myWindow = window.open("<?php echo base_url()?>"+idPerfilURL+"/sis_perfil/popup_funcao_parametros/" + idPerfilFuncao, "", "width=1000, height=600");
		});
		
		$('#table-modulos .btn-remover').click(function(){
			
			var idPerfilFuncao = $(this).attr('role');
			var modulo = $(this).parent().parent().find('td').eq(1).html();
			
			$('#form-remove-funcao #idPerfilFuncao').val(idPerfilFuncao);
			$('#form-remove-funcao #detail').html(modulo);
			
			$( "#dialog-remove-funcao" ).dialog( "open" );
		});

		$( "#dialog-remove-funcao" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Desvincular": {
				text: 'Desvincular Módulo',
				click: function() {
					$(".ui-dialog-buttonpane button:contains('Desvincular Módulo')").attr("disabled", true).addClass("ui-state-disabled");
					$('#form-remove-funcao').submit();
				}
			},
			"Retornar": function() {
				$('#form-remove-funcao #idPerfilFuncao').val('');
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
	.input-large{width: 220px;}
	.btn-alterar{width: 172px !important;}
	.btn-remover{height: 30px;}
	.inline-bloc{display: inline-block;vertical-align: top;}
	#idModuloClienteFuncaoOptions{display: none;}
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Perfil</h5>
            </div>
            <div class="widget-content">

	            <fieldset>
	            	<legend>
		            	Perfil
	            	</legend>
	    			<div class="line">
	    			
	    				<form id="form-unidade" action="<?php echo base_url('sis_perfil/gravar_perfil'); ?>" method="post">
	    					<input class="input-large" type="hidden" id="idPerfil" name="idPerfil" value="<?php if (isset($Perfil->idPerfil)) echo $Perfil->idPerfil; ?>">
		    				<label for="nomePerfil"></label>
		    				<input type="text" id="nomePerfil" name="nomePerfil" maxlength="60" minlength="3" placeholder="Nome do Perfil" value="<?php if (isset($Perfil->nome)) echo $Perfil->nome; ?>" required="required"> 
		    				<select id="situacao" name="situacao" class="input-small" required="required">
		    					<option value="1" <?php if (isset($Perfil->situacao) && $Perfil->situacao) echo "selected"; ?>>Ativo</option>
		    					<option value="0" <?php if (isset($Perfil->situacao) && !$Perfil->situacao) echo "selected"; ?>>Inativo</option>
		    				</select>
		    				
		    				<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Salvar</button>
	    				</form>
	    			</div>
	            </fieldset>
	            
	            <?php if (isset($Perfil->idPerfil)) { ?>
	    		<fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Inserir novo módulo
	            	</legend>
	            	
	    			<form id="form-funcao" action="<?php echo base_url('sis_perfil/gravar_perfil_funcao'); ?>" method="post">
	    				<input type="hidden" id="idPerfil" name="idPerfil" value="<?php if (isset($Perfil->idPerfil)) echo $Perfil->idPerfil; ?>">
		    			<div class="line">
		    				<label for="idModuloCliente">Selecione o Módulo</label>
							<select id="idModuloCliente" name="idModuloCliente" class="input-large" required="required">
								<option value=""></option>
			    					<?php 
			    						if($modulosFuncoesDisponiveis) {
			    							$atual = "";
			    							foreach ($modulosFuncoesDisponiveis as $f) {
			    								if ($atual != $f->idModuloCliente) {
			    									echo '<option value="'.$f->idModuloCliente.'">'.$f->nomeModulo.'</option>';
			    									$atual = $f->idModuloCliente;
			    								}
			    							}
			    						}
			    						
			    					?>
		    				</select>
		    			</div>
		    			<br>
		    			<div class="line">
		    				<label for="idModuloClienteFuncao">Selecione a Função</label>
							<select id="idModuloClienteFuncao" name="idModuloClienteFuncao" class="input-large" required="required">
								<option value=""></option>
		    				</select>
		    				<select id="situacao" name="situacao" class="input-small" required="required">
		    					<option value="1">Ativo</option>
		    					<option value="0">Inativo</option>
		    				</select>
		    				
		    				<select id="visivel" name="visivel" class="input-large" required="required">
		    					<option value="1" <?php if (isset($Perfil->visivel) && $Perfil->visivel) echo "selected"; ?>>Visível no menu</option>
		    					<option value="0" <?php if (isset($Perfil->visivel) && !$Perfil->visivel) echo "selected"; ?>>Invisível (conceder permissão)</option>
		    				</select>
		    				
		    				<button id="btn-gravar-funcao" type="submit" class="btn btn-primary"><i class="icon-plus icon-white"></i> Inserir</button>
		    				<button id="btn-limpar-funcao" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Limpar</button>
		    			</div>
		    			
		    				<div id="idModuloClienteFuncaoOptions">
	    					<?php 
	    						if($modulosFuncoesDisponiveis) {
	    							$atual = "";
	    							$first = true;
	    							
	    							foreach ($modulosFuncoesDisponiveis as $f) {
	    								
	    								if ($atual != $f->idModuloCliente) {
	    									if (!$first) echo "</div>";
	    									$first = false;
	    									
	    									echo "<div class='options' rule='".$f->idModuloCliente."'>";
	    									
	    									$atual = $f->idModuloCliente;
	    								}
	    								
    									echo '<option value="'.$f->idModuloClienteFuncao.'">'.$f->nomeFuncao.'</option>';
	    							}
	    							if (!$first) echo "</div>";
	    						}
	    						
	    					?>		    				
		    				</div>
		    		</form>
	    		</fieldset>
	    		
	    		<div class="line"></div>
	    		
	    		<fieldset>
	            	<legend>
		            	Módulos existentes
	            	</legend>
	    			
		    		<div class="table-responsive">
					    <table class="table table-bordered" id="table-modulos"><thead><tr>
					    	<th>Módulo :: Função</th>
					    	<th>Situação</th>
					    	<th>Visibilidade</th>
					    	<th style="width: 206px;">Ações</th>
					    </tr></thead>
					    <tbody>
					    
					    <?php 
					    if ($modulosFuncoesVinculados) {
							foreach ($modulosFuncoesVinculados as $h) {
								$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
								$visibilidade	= ($h->visivel)  ? "Visível no menu" : "Invisível (conceder permissão)";
								
								echo "<tr>";
								echo "<td style='display:none'>". $h->idPerfilFuncao ."</td>";
								echo "<td>". $h->nomeModulo ." :: ".$h->nomeFuncao."</td>";
								echo "<td>". $situacaoPerfil ."</td>";
								echo "<td>". $visibilidade ."</td>";
								echo "<td>";
								echo '<button class="btn btn-alterar" id="btn-alterar-funcao" type="button">';
								echo '<i class="icon-list-alt"></i> Funções e Parâmetros</button>';

								echo '<button class="btn btn-remover" type="button" role="'.$h->idPerfilFuncao.'"><i class="icon-trash"></i></button>';
								echo "</td>";
								echo "</tr>";
							}
					    }
					    ?>
						
						</tbody></table>
					</div>
	    		</fieldset>
	    		
	    		<?php } ?>
	    		
	    		<div class="line">
	    			<a href="<?php echo base_url('sis_perfil')?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
	            
	    	</div>
	    	
			<div id="dialog-remove-funcao" title="Deseja desvincular o módulo?" style="display:none">
	        	<form id="form-remove-funcao" action="<?php echo base_url('sis_perfil/remover_perfil_funcao'); ?>" method="post">
	        		<input type="hidden" id="idPerfil" name="idPerfil" value="<?php if (isset($Perfil->idPerfil)) echo $Perfil->idPerfil; ?>">
	        		<input type="hidden" id="idPerfilFuncao" name="idPerfilFuncao">
	        		
	        		<div class="">
	        			Deseja realmente desvincular este módulo do perfil?
	        		</div>
	        		<br>
	        		<div id="detail"></div>
	        	</form>
	        </div>	
    </div>
</div>
</div>
