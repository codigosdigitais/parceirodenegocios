<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?php if($this->session->userdata('error')){?>
	<div class="alert alert-danger">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <?php echo $this->session->userdata('error');?>
   </div>
<?php }?>
<?
						$results = $lista_chamadas;
?>
<?php if ($results) {?>
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
                <h5><h5><? echo $results[0]->nome_empresa;?> - <? echo $results[0]->cnpj_empresa;?></h5></h5>
                <div class="buttons">
                	<? if($this->uri->segment(3)!='imprimir'){ ?>
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>
                    <? } else { ?>
                    <a id="imprimir_os" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>
                     <a href="javascript:window.history.go(-1)" title="Voltar" class="btn btn-mini btn-default"><i class="icon-list icon-white"></i> Voltar</a>
                    <? } ?>
                </div>
            </div>
            <div class="widget-content">
					<? if($this->uri->segment(3)!='imprimir'){
					?>  

                        <div class="span10" style="padding: 10px;">
                            <?
                            $total_total_funcionario=0;
                            $total_total_empresa=0;		
                            foreach ($results as $r) {
                                $total_total_funcionario += $r->valor_funcionario_total;
                                $total_total_empresa += $r->valor_empresa_total;
                            }
                            ?>
                            <form class="form-inline" method="get" action="<?php echo base_url('externo/chamadas'); ?>">
                            <div class="span3">
                                <label for="">Data Inicial:</label>
                                <input type="date" name="dataInicial" class="span12" value="<? if(isset($_GET['dataInicial'])){ echo $_GET['dataInicial']; } ?>" />
                            </div>
                            <div class="span3">
                                <label for="">Data Final:</label>
                                <input type="date" name="dataFinal" class="span12" value="<? if(isset($_GET['dataFinal'])){ echo $_GET['dataFinal']; } ?>" />
                            </div>
                            
                            <div class="span2">
                                <label for="">.</label>
                                <button class="btn btn-inverse" style="width: 125px; height:30px;"><i class="icon-search icon-white"></i> Filtrar</button>
                            </div>
                
                            <div class="span2">
                                <label for="">Total de Ordens</label>
                                <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo count($results); ?> </button>
                            </div>
                            
                            <div class="span2">
                                <label for="">Total Chamadas</label>
                                <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_total_empresa, 2, ',', '.'); ?> </button>
                            </div>
                            </form>
                        </div>
                
                
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <td style="text-align:center; background-color: #666; color: #FFF" colspan="9">CHAMADAS VINCULADAS A ESTA EMPRESA</td>
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
                            <th></th>
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
									echo "<td><a href=".base_url('externo/chamadas/imprimir/'.$r->idChamada)." class='btn btn-mini btn-default'><i class='icon-print icon-white'></i> Imprimir</a></td>";
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


                    
                    <? } else { ?>

                    <table class="table table-bordered">
                        <tr style="background-color: #CCC">
                            <th>Empresa Faturada</th>
                        </tr>
                        <tr>
                            <td><strong>Razão Social:</strong> <? echo $imprimir_chamada[0]->cedente_razaosocial; ?></td>
                        </tr>
                        <tr>
                            <td><strong>CNPJ:</strong> <? echo $imprimir_chamada[0]->cedente_cnpj; ?></td>
                        </tr>
                    
                        <tr style="background-color: #CCC">
                            <th>Dados do Cliente</th>
                        </tr>
                        <tr>
                            <td><strong>Razão Social: </strong><? echo $imprimir_chamada[0]->cliente_razaosocial; ?></td>
                        </tr>
                        <tr>
                            <td><strong>CNPJ:</strong> <? echo $imprimir_chamada[0]->cliente_cnpj; ?></td>
                        </tr>
                    
                    </table>

                    <table class="table table-bordered">
                    	<tr>
                        	<th>Data/Hora</th>
                            <th>Tipo de Tarifa</th>
                            <th>Tipo de Veículo</th>
                            <th>Solicitante	</th>
                            <th>Hora de Repasse</th>
                            <th>Tempo de Espera</th>
                            <th>Pontos Chamada</th>
                            <th>Valor</th>
                        </tr>
                        
                        <tr>
                        	<td><? echo date("d/m/Y", strtotime($imprimir_chamada[0]->data)); ?> - <? echo $imprimir_chamada[0]->hora; ?></td>
                            <td><? echo $imprimir_chamada[0]->tarifa; ?></td>
                            <td><? echo $imprimir_chamada[0]->tipo_veiculo; ?></td>
                            <td><? echo $imprimir_chamada[0]->solicitante; ?></td>
                            <td><? echo $imprimir_chamada[0]->hora_repasse; ?></td>
                            <td><? echo $imprimir_chamada[0]->tempo_espera; ?></td>
                            <td><? echo $imprimir_chamada[0]->pontos; ?></td>
                            <td style="background-color: #CCCCCC"><strong>R$ <? echo number_format($imprimir_chamada[0]->valor_empresa, 2, ',', '.'); ?></strong></td>
                        </tr>
                    </table>
                    
                    <table class="table table-bordered">
                        <tr>
                        	<td>
                                <table class="table table-bordered" style=" text-transform: uppercase;" >
                                            <tr>
                                                <th></th>
                                                <th style="width: 350px"><strong>ENDEREÇO</strong></th>
                                                <th><strong>Nº</strong></th>
                                                <th><strong>BAIRRO</strong></th>
                                                <th><strong>CIDADE</strong></th>
                                                <th><strong>FALOU COM</strong></th>
                                            </tr>
                                            
                                        <? foreach($imprimir_chamada[0]->servicos as $valor){ ?>
                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong><? if($valor->tiposervico=='0'){ echo "Coleta"; } elseif($valor->tiposervico=='1'){ echo "Entrega"; } else { echo "Retorno"; } ?></strong>
                                                </td>
                                                <td><? echo $valor->endereco; ?></td>
                                                <td><? echo $valor->numero; ?></td>
                                                <td><? echo $valor->bairro; ?></td>
                                                <td><? echo $valor->cidade; ?></td>
                                                <td><? echo $valor->falarcom; ?></td>
                                            </tr>
                                         <? } ?>
                                </table>

                            </td>
                        </tr>
                    </table>
                    
                    <table class="table table-bordered">
                    	<tr>
                        	<td><center>Impresso em <strong><? echo date("d/m/Y"); ?> às <? echo date("H:i:s"); ?></strong> - Sistema de Controle Interno | Parceiro de Negócios</center></td>
                        </tr>
                    </table>

                    <? } ?>
            </div>
        </div>
    </div>

</div>

<div style="display:none" id="print_ordem_servico">

	<style>
    .table th, .table td {
        padding: 6px;
        line-height: 12px;
        text-align: left;
        vertical-align: top;
        border-top: 0px solid #ddd;
        font-size: 11px
    }
    </style>
    <table class="table table-bordered">
        <tr style="background-color: #CCC">
            <th>Empresa Faturada</th>
        </tr>
        <tr>
            <td><strong>Razão Social:</strong> <? echo $imprimir_chamada[0]->cedente_razaosocial; ?></td>
        </tr>
        <tr>
            <td><strong>CNPJ:</strong> <? echo $imprimir_chamada[0]->cedente_cnpj; ?></td>
        </tr>
    
        <tr style="background-color: #CCC">
            <th>Dados do Cliente</th>
        </tr>
        <tr>
            <td><strong>Razão Social: </strong><? echo $imprimir_chamada[0]->cliente_razaosocial; ?></td>
        </tr>
        <tr>
            <td><strong>CNPJ:</strong> <? echo $imprimir_chamada[0]->cliente_cnpj; ?></td>
        </tr>
    
    </table>

    <table class="table table-bordered">
        <tr>
            <th>Data/Hora</th>
            <th>Tipo de Tarifa</th>
            <th>Tipo de Veículo</th>
            <th>Solicitante	</th>
            <th>Hora de Repasse</th>
            <th>Tempo de Espera</th>
            <th>Pontos Chamada</th>
            <th>Valor</th>
        </tr>
        
        <tr>
            <td><? echo date("d/m/Y", strtotime($imprimir_chamada[0]->data)); ?> - <? echo $imprimir_chamada[0]->hora; ?></td>
            <td><? echo $imprimir_chamada[0]->tarifa; ?></td>
            <td><? echo $imprimir_chamada[0]->tipo_veiculo; ?></td>
            <td><? echo $imprimir_chamada[0]->solicitante; ?></td>
            <td><? echo $imprimir_chamada[0]->hora_repasse; ?></td>
            <td><? echo $imprimir_chamada[0]->tempo_espera; ?></td>
            <td><? echo $imprimir_chamada[0]->pontos; ?></td>
            <td style="background-color: #CCCCCC"><strong>R$ <? echo number_format($imprimir_chamada[0]->valor_empresa, 2, ',', '.'); ?></strong></td>
        </tr>
    </table>
    
    <table class="table table-bordered">
        <tr>
            <td>
                <table class="table table-bordered" style=" text-transform: uppercase;" >
                            <tr>
                                <th></th>
                                <th style="width: 350px"><strong>ENDEREÇO</strong></th>
                                <th><strong>Nº</strong></th>
                                <th><strong>BAIRRO</strong></th>
                                <th><strong>CIDADE</strong></th>
                                <th><strong>FALOU COM</strong></th>
                            </tr>
                            
                        <? foreach($imprimir_chamada[0]->servicos as $valor){ ?>
                            <tr>
                                <td style="text-align: right;">
                                    <strong><? if($valor->tiposervico=='0'){ echo "Coleta"; } elseif($valor->tiposervico=='1'){ echo "Entrega"; } else { echo "Retorno"; } ?></strong>
                                </td>
                                <td><? echo $valor->endereco; ?></td>
                                <td><? echo $valor->numero; ?></td>
                                <td><? echo $valor->bairro; ?></td>
                                <td><? echo $valor->cidade; ?></td>
                                <td><? echo $valor->falarcom; ?></td>
                            </tr>
                         <? } ?>
                </table>

            </td>
        </tr>
    </table>
    
    <table class="table table-bordered">
        <tr>
            <td><center>Impresso em <strong><? echo date("d/m/Y"); ?> às <? echo date("H:i:s"); ?></strong> - Sistema de Controle Interno | Parceiro de Negócios</center></td>
        </tr>
    </table>

</div>

<div style="display: none; padding-top: 0px;" id="printView">

	<style>
    .table th, .table td {
        padding: 6px;
        line-height: 12px;
        text-align: left;
        vertical-align: top;
        border-top: 0px solid #ddd;
        font-size: 11px
    }
    </style>
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
            var mywindow = window.open('', 'Entregas Rápidas - Controller', 'height=600,width=1100');
            mywindow.document.write('<html><head><title>Entregas Rápidas - Controller</title>');
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
            mywindow.document.write("</head><body>");
			mywindow.document.write("<div style='background-color: #FFFFFF; padding: 20px'>");
			mywindow.document.write("<style>table,td,tr { font-family: arial; font-size: 10px; } </style>");
            mywindow.document.write(data);
			mywindow.document.write('</div>');
            
            mywindow.document.write("</body></html>");


            return true;
        }

    });

    $(document).ready(function(){
        $("#imprimir_os").click(function(){         
            PrintElem('#print_ordem_servico');
        })

        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'Entregas Rápidas - Controller <? echo $this->uri->segment(4); ?>', 'height=600,width=1100');
            mywindow.document.write('<html><head><title>Entregas Rápidas - Controller</title>');
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
            mywindow.document.write("</head><body>");
			mywindow.document.write("<div style='background-color: #FFFFFF; padding: 20px'>");
			mywindow.document.write("<style>table,td,tr { font-family: arial; font-size: 10px; } </style>");
            mywindow.document.write(data);
			mywindow.document.write('</div>');
            
            mywindow.document.write("</body></html>");


            return true;
        }

    });

</script>

<?php } else { ?>
	Nenhum registro encontrado.
<?php } ?>