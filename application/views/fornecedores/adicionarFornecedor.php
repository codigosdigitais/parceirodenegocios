
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/fornecedores/js/fornecedores.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Fornecedor";
	} 
	else
	{
		$tituloBase = "Cadastro de Fornecedor"; 
	}
?>
<script type="text/javascript">
$(document).ready(function() {

	onSubmitChangeCheckboxesToInput('#form-fornecedor', 'input:checkbox');
	
});
</script>

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
                <div class="span12" id="divfornecedor" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                        
                        <form id="form-fornecedor" class="form-inline" method="post" action="<?php echo current_url(); ?>">
                            <?php 
                                if($this->router->method=="editar"){
                                    echo form_hidden('idFornecedor',$result[0]->idFornecedor);
                                } 
                            ?>
                            
                            
                            
                            <fieldset>
                                    <legend><i class="icon-plus icon-title"></i> Novo Fornecedor</legend>
            
                                        <div class="line">
                                            <label class="control-label">Razão Social</label>
                                            <input class="input-xxlarge" type="text" placeholder="Razão Social" name="razaosocial" value="<? if(isset($result[0]->razaosocial)){ echo $result[0]->razaosocial; } ;?>" onblur="copiarRazaoSocial()" autofocus required="required">
                                        </div>				    	
                                        
                                        <div class="line">
                                            <label class="control-label">Nome Fantasia</label>
                                            <input class="input-xxlarge" type="text" placeholder="Nome Fantasia" name="nomefantasia" value="<? if(isset($result[0]->nomefantasia)){ echo $result[0]->nomefantasia; } ;?>">
                                        </div>
                                        
                                        <div class="line">
                                            <label class="control-label">CNPJ/CPF</label>
                                            <input class="input-medium" type="text" placeholder="CNPJ/CPF" name="cnpj" value="<? if(isset($result[0]->cnpj)){ echo $result[0]->cnpj; } ;?>" maxlength="14" required="required">
                                            
                                            <label class="control-label">Insc. Est.</label>
                                            <input class="input-medium" type="text" placeholder="Inscrição Estadual" name="ie" value="<? if(isset($result[0]->ie)){ echo $result[0]->ie; } ;?>">
                                            
                                            <label class="control-label">Insc. Mun.</label>
                                            <input class="input-medium" type="text" placeholder="Inscrição Municipal" name="im" value="<? if(isset($result[0]->im)){ echo $result[0]->im; } ;?>">
                                        </div>
                                        
                                        <div class="line">
                                            <label class="control-label">Endereço</label>
                                            <input class="input-large" type="text" placeholder="Endereço" name="endereco" value="<? if(isset($result[0]->endereco)){ echo $result[0]->endereco; } ;?>">
                                            
                                            <label class="control-label">Número</label>
                                            <input class="input-medium" type="text" placeholder="Número" name="endereco_numero" value="<? if(isset($result[0]->endereco_numero)){ echo $result[0]->endereco_numero; } ;?>">
                                            
                                            <label class="control-label">Complemento</label>
                                            <input class="input-small" type="text" placeholder="Complemento" name="endereco_complemento" value="<? if(isset($result[0]->endereco_complemento)){ echo $result[0]->endereco_complemento; } ;?>">
                                        </div>
                                        
                                        <div class="line">
                                            <label class="control-label">Bairro</label>
                                            <input class="input-small" type="text" placeholder="Bairro" name="endereco_bairro" value="<? if(isset($result[0]->endereco_bairro)){ echo $result[0]->endereco_bairro; } ;?>">
                                            
                                            <label class="control-label">CEP</label>
                                            <input class="input-small" type="text" placeholder="CEP" maxlength="8" name="endereco_cep" value="<? if(isset($result[0]->endereco_cep)){ echo $result[0]->endereco_cep; } ;?>">
                                            
                                            <label class="control-label" style="width: 75px !important;">Cidade</label>
                                            <input class="input-small" type="text" placeholder="Cidade" name="endereco_cidade" value="<? if(isset($result[0]->endereco_cidade)){ echo $result[0]->endereco_cidade; } ;?>">
                                            
                                            <label class="control-label">Estado</label>
                                            <select class="input-small" name="endereco_estado" >
                                                <?
                                                    foreach($this->data['estados'] as $estado){
                                                ?>	
                                                <option value="<?=$estado->idEstado?>"  <? if(isset($result[0]->endereco_estado)){ if($estado->idEstado==$result[0]->endereco_estado){ echo "selected"; } } ?> ><?=$estado->estado;?></option>
                                                <? 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="line">
                                            <label class="control-label">Responsável</label>
                                            <input class="input-xxlarge" type="text" placeholder="Responsável" name="responsavel" value="<? if(isset($result[0]->responsavel)){ echo $result[0]->responsavel; } ;?>">
                                        </div>                    
                                        
                                        <div class="line">
                                            <label class="control-label">Telefone</label>
                                            <input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_telefone_ddd" value="<? if(isset($result[0]->responsavel_telefone_ddd)){ echo $result[0]->responsavel_telefone_ddd; } ;?>">
                                            <input class="input-small" type="text" placeholder="Telefone" maxlength="9" name="responsavel_telefone" value="<? if(isset($result[0]->responsavel_telefone)){ echo $result[0]->responsavel_telefone; } ;?>">
                                            
                                            <label class="control-label" style="width: 50px !important;">Celular</label>
                                            <input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_celular_ddd" value="<? if(isset($result[0]->responsavel_celular_ddd)){ echo $result[0]->responsavel_celular_ddd; } ;?>">
                                            <input class="input-small" type="text" placeholder="Celular" maxlength="9" name="responsavel_celular" value="<? if(isset($result[0]->responsavel_celular)){ echo $result[0]->responsavel_celular; } ;?>">
                                            
                                            <label class="control-label" style="width: 65px !important;">Email</label>
                                            <input class="input-medium" type="text" placeholder="Email" style="width: 300px !important;" name="email" value="<? if(isset($result[0]->email)){ echo $result[0]->email; } ;?>">
                                        </div>	
                                        
                                        <div class="line">
                                            <label class="control-label">Agência</label>
                                            <input class="input-small" type="text" name="banco_agencia" value="<? if(isset($result[0]->banco_agencia)){ echo $result[0]->banco_agencia; } ;?>" >
                                            
                                            <label class="control-label" style="width: 60px !important;">Conta</label>
                                            <input class="input-small" type="text" name="banco_conta" value="<? if(isset($result[0]->banco_conta)){ echo $result[0]->banco_conta; } ;?>" >
                                            
                                            <label class="control-label" style="width: 80px !important;">Operacão</label>
                                            <input class="input-small" type="text" name="banco_operacao" value="<? if(isset($result[0]->banco_operacao)){ echo $result[0]->banco_operacao; } ;?>" >
                                            
                                            <label class="control-label" style="width: 116px !important;">Banco</label>
                                            <select class="input-medium" name="banco_banco" >
                                                <option value="0">Selecione</option>
                                                    <? foreach($this->data['parametroBanco'] as $banco){ ?>
                                                    <option value="<?=$banco->idParametro;?>" <? if(isset($result[0]->banco_banco)){ if($result[0]->banco_banco==$banco->idParametro){ echo "selected"; } } ?> ><?=$banco->parametro;?></option>
                                                    <? } ?>							
                                            </select>
                                        </div>
                                        
                                        
                                        <legend class="form-title"><i class="icon-group icon-title"></i> Responsáveis</legend>
                                                                            
                                        <div class="line-fill-height">
                                                            
                                                <table class="table table-striped" style="display: inline;">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Telefone</th>
                                                            <th>E-mail</th>
                                                            <th>Setor</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <?
                                                        if(!empty($result[0]->clienteResponsaveis)){
                                                    ?>
                    
                                                    <tbody id="servicosTable" style="width: 898px;">
                                                        
                                                        <? 
                                                            $contador = 0;
                                                            foreach($result[0]->clienteResponsaveis as $listaResponsaveis){ 
                                                            $contador++;
                                                        ?>
                                                            <tr id="servico_<?=$contador;?>">
                                                                <td style="line-height: 10px !important;">
                                                                	<input type="hidden" name="resp_idFornecedorResponsavel[]" value="<? if (isset($listaResponsaveis->idFornecedorResponsavel)) echo $listaResponsaveis->idFornecedorResponsavel; ?>">
                                                                	 <input type="hidden" name="resp_idFornecedor[]" value="<? if (isset($result[0]->idFornecedor)) echo $result[0]->idFornecedor; ?>">
                                                                     <input class="input-small" style="width: 200px !important;" type="text" name="resp_nome[]" value="<? echo $listaResponsaveis->nome;?>" placeholder="Nome Completo">
                                                                </td>
                                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                                    <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd[]" value="<? echo $listaResponsaveis->telefoneddd;?>" placeholder="DDD">
                                                                    <input class="input-small" style="width: 100px !important;" type="text" name="resp_telefone[]" value="<? echo $listaResponsaveis->telefone;?>" placeholder="Telefone">
                                                                </td>
                                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                                    <input class="input-small" style="width: 230px !important;" type="text" name="resp_email[]" value="<? echo $listaResponsaveis->email;?>" placeholder="E-mail">
                                                                </td>
                                                                <td style="line-height: 10px !important;  font-size: 12px !important;">
                                                                    <select class="input-small" name="resp_setor[]" id="resp_setor[]" style="width: 150px;">
                                                                        <? foreach($this->data['parametroSetor'] as $setor){ ?>
                                                                        <option value="<? echo $setor->idParametro; ?>" <? if($setor->idParametro==$listaResponsaveis->idParametro){ echo "selected"; } ?>><? echo $setor->parametro; ?></option>
                                                                        <? } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <button class="btn" type="button" onclick="removerServico(<?=$contador;?>)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        <tr id="servico_baixo_<?=$contador;?>">
                                                            <td colspan="5">
                                                                <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd2[]" value="<? echo $listaResponsaveis->telefoneddd2;?>" placeholder="DDD">
                                                                <input class="input-small" style="width: 147px !important; margin-right: 15px;" type="text" name="resp_telefone2[]" value="<? echo $listaResponsaveis->telefone2;?>" placeholder="Telefone">
                                                                
                                                                <input type="checkbox" name="resp_confemail1[]" id="1_<?=$contador;?>" <? if($listaResponsaveis->confemail1=="on") echo "checked='checked'"; ?>>&nbsp;&nbsp;<label for="1_<?=$contador;?>" style="text-align: left; ">Financeiro</label>
                                                                <input type="checkbox" name="resp_confemail2[]" id="2_<?=$contador;?>" <? if($listaResponsaveis->confemail2=="on") echo "checked='checked'"; ?>>&nbsp;&nbsp;<label for="2_<?=$contador;?>" style="text-align: left">Operacional</label>
                                                                <input type="checkbox" name="resp_confemail3[]" id="3_<?=$contador;?>" <? if($listaResponsaveis->confemail3=="on") echo "checked='checked'"; ?>>&nbsp;&nbsp;<label for="3_<?=$contador;?>" style="text-align: left">Marketing</label>
                                                                <input type="checkbox" name="resp_confemail4[]" id="4_<?=$contador;?>" <? if($listaResponsaveis->confemail4=="on") echo "checked='checked'"; ?>>&nbsp;&nbsp;<label for="4_<?=$contador;?>" style="text-align: left">Retorno</label>
                                                            </td>
                                                        </tr>
                    
                                                    <? } ?>
                                                    </tbody>
                                                </table>
                                             
                                                
                                                <div style="height: 44px; width: 898px;">
                                                    <button class="btn btn-small" type="button" onclick="adicionarServico()" style="float: right; position: relative; top: 7px; right: 3px;"><i class="icon-plus-sign"></i> Adicionar Responsável</button>
                                                </div>  
                    
                                                    <? } else {  ?>
                                                    <tbody id="servicosTable" style="width: 898px;">
                                                            <tr id="servico_0">
                                                                <td style="line-height: 10px !important;">
											                    	 <input type="hidden" name="resp_idFornecedorResponsavel[]">
											                    	 <input type="hidden" name="resp_idFornecedor[]" value="<? if (isset($result[0]->idFornecedor)) echo $result[0]->idFornecedor; ?>">
                                                                     <input class="input-small" style="width: 200px !important;" type="text" name="resp_nome[]" value="" placeholder="Nome Completo">
                                                                </td>
                                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                                    <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd[]" value="" placeholder="DDD">
                                                                    <input class="input-small" style="width: 100px !important;" type="text" name="resp_telefone[]" value="" placeholder="Telefone">
                                                                </td>
                                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                                    <input class="input-small" style="width: 230px !important;" type="text" name="resp_email[]" value="" placeholder="E-mail">
                                                                </td>
                                                                <td style="line-height: 10px !important;  font-size: 12px !important;">
                                                                    <select class="input-small" name="resp_setor[]" id="resp_setor[]" style="width: 150px;">
                                                                        <? foreach($this->data['parametroSetor'] as $setor){ ?>
                                                                        <option value="<? echo $setor->idParametro; ?>"><? echo $setor->parametro; ?></option>
                                                                        <? } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <button class="btn" type="button" onclick="removerServico(0)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        <tr id="servico_baixo_0">
                                                            <td colspan="5">
                                                                <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd2[]" value="" placeholder="DDD">
                                                                <input class="input-small" style="width: 147px !important; margin-right: 15px;" type="text" name="resp_telefone2[]" value="" placeholder="Telefone">
                                                                
                                                                <input type="checkbox" name="resp_confemail1[]" id="1_0">&nbsp;&nbsp;<label for="1_0" style="text-align: left; ">Financeiro</label>
                                                                <input type="checkbox" name="resp_confemail2[]" id="2_0">&nbsp;&nbsp;<label for="2_0" style="text-align: left">Operacional</label>
                                                                <input type="checkbox" name="resp_confemail3[]" id="3_0">&nbsp;&nbsp;<label for="3_0" style="text-align: left">Marketing</label>
                                                                <input type="checkbox" name="resp_confemail4[]" id="4_0">&nbsp;&nbsp;<label for="4_0" style="text-align: left">Retorno</label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                             
                                                
                                                <div style="height: 44px; width: 898px;">
                                                    <button class="btn btn-small" type="button" onclick="adicionarServico()" style="float: right; position: relative; top: 7px; right: 3px;"><i class="icon-plus-sign"></i> Adicionar Responsável</button>
                                                </div>   
                                                
                                                <? } ?>
                                        </div>
                    
                                        <div class="line">
                                            <label class="control-label">Situação</label>
                                            <select class="input-small" style="width: 97px !important;" name="situacao">
                                                <option value="1" <? if(isset($result[0]->situacao) && $result[0]->situacao) echo 'selected' ;?>>Ativo</option>
                                                <option value="0" <? if(isset($result[0]->situacao) && !$result[0]->situacao) echo 'selected' ;?>>Inativo</option>
                                            </select>
                                        </div>
                                                    
                                <div class="button-form line">										    
                                    <div class="span6 offset3" style="text-align: center">
                                    <? if($this->router->method=="editar"){ ?>
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                    <? } else { ?>
                                        <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                                    <? } ?>
                                    <a href="<?php echo base_url() ?>fornecedores" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                    </div>
                                </div>
                            </fieldset>
            
                        </form>
							
                        </div>

                    </div>

                </div>

                
.
             
        </div>
        
    </div>
</div>
</div>
	<?
		if(!empty($result[0]->clienteResponsaveis)){
			$quantidade = count($result[0]->clienteResponsaveis)+1;
		} else {
			$quantidade = 1;	
		}
	?>
	<input type="hidden" id="countServs" value="<?=$quantidade;?>" >
	<div style="display: none;">
		<table>
			<tbody id="servicoModelo">
				<tr id="servico_COUNT">
                    <td style="line-height: 10px !important;">
                    	 <input type="hidden" name="resp_idFornecedorResponsavel[]">
                    	 <input type="hidden" name="resp_idFornecedor[]" value="<? if (isset($result[0]->idFornecedor)) echo $result[0]->idFornecedor; ?>">
                         <input class="input-small" style="width: 200px !important;" type="text" name="resp_nome[]" value="" placeholder="Nome Completo">
                    </td>
                    <td style="line-height: 10px !important; font-size: 12px !important;">
                        <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd[]" value="" placeholder="DDD">
                        <input class="input-small" style="width: 100px !important;" type="text" name="resp_telefone[]" value="" placeholder="Telefone">
                    </td>
                    <td style="line-height: 10px !important; font-size: 12px !important;">
                        <input class="input-small" style="width: 230px !important;" type="text" name="resp_email[]" value="" placeholder="E-mail">
                    </td>
                    <td style="line-height: 10px !important;  font-size: 12px !important;">
                        <select class="input-small" name="resp_setor[]" id="resp_setor[]" style="width: 150px;">
                            <? foreach($this->data['parametroSetor'] as $setor){ ?>
                            <option value="<? echo $setor->idParametro; ?>"><? echo $setor->parametro; ?></option>
                            <? } ?>
                        </select>
                    </td>
                    <td>
                        <button class="btn" type="button" onclick="removerServico(COUNT)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                    </td>
				</tr>
                <tr id="servico_baixo_COUNT">
                <td colspan="5">
                    <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd2[]" value="" placeholder="DDD">
                    <input class="input-small" style="width: 147px !important; margin-right: 15px;" type="text" name="resp_telefone2[]" value="" placeholder="Telefone">
                    
                    <input type="checkbox" name="resp_confemail1[]" id="1_COUNT">&nbsp;&nbsp;<label for="1_COUNT" style="text-align: left; ">Financeiro</label>
                    <input type="checkbox" name="resp_confemail2[]" id="2_COUNT">&nbsp;&nbsp;<label for="2_COUNT" style="text-align: left">Operacional</label>
                    <input type="checkbox" name="resp_confemail3[]" id="3_COUNT">&nbsp;&nbsp;<label for="3_COUNT" style="text-align: left">Marketing</label>
                    <input type="checkbox" name="resp_confemail4[]" id="4_COUNT">&nbsp;&nbsp;<label for="4_COUNT" style="text-align: left">Retorno</label>
                </td>
            </tr>
			</tbody>
		</table>
	</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/clientes/js/clientes.js"></script>
