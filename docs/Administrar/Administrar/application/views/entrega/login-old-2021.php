<!DOCTYPE html>
<html lang="pt-br">
    
<head>

    <title>Login | Parceiro de Negócios</title><meta charset="UTF-8" />
    <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>assets/login-page/css/style.css">

	<script src="<?php echo base_url()?>assets/login-page/js/index.js?2"></script>
    
    
	<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">
</head>
<body>
    
	    <div class="cont">
		  <div class="demo">
			    <div class="login">
			      <div class="login__check"><img src="<?php echo base_url()?>assets/img/logo-home.png" alt="Logo" /></div>
			      <div class="login__form">
			      
				    <form  class="form-login" id="formLogin" method="post" action="<?php echo base_url()?>entrega/verificarLoginAjax">
				    <input name="idEmpresa" type="hidden" value="<?php if (isset($idEmpresa)) echo $idEmpresa; else echo 148; ?>" required />
				        <div class="login__row">
				          <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
				            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
				          </svg>
				          <input type="text" class="login__input" name="login" placeholder="Nome de usuário" autofocus />
				        </div>
				        <div class="login__row">
				          <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
				            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
				          </svg>
				          <input type="password" class="login__input" name="senha" placeholder="Senha"/>
				        </div>

				        <button type="button" onClick="realizaLogin()" class="login__submit">Acessar</button>
				        <p class="login__signup">
				        	Você não possui uma conta?
				        	&nbsp;
				        	<a>Contato</a>
				        </p>
					</form>
			      </div>
			    </div>
		    </div>
	  	</div>
	  	<form id="formSuccess" method="post" action="<?php echo base_url()?>entrega/encaminhaSistema">
		</form>
</body>
</html>