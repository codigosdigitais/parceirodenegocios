<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/funcionarios/js/funcionarios.js"></script>
<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Funcionário";
	} 
	else
	{
		$tituloBase = "Cadastro de Funcionário"; 
	}
?>
<style>
.div-foto-funcionario-title {
	background-color: rgba(255, 255, 255, 0.7);
    border: 1px solid #ADADAD;
    position: absolute;
    left: 636px;
    width: 265px;
    height: 25px;
    z-index: 2;
    text-align: center;
    font-size: 14px;
}
.div-foto-funcionario {
	background-color: #EFEFEF;
    border: 1px solid #DFDFDF;
    position: absolute;
    left: 636px;
    width: 265px;
    height: 228px;
    overflow: hidden;
    text-align: center;
}
.div-foto-funcionario img {
	/*margin-top: 25px;*/
}
.div-foto-funcionario-bottom {
	background-color: rgba(255, 255, 255, 0.7);
    border: 1px solid #ADADAD;
    position: absolute;
    left: 636px;
    width: 263px;
    margin-top: 176px;
    height: 52px;
    z-index: 2;
    padding: 0;
    overflow: hidden;
    line-height: 10px;
    vertical-align: top;
    padding-left: 2px;
}
.div-foto-funcionario-bottom input{
	font-size: 12px;
	vertical-align: sub;
}
.div-foto-funcionario-bottom label {
	font-size: 12px;
	padding-left: 4px;
	text-align: left;
}
</style>
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
            	<form class="form-inline" method="post" action="<?php echo current_url(); ?>" accept-charset="utf-8" enctype="multipart/form-data">
            <?php 
                if($this->router->method=="editar"){
                    echo form_hidden('idFuncionario',$this->uri->segment(3));
                    $tituloInterno = "Editar Funcionário";
                    $iconeInterno = "icon-pencil";
                } else {
                    $tituloInterno = "Novo Funcionário";
                    $iconeInterno = "icon-title";
                }
            ?>
            
            <fieldset>
            
                <legend><i class="<?=$iconeInterno;?> icon-title"></i> <?=$tituloInterno;?></legend>
            
            	<div class="div-foto-funcionario-title">Foto do Profissional</div>
                <div class="div-foto-funcionario">
                	<?php 
                	$imagem_perfil = (isset($result[0]->imagem_perfil) && file_exists($result[0]->imagem_perfil)) ? base_url($result[0]->imagem_perfil) : false;
                	if ($imagem_perfil)
                		echo '<img src="'. $imagem_perfil .'">';
                	?>
                	
                </div>
                <div class="div-foto-funcionario-bottom">
                	<input id="arquivo" type="file" class="input-small" name="userfile" />
                	<br>
                	<input type="checkbox" id="remove_imagem" name="remove_imagem"><label for="remove_imagem">Remover imagem</label>
                </div>
                
                <div class="line">
                    <label class="control-label">Nome</label>
                    <input class="input-xlarge" style="width: 463px;"  type="text" placeholder="Nome Completo" name="blocobase_nome" id="blocobase_nome" value="<? if(isset($result[0]->nome)){ echo $result[0]->nome; } ?>" required <? if($this->router->method=="editar"){ ?> <? } else { ?>autofocus<? } ?>>
                </div>
                
                
                <div class="line">
                    <label class="control-label">Sexo</label>
                    <select class="input-medium" name="blocobase_sexo" style="width: 149px !important;" >
                        <option value="0" <? if(isset($result[0]->sexo)){ if($result[0]->sexo=='0'){ echo "selected"; } } ?>>MASCULINO</option>
                        <option value="1" <? if(isset($result[0]->sexo)){ if($result[0]->sexo=='1'){ echo "selected"; } } ?>>FEMININO</option>
                    </select>
                    	
                </div>
                
                <div class="line">
                    <label class="control-label">Data Nasc.</label>
                    <input id="dp1" class="input-small" style="width: 135px;" type="date" name="blocobase_datanascimento" value="<? if(isset($result[0]->datanascimento)){ echo $result[0]->datanascimento; } ?>" >
                    
                    <label class="control-label" style="width: 105px !important;">Escolaridade</label>
                    <select class="input-large" name="blocobase_escolaridade" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroEscolaridade'] as $listaEscolaridade){ ?>
                        <option value="<? echo $listaEscolaridade->idParametro;?>" <? if(isset($result[0]->escolaridade)){ if($result[0]->escolaridade==$listaEscolaridade->idParametro){ echo "selected"; } } ?>><? echo $listaEscolaridade->parametro;?></option>
                        <? } ?>
                    </select>
                </div>
                
                <div class="line">
                    <label class="control-label">Naturalidade</label>
                    <input class="input-xlarge" style="width: 198px !important;" type="text" placeholder="Naturalidade" name="blocobase_naturalidade" value="<? if(isset($result[0]->naturalidade)){ echo $result[0]->naturalidade; } ?>" >
                    
                    <label class="control-label" style="width: 80px !important;">Estado</label>
                    <select class="input-medium" name="blocobase_naturalidadeestado" style="width: 172px !important;">
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>"  <? if(isset($result[0]->naturalidadeestado)){ if($result[0]->naturalidadeestado==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>
                    </select>
                </div>	
                
                <div class="line">
                    <label class="control-label">Filiação: Pai</label>
                    <input class="input-xlarge" type="text" style="width: 463px !important;" placeholder="Nome do Pai" name="blocobase_nomedopai" value="<? if(isset($result[0]->nomedopai)){ echo $result[0]->nomedopai; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Mãe</label>
                    <input class="input-xlarge" type="text" style="width: 463px !important;" placeholder="Nome da Mãe" name="blocobase_nomedamae" value="<? if(isset($result[0]->nomedamae)){ echo $result[0]->nomedamae; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Estado Civil</label>
                    <select class="input-medium" name="blocobase_estadocivil" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroEstadoCivil'] as $listaEstadoCivil){ ?>
                        <option value="<? echo $listaEstadoCivil->idParametro;?>"  <? if(isset($result[0]->estadocivil)){ if($result[0]->estadocivil==$listaEstadoCivil->idParametro){ echo "selected"; } } ?>><? echo $listaEstadoCivil->parametro;?></option>
                        <? } ?>							
                    </select>
                    
                    <label class="control-label">Conjuge</label>
                    <input class="input-xlarge" type="text" style="width: 461px !important;" placeholder="Conjuge" name="blocobase_nomeconjuge" value="<? if(isset($result[0]->nomeconjuge)){ echo $result[0]->nomeconjuge; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Endereço</label>
                    <input class="input-large" type="text" placeholder="Endereço" name="blocobase_endereco" value="<? if(isset($result[0]->endereco)){ echo $result[0]->endereco; } ?>" >
                    
                    <label class="control-label">Número</label>
                    <input class="input-medium" type="text" placeholder="Número" name="blocobase_endereconumero" value="<? if(isset($result[0]->endereconumero)){ echo $result[0]->endereconumero; } ?>" >
                    
                    <label class="control-label">Complemento</label>
                    <input class="input-small" type="text" placeholder="Complemento" name="blocobase_enderecocomplemento" value="<? if(isset($result[0]->enderecocomplemento)){ echo $result[0]->enderecocomplemento; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Bairro</label>
                    <input class="input-small" type="text" placeholder="Bairro" name="blocobase_enderecobairro" value="<? if(isset($result[0]->enderecobairro)){ echo $result[0]->enderecobairro; } ?>" >
                    
                    <label class="control-label">CEP</label>
                    <input class="input-small" type="text" placeholder="CEP" name="blocobase_enderecocep" value="<? if(isset($result[0]->enderecocep)){ echo $result[0]->enderecocep; } ?>" >
                    
                    <label class="control-label" style="width: 75px !important;">Cidade</label>
                    <input class="input-small" type="text" placeholder="Cidade" name="blocobase_enderecocidade" value="<? if(isset($result[0]->enderecocidade)){ echo $result[0]->enderecocidade; } ?>" >
                    
                    <label class="control-label"  style="width: 70px !important;">Estado</label>
                    <select class="input-small" name="blocobase_enderecoestado"  style="width: 142px !important;">
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>" <? if(isset($result[0]->enderecoestado)){ if($result[0]->enderecoestado==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>							
                    </select>
                </div>
                
                <div class="line">
                    <label class="control-label">Telefone</label>
                    <input class="input-mini" type="text" placeholder="DDD" style="width: 30px !important;" name="blocobase_responsaveltelefoneddd" value="<? if(isset($result[0]->responsaveltelefoneddd)){ echo $result[0]->responsaveltelefoneddd; } ?>" >
                    <input class="input-small" type="text" placeholder="Telefone" name="blocobase_responsaveltelefone" value="<? if(isset($result[0]->responsaveltelefone)){ echo $result[0]->responsaveltelefone; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Celular</label>
                    <input class="input-mini" type="text" placeholder="DDD" style="width: 30px !important;" name="blocobase_responsavelcelularddd" value="<? if(isset($result[0]->responsavelcelularddd)){ echo $result[0]->responsavelcelularddd; } ?>" >
                    <input class="input-small" type="text" placeholder="Celular" name="blocobase_responsavelcelular" value="<? if(isset($result[0]->responsavelcelular)){ echo $result[0]->responsavelcelular; } ?>" >
                    
                    <label class="control-label" style="width: 74px !important;">Email Pes.</label>
                    <input class="input-medium" type="text" placeholder="Email Pessoal" style="width: 292px !important;" name="blocobase_email" value="<? if(isset($result[0]->email)){ echo $result[0]->email; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Telefone</label>
                    <input class="input-mini" type="text" placeholder="DDD" style="width: 30px !important;" name="blocobase_responsavelfinanceirotelefoneddd" value="<? if(isset($result[0]->responsavelfinanceirotelefoneddd)){ echo $result[0]->responsavelfinanceirotelefoneddd; } ?>" >
                    <input class="input-small" type="text" placeholder="Telefone" name="blocobase_responsavelfinanceirotelefone" value="<? if(isset($result[0]->responsavelfinanceirotelefone)){ echo $result[0]->responsavelfinanceirotelefone; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Celular</label>
                    <input class="input-mini" type="text" placeholder="DDD" style="width: 30px !important;" name="blocobase_responsavelfinanceirocelularddd" value="<? if(isset($result[0]->responsavelfinanceirocelularddd)){ echo $result[0]->responsavelfinanceirocelularddd; } ?>" >
                    <input class="input-small" type="text" placeholder="Celular" name="blocobase_responsavelfinanceirocelular" value="<? if(isset($result[0]->responsavelfinanceirocelular)){ echo $result[0]->responsavelfinanceirocelular; } ?>" >
                    
                    <label class="control-label" style="width: 74px !important;">Email Emp.</label>
                    <input class="input-medium" type="text" placeholder="Email Empresa" style="width: 292px !important;" name="blocobase_emailempresa" value="<? if(isset($result[0]->emailempresa)){ echo $result[0]->emailempresa; } ?>" >
                </div>
                
                
                <legend class="form-title"><i class="icon-list-alt icon-title"></i> Documentos</legend>
                
                <div class="line">
                    <label class="control-label">CTPS Nº</label>
                    <input class="input-medium" type="text" placeholder="CTPS Nº" name="blocodoc_ctpsnumero" value="<? if(isset($result[0]->ctpsnumero)){ echo $result[0]->ctpsnumero; } ?>" >
                    
                    <label class="control-label" style="width: 40px !important;">Série</label>
                    <input class="input-medium" type="text" placeholder="Série" style="width: 70px !important;" name="blocodoc_ctpsserie" value="<? if(isset($result[0]->ctpsserie)){ echo $result[0]->ctpsserie; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Estado</label>
                    <select class="input-small" name="blocodoc_ctpsestado"  style="width: 150px !important;">
                        <option value="0">Selecione</option>
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>"  <? if(isset($result[0]->ctpsestado)){ if($result[0]->ctpsestado==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>
                    </select>
                    
                    <label class="control-label" style="width: 85px !important;">Data de Emi.</label>
                    <input id="dp2" class="input-small" type="date" name="blocodoc_ctpsdata" value="<? if(isset($result[0]->ctpsdata)){ echo $result[0]->ctpsdata; } ?>"  style="width: 135px !important;">
                </div>
                
                <div class="line">
                    <label class="control-label">PIS</label>
                    <input class="input-medium" type="text" placeholder="PIS" style="width: 100px" name="blocodoc_pisnumero" value="<? if(isset($result[0]->pisnumero)){ echo $result[0]->pisnumero; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Org. Ex</label>
                    <input class="input-medium" type="text" placeholder="Org. Ex" style="width: 70px !important;" name="blocodoc_pisorgaoexpeditor" value="<? if(isset($result[0]->pisorgaoexpeditor)){ echo $result[0]->pisorgaoexpeditor; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Estado</label>
                    <select class="input-small" name="blocodoc_pisuf" style="width: 150px !important;">
                        <option value="0">Selecione</option>
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>"  <? if(isset($result[0]->pisuf)){ if($result[0]->pisuf==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>							
                    </select>
                    
                    <label class="control-label" style="width: 125px !important;">Data de Emi.</label>
                    <input id="dp3" class="input-small" type="date" name="blocodoc_pisdata" value="<? if(isset($result[0]->pisdata)){ echo $result[0]->pisdata; } ?>"   style="width: 135px !important;">
                </div>
                
                <div class="line">
                    <label class="control-label">RG</label>
                    <input class="input-medium" type="text" style="width: 96px" placeholder="RG" name="blocodoc_rg" value="<? if(isset($result[0]->rg)){ echo $result[0]->rg; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Org. Ex</label>
                    <input class="input-medium" type="text" placeholder="Org. Ex" style="width: 113px !important;" name="blocodoc_rgorgaoexpeditor" value="<? if(isset($result[0]->rgorgaoexpeditor)){ echo $result[0]->rgorgaoexpeditor; } ?>" >
                    
                    <label class="control-label" style="width: 50px !important;">Estado</label>
                    <select class="input-small" name="blocodoc_rguf" style="width: 150px !important;">
                        <option value="0">Selecione</option>
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>" <? if(isset($result[0]->rguf)){ if($result[0]->rguf==$listaEstado->idEstado){ echo "selected"; } } ?> ><? echo $listaEstado->estado;?></option>
                        <? } ?>							
                    </select>
                    
                    <label class="control-label" style="width: 85px !important;">Data de Emi.</label>
                    <input id="dp4" class="input-small" type="date" name="blocodoc_rgdata" value="<? if(isset($result[0]->rgdata)){ echo $result[0]->rgdata; } ?>"  style="width: 135px !important;">
                </div>
                
                <div class="line">
                    <label class="control-label">CPF</label>
                    <input class="input-medium" type="text" placeholder="CPF" name="blocodoc_cpfnumero" value="<? if(isset($result[0]->cpfnumero)){ echo $result[0]->cpfnumero; } ?>" >
                    
                    <label class="control-label" style="width: 35px !important;">CNH</label>
                    <input class="input-medium" type="text" placeholder="CNH" name="blocodoc_cnhnumero" value="<? if(isset($result[0]->cnhnumero)){ echo $result[0]->cnhnumero; } ?>" >
                                                
                    <label class="control-label" style="width: 69px !important;">Categoria</label>
                    <select class="input-small" style="width: 104px !important;" name="blocodoc_cnhcategoria" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroCNHCategoria'] as $listaCNH){ ?>
                        <option value="<? echo $listaCNH->idParametro;?>"  <? if(isset($result[0]->cnhcategoria)){ if($result[0]->cnhcategoria==$listaCNH->idParametro){ echo "selected"; } } ?>><? echo $listaCNH->parametro;?></option>
                        <? } ?>								
                    </select>
                    
                    <label class="control-label" style="width: 30px !important;">Val.</label>
                    <input id="dp5" class="input-small" type="date" name="blocodoc_cnhvalidade" value="<? if(isset($result[0]->cnhvalidade)){ echo $result[0]->cnhvalidade; } ?>"  style="width: 140px !important;">
                </div>
                
                <div class="line">
                    <label class="control-label">Título</label>
                    <input class="input-small" type="text" placeholder="Título" name="blocodoc_tituloeleitor" value="<? if(isset($result[0]->tituloeleitor)){ echo $result[0]->tituloeleitor; } ?>" >
                    
                    <label class="control-label" style="width: 35px !important;">Zona</label>
                    <input class="input-small" type="text" placeholder="Zona" name="blocodoc_titulozona" value="<? if(isset($result[0]->titulozona)){ echo $result[0]->titulozona; } ?>" >
                    
                    <label class="control-label" style="width: 44px !important;">Seção</label>
                    <input class="input-small" type="text" placeholder="Seção" style="width: 48px !important;" name="blocodoc_titulosecao" value="<? if(isset($result[0]->titulosecao)){ echo $result[0]->titulosecao; } ?>" >
                    
                    <label class="control-label" style="width: 68px !important;">Reservista</label>
                    <input class="input-small" type="text" placeholder="Reservista" name="blocodoc_reservista" value="<? if(isset($result[0]->reservista)){ echo $result[0]->reservista; } ?>" >
                    
                    <label class="control-label" style="width: 30px !important;">Cat.</label>
                    <input class="input-small" type="text" placeholder="Categoria" name="blocodoc_reservistacategoria" value="<? if(isset($result[0]->reservistacategoria)){ echo $result[0]->reservistacategoria; } ?>"  style="width: 142px !important;" >
                </div>
                
                <div class="line">
                    <label class="control-label">Cert. Tipo</label>
                    <select class="input-small" style="width: 104px !important;" name="blocodoc_certidaotipo" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroCertidaoTipo'] as $listaCertidaoTipo){ ?>
                        <option value="<? echo $listaCertidaoTipo->idParametro;?>" ><? echo $listaCertidaoTipo->parametro;?></option>
                        <? } ?>
                        
                    </select>
                    
                    <label class="control-label" style="width: 100px !important;">Data de Emi.</label>
                    <input id="dp6" class="input-small" type="date" name="blocodoc_certidaodata" value="<? if(isset($result[0]->certidaodata)){ echo $result[0]->certidaodata; } ?>" >
                    
                    <label class="control-label" style="width: 75px !important;">Termo</label>
                    <input class="input-small" type="text" placeholder="Termo" name="blocodoc_certidaotermo" value="<? if(isset($result[0]->certidaotermo)){ echo $result[0]->certidaotermo; } ?>" >
                    
                    <label class="control-label" style="width: 79px !important;">Livro</label>
                    <input class="input-small" type="text" placeholder="Livro" name="blocodoc_certidaolivro" value="<? if(isset($result[0]->certidaolivro)){ echo $result[0]->certidaolivro; } ?>"  style="width: 140px !important;" >
                </div>
                
                <div class="line">
                    <label class="control-label">Folha</label>
                    <input class="input-small" type="text" placeholder="Folha" name="blocodoc_certidaofolha" value="<? if(isset($result[0]->certidaofolha)){ echo $result[0]->certidaofolha; } ?>" >
                    
                    <label class="control-label" style="width: 85px !important;">Cartório</label>
                    <input class="input-small" type="text" placeholder="Cartório" name="blocodoc_certidaocartorio" value="<? if(isset($result[0]->certidaocartorio)){ echo $result[0]->certidaocartorio; } ?>" >
                    
                    <label class="control-label" style="width: 90px !important;">Município</label>
                    <input class="input-small" type="text" placeholder="Cartório" name="blocodoc_certidaomunicipio" value="<? if(isset($result[0]->certidaomunicipio)){ echo $result[0]->certidaomunicipio; } ?>" >
                    
                    <label class="control-label" style="width: 93px !important;">Estado</label>
                    <select class="input-small" name="blocodoc_certidaouf"   style="width: 140px !important;">
                        <option value="<? if(isset($result[0]->certidaouf)){ echo $result[0]->certidaouf; } ?>">Selecione</option>
                        <? foreach($this->data['estados'] as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>"  <? if(isset($result[0]->certidaouf)){ if($result[0]->certidaouf==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>
                    </select>
                </div>
                
                <legend class="form-title"><i class="icon-file icon-title"></i> Registro</legend>
                
                <div class="line">
                    <label class="control-label">Emp. Registro</label>
                    <select class="input-xxlarge" style="width: 758px !important;" id="blococon_empresaregistro" name="blococon_empresaregistro" >
                        <option value="0">Selecione</option>
                        
                        <? foreach($this->data['listaCedente'] as $listaCedente){ ?>
                        <option value="<? echo $listaCedente->idCedente; ?>" <? if(isset($result[0]->empresaregistro)){ if($result[0]->empresaregistro==$listaCedente->idCedente){ echo "selected"; } } ?>><? echo $listaCedente->razaosocial; ?></option>
                        <? } ?>
                        
                    </select>
                </div>
                
                <div class="line">
                    <label class="control-label">Tipo de Cont.</label>
                    <select class="input-medium" name="blococon_tipocontrato" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroContratoTipo'] as $listaContratoTipo){ ?>
                        <option value="<? echo $listaContratoTipo->idParametro;?>"  <? if(isset($result[0]->tipocontrato)){ if($result[0]->tipocontrato==$listaContratoTipo->idParametro){ echo "selected"; } } ?>><? echo $listaContratoTipo->parametro;?></option>
                        <? } ?>							
                    </select>
                    
                    <label class="control-label" style="width: 110px !important;">Função</label>
                    <select class="input-medium" name="blococon_funcao" >
                        <option value="0">Selecione</option>
                        <? foreach($this->data['parametroFuncao'] as $listaFuncao){ ?>
                        <option value="<? echo $listaFuncao->idParametro;?>" <? if(isset($result[0]->tipocontrato)){ if($result[0]->funcao==$listaFuncao->idParametro){ echo "selected"; } } ?>><? echo $listaFuncao->parametro;?></option>
                        <? } ?>							
                    </select>
                    
                    <label class="control-label" style="width: 170px !important;">Data de Admissão</label>
                    <input id="dp7" class="input-small" type="date" name="blococon_dataadmissao" value="<? if(isset($result[0]->dataadmissao)){ echo $result[0]->dataadmissao; } ?>"   style="width: 138px !important;">
                </div>
                
                
                <div class="line">
                    <label class="control-label">Carga Horária</label>
                    <input class="input-small" type="text" placeholder="Completa" name="blococon_cargahorariacompleta" value="<? if(isset($result[0]->cargahorariacompleta)){ echo $result[0]->cargahorariacompleta; } ?>" >
                    <input class="input-small" type="text" placeholder="Diária" name="blococon_cargahorariadiaria" value="<? if(isset($result[0]->cargahorariadiaria)){ echo $result[0]->cargahorariadiaria; } ?>" >
                    
                    <label class="control-label" style="width: 110px !important;" >Horista</label>
                    <select class="input-small" name="blococon_horista" >
                        <option value="0" <? if(isset($result[0]->horista)){ if($result[0]->horista=='0'){ echo "selected"; } } ?>>Não</option>
                        <option value="1" <? if(isset($result[0]->horista)){ if($result[0]->horista=='1'){ echo "selected"; } } ?>>Sim</option>
                    </select>
                    
                    <label class="control-label" style="width: 170px !important;">Data de Demissão</label>
                    <input id="dp7" class="input-small" type="date" name="blococon_datademissao" value="<? if(isset($result[0]->datademissao)){ echo $result[0]->datademissao; } ?>"   style="width: 138px !important;">
                </div>
                
                <div class="line">
                    <label class="control-label">Observações</label>
                    <input class="input-xxlarge" type="text" name="blococon_contratoobservacao" value="<? if(isset($result[0]->contratoobservacao)){ echo $result[0]->contratoobservacao; } ?>" >
                </div>
                <!---
                <legend class="form-title"><i class="icon-shopping-cart icon-title"></i> Dados do Contrato</legend>
                <? if($this->router->method=="adicionar" || empty($result[0]->dadosContrato)){ ?> 
                <div id="dadoscontrato">
                    <div class="line">
                        <label class="control-label"><strong>Emp. Trabalho</strong></label>
                        <select class="input-large" style="width: 475px !important;" id="localtrabalho" name="blocodcon_localtrabalho[]" >
                            <option value="0">Selecione</option>
                            <? foreach($this->data['listaCliente'] as $listaCliente){ ?>
                            <option value="<? echo $listaCliente->idCliente; ?>"><? echo $listaCliente->razaosocial; ?></option>
                            <? } ?>						
                        </select>
                        
                        <label class="control-label">Data Início</label>
                        <input id="dp8" class="input-small" type="date" name="blocodcon_localtrabalhodata[]" value=""  style="width: 135px !important;" >
                    </div>
                    
                    <div class="line">
                        <label class="control-label">Horários</label>
                        <input class="input-small" type="time" name="blocodcon_segundaasextadas[]" style="width: 70px !important;" value="" >
                        
                        <label class="control-label" style="width: 24px !important;">às</label>
                        <input class="input-small" type="time" name="blocodcon_segundaasextaas[]" style="width: 70px !important;"  value="" >
                        
                        <label class="control-label"  style="width: 44px !important;">Sáb</label>
                        <input class="input-small" type="time" name="blocodcon_sabadodas[]" style="width: 70px !important;" value="" >
                        
                        <label class="control-label" style="width: 24px !important;">às</label>
                        <input class="input-small" type="time" name="blocodcon_sabadoas[]" style="width: 70px !important;"  value="" >
                        <label class="control-label" style="width: 156px !important;">Data de Saída</label>
                        <input id="dp7" class="input-small" type="date" name="blocodcon_datademissao[]" value=""   style="width: 135px !important;">
                    </div>
                </div>
                <? } else { 
                ?>
                <div id="dadoscontrato">
                <?
                    $cont = 0;
                //print_r($result[0]); 
                    foreach($result[0]->dadosContrato as $dadosContrato){
                        $cont++;
            
                ?>
                <div id="dados_<?=$cont;?>">
                    <div class="line">
                        <label class="control-label"><strong>Emp. Trabalho</strong></label>
                        <select class="input-large" style="width: 475px !important;" id="localtrabalho" name="blocodcon_localtrabalho[]" >
                            <option value="0">Selecione</option>
                            <? foreach($this->data['listaCliente'] as $listaCliente){ ?>
                            <option value="<? echo $listaCliente->idCliente; ?>" <? if(isset($dadosContrato->localtrabalho)){ if($dadosContrato->localtrabalho==$listaCliente->idCliente){ echo "selected"; } } ?>><? echo $listaCliente->razaosocial; ?></option>
                            <? } ?>						
                        </select>
                        
                        <label class="control-label">Data Início</label>
                        <input id="dp8" class="input-small" type="date" name="blocodcon_localtrabalhodata[]" value="<? if(isset($dadosContrato->localtrabalhodata)){ echo $dadosContrato->localtrabalhodata; } ?>"  style="width: 135px !important;" >
                    </div>
                    
                    <div class="line">
                        <label class="control-label">Horários</label>
                        <input class="input-small" type="time" name="blocodcon_segundaasextadas[]" style="width: 70px !important;" value="<? if(isset($dadosContrato->segundaasextadas)){ echo $dadosContrato->segundaasextadas; } ?>" >
                        
                        <label class="control-label" style="width: 24px !important;">às</label>
                        <input class="input-small" type="time" name="blocodcon_segundaasextaas[]" style="width: 70px !important;"  value="<? if(isset($dadosContrato->segundaasextaas)){ echo $dadosContrato->segundaasextaas; } ?>" >
                        
                        <label class="control-label"  style="width: 44px !important;">Sáb</label>
                        <input class="input-small" type="time" name="blocodcon_sabadodas[]" style="width: 70px !important;" value="<? if(isset($dadosContrato->sabadodas)){ echo $dadosContrato->sabadodas; } ?>" >
                        
                        <label class="control-label" style="width: 24px !important;">às</label>
                        <input class="input-small" type="time" name="blocodcon_sabadoas[]" style="width: 70px !important;"  value="<? if(isset($dadosContrato->sabadoas)){ echo $dadosContrato->sabadoas; } ?>" >
                        <label class="control-label" style="width: 90px !important;">Dt de Saída</label>
                        <input id="dp7" class="input-small" type="date" name="blocodcon_datademissao[]" value="<? if(isset($dadosContrato->datademissao)){ echo $dadosContrato->datademissao; } ?>"   style="width: 135px !important;">
            <button class="btn" type="button" onclick="removerContrato(<?=$cont;?>)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                    </div>
            
                </div>
            
                <? }?>
                                        </div>
                <? } ?>
                
                
                
                <div class="button-form line">										    
                    <button class="btn" onclick="adicionarContrato()" type="button"><i class="icon-plus"></i> Adicionar Contrato</button>
                </div>
                
                --->
            
                
                <legend class="form-title"><i class="icon-shopping-cart icon-title"></i> Remuneração</legend>
                
                <div class="line">
                    <label class="control-label">Salário</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_salario" value="<? if(isset($result[0]->salario)){ echo $result[0]->salario; } ?>" >
                    
                    <label class="control-label">Periculosidade</label>
                    <select id="blocorem_periculosidade" name="blocorem_periculosidade" class="input-small">
                    	<option value="1" <? if(isset($result[0]->periculosidade)){ if($result[0]->periculosidade=='1'){ echo "selected"; } } ?>>Sim</option>
                        <option value="2" <? if(isset($result[0]->periculosidade)){ if($result[0]->periculosidade=='2'){ echo "selected"; } } ?>>Não</option>
                    </select> 
                    
                    <label class="control-label">Insalubridade</label>
                    <select id="blocorem_insalubridade" name="blocorem_insalubridade" class="input-small">
                    	<option value="1" <? if(isset($result[0]->insalubridade)){ if($result[0]->insalubridade=='1'){ echo "selected"; } } ?>>Não</option>
                    	<option value="2" <? if(isset($result[0]->insalubridade)){ if($result[0]->insalubridade=='2'){ echo "selected"; } } ?>>Baixo</option>
                        <option value="3" <? if(isset($result[0]->insalubridade)){ if($result[0]->insalubridade=='3'){ echo "selected"; } } ?>>Médio</option>
                        <option value="4" <? if(isset($result[0]->insalubridade)){ if($result[0]->insalubridade=='4'){ echo "selected"; } } ?>>Alto</option>
                    </select>                 
                    
                </div>
                <!----
                <div class="line">
                    <label class="control-label">Aux. Alimen.</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxilioalimentacao" value="<? if(isset($result[0]->auxilioalimentacao)){ echo $result[0]->auxilioalimentacao; } ?>" >
                    
                    <label class="control-label" style="width: 233px !important;">Aux. Comb.</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxiliocombustivel" value="<? if(isset($result[0]->auxiliocombustivel)){ echo $result[0]->auxiliocombustivel; } ?>" >
                    
                    <label class="control-label" style="width: 186px !important;">Aux. Manut.</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxiliomanutencao" value="<? if(isset($result[0]->auxiliomanutencao)){ echo $result[0]->auxiliomanutencao; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Aux. Aluguel</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxilioaluguel" value="<? if(isset($result[0]->auxilioaluguel)){ echo $result[0]->auxilioaluguel; } ?>" >
                    
                    <label class="control-label" style="width: 233px !important;">Aux. Extra</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxilioextra" value="<? if(isset($result[0]->auxilioextra)){ echo $result[0]->auxilioextra; } ?>" >
                    
                    <label class="control-label" style="width: 186px !important;">Aux. Família</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_auxiliofamilia" value="<? if(isset($result[0]->auxiliofamilia)){ echo $result[0]->auxiliofamilia; } ?>" >
                </div>
                
                <div class="line">
                    <label class="control-label">Periculosidade</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_periculosidade" value="<? if(isset($result[0]->periculosidade)){ echo $result[0]->periculosidade; } ?>" >
                    
                    <label class="control-label" style="width: 233px !important;">Valor Contrato</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_valorcontrato" value="<? if(isset($result[0]->valorcontrato)){ echo $result[0]->valorcontrato; } ?>" >
                    
                    <label class="control-label" style="width: 186px !important;">Adicional Tempo Serviço</label>
                    <input class="input-small right money" type="text" placeholder="0.00" name="blocorem_valoroutros" value="<? if(isset($result[0]->valoroutros)){ echo $result[0]->valoroutros; } ?>" >
                </div>
                --->
                <div class="line">
                    <label class="control-label">Agência</label>
                    <input class="input-small right" type="text" name="blocorem_bancoagencia" value="<? if(isset($result[0]->bancoagencia)){ echo $result[0]->bancoagencia; } ?>" >
                    
                    <label class="control-label" style="width: 60px !important;">Conta</label>
                    <input class="input-small right" type="text" name="blocorem_bancoconta" value="<? if(isset($result[0]->bancoconta)){ echo $result[0]->bancoconta; } ?>" >
                    
                    <label class="control-label" style="width: 80px !important;">Operacão</label>
                    <input class="input-small right" type="text" name="blocorem_bancooperacao" value="<? if(isset($result[0]->bancooperacao)){ echo $result[0]->bancooperacao; } ?>" >
                    
                    <label class="control-label" style="width: 69px !important;">Banco</label>
                    <select class="input-medium" name="blocorem_bancobanco"   style="width: 196px !important;">
                        <option value="0">Selecione</option>
                        
                        <? foreach($this->data['parametroBanco'] as $listaBanco){ ?>
                        <option value="<? echo $listaBanco->idParametro;?>" <? if(isset($result[0]->bancobanco)){ if($result[0]->bancobanco==$listaBanco->idParametro){ echo "selected"; } } ?> ><? echo $listaBanco->parametro;?></option>
                        <? } ?>
                        
                    </select>
                </div>
                
                <legend class="form-title"><i class="icon-road icon-title"></i> Dados dos Veículos</legend>
                
                <div>
                    <label class="control-label" style="width: 141px !important; text-align: left;">Marca</label>
                    <label class="control-label" style="width: 88px !important; text-align: left;">Modelo</label>
                    <label class="control-label" style="width: 88px !important; text-align: left;">Ano</label>
                    <label class="control-label" style="width: 86px !important; text-align: left;">Cor</label>
                    <label class="control-label" style="width: 85px !important; text-align: left;">Placa</label>
                    <label class="control-label" style="width: 88px !important; text-align: left;">Renavam</label>
                    <label class="control-label" style="width: 136px !important; text-align: left;">Situação</label>
                </div>
            
                
                <? 
                
                if($this->router->method=="adicionar" || empty($result[0]->veiculosLista)){ ?>
                <div id="veiculos">
                    <? for($i=0; $i<=1; $i++){ ?>
                        <div class="line" id="vei_<?=$i;?>">
                            <select class="input-medium" style="width: 146px !important;" name="veiculos_marca[]" >
                                <option value="0">Selecione</option>
                                <? foreach($this->data['parametroVeiculoMarca'] as $listaMarca){ ?>
                                <option value="<? echo $listaMarca->idParametro;?>" ><? echo $listaMarca->parametro;?></option>
                                <? } ?>
                            </select>
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_modelo[]" value="" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_ano[]" value=""  maxlength="4" onkeypress="return MascaraNumero(event);">
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_cor[]" value="" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_placa[]" value="" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_renavam[]" value="" >
                            <select class="input-medium" style="width: 214px !important;" name="veiculos_situacao[]" >
                                <option value="0">Selecione</option>
                                <? foreach($this->data['parametroVeiculoSituacao'] as $listaSituacao){ ?>
                                <option value="<? echo $listaSituacao->idParametro;?>" ><? echo $listaSituacao->parametro;?></option>
                                <? } ?>
                            </select>
                            
                            <button class="btn" type="button" onclick="removerVeiculo(<?=$i;?>)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                        </div>
                        <? } ?>
                </div>
                
                <? } else { ?>
                <div id="veiculos">
                        <?
                            $i=0;
                            foreach($result[0]->veiculosLista as $valor){
                                $i++;
                        ?>
                        <div class="line" id="vei_<?=$i;?>">
                            <select class="input-medium" style="width: 146px !important;" name="veiculos_marca[]" >
                                <option value="0">Selecione</option>
                                <? foreach($this->data['parametroVeiculoMarca'] as $listaMarca){ ?>
                                <option value="<? echo $listaMarca->idParametro;?>" <? if(isset($valor->marca)){ if($valor->marca==$listaMarca->idParametro){ echo "selected"; } } ?> ><? echo $listaMarca->parametro;?></option>
                                <? } ?>
                            </select>
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_modelo[]" value="<? if(isset($valor->modelo)){ echo $valor->modelo; } ?>" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_ano[]" value="<? if(isset($valor->ano)){ echo $valor->ano; } ?>"  maxlength="4" onkeypress="return MascaraNumero(event);">
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_cor[]" value="<? if(isset($valor->cor)){ echo $valor->cor; } ?>" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_placa[]" value="<? if(isset($valor->placa)){ echo $valor->placa; } ?>" >
                            <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_renavam[]" value="<? if(isset($valor->renavam)){ echo $valor->renavam; } ?>" >
                            <select class="input-medium" style="width: 214px !important;" name="veiculos_situacao[]" >
                                <option value="0">Selecione</option>
                                <? foreach($this->data['parametroVeiculoSituacao'] as $listaSituacao){ ?>
                                <option value="<? echo $listaSituacao->idParametro;?>" <? if(isset($valor->situacao)){ if($valor->situacao==$listaSituacao->idParametro){ echo "selected"; } } ?>><? echo $listaSituacao->parametro;?></option>
                                <? } ?>
                            </select>
                            
                            <button class="btn" type="button" onclick="removerVeiculo(<?=$i;?>)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                        </div>
                        <? } ?>
                </div>
                
                <? } ?>
                
                <div class="button-form line">										    
                    <button class="btn" onclick="adicionarVeiculo()" type="button"><i class="icon-plus"></i> Adicionar Veiculo</button>
                </div>
                
                <legend class="form-title"><i class="icon-wrench icon-title"></i> Materiais de Trabalho</legend>
                
                
                    <?
                        $a = 1;
                        $contador = 0;
                        foreach($this->data['parametroMateriaisTrabalho'] as $materiais){
                            
                            $data['listaMateriaisView'] = @$this->funcionario_model->getMateriais(@$result[0]->idFuncionario, @$materiais->idParametro);
                            $conta_material = @count($data['listaMateriaisView']);
                            
                            $a++;
                            if($contador==0){
                    ?>
                    <div class="line">		
                    <?
                            } $contador++;
                    ?>					
                            <label class="control-label" style="width: 200px !important;"><? echo $materiais->parametro;?></label>
                            <input type="hidden" name="materiais_material[]" value="<? echo $materiais->idParametro;?>">
                            <select class="input-small" style="width: 60px !important;" name="materiais_quantidade[]" >
                                <? for($i=0; $i<=10; $i++){ ?>
                                <option value="<?=$i;?>" <? if($conta_material){ if($data['listaMateriaisView']->quantidade==$i){ echo "selected"; } } ?>><?=$i;?></option>
                                <? } ?>
                            </select>
                            <input class="input-small" style="width: 135px"  type="date"  name="materiais_data[]" value="<? if($conta_material){ echo $data['listaMateriaisView']->data; } ?>" >
                            
                            
                        <? if($contador==2){ $contador = 0; ?>
                    </div>
                    <? } } ?>
            
                
            
                <div class="line"></div>
                                             
					<div class="line">
						<label class="control-label">Situação</label>
						<select class="input-small" style="width: 97px !important;" name="blocobase_situacao">
							<option value="1" <? if(isset($result[0]->situacao) && $result[0]->situacao) echo "selected"; ?>>Ativo</option>
							<option value="0" <? if(isset($result[0]->situacao) && !$result[0]->situacao) echo "selected"; ?>>Inativo</option>
						</select>
					</div>
							               
                <div class="button-form line">										    
                    <div class="span6 offset3" style="text-align: center">
                    <? if($this->router->method=="editar"){ ?>
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                    <? } else { ?>
                        <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                    <? } ?>
                    <a href="<?php echo base_url() ?>funcionario" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </fieldset>
            </form>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="countVei" value="2" >
<div id="modelo" style="display: none;">
    <div class="line" id="vei_COUNT">
        <select class="input-medium" style="width: 146px !important;" name="veiculos_marca[]" >
            <option value="0">Selecione</option>
                <? foreach($this->data['parametroVeiculoMarca'] as $listaMarca){ ?>
                <option value="<? echo $listaMarca->idParametro;?>" ><? echo $listaMarca->parametro;?></option>
                <? } ?>
        </select>
        <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_modelo[]" >
        <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_ano[]" maxlength="4" onkeypress="return MascaraNumero(event);" >
        <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_cor[]" >
        <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_placa[]" >
        <input class="input-small" type="text" style="width: 80px !important;" name="veiculos_renavam[]" >
        <select class="input-medium" style="width: 214px !important;" name="veiculos_situacao[]" >
            <option value="0">Selecione</option>
                <? foreach($this->data['parametroVeiculoSituacao'] as $listaSituacao){ ?>
                <option value="<? echo $listaSituacao->idParametro;?>" ><? echo $listaSituacao->parametro;?></option>
                <? } ?>
        </select>
        
        <button class="btn" type="button" onclick="removerVeiculo(COUNT)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
    </div>
</div>
<? if(empty($result[0]->dadosContrato)) $contador = 1; else $contador = count($result[0]->dadosContrato)+1; ?>
<input type="hidden" id="countContrato" value="<?=$contador;?>" >
<div id="dadoscontratoModelo" style="display: none; background-color: red">
    <div id="dados_COUNT">
        <div class="line">
            <label class="control-label"><strong>Emp. Trabalho</strong></label>
            <select class="input-large" style="width: 475px !important;" id="localtrabalho" name="blocodcon_localtrabalho[]" >
                <option value="0">Selecione</option>
                <? foreach($this->data['listaCliente'] as $listaCliente){ ?>
                <option value="<? echo $listaCliente->idCliente; ?>"><? echo $listaCliente->razaosocial; ?></option>
                <? } ?>						
            </select>
            
            <label class="control-label">Data Início</label>
            <input id="dp1_COUNT" class="input-small" type="date" name="blocodcon_localtrabalhodata[]" value=""  style="width: 135px !important;" >
        </div>
        
        <div class="line">
            <label class="control-label">Horários</label>
            <input class="input-small" type="time" name="blocodcon_segundaasextadas[]" style="width: 60px !important;" value="" >
            
            <label class="control-label" style="width: 24px !important;">às</label>
            <input class="input-small" type="time" name="blocodcon_segundaasextaas[]" style="width: 60px !important;"  value="" >
            
            <label class="control-label"  style="width: 84px !important;">aos Sábados</label>
            <input class="input-small" type="time" name="blocodcon_sabadodas[]" style="width: 60px !important;" value="" >
            
            <label class="control-label" style="width: 24px !important;">às</label>
            <input class="input-small" type="time" name="blocodcon_sabadoas[]" style="width: 60px !important;"  value="" >
            <label class="control-label" style="width: 90px !important;">Dt de Saída</label>
            <input id="dp2_COUNT" class="input-small" type="date" name="blocodcon_datademissao[]" value=""   style="width: 135px !important;">
            <button class="btn" type="button" onclick="removerContrato(COUNT)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
        </div>
        
    </div>
</div>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>

<script>

	maskNum('enderecocep');
	maskNum('responsaveltelefone_ddd');
	maskNum('responsaveltelefone');
	maskNum('responsavelcelularddd');
	maskNum('responsavelcelular');
	maskNum('responsaveltelefoneddd');
	maskNum('responsaveltelefone');
	maskNum('responsavelcelularddd');
	maskNum('responsavelcelular');
	maskNum('responsavelfinanceirotelefoneddd');
	maskNum('responsavelfinanceirotelefone');
	maskNum('responsavelfinanceirocelularddd');
	maskNum('responsavelfinanceirocelular');
	maskNum('bancoagencia');
	maskNum('bancoconta');
	maskNum('bancooperacao');
	maskNum('cargahorariacompleta');
	maskNum('cargahorariadiaria');
	
	maskVal('salario');
	maskVal('auxilioalimentacao');
	maskVal('auxiliocombustivel');
	maskVal('auxiliomanutencao');
	maskVal('auxilioaluguel');
	maskVal('auxilioextra');
	maskVal('auxiliofamilia');
	maskVal('periculosidade');
	maskVal('valorcontrato');
	maskVal('valoroutros');

	maskVal('valormotonormal');
	maskVal('valormotometropolitano');
	maskVal('valormotokm');
	maskVal('valormotodepois18');
	
	maskVal('valorvannormal');
	maskVal('valorvanmetropolitano');
	maskVal('valorvankm');
	maskVal('valorvandepois18');
	
	maskVal('valorcaminhaonormal');
	maskVal('valorcaminhaometropolitano');
	maskVal('valorcaminhaokm');
	maskVal('valorcaminhaodepois18');
	
	maskVal('valorcarronormal');
	maskVal('valorcarrometropolitano');
	maskVal('valorcarrokm');
	maskVal('valorcarrodepois18');
	
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

</script>