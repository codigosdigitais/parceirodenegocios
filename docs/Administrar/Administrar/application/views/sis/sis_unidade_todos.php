
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Unidades Organizacionais</h5>
            </div>
            <div class="widget-content">
		    	
    			<div class="line">
    				<a href="<?php echo base_url('sis_unidade/editarunidade'); ?>" class="btn btn-success"><i class="icon-plus icon-white"></i> Nova Unidade Organizacional</a>
    			</div>
    			
    			
	    		<div class="table-responsive">
				    <table class="table table-bordered "><thead><tr>
				    	<th>Unidade</th>
				    	<th>Funções</th>
				    	<th>Situação</th>
				    	<th style="width: 99px;">Ações</th>
				    </tr></thead>
				    <tbody>
				    
				    <?php 
				    if ($historico) {
						foreach ($historico as $h) {
							$situacaoPerfil = ($h->situacao) ? "Ativo" : "Inativo";
							$funcoes = "Nenhuma função cadastrada";
							if ($h->totalFuncoes == 1) $funcoes = "1 função cadastrada";
							if ($h->totalFuncoes > 1) $funcoes = $h->totalFuncoes ." funções cadastradas";
							
							echo "<tr>";
							echo "<td>". $h->nome ."</td>";
							echo "<td>". $funcoes ."</td>";
							echo "<td>". $situacaoPerfil ."</td>";
							echo "<td>";
							echo "<a href='".base_url("sis_unidade/editarunidade/".$h->idUnidade)."' class='btn btn-alterar'>";
							echo "<i class='icon-list-alt'></i>Alterar</a>";
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
