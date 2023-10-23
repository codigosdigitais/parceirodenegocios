<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Cidade";
	} 
	else
	{
		$tituloBase = "Cadastro de Cidade"; 
	}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?=$tituloBase;?></li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert() && !$this->router->method=="editar"){ ?>
        <a href="<?php echo base_url();?>cidade/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Novo</a>
    <?php } ?>
    <a title="Voltar" class="btn btn-danger" href="<?php echo base_url().'cidade/'; ?>"><i class="icon-list icon-white"></i> Listar todos</a>
    </ol>
</nav>


<form action="<?php echo current_url(); ?>" method="post" id="formCidade">
    <div class="span12" id="divCadastrarCidade">  
  			<?php 
				if($this->router->method=="editar"){
					echo form_hidden('idCidade',$result->idCidade);
				} 
			?>
			
			<?php if($custom_error == true){ ?>
            <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">
                Dados incompletos, verifique os campos com asterisco
            </div>
            <?php } ?>
            
            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <div class="span6">
                    <label for="idEstado">Estado *</label>
					<select class="span12" name="idEstado" id="idEstado" value="">
                    <? foreach($this->data['estados'] as $valor){ ?>
                        <option value="<? echo $valor->idEstado;?>" <? if(isset($result->idEstado) and $valor->idEstado==$result->idEstado or $valor->idEstado=='41'){ echo "selected"; }  ?> ><? echo $valor->estado;?></option>
                    <? } ?>
                    </select>
                </div>
                <div class="span6">
                    <label for="idTipo">Tipo</label>
                    <select class="span12" name="idTipo" id="idTipo" value="">
                        <option value="1"  <? if(isset($result->idTipo) and $result->idTipo=='1'){ echo "selected"; }  ?> >Capital</option>
                        <option value="2" <? if(isset($result->idTipo) and $result->idTipo=='2'){ echo "selected"; }  ?>>Metropolitano</option>
                        <option value="3" <? if(isset($result->idTipo) and $result->idTipo=='3'){ echo "selected"; }  ?>>Interior</option>
                    </select>
                </div>
            </div>

            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <label for="cidade">Cidade *</label>
                <input id="cidade" class="span12" type="text" name="cidade" value="<? if(isset($result->cidade)){ echo $result->cidade; } ;?>"  placeholder="Cidade"  />
            </div>
            
            
            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <hr>
                <div class="pull-right">
                	<? if($this->router->method=="editar"){ ?>
                    	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                    <? } else { ?>
                    	<button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                    <? } ?>
                    <a href="<?php echo base_url() ?>cidade" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                </div>
            </div>
    </div>
</form>
