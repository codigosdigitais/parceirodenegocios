<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
</style>

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
			<?
				$total_empresa = 0;
				$total_agrupado = 0;
				foreach($results as $valor){
					$total_agrupado += $valor->total_por_agrupamento;
					$total_empresa += $valor->valor_empresa_total;
				}

			?>
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
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $total_agrupado;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Empresa</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_empresa, 2, ',', '.'); ?> </button>
            </div>
            
        </div>


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Cliente</th>
            <th style="width: 30px;">OS</th>
            <th style="width: 45px;">NF</th>
            <th style="width: 300px;">Faturado</th>
            <th style="width: 70px;">Valor</th>
            <th style="width: 70px;">C</th>
            <th style="width: 70px;">D</th>
            <th style="width: 120px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
			foreach ($results as $r) {
			
				$total_credito = "";
				$total_debito = "";
					if(count($r->adicionais)){
						foreach($r->adicionais as $totais){
							$total_credito = $totais->total_credito;
							$total_debito = $totais->total_debito;
						}
					}
				if($total_credito=="") $total_credito = "0.00";
				if($total_debito=="") $total_debito = "0.00";


            echo '<tr>';
				echo '<td>'.$r->nome_empresa.'</td>';
				echo '<td><center>'.$r->total_por_agrupamento.'</center></td>';
				echo '<td>'.$r->nota_fiscal.'</td>';
				echo '<td>'.$r->nome_cedente.'</td>';
				echo '<td>R$ '.number_format($r->valor_empresa_total, 2, ",", ".").'</td>';
				echo '<td>R$ '.number_format($total_credito, 2, ",", ".").'</td>';
				echo '<td>R$ '.number_format($total_debito, 2, ",", ".").'</td>';
				echo '<td>';
				
                echo '<a href="'.base_url().'fechamentos/fechamentoChamada?idCliente='.$r->idCliente.'&idFuncionario='.$_GET['idFuncionario'].'&data_inicial='.$_GET['data_inicial'].'&data_final='.$_GET['data_final'].'&view=todos" style="margin-right: 1%" class="btn" title="Visualizar Todas"><i class="icon-eye-open"></i></a>';
				
				//echo '<a href="'.base_url().'boleto/gerar/'.$r->idCliente.'/'.$_GET['data_inicial'].'/'.$_GET['data_final'].'"><button id="gerar_boleto" class="btn btn-default">Boleto</buttom>'; 
				//echo '<button name="dialog" id="dialog" type="button" class="btn btn-info btn-lg boleto_campo" data-toggle="modal" data-cliente='.$r->idCliente.' data-datainicial='.$_GET['data_inicial'].' data-datafinal='.$_GET['data_final'].' data-target="#myModal">Boleto</button>'; 	
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


<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    	<?
			//print_r($_GET);
		?>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Qual destas opções você deseja?</h4>
        </div>
        <div class="modal-body">
          <p><h5>Você poderá emitir o boleto bancário e gerar em PDF ou então enviar-la diretamente no e-mail de cadastro do cliente. Por favor, selecione uma opção abaixo.</h5></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger gerar_pdf">Gerar PDF</button>
          <button type="button" class="btn btn-primary enviar_email">Enviar E-Mail</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modal fade" id="myModalBoletoOK" role="dialog">
    <div class="modal-dialog">
    	<?
			//print_r($_GET);
		?>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Boleto </h4>
        </div>
        <div class="modal-body">
          <p><h5>Boleto foi enviado com sucesso!</h5></p>
        </div>
        
      </div>
      
    </div>
  </div>
  
  
</div>
<script>
	$(document).ready(function(){
		$(".boleto_campo").click(function(){ 
			$("#cliente").val($(this).data('cliente'));
			$("#datainicial").val($(this).data('datainicial'));
			$("#datafinal").val($(this).data('datafinal'));
			var cliente = $(this).data('cliente');
			var datainicial = $(this).data('datainicial');
			var datafinal = $(this).data('datafinal');
			$("#form_modal").modal('show');
			
			$(".gerar_pdf").click(function(){
				$('#myModal').modal('hide');
				window.location.href = "<? echo base_url('boleto/gerar/'); ?>/" + cliente + "/" + datainicial + "/" + datafinal;	
			});
			
					
			$(".enviar_email").on("click", function(evt) {
				$.ajax({
					url: "<? echo base_url('boleto/email/'); ?>/" + cliente + "/" + datainicial + "/" + datafinal,
					data: {id: 1 },
					type: 'BOLETO'
				}).done(function() {
					 $('#myModal').modal('hide');
					 $('#myModalBoletoOK').modal('show');
						/*setTimeout(function() { 
							$('#myModalBoletoOK').modal('hide');
        				}, 400);	*/				 
					 
					 //alert('Boleto enviado com sucesso!');  
				});
			});
			
		});
	});
</script>

<?php 
} else { 
?>

<div class="widget-box" style="margin-top: -15px;">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5><? echo $results[0]->nome_empresa;?></h5>
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
                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo $results[0]->retornoR->totalOsGeral;?> </button>
            </div>
            
            <div class="span2">
                <label for="">Total Empresa</label>
                <button class="btn btn-inverse span12"> Valor: <? echo number_format($results[0]->retornoR->valorEmpresaGeral, 2, ',', '.'); ?> </button>
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
        <?php foreach ($results as $r) {
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
            <td><? echo $results[0]->retornoR->totalOsGeral;?></td>
            <td>R$ <? echo number_format($results[0]->retornoR->valorEmpresaGeral, 2, ',', '.'); ?></td>
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
        <?php foreach ($results as $r) {
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

