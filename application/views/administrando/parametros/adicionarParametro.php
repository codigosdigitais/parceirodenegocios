<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<?
	#Define Títulos Topo
	if($this->uri->segment(2)=="parametrosEditar")
	{
		$tituloBase = "Editar Parâmetro";
	} 
	else
	{
		$tituloBase = "Cadastro de Parâmetro"; 
	}

	
?>



<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Cadastro de Parâmetro</li></ol>
    <ol class="breadcrumb"> 

        <a href="<?php echo base_url();?>administrando/parametros" class="btn btn-primary"><i class="icon-plus icon-white"></i> Listar Parâmetros</a>

        <a href="<?php echo base_url();?>relatorios/contratos" class="btn btn-danger" style="width: 125px;"><i class="icon-check icon-white"></i> Relatório</a>
        
    </ol>
</nav>

<form action="<?php echo current_url(); ?>" method="post" id="formParametro">
    <div class="span12" id="divParametroCadastrarDados">
    
  			<?php 
				if($this->uri->segment(2)=="parametrosEditar"){
					if(!empty($_GET['tipo_parametro'])){ echo form_hidden('tipo_parametro',$_GET['tipo_parametro']); }
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
                <label for="codigoeSocial">Código</label>
                <input id="codigoeSocial" class="span12" type="text" name="codigoeSocial" value="<? if(isset($result->codigoeSocial)){ echo $result->codigoeSocial; } ;?>"  placeholder="Código eSocial"  />
            </div>

            <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                <label for="parametro">Parâmetro *</label>
                <input id="parametro" class="span12" type="text" name="parametro" value="<? if(isset($result->parametro)){ echo $result->parametro; } ;?>"  placeholder="Sub-Categoria Parâmetro"  />
            </div>
            
            <div class="span12 " style="padding: 1%; margin-left: 0">
                <label for="dsceSocial">Descrição</label>
                <textarea name="dsceSocial" class="input-xxlarge" style="height: 90px; width: 99%;"><? if(isset($result->dsceSocial)){ echo $result->dsceSocial; } ?></textarea>
            </div>
            

            <div class="span12" style="padding: 1%; margin-left: 0">
                <hr>
                <div class="span12 pull-right">

                	<? if($this->uri->segment(2)=="parametrosEditar"){ ?>
                    	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                    <? } else { ?>
                    	<button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                    <? } ?>
                    <a href="<?php echo base_url() ?>administrando/parametros" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                </div>
            </div>
            
        
    </div>
</form>
