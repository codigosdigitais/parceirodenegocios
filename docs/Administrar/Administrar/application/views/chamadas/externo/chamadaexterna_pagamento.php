<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>:: Pagamento Parceiro de Negócios</title>
	<meta charset="utf-8">
</head>

<body>

	<link href='https://fonts.googleapis.com/css?family=Merriweather+Sans|Raleway' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Signika:400,300,600,700" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/chamadas/css/chamadaexterna_integracao.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/controllers/chamadas/css/chamadaexterna_integracao_148.css" />	

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


	<!-- Vendor libraries -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<div class="container">
	    <div class="row">
	        <div class="col-xs-12 col-md-12"> 

	            <div class="panel panel-default credit-card-box">
	                <div class="panel-body div-chamada-page">
	                    <form id="paymentForm" method="POST" action="<?php echo base_url('chamadaexterna/paymentprocess'); ?>">
	                    	<div class="row">
	                    		<!--
	                    		<div class="col-xs-12">
	                    			<img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
	                    			<hr>
	                    		</div>-->
	                    	</div>

	                    	<div class="row">
	                    		<table class="table table-bordered table-striped">
	                    			<tr>
	                    				<th colspan="5">Respostas a Tentativas</th>
	                    			</tr>
	                    			<tr>
	                    				<th>Chamada</th>
	                    				<th>Data</th>
	                    				<th>Bandeira</th>
	                    				<th>Cartão</th>
	                    				<th>Mensagem</th>
	                    			</tr>
	                    			<?php if($pagamento){ ?>
	                    			<?php foreach($pagamento as $pgto){ ?>
	                    			<tr>
	                    				<td><?php echo $pgto->idChamada; ?></td>
	                    				<td><?php echo date("d/m - h:i", strtotime($pgto->dateOfPayment)); ?></td>
	                    				<td><?php echo strtoupper($pgto->paymentMethodId); ?></td>
	                    				<td><?php echo substr_replace($pgto->cardNumber, ' **** **** ', 4, 8); ?></td>
	                    				<td width="50%"><?php echo $pgto->statusDetail; ?></td>
	                    			</tr>
	                    			<?php } ?>
	                    			<?php } else { ?>
	                    				<tr>
	                    					<td colspan="5">Nenhuma tentativa registrada.</td>
	                    				</tr>
	                    			<?php } ?>
	                    		</table>
	                    	</div>

	                    	<?php
	                    		if($detalhes->statusPayment==1){
	                    	?>
	                    	<div class="row">
	                    		<h3>
	                    			<center>
	                    				<hr>
	                    				Seu pagamento foi processado com sucesso. <br>Nossa equipe entrará em contato!
	                    			</center>
	                    		</h3>
	                    	</div>
	                    	<?php } else { ?>

	                        <div class="row">
	                            <div class="col-xs-6 col-md-2">
	                                <div class="form-group">
	                                    <label for="chamada-idChamada"><span class="hidden-xs">Chamada</span><span class="visible-xs-inline">Cham.</span></label>
										<input 
	                                        type="text"
	                                        class="form-control"
	                                        name="chamada-idChamada"
	                                        readonly=""
	                                        value="<?php echo $detalhes->idChamada; ?>"
	                                    /> 
	                                </div>
	                            </div>
	                            <div class="col-xs-6 col-md-3">
	                                <div class="form-group">
	                                    <label for="chamada-data"><span class="hidden-xs">Data</span><span class="visible-xs-inline">Dt.</span></label>
										<input 
	                                        type="text"
	                                        class="form-control"
	                                        name="chamada-data"
	                                        readonly=""
	                                        value="<?php echo date("d/m/Y", strtotime($detalhes->data))." ".$detalhes->hora; ?>"
	                                    /> 
	                                </div>
	                            </div>
	                            <div class="col-xs-8 col-md-5 pull-right">
	                                <div class="form-group">
	                                    <label for="cliente-nome">Cliente</label>
										<input 
	                                        type="text"
	                                        class="form-control"
	                                        name="cardholderName"
	                                        data-checkout="cardholderName"
	                                        value="<?php echo $detalhes->idCliente; ?>"
	                                    />
	                                </div>
	                            </div>
	                            <div class="col-xs-4 col-md-2">
	                                <div class="form-group">
	                                    <label for="chamada-valor"><span class="hidden-xs">Valor</span><span class="visible-xs-inline">Vl.</span></label>
										<input 
	                                        type="text"
	                                        class="form-control"
	                                        name="chamada-valor"
	                                        readonly=""
	                                        value="R$ <?php echo number_format($detalhes->valor_empresa, 2, ',', '.'); ?>"
	                                    /> 
	                                </div>
	                            </div>                            
	                        </div>


	                        <div class="row">
	                            <div class="col-xs-12 col-md-5">
	                                <div class="form-group">
	                                    <label for="email">E-mail</label>
	                                    <input 
	                                    	id="email" 
	                                    	name="email" 
	                                    	type="text" 
	                                    	value="<?php echo $detalhes->email; ?>" 
	                                    	class="form-control"
	                                    	readonly="" 
	                                    >
	                                </div>
	                            </div>

	                            <div class="col-xs-8 col-md-7">
	                                <div class="form-group">
	                                    <label for="issuer">Documento Principal</label>
										<input 
											name="docNumberInput" 
											id="docNumberInput"
											data-checkout="docNumberInput" 
											type="text" 
											class="form-control"
											value="<?php echo $detalhes->cnpj; ?>"
											readonly=""
										/>
	                                </div>
	                            </div>                                                        	                        
	                        </div>	  
	                        <hr>
	                        <div class="row">
	                            <div class="col-xs-12 col-md-12">
	                                <div class="form-group">
	                                    <label for="cardNumber">Escolha o Tipo do Cartão</label>
	                                    <div class="input-group col-xs-12 col-md-12">
	                                        <select id="typeCard" name="typeCard" class="form-control">
	                                        	<option value="credito">Cartão de Crédito</option>
	                                        	<option value="debito">Cartão de Débito - MASTER/VISA</option>
	                                        </select>
	                                    </div>
	                                </div>                            
	                            </div>
	                        </div>	                        

	                        <div class="row">
	                            <div class="col-xs-12 col-md-12">
	                                <div class="form-group">
	                                    <label for="cardNumber">Número do Cartão</label>
	                                    <div class="input-group col-xs-12 col-md-12">
	                                        <input 
		                                        type="text" 
		                                        id="cardNumber" 
		                                        name="cardNumber"
		                                        data-checkout="cardNumber"
	           									onselectstart="return false" 
	           									onpaste="return false"
	          									oncopy="return false" 
	          									oncut="return false"
	           									ondrag="return false" 
	           									ondrop="return false" 
	           									autocomplete=off
	           									class="form-control cc-num"
	           									placeholder="•••• •••• •••• ••••"
           									>
	                                    </div>
	                                </div>                            
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-xs-6 col-md-2">
	                                <div class="form-group">
	                                    <label for="cardExpirationMonth"><span class="hidden-xs">Mês</span><span class="visible-xs-inline">Vcto.</span></label>
	                                    <select 
	                                    	name="cardExpirationMonth" 
	                                    	data-checkout="cardExpirationMonth" 
	                                    	class="form-control">

	                                    	<option value="1">01 - Janeiro</option>
	                                    	<option value="2">02 - Fevereiro</option>
	                                    	<option value="3">03 - Março</option>
	                                    	<option value="4">04 - Abril</option>
	                                    	<option value="5">05 - Maio</option>
	                                    	<option value="6">06 - Junho</option>
	                                    	<option value="7">07 - Julho</option>
	                                    	<option value="8">08 - Agosto</option>
	                                    	<option value="9">09 - Setembro</option>
	                                    	<option value="10">10 - Outubro</option>
	                                    	<option value="11">11 - Novembro</option>
	                                    	<option value="11">12 - Dezembro</option>

	                                    </select>	                                    
	                                </div>
	                            </div>
	                            <div class="col-xs-6 col-md-2">
	                                <div class="form-group">
	                                    <label for="cardExpirationYear"><span class="hidden-xs">Ano</span><span class="visible-xs-inline">Vcto.</span></label>
	                                    <select
	                                    	class="form-control cc-year" 
	                                        name="cardExpirationYear"
	                                        data-checkout="cardExpirationYear">

	                                    	<?php for($i=date("Y"); $i<=date("Y")+10; $i++){ ?>
	                                    	<option><?php echo $i; ?></option>
	                                    	<?php } ?>
	                                    
	                                    </select>
                                    
	                                </div>
	                            </div>	                            
	                            <div class="col-xs-3 col-md-2">
	                                <div class="form-group">
	                                    <label for="cardCVC">CVV</label>
										<input 
											id="securityCode" 
											name="securityCode"
											data-checkout="securityCode" 
											type="text"
											onselectstart="return false" 
											onpaste="return false"
											oncopy="return false" 
											oncut="return false"
											ondrag="return false"
											ondrop="return false" 
											autocomplete=off
											class="form-control"
											maxlength="4" 
										>
	                                </div>
	                            </div>
	                            <div class="col-xs-3 col-md-3">
	                                <div class="form-group">
	                                    <label for="issuer">Bandeira</label>
										<input 
											type="text" 
											id="issuer" 
											name="issuer" 
											data-checkout="issuer" 
											class="form-control"
											value="-"
											readonly="" 
										>
	                                </div>
	                            </div>
	                            <div class="col-xs-12 col-md-3">
	                                <div class="form-group">
	                                    <label for="installments">Parcelas</label>
										<select 
											type="text" 
											id="installments" 
											name="installments" 
											class="form-control"
										></select>
	                                </div>
	                            </div>
	                        </div>

							<select 
								id="docType" 
								name="docType" 
								data-checkout="docType" 
								type="text" 
								class="form-control" 
								style="display: none">
									<option 
										value="<?php 
											if($detalhes->cnpj && 
											strlen($detalhes->cnpj)==11){ 
												echo "CPF";  
											} else { 
												echo "CNPJ"; 
											} 
											?>">
											<?php 
												if($detalhes->cnpj && 
												strlen($detalhes->cnpj)==11){ 
													echo "CPF";  
												} else { 
													echo "CNPJ"; 
												} ?>
									</option>
							</select>	                        

	                        
	                        <input type="hidden" name="docNumber" data-checkout="docNumber" id="docNumber" value="<?php echo $detalhes->cnpj; ?>">
							<input type="hidden" name="transactionAmount" id="transactionAmount" value="<?php echo str_replace(".", "", $detalhes->valor_empresa); ?>" />
							<input type="hidden" name="paymentMethodId" id="paymentMethodId" />
							<input type="hidden" name="description" id="description" />

	                        <div class="row">
	                            <div class="col-xs-12">
	                                <button class="div-login-cadastro btn btn-primary" type="submit" id="btn-pagamento">Enviar Pagamento</button>
	                            </div>
	                        </div>
	                    	<?php } ?>
	                    </form>
	                </div>
	            </div>            
	            
	        </div>
	    </div>
	</div>


</body>


	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

	<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
	<script src="<?php echo base_url('assets/mercadopago'); ?>/mercadopago.js"></script>


</html>