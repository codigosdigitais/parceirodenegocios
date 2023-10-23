<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<!--- Estrutura Interna --->
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/adicional/js/adicionalc.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>assets/controllers/sobreescrever/css/formularios.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/controllers/sobreescrever/css/chosen.css" />




<?
	#Define Títulos Topo
	if($this->uri->segment(2)=="editar")
	{
		$tituloBase = "Editar Adicional para Funcionário";
	} 
	else
	{
		$tituloBase = "Cadastro de Adicional para Funcionário"; 
	}
?>


<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content" style="height: 600px">
                <div class="span12" id="divdesconto" style=" margin-left: 0">
                    <div class="tab-content" style="height: 500px">
                        <div class="tab-pane active" id="tab1">
                        
		    	<form class="form-inline" method="post" action="<?php echo current_url(); ?>">
				<?php 
                    if($this->uri->segment(2)=="editar"){
                        echo form_hidden('idAdicional',$result->idAdicional);
                    } 
                ?>

                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Adicional</legend>
                        <div class="line">
							<p>
							  <label class="control-label">Tipo de Adicional</label>
                                <select class="input-xxlarge" name="tipoValor" id="tipoValor" style="width: 205px !important;">
							    <option value="C">CRÉDITO</option>
							    <option value="D">DÉBITO</option>
						      </select>
							  <br>
						  </p>
							<p>&nbsp; </p>
						</div>
						<div class="line">
							<p>
							  <label class="control-label">Tipo</label>
							  <select class="input-xxlarge" name="idParametro" id="idParametro" style="width: 715px !important;" autofocus>
							    <option value="">Selecione o Tipo</option>
							    <? foreach($this->data['parametroDesconto'] as $listaDesconto){ ?>
							    <option value="<? echo $listaDesconto->idParametro; ?>" <? if(isset($result->idParametro)){ if($listaDesconto->idParametro==$result->idParametro){ echo "selected"; } } ?>><? echo $listaDesconto->parametro; ?></option>
							    <? } ?>
						      </select>
							  <br>
						  </p>
							<p>&nbsp; </p>
						</div>
						
						<div class="line">
							<label class="control-label">Cliente</label>
							<select class="input-xxlarge" name="idAdministrativo" id="idAdministrativo" style="width: 715px !important;" required>
								<option value="">Selecione o Cliente</option>
								<?
                                    foreach($this->data['listaFuncionario'] as $funcionarioLista){ 
                                ?>
                                <option value="<?=$funcionarioLista->idCliente;?>" <? if(isset($result->idAdministrativo)){ if($funcionarioLista->idCliente==$result->idAdministrativo){ echo "selected"; } } ?> ><?=$funcionarioLista->razaosocial;?></option>
                                <? } ?>								
							</select>
						</div>
						
						<div class="line">
							<label class="control-label">Data</label>
							<input id="dp1" class="input-small" onkeyup="mascaraData(this);" name="data" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="text" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy"  required="required">
							
							<label class="control-label" style="width: 45px !important;">Valor</label>
							<input class="input-small right money" id="valor" name="valor" type="text" value="<? if(isset($result->valor)){ echo $result->valor; } ?>" style="width: 60px !important;" placeholder="0.00">
							
							<label class="control-label" style="width: 70px !important;">Detalhes</label>
							<input class="input-large" style="width: 381px !important;" name="detalhes" value="<? if(isset($result->detalhes)){ echo $result->detalhes; } ?>" type="text">
						</div>
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->uri->segment(2)=="editar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>adicionaisc" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
		    	</fieldset>
	    	</form>
							
                        </div>

                    </div>

                </div>

                

             
        </div>
        
    </div>
</div>
</div>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>

<script type="text/javascript">
      $(document).ready(function(){
		  
		  $(".money").maskMoney();
		  
           $('#formFuncionario').validate({
            rules :{
                  nome:{ required: true},
            },
            messages:{
                  nome :{ required: ''},
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
      });
</script>