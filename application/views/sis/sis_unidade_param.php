
<?php 
if ($historico) $Funcao = array_shift($historico);
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tipoParametro').change(function(){

			$('#form-parametros .div-tipos').appendTo('#div-tipos-wrap').hide();
			
			var role = $('#tipoParametro :selected').attr('role');

			if ($(role)) {
				$(role).appendTo('#form-parametros').show();
			}
		});

		$('#btn-add-array').click(function(){
			 
			if ( $('#arrCodigo').val() != "" && $('#arrValor').val() != "" ) {

				var linha = "<tr><td>";
					linha += $('#arrCodigo').val();
					linha += '<input type="text" name="arrCodigos[]" value="'+ $('#arrCodigo').val() +'">';
	
					linha += "</td><td>";
					linha += $('#arrValor').val();
					linha += '<input type="text" name="arrValores[]" value="'+ $('#arrValor').val() +'">';

					linha += "</td><td>";
					linha += "<div class='remove-line'>X</div>";
					linha += "</td></tr>";
					
				$('#table-array-values').append(linha);

				$('#table-array-values .remove-line').unbind('click').click(function(){
					$(this).parent().parent().remove();
				});
				
				$('#arrCodigo').val('');
				$('#arrValor').val('');
			}
		});

		$('#nomeParametro').keyup(function(){
			var str = $(this).val();
				str = str.replace(/[^a-z0-9_]/gi,'');
			//$('#nomeAcessoParametro').html( "<span>String:</span> " + str );
			$('#stringParametro').val(str);
		});
	});
</script>

<style>
	input, select{margin-right: 10px;}
	input[type="text"]{margin-bottom: 0;}
	.btn{padding: 5px 10px;width: 90px;}
	fieldset{margin-bottom: 15px;}
	.info-controller{font-size: 16px;color: #696969;}
	.inline-bloc{display: inline-block;vertical-align: top;}
	.div-line-space{margin: 20px 0;}
	.div-tipos{display: none;}
	#div-array-values input{display: none; }
	.line{height: auto !important;min-height: auto !important;max-height: none !important;}
	#div-array-values{margin: 5px 10px;}
	#div-array-values td{padding: 0 5px;}
	.remove-line{margin-left: 20px;cursor: pointer;font-weight: bold;padding: 0px 4px;}
	.remove-line:hover{background-color: #E6F3FF;}
	#nomeAcessoParametro{display: block;margin: 0 0 0 5px;}
	#nomeAcessoParametro span{color: #797979;}
	.bloc-btns{margin-top: 25px;}
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Parâmetros</h5>
            </div>
            
            <div class="widget-content">
            
	            <fieldset>
	            	<legend>
		            	<?php echo $Funcao->nomeUnidade ." :: ". $Funcao->nome; ?>
		            	<div class="info-controller"><?php echo "Controller: " . $Funcao->controller; ?></div>
	            	</legend>
	            </fieldset>
	            
	    		<fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Cadastro de Parâmetros
	            	</legend>
	            	
	    			<form id="form-parametros" action="<?php echo base_url('sis_unidade/gravar_parametro'); ?>" method="post">
	    				<input type="hidden" id="idFuncao" name="idFuncao" value="<?php if (isset($Funcao->idFuncao)) echo $Funcao->idFuncao; ?>">
	    				
		    			<div class="inline-bloc">
		    				<label for="nomeParametro">Nome do Parâmetro</label>
		    				<input class="" type="text" id="nomeParametro" name="nomeParametro" maxlength="60" minlength="3" placeholder="Nome do Parâmetro" required="required">
		    				
						</div>
						<div class="inline-bloc">
							<label for="tipoParametro">Tipo</label>
		    				<select id="tipoParametro" name="tipoParametro" class="input-large" required="required">
		    					<option value="VF">Verdadeiro e Falso</option>
		    					<option value="texto" role="#div-tipo-texto">Texto</option>
		    					<option value="inteiro" role="#div-tipo-inteiro">Num. Inteiro</option>
		    					<option value="real" role="#div-tipo-real">Num. Real</option>
		    					<option value="faixaInteiro" role="#div-tipo-faixa-inteiro">Faixa Num. Inteiros</option>
		    					<option value="faixaReal" role="#div-tipo-faixa-real">Faixa Num. Reais</option>
		    					<option value="array" role="#div-tipo-array">Conjunto /Array</option>
		    				</select>
		    			</div>
						<div class="inline-bloc">
							<label for="acessivel">Acesso</label>
		    				<select id="acessivel" name="acessivel" class="input-medium" required="required">
		    					<option value="SISAdmin">SIS Admin</option>
		    					<option value="Perfil">Perfil</option>
		    					<option value="Usuario">Usuário</option>
		    				</select>
		    			</div>
		    			<div class="inline-bloc bloc-btns">
		    				<button id="btn-gravar-funcao" type="submit" class="btn btn-primary"><i class="icon-plus icon-white"></i> Inserir</button>
		    				<button id="btn-limpar-funcao" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Limpar</button>
		    			</div>
		    			
		    			<br>
		    			<div class="line">
		    				<label for="stringParametro" style="font-size: 13px;color: #898989;margin-top: 5px;">String de acesso no código fonte</label>
		    				<input type="text" id="stringParametro" name="stringParametro" maxlength="60" minlength="3" required="required">
		    			</div>
		    			
		    			<div class="div-line-space"></div>
		    			
		    		</form>
		    		
		    		<div id="div-tipos-wrap">
		    			<div id="div-tipo-texto" class="line div-tipos">
		    				<label for="valPadrao">Valor padrão</label>
		    				<input class="" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
		    			</div>
		    			
		    			<div id="div-tipo-inteiro" class="line div-tipos">
		    				<label for="valPadrao">Valor padrão</label>
		    				<input class="mascara_numero_sem_decimal" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
		    			</div>
		    			
		    			<div id="div-tipo-real" class="line div-tipos">
		    				<label for="valPadrao">Valor padrão</label>
		    				<input class="mascara_float_3_digitos" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
		    			</div>
		    			
		    			<div id="div-tipo-faixa-inteiro" class="line div-tipos">
		    				<div class="inline-bloc">
			    				<label for="valInicial">Valor Inicial</label>
			    				<input class="mascara_numero_sem_decimal input-small" type="text" id="valInicial" name="valInicial" maxlength="60" placeholder="Informe valor">
			    			</div>
			    			<div class="inline-bloc">
			    				<label for="valFinal">Valor Final</label>
			    				<input class="mascara_numero_sem_decimal input-small" type="text" id="valFinal" name="valFinal" maxlength="60" placeholder="Informe valor">
		    				</div>
		    				<div class="inline-bloc">
			    				<label for="valPadrao">Valor padrão</label>
			    				<input class="mascara_numero_sem_decimal input-large" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
		    				</div>
		    			</div>
		    			
		    			<div id="div-tipo-faixa-real" class="line div-tipos">
		    				<div class="inline-bloc">
			    				<label for="valInicial">Valor Inicial</label>
			    				<input class="mascara_float_3_digitos input-small" type="text" id="valInicial" name="valInicial" maxlength="60" placeholder="Informe valor">
			    			</div>
			    			<div class="inline-bloc">
			    				<label for="valFinal">Valor Final</label>
			    				<input class="mascara_float_3_digitos input-small" type="text" id="valFinal" name="valFinal" maxlength="60" placeholder="Informe valor">
		    				</div>
		    				<div class="inline-bloc">
			    				<label for="valPadrao">Valor padrão</label>
			    				<input class="mascara_float_3_digitos input-large" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
		    				</div>
		    			</div>
		    			
		    			<div id="div-tipo-array" class="line div-tipos">
		    			
			    				<div class="inline-bloc">
				    				<label for="arrCodigo">Código</label>
				    				<input class="input-small mascara_letra_num" type="text" id="arrCodigo" maxlength="10" placeholder="Informe valor">
				    			</div>
				    			<div class="inline-bloc">
				    				<label for="arrValor">Valor</label>
				    				<input class="input-small" type="text" id="arrValor" maxlength="60" placeholder="Informe valor">
			    				</div>
			    				<div class="inline-bloc" style="margin-right: 30px;margin-top: 25px;">
			    					<button id="btn-add-array" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Inserir</button>
			    				</div>
			    				<div class="inline-bloc">
				    				<label for="valPadrao">Valor padrão</label>
				    				<input class="input-large" type="text" id="valPadrao" name="valPadrao" maxlength="60" placeholder="Informe valor padrão">
			    				</div>
		    				
		    				<div class="line" id="div-array-values">
		    					<table id="table-array-values"></table>
		    				</div>
		    			</div>
	    			</div>
	    			
	    		</fieldset>
	    		
    			<div class="line"></div>
		    			
	    		<fieldset>
	            	<legend>
		            	Parâmetros existentes
	            	</legend>
	    			
		    		<div class="table-responsive">
					    <table class="table table-bordered" id="table-controllers"><thead><tr>
					    	<th>ID</th>
					    	<th>Nome</th>
					    	<th>String para acesso</th>
					    	<th>Tipo</th>
					    	<th>Valores</th>
					    	<th>Padrão</th>
					    	<th>Acesso</th>
					    </tr></thead>
					    <tbody>
					    
					    <?php 
					    if ($historico) {
							foreach ($historico['parametros'] as $h) {
								$tipo = "";
								
								switch ($h->tipo) {
									case 'VF' 			: $tipo = 'Verdadeiro e Falso'; break;
									case 'texto' 		: $tipo = 'Texto'; break;
									case 'inteiro' 		: $tipo = 'Num. Inteiro'; break;
									case 'real' 		: $tipo = 'Num. Real'; break;
									case 'faixaInteiro' : $tipo = 'Faixa Num. Inteiros'; break;
									case 'faixaReal' 	: $tipo = 'Faixa Num. Reais'; break;
									case 'array' 		: $tipo = 'Conjunto /Array'; break;
								}
								
								$valor = ($h->valor != '') ? json_encode( unserialize($h->valor) ) : '';
								$valor = str_replace('","', '", "', $valor);
								
								echo "<tr>";
								echo "<td>". $h->idFuncaoParam ."</td>";
								echo "<td>". $h->nome ."</td>";
								echo "<td>". $h->string ."</td>";
								echo "<td>". $tipo ."</td>";
								echo "<td>". $valor ."</td>";
								echo "<td>". $h->padrao ."</td>";
								echo "<td>". $h->acesso ."</td>";
								echo "</tr>";
							}
					    }
					    ?>
						
						</tbody></table>
					</div>
	    		</fieldset>
	    		
	    		<div class="line">
	    			<a href="<?php echo base_url('sis_unidade/editarunidade/' . $Funcao->idUnidade)?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
	            
	    	</div>
    </div>
</div>
</div>
