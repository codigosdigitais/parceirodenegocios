<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/proventos/js/proventos.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Provento";
	} 
	else
	{
		$tituloBase = "Cadastro de Provento"; 
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
            <div class="widget-content">
		    	<form class="form-inline" method="post" action="<?php echo current_url(); ?>/alterando">
				<?php 
                    if($this->uri->segment(3)=="editar"){
                        echo form_hidden('idProvento',$result->idProvento);
						echo form_hidden('idFuncionario',$result->idFuncionario);
                    } 
                ?>

                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Provento</legend>
						<div class="line">
							<label class="control-label">Tipo de Prov.</label>
							<select class="input-xxlarge" name="tipo" id="tipo" style="width: 715px !important;" autofocus>
							<option value="">Selecione o Tipo de Provento</option>
								<? foreach($this->data['parametroProvento'] as $listaProvento){ ?>
                                <option value="<? echo $listaProvento->idParametro; ?>" <? if(isset($result->tipo)){ if($listaProvento->idParametro==$result->tipo){ echo "selected"; } } ?> disabled><? echo $listaProvento->parametro; ?></option>
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
                                <option value="<?=$funcionarioLista->idFuncionario;?>" <? if(isset($result->idFuncionario)){ if($funcionarioLista->idFuncionario==$result->idFuncionario){ echo "selected"; } } ?> disabled ><?=$funcionarioLista->nome;?></option>
                                <? } ?>								
							</select>
						</div>
						
						<div class="line">
							<label class="control-label">Data</label>
							<input id="data" class="input-small" style="width: 150px"  name="data" value="<? if(isset($result->data)){ echo $result->data; } ?>" type="date" required="required">
							
							<label class="control-label" style="width: 45px !important;">Valor</label>
							<input class="input-small right money" id="valor" name="valor" type="text" value="<? if(isset($result->valor)){ echo $result->valor; } ?>" style="width: 60px !important;" placeholder="0.00">
							
							<label class="control-label" style="width: 70px !important;">Detalhes</label>
							<input class="input-large" style="width: 322px !important;" name="detalhes" value="<? if(isset($result->detalhes)){ echo $result->detalhes; } ?>" type="text">
						</div>
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->uri->segment(3)=="editar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>proventos/lista" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
		    	</fieldset>
	    	</form>

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