<!DOCTYPE html>
<html lang="en">
<head>
<title>Cadastro de Colaborador</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/new-menu/styles.css" />

<!-- Pego de outros arquivos, condensado aqui -->
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/chosen.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/sobreescrever/css/formularios.css" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/notify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/new-menu/script.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/sobreescrever/js/chosen.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.mask.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/geral.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/global_functions.js"/></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css" />

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/funcionarios/js/funcionarios.js"></script>

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
body {
	background-color: #fff;
	margin: 0;
	padding: 0;
}
.widget-box {
	margin: 0;
}
</style>
</head>
<body>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de Colaborador</h5>
            </div>
            <div class="widget-content">
            	<form class="form-inline" method="post" action="<?php echo base_url('funcionarioexterno/adicionar'); ?>" accept-charset="utf-8" enctype="multipart/form-data">
            
            <fieldset>
            
                <legend><i class="icon-title"></i> Dados pessoais</legend>
            
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
                        <? foreach($estados as $listaEstado){ ?>
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
                        <? foreach($estados as $listaEstado){ ?>
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
                
                <div class="line">
                    <label class="control-label">IMEI</label>
                    <input class="input-mini" type="text" placeholder="Imei" style="width: 150px !important;" name="blocobase_imei" value="<? if(isset($result[0]->imei)){ echo $result[0]->imei; } ?>" >
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
                        <? foreach($estados as $listaEstado){ ?>
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
                        <? foreach($estados as $listaEstado){ ?>
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
                        <? foreach($estados as $listaEstado){ ?>
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
                        <? foreach($estados as $listaEstado){ ?>
                        <option value="<? echo $listaEstado->idEstado;?>"  <? if(isset($result[0]->certidaouf)){ if($result[0]->certidaouf==$listaEstado->idEstado){ echo "selected"; } } ?>><? echo $listaEstado->estado;?></option>
                        <? } ?>
                    </select>
                </div>
                
							               
                <div class="button-form line">										    
                    <div class="span6 offset3" style="text-align: center">
                    <? if($this->router->method=="editar"){ ?>
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                    <? } else { ?>
                        <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                    <? } ?>
                    <a href="<?php echo base_url() ?>funcionarioexterno/novoformulario" class="btn">Novo Cadastro</a>
                    </div>
                </div>
            </fieldset>
            </form>
            </div>
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
</body>
</html>