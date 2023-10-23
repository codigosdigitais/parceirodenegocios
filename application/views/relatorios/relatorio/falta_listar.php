<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?
	if(empty($_POST['idTipo'])){
		$_POST['idTipo'] = "";	
	} else { 
		$_POST['idTipo'] = $_POST['idTipo'];
	}
?>

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
                <h5>Relatório de Faltas & Atrasos</h5>
                <div class="buttons">
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content">
            
            		<?
						$contagem_ativos_total = 0;
						for($contagem_ativos=0; $contagem_ativos<=count($results); $contagem_ativos++){
							$contagem_ativos_total += @count($results[$contagem_ativos]->contratos_ativos);	
						}
						
						$contagem_inativos_total = 0;
						for($contagem_inativos=0; $contagem_inativos<=count($results); $contagem_inativos++){
							$contagem_inativos_total += @count($results[$contagem_inativos]->contratos_inativos);	
						}
						
					?>
            
                    <div class="span12" style="margin-bottom: 15px;">
                    	<form action="<?php echo base_url()?>relatorios/listarFalta" method="post">
                        	
                            <div class="span6">
                                <label for="">Cedente</label>
                                <select class="input span12" name="idCedente" >
                                	<option value="">Todos os Cedentes</option>
                                    <? foreach($lista_cedente as $valor){ ?>
                                        <option value="<? echo $valor->idCedente;?>" <? if(empty($_POST['idCedente'])){ echo ""; } elseif($_POST['idCedente']==$valor->idCedente){ echo "selected='seleted'"; } ?>><? echo $valor->razaosocial;?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <!---
                            <div class="span2">
                                <label for="">Clientes Ativos</label>
                                <button class="btn btn-inverse span12" style="background-color: red"><? echo $contagem_ativos_total; ?></button>
                            </div>
                            
                            <div class="span2">
                                <label for="">Clientes Inativos</label>
                                <button class="btn btn-inverse span12"> <? echo $contagem_inativos_total; ?> </button>
                            </div>
                            -->
                            <div class="span2">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>
                            </div>
                        </form>
                    </div>
                    
                    <table class="table table-bordered">
                    <? foreach($results as $valor){ ?>
                        <tr><td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->cedente; ?></strong></td></tr>
                        <? 
							$i=0;
							foreach($valor->funcionarios as $valor_funcionario){ 
						?>							
                        <tr><td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong><? echo $valor_funcionario->nome_funcionario; ?></strong></td></tr>
                        <? if(!empty($_POST['idTipo'])  or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='897' or $_POST['idTipo']=='896' or $_POST['idTipo']==''){
						?>
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE FALTAS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->funcionarios[$i]->funcionarios_falta)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 40%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 30%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_falta as $funcionario_falta){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_falta->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_falta->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_falta->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_falta->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_falta); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhuma falta para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                        <? } } ?>
                        <? if(!empty($_POST['idTipo']) or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='899' or $_POST['idTipo']=='898' or $_POST['idTipo']==''){
						?>
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE ATRASOS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                               		<? if(count($valor->funcionarios[$i]->funcionarios_atraso)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 30%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 9%">Hora Inicial</th>
                                            <th style="width: 8%">Hora Final</th>
                                            <th style="width: 23%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_atraso as $funcionario_atraso){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_atraso->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_atraso->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_atraso->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_atraso->hora_inicio; ?></td>
                                            <td><? echo $funcionario_atraso->hora_final; ?></td>
                                            <td><? echo $funcionario_atraso->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="6" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_atraso); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhum atraso para este funcionário</strong></p></center>
                                    <? } ?>
                                    
                                </td>
                            </tr>
                        <? } } ?>
                        <? if(!empty($_POST['idTipo']) or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='939' or $_POST['idTipo']=='305' or $_POST['idTipo']==''){
						?>   
                            
                        
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE OUTROS MOTIVOS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->funcionarios[$i]->funcionarios_outros)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 40%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 30%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_outros as $funcionario_outros){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_outros->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_outros->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_outros->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_outros->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_outros); ?></td>
                                        </tr>
                                    </table>
                                    <? } else { ?>
                                    	<center><p><strong>Nenhum registro em outros para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                            <? } } ?>
                            
                        <?  $i++; } ?>

                        
                        
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
                        <tr><td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->cedente; ?></strong></td></tr>
                        <? 
							$i=0;
							foreach($valor->funcionarios as $valor_funcionario){ 
						?>							
                        <tr><td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong><? echo $valor_funcionario->nome_funcionario; ?></strong></td></tr>
                        <? if(!empty($_POST['idTipo'])  or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='897' or $_POST['idTipo']=='896' or $_POST['idTipo']==''){
						?>
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE FALTAS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->funcionarios[$i]->funcionarios_falta)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 40%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 30%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_falta as $funcionario_falta){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_falta->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_falta->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_falta->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_falta->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_falta); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhuma falta para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                        <? } } ?>
                        <? if(!empty($_POST['idTipo']) or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='899' or $_POST['idTipo']=='898' or $_POST['idTipo']==''){
						?>
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE ATRASOS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                               		<? if(count($valor->funcionarios[$i]->funcionarios_atraso)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 30%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 9%">Hora Inicial</th>
                                            <th style="width: 8%">Hora Final</th>
                                            <th style="width: 23%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_atraso as $funcionario_atraso){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_atraso->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_atraso->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_atraso->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_atraso->hora_inicio; ?></td>
                                            <td><? echo $funcionario_atraso->hora_final; ?></td>
                                            <td><? echo $funcionario_atraso->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="6" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_atraso); ?></td>
                                        </tr>
                                    </table>
                                    <? } else {  ?>
                                    	<center><p><strong>Nenhum atraso para este funcionário</strong></p></center>
                                    <? } ?>
                                    
                                </td>
                            </tr>
                        <? } } ?>
                        <? if(!empty($_POST['idTipo']) or $_POST['idTipo']==''){  
								if($_POST['idTipo']=='939' or $_POST['idTipo']=='305' or $_POST['idTipo']==''){
						?>   
                            
                        
                        <tr><td style="text-align:left; background-color: #FFFFFF; color: #333"; colspan="6"><strong>&nbsp;&nbsp;&nbsp;&nbsp; - LISTAGEM DE OUTROS MOTIVOS</strong></td></tr>
                        	<tr>
                            	<td style="border-bottom: 1px solid #B9A5A5;">
                                	<? if(count($valor->funcionarios[$i]->funcionarios_outros)>0){ ?>
                                	<table class="table table-bodereded">
                                    	<tr>
                                            <th style="width: 40%">Tipo</th>
                                            <th style="width: 15%">Data de Solicitação</th>
                                            <th style="width: 15%">Data de Cadastro</th>
                                            <th style="width: 30%">Detalhes</th>
                                        </tr>
                                        <? foreach($valor->funcionarios[$i]->funcionarios_outros as $funcionario_outros){ ?>
                                        <tr>
                                        	<td><? echo $funcionario_outros->idTipo; ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_outros->data_solicitado)); ?></td>
                                            <td><? echo date("d/m/Y", strtotime($funcionario_outros->data_cadastro)); ?></td>
                                            <td><? echo $funcionario_outros->detalhes; ?></td>
                                        </tr>
                                        <? } ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right; background-color: #EDEDED"><strong>Total Registros: </strong><? echo count($valor->funcionarios[$i]->funcionarios_outros); ?></td>
                                        </tr>
                                    </table>
                                    <? } else { ?>
                                    	<center><p><strong>Nenhum registro em outros para este funcionário</strong></p></center>
                                    <? } ?>
                                </td>
                            </tr>
                            <? } } ?>
                            
                        <?  $i++; } ?>

                        
                        
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

