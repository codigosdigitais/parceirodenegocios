<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

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
                <h5>Relatório de Chamadas</h5>
                <div class="buttons">
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content">
            
                    <div class="span12" style="margin-bottom: 15px;">
                    	<form action="<?php echo base_url()?>relatorios/listarChamada" method="post">
                        	

                            
                            <div class="span6">
                                <label class="control-label">Cliente</label>
                                <select class="input span12" name="idCliente" id="idCliente">
                                    <option value="">Selecione o Cliente</option>
                                    <?
                                        foreach($this->data['listaCliente'] as $clienteLista){ 
                                    ?>
                                    <option value="<?=$clienteLista->idCliente;?>" <? if(empty($_POST['idCliente'])){ echo ""; } elseif($_POST['idCliente']==$clienteLista->idCliente){ echo "selected='seleted'"; } ?>><?=$clienteLista->razaosocial;?></option>
                                    <? } ?>								
                                </select>
                            </div>	
                            
                            <div class="span2">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>
                            </div>
                        </form>
                    </div>
                    
                    <table class="table table-bordered">
                    <? foreach($results as $valor){ ?>
                        <tr><td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->nome_cliente; ?></strong></td></tr>
                        <? 
							$i=0;
							foreach($valor->cliente_lista as $valor_cliente){ 
						?>							
                        <tr><td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong><? echo $valor_cliente->nome_funcionario; ?></strong></td></tr>
                
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->cliente_lista[$i]->cliente_lista_funcionario)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 15%">Chamada</th>
                                            <th style="width: 20%">Data</th>
                                            <th style="width: 10%">Hora Inicial</th>
                                            <th style="width: 10%">Hora Final</th>
                                            <th style="width: 15%">Tempo Espera</th>
                                            <th style="width: 15%">Valor Emp.</th>
                                            <th style="width: 15%">Valor Func.</th>
                                        </tr>
                                        <? 
										$valor_empresa = 0;
										$valor_funcionario = 0;
										foreach($valor->cliente_lista[$i]->cliente_lista_funcionario as $lista_chamada){ 
											$valor_empresa += $lista_chamada->valor_empresa;
											$valor_funcionario += $lista_chamada->valor_funcionario;
										?>
                                        <tr>
                                        	<td>
											
											<? echo $lista_chamada->idChamada; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($lista_chamada->data)); ?></td>
                                            <td><? echo $lista_chamada->hora_inicio; ?></td>
                                            <td><? echo $lista_chamada->hora_fim; ?></td>
                                            <td><? echo $lista_chamada->tempo_espera; ?></td>
                                            <td>R$ <? echo number_format($lista_chamada->valor_empresa, '2', ',', '.'); ?></td>
                                            <td>R$ <? echo number_format($lista_chamada->valor_funcionario, '2', ',', '.'); ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->cliente_lista[$i]->cliente_lista_funcionario); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #F5F5F5"><strong>Valor Empresa: </strong> R$ <? echo number_format($valor_empresa, '2', ',', '.'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #EDEDED"><strong>Valor Funcionário: </strong>R$ <? echo number_format($valor_funcionario, '2', ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhuma falta para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                        <? $i++; }  ?>
                    <? } ?>
                    </table>
            </div>
        </div>
    </div>

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
<div style="float:right"><img src="<? echo base_url("assets/img"); ?>/logo_empresa.jpg" /></div>    
                    <table class="table table-bordered">
                    <? foreach($results as $valor){ ?>
                        <tr><td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->nome_cliente; ?></strong></td></tr>
                        <? 
							$i=0;
							foreach($valor->cliente_lista as $valor_cliente){ 
						?>							
                        <tr><td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong><? echo $valor_cliente->nome_funcionario; ?></strong></td></tr>
                
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->cliente_lista[$i]->cliente_lista_funcionario)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 15%">Chamada</th>
                                            <th style="width: 20%">Data</th>
                                            <th style="width: 10%">Hora Inicial</th>
                                            <th style="width: 10%">Hora Final</th>
                                            <th style="width: 15%">Tempo Espera</th>
                                            <th style="width: 15%">Valor Emp.</th>
                                            <th style="width: 15%">Valor Func.</th>
                                        </tr>
                                        <? 
										$valor_empresa = 0;
										$valor_funcionario = 0;
										foreach($valor->cliente_lista[$i]->cliente_lista_funcionario as $lista_chamada){ 
											$valor_empresa += $lista_chamada->valor_empresa;
											$valor_funcionario += $lista_chamada->valor_funcionario;
										?>
                                        <tr>
                                        	<td>
											
											<? echo $lista_chamada->idChamada; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($lista_chamada->data)); ?></td>
                                            <td><? echo $lista_chamada->hora_inicio; ?></td>
                                            <td><? echo $lista_chamada->hora_fim; ?></td>
                                            <td><? echo $lista_chamada->tempo_espera; ?></td>
                                            <td>R$ <? echo number_format($lista_chamada->valor_empresa, '2', ',', '.'); ?></td>
                                            <td>R$ <? echo number_format($lista_chamada->valor_funcionario, '2', ',', '.'); ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->cliente_lista[$i]->cliente_lista_funcionario); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #F5F5F5"><strong>Valor Empresa: </strong> R$ <? echo number_format($valor_empresa, '2', ',', '.'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="7" style="text-align: right; background-color: #EDEDED"><strong>Valor Funcionário: </strong>R$ <? echo number_format($valor_funcionario, '2', ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhuma falta para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                        <? $i++; }  ?>
                    <? } ?>
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
</script>

