<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/geral.js"></script>

<!--- Estrutura Interna --->
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/formularios.css" />

<?
	#Define Títulos Topo
	if($this->uri->segment(2)=="modulosEditar")
	{
		$tituloBase = "Editar Módulo";
	} 
	else
	{
		$tituloBase = "Cadastro de Módulos"; 
	}
//	echo $this->uri->segment(2);
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
                        if($this->uri->segment(2)=="modulosEditar"){
                            echo form_hidden('idModulo',$result->idModulo);
                        } 
						
						if($this->uri->segment(2)=="modulosAdicionar"){
							echo form_hidden('datacriacao', date("Y-m-d H:i:s"));
						}
                    ?>
                    <fieldset>
                        <div class="line">
                            <label for="parametroCategoria" class="control-label">Módulo Base</label>
                            <select class="input" name="idModuloBase" id="idModuloBase">
                                <option value="0">Módulo Base</option>
                                <? foreach($this->data['modulosBase'] as $valor){ ?>
                                <option value="<? echo $valor->idModulo;?>" <? if(isset($result->idModuloBase) && $result->idModuloBase==$valor->idModulo){ echo "selected"; } ?>><? echo $valor->modulo;?></option>
                                <? } ?>
                            </select>
                        </div>
                        
                        <div class="line">
                            <label class="control-label">Módulo Auxiliar</label>
                            <input class="input-xxlarge" type="text" placeholder="Nome do Módulo" name="modulo" value="<? if(isset($result->modulo)){ echo $result->modulo; } ;?>" required="required">
                        </div>				    	
                        
                        <div class="line">
                            <label class="control-label">Pasta Principal</label>
                            <input class="input-xxlarge" type="text" placeholder="Pasta Principal" name="pasta" value="<? if(isset($result->pasta)){ echo $result->pasta; } ;?>" required="required">
                        </div>
                        
                    
                        <div class="line">
                            <label class="control-label">Status</label>
                            <select class="input-small" style="width: 97px !important;" name="status" required>
                                <option value="">Selecione</option>
                                <option value="0" <? if(isset($result->status)){ if($result->status=="0"){ echo "selected"; } } ?>>Ativo</option>
                                <option value="1" <? if(isset($result->status)){ if($result->status=="1"){ echo "selected"; } } ?>>Inativo</option>
                                <option value="2" <? if(isset($result->status)){ if($result->status=="2"){ echo "selected"; } } ?>>Bloqueado</option>
                            </select>
                        </div>
                                            
                        <div class="button-form line">										    
                            <div class="span6 offset3" style="text-align: center">
                            <? if($this->uri->segment(2)=="modulosEditar"){ ?>
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                            <? } else { ?>
                                <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                            <? } ?>
                            <a href="<?php echo base_url() ?>administrando/modulos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </fieldset>
                </form>

			</div>
		</div>
    </div>
</div>
