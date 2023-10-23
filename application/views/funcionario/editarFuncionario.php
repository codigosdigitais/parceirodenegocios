<style>
	.recuo-margem
	{
		height: 65px;	
	}
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
              <div class="widget-title">
                    <span class="icon">
                          <i class="icon-align-justify"></i>
                    </span>
                    <h5>Editar Funcionário</h5>
              </div>
              
            <div class="widget-content nopadding">
                <div class="span12" id="divFuncionario" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
							<form action="<?php echo current_url(); ?>" method="post" id="formFuncionario">
                                <div class="span12" id="divFuncionarioCadastrarDados">
                                
										<?php if($custom_error == true){ ?>
                                        <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">
                                            Dados incompletos, verifique os campos com asterisco
                                        </div>
                                        <?php } ?>

                                        <?php echo form_hidden('idFuncionario',$result->idFuncionario) ?>
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <label for="nome">Nome</label>
                                            <input id="nome" class="span12" type="text" name="nome" value="<? echo $result->nome; ?>"  placeholder="Nome Completo"  />
                                        </div>

                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span3">
                                                <label for="escolaridade">Escolaridade</label>
                                                    <select class="span12" name="escolaridade" id="escolaridade" value="">
                                                        <option value="0" <? if($result->escolaridade=='0'){ echo "selected"; } ?>>Selecione</option>
                                                        <option value="1" <? if($result->escolaridade=='1'){ echo "selected"; } ?>>Primeiro Grau Completo</option>
                                                        <option value="2" <? if($result->escolaridade=='2'){ echo "selected"; } ?>>Primeiro Grau Incompleto</option>
                                                        <option value="3" <? if($result->escolaridade=='3'){ echo "selected"; } ?>>Segundo Grau Completo</option>
                                                        <option value="4" <? if($result->escolaridade=='4'){ echo "selected"; } ?>>Segundo Grau Incompleto</option>
                                                        <option value="5" <? if($result->escolaridade=='5'){ echo "selected"; } ?>>Superior Completo</option>
                                                        <option value="6" <? if($result->escolaridade=='6'){ echo "selected"; } ?>>Superior Incompleto</option>
                                                    </select>
                                            </div>
                                            <div class="span3">
                                                <label for="dataNascimento">Data de Nasc.</label>
                                                <input id="dataNascimento" class="span12" type="text" name="dataNascimento" value="<? echo date('d/m/Y', strtotime($result->dataNascimento)); ?>" placeholder="DD/MM/YYYY"  />
                                            </div>
                                            <div class="span3">
                                                <label for="sexo">Sexo</label>
                                                <select class="span12" name="sexo" id="sexo" value="<? echo $result->sexo; ?>">
                                                    <option value="1" <? if($result->sexo=='1'){ echo "selected"; } ?>>Masculino</option>
                                                    <option value="2" <? if($result->sexo=='2'){ echo "selected"; } ?>>Feminino</option>
                                                </select>
                                            </div>
    
                                            <div class="span3">
                                                <label for="naturalidade">Naturalidade</label>
                                                <input id="naturalidade" type="text" class="span12" name="naturalidade" value="<? echo $result->naturalidade; ?>"  />
                                            </div>
                                        </div>
    



                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span6">
                                                <label for="filiacaoPai">Filiação</label>
												<input id="filiacaoPai" class="span12" type="text" name="filiacaoPai" value="<? echo $result->filiacaoPai; ?>" placeholder="Nome do Pai"  />
                                            </div>
                                            <div class="span6">
                                                <label for="filiacaoMae">&nbsp;</label>
                                                <input id="filiacaoMae" class="span12" type="text" name="filiacaoMae" value="<? echo $result->filiacaoMae; ?>"  placeholder="Nome da Mãe" />
                                            </div>
                                        </div>
                                        
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span4">
                                                <label for="estadoCivil">Estado Civil</label>
												<select class="span12" name="estadoCivil" id="estadoCivil" value="<? echo $result->estadoCivil; ?>">
                                                    <option value="1"  <? if($result->estadoCivil=='1'){ echo "selected"; } ?>>Casado</option>
                                                    <option value="2" <? if($result->estadoCivil=='2'){ echo "selected"; } ?>>Solteiro</option>
                                                    <option value="3" <? if($result->estadoCivil=='3'){ echo "selected"; } ?>>Divorciado</option>
                                                    <option value="4" <? if($result->estadoCivil=='4'){ echo "selected"; } ?>>Separado</option>
                                                    <option value="5" <? if($result->estadoCivil=='5'){ echo "selected"; } ?>>Viúvo</option>
                                                    <option value="6" <? if($result->estadoCivil=='6'){ echo "selected"; } ?>>Outros</option>
                                                </select>
                                            </div>
                                            <div class="span8">
                                                <label for="conjuge">Conjuge</label>
                                                <input id="conjuge" class="span12" type="text" name="conjuge" value="<? echo $result->conjuge; ?>"  placeholder="Nome do Conjuge" />
                                            </div>
                                        </div>


                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span4">
                                                <label for="endereco">Endereço</label>
												<input id="endereco" class="span12" type="text" name="endereco" value="<? echo $result->endereco; ?>"  placeholder="Endereço" />
                                            </div>
                                            <div class="span4">
                                                <label for="enderecoNumero">Número</label>
                                                <input id="enderecoNumero" class="span12" type="text" name="enderecoNumero" value="<? echo $result->enderecoNumero; ?>"  placeholder="Número" />
                                            </div>
                                            
                                            <div class="span4">
                                                <label for="enderecoComplemento">Complemento</label>
                                                <input id="enderecoComplemento" class="span12" type="text" name="enderecoComplemento" value="<? echo $result->enderecoComplemento; ?>"  placeholder="Complemento" />
                                            </div>
                                        </div>


                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span4">
                                                <label for="enderecoBairro">Bairro</label>
												<input id="enderecoBairro" class="span12" type="text" name="enderecoBairro" value="<? echo $result->enderecoBairro; ?>"  placeholder="Bairro" />
                                            </div>
                                            <div class="span4">
                                                <label for="enderecoCidade">Cidade</label>
                                                <input id="enderecoCidade" class="span12" type="text" name="enderecoCidade" value="<? echo $result->enderecoCidade; ?>"  placeholder="Cidade" />
                                            </div>
                                            
                                            <div class="span4">
                                                <label for="enderecoEstado">Estado</label>
												<select class="span12" name="enderecoEstado" id="enderecoEstado" value="<? echo $result->enderecoEstado; ?>">
												<? foreach($this->data['estados'] as $valor){ ?>
                                                	<option value="<? echo $valor->idEstado;?>" <? if($valor->idEstado==$result->enderecoEstado){ echo "selected"; } ?>><? echo $valor->estado;?></option>
                                                <? } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span4">
                                                <label for="telefonePrincipalFixo">Telefone Fixo</label>
                                                <input id="telefonePrincipalFixoDDD" class="span2" type="text" name="telefonePrincipalFixoDDD" value="<? echo $result->telefonePrincipalFixoDDD; ?>" />
                                                <input id="telefonePrincipalFixo" class="span10" type="text" name="telefonePrincipalFixo" value="<? echo $result->telefonePrincipalFixo; ?>" />
                                            </div>
                                            <div class="span4">
                                                <label for="telefonePrincipalCelular">Celular</label>
                                                <input id="telefonePrincipalCelularDDDD" class="span2" type="text" name="telefonePrincipalCelularDDD" value="<? echo $result->telefonePrincipalCelularDDD; ?>" />
                                                <input id="telefonePrincipalCelular" class="span10" type="text" name="telefonePrincipalCelular" value="<? echo $result->telefonePrincipalCelular; ?>" />
                                            </div>
                                            
                                            <div class="span4">
                                                <label for="emailPessoal">E-mail Pessoal</label>
												<input id="emailPessoal" class="span12" type="text" name="emailPessoal" value="<? echo $result->emailPessoal; ?>"  placeholder="E-mail Pessoal" />
                                            </div>
                                        </div>

                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span4">
                                                <label for="telefoneFixoEmpresa">Telefone Fixo</label>
                                                <input id="telefoneFixoEmpresaDDD" class="span2" type="text" name="telefoneFixoEmpresaDDD" value="<? echo $result->telefoneFixoEmpresaDDD; ?>" />
                                                <input id="telefoneFixoEmpresa" class="span10" type="text" name="telefoneFixoEmpresa" value="<? echo $result->telefoneFixoEmpresa; ?>" />
                                            </div>
                                            <div class="span4">
                                                <label for="telefoneCelularEmpresa">Celular</label>
                                                <input id="telefoneCelularEmpresaDDD" class="span2" type="text" name="telefoneCelularEmpresaDDD" value="<? echo $result->telefoneCelularEmpresaDDD; ?>" />
                                                <input id="telefoneCelularEmpresa" class="span10" type="text" name="telefoneCelularEmpresa" value="<? echo $result->telefoneCelularEmpresa; ?>" />
                                            </div>
                                            
                                            <div class="span4">
                                                <label for="emailEmpresa">E-mail Empresa</label>
												<input id="emailEmpresa" class="span12" type="text" name="emailEmpresa" value="<? echo $result->emailEmpresa; ?>"  placeholder="E-mail Empresa" />
                                            </div>
                                        </div>
										
                                        <div class="span12" style="border-bottom: solid 1px #CCC; padding: 1%; margin-left: 0">
										</div>
                                        <div class="span12" style="border-bottom: solid 1px #CCC; padding: 1%; margin-left: 0">
                                        	<h4>Documentos</h4>
										</div>

                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span3">
                                                <label for="documentoCPF">CPF</label>
                                                <input id="documentoCPF" type="text" class="span12" name="documentoCPF" value="<? echo $result->documentoCPF; ?>" placeholder="Número CPF" />
                                            </div>
                                            <div class="span3">
                                                <label for="documentoRG">RG</label>
                                                <input id="documentoRG" class="span12" type="text" name="documentoRG" value="<? echo $result->documentoRG; ?>" placeholder="Número RG"  />
                                            </div>
                                            <div class="span3">
                                                <label for="documentoCNH">CNH</label>
                                                <input id="documentoCNH" type="text" class="span12" name="documentoCNH" value="<? echo $result->documentoCNH; ?>" placeholder="Número CNH"  />
                                            </div>
    
                                            <div class="span3">
                                                <label for="documentoCTPS">CTPS</label>
                                                <input id="documentoCTPS" type="text" class="span12" name="documentoCTPS" value="<? echo $result->documentoCTPS; ?>" placeholder="Número CTPS"  />
                                            </div>
                                        </div>
    


                                        <div class="span12" style="border-bottom: solid 1px #CCC; padding: 1%; margin-left: 0">
										</div>
                                        <div class="span12" style="border-bottom: solid 1px #CCC; padding: 1%; margin-left: 0">
                                        	<h4>Remuneração</h4>
										</div>


                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span3">
                                                <label for="salarioBase">Salário Base</label>
                                                <input id="salarioBase" type="text" class="span12 money" name="salarioBase" value="<? echo number_format($result->salarioBase, 2, '.', ''); ?>" placeholder="0.00" />
                                            </div>
                                            <div class="span3">
                                                <label for="salarioAuxilio">Auxilios</label>
                                                <input id="salarioAuxilio" class="span12 money" type="text" name="salarioAuxilio" value="<? echo number_format($result->salarioAuxilio, 2, '.', ''); ?>" placeholder="0.00"  />
                                            </div>
                                            <div class="span3">
                                                <label for="dataAdmissao">Data de Admissão</label>
                                                <input id="dataAdmissao" type="text" class="span12" name="dataAdmissao" value="<? echo date('d/m/Y', strtotime($result->dataAdmissao)); ?>" placeholder="DD/MM/YYYY"  />
                                            </div>
    
                                            <div class="span3">
                                                <label for="dataDemissao">Data de Demissão</label>
                                                <input id="dataDemissao" type="text" class="span12" name="dataDemissao" value="<? echo date('d/m/Y', strtotime($result->dataDemissao)); ?>" placeholder="DD/MM/YYYY"  />
                                            </div>
                                        </div>

                                        <div class="span12 recuo-margem" style="padding: 1%; margin-left: 0">
                                            <div class="span3">
                                                <label for="status">Status do Cadastro</label>
												<select class="span4" name="status" id="status" style="width: 180px" value="<? echo $result->status; ?>">
                                                    <option value="1" <? if($result->status=='1'){ echo "selected"; } ?> >Ativo</option>
                                                    <option value="2" <? if($result->status=='2'){ echo "selected"; } ?> >Afastado</option>
                                                    <option value="3" <? if($result->status=='3'){ echo "selected"; } ?> >Demitido</option>
                                                    <option value="4" <? if($result->status=='4'){ echo "selected"; } ?>>Outros</option>
                                                </select>
                                            </div>
                                    </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                        
                                            <div class="span6 offset3" style="text-align: center">
                                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                                <a href="<?php echo base_url() ?>funcionario" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>

<script type="text/javascript">
      $(document).ready(function(){
		  
		  $(".money").maskMoney();
		  
      });
</script>