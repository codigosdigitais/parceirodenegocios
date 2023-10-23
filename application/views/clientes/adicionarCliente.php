<?
   #Define Títulos Topo
   if($this->router->method=="editar")
   {
   	$tituloBase = "Editar Cliente";
   } 
   else
   {
   	$tituloBase = "Cadastro de Cliente"; 
   }
   
   ?>
<script type="text/javascript">
   $(document).ready(function() {
   
   	onSubmitChangeCheckboxesToInput('#form-cliente', 'input:checkbox');
   	
   });
</script>
<nav aria-label="breadcrumb">
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><?=$tituloBase;?></li>
   </ol>
   <ol class="breadcrumb"> 
      <?php if($this->permission->canInsert() && !$this->router->method=="editar"){ ?>
      <a href="<?php echo base_url();?>clientes/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Novo</a>
      <?php } ?>
      <a title="Voltar" class="btn btn-danger" href="<?php echo base_url().'clientes/'; ?>"><i class="icon-list icon-white"></i> Listar todos</a>
   </ol>
</nav>
<form id="form-cliente" class="form-inline" method="post" action="<?php echo current_url(); ?>">
   <?php 
      if($this->router->method=="editar"){
          echo form_hidden('idCliente',$result[0]->idCliente);
      } 
      ?>
   <fieldset>
      <legend><i class="icon-plus icon-title"></i> Novo Cliente</legend>
      <div class="line">
         <label class="control-label">Razão Social</label>
         <input class="input-xxlarge" type="text" placeholder="Razão Social" name="razaosocial" value="<? if(isset($result[0]->razaosocial)){ echo $result[0]->razaosocial; } ;?>" onblur="copiarRazaoSocial()" <? if($this->router->method=="editar"){ echo ""; } else { echo "autofocus"; } ?> required="required">
      </div>
      <div class="line">
         <label class="control-label">Nome Fantasia</label>
         <input class="input-xxlarge" type="text" placeholder="Nome Fantasia" name="nomefantasia" value="<? if(isset($result[0]->nomefantasia)){ echo $result[0]->nomefantasia; } ;?>" required="required">
      </div>
      <div class="line">
         <label class="control-label">CNPJ/CPF</label>
         <input class="input-medium" type="text" placeholder="CNPJ/CPF" id="cnpj" name="cnpj" value="<? if(isset($result[0]->cnpj)){ echo $result[0]->cnpj; } ;?>" maxlength="20" required="required">
         <label class="control-label">Insc. Est.</label>
         <input class="input-medium" type="text" placeholder="Inscrição Estadual" name="ie" value="<? if(isset($result[0]->ie)){ echo $result[0]->ie; } ;?>">
         <label class="control-label">Insc. Mun.</label>
         <input class="input-medium" type="text" placeholder="Inscrição Municipal" name="im" value="<? if(isset($result[0]->im)){ echo $result[0]->im; } ;?>">
      </div>
      <div class="line">
         <label class="control-label">Endereço</label>
         <input class="input-large" type="text" placeholder="Endereço" name="endereco" style="width: 250px !important;" value="<? if(isset($result[0]->endereco)){ echo $result[0]->endereco; } ;?>">
         <label class="control-label" style="width: 80px !important;">Número</label>
         <input class="input-medium" type="text" placeholder="Número" name="endereco_numero"  style="width: 80px !important;" value="<? if(isset($result[0]->endereco_numero)){ echo $result[0]->endereco_numero; } ;?>">
         <label class="control-label">Complemento</label>
         <input class="input-small" type="text" placeholder="Complemento" name="endereco_complemento"  style="width: 158px !important;" value="<? if(isset($result[0]->endereco_complemento)){ echo $result[0]->endereco_complemento; } ;?>">
      </div>
      <!--- alterado --->
      <div class="line">
         <label class="control-label">Estado</label>
         <select class="input-smallx endereco_estado" name="endereco_estado" id="endereco_estado" onchange="getCidade()" >
            <option>Selecione o Estado</option>
            <?
               foreach($this->data['estados'] as $estado){
               ?>	
            <option value="<?=$estado->idEstado?>"  <? if(isset($result[0]->endereco_estado)){ if($estado->idEstado==$result[0]->endereco_estado){ echo "selected"; } } ?> ><?=$estado->estado;?></option>
            <? 
               }
               ?>
         </select>
         <label class="control-label" style="width: 60px !important;">Cidade</label>
         <select id="endereco_cidade" class="endereco_cidade" name="endereco_cidade" onchange="getBairro()">
            <?
               if($this->router->method=="editar"){
               ?>
            <?
               foreach($listagem_cidade as $cidade){ 
               ?>
            <option value="<? echo $cidade->idCidade; ?>"  <? if(isset($result[0]->endereco_cidade)){ if($cidade->idCidade==$result[0]->endereco_cidade){ echo "selected"; } } ?> ><? echo $cidade->cidade; ?></option>
            <? } ?>
            <? } else { ?>
            <option>&#9666 Selecione a Cidade </option>
            <? } ?>
         </select>
         <label class="control-label" style="width: 60px !important;">Bairro</label>
         <select style="width: 169px !important;" id="endereco_bairro" name="endereco_bairro" class="endereco_bairro">
            <?
               if($this->router->method=="editar"){
               ?>
            <?
               foreach($listagem_bairro as $bairro){ 
               ?>
            <option value="<? echo $bairro->idBairro; ?>"  <? if(isset($result[0]->endereco_bairro)){ if($bairro->idBairro==$result[0]->endereco_bairro){ echo "selected"; } } ?> ><? echo $bairro->bairro; ?></option>
            <? } ?>
            <? } else { ?>
            <option>&#9666 Selecione o Bairro </option>
            <? } ?>
         </select>
      </div>
      <div class="line">
         <label class="control-label">Responsável</label>
         <input class="input-xlarge" style="width: 575px !important" type="text" placeholder="Responsável" name="responsavel" value="<? if(isset($result[0]->responsavel)){ echo $result[0]->responsavel; } ;?>">
         <label class="control-label" style="width: 50px !important" >CEP</label>
         <input class="input-small" type="text" placeholder="CEP" maxlength="8" name="endereco_cep" value="<? if(isset($result[0]->endereco_cep)){ echo $result[0]->endereco_cep; } ;?>">
      </div>
      <div class="line">
         <label class="control-label">Telefone</label>
         <input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_telefone_ddd" value="<? if(isset($result[0]->responsavel_telefone_ddd)){ echo $result[0]->responsavel_telefone_ddd; } ;?>">
         <input class="input-small" type="text" placeholder="Telefone" maxlength="9" name="responsavel_telefone" value="<? if(isset($result[0]->responsavel_telefone)){ echo $result[0]->responsavel_telefone; } ;?>">
         <label class="control-label" style="width: 50px !important;">Celular</label>
         <input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_celular_ddd" value="<? if(isset($result[0]->responsavel_celular_ddd)){ echo $result[0]->responsavel_celular_ddd; } ;?>">
         <input class="input-small" type="text" placeholder="Celular" maxlength="9" name="responsavel_celular" value="<? if(isset($result[0]->responsavel_celular)){ echo $result[0]->responsavel_celular; } ;?>">
         <label class="control-label" style="width: 40px !important;">Email</label>
         <input class="input-medium" type="text" placeholder="Email" style="width: 168px !important;" name="email" value="<? if(isset($result[0]->email)){ echo $result[0]->email; } ;?>">
         <label class="control-label" style="width: 40px !important;">Ativo</label>
         <input id="dp1" class="input-small" type="text" placeholder="DD/MM/YYYY" maxlength="10" name="data_ativo" value="<? if(isset($result[0]->data_ativo)){ echo date('d/m/Y', strtotime($result[0]->data_ativo)); } ;?>">
      </div>
      <legend class="form-title"><a href="javascript:copiarDados();"><i title="Copiar Dados" class="icon-list-alt icon-title"></i></a> Dados Para Faturamento</legend>
      <div class="line">
         <label class="control-label">Cedente</label>
         <select class="input-xxlarge" style="width: 758px !important;" name="codCedente" >
            <? foreach($this->data['listaCedente'] as $listaCedente){ ?>
            <option value="<? echo $listaCedente->idCedente;?>" <? if(isset($result[0]->codCedente)){  if($result[0]->codCedente==$listaCedente->idCedente){ echo "selected"; }  } ?> ><? echo $listaCedente->razaosocial;?></option>
            <? } ?>
         </select>
      </div>
      <div class="line">
         <label class="control-label">Endereço</label>
         <input class="input-large" type="text" placeholder="Endereço" name="fat_endereco" value="<? if(isset($result[0]->fat_endereco)){ echo $result[0]->fat_endereco; } ;?>">
         <label class="control-label">Número</label>
         <input class="input-medium" type="text" placeholder="Número" name="fat_endereco_numero" value="<? if(isset($result[0]->fat_endereco_numero)){ echo $result[0]->fat_endereco_numero; } ;?>">
         <label class="control-label">Complemento</label>
         <input class="input-small" type="text" placeholder="Complemento" name="fat_endereco_complemento" value="<? if(isset($result[0]->fat_endereco_complemento)){ echo $result[0]->fat_endereco_complemento; } ;?>">
      </div>
      <div class="line">
         <label class="control-label">Estado</label>
         <select class="input-smallx fat_endereco_estado" name="fat_endereco_estado" id="fat_endereco_estado" onchange="fat_getCidade()" >
            <option>Selecione o Estado</option>
            <?
               foreach($this->data['estados'] as $estado){
               ?>	
            <option value="<?=$estado->idEstado?>"  <? if(isset($result[0]->fat_endereco_estado)){ if($estado->idEstado==$result[0]->fat_endereco_estado){ echo "selected"; } } ?> ><?=$estado->estado;?></option>
            <? 
               }
               ?>
         </select>
         <label class="control-label" style="width: 60px !important;">Cidade</label>
         <select id="fat_endereco_cidade" class="fat_endereco_cidade" name="fat_endereco_cidade" onchange="fat_getBairro()">
            <?
               if($this->router->method=="editar"){
               ?>
            <option>&#9666 Selecione a Cidade </option>
            <?
               foreach($fat_listagem_cidade as $cidade){ 
               ?>
            <option value="<? echo $cidade->idCidade; ?>"  <? if(isset($result[0]->fat_endereco_cidade)){ if($cidade->idCidade==$result[0]->fat_endereco_cidade){ echo "selected"; } } ?> ><? echo $cidade->cidade; ?></option>
            <? } ?>
            <? } else { ?>
            <option>&#9666 Selecione a Cidade </option>
            <? } ?>
         </select>
         <label class="control-label" style="width: 60px !important;">Bairro</label>
         <select style="width: 169px !important;" id="fat_endereco_bairro" name="fat_endereco_bairro" class="fat_endereco_bairro">
            <?
               if($this->router->method=="editar"){
               ?>
            <option>&#9666 Selecione o Bairro </option>
            <?
               foreach($fat_listagem_bairro as $bairro){ 
               ?>
            <option value="<? echo $bairro->idBairro; ?>"  <? if(isset($result[0]->fat_endereco_bairro)){ if($bairro->idBairro==$result[0]->fat_endereco_bairro){ echo "selected"; } } ?> ><? echo $bairro->bairro; ?></option>
            <? } ?>
            <? } else { ?>
            <option>&#9666 Selecione o Bairro </option>
            <? } ?>
         </select>
      </div>
      <div class="line">
         <label class="control-label">Vencimento</label>
         <select class="input-medium" name="vencimento" style="width: 200px !important"  >
            <? for($i=1; $i<=31; $i++){ ?>
            <option value="<?=$i;?>" <? if(isset($result[0]->vencimento)){ if($result[0]->vencimento==$i){ echo "selected"; } } ?> ><?=$i;?> DE CADA MÊS</option>
            <? } ?>
         </select>
         <label class="control-label" style="width: 150px !important" >Forma de Pag.</label>
         <select class="input-medium" name="forma_de_pagamento"  style="width: 178px !important"  >
            <? foreach($this->data['parametroFormaPagamento'] as $parametroFormaPagamento){ ?>
            <option value="<?=$parametroFormaPagamento->idParametro;?>" ><?=$parametroFormaPagamento->parametro;?></option>
            <? } ?>
         </select>
         <label class="control-label" style="width: 115px !important;">Nota</label>
         <select class="input-small" name="nota">
            <?
               foreach($this->data['parametroNota'] as $parametroNota){ 
               ?>
            <option value="<?=$parametroNota->idParametro;?>" <? if(isset($result[0]->nota)){ if($result[0]->nota==$parametroNota->idParametro){ echo "selected"; } } ?>><?=$parametroNota->parametro;?></option>
            <? } ?>
         </select>
      </div>
      <div class="line">
         <label class="control-label">Fechamento</label>
         <select class="input-mini" name="fechamento_de" >
            <? for($i=1; $i<=31; $i++){ ?>
            <option value="<?=$i;?>" <? if(isset($result[0]->fechamento_de)){ if($result[0]->fechamento_de==$i){ echo "selected"; } } ?> ><?=$i;?></option>
            <? } ?>
         </select>
         <label class="control-label" style="width: 15px !important;">à</label>
         <select class="input-mini" name="fechamento_a" >
            <? for($i=1; $i<=31; $i++){ ?>
            <option value="<?=$i;?>" <? if(isset($result[0]->fechamento_a)){ if($result[0]->fechamento_a==$i){ echo "selected"; } } ?> ><?=$i;?></option>
            <? } ?>
         </select>
         <label class="control-label">Guias</label>
         <select class="input-medium" style="width: 117px !important; "name="guias">
            <option value="0" <? if(isset($result[0]->guias)){ if($result[0]->guias==0){ echo "selected"; } } ?> >NÃO</option>
            <option value="1" <? if(isset($result[0]->guias)){ if($result[0]->guias==1){ echo "selected"; } } ?> >SIM</option>
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
                  <input class="input-small" style="width: 35px !important;" type="text" name="resp_telefoneddd[]" value="" placeholder="DDD">
                  <input class="input-small" style="width: 147px !important; margin-right: 15px;" type="text" name="resp_telefone[]" value="" placeholder="Telefone">
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
      <div class="line"></div>
      <hr>
      <div class="line">
         <label class="control-label">Situação</label>
         <select class="input-small" style="width: 97px !important;" name="situacao">
            <option value="1" <? if(isset($result[0]->situacao) && $result[0]->situacao) echo "selected"; ?>>Ativo</option>
            <option value="0" <? if(isset($result[0]->situacao) && !$result[0]->situacao) echo "selected"; ?>>Inativo</option>
         </select>
      </div>
      <hr>
      <div class="button-form line">
         <div class="span6 offset3" style="text-align: center">
            <? if($this->router->method=="editar"){ ?>
            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
            <? } else { ?>
            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
            <? } ?>
            <a href="<?php echo base_url($urlBtnRetornar) ?>" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
         </div>
      </div>
   </fieldset>
   <input type="hidden" name="urlBtnRetornar" value="<?php echo $urlBtnRetornar; ?>">
</form>
<?php
   if(!empty($listaResponsaveis)){
   	$quantidade = @count($listaResponsaveis)+1;
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
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script>
   $('#dp1').datepicker({
   	autoclose : true,
   	todayBtn: true,
   	monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
   	monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
   	dateFormat: 'dd/mm/yy'
   });
   
   
   maskNum('cnpj');
   maskNum('ie');
   maskNum('im');
   maskNum('endereco_cep');
   maskNum('responsavel_telefone_ddd');
   maskNum('responsavel_telefone');
   maskNum('responsavel_celular_ddd');
   maskNum('responsavel_celular');
   maskNum('fat_endereco_cep');
   maskNum('fat_telefone_ddd');
   maskNum('fat_telefone');
   maskNum('fat_celular_ddd');
   maskNum('fat_celular');
   	
   	
   $(document).ready(function(){
   	$(".money").maskMoney();
   		$('#formFuncionario').validate({
   		rules :{
   			  nome:{ required: true},
   		},
   		messages:{
   			  nome :{ required: ''},
   	},
   		errorClass: "help-inline",
   		errorElement: "span",
   		highlight:function(element, errorClass, validClass) {
   			$(element).parents('.control-group').addClass('error');
   		},
   		unhighlight: function(element, errorClass, validClass) {
   			$(element).parents('.control-group').removeClass('error');
   			$(element).parents('.control-group').addClass('success');
   		}
   	});
   });
   
   /* Jquery para Estados/Cidades/Bairros */
   	function getCidade() {
   		var id = $('#endereco_estado').val();
   		$(".endereco_cidade").append('<option value="0">Carregando...</option>');
   		$.post("<? echo base_url('/'); ?>clientes/ajax/cidade/" + id,
   			{endereco_cidade:jQuery(id).val()},
   			function(valor){
   				 $(".endereco_cidade").html(valor);
   			}
   		);
   	}
   	
   	function getBairro() {
   		var id = $('#endereco_cidade').val();
   		$(".endereco_bairro").append('<option value="0">Carregando...</option>');
   		$.post("<? echo base_url('/'); ?>clientes/ajax/bairro/" + id,
   			{endereco_bairro:jQuery(id).val()},
   			function(valor){
   				 $(".endereco_bairro").html(valor);
   			}
   		);
   	}
   	
   	
   	function fat_getCidade() {
   		var id = $('#fat_endereco_estado').val();
   		$(".fat_endereco_cidade").append('<option value="0">Carregando...</option>');
   		$.post("<? echo base_url('/'); ?>clientes/ajax/cidade/" + id,
   			{fat_endereco_cidade:jQuery(id).val()},
   			function(valor){
   				 $(".fat_endereco_cidade").html(valor);
   			}
   		);
   	}
   	
   	function fat_getBairro() {
   		var id = $('#fat_endereco_cidade').val();
   		$(".fat_endereco_bairro").append('<option value="0">Carregando...</option>');
   		$.post("<? echo base_url('/'); ?>clientes/ajax/bairro/" + id,
   			{fat_endereco_bairro:jQuery(id).val()},
   			function(valor){
   				 $(".fat_endereco_bairro").html(valor);
   			}
   		);
   	}
</script>