
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Contrato";
	} 
	else
	{
		$tituloBase = "Cadastro de Contrato"; 
	}

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Cadastro de Contratos</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>

        <a href="<?php echo base_url();?>contratos" class="btn btn-primary"><i class="icon-plus icon-white"></i> Listar Contratos</a>

        <a href="<?php echo base_url();?>relatorios/contratos" class="btn btn-danger" style="width: 125px;"><i class="icon-check icon-white"></i> Relatório</a>

    <?php } ?>
    </ol>
</nav>


            
		    <form class="form-inline" method="post" action="<?php echo current_url(); ?>" name="formularioContrato">
				<?php 
                    if($this->router->method=="editar"){
                        echo form_hidden('idContrato',$result[0]->idContrato);
                    } 
                ?>
                
                
                
		    	<fieldset>
		    		
	    				<legend><i class="icon-plus icon-title"></i> <? if($this->router->method=="editar"){ echo "Editar"; } else { echo "Novo"; } ?> Contrato</legend>
	    			
	    			

					<div class="line">
						<label class="control-label">Cliente</label> 
						<select class="input-xxlarge" style="width: 758px !important;" id="idCliente" name="idCliente" autofocus>
								<?
									foreach($this->data['listaCliente'] as $cliente){
								?>
								<option value="<? echo $cliente->idCliente; ?>" <? if(isset($result[0]->idCliente)){ if($result[0]->idCliente==$cliente->idCliente){ echo "selected"; } } ?> ><? echo $cliente->razaosocial; ?></option>
								<?
									}
								?>
							
						</select>
					</div>
					
					<div class="line">
						<label class="control-label">Cedente</label>
						<select class="input-xxlarge" style="width: 758px !important;" id="idCedente" name="idCedente">
							
								<?
									foreach($this->data['listaCedente'] as $cedente){
								?>
								<option value="<? echo $cedente->idCedente; ?>" <? if(isset($result[0]->idCedente)){ if($result[0]->idCedente==$cedente->idCedente){ echo "selected"; } } ?>><? echo $cedente->razaosocial; ?></option>
								<?
									}
								?>
							
						</select>
					</div>
					
					<div class="line">
						<label class="control-label">Forma Pgto.</label>
						<select class="input-medium" name="forma_de_pagamento">
							
								<? foreach($this->data['parametroFormaPagamento'] as $parametroFormaPagamento){ ?>
	        					<option value="<?=$parametroFormaPagamento->idParametro;?>" <? if(isset($result[0]->forma_de_pagamento)){ if($result[0]->forma_de_pagamento==$parametroFormaPagamento->idParametro){ echo "selected";  } } ?> ><?=$parametroFormaPagamento->parametro;?></option>
                                <? } ?>
	    					
						</select>
							
						<label class="control-label" style="width: 40px !important;">Nota</label>
						<select class="input-medium" style="width: 120px !important;" name="nota_fiscal">
							
								<?
									foreach($this->data['parametroNota'] as $parametroNota){ 
								?>
	        					<option value="<?=$parametroNota->idParametro;?>" <? if(isset($result[0]->nota_fiscal)){ if($result[0]->nota_fiscal==$parametroNota->idParametro){ echo "selected"; } } ?>><?=$parametroNota->parametro;?></option>
                                <? } ?>
	    					
						</select>
							
						<label class="control-label" style="width: 90px !important;">Fechamento</label>
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
						<label class="control-label" style="width: 90px !important;">Vencimento</label>
						<select class="input-medium" style="width: 80px !important;" name="vencimento">
							<? for($i=1; $i<=31; $i++){ ?>
	        					<option value="<?=$i;?>"  <? if(isset($result[0]->vencimento)){ if($result[0]->vencimento==$i){ echo "selected"; } } ?>><?=$i;?></option>
	    					<? } ?>
    					
						</select>
					</div>

					<div class="line">
						<label class="control-label">Guias</label>
						<select class="input-medium" style="width: 117px !important; "name="guias">
                            <option value="0" <? if(isset($result[0]->guias)){ if($result[0]->guias==0){ echo "selected"; } } ?> >Não</option>
                            <option value="1" <? if(isset($result[0]->guias)){ if($result[0]->guias==1){ echo "selected"; } } ?> >Sim</option>
						</select>
						
						<label class="control-label" style="width: 63px !important;">Ativo</label>
						<select class="input-medium" name="situacao" style="width: 70px !important;">
                            <option value="1" <? if(isset($result[0]->situacao)){ if($result[0]->situacao==1){ echo "selected"; } } ?> >Ativo</option>
                            <option value="0" <? if(isset($result[0]->situacao)){ if($result[0]->situacao==0){ echo "selected"; } } ?> >Inativo</option>	
                            <option value="2" <? if(isset($result[0]->situacao)){ if($result[0]->situacao==2){ echo "selected"; } } ?> >Bloqueado</option>
						</select>
                        
                        <label class="control-label" style="width: 85px !important;">Data Ativo</label>
                        <input class="input-small" name="dataativo" style="width: 135px !important; height: 20px;" type="date" value="<? if(isset($result[0]->dataativo)){ echo $result[0]->dataativo; } ?>">
                        
                        <label class="control-label" style="width: 85px !important;">Data Inativo</label>
                        <input class="input-small" name="datainativo" style="width: 135px !important; height: 20px;" type="date" value="<? if(isset($result[0]->datainativo)){ echo $result[0]->datainativo; } ?>">
					</div>

					<div class="line">
                        <label class="control-label">Renovação</label>
                        <input class="input-small" name="renovacao" style="width: 135px !important; height: 20px;" type="date" value="<? if(isset($result[0]->renovacao)){ echo $result[0]->renovacao; } ?>">						
					</div>
					
					<div class="line-fill-height" style="margin-bottom: 20px;">
						<label class="control-label">Observações</label>
						<textarea name="observacoes" class="input-xxlarge" style="height: 90px; width: 744px;"><? if(isset($result[0]->observacoes)){ echo $result[0]->observacoes; } ?></textarea>
					</div>
						
					<legend class="form-title"><i class="icon-group icon-title"></i> Funcionários</legend>

					<div id="funcs">
                    	<?
						//	echo count($result[0]->funcionarioLista);
							
							if(isset($result[0]->funcionarioLista)){
								
								$contador = 1;
								foreach($result[0]->funcionarioLista as $valor){
									$contador++; 
						?>
                            <div class="line_conteudo" id="func_<?=$contador;?>">
							
								<div class="line-fill-height" style="margin-bottom: 20px;">
									<label class="control-label">Funcionário</label>
                                    <select class="input-xxlarge"  style="width:758px"  name="func_idFuncionario[]">
                                        <option value="0">Selecione o Funcionário</option>
                                            <? foreach($this->data['listaFuncionario'] as $funcionario){?>
                                            <option value="<? echo $funcionario->idFuncionario; ?>" <? if(isset($valor->idFuncionario)){ if($valor->idFuncionario==$funcionario->idFuncionario){ echo "selected"; } } ?>><? echo $funcionario->nome; ?></option>
                                            <? } ?>
                                    </select>									
								</div>

								<div class="line-fill-height" style="margin-bottom: 20px;">
									<label class="control-label">Data Entrada</label>
									<input class="input-small" name="func_dataentrada[]" style="width: 135px !important; height: 20px;" type="date" value="<? if(isset($valor->dataentrada)){ echo $valor->dataentrada; } ?>">
                                
                                    <label class="control-label" style="width: 85px !important;">Data Saída</label>
                                    <input class="input-small" name="func_datasaida[]" style="width: 135px !important; height: 20px;" type="date" value="<? if(isset($valor->datasaida)){ echo $valor->datasaida; } ?>">	

									<label class="control-label" style="width: 80px !important">Valor Emp</label>
									<input class="input-small right money" name="func_valor[]" style="width: 70px !important; height: 20px;" type="text" placeholder="Valor Empresa" value="<? echo $valor->valor; ?>" >
                                
                                    <label class="control-label" style="width: 85px !important;">Valor Func</label>
                                    <input class="input-small right money" name="func_valorfunc[]" style="width: 73px !important; height: 20px;" type="text" placeholder="Valor Funcionário" value="<? if(isset($valor->valorfunc)){  echo $valor->valorfunc; } ?>" >
								</div>

								<div class="line-fill-height" style="margin-bottom: 20px;">
									<label class="control-label">Horários / Manhã</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentrada[]" value="<?=$valor->horaentrada;?>">
                                
                                    <label class="control-label" style="width: 24px !important;">às</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horasaida[]" value="<?=$valor->horasaida;?>">
                                    
                                    <label class="control-label" style="width: 70px !important">Tarde</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradatarde[]" value="<?=$valor->horaentradatarde;?>">
                                
                                    <label class="control-label" style="width: 24px !important;">às</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horasaidatarde[]" value="<?=$valor->horasaidatarde;?>"> 

									<label class="control-label" style="width: 130px !important;">Km Empresa</label>
                                    <input class="input-small" style="width: 109px !important; height: 20px;" type="number" name="func_kmempresa[]" value="<?=$valor->kmempresa;?>"> 
								</div>								
										                                
                                <div class="line">
                                
									<label class="control-label">Manhã Sábado</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradamanhasabado[]" value="<?=$valor->horaentradamanhasabado;?>">
                                
                                    <label class="control-label" style="width: 24px !important;">às</label>
                                    <input class="input-small hora" style="width: 75px !important; height: 20px;" type="time" name="func_horasaidamanhasabado[]" value="<?=$valor->horasaidamanhasabado;?>">	
                            
                        
                                    <label class="control-label" style="width: 65px !important">Sábado</label>
                                    <input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradasabado[]" value="<?=$valor->horaentradasabado;?>">
                                
                                    <label class="control-label" style="width: 24px !important;">às</label>
                                    <input class="input-small" style="width: 70px !important; height: 20px;" type="time" name="func_horasaidasabado[]" value="<?=$valor->horasaidasabado;?>">	

									<label class="control-label" style="width: 130px !important;">Km Funcionário</label>
                                    <input class="input-small" style="width: 73px !important; height: 20px;" type="number" name="func_kmfuncionario[]" value="<?=$valor->kmfuncionario;?>">
									<button class="btn" type="button" onclick="removerFuncionario(<?=$contador;?>)" style="padding: 3px; width: 32px !important; height: 30px;"><i class="icon-trash"></i></button>
                  
                                </div>		

								<hr>
                            </div>
							

                        <? 
								}
							} 
						?>
										
					</div>
					
					<div class="button-form line">										    
						<button class="btn" onclick="adicionarFuncionario()" type="button"><i class="icon-plus"></i> Adicionar Funcionario</button>
					</div>
									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->router->method=="editar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>contratos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
		    	</fieldset>
	    	</form>

	<input type="hidden" id="countFunc" value="0" >
		
	<div id="modelo" style="display: none; border-bottom: 1px solid #CCC !important">
		<div class="modelo_contrato" id="func_COUNT">
		


			<div class="line-fill-height" style="margin-bottom: 20px;">
				<label class="control-label">Funcionário</label>
				<select class="input-xxlarge"  style="width:758px"  name="func_idFuncionario[]">
					<option value="0">Selecione o Funcionário</option>
						<? foreach($this->data['listaFuncionario'] as $funcionario){?>
						<option value="<? echo $funcionario->idFuncionario; ?>"><? echo $funcionario->nome; ?></option>
						<? } ?>
				</select>									
			</div>

			<div class="line-fill-height" style="margin-bottom: 20px;">
				<label class="control-label">Data Entrada</label>
				<input class="input-small" name="func_dataentrada[]" style="width: 135px !important; height: 20px;" type="date" value="">
			
				<label class="control-label" style="width: 85px !important;">Data Saída</label>
				<input class="input-small" name="func_datasaida[]" style="width: 135px !important; height: 20px;" type="date" value="">	

				<label class="control-label" style="width: 80px !important">Valor Emp</label>
				<input class="input-small right money" name="func_valor[]" style="width: 70px !important; height: 20px;" type="text" placeholder="Valor Empresa" value="" >
			
				<label class="control-label" style="width: 85px !important;">Valor Func</label>
				<input class="input-small right money" name="func_valorfunc[]" style="width: 73px !important; height: 20px;" type="text" placeholder="Valor Funcionário" value="" >
			</div>

			<div class="line-fill-height" style="margin-bottom: 20px;">
				<label class="control-label">Horários / Manhã</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentrada[]" value="">
			
				<label class="control-label" style="width: 24px !important;">às</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horasaida[]" value="">
				
				<label class="control-label" style="width: 70px !important">Tarde</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradatarde[]" value="">
			
				<label class="control-label" style="width: 24px !important;">às</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horasaidatarde[]" value=""> 

				<label class="control-label" style="width: 130px !important;">Km Empresa</label>
				<input class="input-small" style="width: 109px !important; height: 20px;" type="number" name="func_kmempresa[]" value=""> 
			</div>								
													
			<div class="line">
			
				<label class="control-label">Manhã Sábado</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradamanhasabado[]" value="">
			
				<label class="control-label" style="width: 24px !important;">às</label>
				<input class="input-small hora" style="width: 75px !important; height: 20px;" type="time" name="func_horasaidamanhasabado[]" value="">	
		

				<label class="control-label" style="width: 65px !important">Sábado</label>
				<input class="input-small hora" style="width: 70px !important; height: 20px;" type="time" name="func_horaentradasabado[]" value="">
			
				<label class="control-label" style="width: 24px !important;">às</label>
				<input class="input-small" style="width: 70px !important; height: 20px;" type="time" name="func_horasaidasabado[]" value="">	

				<label class="control-label" style="width: 130px !important;">Km Funcionário</label>
				<input class="input-small" style="width: 73px !important; height: 20px;" type="number" name="func_kmfuncionario[]" value="">
				<button class="btn" type="button" onclick="removerFuncionario(COUNT)" style="padding: 3px; width: 32px !important; height: 30px;"><i class="icon-trash"></i></button>

			</div>				
			<hr>
		</div>	
	</div>


<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script>
	$(document).ready(function(){
		$(".money").maskMoney();
			$('#formularioContrato').validate({
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