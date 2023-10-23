<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/proventos/js/proventos.js"></script>

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                    <i class="icon-tags"></i>
                    </span>
                    <h5><? echo $parametro_selecionado->parametro; ?></h5>
                </div>
                <div class="widget-content">
                	


                                <form class="form-inline" method="post" action="<?php echo current_url(); ?>/adicionar">
                                    <fieldset>
                                        
                                        <div class="span12" style="height:35px;">
                                            <div class="span3" style="text-align:right">
                                                <strong>Registro</strong>
                                            </div>
                                            
                                            <div class="span9">
                                                 <? echo $lista_funcionario[0]->razaosocial; ?>
                                            </div>
                                        </div>
                            
                                        <div class="span12" style="height:35px;">
                                            <div class="span3" style="text-align:right">
                                                <strong>Base de Cáculo</strong>
                                            </div>
                                            
                                            <div class="span9">
                                                 <? if($this->input->post('base_calculo')==false) { echo "MANUAL"; } else { echo $this->input->post('base_calculo');  }?>
                                            </div>
                                        </div>
                            
                            
                                                <?php
                                                foreach($lista_funcionario as $key => $valor){
                                                
                                                    /* Verificando se o tipo de parametro é vale */
                                                    if($this->input->post('base_calculo')!=NULL){
                                                        $base_calculo = str_replace("%", "", $this->input->post('base_calculo'));
                                                        $valor_adiantamento = $valor->salario * $base_calculo / 100;    
                                                    } else {
                                                        $valor_adiantamento = NULL;	
                                                    }
													
													$valor_preenche = "";
													if($this->input->post('valor')!=NULL){ 
														$valor_preenche = $this->input->post('valor'); 
													} elseif($valor_adiantamento!=NULL){ 
														$valor_preenche =  $valor_adiantamento; 
													}
													
													$referencia = "";
													if($this->input->post('referencia')!=NULL){ 
														$referencia_b = $this->input->post('referencia'); 
													} elseif($referencia!=NULL){ 
														$referencia_b =  $referencia; 
													}
													
                                                    ?>

                                                    
                                                    <input type="hidden" id="campo[<?php echo $key;?>][idFuncionario]" name="campo[<?php echo $key;?>][idFuncionario]" value="<? echo $valor->idFuncionario; ?>">
                                                    <input type="hidden" id="campo[<?php echo $key;?>][tipo]" name="campo[<?php echo $key;?>][tipo]" value="<? echo $this->uri->segment(3); ?>">
                                                    <input type="hidden" id="campo[<?php echo $key;?>][referencia]" name="campo[<?php echo $key;?>][referencia]" value="<? echo $referencia_b; ?>">
                                                    <div class="span12" style="height:35px;">
                                                        <div class="span3" style="text-align:right">
                                                            <strong><? echo $valor->nome; ?></strong>
                                                        </div>
                                                
                                                        <div class="span1">
                                                            <input id="campo[<?php echo $key;?>][valor]" class="span12" type="text" name="campo[<?php echo $key;?>][valor]" value="<? echo $valor_preenche; ?>" placeholder="0.00"  />
                                                        </div>
                                                        <div class="span2">
                                                            <input id="campo[<?php echo $key;?>][data]" class="span12" type="date" name="campo[<?php echo $key;?>][data]"  value="<? if($this->input->post('data')!=NULL){ echo $this->input->post('data'); } ?>" />
                                                        </div>
                                                        <div class="span6">
                                                            <input id="campo[<?php echo $key;?>][detalhes]" class="span10" type="text" name="campo[<?php echo $key;?>][detalhes]" placeholder="Detalhes do Provento" value="<? if($this->input->post('detalhes')!=NULL){ echo $this->input->post('detalhes'); } ?>" />
                                                        </div>
                                                    </div>
                                                <?php
                                                } 
                                                ?>
                            
                            
                                        <div class="line" style="padding: 1%; margin-left: 0">
                                            <div class="span6 offset3" style="text-align: center">
                                                    <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                                                <a href="<?php echo base_url() ?>proventos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                            </div>
                                        </div>
                                        
                                    </fieldset>
                                </form>




                    
                </div>
            </div>
        </div>
    </div>
