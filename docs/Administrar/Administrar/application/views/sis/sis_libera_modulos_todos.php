<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Parceiros e Liberação de Módulos</h5>
            </div>
            <div class="widget-content">
		    	
    			<div class="line">
    				<a href="<?php echo base_url('administrando/clientesAdicionar'); ?>" class="btn btn-success"><i class="icon-plus icon-white"></i> Novo Parceiro de Negócios</a>
    			</div>
    			
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered "><thead><tr>
				    	<th>ID</th>
				    	<th>Nome de Fantasia</th>
				    	<th>CNPJ</th>
				    	<th>Telefone</th>
				    	<th>E-mail</th>
				    	<th>Responsável</th>
				    	<th>Localização</th>
				    	<th>Situação</th>
				    	<th style="width: 225px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php 
				    if (0 < count($historico)) {
						foreach ($historico as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							
							echo "<tr>";
							echo "<td>". $h->idCliente ."</td>";
							echo "<td>". $h->nomefantasia ."</td>";
							echo "<td>". $h->cnpj ."</td>";
							echo "<td>". $h->responsavel_telefone_ddd ." ". $h->responsavel_telefone ."</td>";
							echo "<td>". $h->email ."</td>";
							echo "<td>". $h->responsavel ."</td>";
							echo "<td>". $h->endereco_cidade ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							
							
							echo "<td>";
							echo "<a href='".base_url("administrando/clientesEditar/".$h->idCliente)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i>Cadastro</a>";
							
							echo "<a href='".base_url("sis_libera_modulos/editar_modulos_cliente/".$h->idCliente)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i>Módulos</a>";
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
