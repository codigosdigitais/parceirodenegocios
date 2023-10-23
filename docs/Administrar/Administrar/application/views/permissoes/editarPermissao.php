<?php $permissoes = unserialize($result->permissoes);?>
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>permissoes/editar" id="formPermissao" method="post">

    <div class="span12" style="margin-left: 0">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-lock"></i>
                </span>
                <h5>Editar Permissão</h5>
            </div>
            <div class="widget-content">
                
                <div class="span4">
                    <label>Nome da Permissão</label>
                    <input name="nome" type="text" id="nome" class="span12" value="<?php echo $result->nome; ?>" />
                    <input type="hidden" name="idPermissao" value="<?php echo $result->idPermissao; ?>">

                </div>

                <div class="span3">
                    <label>Situação</label>
                    
                    <select name="situacao" id="situacao" class="span12">
                        <?php if($result->situacao == 1){$sim = 'selected'; $nao ='';}else{$sim = ''; $nao ='selected';}?>
                        <option value="1" <?php echo $sim;?>>Ativo</option>
                        <option value="0" <?php echo $nao;?>>Inativo</option>
                    </select>

                </div>
                <div class="span4">
                    <br/>
                    <label>
                        <input name="" type="checkbox" value="1" id="marcarTodos" />
                        <span class="lbl"> Marcar Todos</span>

                    </label>
                    <br/>
                </div>

                <div class="control-group">
                    <label for="documento" class="control-label"></label>
                    <div class="controls">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                  <td colspan="4" style="background-color: #CCC">CADASTROS</td>
                                </tr>
                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permissoes['vCliente'])){ if($permissoes['vCliente'] == '1'){echo 'checked';}}?> name="vCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Cliente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permissoes['aCliente'])){ if($permissoes['aCliente'] == '1'){echo 'checked';}}?> name="aCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Cliente</span>
                                        </label>
                                    </td>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permissoes['eCliente'])){ if($permissoes['eCliente'] == '1'){echo 'checked';}}?> name="eCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if(isset($permissoes['dCliente'])){ if($permissoes['dCliente'] == '1'){echo 'checked';}}?> name="dCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Cliente</span>
                                        </label>
                                    </td>
                                 
                                </tr>

                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vCedente'])){ if($permissoes['vCedente'] == '1'){echo 'checked';}}?> name="vCedente" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Cedente</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aCedente'])){ if($permissoes['aCedente'] == '1'){echo 'checked';}}?> name="aCedente" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Cedente</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eCedente'])){ if($permissoes['eCedente'] == '1'){echo 'checked';}}?> name="eCedente" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Cedente</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dCedente'])){ if($permissoes['dCedente'] == '1'){echo 'checked';}}?> name="dCedente" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Cedente</span> </label></td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vFornecedor'])){ if($permissoes['vFornecedor'] == '1'){echo 'checked';}}?> name="vFornecedor" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Fornecedor</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aFornecedor'])){ if($permissoes['aFornecedor'] == '1'){echo 'checked';}}?> name="aFornecedor" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Fornecedor</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eFornecedor'])){ if($permissoes['eFornecedor'] == '1'){echo 'checked';}}?> name="eFornecedor" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Fornecedor</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dFornecedor'])){ if($permissoes['dFornecedor'] == '1'){echo 'checked';}}?> name="dFornecedor" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Fornecedor</span></label></td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vContrato'])){ if($permissoes['vContrato'] == '1'){echo 'checked';}}?> name="vContrato" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Contrato</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aContrato'])){ if($permissoes['aContrato'] == '1'){echo 'checked';}}?> name="aContrato" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Contrato</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eContrato'])){ if($permissoes['eContrato'] == '1'){echo 'checked';}}?> name="eContrato" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Contrato</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dContrato'])){ if($permissoes['dContrato'] == '1'){echo 'checked';}}?> name="dContrato" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Contrato</span></label></td>
                                </tr>

                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vFuncionario'])){ if($permissoes['vFuncionario'] == '1'){echo 'checked';}}?> name="vFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Funcionario</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aFuncionario'])){ if($permissoes['aFuncionario'] == '1'){echo 'checked';}}?> name="aFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Funcionario</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eFuncionario'])){ if($permissoes['eFuncionario'] == '1'){echo 'checked';}}?> name="eFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Funcionario</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dFuncionario'])){ if($permissoes['dFuncionario'] == '1'){echo 'checked';}}?> name="dFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Funcionario</span> </label></td>
                                </tr>

                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vDocumento'])){ if($permissoes['vDocumento'] == '1'){echo 'checked';}}?> name="vDocumento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Documento</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aDocumento'])){ if($permissoes['aDocumento'] == '1'){echo 'checked';}}?> name="aDocumento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Documento</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eDocumento'])){ if($permissoes['eDocumento'] == '1'){echo 'checked';}}?> name="eDocumento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Documento</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dDocumento'])){ if($permissoes['dDocumento'] == '1'){echo 'checked';}}?> name="dDocumento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Documento</span></label></td>
                                </tr>
                                <tr><td colspan="4"></td></tr>

                                <tr>
                                  <td colspan="4" style="background-color: #CCC">LANÇAMENTOS</td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vChamada'])){ if($permissoes['vChamada'] == '1'){echo 'checked';}}?> name="vChamada" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Chamada</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aChamada'])){ if($permissoes['aChamada'] == '1'){echo 'checked';}}?> name="aChamada" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Chamada</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eChamada'])){ if($permissoes['eChamada'] == '1'){echo 'checked';}}?> name="eChamada" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Chamada</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dChamada'])){ if($permissoes['dChamada'] == '1'){echo 'checked';}}?> name="dChamada" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Chamada</span> </label></td>
                                </tr>
                                
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vSubstituicao'])){ if($permissoes['vSubstituicao'] == '1'){echo 'checked';}}?> name="vSubstituicao" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Substituição</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aSubstituicao'])){ if($permissoes['aSubstituicao'] == '1'){echo 'checked';}}?> name="aSubstituicao" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Substituição</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eSubstituicao'])){ if($permissoes['eSubstituicao'] == '1'){echo 'checked';}}?> name="eSubstituicao" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Substituição</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dSubstituicao'])){ if($permissoes['dSubstituicao'] == '1'){echo 'checked';}}?> name="dSubstituicao" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Substituição</span> </label></td>
                                </tr>
                                
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vProvento'])){ if($permissoes['vProvento'] == '1'){echo 'checked';}}?> name="vProvento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Provento</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aProvento'])){ if($permissoes['aProvento'] == '1'){echo 'checked';}}?> name="aProvento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Provento</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eProvento'])){ if($permissoes['eProvento'] == '1'){echo 'checked';}}?> name="eProvento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Provento</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dProvento'])){ if($permissoes['dProvento'] == '1'){echo 'checked';}}?> name="dProvento" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Provento</span> </label></td>
                                </tr>
                                
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vDesconto'])){ if($permissoes['vDesconto'] == '1'){echo 'checked';}}?> name="vDesconto" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Desconto</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aDesconto'])){ if($permissoes['aDesconto'] == '1'){echo 'checked';}}?> name="aDesconto" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Desconto</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eDesconto'])){ if($permissoes['eDesconto'] == '1'){echo 'checked';}}?> name="eDesconto" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Desconto</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dDesconto'])){ if($permissoes['dDesconto'] == '1'){echo 'checked';}}?> name="dDesconto" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Desconto</span> </label></td>
                                </tr>
                                
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vFalta'])){ if($permissoes['vFalta'] == '1'){echo 'checked';}}?> name="vFalta" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Falta</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aFalta'])){ if($permissoes['aFalta'] == '1'){echo 'checked';}}?> name="aFalta" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Falta</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eFalta'])){ if($permissoes['eFalta'] == '1'){echo 'checked';}}?> name="eFalta" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Falta</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dFalta'])){ if($permissoes['dFalta'] == '1'){echo 'checked';}}?> name="dFalta" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Falta</span> </label></td>
                                </tr>
                                
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['vAtraso'])){ if($permissoes['vAtraso'] == '1'){echo 'checked';}}?> name="vAtraso" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Visualizar Atraso</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aAtraso'])){ if($permissoes['aAtraso'] == '1'){echo 'checked';}}?> name="aAtraso" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Atraso</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eAtraso'])){ if($permissoes['eAtraso'] == '1'){echo 'checked';}}?> name="eAtraso" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Atraso</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dAtraso'])){ if($permissoes['dAtraso'] == '1'){echo 'checked';}}?> name="dAtraso" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Atraso</span> </label></td>
                                </tr>
                                <tr><td colspan="4"></td></tr>
                                
                                <tr>
                                  <td colspan="4" style="background-color: #CCC">FECHAMENTOS</td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['fFuncionario'])){ if($permissoes['fFuncionario'] == '1'){echo 'checked';}}?> name="fFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Funcionário</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['fParticular'])){ if($permissoes['fParticular'] == '1'){echo 'checked';}}?> name="fParticular" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Particulares</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['fEmpresa'])){ if($permissoes['fEmpresa'] == '1'){echo 'checked';}}?> name="fEmpresa" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Chamadas Empresa</span> </label></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr><td colspan="4"></td></tr>

                                  <tr>
                                  <td colspan="4" style="background-color: #CCC">OPÇÕES</td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['oHolerite'])){ if($permissoes['oHolerite'] == '1'){echo 'checked';}}?> name="oHolerite" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Holerite</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['oEtiqueta'])){ if($permissoes['oEtiqueta'] == '1'){echo 'checked';}}?> name="oEtiqueta" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Etiqueta</span> </label></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr><td colspan="4"></td></tr>
                             
                                
                                

                                <tr>
                                    <td colspan="4" style="background-color: #CCC">RELATÓRIOS</td>
                                </tr>

                                <tr>

                                    <td>
                                        <label>
                                            <input <?php if(isset($permissoes['rContrato'])){ if($permissoes['rContrato'] == '1'){echo 'checked';}}?> name="rContrato" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Contrato</span>
                                        </label>
                                    </td>

                                    <td>
                                    	<label>
                                    		<input <?php if(isset($permissoes['rChamada'])){ if($permissoes['rChamada'] == '1'){echo 'checked';}}?> name="rChamada" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Chamada</span>
                                    	</label>
                                    </td>

                                    <td>                                    	<label>
                                    		<input <?php if(isset($permissoes['rCliente'])){ if($permissoes['rCliente'] == '1'){echo 'checked';}}?> name="rCliente" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Cliente</span>
                                    	</label></td>

                                    <td>                                    	<label>
                                    		<input <?php if(isset($permissoes['rFuncionario'])){ if($permissoes['rFuncionario'] == '1'){echo 'checked';}}?> name="rFuncionario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Funcionário Salários</span>
                                    	</label></td>
                                 
                                </tr>
                                <tr><td colspan="4"></td></tr>

                                <tr>
                                    <td colspan="4" style="background-color: #CCC">CONFIGURAÇÕES</td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aParametro'])){ if($permissoes['aParametro'] == '1'){echo 'checked';}}?> name="aParametro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Parâmetro</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eParametro'])){ if($permissoes['eParametro'] == '1'){echo 'checked';}}?> name="eParametro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Parâmetro</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dParametro'])){ if($permissoes['dParametro'] == '1'){echo 'checked';}}?> name="dParametro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Parâmetro</span></label></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aCidade'])){ if($permissoes['aCidade'] == '1'){echo 'checked';}}?> name="aCidade" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Cidade</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eCidade'])){ if($permissoes['eCidade'] == '1'){echo 'checked';}}?> name="eCidade" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Cidade</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dCidade'])){ if($permissoes['dCidade'] == '1'){echo 'checked';}}?> name="dCidade" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Cidade</span></label></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aBairro'])){ if($permissoes['aBairro'] == '1'){echo 'checked';}}?> name="aBairro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Bairro</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eBairro'])){ if($permissoes['eBairro'] == '1'){echo 'checked';}}?> name="eBairro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Bairro</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dBairro'])){ if($permissoes['dBairro'] == '1'){echo 'checked';}}?> name="dBairro" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Bairro</span></label></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['aTabelaFrete'])){ if($permissoes['aTabelaFrete'] == '1'){echo 'checked';}}?> name="aTabelaFrete" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Adicionar Tabela</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['eTabelaFrete'])){ if($permissoes['eTabelaFrete'] == '1'){echo 'checked';}}?> name="eTabelaFrete" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Editar Tabela</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['dTabelaFrete'])){ if($permissoes['dTabelaFrete'] == '1'){echo 'checked';}}?> name="dTabelaFrete" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Excluir Tabela</span></label></td>
                                  <td></td>
                                </tr>

                                <tr>
                                  <td><label>
                                    <input <?php if(isset($permissoes['cUsuario'])){ if($permissoes['cUsuario'] == '1'){echo 'checked';}}?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Configurar Usuário</span> </label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['cBackup'])){ if($permissoes['cBackup'] == '1'){echo 'checked';}}?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Backup</span></label></td>
                                  <td><label>
                                    <input <?php if(isset($permissoes['cPermissao'])){ if($permissoes['cPermissao'] == '1'){echo 'checked';}}?> name="cPermissao" class="marcar" type="checkbox" value="1" />
                                    <span class="lbl"> Configurar Permissão</span> </label></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr><td colspan="4"></td></tr>


                            </tbody>
                        </table>
                    </div>
                </div>

              
    
            <div class="form-actions">
                <div class="span12">
                    <div class="span6 offset3">
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <a href="<?php echo base_url() ?>permissoes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
           
            </div>
        </div>

                   
    </div>

</form>

</div>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){


        $("#marcarTodos").click(function(){

            if ($(this).attr("checked")){
              $('.marcar').each(
                 function(){
                    $(this).attr("checked", true);
                 }
              );
           }else{
              $('.marcar').each(
                 function(){
                    $(this).attr("checked", false);
                 }
              );
           }

        });   


 
    $("#formPermissao").validate({
        rules :{
            nome: {required: true}
        },
        messages:{
            nome: {required: 'Campo obrigatório'}
        }
    });     

        

    });
</script>
