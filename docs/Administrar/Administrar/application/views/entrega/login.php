<!doctype html>
<html lang="en">
    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/login-form'); ?>/fonts/icomoon/style.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/login-form'); ?>/css/owl.carousel.min.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/login-form'); ?>/css/bootstrap.min.css">

        <!-- Style -->
        <link rel="stylesheet" href="<?php echo base_url('assets/login-form'); ?>/css/style.css">

        <!-- Carrega Login -->
		<script src="<?php echo base_url()?>assets/login-page/js/index.js?2"></script>

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">

		<!-- Title -->
        <title>SIS | JC Entregas Rápidas</title>

        <style>
        	.login__signup { padding-top: 10px; color:red; font-size: 11px; }
        </style>
    </head>
    <body>
        <div class="d-lg-flex half">
            <div class="bg order-1 order-md-2" style="background-image: url('<?php echo base_url('assets/login-form'); ?>/images/bg_1.jpg');"></div>
            <div class="contents order-2 order-md-1">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7">
                            <h3>Login <strong>Sistema</strong></h3>
                            <p class="mb-4">Preencha seu login/senha para acesso ao sistema</p>
							    
							    <form  
							    	class="form-login" 
							    	id="formLogin" 
							    	method="post" 
							    	action="<?php echo base_url()?>entrega/verificarLoginAjax"
							    	>
							    	
							    	<input 
							    		name="idEmpresa" 
							    		type="hidden" 
							    		value="<?php if (isset($idEmpresa)) echo $idEmpresa; else echo 148; ?>" 
							    		required 
							    	/>

                                <div class="form-group first">
                                    <label for="login">Login</label>
                                    <input type="text" class="form-control" placeholder="Entre com seu login" id="login" name="login" autofocus>
                                </div>
                                
                                <div class="form-group last mb-3">
                                    <label for="senha">Senha</label>
                                    <input type="password" class="form-control" placeholder="Digite sua senha" id="senha" name="senha">
                                </div>
                                
                                <input 
                                	type="button" 
                                	onClick="realizaLogin()" 
                                	value="Entrar" 
                                	class="btn btn-block btn-primary login__submit"
                                >
                            	
                            	<div class="login__signup"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	  	<form 
	  		id="formSuccess" 
	  		method="post" 
	  		action="<?php echo base_url()?>entrega/encaminhaSistema"
	  	></form>

        <script src="<?php echo base_url('assets/login-form'); ?>/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo base_url('assets/login-form'); ?>/js/popper.min.js"></script>
        <script src="<?php echo base_url('assets/login-form'); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/login-form'); ?>/js/main.js"></script>
    </body>
</html>


