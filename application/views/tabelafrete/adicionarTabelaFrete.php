<?
	$bairroSaida = $bairroAtual;
	
	#Define Títulos Topo
	if($this->uri->segment(2)=="editar")
	{
		$tituloBase = "Editar Tabela Frete";
	} 
	else
	{
		$tituloBase = "Cadastro de Tabela Frete"; 
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
                <div class="span12" id="divtabelafrete" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
							<form action="<?php echo current_url(); ?>" method="post" id="formtabelafrete">
                            
                            	
                                <div class="span12" id="divCadastrartabelafrete">
                              			<?php 
											if($this->uri->segment(2)=="editar" and isset($result->idTabelaFrete)){	

												echo form_hidden('idTabelaFrete',$result->idTabelaFrete);
											} 
										?>
										
										<?php if($custom_error == true){ ?>
                                        <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">
                                            Dados incompletos, verifique os campos com asterisco
                                        </div>
                                        <?php } ?>

                                        
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span6">
                                                <label for="idCidade">Cidade *</label>
												<select class="span12" name="idCidade" id="idCidade" value="">
                                                <? foreach($this->data['cidades'] as $valor){ ?>
                                                    <option value="<? echo $valor->idCidade;?>" <? if(isset($bairroAtual->idCidade) and $valor->idCidade==$bairroAtual->idCidade){ echo "selected"; }  ?> ><? echo $valor->cidade;?></option>
                                                <? } ?>
                                                </select>
                                            </div>
                                            <div class="span6">
                                                <label for="bairro">Bairro de Saída</label>
                                                <input id="bairro" class="span12" type="text" name="bairro" value="<? echo $bairroAtual->bairro; ?>"  placeholder="Bairro" disabled  />
                                                <input id="idBairroSaida" class="span12" type="hidden" name="idBairroSaida" value="<? echo $bairroAtual->idBairro; ?>"  placeholder="Bairro"  />
                                            </div>

                                        </div>
                                        
                                        <div style="maring-top: 10px">
											<style>
                                                .input-mini {
                                                    width: 65px;
                                                    display:inline-block;
                                                }
                                                
                                                label {
                                                    width: 100px;   
                                                }
                                                div.form-group{
                                                    width: 100px;
                                                    display:inline-block;
                                                    vertical-align: middle;
                                                }
                                            </style>
                                            
                                            <div class="control-group">
                                                <? 
                                                    $linhas = 0;
                                                    $cores = 0;


                                                    foreach($this->data['listaBairrosAdd'] as $bairro){

														$base=null;
														if(isset($result)){
															foreach($result as $valor){
																if( $valor->idBairro==$bairro->idBairro){
																	$base = $valor;	
																	
																}
															}
														}
															
                                                        $linhas++;
                                                        
                                                        if($cores%2==0){ $cor=""; } else { $cor = "#FFFFFF"; }
                                                        $cores++;
                                                ?>
                                                <div class="controls" style=" background-color: <?=$cor;?>">
                                                    <div class="input-mini" style=" margin-right: 5px; width: 130px; text-align: right; text-transform: uppercase">
                                                        <strong><? echo $bairro->bairro; ?></strong>
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>P. Base</label><? } ?>
                                                        <input id="pon_pontoBase[<?=$bairro->idBairro;?>]" name="pon_pontoBase[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini preco_base" value="<? if(isset($base)){ echo $base->pontoBase; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>P. Moto</label><? } ?>
                                                        <input id="pon_pontoMoto[<?=$bairro->idBairro;?>]" name="pon_pontoMoto[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-pontomoto" value="<? if(isset($base)){ echo $base->pontoMoto; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>P. Carro</label><? } ?>
                                                        <input  id="pon_pontoCarro[<?=$bairro->idBairro;?>]" name="pon_pontoCarro[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-pontocarro" value="<? if(isset($base)){ echo $base->pontoCarro; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>P. Van</label><? } ?>
                                                        <input  id="pon_pontoVan[<?=$bairro->idBairro;?>]" name="pon_pontoVan[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-pontovan" value="<? if(isset($base)){ echo $base->pontoVan; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>P. Caminhão</label><? } ?>
                                                        <input  id="pon_pontoCaminhao[<?=$bairro->idBairro;?>]" name="pon_pontoCaminhao[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-pontocaminhao" value="<? if(isset($base)){ echo $base->pontoCaminhao; } ;?>">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>R. Moto</label><? } ?>
                                                        <input  id="pon_retornoMoto[<?=$bairro->idBairro;?>]" name="pon_retornoMoto[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-retornomoto" value="<? if(isset($base)){ echo $base->retornoMoto; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>R. Carro</label><? } ?>
                                                        <input id="pon_retornoCarro[<?=$bairro->idBairro;?>]" name="pon_retornoCarro[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-retornocarro" value="<? if(isset($base)){ echo $base->retornoCarro; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>R. Van</label><? } ?>
                                                        <input id="pon_retornoVan[<?=$bairro->idBairro;?>]" name="pon_retornoVan[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-retornovan" value="<? if(isset($base)){ echo $base->retornoVan; } ;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <? if($linhas==1){ ?><label>R. Caminhão</label><? } ?>
                                                        <input id="pon_retornoCaminhao[<?=$bairro->idBairro;?>]" name="pon_retornoCaminhao[<?=$bairro->idBairro;?>]" type="text" placeholder="0.00" class="input-mini class-retornocaminhao" value="<? if(isset($base)){ echo $base->retornoCaminhao; } ;?>">
                                                    </div>
                                                </div>
                                                <? 
												//} 
												} ?>
                                            </div>
                                        </div>
 										

                                        
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span6 offset3" style="text-align: center">
                                            	<? if($this->uri->segment(2)=="editar"){ ?>
                                                	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                                <? } else { ?>
                                                	<button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                                                <? } ?>
                                                <a href="<?php echo base_url() ?>tabelafrete" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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


<script>
	$(document).ready(function() {
		$(".preco_base").keyup(function(e){
			tmp = $(this).val();
			tmp2 = parseFloat(($(this).val()).replace(".", "").replace(",", "."));
			$(this).parent().parent().find('.class-pontomoto').val(((tmp2)));  
			$(this).parent().parent().find('.class-pontocarro').val(((tmp2 + 0.25 )));		
			$(this).parent().parent().find('.class-pontovan').val(((tmp2 + 0.50 )));		
			$(this).parent().parent().find('.class-pontocaminhao').val(((tmp2 + 0.75 )));	
			$(this).parent().parent().find('.class-retornomoto').val('0.25');
			$(this).parent().parent().find('.class-retornocarro').val('0.50');
			$(this).parent().parent().find('.class-retornovan').val('0.75');
			$(this).parent().parent().find('.class-retornocaminhao').val('1.00');		
		})
	})
</script>
