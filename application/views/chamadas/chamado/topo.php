<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Chamadas - Nova Dashboard</title>

        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/vendors/feather/feather.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/css/vendor.bundle.base.css">
        <!-- endinject -->

        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/vendors/ti-icons/css/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/chamada'); ?>/assets/js/select.dataTables.min.css">
        <!-- End plugin css for this page -->
        
        <!-- inject:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/chamada'); ?>/assets/css/horizontal-layout-light/style.css">
        <!-- endinject -->

        <!-- Select 2 -->
        <link href="<?php echo base_url('assets/chamada'); ?>/assets/vendors/select2/select2.min.css" rel="stylesheet" />
        <!-- End Select 2 -->
        
        <link href="//cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css" rel="stylesheet" />

        <link rel="shortcut icon" href="<?php echo base_url('assets/chamada'); ?>/assets/images/favicon.png" />
    </head>

    <body>
        <div class="container-scroller">
            <!-- partial:partials/_horizontal-navbar.html -->
            <div class="horizontal-menu">
                <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                    <div class="container">
                        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                            
                            <a class="" href="<?php echo base_url(); ?>">
                                <img src="<? echo base_url("assets/img/logo2.png"); ?>" style="padding: 10px">
                            </a>
                            
                            <button type="button" class="btn btn-info btn-icon-text pr-4">
                              <i class="ti-file btn-icon-prepend"></i>
                              VOLTAR AO SISTEMA ANTERIOR
                            </button>

                        </div>
                    </div>
                </nav>
                <nav class="bottom-navbar pt-2 pb-2">
                    <div class="container">
                        <ul class="nav page-navigation">
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;">
                                    <i class="ti-user menu-icon"></i>
                                    <span class="menu-title active-bold"><?php echo $this->session->userdata('nome'); ?></span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;">
                                    <i class="ti-receipt menu-icon"></i>
                                    <span class="menu-title active-bold"><?php echo $this->session->userdata('tipo'); ?></span>
                                </a>
                            </li>                        

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;">
                                    <i class="ti-star menu-icon"></i>
                                    <span class="menu-title active-bold"><?php echo $this->session->userdata('razaosocial'); ?></span>
                                </a>
                            </li>
                            <!--
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <i class="ti-infinite menu-icon"></i>
                                    <span class="menu-title active-bold"><?php echo $this->session->userdata('nomeEmpresaVinculo'); ?></span>
                                </a>
                            </li>
                            -->
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <i class="ti-power-off menu-icon"></i>
                                    <span class="menu-title active-bold">SAIR DO SISTEMA</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
