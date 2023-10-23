<?php 
if ($historico) $Funcao = array_shift($historico);
?>

<script type="text/javascript">
	$(document).ready(function(){

		$('form').submit(function(){
			if ( !$(this).valid() ) {
				event.preventDefault();
			}
		});
		
		$('.btn-alterar-funcao').click(function(){
			$('#form-funcao #idFuncao').val( $(this).parent().parent().find('td').eq(0).html() );
			$('#form-funcao #nomeFuncao').val( $(this).parent().parent().find('td').eq(1).html() );
			$('#form-funcao #controller').val( $(this).parent().parent().find('td').eq(2).html() );
			$('#form-funcao #tipo').val( $(this).parent().parent().find('td').eq(4).html() );
			$('#form-funcao #situacaoFuncao').val( $(this).parent().parent().find('td').eq(3).html() );
			$('#form-funcao #btn-gravar-funcao').html( '<i class="icon-ok icon-white"></i> Salvar' );
			$('#form-funcao #btn-limpar-funcao').show();
		});

		$('#btn-limpar-funcao').click(function(){
			$('#form-funcao input').val('');
			$('#form-funcao select').val(1);
			$('#form-funcao #btn-gravar-funcao').html( '<i class="icon-plus icon-white"></i> Inserir' );
			$(this).hide();
		});
	});
</script>

<style>
	input, select{margin-right: 15px;}
	input[type="text"]{margin-bottom: 0;}
	.btn{padding: 5px 10px;width: 90px;}
	fieldset{margin-bottom: 15px;}
	#btn-limpar-funcao{display: none;}
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Funções e Parâmetros</h5>
            </div>
            
            <div class="widget-content">
	            <fieldset>
	            	<legend>
		            	Unidade Organizacional
	            	</legend>
	    			<div class="line">
	    			
	    				<form id="form-unidade" action="<?php echo base_url('sis_unidade/gravar_unidade'); ?>" method="post">
	    					<input type="hidden" id="idUnidade" name="idUnidade" value="<?php if (isset($Funcao->idUnidade)) echo $Funcao->idUnidade; ?>">
		    				<label for="nomeUnidade"></label>
		    				<input type="text" id="nomeUnidade" name="nomeUnidade" maxlength="60" minlength="3" placeholder="Unidade organizacional" value="<?php if (isset($Funcao->nome)) echo $Funcao->nome; ?>" required="required"> 
		    				<select id="situacaoUnidade" name="situacaoUnidade" class="input-small" required="required">
		    					<option value="1" <?php if (isset($Funcao->situacao) && $Funcao->situacao) echo "selected"; ?>>Ativo</option>
		    					<option value="0" <?php if (isset($Funcao->situacao) && !$Funcao->situacao) echo "selected"; ?>>Inativo</option>
		    				</select>
		    				
		    				<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Salvar</button>
	    				</form>
	    			</div>
	            </fieldset>
	            
	            <?php if (isset($Funcao->idUnidade)) { ?>
	    		<fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Inserir nova função
	            	</legend>
	            	
	    			<form id="form-funcao" action="<?php echo base_url('sis_unidade/gravar_funcao'); ?>" method="post">
	    				<input type="hidden" id="idFuncao" name="idFuncao">
	    				<input type="hidden" id="idUnidade" name="idUnidade" value="<?php if (isset($Funcao->idUnidade)) echo $Funcao->idUnidade; ?>">
		    			<div class="line">
		    				<label for="nomeFuncao"></label>
		    				<input type="text" id="nomeFuncao" name="nomeFuncao" maxlength="60" minlength="3" placeholder="Função" required="required">
		    			</div>
		    			<div class="line">
		    				<label for="controller"></label>
		    				<input type="text" class="mascara_letra_num_barra" id="controller" name="controller" maxlength="60" minlength="3" placeholder="Controller" required="required">
		    				 
		    				<select id="situacaoFuncao" name="situacaoFuncao" class="input-small" required="required">
		    					<option value="1">Ativo</option>
		    					<option value="0">Inativo</option>
		    				</select>
		    				
		    				<select id="tipo" name="tipo" class="input-medium" required="required">
		    					<?php if ($this->session->userdata('tipo') == 'SISAdmin') { ?>
		    					<option value="SISAdmin">SISADmin</option>
		    					<?php } ?>
		    					<option value="Interno" selected>Interna</option>
		    					<option value="Externo">Externa</option>
		    				</select> 
		    				
		    				<button id="btn-gravar-funcao" type="submit" class="btn btn-primary"><i class="icon-plus icon-white"></i> Inserir</button>
		    				<button id="btn-limpar-funcao" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Limpar</button>
		    			</div>
		    		</form>
	    		</fieldset>
	    		
	    		<fieldset>
	            	<legend>
		            	Funções existentes
	            	</legend>
	    			
		    		<div class="table-responsive">
					    <table class="table table-bordered" id="table-controllers"><thead><tr>
					    	<th>Unidade : Função</th>
					    	<th>Controller</th>
					    	<th>Acesso a função</th>
					    	<th>Situação</th>
					    	<th style="width: 202px;">Ações</th>
					    </tr></thead>
					    <tbody>
					    
					    <?php 
					    if ($historico) {
							foreach ($historico['funcoes'] as $h) {
								$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
								
								echo "<tr>";
								echo "<td style='display:none'>". $h->idFuncao ."</td>";
								echo "<td>". $h->nome ."</td>";
								echo "<td>". $h->controller ."</td>";
								echo "<td style='display:none'>". $h->situacao ."</td>";
								echo "<td>". $h->tipo ."</td>";
								echo "<td>". $situacaoPerfil ."</td>";
								echo "<td>";
								echo '<button class="btn btn-alterar btn-alterar-funcao" type="button">';
								echo '<i class="icon-list-alt"></i>Alterar</button>';

								echo '<a href="'.base_url('sis_unidade/editarparametrosfuncao/'.$h->idFuncao).'" class="btn btn-alterar">';
								echo '<i class="icon-list-alt"></i>Parâmetros</a>';
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
	    			<a href="<?php echo base_url('sis_unidade')?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
	            
	    	</div>
    </div>
</div>
</div>
