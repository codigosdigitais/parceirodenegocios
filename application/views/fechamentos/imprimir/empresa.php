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
            <h5>Fechamento de Chamadas Empresa - Relatório</h5>

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
        <h5>Fechamento de Chamadas Empresa - Relatório</h5>
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
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $results[0]->totalOs;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Empresa</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($results[0]->valorEmpresa, 2, ',', '.'); ?> </button>
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
                echo '<a href="'.base_url().'fechamentos/fechamentoEmpresa?idFuncionario='.$_GET['idFuncionario'].'&data_inicial='.$_GET['data_inicial'].'&data_final='.$_GET['data_final'].'&view=todos" style="margin-right: 1%" class="btn " title="Visualizar Todas"><i class="icon-eye-open"></i></a>'; 
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
        <h5><? echo $results[0]->nomeCliente;?></h5>
            <div class="buttons">
	            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            </div>
     </div>

<div class="widget-content nopadding">
        <div class="span10" style="padding: 10px;">
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
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $results[0]->totalOs;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Empresa</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($results[0]->valorEmpresa, 2, ',', '.'); ?> </button>
            </div>
            
        </div>


<table class="table table-bordered ">
    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="7">CHAMADAS VINCULADAS A ESTA EMPRESA</td>
        </tr>    
        <tr>
            <th style="width: 50px;">Chamada</th>
            <th style="width: 50px;">OS</th>
            <th style="width: 50px;">HR. CH.</th>
            <th style="width: 50px;">HR. RE.</th>
            <th>Funcionário</th>
            <th style="width: 75px;">Valor</th>
            <th style="width: 30px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results[0]->retorno as $r) {
            echo '<tr>';
				echo '<td><center>'.$r->idChamada.'</center></td>';
				echo '<td>'.$r->numero_os.'</td>';
				echo '<td>'.$r->hora.'</td>';
				echo '<td>'.$r->hora_repasse.'</td>';
				echo '<td>'.$results[0]->nomeFuncionario.'</td>';
				echo '<td>R$ '.number_format($r->valor_empresa, 2, ",", ".").'</td>';
				if($r->numero_os){
					echo "<td><div class=substituicao-ok><i class='icon icon-ok'></i></div></td>";
				} else {
					echo '<td></td>';
				}
            echo '</tr>';
        }
		?>
        <tr>
            
        </tr>
    </tbody>
</table>




</div>
</div>
<div style="display: none; padding-top: 20px;" id="printView">

<table class="table table-bordered">
    <thead>

        <tr>
            <td style="text-align:center; background-color: #000000; color: #FFF" colspan="5"><? echo $results[0]->nomeCliente;?></td>
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
            <td><? echo $results[0]->totalOs;?></td>
            <td>R$ <? echo number_format($results[0]->valorEmpresa, 2, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered">

    <thead>
        <tr>
            <td style="text-align:center; background-color: #666; color: #FFF" colspan="7">CHAMADAS VINCULADAS A ESTA EMPRESA</td>
        </tr>    
    
        <tr>
            <th style="width: 50px;">Chamada</th>
            <th style="width: 50px;">OS</th>
            <th style="width: 50px;">HR. CH.</th>
            <th style="width: 50px;">HR. RE.</th>
            <th>Funcionário</th>
            <th style="width: 75px;">Valor</th>
            <th style="width: 30px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results[0]->retorno as $r) {
            echo '<tr>';
                echo '<td><center>'.$r->idChamada.'</center></td>';
                echo '<td>'.$r->numero_os.'</td>';
                echo '<td>'.$r->hora.'</td>';
                echo '<td>'.$r->hora_repasse.'</td>';
                echo '<td>'.$results[0]->nomeFuncionario.'</td>';
                echo '<td>R$ '.number_format($r->valor_empresa, 2, ",", ".").'</td>';
				if($r->numero_os){
					echo "<td><div class=substituicao-ok><i class='icon icon-ok'></i></div></td>";
				} else {
					echo '<td></td>';
				}
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<table class="table table-bordered">
	<tr>
    	<td style="text-align: center">
        	Relatório gerado em <? echo date("d/m/Y - H:i:s"); ?> - Entregas Rápidas - Controller
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

