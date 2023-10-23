<!DOCTYPE html>
<html lang="en">
<head>
<title>Parceiro de Negócios - Sistema Jc Entregas | <?php echo date('Y'); ?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">
<script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/new-menu/styles.css" />
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" />

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
<script type="text/javascript" src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"/></script>
<script type="text/javascript" src="<?php echo base_url()?>js/global_functions.js?2"/></script>

<script>BASE_URL = '<?php echo base_url($this->uri->segment(1)); ?>'</script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/holerites/js/holerites.js"></script>

<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css" />

<style>
	/*.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}*/
</style>

</head>
<body>

<div id="header">
 <img src="<? echo base_url("assets/img/logo2.png"); ?>" style="padding: 10px">
</div>

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class="" style="color: #FFF;">
    	<a title="" href="#" style="color: #FFF;">
    	<span class="text">Empresa: <strong><? echo $this->session->userdata['razaosocial']; ?></strong></span>
    	</a>
    </li>
    
    <li class="" style="color: #FFF;">
    	<a title="" href="#" style="color: #FFF;"><i class="icon icon-user"></i>
    	<span class="text">Usuário: <strong><? echo $this->session->userdata['nome']; ?></strong></span>
    	</a>
    </li>
    
    <?php if (isset($this->session->userdata['nomeSimulacao'])) { ?>
    <li class="" style="color: #FFF;">
    	<a title="" href="#" style="color: #FFF;background-color: #5A9DD4;"><i class="icon icon-user"></i>
    	<span class="text">Simulando acesso de: <strong><? echo $this->session->userdata['nomeSimulacao']; ?></strong></span>
    	</a>
    </li>
    <?php } ?>
    
    <?php if (isset($this->session->userdata['idPerfilSimular'])) { ?>
    <li class="" style="color: #FFF;">
    	<a title="" href="#" style="color: #FFF;background-color: #5A9DD4;"><i class="icon icon-user"></i>
    	<span class="text">Simulando Perfil: <strong><? echo $this->session->userdata['nomePerfilSimular']; ?></strong></span>
    	</a>
    </li>
    <?php } ?>
    
    <?php 
     if($this->permission->getIdPerfilAtual()) {
    ?>
    <li class="" style="color: #FFF;">
    	<a title="" href="#" style="color: #FFF;"><i class="icon icon-lock"></i>
    	<span class="text">Perfil: <strong><? echo $this->permission->getNomePerfilAtual(); ?></strong></span>
    	</a>
    </li>
    <?php } ?>
    
    <li class="last">
    	<a title="" href="<?php echo base_url();?>entrega/sair"><i class="icon icon-remove"></i>
    	<span class="text" style="color: #FFF">Sair do Sistema</span>
    	</a>
    </li>
  </ul>
</div>

<!--sidebar-menu-->

	<div id="sidebar">
		<div id='cssmenu'>
		<ul>
		   <li><a href='<?php echo base_url(); ?>'><i class="icon icon-home"></i> Início</a></li>
           <?
            $Permissoes = $this->session->userdata('permissoes');
            
            if ($Permissoes) {
	            $perfilAtual = ""; $perfilFirst = true;
	            $moduloAtual = ""; $moduloFirst = true;
	            
				foreach($Permissoes as $P){
					if ($P->canSelect && $P->visivel) {
						if ($perfilAtual != $P->nomePerfil) {
							$moduloFirst = true;
	
							$classAtualPerfil = (
									isset($this->data['menuActive']) &&
									$this->data['menuActive'][0] == $P->idPerfil
									|| (isset($this->data['menuActive']) && !$this->data['menuActive'][0] && $perfilFirst)
									) ? 'active' : '';
							
							if (!$perfilFirst) echo "</ul></li></ul></li>"; $perfilFirst = false;
							
							echo '<li class="has-sub '.$classAtualPerfil.'">';
		            		echo '<a href="#"><i class="icon icon-list"></i> <span><b>'.$P->nomePerfil.'</b></span></a>';
		            		echo '<ul>';
		            		
		            		$perfilAtual = $P->nomePerfil;
						}
						
						if ($moduloAtual != $P->nomeModulo) {
							
							if (!$moduloFirst) echo "</ul></li>"; $moduloFirst = false;
							
							echo '<li class="has-sub">';
							echo '<a href="#"><i class="icon icon-th-large"></i><span> '. $P->nomeModulo .'</span></a>';
							echo '<ul>';
							
							$moduloAtual = $P->nomeModulo;
						}
						$classAtualFuncao = ( 
									isset($this->data['menuActive']) &&
									$this->data['menuActive'][0] == $P->idPerfil &&
									$this->data['menuActive'][1] == $P->controller
								) ? 'active' : '';
						
						echo "<li class='".$classAtualFuncao."'>";
						echo "<a href='". base_url($P->idPerfil ."/". $P->controller) ."'><i class='icon icon-forward'></i> <span>". $P->nomeFuncao ."</span></a>";
						echo "</li>";
					}
	            }
	            echo "</ul></li>";
	            echo "</ul></li>";
            }
           	?>
			</ul>
			<?php //var_dump($this->data['menuActive']); ?>
		</div>
	</div>
   
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i> Início</a> 
    
    <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().''.$this->uri->segment(1).'/'.$this->uri->segment(2) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>">
    <?php echo ucfirst($this->uri->segment(2));} ?></a>
     
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
          			<?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php if(isset($view)){echo $this->load->view($view);}?>


        </div>
      </div>
    </div>
  </div>
</div>

<div class="row-fluid">
  <div id="footer" class="span12" style="color: #666"> <?php echo date('Y'); ?> &copy; Parceiro de Negócios - Desenvolvido por <b>Códigos Digitais - Agência Digital</b></div>
</div>



<?php 
	$idPerfilURL = ( is_numeric($this->uri->segment(1)) ? $this->uri->segment(1) : '' );
?>
<input type="hidden" id="idPerfilURL" value="<?php echo $idPerfilURL; ?>">
</body>
</html>