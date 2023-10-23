
<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Bairro";
	} 
	else
	{
		$tituloBase = "Cadastro de Bairro"; 
	}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?=$tituloBase;?></li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert() && !$this->router->method=="editar"){ ?>
        <a href="<?php echo base_url();?>bairro/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Novo</a>
    <?php } ?>
    <a title="Voltar" class="btn btn-danger" href="<?php echo base_url().'bairro/'; ?>"><i class="icon-list icon-white"></i> Listar todos</a>
    </ol>
</nav>


<form action="<?php echo current_url(); ?>" method="post" id="formbairro">
    <div class="span12" id="divCadastrarBairro">
      			<?php 
				if($this->router->method=="editar"){
					echo form_hidden('idBairro',$result->idBairro);
				} 
			?>
			
			<?php if($custom_error == true){ ?>
            <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">
                Dados incompletos, verifique os campos com asterisco
            </div>
            <?php } ?>

            
            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <div class="span6">
                    <label for="idEstado">Cidade *</label>
					<select class="span12" name="idCidade" id="idCidade" value="">
                    <? foreach($this->data['cidades'] as $valor){ ?>
                        <option value="<? echo $valor->idCidade;?>" <? if(isset($result->idCidade) and $valor->idCidade==$result->idCidade){ echo "selected"; }  ?> ><? echo $valor->cidade;?></option>
                    <? } ?>
                    </select>
                </div>
                <div class="span6">
                    <label for="idTipo">Bairro Tipo</label>
                    <select class="span12" name="idTipo" id="idTipo" value="">
                        <option value="1"  <? if(isset($result->idTipo) and $result->idTipo=='1'){ echo "selected"; }  ?> >Centro</option>
                        <option value="2" <? if(isset($result->idTipo) and $result->idTipo=='2'){ echo "selected"; }  ?>>Bairro</option>
                        <option value="3" <? if(isset($result->idTipo) and $result->idTipo=='3'){ echo "selected"; }  ?>>Afastado</option>
                    </select>
                </div>
            </div>

            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <label for="bairro">Bairro *</label>
                <input id="bairro" class="span12" type="text" name="bairro" value="<? if(isset($result->bairro)){ echo $result->bairro; } ;?>"  placeholder="Bairro"  />
            </div>
            
            <div class="span12" style="padding: 1%; margin-left: 0">

                <hr>

                <div class="pull-right">
                	<? if($this->router->method=="editar"){ ?>
                    	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                    <? } else { ?>
                    	<button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                    <? } ?>
                    <a href="<?php echo base_url() ?>bairro" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                </div>
            </div>
            
        
    </div>
</form>
