<? 
	/*echo "<pre>";
	print_r($results);
	echo "</pre>";*/
?>
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/geral.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/chosen.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>

<!--- Estrutura Interna --->
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/formularios.css" />


<style>

.table th, .table td {
    padding: 6px;
    line-height: 12px;
    text-align: left;
    vertical-align: top;
    border-top: 0px solid #ddd;
	font-size: 11px;
}

</style>


<div class="row-fluid" style="margin-top:-25px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
               <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Relatório de Clientes</h5>
                <div class="buttons">
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content">
          
                    <table class="table table-bordered">
                    <?
                        foreach($results as $valor){
                    ?>
                        <tr>
                            <td style="text-align:left; background-color: #666; color: #FFF"; colspan="5"><strong><? echo $valor->tipoValor; ?></strong></td>
                        </tr> 
                       

						<? 
						$i = 0;
						foreach($valor->listagem as $valor_lista){
						?>	
						
						<tr style="background-color:#CCC;"><td colspan="5"><? echo $valor_lista->nome_view; ?></td></tr>
	
						<tr style="background-color: #F5F5F5">
                            <td><strong>Parâmetro</strong></td>
                            <td><strong>Data</strong></td>
                            <td><strong>Valor</strong></td>
                            <td><strong>Detalhes</strong></td>
                        </tr>

						
						<? 
						$i++;
						$a=0;
						
						foreach($valor_lista->listagem_interna as $valor_lista_interna){
							
						?>							

						<tr>
                            <td><? echo $valor_lista_interna->idParametro; ?></td>
                            <td><? echo date("d/m/Y", strtotime($valor_lista_interna->data)); ?></td>
                            <td>R$ <? echo number_format($valor_lista_interna->valor, 2, ",", "."); ?></td>
                            <td width="40%"><? echo $valor_lista_interna->detalhes; ?></td>
                        </tr>
						<? $a++; } ?>
						<? } ?>
						<!---
					<tr>
						<td colspan="5" style="background-color:blue; color:#FFF; text-align:right">
							<? 
								$total_reais = 0;
								foreach($valor->listagem as $somando_valores){
									$total_reais += $somando_valores->valor;
								}
							?>
							<strong>REGISTROS ENCONTRADOS: <? echo $i; ?> | TOTAL:  R$ <? echo number_format($total_reais, 2, ",", "."); ?></strong>
						</td>
					</tr>--->
                        	
                    <? 
                        } 
                    ?>
					<!---
					<tr>
						<td colspan="5" style="background-color:red; color:#FFF; text-align:right">
							<? 
								$total_reais = 0;
								foreach($valor->listagem as $somando_valores){
									$total_reais += $somando_valores->valor;
								}
							?>
							<strong>REGISTROS ENCONTRADOS: <? echo $i; ?> | TOTAL:  R$ <? echo number_format($total_reais, 2, ",", "."); ?></strong>
						</td>
					</tr>-->
                    </table>
            </div>
        </div>
    </div>
</div>
