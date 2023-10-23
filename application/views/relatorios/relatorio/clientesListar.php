<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />

<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/geral.js"></script>



<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/chosen.css" />

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>



<!--- Estrutura Interna --->

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/formularios.css" />





<style>



.table th, .table td {

    padding: 6px;

    line-height: 5px;

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

					if(!empty($_POST['campo'])) 

					foreach($_POST['campo'] as $campo){

						if($campo=="status" or count($campo)==0){

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

                                <button class="btn btn-inverse span12" style="background-color: red"><? echo count($results[0]->clientes_ativos); ?></button>

                            </div>

                            

                            <div class="span2">

                                <label for="">Clientes Inativos</label>

                                <button class="btn btn-inverse span12"> <? echo count($results[0]->clientes_inativos); ?> </button>

                            </div>

                            <div class="span2">

                                <label for="">&nbsp;</label>

                                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>

                            </div>

                            

                            <input type="hidden" id="campo[]" name="campo[]" value="status">

                        </form>

                    </div>

                    <table class="table table-bordered">

                        <tr>

                            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">CLIENTES ATIVOS</td>

                        </tr> 

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 60% !important; "><strong>Nome Fantasia</strong></td>

                            <td style="width: 15% !important; "><strong>CNPJ</strong></td>

                            <td style="width: 15% !important; "><strong>Data de Cadastro</strong></td>

                            <td style="width: 10% !important; "><strong>Status</strong></td>

                        </tr>

                    <?

                        foreach($results[0]->clientes_ativos as $valor){

                    ?>

                        <tr>

                            <td><? echo substr($valor->razaosocial, 0, 80); ?></td>

                            <td><? echo $valor->cnpj; ?></td>

                            <td><? echo date("d/m/Y", strtotime($valor->data_ativo)); ?></td>

                            <td><? if($valor->status==0) echo "ATIVO"; else echo "INATIVO"; ?></td>

                        </tr>

                    <? 

                        } 

                    ?>

                    </table>

                    

                    

                    <table class="table table-bordered">

                        <tr>

                            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">CLIENTES INATIVOS</td>

                        </tr> 

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 60% !important; "><strong>Nome Fantasia</strong></td>

                            <td style="width: 15% !important; "><strong>CNPJ</strong></td>

                            <td style="width: 15% !important; "><strong>Data de Cadastro</strong></td>

                            <td style="width: 10% !important; "><strong>Status</strong></td>

                        </tr>

                    <?

                        foreach($results[0]->clientes_inativos as $valor){

                    ?>

                        <tr>

                            <td><? echo substr($valor->razaosocial, 0, 80); ?></td>

                            <td><? echo $valor->cnpj; ?></td>

                            <td><? echo date("d/m/Y", strtotime($valor->data_ativo)); ?></td>

                            <td><? if($valor->status==0) echo "ATIVO"; else echo "INATIVO"; ?></td>

                        </tr>

                    <? 

                        } 

                    ?>

                    </table>



                    <? 

						}  

					} 

					?>

                    

                    

            		<?

						if($campo=="dados_empresa"){

							

					?>



                    <table class="table table-bordered">

                        <tr>

                            <td style="text-align:center; background-color: #666; color: #FFF" colspan="5">CLIENTES ATIVOS</td>

                        </tr> 

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 30% !important; "><strong>Razão Social</strong></td>

                            <td style="width: 10% !important; "><strong>CNPJ</strong></td>

                            <td style="width: 7% !important; "><strong>IE</strong></td>

                            <td style="width: 7% !important; "><strong>IM</strong></td>

                            <td style="width: 46% !important; "><strong>Endereço</strong></td>

                        </tr>

                    <?

                        foreach($results[0]->clientes_ativos as $valor){

                    ?>

                        <tr>

                            <td><? echo substr($valor->razaosocial, 0, 50); ?></td>

                            <td><? echo $valor->cnpj; ?></td>

                            <td><? echo $valor->ie; ?></td>

                            <td><? echo $valor->im; ?></td>

                            <td><? echo $valor->endereco; ?>, <? echo $valor->endereco_numero; ?> - <? echo $valor->endereco_cep; ?> - <? echo $valor->endereco_bairro; ?>, <? echo $valor->endereco_cidade; ?> - <? echo $valor->endereco_estado; ?></td>

                        </tr>



                    <? 

                        } 

                    ?>

                    </table>

                    

                    

                    <table class="table table-bordered">

                        <tr>

                            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">CLIENTES INATIVOS</td>

                        </tr> 

                        <tr style="background-color: #DEDEDE">

                            <td style="width: 60% !important; "><strong>Nome Fantasia</strong></td>

                            <td style="width: 15% !important; "><strong>CNPJ</strong></td>

                            <td style="width: 15% !important; "><strong>Data de Cadastro</strong></td>

                            <td style="width: 10% !important; "><strong>Status</strong></td>

                        </tr>

                    <?

                        foreach($results[0]->clientes_inativos as $valor){

                    ?>

                        <tr>

                            <td><? echo substr($valor->razaosocial, 0, 80); ?></td>

                            <td><? echo $valor->cnpj; ?></td>

                            <td><? echo date("d/m/Y", strtotime($valor->data_ativo)); ?></td>

                            <td><? if($valor->status==0) echo "ATIVO"; else echo "INATIVO"; ?></td>

                        </tr>

                    <? 

                        } 

                    ?>

                    </table>



                    <? 

						  

					} 

					?>

                    

                    

                    

                    

            </div>

        </div>

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


<div style="float:right"><img src="<? echo base_url("assets/img"); ?>/logo_empresa.jpg" /></div>
    <table class="table table-bordered">

        <tr>

            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">CLIENTES ATIVOS</td>

        </tr> 

        <tr style="background-color: #DEDEDE">

            <td style="width: 60% !important; "><strong>Nome Fantasia</strong></td>

            <td style="width: 15% !important; "><strong>CNPJ</strong></td>

            <td style="width: 15% !important; "><strong>Data de Cadastro</strong></td>

            <td style="width: 10% !important; "><strong>Status</strong></td>

        </tr>

    <?

        foreach($results[0]->clientes_ativos as $valor){

    ?>

        <tr>

            <td><? echo substr($valor->razaosocial, 0, 50); ?></td>

            <td><? echo $valor->cnpj; ?></td>

            <td><? echo date("d/m/Y", strtotime($valor->data_ativo)); ?></td>

            <td><? if($valor->status==0) echo "ATIVO"; else echo "INATIVO"; ?></td>

        </tr>

    <? 

        } 

    ?>

    </table>

    

    

    <table class="table table-bordered">

        <tr>

            <td style="text-align:center; background-color: #666; color: #FFF" colspan="4">CLIENTES INATIVOS</td>

        </tr> 

        <tr style="background-color: #DEDEDE">

            <td style="width: 60% !important; "><strong>Nome Fantasia</strong></td>

            <td style="width: 15% !important; "><strong>CNPJ</strong></td>

            <td style="width: 15% !important; "><strong>Data de Cadastro</strong></td>

            <td style="width: 10% !important; "><strong>Status</strong></td>

        </tr>

    <?

        foreach($results[0]->clientes_inativos as $valor){

    ?>

        <tr>

            <td><? echo substr($valor->razaosocial, 0, 80); ?></td>

            <td><? echo $valor->cnpj; ?></td>

            <td><? echo date("d/m/Y", strtotime($valor->data_ativo)); ?></td>

            <td><? if($valor->status==0) echo "ATIVO"; else echo "INATIVO"; ?></td>

        </tr>

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



