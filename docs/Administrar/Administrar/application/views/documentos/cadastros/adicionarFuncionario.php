
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/documentos/js/documentos.js"></script>




<? 
	#Define Títulos Topo
	if($this->router->method=="funcionarioEditar")
	{
		$tituloBase = "Editar Documentação de Funcionário";
	} 
	else
	{
		$tituloBase = "Cadastro de Documentação para Funcionários"; 
	}
	
?>


<div class="row-fluid" style="margin-top:-30px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content" style="height: 300px">
                <div class="span12" id="divdesconto" style=" margin-left: 0">
                    <div class="tab-content" style="height: 300px">
                        <div class="tab-pane active" id="tab1">
                        
		    	
                <form action="<? echo current_url(); ?>" class="form-inline" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<?php 
                    if($this->router->method=="funcionarioEditar"){
                       echo form_hidden('idDocumento',$result[0]->idDocumento);
                    }
                ?>

                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Documento</legend>
						<div class="line">
							<p>
							  <label class="control-label">Cliente</label>
							  <select class="input-xxlarge" name="idAdministrador" id="idAdministrador" style="width: 715px !important;" autofocus>
							    <option value="">Selecione o Funcionário</option>
							    <? foreach($this->data['listaFuncionario'] as $listaFuncionario){ ?>
							    <option value="<? echo $listaFuncionario->idFuncionario; ?>" <? if(isset($result[0]->idAdministrador)){ if($listaFuncionario->idFuncionario==$result[0]->idAdministrador){ echo "selected"; } } ?>><? echo $listaFuncionario->nome; ?></option>
							    <? } ?>
						      </select>
							  <br>
						  </p>
							<p>&nbsp; </p>
						</div>
						
						<div class="line">
							<label class="control-label">Nome do Arquivo</label>
							<input id="dp1" class="input-small" style="width: 701px !important;" name="nomearquivo" value="<? if(isset($result[0]->nomearquivo)){ echo $result[0]->nomearquivo; } ?>" type="text" placeholder="Nome do Arquivo" >
						</div>
                        <? if(isset($result[0]->arquivo)){ ?>
                        <div class="line">
                        	<label class="control-label">Baixar Atual </label>
                        	<a href="<?=base_url();?>documentos/download/<?=$result[0]->idDocumento;?>" target="_blank"><strong><? echo $result[0]->arquivo; ?></strong></a>
                        </div>
                        <? } ?>
						
						<? if (!isset($result[0]->arquivo) || $result[0]->arquivo == "") { ?>
                        <div class="line">
                        	<label class="control-label">Arquivo </label>
                        	<input id="arquivo" type="file" class="input-small" name="userfile" /> (txt|pdf|gif|png|jpg|jpeg)
                        </div>
                        <?php } ?>
                        
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->router->method=="funcionarioEditar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>documentos/funcionario" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

