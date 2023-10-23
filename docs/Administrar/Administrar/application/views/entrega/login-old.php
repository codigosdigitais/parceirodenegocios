<!DOCTYPE html>
<html lang="pt-br">
    
<head>
        <title>Login | Parceiro de Negócios</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/matrix-login.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.min.js"></script>
        
		<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">
    </head>
    <body>
        <div id="loginbox">            
            <form  class="form-vertical" id="formLogin" method="post" action="<?php echo base_url()?>entrega/verificarLogin">
            <input name="idEmpresa" type="hidden" value="<?php if (isset($idEmpresa)) echo $idEmpresa; else echo 148; ?>" required="required" />

                <div class="control-group normal_text"> <h3><img src="<?php echo base_url()?>assets/img/logo-home.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span>
                            <input id="login" name="login" type="text" placeholder="Usuário /Login" required />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                            <input name="senha" type="password" placeholder="Senha" required />
                        </div>
                    </div>
                </div>
                
                  <?php if($this->session->userdata('error')){?>
                        <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <?php echo $this->session->userdata('error');?>
                       </div>
                  <?php }?>
                
                <div class="form-actions" style="text-align: center">
                    <button class="btn btn-info btn-large"/> Logar</button>
                </div>
            </form>
       
        </div>

        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/validate.js"></script>

    </body>

</html>