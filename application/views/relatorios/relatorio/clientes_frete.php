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

                            

                            <input type="hidden" id="campo[]" name="campo[]" value="dados_frete">

                        </form>

                    </div>

                    <table class="table table-bordered">

                    <?

                        foreach($results as $valor){

                    ?>

                        <tr>

                            <td style="text-align:left; background-color: #333333; color: #FFF"; ><strong><? echo $valor->cedente; ?></strong></td>

                        </tr>

                        <tr>

                          <td style="text-align:left; background-color: #CCC; color: #333";><strong>CLIENTES ATIVOS</strong></td>

                        </tr> 



                       



                                                

                        	<?

								# Clientes Ativos

								if(count($valor->clientes_ativos)>0){

									

									foreach($valor->clientes_ativos as $valor_ativo){

							?>

                                    <tr>

                                        <td style="text-align:left; background-color: #CCC; color: #333";><strong><? echo $valor_ativo->razaosocial; ?></strong></td>

                                    </tr>



                                    <tr> 

										<td>

                                        	

                                             <table class="table table-bordered">

                                                <thead>

                                                  <tr>

                                                    <th style="width:17%">Veículo</th>

                                                    <th style="width:16%">Normal</th>

                                                    <th style="width:16%">Metropolitano</th>

                                                    <th style="width:16%">M. Após as 18hs</th>

                                                    <th style="width:16%">Após as 18hs</th>

                                                    <th style="width:16%">KM</th>

                                                  </tr>

                                                </thead>

                                                <tbody>

                                                  <tr>

                                                    <td><strong>Moto</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Carro</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Van</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Caminhão</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                </tbody>

                                              </table>

                                        	

                                        </td>

                                    </tr>              





                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="5"><strong>Nenhum cliente ativo neste cedente.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            

                            

                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333";><strong>CLIENTES INATIVOS</strong></td>

                        </tr>

                        

                                               

                        	<?

								# Clientes Inativos

								if(count($valor->clientes_inativos)>0){

									

									foreach($valor->clientes_inativos as $valor_inativo){

							?>

                                    <tr>

                                        <td style="text-align:left; background-color: #CCC; color: #333";><strong><? echo $valor_inativo->razaosocial; ?></strong></td>

                                    </tr>

                                    

                                    <tr>

                                    	<td>

                                             <table class="table table-bordered">

                                                <thead>

                                                  <tr>

                                                    <th style="width:17%">Veículo</th>

                                                    <th style="width:16%">Normal</th>

                                                    <th style="width:16%">Metropolitano</th>

                                                    <th style="width:16%">M. Após as 18hs</th>

                                                    <th style="width:16%">Após as 18hs</th>

                                                    <th style="width:16%">KM</th>

                                                  </tr>

                                                </thead>

                                                <tbody>

                                                  <tr>

                                                    <td><strong>Moto</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Carro</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Van</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Caminhão</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                </tbody>

                                              </table>



                                        </td>

                                    </tr>





                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center";><strong>Nenhum cliente ativo neste cedente.</strong></td>

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

                            <td style="text-align:left; background-color: #333333; color: #FFF"; ><strong><? echo $valor->cedente; ?></strong></td>

                        </tr>

                        <tr>

                          <td style="text-align:left; background-color: #CCC; color: #333";><strong>CLIENTES ATIVOS</strong></td>

                        </tr> 



                       



                                                

                        	<?

								# Clientes Ativos

								if(count($valor->clientes_ativos)>0){

									

									foreach($valor->clientes_ativos as $valor_ativo){

							?>

                                    <tr>

                                        <td style="text-align:left; background-color: #CCC; color: #333";><strong><? echo $valor_ativo->razaosocial; ?></strong></td>

                                    </tr>



                                    <tr> 

										<td>

                                        	

                                             <table class="table table-bordered">

                                                <thead>

                                                  <tr>

                                                    <th style="width:17%">Veículo</th>

                                                    <th style="width:16%">Normal</th>

                                                    <th style="width:16%">Metropolitano</th>

                                                    <th style="width:16%">M. Após as 18hs</th>

                                                    <th style="width:16%">Após as 18hs</th>

                                                    <th style="width:16%">KM</th>

                                                  </tr>

                                                </thead>

                                                <tbody>

                                                  <tr>

                                                    <td><strong>Moto</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_moto_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Carro</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_carro_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Van</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_van_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Caminhão</strong></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_ativo->valor_caminhao_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                </tbody>

                                              </table>

                                        	

                                        </td>

                                    </tr>              





                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center"; colspan="5"><strong>Nenhum cliente ativo neste cedente.</strong></td>

                            </tr>

                            <?	

								}

							?>

                            

                            

                        <tr>

                            <td style="text-align:left; background-color: #CCC; color: #333";><strong>CLIENTES INATIVOS</strong></td>

                        </tr>

                        

                                               

                        	<?

								# Clientes Inativos

								if(count($valor->clientes_inativos)>0){

									

									foreach($valor->clientes_inativos as $valor_inativo){

							?>

                                    <tr>

                                        <td style="text-align:left; background-color: #CCC; color: #333";><strong><? echo $valor_inativo->razaosocial; ?></strong></td>

                                    </tr>

                                    

                                    <tr>

                                    	<td>

                                             <table class="table table-bordered">

                                                <thead>

                                                  <tr>

                                                    <th style="width:17%">Veículo</th>

                                                    <th style="width:16%">Normal</th>

                                                    <th style="width:16%">Metropolitano</th>

                                                    <th style="width:16%">M. Após as 18hs</th>

                                                    <th style="width:16%">Após as 18hs</th>

                                                    <th style="width:16%">KM</th>

                                                  </tr>

                                                </thead>

                                                <tbody>

                                                  <tr>

                                                    <td><strong>Moto</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_moto_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Carro</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_carro_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Van</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_van_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                  <tr>

                                                    <td><strong>Caminhão</strong></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_normal, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_metropolitano, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_metropolitano_apos18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_depois_18, "2", ",", "."); ?></td>

                                                    <td>R$ <? echo number_format($valor_inativo->valor_caminhao_km, "2", ",", "."); ?></td>

                                                  </tr>

                                                </tbody>

                                              </table>



                                        </td>

                                    </tr>





                            <? 

									} # Fecha clientes Ativos 

								} else {

							?>

                            <tr>

                                <td style="text-align:center";><strong>Nenhum cliente ativo neste cedente.</strong></td>

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



