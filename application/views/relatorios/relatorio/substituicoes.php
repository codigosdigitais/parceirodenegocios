<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "";
	} 
	else
	{
		$tituloBase = "Relatório de Substituições"; 
	}
?>

<div class="row-fluid" style="margin-top:-35px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content">
                   <form class="form-inline" id="frm" method="post" action="listarSubstituicoes">
                        <fieldset>
                            <legend><i class="icon-search icon-title"></i> Pesquisar Substituições</legend>
							                           
                            <div class="line">
                                <label class="control-label">Cliente</label>
                                <select class="input-xxlarge" name="idCliente" id="idCliente" style="width: 715px !important;">
                                    <option value="">Selecione o Cliente</option>
                                    <?
                                        foreach($this->data['listaCliente'] as $clienteLista){ 
                                    ?>
                                    <option value="<?=$clienteLista->idCliente;?>" <? if(isset($result->idCliente)){ if($clienteLista->idCliente==$result->idCliente){ echo "selected"; } } ?> ><?=$clienteLista->razaosocial;?></option>
                                    <? } ?>								
                                </select>
                            </div>				    	
                            
							<div class="line">
                                <label class="control-label">Data Inicial</label>
                                <input id="data_inicial" class="input-small" name="data_inicial" value="<? if($this->input->post('data_inicial')!=NULL){ echo $this->input->post('data_inicial');  } ?>" type="date" style="width: 150px;">
                
                                <label class="control-label">Data Final</label>
                                <input id="data_final" class="input-small" name="data_final"  value="<? if($this->input->post('data_final')!=NULL){ echo $this->input->post('data_final');  } ?>" type="date" style="width: 150px;">				
                            </div>
                            
                            <legend style="position: relative; top: 12px;"></legend>
                            <!---
                            <div class="line">
                                <ul class="quick-actions">
                                    <li class="bg_lo" style="background-color: #C02028 !important"> 
                                        <a href=""> 
                                            <i class="icon-group"></i> 
                                            <input style="position: relative; top: -1px; width: 80px; " type="radio" value="dados_faturamento" name="campo[]">
                                            <br>Faturamento
                                        </a> 
                                    </li>
                                </ul>

                                <ul class="quick-actions">
                                    <li class="bg_lo" style="background-color: blue !important"> 
                                        <a href=""> 
                                            <i class="icon-group"></i> 
                                            <input style="position: relative; top: -1px; width: 80px; " type="radio" value="dados_horarios" name="campo[]">
                                            <br>Horários
                                        </a> 
                                    </li>
                                </ul>

							</div>
							<br><br><br><br>--->
                            <div class="button-form line">										    
                                <div class="span6 offset3" style="text-align: center">
                                    <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Pesquisar</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
	        </div>
   	 	</div>
	</div>
</div>

