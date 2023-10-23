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

                <h5>Relatório de Substituições</h5>

                <div class="buttons">

                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>

                </div>

            </div>

            <div class="widget-content">

            

                    <div class="span12" style="margin-bottom: 15px;">

                    	<form action="<?php echo base_url()?>relatorios/listarSubstituicoes" method="post">

                        	

                            <div class="span6">

                                <label for="">Cliente</label>

                                <select class="input span12" name="idCliente" id="idCliente" >

                                	<option value="">Todos os Clientes</option>

                                    <?

                                        foreach($this->data['listaCliente'] as $clienteLista){ 

                                    ?>

                                    <option value="<?=$clienteLista->idCliente;?>" <? if(isset($_POST['idCliente'])){ if($clienteLista->idCliente==$_POST['idCliente']){ echo "selected"; } } ?> ><?=$clienteLista->razaosocial;?></option>

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

                    <?

                        foreach($results as $valor){

                    ?>

                        <tr>

                            <td style="text-align:left; background-color: #666; color: #FFF"; colspan="5"><strong><? echo $valor->razaosocial; ?></strong></td>

                        </tr> 



                       

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 7% !important; "><strong>Data</strong></td>

                            <td style="width: 28% !important; "><strong>Funcionário Falta</strong></td>

                            <td style="width: 20% !important; "><strong>Funcionário Substituto</strong></td>

                            <td style="width: 15% !important; "><strong>Horários</strong></td>

                            <td style="width: 20% !important; "><strong>Detalhes</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Ativos

								if(count(@$valor->substituicao_cliente)>0){

									foreach($valor->substituicao_cliente as $valor_ativo){

							?>

                   

                                    <tr> 

                                        <td><? echo $valor_ativo->data; ?></td>

                                        <td><? echo $valor_ativo->nome_funcionario_faltou; ?></td>

                                        <td><? echo $valor_ativo->nome_funcionario_substituiu; ?></td>

                                        <td><? echo $valor_ativo->subst_das." às ".$valor_ativo->subst_as; ?> / <? echo $valor_ativo->subst_das2." às ".$valor_ativo->subst_as2; ?></td>

                                        <td><? echo $valor_ativo->detalhes; ?></td>

                                    </tr>              



                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="5"><strong>Nenhuma substituição encontrada.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            



                    <? 

                        } 

                    ?>

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

                    <?

                        foreach($results as $valor){

                    ?>

                        <tr>

                            <td style="text-align:left; background-color: #666; color: #FFF"; colspan="5"><strong><? echo $valor->razaosocial; ?></strong></td>

                        </tr> 



                       

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 7% !important; "><strong>Data</strong></td>

                            <td style="width: 28% !important; "><strong>Funcionário Falta</strong></td>

                            <td style="width: 20% !important; "><strong>Funcionário Substituto</strong></td>

                            <td style="width: 15% !important; "><strong>Horários</strong></td>

                            <td style="width: 20% !important; "><strong>Detalhes</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Ativos

								if(count(@$valor->substituicao_cliente)>0){

									foreach($valor->substituicao_cliente as $valor_ativo){

							?>

                   

                                    <tr> 

                                        <td><? echo $valor_ativo->data; ?></td>

                                        <td><? echo $valor_ativo->nome_funcionario_faltou; ?></td>

                                        <td><? echo $valor_ativo->nome_funcionario_substituiu; ?></td>

                                        <td><? echo $valor_ativo->subst_das." às ".$valor_ativo->subst_as; ?> / <? echo $valor_ativo->subst_das2." às ".$valor_ativo->subst_as2; ?></td>

                                        <td><? echo $valor_ativo->detalhes; ?></td>

                                    </tr>              



                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="5"><strong>Nenhuma substituição encontrada.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            



                    <? 

                        } 

                    ?>

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



