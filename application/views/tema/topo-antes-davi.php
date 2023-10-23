<!DOCTYPE html>
<html lang="en">
<head>
<title>Entregas Rápidas - Controller</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/notify.min.js"></script>

<link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico">

<!-- new layout and improvements -->
<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css?1" />

</head>
<body>

<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
</style>

<!--Header-part-->
<div id="header">
  <h1><a href="">Entregas Rápidas - Controller</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="<?php echo base_url();?>entrega/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
    <li class="" style="color: #FFF;"><a title="" href="#" style="color: #FFF;"><i class="icon icon-share-alt"></i> <span class="text">Empresa: <strong><? echo $this->session->userdata['empresa']; ?></strong></span></a></li>
    
    <li class="" style="color: #FFF;"><a title="" href="#" style="color: #FFF;"><i class="icon icon-share-alt"></i> <span class="text">Responsável: <strong><? echo $this->session->userdata['nome']; ?></strong></span></a></li>
        
  </ul>
</div>

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>
  
    <li class=""><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
        
        <?
			if($this->session->userdata('idCliente')==151){
		?>
        
        <li class="submenu open active">
            <a href="#"><i class="icon icon-list-alt"></i> <span>Administração</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
            <ul>
                <li>
                	<a href="<?php echo base_url()?>administrando/clientes"><i class="icon icon-group"></i> <span>Clientes</span></a>
                </li>
            </ul>
            <ul>
                <li>
                	<a href="<?php echo base_url()?>administrando/modulos"><i class="icon icon-group"></i> <span>Módulos</span></a>
                </li>
            </ul>
            <ul>
                <li>
                	<a href="<?php echo base_url()?>administrando/parametros"><i class="icon icon-group"></i> <span>Parâmetros</span></a>
                </li>
            </ul>
            
            <ul>
                <li>
                	<a href="<?php echo base_url()?>entrega/backup"><i class="icon icon-group"></i> <span>Backup SQL</span></a>
                </li>
            </ul>
        </li>
		<? } else { ?>
        <?
			foreach($modulosBase as $modulo){ 
				if($this->permission->checkPermission($this->session->userdata('permissao'),$modulo->pasta)){
		?>
        <li class="submenu <?php if(isset($menu) and $menu==$modulo->pasta) echo 'open active'; ?>">
            <a href="#"><i class="icon icon-list-alt"></i> <span><? echo $modulo->modulo; ?></span> <span class="label"><i class="icon-chevron-down"></i></span></a>

            <?
			foreach($modulo->subModulo as $submodulo){
				$prefixo = substr($modulo->pasta, 0, 3);
				$permissao = $prefixo."_a".ucfirst($submodulo->pasta);
				if($this->permission->checkPermission($this->session->userdata('permissao'),$permissao)){
					if($modulo->pasta=='financeiro') $sublink = "financeiro/"; else $sublink = "";
			?>
            <ul>
                <li>
                	<a href="<?php echo base_url($sublink."".$submodulo->pasta)?>"><i class="icon icon-group"></i> <span><?=$submodulo->modulo;?></span></a>
                </li>
            </ul>
            <? } } ?>
        </li>
        
        <? 
			} }
		?>
		
        <!-- PROVISÓRIO -->
		<li class="submenu">
            <a href="#"><i class="icon icon-list-alt"></i> <span>Tabela de Fretes</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
	          <ul>
	          	<li><a href="<?php echo base_url();?>tabelafretecliente"><i class="icon icon-group"></i> <span>Tab. Cliente</span></a></li>
	          	<li><a href="<?php echo base_url();?>tabelafretefuncionario"><i class="icon icon-group"></i> <span>Tab. Funcionário</span></a></li>
	          </ul>
        </li>
        <? } ?>
    
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <?php if($this->uri->segment(1) != null){?><a href="<?php echo base_url().''.$this->uri->segment(1)?>" class="tip-bottom" title="<?php echo ucfirst($this->uri->segment(1));?>"><?php echo ucfirst($this->uri->segment(1));?></a> <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().''.$this->uri->segment(1).'/'.$this->uri->segment(2) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> <?php }?></div>
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
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2015 &copy;- PixxCriativa | Entregas Rápidas - Controller</div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>