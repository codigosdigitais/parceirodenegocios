
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/atrasos/js/atrasos.js"></script>


<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Atraso";
		$subTitulo = "Editar Atraso";
	} 
	else
	{
		$tituloBase = "Cadastro de Atrasos";
		$subTitulo = "Novo Atraso"; 
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
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" style="height: 500px">
                        <div class="tab-pane active" id="tab1">
                        
		    	<form class="form-inline" method="post" action="<?php echo current_url(); ?>">
				<?php 
                    if($this->router->method=="editar"){
                        echo form_hidden('idAtraso',$result->idAtraso);
                    } 
                ?>

                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Atraso</legend>
						<div class="line">
							<label class="control-label">Tipo de Prov.</label>
							<select class="input-xxlarge" name="tipo" id="tipo" style="width: 715px !important;" autofocus>
							<option value="">Selecione o tipo de Atraso</option>
								<? foreach($this->data['parametroAtraso'] as $listaAtraso){ ?>
                                <option value="<? echo $listaAtraso->idParametro; ?>" <? if(isset($result->tipo)){ if($listaAtraso->idParametro==$result->tipo){ echo "selected"; } } ?>><? echo $listaAtraso->parametro; ?></option>
                                <? } ?>
							</select>
						</div>
						
						<div class="line">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge" name="idFuncionario" id="idFuncionario" style="width: 715px !important;">
								<option value="">Selecione o Funcionário</option>
								<?
                                    foreach($this->data['listaFuncionario'] as $funcionarioLista){ 
                                ?>
                                <option value="<?=$funcionarioLista->idFuncionario;?>" <? if(isset($result->idFuncionario)){ if($funcionarioLista->idFuncionario==$result->idFuncionario){ echo "selected"; } } ?> ><?=$funcionarioLista->nome;?></option>
                                <? } ?>								
							</select>
						</div>
						
						<div class="line">
							<label class="control-label">Data</label>
							<input id="dp1" class="input-small" onkeyup="mascaraData(this);" name="data" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="text" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy"  required="required">
							
							<label class="control-label" style="width: 45px !important;">Valor</label>
							<input class="input-small right money" id="valor" name="valor" type="text" value="<? if(isset($result->valor)){ echo $result->valor; } ?>" disabled style="width: 60px !important;" placeholder="0.00">
                            
                            <label class="control-label" style="width: 120px !important;">Hora Inicial</label>
							<input class="input-small" maxlength="5" name="hora_inicial" value="<? if(isset($result->hora_inicial)){ echo $result->hora_inicial; } ?>" type="time" required="required">
                            
                            <label class="control-label" style="width: 124px !important;">Hora Final	</label>
							<input class="input-small" maxlength="5" name="hora_final" value="<? if(isset($result->hora_final)){ echo $result->hora_final; } ?>" type="time" required="required">
							
						</div>
                        <div class="line">
                        <label class="control-label" style="width: 120px !important;">Detalhes</label>
							<input class="input-large" style="width: 702px !important;" name="detalhes" value="<? if(isset($result->detalhes)){ echo $result->detalhes; } ?>" type="text">
                        </div>
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->router->method=="editar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>atrasos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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