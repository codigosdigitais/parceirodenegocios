
<?php 
if ($historico) $Usuario = array_shift($historico);
?>

<script type="text/javascript">
	var optionsTemp;
	
	$(document).ready(function(){

		$('form').submit(function(){
			if ( !$(this).valid() ) {
				event.preventDefault();
			}
		});

		$('#idFuncionario').change(function(){
			$('#nome').val( $(this).find('option:selected').text() );
		});

		$('#senha').change(function(){
			if ( $(this).val() != "" ) {
				$('#conf_senha').prop('required', true);
			}
			else {
				$('#conf_senha').prop('required', false);
			}
		});

		$('#tipo').change(function(){
			var tipo = $(this).val();
			
			if (tipo == 'Externo') {
				$('#line-idFuncionario').css('opacity', 0.5);
				$('#line-idCliente').css('opacity', 1);
				$('#line-idCliente select').prop('disabled', false).trigger("chosen:updated");
				$('#line-idFuncionario select').prop('disabled', true).trigger("chosen:updated");
			}
			else if (tipo == 'Interno') {
				$('#line-idCliente').css('opacity', 0.5);
				$('#line-idFuncionario').css('opacity', 1);
				$('#line-idCliente select').prop('disabled', true).trigger("chosen:updated");
				$('#line-idFuncionario select').prop('disabled', false).trigger("chosen:updated");
			}
			else if (tipo == 'SISAdmin') {
				$('#line-idFuncionario, #line-idCliente').css('opacity', 1);
				$('#line-idCliente select').prop('disabled', false).trigger("chosen:updated");
				$('#line-idFuncionario select').prop('disabled', false).trigger("chosen:updated");
			}
		});

		$('#tipo').trigger('change');

		$('#idFuncionario, #idCliente').chosen({allow_single_deselect: true});



		$('.btn-remover-form').click(function() {

			var idUsuario = $('#form-usuario #idUsuario').val();
			//var idUsuario = $(this).attr('role');
			//var info = $(this).parent().parent().find('td').eq(2).html();
			
			$('#form-remove-usuario #idUsuario').val(idUsuario);
			//$('#form-remove-usuario #detail').html(info);
			
			$( "#dialog-remove-usuario" ).dialog( "open" );
		});
		
		$( "#dialog-remove-usuario" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Remover": {
				text: 'Remover Usuário',
				click: function() {
					$(".ui-dialog-buttonpane button:contains('Remover Usuário')").attr("disabled", true).addClass("ui-state-disabled");
					$('#form-remove-usuario').submit();
				}
			},
			"Retornar": function() {
				$('#form-remove-usuario #idUsuario').val('');
				$( this ).dialog( "close" );
			}
		  }
		});


		$('#table-perfis .btn-remover').click(function() {

			var idUsuarioPerfil = $(this).attr('role');
			var info = $(this).parent().parent().find('td').eq(3).html();

			$('#form-remove-perfil #idUsuarioPerfil').val(idUsuarioPerfil);
			$('#form-remove-perfil #detail span').html(info);
			
			$( "#dialog-remove-perfil" ).dialog( "open" );
		});

		$( "#dialog-remove-perfil" ).dialog({
		  autoOpen: false,
		  modal: true,
		  width: 500,
		  heigth: 500,
		  buttons: {
			"Remover": {
				text: 'Remover Perfil',
				click: function() {
					$(".ui-dialog-buttonpane button:contains('Remover Perfil')").attr("disabled", true).addClass("ui-state-disabled");
					$('#form-remove-perfil').submit();
				}
			},
			"Retornar": function() {
				$('#form-remove-perfil #idUsuarioPerfil').val('');
				$( this ).dialog( "close" );
			}
		  }
		});
		


		$('#table-perfis .btn-alterar').click(function(){
			optionsTemp = $('#form-perfil #idPerfil').html();
			
			var newOptions 		= $(this).parent().parent().find('td').eq(0).html();
			var idUsuarioPerfil = $(this).parent().parent().find('td').eq(1).html();
			var situacao 		= $(this).parent().parent().find('td').eq(2).html();
			
			$('#form-perfil #idPerfil').html(newOptions);
			$('#form-perfil #idUsuarioPerfil').val(idUsuarioPerfil);
			$('#form-perfil #situacao').val(situacao);

			$('#form-perfil #btn-gravar-perfil').html( '<i class="icon-ok icon-white"></i> Salvar' );
			$('#form-perfil #btn-limpar-perfil').show();
			
		});

		$('#btn-limpar-perfil').click(function(){
			$('#form-perfil #idPerfil').html(optionsTemp);
			$('#form-perfil #idUsuarioPerfil').val('');
			$('#form-perfil select').val(1);
			$('#form-perfil #btn-gravar-perfil').html( '<i class="icon-plus icon-white"></i> Inserir' );
			$(this).hide();
		});
	});
</script>

<style>
	input, select, .chosen-container{margin-right: 15px;}
	input[type="text"]{margin-bottom: 0;}
	.btn{padding: 5px 10px;width: 90px;}
	fieldset{margin-bottom: 15px;}
	#btn-limpar-perfil{display: none;}
	.inline-bloc{display: inline-block;vertical-align: top;}
	.bloc-btns{margin-top: 25px;}
	.line{height: auto !important; padding: 5px 0;width: auto !important;}
	.select-xlarge{width: 284px !important;}
	.input-medium{width: 177px;}
	.input-small2{width: 118px;}
</style>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Usuário e Perfil</h5>
            </div>
            <div class="widget-content">
		    	
	            <fieldset>
	            	<legend>
		            	Cadastro de Usuário
	            	</legend>
	            </fieldset>
	            
	            <fieldset>
	            
	    			<form id="form-usuario" action="<?php echo base_url('sis_usuario/gravar_usuario'); ?>" method="post">
	    			<input type="hidden" id=idUsuario name="idUsuario" value="<?php if (isset($Usuario->idUsuario)) echo $Usuario->idUsuario; ?>">
	    			
	    				<div class="line">
	    					<div class="inline-bloc">
		    					<label for="nome">Nome</label>
		    					<input type="text" id="nome" name="nome" class="input-xlarge" value="<?php if (isset($Usuario->nome)) echo $Usuario->nome; ?>" required="required">
		    				</div>
		    				
	    					<div class="inline-bloc">
		    					<label for="tipo">Tipo</label>
			    				<select id="tipo" name="tipo" class="input-medium" required="required">
			    					<?php if ($this->session->userdata('tipo') == 'SISAdmin') { ?>
			    					<option value="SISAdmin" <?php if (isset($Usuario->tipo) && $Usuario->tipo == 'SISAdmin') echo "selected"; ?>>SISADmin</option>
			    					<?php } ?>
			    					<option value="Interno" <?php if (isset($Usuario->tipo) && $Usuario->tipo == 'Interno') echo "selected"; ?>>Interno</option>
			    					<option value="Externo" <?php if (isset($Usuario->tipo) && $Usuario->tipo == 'Externo') echo "selected"; ?>>Externo</option>
			    				</select> 
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="situacao">Situação</label>
			    				<select id="situacao" name="situacao" class="input-small" required="required">
			    					<option value="1" <?php if (isset($Usuario->situacao) && $Usuario->situacao) echo "selected"; ?>>Ativo</option>
			    					<option value="0" <?php if (isset($Usuario->situacao) && !$Usuario->situacao) echo "selected"; ?>>Inativo</option>
			    				</select>
		    				</div>
			    		</div>
			    		
			    		<div class="line">
	    					<div class="inline-bloc" id="line-idFuncionario" style="opacity: <?php if (isset($Usuario->tipo) && $Usuario->tipo != 'Externo') echo "1"; else echo "0"; ?>;">
		    					<label for="idFuncionario">Vinculado ao Funcionário</label>
			    				<select id="idFuncionario" name="idFuncionario" class="select-xlarge">
			    					<option value=""></option>
			    					<?php 
			    					if (($funcionarios)) {
			    						foreach ($funcionarios as $f) {
			    							echo "<option value='".$f->idFuncionario."' ";
			    							
			    							if (isset($Usuario->idFuncionario) && $Usuario->idFuncionario == $f->idFuncionario) echo "selected";
			    							
			    							echo ">".$f->nome."</option>";
			    						}
			    					}
			    					?>
			    				</select> 
		    				</div>
			    		
	    					<div class="inline-bloc" id="line-idCliente" style="opacity: <?php if (isset($Usuario->tipo) && $Usuario->tipo != 'Interno') echo "1"; else echo "0"; ?>;">
		    					<label for="idCliente">Vinculado ao Cliente</label>
			    				<select id="idCliente" name="idCliente" class="select-xlarge" required="required">
			    					<option value=""></option>
			    					<?php 
			    					if (($clientes)) {
			    						foreach ($clientes as $f) {
			    							echo "<option value='".$f->idCliente."' ";
			    							
			    							if (isset($Usuario->idCliente) && $Usuario->idCliente == $f->idCliente) echo "selected";
			    							
			    							echo ">".$f->nomefantasia."</option>";
			    						}
			    					}
			    					?>
			    				</select> 
		    				</div>
			    		</div>
			    		<div class="line">
	    					<div class="inline-bloc">
		    					<label for="login">Usuário</label>
		    					<input type="text" id="login" name="login" class="input-xlarge mascara_letra_num_traco_arroba_ponto" value="<?php if (isset($Usuario->login)) echo $Usuario->login; ?>" required="required" minlength="5" maxlength="60">
		    				</div>
		    				
	    					<div class="inline-bloc">
		    					<label for="senha">Senha</label>
		    					<input type="password" id="senha" name="senha" class="input-small2" minlength="6" maxlength="30">
		    				</div>
		    				
	    					<div class="inline-bloc">
		    					<label for="conf_senha">Confirma senha</label>
		    					<input type="password" id="conf_senha" name="conf_senha" class="input-small2" minlength="6" maxlength="30">
		    				</div>
		    			</div>
			    		
		    			<div class="line">
		    				<div class="inline-bloc bloc-btns">
		    					<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Gravar</button>
		    					<button type="button" class="btn btn-remover-form"><i class="icon-ok icon-white"></i> Remover</button>
		    					<a href="<?php echo base_url('sis_usuario')?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
		    				</div>
		    			</div>
		    		</form>
	            </fieldset>
	            
	            <?php if (isset($Usuario)) { ?>
	            <fieldset>
	            	<legend>
		            	<i class="icon-plus icon-title"></i> Vincular Perfil
	            	</legend>
	            	
	    			<div class="line">
	    			
	    				<form id="form-perfil" action="<?php echo base_url('sis_usuario/gravar_perfil'); ?>" method="post">
	    					<input type="hidden" id="idUsuario" name="idUsuario" value="<?php if (isset($Usuario->idUsuario)) echo $Usuario->idUsuario; ?>">
	    					<input type="hidden" id="idUsuarioPerfil" name="idUsuarioPerfil">
	    					
	    					<div class="inline-bloc">
		    					<label for="idPerfil">Perfil</label>
			    				<select id="idPerfil" name="idPerfil" class="input-xlarge" required="required">
			    					<option></option>
			    					<?php 
			    					if (($perfisDisponiveis)) {
			    						foreach ($perfisDisponiveis as $p) {
			    							echo "<option value='".$p->idPerfil."'>".$p->nome."</option>";
			    						}
			    					}
			    					?>
			    				</select> 
		    				</div>
		    				<div class="inline-bloc">
		    					<label for="situacao">Situação</label>
			    				<select id="situacao" name="situacao" class="input-small" required="required">
			    					<option value="1">Ativo</option>
			    					<option value="0">Inativo</option>
			    				</select>
		    				</div>
		    				<div class="inline-bloc bloc-btns">
		    					<button id="btn-gravar-perfil" type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Incluir</button>
		    					<button id="btn-limpar-perfil" type="button" class="btn btn-default"><i class="icon-plus icon-white"></i> Limpar</button>
		    				</div>
	    				</form>
	    			</div>
	            </fieldset>
	            
	            <div class="line"></div>
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered" id="table-perfis"><thead><tr>
				    	<th>Perfil</th>
				    	<th>Situação</th>
				    	<th style="width: 124px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php 
				    if (($perfisVinculados)) {
				    	//$first = true;
				    	$atual = "";
						foreach ($perfisVinculados as $p) {
							$situacaoPerfil = ($p->sitPerfil) ? "Ativo" : "Inativo";
							
							if ($atual != $p->idUsuarioPerfil) {
								
								echo "<tr>";
								echo "<td style='display:none;'><option value='".$p->idPerfil."'>".$p->nomePerfil."</option></td>";
								echo "<td style='display:none;'>". $p->idUsuarioPerfil."</td>";
								echo "<td style='display:none;'>". $p->sitPerfil."</td>";
								echo "<td>". $p->nomePerfil ."</td>";
								echo "<td>". $situacaoPerfil ."</td>";
								
								echo "<td>";
								echo "<button class='btn btn-alterar'><i class='icon-list-alt'></i> Alterar</button>";
								echo "<button class='btn btn-remover' role='".$p->idUsuarioPerfil."'><i class='icon-trash'></i></button>";
								echo "</td>";
								echo "</tr>";
								
								$atual = $p->idUsuarioPerfil;
							}
							/*
							echo "<tr>";
								echo "<td style='display:none;'>". $p->idModuloClienteFuncao."</td>";
								echo "<td colspan='3'> &raquo ". $p->nomeFuncao ."</td>";
								echo "</tr>";
							echo "</tr>";
							*/
						}
				    }
				    ?>
					
					</tbody></table>
				</div>
				
	    		<div class="line">
	    			<a href="<?php echo base_url('sis_usuario')?>" class="btn" style="margin-left:10px;"><i class="icon-arrow-left"></i> Retornar</a>
	            </div>
	            <?php } ?>
			</div>
    	</div>
    
		<div id="dialog-remove-usuario" title="Deseja remover o registro?" style="display:none">
        	<form id="form-remove-usuario" action="<?php echo base_url('sis_usuario/remover_usuario'); ?>" method="post">
        		<input type="hidden" id="idUsuario" name="idUsuario" value="<?php if (isset($Usuario->idUsuario)) echo $Usuario->idUsuario; ?>">
        		<div class="">
        			Deseja realmente remover este usuário?
        		</div>
        		<br>
        		<div id="detail"><?php if (isset($Usuario->nome)) echo $Usuario->nome; ?></div>
        	</form>
        </div>
        
        <div id="dialog-remove-perfil" title="Deseja remover o registro?" style="display:none">
        	<form id="form-remove-perfil" action="<?php echo base_url('sis_usuario/remover_perfil'); ?>" method="post">
        		<input type="hidden" id="idUsuario" name="idUsuario" value="<?php if (isset($Usuario->idUsuario)) echo $Usuario->idUsuario; ?>">
        		<input type="hidden" id="idUsuarioPerfil" name="idUsuarioPerfil">
        		<div class="">
        			Deseja remover este perfil do usuário?
        		</div>
        		<br>
        		<div id="detail"><b><?php if (isset($Usuario->nome)) echo $Usuario->nome; ?></b><br> &raquo Perfil: <span></span></div>
        	</form>
        </div>
        
	</div>
</div>
