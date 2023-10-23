
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

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">Entregas Rápidas - Controller</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo base_url();?>entrega/minhaConta"><i class="icon icon-star"></i> <span class="text">Minha Conta</span></a></li>
    <li class=""><a title="" href="<?php echo base_url();?>entrega/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<div id="search">
  <form action="<?php echo base_url()?>entrega/pesquisar">
    <input type="text" name="termo" placeholder="Pesquisar..."/>
    <button type="submit"  class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
    
  </form>
</div>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
    	
    	<!--- CADASTROS --->
        <li class="submenu <?php if(isset($menuCadastros)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Cadastros</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
				<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>clientes"><i class="icon icon-group"></i> <span>Clientes</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCedente')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>cedentes"><i class="icon icon-road"></i> <span>Cedentes</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vFornecedor')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>fornecedores"><i class="icon icon-headphones"></i> <span>Fornecedores</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vContrato')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>contratos"><i class="icon icon-book"></i> <span>Contratos</span></a>
                    </li>
                <?php } ?>    
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vFuncionario')){ ?>
                    <li><a href="<?php echo base_url()?>funcionario"><i class="icon icon-folder-open-alt"></i> <span>Funcionários</span></a></li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vDocumento')){ ?> 
                    <li>
                   		<a href="<?php echo base_url()?>documentos"><i class="icon icon-group"></i> <span>Documentos</span></a>
                    </li>
                <?php } ?> 
          </ul>
        </li>


    	<!--- LANCAMENTOS --->
        <li class="submenu <?php if(isset($menuLancamentos)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-play-circle"></i> <span>Lançamentos</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
				<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aChamada')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>chamadas"><i class="icon icon-ok"></i> <span>Chamadas</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aSubstituicao')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>substituicoes"><i class="icon icon-refresh"></i> <span>Substituições</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aProvento')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>proventos"><i class="icon icon-upload"></i> <span>Proventos</span></a>
                    </li>
                <?php } ?>
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aDesconto')){ ?>
                    <li>
                        <a href="<?php echo base_url()?>descontos"><i class="icon icon-download"></i> <span>Descontos</span></a>
                    </li>
                <?php } ?>    
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aFalta')){ ?>
                    <li><a href="<?php echo base_url()?>faltas"><i class="icon icon-th"></i> <span>Faltas</span></a></li>
                <?php } ?>    
                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAtraso')){ ?>
                    <li><a href="<?php echo base_url()?>atrasos"><i class="icon icon-th-list"></i> <span>Atrasos</span></a></li>
                <?php } ?> 
          </ul>
        </li>

        <!--- FECHAMENTOS --->
        <li class="submenu <?php if(isset($menuFechamentos)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-ok"></i> <span>Fechamentos</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'fFuncionario')){ ?>
                <li><a href="<?php echo base_url()?>fechamentos/funcionario"><i class="icon icon-folder-open-alt"></i> Funcionários</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rChamada')){ ?>
                <li><a href="<?php echo base_url()?>fechamentos/chamada"><i class="icon icon-ok"></i> Chamadas</a></li>
            <?php } ?>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'fParticular')){ ?>
                <li><a href="<?php echo base_url()?>fechamentos/particular"><i class="icon icon-ok"></i> Particulares</a></li>
            <?php } ?>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'fEmpresa')){ ?>
                <li><a href="<?php echo base_url()?>fechamentos/empresa"><i class="icon icon-ok"></i> Chamadas Empresa</a></li>
            <?php } ?>
            
          </ul>
        </li>
    

        <!--- RELATÓRIOS --->
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-star"></i> <span>Relatórios</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rContrato')){ ?>
                <li><a href="<?php echo base_url()?>relatorios/contratos"><i class="icon icon-book"></i> Contratos</a></li>
            <?php } ?>
            
           
			<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){ ?>
                <li><a href="<?php echo base_url()?>relatorios/clientes"><i class="icon icon-group"></i> Clientes</a></li>
            <?php } ?>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFuncionario')){ ?>
                <li><a href="<?php echo base_url()?>relatorios/funcionarioSalarios"><i class="icon icon-folder-open-alt"></i> Funcionário Salários</a></li>
            <?php } ?>
            
            
          </ul>
        </li>
        
        <!--- OPÇÕES --->
        <li class="submenu <?php if(isset($menuOpcoes)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-zoom-in"></i> <span>Recursos Humanos</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'oHolerite')){ ?>
                <li><a href="<?php echo base_url()?>holerites"><i class="icon icon-inbox"></i> Holerites</a></li>
            <?php } ?>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'oEtiqueta')){ ?>
                <li><a href="<?php echo base_url()?>etiquetas"><i class="icon icon-flag"></i> Etiquetas</a></li>
            <?php } ?>
          </ul>
        </li>



    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Configurações</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>usuarios">Usuários</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aParametro')){ ?>
                <li><a href="<?php echo base_url()?>parametro">Parâmetros</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCidade')){ ?>
                <li><a href="<?php echo base_url()?>cidade">Cidades</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aBairro')){ ?>
                <li><a href="<?php echo base_url()?>bairro">Bairros</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aTabelaFrete')){ ?>
                <li><a href="<?php echo base_url()?>tabelafrete">Tabelas de Frete</a></li>
            <?php } ?>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>permissoes">Permissões</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>entrega/backup">Backup</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    
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







