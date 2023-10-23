<?php if($this->permission->controllerManual('financeiro/folhadepagamento')->canInsert()){ ?>
    <a href="<?php echo base_url();?>financeiro/folhadepagamento/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Configurar novo Parâmetro</a>    
<?php } ?>


    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
	            <i class="icon-user"></i>
            </span>
            <h5>Parâmetros Globais de Folhas de Pagamento</h5>
        </div>
    
            <div class="widget-content">
            	<legend>Parâmetros Globais - Cedente</legend>
				
                <table class="table table-hover">
                    <tr style="background-color: white;">
                        <td style="padding-top: 10px; padding-bottom: 10px;">
                            <strong><?php echo $results->razaosocial; ?> - <?php echo $results->cnpj; ?></strong>   
                        </td>
                        <td>Salário Base</td>
                        <td></td>
                    </tr>
						<?
                            foreach($results->parametros as $valor_parametro){ 
                        ?>
                        <tr>
                            <td><?php echo $valor_parametro->parametro; ?></td>
                            <td>R$ <?php echo number_format($valor_parametro->salario, 2, ',', '.'); ?></td>
                            <td>
                                <?
                                    echo '<a href="'.base_url().'financeiro/folhadepagamento/editar/'.$valor_parametro->idFolhaParametro.'" style="margin-right: 1%" class="btn btn-sm btn-info " title="Editar Configuração"><i class="icon-pencil icon-white"></i></a>';  
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" configuracao="'.$valor_parametro->idFolhaParametro.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Configuração"><i class="icon-trash icon-white"></i></a>';  
                                ?>
                            </td>
                        </tr>
                        <? } ?>
					
                    
                    	
                </table>
                                
            </div>
    </div>