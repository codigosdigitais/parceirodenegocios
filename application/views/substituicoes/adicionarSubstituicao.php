<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/substituicoes/js/substituicoes.js"></script>

<?

	#Define Títulos Topo
	if($this->uri->segment(2)=="editar")
	{
		$tituloBase = "Editar Substituição";
	} 
	else
	{
		$tituloBase = "Cadastro de Substituição"; 
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
                        <form class="form-inline" method="post" action="<?php echo current_url(); ?>">
                            <?php 
                                if($this->uri->segment(2)=="editar"){
                                    echo form_hidden('idSubstituicao',$result[0]->idSubstituicao);
                                } 
                            ?>
               
                            <fieldset>
                            <legend><i class="icon-plus icon-title"></i> Nova Substituição</legend>
                                    
                                    <div class="line">
                                        <label class="control-label" >Cliente</label>
                                        <select class="input-large" name="idCliente" onchange="clienteChange()" id="idCliente" style="width: 380px !important;" autofocus required>
                                            <option value="">Selecione o Cliente</option>
											<? foreach($this->data['listaCliente'] as $clienteLista){ ?>
                                            <option value="<? echo $clienteLista->idCliente; ?>" <? if(isset($result[0]->idCliente)){ if($result[0]->idCliente==$clienteLista->idCliente){ echo "selected"; } } ?>><? echo $clienteLista->razaosocial; ?></option>
                                            <? } ?>
                                        </select>
                                        
                                        <label class="control-label">Solicitante</label>
                                        <select class="input-small selectSolicitante" name="solicitante" id="solicitante" style="width: 225px;" 
                                        
                                     	<?
											if($this->uri->segment(2)=="editar" && isset($result[0]->listaSubstCliente[0]->idClienteResponsavel)){
                                       			echo 'role="' . $result[0]->listaSubstCliente[0]->idClienteResponsavel . '"';
											}
                                        ?>
                                        >    
                                        	<option></option>
                                        </select>                                        

                                    </div>
                                    
                                    <div class="line">
                                        <label class="control-label" >Func. Falta</label>
                                        <select class="input-large" name="idFuncionario" id="idFuncionario" style="width: 737px !important;" required>
                                            <option value=""></option>
                                            
                                            	<? foreach($this->data['listaFuncionario'] as $funcionarioLista){ ?>
                                                <option value="<? echo $funcionarioLista->idFuncionario; ?>" <? if(isset($result[0]->idFuncionario)){ if($result[0]->idFuncionario==$funcionarioLista->idFuncionario){ echo "selected"; } } ?>><? echo $funcionarioLista->nome; ?></option>
                                                <? } ?>                                            
                                        </select>
                                    </div>
                                    
                                    <div class="line">
                                        <label class="control-label" >Func. Substit.</label>
                                        <select class="input-large" name="idFuncionarioSubstituto" id="idFuncionarioSubstituto" style="width: 737px !important;" required>
                                            <option value=""></option>
                                            
                                            	<? foreach($this->data['listaFuncionario'] as $funcionarioLista){ ?>
                                                <option value="<? echo $funcionarioLista->idFuncionario; ?>" <? if(isset($result[0]->idFuncionarioSubstituto)){ if($result[0]->idFuncionarioSubstituto==$funcionarioLista->idFuncionario){ echo "selected"; } } ?>><? echo $funcionarioLista->nome; ?></option>
                                                <? } ?>                                            
                                        </select>
                                    </div>
                                    
                                    <div class="line">
                                        <label class="control-label">Data</label>
                                        <input id="data" class="input-small" style="width: 135px;" name="data" value="<? if(isset($result[0]->data)){ echo $result[0]->data; } ?>" type="date" required="required">
                                        
                                        <label class="control-label" style="width: 78px !important;">Manhã</label>
                                        <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" name="subst_das" value="<? if(isset($result[0]->subst_das)){ echo $result[0]->subst_das; } ?>" type="time" style="background-color: #ffffff !important; border-radius: 0px !important; width: 70px !important;">
                                        
                                        <label class="control-label" style="width: 25px !important;">às</label>                                        
                                        <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" name="subst_as" value="<? if(isset($result[0]->subst_as)){ echo $result[0]->subst_as; } ?>" type="time" style="background-color: #ffffff !important; border-radius: 0px !important; width: 70px !important;">
                                      <label class="control-label" style="width: 70px !important;">Tarde</label>                                        
                                        <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" name="subst_das2" value="<? if(isset($result[0]->subst_das2)){ echo $result[0]->subst_das2; } ?>" type="time" style="background-color: #ffffff !important; border-radius: 0px !important; width: 70px !important;">
                                        <label class="control-label" style="width: 25px !important;">às</label>
                                        <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" name="subst_as2" value="<? if(isset($result[0]->subst_as2)){ echo $result[0]->subst_as2; } ?>" type="time" style="background-color: #ffffff !important; border-radius: 0px !important; width: 70px !important;">
                                        
  
                                        
                                    </div>

                                    
                                    <div class="line">
                                    
                                      <label class="control-label">Período</label>
                                        <select name="periodo" class="input-medium">
                                            <option value="">Selecione</option>
                                                <option value="102" <? if(isset($result[0]->periodo)){ if($result[0]->periodo==102){ echo "selected"; } } ?> >INTEGRAL</option>
                                                <option value="101" <? if(isset($result[0]->periodo)){ if($result[0]->periodo==101){ echo "selected"; } } ?>>MEIO PERIODO</option>
                                        </select>
                                    
                                        <label class="control-label">Detalhes</label>
                                        <input class="input-xxlarge" style="width: 438px !important;" name="detalhes" value="<? if(isset($result[0]->detalhes)){ echo $result[0]->detalhes; } ?>" type="text">						
                                    </div>                                    
                                    <div class="button-form line">										    
                                        <div class="span6 offset3" style="text-align: center">
                                        <? if($this->uri->segment(2)=="editar"){ ?>
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                        <? } else { ?>
                                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                                        <? } ?>
                                        <a href="<?php echo base_url() ?>substituicoes" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>
                                
                                </fieldset>
                            </form>
	
            </div>
        
    </div>
    

</div>
</div>
<script>
function clienteChange() {
	var id = $('#idCliente').val();
	$(".selectSolicitante").append('<option value="0">Carregando...</option>');
	$.post("<? echo base_url(''); ?>substituicoes/ajax/solicitante/"+id,
		{solicitante:jQuery(id).val()},
		function(valor){
			 $(".selectSolicitante").html(valor).after(function(){ 
				 
				if ($('#solicitante').attr('role') != "" ) {
					$('#solicitante option[value="'+$('#solicitante').attr('role')+'"]').attr('selected', true);
					$('#solicitante').removeAttr('role')
				}
			});;
		}
	);
}
</script>