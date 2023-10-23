
<?php
if(!$results){?>

        <div class="widget-box" style="margin-top: -15px;">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Fechamento de Chamadas - Relatório</h5>

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
if(!$_GET['view']){
	

?>
<div class="widget-box" style="margin-top: -15px;">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Fechamento de Chamadas - Relatório</h5>
     </div>

<div class="widget-content nopadding">
        <div class="span12" style="padding: 10px;">
            <div class="span2">
                <label for="">Data Inicial:</label>
                <input type="date" name="dataInicial" class="span12" disabled value="<? if(isset($_GET['data_inicial'])){ echo $_GET['data_inicial']; } ?>" />
            </div>
            <div class="span2">
                <label for="">Data Final:</label>
                <input type="date" name="dataFinal" class="span12" disabled value="<? if(isset($_GET['data_final'])){ echo $_GET['data_final']; } ?>" />
            </div>

            <div class="span2">
                <label for="">Total de Ordens</label>
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $results[0]->retorno->totalOs;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Chamadas</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($results[0]->retorno->valorEmpresa, 2, ',', '.'); ?> </button>
            </div>
            
        </div>


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Cliente</th>
            <th style="width: 60px;">Qtd. Os</th>
            <th style="width: 60px;">NF</th>
            <th style="width: 300px;">Faturado</th>
            <th style="width: 100px;">Valor</th>
            <th style="width: 40px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->nomeCliente.'</td>';
				echo '<td>'.$r->totalOs.'</td>';
				echo '<td>'.$r->notaFiscal.'</td>';
				echo '<td>'.$r->nomeFaturado.'</td>';
				echo '<td>R$ '.number_format($r->valorEmpresa, 2, ",", ".").'</td>';
				echo '<td>';
				if($this->permission->controllerManual('financeiro/funcionario')->canSelect()){
                echo '<a href="'.base_url().'fechamentos/fechamentoChamada?idCliente='.$r->idCliente.'&idFuncionario='.$_GET['idFuncionario'].'&data_inicial='.$_GET['data_inicial'].'&data_final='.$_GET['data_final'].'&view=todos" style="margin-right: 1%" class="btn " title="Visualizar Todas"><i class="icon-eye-open"></i></a>'; 
            	}
				echo '</td>';
            echo '</tr>';
        }
		?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php 
} else { 

?>

<div class="widget-box" style="margin-top: -15px;">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5><? echo $results[0]->nome_empresa;?> - <? echo $results[0]->cnpj_empresa;?></h5>
            <div class="buttons">
	            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            </div>
     </div>

<div class="widget-content nopadding">
        <div class="span10" style="padding: 10px;">
        	<?
			$total_total_funcionario=0;
			$total_total_empresa=0;		
            foreach ($results as $r) {
				$total_total_funcionario += $r->valor_funcionario_total;
				$total_total_empresa += $r->valor_empresa_total;
			}
			?>
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
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo count($results); ?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Chamadas</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_total_empresa, 2, ',', '.'); ?> </button>
            </div>
            
        </div>


<table class="table table-bordered ">
    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="8">CHAMADAS VINCULADAS A ESTA EMPRESA</td>
        </tr>    
        <tr>
            <th style="width: 50px;">Chamada</th>
            <th style="width: 50px;">Data</th>
            <th style="width: 30px;">Pontos</th>
            <th>Solicitante</th>
            <th style="width: 50px;">HR. CH.</th>
            <th style="width: 50px;">HR. RE.</th>
            <th>Funcionário</th>
            <th style="width: 75px;">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php
			foreach ($results as $r) {
				echo '<tr>';
					echo '<td><center>'.$r->idChamada.'</center></td>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$r->pontos.'</td>';
					echo '<td>'.$r->nome_solicitante.'</td>';
					echo '<td>'.$r->hora.'</td>';
					echo '<td>'.$r->hora_repasse.'</td>';
					echo '<td>'.$r->nome_funcionario.'</td>';
					echo '<td>R$ '.number_format($r->valor_empresa, 2, ",", ".").'</td>';
				echo '</tr>';
       		}
		?>
        <tr>
            
        </tr>
    </tbody>
</table>

<table class="table table-bordered ">
    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">ADICIONAIS VINCULADOS A ESTA EMPRESA</td>
        </tr>    
        <tr>
            <th style="width: 120px;">Data de Lançamento</th>
            <th style="width: 100px;">Tipo de Vínculo</th>
            <th style="width: 100px;">Valor</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php
		
			$total_credito = "";
			foreach ($results[0]->adicionais_credito as $r) {
				$total_credito += $r->valor;
				$tipoValor = $r->tipoValor;
				if($tipoValor=="C") $tipoValor = "CRÉDITO"; else  $tipoValor = "DÉBITO";
				echo '<tr>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$tipoValor.'</td>';
					echo '<td>R$ '.number_format($r->valor, 2, ",", ".").'</td>';
					echo '<td>'.$r->detalhes.'</td>';
				echo '</tr>';
       		}
			
			if($total_credito){ $total_credito = $total_credito; } else { $total_credito = 0; } 

			?>
             <td style="text-align:right; background-color: #EDEDED; border-bottom: 1px black solid" colspan="4"><strong>TOTAL CRÉDITO R$ <? echo number_format($total_credito, 2, ",", "."); ?></strong></td>
            <?
			$total_debito = "";
			foreach ($results[0]->adicionais_debito as $r) {
				$total_debito += $r->valor;
				$tipoValor = $r->tipoValor;
				if($tipoValor=="C") $tipoValor = "CRÉDITO"; else  $tipoValor = "DÉBITO";
				echo '<tr>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$tipoValor.'</td>';
					echo '<td>R$ '.number_format($r->valor, 2, ",", ".").'</td>';
					echo '<td>'.$r->detalhes.'</td>';
				echo '</tr>';
       		}
			if($total_debito){ $total_debito = $total_debito; } else { $total_debito = 0; } 
		?>
        <tr>
        <Tr>
        <td style="text-align:right; background-color: #EDEDED; border-bottom: 1px black solid" colspan="4"><strong>TOTAL DÉBITO R$ <? echo number_format($total_debito, 2, ",", "."); ?></strong></td></Tr>
    </tbody>
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
            <th>TOTAL CRÉDITO</th>
            <th>TOTAL DÉBITO</th>
            <th>TOTAL FATURA</th>
        <tr>
        
        <tr>
        	<?
				$total_fatura = ($total_total_empresa - $total_credito) + $total_debito;
			?>	
            <th>R$ <? echo number_format($total_total_empresa, 2, ',', '.'); ?></th>
            <th>R$ <? echo number_format($total_credito, 2, ",", "."); ?></th>
            <th>R$ <? echo number_format($total_debito, 2, ",", "."); ?></th>
            <th style="background-color: red; color: white; font-size: 14px;"><strong>R$ <? echo number_format($total_fatura, 2, ",", "."); ?></strong></th>
        <tr>
    </tbody>
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



<table class="table table-bordered">
    <thead>

        <tr>
            <td style="text-align:center; background-color: #000000; color: #FFF" colspan="5"><? echo $results[0]->nome_empresa;?> - <? echo $results[0]->cnpj_empresa;?></td>
        </tr>
        <tr>
            <th>Data Inicial</th>
            <th>Data Final</th>
            <th>Total de OS</th>
            <th>Total Empresa</th>
        </tr>
    </thead>
    <tbody>
		<tr>
        	<td><? if(isset($_GET['data_inicial'])){ echo date("d/m/Y", strtotime($_GET['data_inicial'])); } ?></td>
            <td><? if(isset($_GET['data_final'])){ echo date("d/m/Y", strtotime($_GET['data_final']));  } ?></td>
            <td><? echo count($results); ?></td>
            <td>R$ <? echo number_format($total_total_empresa, 2, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered">

    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="8">CHAMADAS VINCULADAS A ESTA EMPRESA</td>
        </tr>    
    
        <tr>
            <th style="width: 30px;">Chamada</th>
            <th style="width: 50px;">Data</th>
            <th style="width: 30px;">Pontos</th>
            <th>Solicitante</th>
            <th style="width: 40px;">HR. CH.</th>
            <th style="width: 40px;">HR. RE.</th>
            <th>Funcionário</th>
            <th style="width: 75px;">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php 
			foreach ($results as $r) {
				echo '<tr>';
					echo '<td><center>'.$r->idChamada.'</center></td>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$r->pontos.'</td>';
					echo '<td>'.$r->nome_solicitante.'</td>';
					echo '<td>'.$r->hora.'</td>';
					echo '<td>'.$r->hora_repasse.'</td>';
					echo '<td>'.substr($r->nome_funcionario, 0, 15).'</td>';
					echo '<td>R$ '.number_format($r->valor_empresa, 2, ",", ".").'</td>';
				echo '</tr>';
       		}		
        ?>
    </tbody>
</table>
<table class="table table-bordered ">
    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">ADICIONAIS VINCULADOS A ESTA EMPRESA</td>
        </tr>    
        <tr>
            <th style="width: 120px;">Data de Lançamento</th>
            <th style="width: 100px;">Tipo de Vínculo</th>
            <th style="width: 100px;">Valor</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php
		
			$total_credito = "";
			foreach ($results[0]->adicionais_credito as $r) {
				$total_credito += $r->valor;
				$tipoValor = $r->tipoValor;
				if($tipoValor=="C") $tipoValor = "CRÉDITO"; else  $tipoValor = "DÉBITO";
				echo '<tr>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$tipoValor.'</td>';
					echo '<td>R$ '.number_format($r->valor, 2, ",", ".").'</td>';
					echo '<td>'.$r->detalhes.'</td>';
				echo '</tr>';
       		}
			
			if($total_credito){ $total_credito = $total_credito; } else { $total_credito = 0; } 

			?>
             <td style="text-align:right; background-color: #EDEDED; border-bottom: 1px black solid" colspan="4"><strong>TOTAL CRÉDITO R$ <? echo number_format($total_credito, 2, ",", "."); ?></strong></td>
            <?
			$total_debito = "";
			foreach ($results[0]->adicionais_debito as $r) {
				$total_debito += $r->valor;
				$tipoValor = $r->tipoValor;
				if($tipoValor=="C") $tipoValor = "CRÉDITO"; else  $tipoValor = "DÉBITO";
				echo '<tr>';
					echo '<td><center>'.date('d/m/Y', strtotime($r->data)).'</center></td>';
					echo '<td>'.$tipoValor.'</td>';
					echo '<td>R$ '.number_format($r->valor, 2, ",", ".").'</td>';
					echo '<td>'.$r->detalhes.'</td>';
				echo '</tr>';
       		}
			if($total_debito){ $total_debito = $total_debito; } else { $total_debito = 0; } 
		?>
        <tr>
        <Tr>
        <td style="text-align:right; background-color: #EDEDED; border-bottom: 1px black solid" colspan="4"><strong>TOTAL DÉBITO R$ <? echo number_format($total_debito, 2, ",", "."); ?></strong></td></Tr>
    </tbody>
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
            <th>TOTAL CRÉDITO</th>
            <th>TOTAL DÉBITO</th>
            <th>TOTAL FATURA</th>
        <tr>
        
        <tr>
        	<?
				$total_fatura = ($total_total_empresa - $total_credito) + $total_debito;
			?>	
            <th>R$ <? echo number_format($total_total_empresa, 2, ',', '.'); ?></th>
            <th>R$ <? echo number_format($total_credito, 2, ",", "."); ?></th>
            <th>R$ <? echo number_format($total_debito, 2, ",", "."); ?></th>
            <th style="background-color: red; color: white; font-size: 14px;"><strong>R$ <? echo number_format($total_fatura, 2, ",", "."); ?></strong></th>
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
<? } 

}
?>

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
            var mywindow = window.open('', 'Entregas Rápidas - Controller', 'height=600,width=800');
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

