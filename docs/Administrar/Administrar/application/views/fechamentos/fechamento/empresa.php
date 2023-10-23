<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/fechamentos/chamadas/js/chamadas.js"></script>

<?
	#Define Títulos Topo
	$tituloBase = "Fechamento de Empresa";
	$subTitulo = "Pesquisar"; 
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
            <div class="widget-content" style="height: 600px">
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" style="height: 500px">
                        <div class="tab-pane active" id="tab1">
                        
		    	<form class="form-inline" method="get" action="<?php echo base_url('fechamentos/fechamentoEmpresa'); ?>">
                <input type="hidden" id="view" name="view" value="">
                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> <?=$subTitulo;?></legend>
						
                        
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
							<label class="control-label">Data Inicial</label>
							<input id="data_inicial" class="input-small" onkeyup="mascaraData(this);" name="data_inicial" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="date" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy"  required="required" style="width: 150px;">
			
            				<label class="control-label">Data Final</label>
							<input id="data_final" class="input-small" onkeyup="mascaraData(this);" name="data_final" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="date" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy"  required="required" style="width: 150px;">				
							
						</div>
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Pesquisar</button>
                        <a href="<?php echo base_url() ?>fechamentos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

