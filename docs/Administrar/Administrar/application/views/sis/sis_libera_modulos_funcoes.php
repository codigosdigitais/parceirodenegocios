<?php 
if ($historico) $ModuloCliente = array_shift($historico);
?>

<script type="text/javascript">

	var idFuncaoTemp;
	
	$(document).ready(function(){

		$('#table-funcoes .btn-remover').click(function(){
			
			var idModuloClienteFuncao = $(this).attr('role');
			var funcao = $(this).parent().parent().find('td').eq(2).html();
			
			$('#form-remove-funcao #idModuloClienteFuncao').val(idModuloClienteFuncao);
			$('#form-remove-funcao #detail').html(funcao);
			
			$( "#dialog-remove-funcao" ).dialog( "open" );
		});

		$('#table-funcoes .btn-alterar').click(function(){
			idFuncaoTemp = $('#form-modulo-funcao #idFuncao').html();

			var newOptions = $(this).parent().parent().find('td').eq(0).html();
			var idModCliFunc = $(this).parent().parent().find('td').eq(1).html();
			var nome = $(this).parent().parent().find('td').eq(3).html();
			var ordem= $(this).parent().parent().find('td').eq(4).html();
			var situacao = $(this).parent().parent().find('td').eq(5).html();

			$('#form-modulo-funcao #idModuloClienteFuncao').val(idModCliFunc);
			$('#form-modulo-funcao #idFuncao').html(newOptions);
			$('#form-modulo-funcao #nomeFuncao').val(nome);
			$('#form-modulo-funcao #ordemVisualizacao').val(ordem);
			$('#form-modulo-funcao #situacao').val(situacao);

			$('#form-modulo-funcao #btn-gravar-funcao').html( '<i class="icon-ok icon-white"></i> Salvar' );
			$('#form-modulo-funcao #btn-limpar-funcao').show();
			
		});

		$('#btn-limpar-funcao').click(function(){
			$('#form-modulo-funcao input').val('');
			$('#form-modulo-funcao select').val(1);
			$('#form-modulo-funcao #btn-gravar-funcao').html( '<i class="icon-plus icon-white"></i> Inserir' );
			$(this).hide();
		});

		$('form').submit(function(){
			if ( !$(this).valid() ) {
				event.preventDefault();
			}
		});

		$( "#dialog-remove-funcao" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Remover": {
				text: 'Remover Função',
				click: function() {
					$(".ui-dialog-buttonpane button:contains('Remover Função')").attr("disabled", true).addClass("ui-state-disabled");
					$('#form-remove-funcao').submit();
				}
			},
			"Retornar": function() {
				$('#form-remove-funcao #idModuloClienteFuncao').val('');
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
	.btn-remover{height: 30px;}
	fieldset{margin-bottom: 15px;}
	#btn-limpar-funcao{display: none;}
	.inline-bloc{display: inline-block;vertical-align: top;}
	.bloc-btns{margin-top: 25px;}
	.info-unidade{font-size: 16px;color: #696969;}
	.line{width: auto;}
	.input-xxlarge{width: 350px;}
</style>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Liberação de Funções</h5>
            </div>
            <div class="widget-content">
		    	
	            <fieldset>
	            	<legend>
		            	<?php echo $ModuloCliente->nomefantasia; ?>
	            	</legend>
	            </fieldset>
	            
	            
				<fieldset>
	            	<legend>
		            	Módulo
	            	</legend>
	            	
	    			<div class="line">
	    			
	    				<form id="form-modulo" action="<?php echo base_url('sis_libera_modulos/gravar_modulo'); ?>" method="post">
	    					<input type="hidden" id="idModuloCliente" name="idModuloCliente" value="<?php if (isset($ModuloCliente->idModuloCliente)) echo $ModuloCliente->idModuloCliente; ?>">
	    					<input type="hidden" id="idCliente" name="idCliente" value="<?php if (isset($ModuloCliente->idCliente)) echo $ModuloCliente->idCliente; ?>">
	    					
	    					<div class="inline-bloc">
			    				<label for="nomeModulo">Nome do Módulo</label>
			    				<input type="text" id="nomeModulo" name="nomeModulo" maxlength="60" minlength="3" placeholder="Nome de Menu" required="required" value="<?php if (isset($ModuloCliente->nome)) echo $ModuloCliente->nome; ?>"> 
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="ordemVisualizacao">Ordem</label>
			    				<input class="input-small mascara_numero_sem_decimal" type="text" id="ordemVisualizacao" name="ordemVisualizacao" maxlength="3" placeholder="ex. 10" value="<?php if (isset($ModuloCliente->ordem)) echo $ModuloCliente->ordem; ?>">
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="situacao">Situação</label>
			    				<select id="situacao" name="situacao" class="input-small" required="required">
			    					<option value="1" <?php if (isset($ModuloCliente->situacao) && $ModuloCliente->situacao) echo "selected"; ?>>Ativo</option>
			    					<option value="0" <?php if (isset($ModuloCliente->situacao) && !$ModuloCliente->situacao) echo "selected"; ?>>Inativo</option>
			    				</select>
		    				</div>
		    				<div class="inline-bloc bloc-btns">
		    					<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
		    				</div>
	    				</form>
	    			</div>
	            </fieldset>
	            
				<div class="line"></div>
	            
	            
	            <fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Nova Função
	            	</legend>
	            	
	    			<div class="line">
	    			
	    				<form id="form-modulo-funcao" action="<?php echo base_url('sis_libera_modulos/gravar_funcao_modulo'); ?>" method="post">
	    					<input type="hidden" id="idModuloClienteFuncao" name="idModuloClienteFuncao">
	    					<input type="hidden" id="idModuloCliente" name="idModuloCliente" value="<?php if (isset($ModuloCliente->idModuloCliente)) echo $ModuloCliente->idModuloCliente; ?>">
	    					
		    				<div class="inline-bloc">
		    					<label for="idFuncao">Selecione uma Função</label>
			    				<select id="idFuncao" name="idFuncao" class="input-xxlarge" required="required">
			    					<option value=""></option>
			    					<?php 
			    						
			    						if($funcoesDisponiveis) {
			    							foreach ($funcoesDisponiveis as $f) {
			    								echo '<option value="'.$f->idFuncao.'">'.$f->nomeUnidade.' :: '.$f->nome.'</option>';
			    							}
			    						}
			    						
			    					?>
			    				</select>
		    				</div>
	    					<div class="inline-bloc">
			    				<label for="nomeFuncao">Nome da Função</label>
			    				<input type="text" id="nomeFuncao" name="nomeFuncao" maxlength="60" minlength="3" placeholder="Nome de Menu" required="required"> 
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
		    					<button type="submit" class="btn btn-primary btn-gravar-funcao"><i class="icon-ok icon-white"></i> Incluir</button>
		    					<button id="btn-limpar-funcao" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Limpar</button>
		    				</div>
	    				</form>
	    			</div>
	            </fieldset>
	            
	            <div class="line"></div>
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered" id="table-funcoes"><thead><tr>
				    	<th>Função</th>
				    	<th>Nome de Menu</th>
				    	<th>Ordem</th>
				    	<th>Situação</th>
				    	<th style="width: 122px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php 
				    if (0 < count($historico)) {
						foreach ($historico['funcoes'] as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							
							echo "<tr>";
							
							echo "<td style='display:none'>";
							echo '<option value="'.$h->idFuncao.'">'.$h->nomeFuncao.'</option>';
							echo "</td>";
							
							echo "<td style='display:none'>". $h->idModuloClienteFuncao ."</td>";
							
							echo "<td>". $h->nomeUnidade ." :: ". $h->nomeFuncao ."</td>";
							echo "<td>". $h->nome ."</td>";
							echo "<td>". $h->ordem ."</td>";
							echo "<td style='display:none'>". $h->situacao ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							
							echo "<td>";
							echo "<button class='btn btn-alterar'><i class='icon-list-alt'></i> Alterar</button>";
							echo '<button class="btn btn-remover" type="button" role="'.$h->idModuloClienteFuncao.'"><i class="icon-trash"></i></button>';
							echo "</td>";
							echo "</tr>";
						}
				    }
				    ?>
					
					</tbody></table>
				</div>
				
	    		<div class="line">
	    			<a href="<?php echo base_url('sis_libera_modulos/editar_modulos_cliente/'.$ModuloCliente->idCliente)?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
				
			</div>
			
			<div id="dialog-remove-funcao" title="Deseja remover o registro?" style="display:none">
	        	<form id="form-remove-funcao" action="<?php echo base_url('sis_libera_modulos/remover_funcao_modulo'); ?>" method="post">
	        		<input type="hidden" id="idModuloCliente" name="idModuloCliente" value="<?php if (isset($ModuloCliente->idModuloCliente)) echo $ModuloCliente->idModuloCliente; ?>">
	        		<input type="hidden" id="idModuloClienteFuncao" name="idModuloClienteFuncao">
	        		
	        		<div class="">
	        			Deseja realmente remover esta função?
	        		</div>
	        		<br>
	        		<div id="detail"></div>
	        	</form>
	        </div>			
			
    </div>
</div>
</div>
