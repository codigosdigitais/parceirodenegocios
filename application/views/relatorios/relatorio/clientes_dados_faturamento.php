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

                <h5>Relatório de Clientes</h5>

                <div class="buttons">

                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"><i class="icon-print icon-white"></i> Imprimir</a>

                </div>

            </div>

            <div class="widget-content">

            

            		<?

						$contagem_ativos_total = 0;

						for($contagem_ativos=0; $contagem_ativos<=count($results); $contagem_ativos++){

							$contagem_ativos_total += @count($results[$contagem_ativos]->clientes_ativos);	

						}

						

						$contagem_inativos_total = 0;

						for($contagem_inativos=0; $contagem_inativos<=count($results); $contagem_inativos++){

							$contagem_inativos_total += @count($results[$contagem_inativos]->clientes_inativos);	

						}

						

					?>

            

                    <div class="span12" style="margin-bottom: 15px;">

                    	<form action="<?php echo base_url()?>relatorios/listarCliente" method="post">

                        	

                            <div class="span6">

                                <label for="">Cedente</label>

                                <select class="input span12" name="codCedente" >

                                	<option value="">Todos os Cedentes</option>

                                    <? foreach($lista_cedente as $valor){ ?>

                                        <option value="<? echo $valor->idCedente;?>" <? if(empty($_POST['codCedente'])){ echo ""; } elseif($_POST['codCedente']==$valor->idCedente){ echo "selected='seleted'"; } ?>><? echo $valor->razaosocial;?></option>

                                    <? } ?>

                                </select>

                            </div>

                            <div class="span2">

                                <label for="">Clientes Ativos</label>

                                <button class="btn btn-inverse span12" style="background-color: red"><? echo $contagem_ativos_total; ?></button>

                            </div>

                            

                            <div class="span2">

                                <label for="">Clientes Inativos</label>

                                <button class="btn btn-inverse span12"> <? echo $contagem_inativos_total; ?> </button>

                            </div>

                            <div class="span2">

                                <label for="">&nbsp;</label>

                                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>

                            </div>

                            

                            <input type="hidden" id="campo[]" name="campo[]" value="dados_faturamento">

                        </form>

                    </div>

                    <table class="table table-bordered">

                    <?

                        foreach($results as $valor){

                    ?>

                        <tr>

                            <td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->cedente; ?></strong></td>

                        </tr> 



                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong>CLIENTES ATIVOS</strong></td>

                        </tr>

                        

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 25% !important; "><strong>Razão Social</strong></td>

                            <td style="width: 4% !important; "><strong>Vencimento</strong></td>

                            <td style="width: 7% !important; "><strong>Pagamento</strong></td>

                            <td style="width: 7% !important; "><strong>Fechamento</strong></td>

                            <td style="width: 6% !important; "><strong>Guias/Nota</strong></td>

                            <td style="width: 51% !important; "><strong>Endereço</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Ativos

								if(count($valor->clientes_ativos)>0){

									foreach($valor->clientes_ativos as $valor_ativo){

							?>

                   

                                    <tr> 

                                        <td><? echo substr($valor_ativo->razaosocial, 0, 35); ?></td>

                                        <td><? echo $valor_ativo->vencimento; ?></td>

                                        <td><? echo $valor_ativo->forma_de_pagamento; ?></td>

                                        <td><? echo $valor_ativo->fechamento_de." à ".$valor_ativo->fechamento_a; ?></td>

                                        <td><? echo $valor_ativo->guias; ?> / <? echo $valor_ativo->nota; ?></td>

                                        <td><? echo $valor_ativo->fat_endereco; ?>, <? echo $valor_ativo->fat_endereco_numero; ?> - <? echo $valor_ativo->fat_endereco_cep; ?> - <? echo $valor_ativo->fat_endereco_bairro; ?>, <? echo $valor_ativo->fat_endereco_cidade; ?> - <? echo $valor_ativo->fat_endereco_estado; ?></td>

                                    </tr>              



                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="6"><strong>Nenhum cliente ativo neste cedente.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            

                            

                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong>CLIENTES INATIVOS</strong></td>

                        </tr>

                        

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 25% !important; "><strong>Razão Social</strong></td>

                            <td style="width: 4% !important; "><strong>Vencimento</strong></td>

                            <td style="width: 7% !important; "><strong>Pagamento</strong></td>

                            <td style="width: 7% !important; "><strong>Fechamento</strong></td>

                            <td style="width: 6% !important; "><strong>Guias/Nota</strong></td>

                            <td style="width: 51% !important; "><strong>Endereço</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Inativos

								if(count($valor->clientes_inativos)>0){

									foreach($valor->clientes_inativos as $valor_inativo){

							?>

                   

                                    <tr> 

                                        <td><? echo substr($valor_inativo->razaosocial, 0, 35); ?></td>

                                        <td><? echo $valor_inativo->vencimento; ?></td>

                                        <td><? echo $valor_inativo->forma_de_pagamento; ?></td>

                                        <td><? echo $valor_inativo->fechamento_de." à ".$valor_inativo->fechamento_a; ?></td>

                                        <td><? echo $valor_inativo->guias; ?> / <? echo $valor_inativo->nota; ?></td>

                                        <td><? echo $valor_inativo->fat_endereco; ?>, <? echo $valor_inativo->fat_endereco_numero; ?> - <? echo $valor_inativo->fat_endereco_cep; ?> - <? echo $valor_inativo->fat_endereco_bairro; ?>, <? echo $valor_inativo->fat_endereco_cidade; ?> - <? echo $valor_inativo->fat_endereco_estado; ?></td>

                                    </tr>                



                            <? 

									} # Fecha clientes Inativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="6"><strong>Nenhum cliente inativo neste cedente.</strong></td>

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

<?

	$contagem_ativos_total = 0;

	for($contagem_ativos=0; $contagem_ativos<=count($results); $contagem_ativos++){

		$contagem_ativos_total += @count($results[$contagem_ativos]->clientes_ativos);	

	}

	

	$contagem_inativos_total = 0;

	for($contagem_inativos=0; $contagem_inativos<=count($results); $contagem_inativos++){

		$contagem_inativos_total += @count($results[$contagem_inativos]->clientes_inativos);	

	}

	

?>
<div style="float:right"><img src="<? echo base_url("assets/img"); ?>/logo_empresa.jpg" /></div>
                    <table class="table table-bordered">

                    <?

                        foreach($results as $valor){

                    ?>

                        <tr>

                            <td style="text-align:left; background-color: #666; color: #FFF"; colspan="6"><strong><? echo $valor->cedente; ?></strong></td>

                        </tr> 



                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong>CLIENTES ATIVOS</strong></td>

                        </tr>

                        

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 25% !important; "><strong>Razão Social</strong></td>

                            <td style="width: 4% !important; "><strong>Vencimento</strong></td>

                            <td style="width: 7% !important; "><strong>Pagamento</strong></td>

                            <td style="width: 7% !important; "><strong>Fechamento</strong></td>

                            <td style="width: 6% !important; "><strong>Guias/Nota</strong></td>

                            <td style="width: 51% !important; "><strong>Endereço</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Ativos

								if(count($valor->clientes_ativos)>0){

									foreach($valor->clientes_ativos as $valor_ativo){

							?>

                   

                                    <tr> 

                                        <td><? echo substr($valor_ativo->razaosocial, 0, 35); ?></td>

                                        <td><? echo $valor_ativo->vencimento; ?></td>

                                        <td><? echo $valor_ativo->forma_de_pagamento; ?></td>

                                        <td><? echo $valor_ativo->fechamento_de." à ".$valor_ativo->fechamento_a; ?></td>

                                        <td><? echo $valor_ativo->guias; ?> / <? echo $valor_ativo->nota; ?></td>

                                        <td><? echo $valor_ativo->fat_endereco; ?>, <? echo $valor_ativo->fat_endereco_numero; ?> - <? echo $valor_ativo->fat_endereco_cep; ?> - <? echo $valor_ativo->fat_endereco_bairro; ?>, <? echo $valor_ativo->fat_endereco_cidade; ?> - <? echo $valor_ativo->fat_endereco_estado; ?></td>

                                    </tr>              



                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="6"><strong>Nenhum cliente ativo neste cedente.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            

                            

                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333"; colspan="6"><strong>CLIENTES INATIVOS</strong></td>

                        </tr>

                        

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 25% !important; "><strong>Razão Social</strong></td>

                            <td style="width: 4% !important; "><strong>Vencimento</strong></td>

                            <td style="width: 7% !important; "><strong>Pagamento</strong></td>

                            <td style="width: 7% !important; "><strong>Fechamento</strong></td>

                            <td style="width: 6% !important; "><strong>Guias/Nota</strong></td>

                            <td style="width: 51% !important; "><strong>Endereço</strong></td>

                        </tr>

                                                

                        	<?

								# Clientes Inativos

								if(count($valor->clientes_inativos)>0){

									foreach($valor->clientes_inativos as $valor_inativo){

							?>

                   

                                    <tr> 

                                        <td><? echo substr($valor_inativo->razaosocial, 0, 35); ?></td>

                                        <td><? echo $valor_inativo->vencimento; ?></td>

                                        <td><? echo $valor_inativo->forma_de_pagamento; ?></td>

                                        <td><? echo $valor_inativo->fechamento_de." à ".$valor_inativo->fechamento_a; ?></td>

                                        <td><? echo $valor_inativo->guias; ?> / <? echo $valor_inativo->nota; ?></td>

                                        <td><? echo $valor_inativo->fat_endereco; ?>, <? echo $valor_inativo->fat_endereco_numero; ?> - <? echo $valor_inativo->fat_endereco_cep; ?> - <? echo $valor_inativo->fat_endereco_bairro; ?>, <? echo $valor_inativo->fat_endereco_cidade; ?> - <? echo $valor_inativo->fat_endereco_estado; ?></td>

                                    </tr>                



                            <? 

									} # Fecha clientes Inativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="6"><strong>Nenhum cliente inativo neste cedente.</strong></td>

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



