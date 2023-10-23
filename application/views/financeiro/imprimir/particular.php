<style>
.substituicao-ok { background-color: red; padding: 0px 7px 0px 7px; border-radius: 3px; color: #FFF; height: 22px; width: 12px; }
</style>
<?php
if(!$results){?>

        <div class="widget-box" style="margin-top: -15px;">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Fechamento de Chamadas Particulares - Relatório</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th style="width: 100px;">Qtd. Os</th>
                        <th style="width: 100px;">NF</th>
                        <th style="width: 200px;">Faturado</th>
                        <th style="width: 100px;">Valor</th>
                        <th style="width: 40px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Não foi possível encontrar nenhuma chamada na data espeficada.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else {
?>
<div class="widget-box" style="margin-top: -15px;">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Fechamento de Chamadas Particulares - Relatório</h5>
        <div class="buttons">
       		<a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
        </div>
     </div>
     
     <?
	 	// total de ordems registradas
	 	$total_ordem = 0;
		$total_empresa = 0;
		$total_funcionario = 0;
		$i=0;
		
	 	foreach($results as $contagem){
			$total_ordem += $contagem->total_lista;
			foreach($results[$i]->lista_particular as $valores){ 
				$total_empresa += $valores->valor_empresa;
				$total_funcionario += $valores->valor_funcionario;
			}
			$i++;
		}
		
	 ?>

<div class="widget-content nopadding">
        <div class="span12" style="padding: 10px;">
            <div class="span3">
                <label for="">Data Inicial:</label>
                <input type="date" name="dataInicial" class="span12" disabled value="<? if(isset($_GET['data_inicial'])){ echo $_GET['data_inicial']; } ?>" />
            </div>
            <div class="span3">
                <label for="">Data Final:</label>
                <input type="date" name="dataFinal" class="span12" disabled value="<? if(isset($_GET['data_final'])){ echo $_GET['data_final']; } ?>" />
            </div>
			
            <div class="span2">
                <label for="">Total de Ordens</label>
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $total_ordem;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Empresa</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_empresa, 2, ',', '.'); ?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Funcionário</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_funcionario, 2, ',', '.'); ?> </button>
            </div>
           
        </div>
        
      
        
                <table class="table">
                	<?
						$i=-1;
						foreach($results as $valor){
					?>
                	<tr>
                    	<td style=" background-color: #CCCCCC; padding: 8px; border-top: 1px #513B3C solid" colspan="9"><strong><? echo $valor->nome_funcionario; ?></strong></td>
                    </tr>
                    <tr style="background-color: #EDEDED;">
                        <th style="width: 50px;">Chamada</th>
                        <th style="width: 70px;">Data</th>
                        <th style="width: 50px;">Pontos</th>
                        <th>Solicitante</th>
                        <th style="width: 50px;">HR. CH.</th>
                        <th style="width: 50px;">HR. RE.</th>
                        <th>Funcionário</th>
                        <th style="width: 110px;">Valor Empresa</th>
                        <th style="width: 110px;">Valor Funcionário</th>
                    </tr>
						<?
							$i++;
							$total_empresa_lista = 0;
							$total_funcionario_lista = 0;
                            foreach($results[$i]->lista_particular as $valor_particular){ 
								$total_empresa_lista += $valor_particular->valor_empresa;
								$total_funcionario_lista += $valor_particular->valor_funcionario;
								echo '<tr>';
									echo '<td><center>'.$valor_particular->idChamada.'</center></td>';
									echo '<td>'.date('d/m/Y', strtotime($valor_particular->data)).'</td>';
									echo '<td>'.$valor_particular->pontos.'</td>';
									echo '<td>'.$valor_particular->nome_solicitante.'</td>';
									echo '<td>'.$valor_particular->hora.'</td>';
									echo '<td>'.$valor_particular->hora_repasse.'</td>';
									echo '<td>'.$valor->nome_funcionario.'</td>';
									echo '<td>R$ '.number_format($valor_particular->valor_empresa, 2, ",", ".").'</td>';
									echo '<td>R$ '.number_format($valor_particular->valor_funcionario, 2, ",", ".").'</td>';
								echo '</tr>';
							}
						 ?>
                	<tr>
                        <td style=" background-color: #FFFFFF; padding: 8px; border-top: 1px #CCCCCC solid; text-align: right" colspan="9">
                            <div class="span8">
                            </div>
                            <div class="span2">                            
                            	<button class="btn btn-primary span12"> Empresa: R$ <? echo number_format($total_empresa_lista, 2, ',', '.'); ?> </button>
                            </div>
							<div class="span2">                            
                            	<button class="btn btn-primary span12"> Funcionário: R$ <? echo number_format($total_funcionario_lista, 2, ',', '.'); ?> </button>
                            </div>
                        </td>
                    </tr>
					<? } ?>
                    
                    	
                </table>



</div>
</div>

<div style="display: none; padding-top: 0px;" id="printView">

<style>
.table th, .table td {
    padding: 6px;
    line-height: 5px;
    text-align: left;
    vertical-align: top;
    border-top: 0px solid #ddd;
	font-size: 11px
}
</style>

<table style="text-align: center;">

    <thead>
        <tr>
        	<td>
            	<center><img src="<? echo base_url('assets/img/logo_empresa.jpg'); ?>"></center>
            </td>
            <!--
            <td>
            	<span>
                    <h5><? echo $results[0]->nome_cedente; ?> </h5>
                    <h6>RUA GASTÃO LUIZ CRULS, 1910 - BAIRRO ALTO</h6>
                    <h6>CURITIBA - PARANÁ</h6>
                    <h6>(41) 3367-6167 - WWW.JCENTREGASRAPIDAS.COM.BR</h6>
                </span>
            </td>
            --->
        </tr>
    </thead>
</table>

                <table class="table">
                	<?
						$i=-1;
						foreach($results as $valor){
					?>
                	<tr>
                    	<td style=" background-color: #CCCCCC; padding: 8px; border-top: 1px #513B3C solid" colspan="9"><strong><? echo $valor->nome_funcionario; ?></strong></td>
                    </tr>
                    <tr style="background-color: #EDEDED;">
                        <th style="width: 50px;">Chamada</th>
                        <th style="width: 70px;">Data</th>
                        <th style="width: 50px;">Pontos</th>
                        <th>Solicitante</th>
                        <th style="width: 50px;">HR. CH.</th>
                        <th style="width: 50px;">HR. RE.</th>
                        <th>Funcionário</th>
                        <th style="width: 110px;">Valor Empresa</th>
                        <th style="width: 110px;">Valor Funcionário</th>
                    </tr>
						<?
							$i++;
							$total_empresa_lista = 0;
							$total_funcionario_lista = 0;
                            foreach($results[$i]->lista_particular as $valor_particular){ 
								$total_empresa_lista += $valor_particular->valor_empresa;
								$total_funcionario_lista += $valor_particular->valor_funcionario;
								echo '<tr>';
									echo '<td><center>'.$valor_particular->idChamada.'</center></td>';
									echo '<td>'.date('d/m/Y', strtotime($valor_particular->data)).'</td>';
									echo '<td>'.$valor_particular->pontos.'</td>';
									echo '<td>'.$valor_particular->nome_solicitante.'</td>';
									echo '<td>'.$valor_particular->hora.'</td>';
									echo '<td>'.$valor_particular->hora_repasse.'</td>';
									echo '<td>'.$valor->nome_funcionario.'</td>';
									echo '<td>R$ '.number_format($valor_particular->valor_empresa, 2, ",", ".").'</td>';
									echo '<td>R$ '.number_format($valor_particular->valor_funcionario, 2, ",", ".").'</td>';
								echo '</tr>';
							}
						 ?>
                	<tr>
                        <td style=" background-color: #EDEDED; padding: 8px; border-top: 1px #CCCCCC solid; text-align: right; height: 40px; line-height: 25px;" colspan="9">
                             <strong>Total Empresa: R$ <? echo number_format($total_empresa_lista, 2, ',', '.'); ?> </strong><br />
                             <strong>Total Funcionário: R$ <? echo number_format($total_funcionario_lista, 2, ',', '.'); ?> </strong>
                        </td>
                    </tr>
					<? } ?>
                    
                    	
                </table>
                
<table class="table table-bordered ">
    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">EXTRATO CONSOLIDADO</td>
        </tr>    
    </thead>
    <tbody>
        <tr>
            <th>TOTAL CHAMADAS</th>
            <th>TOTAL DA EMPRESA</th>
            <th>TOTAL DOS FUNCIONÁRIOS</th>
        <tr>
        
        <tr>
            <th><? echo $total_ordem; ?> Registros</th>
            <th>R$ <? echo number_format($total_empresa, 2, ",", "."); ?></th>
            <th>R$ <? echo number_format($total_funcionario, 2, ",", "."); ?></th>
        <tr>
    </tbody>
</table>
<table class="table table-bordered">
	<tr>
    	<td style="text-align: center; line-height: 30px;">
        	Relatório gerado em <? echo date("d/m/Y - H:i:s"); ?> - Entregas Rápidas - Controller<br>
            RUA GASTÃO LUIZ CRULS, 1910 - BAIRRO ALTO - CURITIBA - PARANÁ
            (41) 3367-6167 - WWW.JCENTREGASRAPIDAS.COM.BR
       </td>
    </tr>
</table>

</div>







<? } ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#imprimir").click(function(){         
            PrintElem('#printView');
        })

        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'Entregas Rápidas - Controller', 'height=600,width=900');
            mywindow.document.write('<html><head><title>Entregas Rápidas - Controller</title>');
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
            mywindow.document.write("</head><body>");
			mywindow.document.write("<div style='background-color: #FFFFFF; padding: 20px'>");
			mywindow.document.write("<style>table,td,tr { font-family: arial; font-size: 12px; } </style>");
            mywindow.document.write(data);
			mywindow.document.write('</div>');
            
            mywindow.document.write("</body></html>");


            return true;
        }

    });
</script>

