<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Parâmetro";
	} 
	else
	{
		$tituloBase = "Cadastro de Parâmetro"; 
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
            <div class="widget-content nopadding">
                <div class="span12" id="divParametro" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
							<form action="<?php echo current_url(); ?>" method="post" id="formParametro">
                            
                            	
                                <div class="span12" id="divParametroCadastrarDados">
                                
                              			<?php 
											if($this->router->method=="editar"){
												echo form_hidden('idParametro',$result->idParametro);
											} 
										?>
										
										<?php if($custom_error == true){ ?>
                                        <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">
                                            Dados incompletos, verifique os campos com asterisco
                                        </div>
                                        <?php } ?>

                                        
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <label for="parametroCategoria">Parâmetro Categoria</label>
                                            <select class="span12" name="idParametroCategoria" id="idParametroCategoria">
                                            	<option value="0">Categoria Base</option>
												<? foreach($this->data['parametrosCategoria'] as $valor){ ?>
                                                <option value="<? echo $valor->idParametro;?>" <? if(isset($result->idParametroCategoria) && $result->idParametroCategoria==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro;?></option>
                                                <? } ?>
                                            </select>
                                        </div>

                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <label for="parametro">Código</label>
                                            <input id="codigoeSocial" class="span12" type="text" name="parametro" value="<? if(isset($result->codigoeSocial)){ echo $result->codigoeSocial; } ;?>"  placeholder="Código eSocial"  />
                                        </div>
 
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <label for="parametro">Parâmetro *</label>
                                            <input id="parametro" class="span12" type="text" name="parametro" value="<? if(isset($result->parametro)){ echo $result->parametro; } ;?>"  placeholder="Sub-Categoria Parâmetro"  />
                                        </div>
                                        
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <label for="parametro">Descrição</label>
                                            <input id="parametro" class="span12" type="text" name="dsceSocial" value="<? if(isset($result->dsceSocial)){ echo $result->dsceSocial; } ;?>"  placeholder="Descrição eSocial"  />
                                        </div>
                                        
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span6 offset3" style="text-align: center">
                                            	<? if($this->router->method=="editar"){ ?>
                                                	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                                <? } else { ?>
                                                	<button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                                                <? } ?>
                                                <a href="<?php echo base_url() ?>parametro" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                            </div>
                                        </div>
                                        
                                    
                                </div>
							</form>
                        </div>

                    </div>

                </div>

                
.
             
        </div>
        
    </div>
</div>
</div>
