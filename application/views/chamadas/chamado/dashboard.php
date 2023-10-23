            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <?php 
                                            #echo "<pre>";
                                            #print_r($this->session->userdata);
                                            #echo "</pre>";


                                            $periodo_atual = $this->uri->segment(4);
                                            if($periodo_atual=="")
                                            {
                                                $periodo_atual = 1;
                                            }
                                            /*
                                            else 
                                            {
                                                $periodo_atual = $this->uri->segment(4);
                                            }*/
                                        ?>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="justify-content-end d-flex">
                                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                                <button class="btn btn-primary dropdown-toggle escolher-periodo" type="button" id="dropdownMenuDate2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-periodo="1">
                                                <i class="mdi mdi-calendar"></i> 
                                                <?php if($periodo_atual==1){ ?>
                                                    Hoje - <?php echo date("d/m/Y"); ?>
                                                <?php } else { ?>
                                                    <?php 

                                                        if($periodo_atual==15){
                                                            echo "Próximos ".$periodo_atual." dias";
                                                        } else {
                                                            echo $periodo_atual." dias atrás"; 
                                                        }
                                                    
                                                    ?>
                                                <?php } ?>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">


                                                    <?php if($periodo_atual!=1){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="1">Hoje - <?php echo date("d/m/Y"); ?></a>
                                                    <?php } ?>

                                                    <?php if($periodo_atual!=7){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="7">7 dias atrás</a>
                                                    <?php } ?>
                                                    
                                                    <?php if($periodo_atual!=14){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="14">14 dias atrás</a>
                                                    <?php } ?>
                                                    
                                                    <?php if($periodo_atual!=30){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="30">30 dias atrás</a>
                                                    <?php } ?>

                                                    <?php if($periodo_atual!=90){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="90">90 dias atrás</a>
                                                    <?php } ?>

                                                    <?php if($periodo_atual!=15){ ?>
                                                    <a class="dropdown-item escolher-periodo" href="javascript:;" data-periodo="15">Próximos 15 dias</a>
                                                    <?php } ?>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-light-danger">
                                    <div class="card-body">
                                        <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                            <i class="icon-search"></i>
                                            <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                                <h6 class="mb-0">Chamadas em Aberto</h6>
                                                <p class="mb-0 text-success font-weight-bold qtde-item"><?php echo count($chamadas_lista_pendente); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-dark-blue">
                                    <div class="card-body">
                                        <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                                <i class="icon-search"></i>
                                            <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                                <h6 class="mb-0">Chamadas Finalizadas</h6>
                                                <p class="mb-0 text-success font-weight-bold qtde-item"><?php echo count($chamadas_lista_finalizada); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card card-light-blue">
                                    <div class="card-body">
                                        <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                            <i class="icon-search"></i>
                                            <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                                <h6 class="mb-0">Clientes sem Avaliação</h6>
                                                <p class="mb-0 text-success font-weight-bold qtde-item">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="justify-content-end d-flex">
                            <a href="<?php echo base_url($this->uri->segment(1).'/chamadas/chamado/criar'); ?>">
                                <button class="btn btn-dark btn-icon-text">
                                    <i class="ti-blackboard btn-icon-prepend"></i>
                                    <span class="d-inline-block text-left">
                                        <small class="font-weight-light d-block">Registre um novo</small>
                                        Chamado
                                    </span>
                                </button>
                            </a>                          
                        </div>
                    </div>
                    <!-- content-wrapper ends -->

                        <!-- Chamadas Pendentes -->
                        <div class="row pl-4 pr-4 pt-4 pb-4">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-title">Chamadas Pendentes</p>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="" class="display  expandable-table table-hover lista-chamadas-finalizadas" style="width:100%">
                                                        <thead>
                                                            <tr style="background-color: red !important;">
                                                                <th>Chamada</th>
                                                                <th width="12%">Data</th>
                                                                <th>Empresa</th>
                                                                <th width="20%">Funcionário</th>
                                                                <th>Repasse</th>
                                                                <th width="8%">Tipo</th>
                                                                <th width="10%">Valor</th>
                                                                <th>Status</th>
                                                                <th width="10%">Opções</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            foreach($chamadas_lista_pendente as $valor){ 




                                                                // Verificação de cores
                                                                if($valor->status=='3'){
                                                                    $cor = "#75A9DD";   
                                                                    $style = "style='color: black;'";
                                                                } elseif($valor->status=='1') {
                                                                    $cor = "#FFCC00";
                                                                    $style = "style='color: black;'";
                                                                } elseif($valor->status=='0'){
                                                                    $cor = "red";
                                                                    $style = "style='color: white;'";
                                                                } elseif($valor->status=='-5' || $valor->statusPayment=='0' && $valor->idFuncionario==NULL){
                                                                    $cor = "#C02028";
                                                                    $style = "style='color: white;'";
                                                                } elseif($valor->status=='-1'){
                                                                    $existePreCadastro =true;
                                                                    $cor = "#000";
                                                                    $style = "style='color: white;'";
                                                                } elseif($valor->status=='-2'){
                                                                    $existeTrechoSemValor =true;
                                                                    $cor = "#666";
                                                                    $style = "style='color: white;'";
                                                                } else { 
                                                                    $cor = NULL;
                                                                    $style = NULL;  
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <label class="badge badge-success"><?php echo $valor->idChamada; ?></label>
                                                                </td>                                                                
                                                                <td><?php echo date("d/m/Y", strtotime($valor->data))." ".$valor->hora; ?></td>
                                                                <td><?php echo $valor->idCliente; ?></td>
                                                                <td><?php echo $valor->idFuncionario; ?></td>
                                                                <td>
                                                                    <label class="badge badge-primary"><?php echo $valor->hora_repasse; ?></label>
                                                                </td>
                                                                <td>
                                                                    <?php echo $valor->tipo_veiculo; ?>
                                                                </td>
                                                                <td>R$ <?php echo number_format($valor->valor_empresa, 2, ',', '.'); ?></td>
                                                                <td>
                                                                    <!--<label class="badge badge-warning"><?php echo $valor->status; ?></label>-->
                                                                    <div style="width: 30px; height: 30px; background-color: <?php echo $cor; ?>"></div>
                                                                </td>
                                                                <td>
                                                                    <!--
                                                                    <button class="btn btn-sm btn-danger" title="Marcar como Finalizada"><i class="ti-check"></i></button>
                                                                    <button class="btn btn-sm btn-warning" title="Cancelar Chamada"><i class="ti-close"></i></button>
                                                                    -->
                                                                    <a href="<?php echo base_url($this->uri->segment(1).'/chamadas/chamado/editar/'.$valor->idChamada); ?>">
                                                                        <button type="button" class="btn btn-warning" title="Editar"><i class="ti-pencil"></i></button>
                                                                    </a>

                                                                </td>
                                                            </tr> 
                                                            <?php } ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        



                        <!-- Chamadas Finalizadas -->
                        <div class="row pl-4 pr-4 pt-4 pb-4">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-title">Chamadas Finalizadas</p>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="" class="display  expandable-table table-hover lista-chamadas-finalizadas" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Chamada</th>
                                                                <th width="12%">Data</th>
                                                                <th>Empresa</th>
                                                                <th width="20%">Funcionário</th>
                                                                <th>Repasse</th>
                                                                <th>Tipo</th>
                                                                <th width="10%">Valor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($chamadas_lista_finalizada as $valor){ ?>
                                                            <tr>
                                                                <td>
                                                                    <label class="badge badge-success"><?php echo $valor->idChamada; ?></label>
                                                                </td>                                                                
                                                                <td><?php echo date("d/m/Y", strtotime($valor->data))." ".$valor->hora; ?></td>
                                                                <td><?php echo $valor->idCliente; ?></td>
                                                                <td><?php echo $valor->idFuncionario; ?></td>
                                                                <td>
                                                                    <label class="badge badge-primary"><?php echo $valor->hora_repasse; ?></label>
                                                                </td>
                                                                <td>
                                                                    <label class="badge badge-warning"><?php echo $valor->tipo_veiculo; ?></label>
                                                                </td>
                                                                <td>R$ <?php echo number_format($valor->valor_empresa, 2, ',', '.'); ?></td>
                                                            </tr> 
                                                            <?php } ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium 
                            <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.
                            </span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with 
                            <i class="ti-heart text-danger ml-1"></i>
                            </span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->