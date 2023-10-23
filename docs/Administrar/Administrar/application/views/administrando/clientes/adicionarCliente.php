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
		    <form class="form-inline" method="post" action="<?php echo current_url(); ?>">
				<?php 
                    if($this->router->method=="clientesEditar"){
                        echo form_hidden('idCliente',$result->idCliente);
						//$permissoes = unserialize($result->permissoes);
                    } 
                ?>
                
			    <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Cliente</legend>

					<div class="line">
						<label class="control-label">Razão Social</label>
						<input class="input-xxlarge" type="text" placeholder="Razão Social" name="razaosocial" value="<? if(isset($result->razaosocial)){ echo $result->razaosocial; } ;?>" onblur="copiarRazaoSocial()" <? if($this->router->method=="editar"){ echo ""; } else { echo "autofocus"; } ?> required="required">
					</div>				    	
					
					<div class="line">
						<label class="control-label">Nome Fantasia</label>
						<input class="input-xxlarge" type="text" placeholder="Nome Fantasia" name="nomefantasia" value="<? if(isset($result->nomefantasia)){ echo $result->nomefantasia; } ;?>" required="required">
					</div>
					
					<div class="line">
						<label class="control-label">CNPJ/CPF</label>
						<input class="input-medium" type="text" placeholder="CNPJ/CPF" name="cnpj" value="<? if(isset($result->cnpj)){ echo $result->cnpj; } ;?>" maxlength="14" required="required">
						
						<label class="control-label">Insc. Est.</label>
						<input class="input-medium" type="text" placeholder="Inscrição Estadual" name="ie" value="<? if(isset($result->ie)){ echo $result->ie; } ;?>">
						
						<label class="control-label">Insc. Mun.</label>
						<input class="input-medium" type="text" placeholder="Inscrição Municipal" name="im" value="<? if(isset($result->im)){ echo $result->im; } ;?>">
					</div>
					
					<div class="line">
						<label class="control-label">Endereço</label>
						<input class="input-large" type="text" placeholder="Endereço" name="endereco" style="width: 250px !important;" value="<? if(isset($result->endereco)){ echo $result->endereco; } ;?>">
						
						<label class="control-label" style="width: 80px !important;">Número</label>
						<input class="input-medium" type="text" placeholder="Número" name="endereco_numero"  style="width: 80px !important;" value="<? if(isset($result->endereco_numero)){ echo $result->endereco_numero; } ;?>">
						
						<label class="control-label">Complemento</label>
						<input class="input-small" type="text" placeholder="Complemento" name="endereco_complemento"  style="width: 158px !important;" value="<? if(isset($result->endereco_complemento)){ echo $result->endereco_complemento; } ;?>">
					</div>
					
					<div class="line">
						<label class="control-label">Bairro</label>
						<input class="input-small" type="text" placeholder="Bairro" name="endereco_bairro" style="width: 150px !important" value="<? if(isset($result->endereco_bairro)){ echo $result->endereco_bairro; } ;?>">
						
						<label class="control-label" style="width: 50px !important" >CEP</label>
						<input class="input-small" type="text" placeholder="CEP" maxlength="8" name="endereco_cep" value="<? if(isset($result->endereco_cep)){ echo $result->endereco_cep; } ;?>">
						
						<label class="control-label" style="width: 65px !important;">Cidade</label>
						<input class="input-small" type="text" placeholder="Cidade" name="endereco_cidade"  style="width: 150px !important"  value="<? if(isset($result->endereco_cidade)){ echo $result->endereco_cidade; } ;?>">
						
						<label class="control-label" style="width: 80px !important" >Estado</label>
						<select class="input-small" name="endereco_estado" >
							<?
                                foreach($this->data['estados'] as $estado){
                            ?>	
                            <option value="<?=$estado->idEstado?>"  <? if(isset($result->endereco_estado)){ if($estado->idEstado==$result->endereco_estado){ echo "selected"; } } ?> ><?=$estado->estado;?></option>
                            <? 
                                }
                            ?>
						</select>
					</div>
					
					<div class="line">
						<label class="control-label">Responsável</label>
						<input class="input-xxlarge" type="text" placeholder="Responsável" name="responsavel" value="<? if(isset($result->responsavel)){ echo $result->responsavel; } ;?>">
					</div>
					
					<div class="line">
						<label class="control-label">Telefone</label>
						<input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_telefone_ddd" value="<? if(isset($result->responsavel_telefone_ddd)){ echo $result->responsavel_telefone_ddd; } ;?>">
						<input class="input-small" type="text" placeholder="Telefone" maxlength="9" name="responsavel_telefone" value="<? if(isset($result->responsavel_telefone)){ echo $result->responsavel_telefone; } ;?>">
						
						<label class="control-label" style="width: 50px !important;">Celular</label>
						<input class="input-mini" type="text" placeholder="DDD" maxlength="2" style="width: 30px !important;" name="responsavel_celular_ddd" value="<? if(isset($result->responsavel_celular_ddd)){ echo $result->responsavel_celular_ddd; } ;?>">
						<input class="input-small" type="text" placeholder="Celular" maxlength="9" name="responsavel_celular" value="<? if(isset($result->responsavel_celular)){ echo $result->responsavel_celular; } ;?>">
						
						<label class="control-label" style="width: 40px !important;">Email</label>
						<input class="input-medium" type="text" placeholder="Email" style="width: 168px !important;" name="email" value="<? if(isset($result->email)){ echo $result->email; } ;?>" required="required">
						
						<label class="control-label" style="width: 40px !important;">Ativo</label>
						<input id="dp1" class="input-small" type="text" placeholder="DD/MM/YYYY" maxlength="10" name="data_ativo" value="<? if(isset($result->data_ativo)){ echo date('d/m/Y', strtotime($result->data_ativo)); } ;?>">
					</div>	
					
					<div class="line"></div>
					
					<div class="line">
						<label class="control-label">Situação</label>
						<select class="input-small" style="width: 97px !important;" name="situacao">
							<option value="1" <? if(isset($result->situacao) && $result->situacao) echo 'selected'; ?>>Ativo</option>
							<option value="0" <? if(isset($result->situacao) && !$result->situacao) echo 'selected'; ?>>Inativo</option>
						</select>
					</div>
									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->router->method=="clientesEditar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        
                        
                        <a href="<?php echo base_url('sis_libera_modulos') ?>" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
		    	</fieldset>
	    	</form>
			</div>
    </div>
</div>
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
</script>