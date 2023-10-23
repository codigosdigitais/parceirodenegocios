
<style>
.btn-alterar{width: auto !important;}
.inline-block{display: inline-block;vertical-align: top;}
.line{height: auto !important; padding: 5px 0;width: auto !important;}
input.input-xlarge{width: 256px;}
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
        
        
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Usuários e Permissões</h5>
            </div>
            
            <div class="widget-content">
            	<form class="form-inline" action="" method="get">
            	
            	<div class="line">
            		<div class="inline-block">
    					<label for="nome">Nome</label>
    					<input type="text" id="nome" name="nome" class="input-xlarge" value="<?php echo $this->input->get('nome'); ?>">
		    		</div>
		    		<div class="inline-block">
    					<label for="tipo">Tipo</label>
    					<select id="tipo" name="tipo" class="input-xlarge">
    						<?php if ($this->session->userdata('tipo') == 'SISAdmin') { ?>
    						<option value="SISAdmin" <?php if ($this->input->get('tipo') && $this->input->get('tipo') == 'SISAdmin') echo "selected"; ?>>SISAdmin</option>
    						<?php } ?>
    						<option value="Interno" <?php if (!isset($_GET['tipo']) || $this->input->get('tipo') && $this->input->get('tipo') == 'Interno') echo "selected"; ?>>Interno</option>
    						<option value="Externo" <?php if ($this->input->get('tipo') && $this->input->get('tipo') == 'Externo') echo "selected"; ?>>Externo</option>
    						<option value="" style="background-color: #ddd"></option>
    						<option value="" <?php if (isset($_GET['tipo']) && $this->input->get('tipo') == '') echo "selected"; ?>>Todos</option>
    					</select>
    				</div>
	    		</div>
	    		<div class="line">
	    			<div class="inline-block">
    					<label for="vinculado">Vinculado à</label>
    					<input type="text" id="vinculado" name="vinculado" class="input-xlarge" value="<?php echo $this->input->get('vinculado'); ?>">
		    		</div>
		    		<div class="inline-block">
    					<label for="login">Login</label>
    					<input type="text" id="login" name="login" class="input-xlarge" value="<?php echo $this->input->get('login'); ?>">
	    			</div>
	    		</div>
	    		<div class="line">
	    			<div class="inline-block">
    					<label for="situacao">Situação</label>
    					<select id="situacao" name="situacao" class="input-xlarge">
    						<?php $situacao = isset($_GET['situacao']) ? $this->input->get('situacao') : 1; ?>
    						<option value="1" <?php if ($situacao) echo "selected" ?>>Ativo</option>
    						<option value="0" <?php if(!$situacao) echo "selected" ?>>Inativo</option>
    					</select>
	    			</div>
	    		</div>
	    		<div class="line">
	    			<div class="line" style="padding-left: 130px; padding-bottom: 25px;">
	    				<button class="btn btn-inverse span2"><i class="icon-print icon-white"></i> Filtrar</button>
	    				<a href="<?php echo base_url('sis_usuario'); ?>" class="btn btn-default" style="margin-left: 10px;"><i class="icon-retweet"></i> Limpar filtros</a>
	    			</div>
	    		</div>
	    		</form>
            </div>
            
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Usuários cadastrados</h5>
            </div>
            <div class="widget-content">
		    	
		    	<?php if ($this->permission->canInsert()) { ?>
    			<div class="line">
    				<a href="<?php echo base_url('sis_usuario/usuario_editar'); ?>" class="btn btn-success"><i class="icon-plus icon-white"></i> Novo Usuário</a>
    			</div>
    			<?php } ?>
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered "><thead><tr>
				    	<th>Nome</th>
				    	<th>Tipo</th>
				    	<th>Vínculado à</th>
				    	<th>Login</th>
				    	<th>Situação</th>
				    	<th style="width: 130px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php
				    if ($historico) {
						foreach ($historico as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							
							echo "<tr>";
							echo "<td>". $h->nome ."</td>";
							echo "<td>". $h->tipo ."</td>";
							echo "<td>". $h->vinculo ."</td>";
							echo "<td>". $h->login ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							
							
							echo "<td>";
							echo "<a href='".base_url("sis_usuario/usuario_editar/".$h->idUsuario)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i>Cadastro</a>";
							
							echo "</td>";
							echo "</tr>";
						}
				    }
				    ?>
					
					</tbody></table>
				</div>
				
				
			</div>
    </div>
</div>
</div>
