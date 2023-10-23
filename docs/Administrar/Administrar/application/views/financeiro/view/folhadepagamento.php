<meta charset="utf-8">
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/fechamentos/folhadepagamento/js/folhadepagamento.js"></script>

<?



	# Definições de Parametrizações para Edição
	if(isset($results)){
	

		# INSS
		if($results[0]->consulta_inss[0]->faixa){ $inss_faixa_1 =  $results[0]->consulta_inss[0]->faixa; }	 else { $inss_faixa_1 = ""; }
		if($results[0]->consulta_inss[0]->valor_min){ $inss_valor_min_1 =  $results[0]->consulta_inss[0]->valor_min; }	 else { $inss_valor_min_1 = ""; }
		if($results[0]->consulta_inss[0]->valor_max){ $inss_valor_max_1 =  $results[0]->consulta_inss[0]->valor_max; }	 else { $inss_valor_max_1 = ""; }
		
		if($results[0]->consulta_inss[1]->faixa){ $inss_faixa_2 =  $results[0]->consulta_inss[1]->faixa; }	 else { $inss_faixa_2 = ""; }
		if($results[0]->consulta_inss[1]->valor_min){ $inss_valor_min_2 =  $results[0]->consulta_inss[1]->valor_min; }	 else { $inss_valor_min_2 = ""; }
		if($results[0]->consulta_inss[1]->valor_max){ $inss_valor_max_2 =  $results[0]->consulta_inss[1]->valor_max; }	 else { $inss_valor_max_2 = ""; }
		
		if($results[0]->consulta_inss[2]->faixa){ $inss_faixa_3 =  $results[0]->consulta_inss[2]->faixa; } else { $inss_faixa_3 = ""; }
		if($results[0]->consulta_inss[2]->valor_min){ $inss_valor_min_3 =  $results[0]->consulta_inss[2]->valor_min; }	 else { $inss_valor_min_3 = ""; }
		if($results[0]->consulta_inss[2]->valor_max){ $inss_valor_max_3 =  $results[0]->consulta_inss[2]->valor_max; }	 else { $inss_valor_max_3 = ""; }		
		
		# IRR
		if($results[0]->consulta_irr[0]->faixa){ $irr_faixa_1 =  $results[0]->consulta_irr[0]->faixa; }	 else { $irr_faixa_1 = ""; }
		if($results[0]->consulta_irr[0]->valor_min){ $irr_valor_min_1 =  $results[0]->consulta_irr[0]->valor_min; }	 else { $irr_valor_min_1 = ""; }
		if($results[0]->consulta_irr[0]->valor_max){ $irr_valor_max_1 =  $results[0]->consulta_irr[0]->valor_max; }	 else { $irr_valor_max_1 = ""; }
		
		if($results[0]->consulta_irr[1]->faixa){ $irr_faixa_2 =  $results[0]->consulta_irr[1]->faixa; }	 else { $irr_faixa_2 = ""; }
		if($results[0]->consulta_irr[1]->valor_min){ $irr_valor_min_2 =  $results[0]->consulta_irr[1]->valor_min; }	 else { $irr_valor_min_2 = ""; }
		if($results[0]->consulta_irr[1]->valor_max){ $irr_valor_max_2 =  $results[0]->consulta_irr[1]->valor_max; }	 else { $irr_valor_max_2 = ""; }
		
		if($results[0]->consulta_irr[2]->faixa){ $irr_faixa_3 =  $results[0]->consulta_irr[2]->faixa; }	 else { $irr_faixa_3 = ""; }
		if($results[0]->consulta_irr[2]->valor_min){ $irr_valor_min_3 =  $results[0]->consulta_irr[2]->valor_min; }	 else { $irr_valor_min_3 = ""; }
		if($results[0]->consulta_irr[2]->valor_max){ $irr_valor_max_3 =  $results[0]->consulta_irr[2]->valor_max; }	 else { $irr_valor_max_3 = ""; }
		
		if($results[0]->consulta_irr[3]->faixa){ $irr_faixa_4 =  $results[0]->consulta_irr[3]->faixa; }	 else { $irr_faixa_4 = ""; }
		if($results[0]->consulta_irr[3]->valor_min){ $irr_valor_min_4 =  $results[0]->consulta_irr[3]->valor_min; }	 else { $irr_valor_min_4 = ""; }
		if($results[0]->consulta_irr[3]->valor_max){ $irr_valor_max_4 =  $results[0]->consulta_irr[3]->valor_max; }	 else { $irr_valor_max_4 = ""; }
		
		# FAMILIA
		if($results[0]->consulta_familia[0]->faixa){ $familia_faixa_1 =  $results[0]->consulta_familia[0]->faixa; }	 else { $familia_faixa_1 = ""; }
		if($results[0]->consulta_familia[0]->valor_min){ $familia_valor_min_1 =  $results[0]->consulta_familia[0]->valor_min; }	 else { $familia_valor_min_1 = ""; }
		if($results[0]->consulta_familia[0]->valor_max){ $familia_valor_max_1 =  $results[0]->consulta_familia[0]->valor_max; }	 else { $familia_valor_max_1 = ""; }
		
		if($results[0]->consulta_familia[1]->faixa){ $familia_faixa_2 =  $results[0]->consulta_familia[1]->faixa; }	 else { $familia_faixa_2 = ""; }
		if($results[0]->consulta_familia[1]->valor_min){ $familia_valor_min_2 =  $results[0]->consulta_familia[1]->valor_min; }	 else { $familia_valor_min_2 = ""; }
		if($results[0]->consulta_familia[1]->valor_max){ $familia_valor_max_2 =  $results[0]->consulta_familia[1]->valor_max; }	 else { $familia_valor_max_2 = ""; }
		
		if($results[0]->consulta_familia[2]->faixa){ $familia_faixa_3 =  $results[0]->consulta_familia[2]->faixa; }	 else { $familia_faixa_3 = ""; }
		if($results[0]->consulta_familia[2]->valor_min){ $familia_valor_min_3 =  $results[0]->consulta_familia[2]->valor_min; }	 else { $familia_valor_min_3 = ""; }
		if($results[0]->consulta_familia[2]->valor_max){ $familia_valor_max_3 =  $results[0]->consulta_familia[2]->valor_max; }	 else { $familia_valor_max_3 = ""; }
		
		# INSALUBRIDADE
		if($results[0]->consulta_insalubridade[0]->faixa){ $insalubridade_faixa_1 =  $results[0]->consulta_insalubridade[0]->faixa; }	 else { $insalubridade_faixa_1 = ""; }
		if($results[0]->consulta_insalubridade[0]->valor_min){ $insalubridade_valor_min_1 =  $results[0]->consulta_insalubridade[0]->valor_min; }	 else { $insalubridade_valor_min_1 = ""; }
		
		if($results[0]->consulta_insalubridade[1]->faixa){ $insalubridade_faixa_2 =  $results[0]->consulta_insalubridade[1]->faixa; }	 else { $insalubridade_faixa_2 = ""; }
		if($results[0]->consulta_insalubridade[1]->valor_min){ $insalubridade_valor_min_2 =  $results[0]->consulta_insalubridade[1]->valor_min; }	 else { $insalubridade_valor_min_2 = ""; }
		
		if($results[0]->consulta_insalubridade[2]->faixa){ $insalubridade_faixa_3 =  $results[0]->consulta_insalubridade[2]->faixa; }	 else { $insalubridade_faixa_3 = ""; }
		if($results[0]->consulta_insalubridade[2]->valor_min){ $insalubridade_valor_min_3 =  $results[0]->consulta_insalubridade[2]->valor_min; } else { $insalubridade_valor_min_3 = ""; }	
		
	}
	
	#Define Títulos Topo
	$tituloBase = "Folhas de Pagamento";
	$subTitulo = "Parâmetros Globais"; 
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
            <div class="widget-content">
            	<? if($this->uri->segment(3)=="editar"){ ?>
                <form class="form-inline" method="post" action="<?php echo current_url(); ?>/editando" enctype="multipart/form-data">
                <? } else { ?>
                <form class="form-inline" method="post" action="<?php echo current_url(); ?>/adicionando" enctype="multipart/form-data">
                <? } ?>
                <fieldset>
                    <legend><i class="icon-plus icon-title"></i> <?=$subTitulo;?></legend>
                    <div class="button-form line">
                    <div class="line" style="font-size: 14px; padding: 10px">
                    	Para que você possa parametrizar automaticamente as Folhas de Pagamento e com base nos artigos da lei, preencha corretamente os parâmetros abaixo:
                    </div>
                    
                    <div class="line">
                        <label class="control-label">Empresa</label>
                        <select class="input-xxlarge" name="idCedente" id="idCedente" style="width: 765px !important;">
                            <option value="">Selecione a Empresa</option>
                            <?
                                foreach($lista_cedente as $valor){
                            ?>
                                <option value="<? echo $valor->idCedente; ?>" <? if(isset($results[0]->idCedente)){ if($results[0]->idCedente==$valor->idCedente){ echo "selected"; } }  ?>><? echo $valor->razaosocial; ?></option>
                            <? } ?>
                        </select>
                    </div>	
                    
                    <div class="line">
                        <label class="control-label">Atividade/Função</label>
                        <select class="input-xxlarge" name="idParametro" id="idParametro" style="width: 765px !important;">
                            <option value="">Selecione a Atividade</option>
                            <?
                                foreach($lista_atividade as $valor){
                            ?>
                                <option value="<? echo $valor->idParametro; ?>" <? if(isset($results[0]->idParametro)){ if($results[0]->idParametro==$valor->idParametro){ echo "selected"; } }  ?>><? echo $valor->codigoeSocial; ?> - <? echo $valor->parametro; ?></option>
                            <? } ?>
                        </select>
                    </div>	
                    
                    <div class="line">
                        <label class="control-label">Salário Base</label>
                      <input type="text" class="input-smallx" placeholder="0.00" id="salario" name="salario" value="<? if(isset($results[0]->salario)){ echo $results[0]->salario; }  ?>"> 
                    </div>	
                    
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                          <tbody>
                            <tr>
                              <td colspan="5" bgcolor="#EDEDED" style="height:30px; padding-top: 10px;"><strong><center>FAIXAS DE INSS</center></strong></td>
                            </tr>
                            <tr>
                              <td><center>
                                FAIXAS %
                              </center></td>
                              <td colspan="2" rowspan="4" valign="top">                                <div align="left">
                                <table align="center" class="" style="border: none !important;">
                                  <tr>
                                    <td><table>
                                        <tr>
										
                                			<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_folha_inss)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_folha_inss as $value){ 
													$i++;
												?>
                                                <div id="linha_<? echo $i; ?>" class="linha" style="padding: 2px">
                                                  <label>Tipo de Provento</label>
                                                  <select style="width: 300px" name="faixainss_tipo[]" class="limpar_campo">
                                                        <option>Selecione o Tipo de Provento</option>
                                                        <?
                                                            foreach($lista_adicionais_desconto as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small limpar_campo" name="faixainss_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >Diário</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>Hora</option>
                                                    </select>

                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_folha_inss)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>       
                                                    <? } ?>                                           
                                                </div>
                                                <? } ?>
                                            </div>

                                            <? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <label>Tipo de Desconto</label>
                                                  <select style="width: 300px" name="faixainss_tipo[]">
                                                        <option>Selecione o Tipo de Provento</option>
                                                        <?
                                                            foreach($lista_adicionais_desconto as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small" name="faixainss_formato[]">
                                                        <option value="1">Diário</option>
                                                        <option value="2">Hora</option>
                                                    </select>
  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>                                                  
                                                </div>
                                            </div>     
                                            <? } ?>                                
										
										
										
										
										
                                            
                                          
                                      </tr>
                                      </table></td>
                                  </tr>
                                                                  </table>
                              </div></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px"><div align="center">
                                <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[1][valor_min]" value="<? if(isset($inss_valor_min_1)) echo $inss_valor_min_1; ?>" />
                                <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[1][valor_max]" value="<? if(isset($inss_valor_min_1)) echo $inss_valor_max_1; ?>" />
                                <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="inss[1][faixa]" value="<? if(isset($inss_faixa_1)) echo $inss_faixa_1; ?>" />
                              </div></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px"><div align="center">
                                <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[2][valor_min]" value="<? if(isset($inss_valor_min_2)) echo $inss_valor_min_2; ?>" />
                                <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[2][valor_max]" value="<? if(isset($inss_valor_max_2)) echo $inss_valor_max_2; ?>" />
                                <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="inss[2][faixa]" value="<? if(isset($inss_faixa_2)) echo $inss_faixa_2; ?>" />
                              </div></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px">
                              	<center>
                              	  <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[3][valor_min]" value="<? if(isset($inss_valor_min_3)) echo $inss_valor_min_3; ?>" />
                                  <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="inss[3][valor_max]" value="<? if(isset($inss_valor_max_3)) echo $inss_valor_max_3; ?>" />
                                  <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="inss[3][faixa]" value="<? if(isset($inss_faixa_3)){ echo $inss_faixa_3; }?>" />
                              	                                </center>                              </td>
                            </tr>
                            
                            <tr>
                              <td colspan="5" bgcolor="#EDEDED" style="height:30px; padding-top: 10px;"><strong><center>FAIXAS DE IMPOSTO RETIDO NA FONTE</center></strong></td>
                            </tr>
                            <tr>
                              <td><center>1ª FAIXA %</center></td>
                              <td><center>2ª FAIXA %</center></td>
                              <td><center>3ª FAIXA %</center></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[1][valor_min]" value="<? if(isset($irr_valor_min_1)) echo $irr_valor_min_1; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[1][valor_max]" value="<? if(isset($irr_valor_max_1)) echo $irr_valor_max_1; ?>">
                                    <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="irr[1][faixa]" value="<? if(isset($irr_faixa_1)) echo $irr_faixa_1; ?>">
                                </center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[2][valor_min]" value="<? if(isset($irr_valor_min_2)) echo $irr_valor_min_2; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[2][valor_max]" value="<? if(isset($irr_valor_max_2)) echo $irr_valor_max_2; ?>">
                                    <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="irr[2][faixa]" value="<? if(isset($irr_faixa_2)) echo $irr_faixa_2; ?>">
                                </center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[3][valor_min]" value="<? if(isset($irr_valor_min_3)) echo $irr_valor_min_3; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[3][valor_max]" value="<? if(isset($irr_valor_max_3)) echo $irr_valor_max_3; ?>">
                                   	<input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="irr[3][faixa]" value="<? if(isset($irr_faixa_3)) echo $irr_faixa_3; ?>">
                                </center>                              </td>
                            </tr>
                            
                            <tr>
                              <td><center>4ª FAIXA %</center></td>
                              <td><center></center></td>
                              <td><center></center></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[4][valor_min]" value="<? if(isset($irr_valor_min_4)) echo $irr_valor_min_4; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="irr[4][valor_max]" value="<? if(isset($irr_valor_max_4)) echo $irr_valor_max_4; ?>">
                                    <input type="text" class="input-small" placeholder="0.0" style="margin: 2px; width: 50px" name="irr[4][faixa]" value="<? if(isset($irr_faixa_4)) echo $irr_faixa_4; ?>">
                                </center>                              </td>
                              <td style="padding-top: 7px">                              </td>
                              <td style="padding-top: 7px">                              </td>
                            </tr>
                            
                             <tr>
                              <td colspan="5" bgcolor="#EDEDED" style="height:30px; padding-top: 10px;"><strong><center>SALÁRIO FAMÍLIA</center></strong></td>
                            </tr>
                            <tr>
                              <td><center>1ª FAIXA %</center></td>
                              <td><center>2ª FAIXA %</center></td>
                              <td><center>3ª FAIXA %</center></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[1][valor_min]" value="<? if(isset($familia_valor_min_1)) echo $familia_valor_min_1; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[1][valor_max]" value="<? if(isset($familia_valor_max_1)) echo $familia_valor_max_1; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px; width: 50px" name="familia[1][faixa]" value="<? if(isset($familia_faixa_1)) echo $familia_faixa_1; ?>">
                              	</center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[2][valor_min]" value="<? if(isset($familia_valor_min_2)) echo $familia_valor_min_2; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[2][valor_max]" value="<? if(isset($familia_valor_max_2)) echo $familia_valor_max_2; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px; width: 50px" name="familia[2][faixa]" value="<? if(isset($familia_faixa_2)) echo $familia_faixa_2; ?>">
                              	</center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[3][valor_min]" value="<? if(isset($familia_valor_min_3)) echo $familia_valor_min_3; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="familia[3][valor_max]" value="<? if(isset($familia_valor_max_3)) echo $familia_valor_max_3; ?>">
                                    <input type="text" class="input-small" placeholder="0.00" style="margin: 2px; width: 50px" name="familia[3][faixa]" value="<? if(isset($familia_faixa_3)) echo $familia_faixa_3; ?>">
                              	</center>                              </td>
                            </tr>
                           

                            <tr>
                              <td colspan="5" bgcolor="#EDEDED" style="height:30px; padding-top: 10px;"><strong><center>ADICIONAIS DE INSALUBRIDADE</center></strong></td>
                            </tr>
                            <tr style="height:45px;">
                              <td style="padding-top: 7px">
                              	<center>
                                	<input type="text" class="input-small" placeholder="0.0" style="margin: 2px;" name="insalubridade[1][faixa]" value="<? if(isset($insalubridade_faixa_1)) echo $insalubridade_faixa_1; ?>">
                           	      <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="insalubridade[1][valor_min]" value="<? if(isset($insalubridade_valor_min_1)) echo $insalubridade_valor_min_1; ?>">
                              	</center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.0" style="margin: 2px;" name="insalubridade[2][faixa]" value="<? if(isset($insalubridade_faixa_2)) echo $insalubridade_faixa_2; ?>">
                           	      <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="insalubridade[2][valor_min]" value="<? if(isset($insalubridade_valor_min_2)) echo $insalubridade_valor_min_2; ?>">
                              	</center>                              </td>
                              <td style="padding-top: 7px">
                              	<center>
                                    <input type="text" class="input-small" placeholder="0.0" style="margin: 2px;" name="insalubridade[3][faixa]" value="<? if(isset($insalubridade_faixa_3)) echo $insalubridade_faixa_3; ?>">
                           	      <input type="text" class="input-small" placeholder="0.00" style="margin: 2px" name="insalubridade[3][valor_min]" value="<? if(isset($insalubridade_valor_min_3)) echo $insalubridade_valor_min_3; ?>">
                              	</center>                              </td>
                            </tr>
                            <tr>
                              <td bgcolor="#CCC" style="height:30px; padding-top: 10px;"  colspan="3"><strong><center>ADICIONAIS DE DESCONTOS</center></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                			<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_desconto)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_desconto as $value){ 
													$i++;
												?>
                                                <div id="linha_<? echo $i; ?>" class="linha" style="padding: 2px">
                                                  <label>Tipo de Desconto</label>
                                                  <select style="width: 480px" name="desconto_tipo[]" class="limpar_campo">
                                                        <option>Selecione o Tipo de Desconto</option>
                                                        <?
                                                            foreach($lista_adicionais_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small limpar_campo" name="desconto_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >R$</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>%</option>
                                                    </select>
                                                    <input type="text" class="input-small limpar_campo" name="desconto_valor[]" value="<? echo $value->valor; ?>">  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_desconto)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>       
                                                    <? } ?>                                           
                                                </div>
                                                <? } ?>
                                            </div>

                                            <? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <label>Tipo de Desconto</label>
                                                  <select style="width: 480px" name="desconto_tipo[]">
                                                        <option>Selecione o Tipo de Desconto</option>
                                                        <?
                                                            foreach($lista_adicionais_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small" name="desconto_formato[]">
                                                        <option value="1">R$</option>
                                                        <option value="2">%</option>
                                                    </select>
                                                    <input type="text" class="input-small" name="desconto_valor[]">  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>                                                  
                                                </div>
                                            </div>     
                                            <? } ?>                                </td>
                            </tr>
                            
                            <tr>
                              <td bgcolor="#CCC" style="height:30px; padding-top: 10px;"  colspan="3"><strong><center>ADICIONAIS DE PROVENTOS</center></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                			<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_provento)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_provento as $value){ 
													$i++;
												?>
                                                <div id="linha_<?=$i;?>" class="linha" style="padding: 2px">
                                                  <label>Tipo de Provento</label>
                                                  <select style="width: 480px" name="provento_tipo[]" class="limpar_campo">
                                                        <option>Selecione o Tipo de Provento</option>
                                                        <?
                                                            foreach($lista_adicionais_desconto as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small limpar_campo" name="provento_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >R$</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>%</option>
                                                    </select>
                                                    <input type="text" class="input-small limpar_campo" name="provento_valor[]" value="<? echo $value->valor; ?>">  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_provento)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>       
                                                    <? } ?>                                                  
                                                </div>
                                                <? } ?>
                                            </div>                                
                                			<? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <label>Tipo de Provento</label>
                                                  <select style="width: 480px" name="provento_tipo[]">
                                                        <option>Selecione o Tipo de Provento</option>
                                                        <?
                                                            foreach($lista_adicionais_desconto as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                    </select>
                                                  	<select class="input-small" name="provento_formato[]">
                                                        <option value="1">R$</option>
                                                        <option value="2">%</option>
                                                    </select>
                                                    <input type="text" class="input-small" name="provento_valor[]">  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>                                                    </button>                                                  
                                                </div>
                                            </div>  
                                            <? } ?>                                </td>
                            </tr>
                          </tbody>
                        </table>
                        <legend><i class="icon-plus icon-title"></i> Parâmetros de Faltas</legend>
                        <table class="table table-bordered">
                        	<tr>
                            	<td style="width: 140px; padding-top: 8px; text-align:right"><strong>FALTA JUSTIFICADA</strong></td>
                                <td>
                                    <table>
                                    	<tr>
                                        	<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_faltasjust)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_faltasjust as $value){ 
													$i++;
												?>
                                                <div id="linha_<?=$i;?>" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="faltajust_tipo[]" class="limpar_campo">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small limpar_campo" name="faltajust_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >Diário</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>Hora</option>
                                                    </select>  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_faltasjust)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>       
                                                    <? } ?>                                                 
                                                </div>
                                                <? } ?>
                                            </div>
                                            <? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="faltajust_tipo[]">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small" name="faltajust_formato[]">
                                                        <option value="1">Diário</option>
                                                        <option value="2">Hora</option>
                                                    </select>  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>                                                  
                                                </div>
                                            </div>
                                            <? } ?>
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                            
                        	<tr>
                            	<td style="width: 140px; padding-top: 8px; text-align:right"><strong>FALTA INJUSTIFICADA</strong></td>
                                <td>
                                    <table>
                                   	  <tr>
                                      		<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_faltasinjust)>0){ ?>
                                        	<div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_faltasinjust as $value){ 
													$i++;
												?>
                                                <div id="linha_<?=$i;?>" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="faltainjust_tipo[]" class="limpar_campo">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small limpar_campo" name="faltainjust_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >Diário</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>Hora</option>
                                                    </select>   
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_faltasinjust)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>       
                                                    <? } ?>                                                   
                                                </div>
                                                <? } ?>
                                            </div>
                                            <? } else { ?>
                                        	<div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="faltainjust_tipo[]">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small" name="faltainjust_formato[]">
                                                        <option value="1">Diário</option>
                                                        <option value="2">Hora</option>
                                                    </select>   
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>                                                  
                                                </div>
                                            </div>
                                            <? } ?>
                                      </tr>
                                    </table>
                                    
                                </td>
                            </tr>

                        </table>
                        
                        <legend><i class="icon-plus icon-title"></i> Parâmetros de Atrasos</legend>
                        <table class="table table-bordered">
                        	<tr>
                            	<td style="width: 140px; padding-top: 8px; text-align:right"><strong>ATRASO JUSTIFICADO</strong></td>
                                <td>
                                    <table>
                                   	  <tr>
                                      		<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_atrasosjust)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_atrasosjust as $value){ 
													$i++;
												?>
                                                <div id="linha_1"  class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="atrasojust_tipo[]" class="limpar_campo">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small limpar_campo" name="atrasojust_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >Diário</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>Hora</option>
                                                    </select>  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_atrasosjust)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>       
                                                    <? } ?>                                                  
                                                </div>
                                                <? } ?>
                                            </div>
                                            <? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1"  class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="atrasojust_tipo[]">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small" name="atrasojust_formato[]">
                                                        <option value="1">Diário</option>
                                                        <option value="2">Hora</option>
                                                    </select>  
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>                                                  
                                                </div>
                                            </div>
                                            <? } ?>
                                      </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                            
                        	<tr>
                            	<td style="width: 140px; padding-top: 8px; text-align:right"><strong>ATRASO INJUSTIFICADO</strong></td>
                                <td>
                                    <table>
                                   	  <tr>
                                      		<? if($this->uri->segment(3)=="editar" and count($results[0]->consulta_atrasosinjust)>0){ ?>
                                            <div class="container_linhas">
                                            	<? 
												$i = 0;
												foreach($results[0]->consulta_atrasosinjust as $value){ 
													$i++;
												?>
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="atrasoinjust_tipo[]" class="limpar_campo">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>" <? if($value->tipo==$valor->idParametro){ echo "selected"; } ?>><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small limpar_campo" name="atrasoinjust_formato[]">
                                                        <option value="1" <? if($value->formato==1){ echo "selected"; } ?> >Diário</option>
                                                        <option value="2" <? if($value->formato==2){ echo "selected"; } ?>>Hora</option>
                                                    </select>   
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" ><i class="icon-remove"></i></button>
                                                    <? if($i==count($results[0]->consulta_atrasosinjust)){ ?>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>       
                                                    <? } ?>                                                   
                                                </div>
                                               <? } ?>
                                            </div>
                                            <? } else { ?>
                                            <div class="container_linhas">
                                                <div id="linha_1" class="linha" style="padding: 2px">
                                                  <select style="width: 550px" name="atrasoinjust_tipo[]">
                                                        <option>Selecione</option>
                                                        <?
                                                            foreach($lista_provento as $valor){ 
                                                        ?>
                                                        <option value="<? echo $valor->idParametro; ?>"><? echo $valor->parametro; ?></option>
                                                        <? } ?>
                                                  </select>
                                                  	<select class="input-small" name="atrasoinjust_formato[]">
                                                        <option value="1">Diário</option>
                                                        <option value="2">Hora</option>
                                                    </select>   
                                                    
                                                    <button type="button" class="removelinha" id="removelinha" style="display:none"><i class="icon-remove"></i></button>
                                                    <button class="btn btn-small clonarlinha" type="button" id="clonarlinha" style="margin-top: 3px">
                                                        <i class="icon-plus-sign"></i>
                                                    </button>                                                  
                                                </div>
                                            </div>
                                            <? } ?>
                                      </tr>
                                    </table>
                                    
                                </td>
                            </tr>

                        </table>

                    											    
                        <div class="span6 offset3" style="text-align: center">
                        	<? if($this->uri->segment(3)=="editar"){ ?>
                            <button class="btn btn-danger" id="btnContinuar"><i class="icon-plus icon-white"></i> Editar Parâmetros</button>
                            <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar Parâmetros</button>
                        	<? } ?>
                            <a href="<?php echo base_url() ?>financeiro/folhadepagamento" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
                    </div>
                </fieldset>
                </form>
        	</div>
	    </div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
    $('.clonarlinha').click(function(e) {
        //exibe botões de remover
        $(this).parent().parent().find('.removelinha').css('display', 'inline-block');

        //clona linha e atribui novo ID incrementando
		tmp = $(this).parent().clone(true);
		tmp.find('.limpar_campo').val("");
		tmp.appendTo( $(this).parent().parent() );
		tmp.attr('id', 'linha_' + $(this).parent().parent().children( ".linha" ).length);
		tmp.find('.removelinha').css('display', 'inline-block');

        //remove botão de clonagem repetido
        $(this).parent().parent().find('.clonarlinha:first').remove();

    });

    $('.removelinha').click(function(e) {
        var container = $(this).parent().parent();

        //se tiver mais de uma linha permite remover
        if ($(container).find('.linha').length > 1) {
            //faz uma cópia do botão clonar
            var btnClonar = $(this).parent().find('.clonarlinha').clone(true);

            //remove a linha
            $(this).parent().remove().after(function(){

                //caso a linha removido contenha o botão clonar, insere o mesmo nvamente
                if ( $(container).find('.clonarlinha').length == 0 ) {
                    $(container).find('.linha:last').append(btnClonar);
                }
                if ($(container).find('.linha').length == 1) {
                    $(container).find('.removelinha').css('display', 'none');
                }
            });

        }
    });
});
</script>
