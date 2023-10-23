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
    				<a href="<?php echo base_url('sis_perfil/perfilAdicionar'); ?>" class="btn btn-success"><i class="icon-plus icon-white"></i> Novo Perfil</a>
    			</div>
    			
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered "><thead><tr>
				    	<th>Nome</th>
				    	<th>Situação</th>
				    	<th style="width: 100px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php
				    if ($historico) {
						foreach ($historico as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							
							echo "<tr>";
							echo "<td>". $h->nome ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							
							
							echo "<td>";
							echo "<a href='".base_url("sis_perfil/perfilAdicionar/".$h->idPerfil)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i>Funções</a>";
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
