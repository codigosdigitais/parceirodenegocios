<?php

    /* Configurações básicas do formulário de chamadas */
    
    //$chamada = null;
    $idChamada = 0;
    $metodo = $this->uri->segment(3);

    if($metodo=='editar')
    {
        $chamada = $chamadaById;
        $idChamada = $this->uri->segment(4);
        $metodo = "editar";
    }
        //echo $this->uri->segment(4);

?>
<style>
    .data-chamada 
    {
        border: none;
        background-color: transparent;
        color: white;
        font-size: 28px;
        font-weight: bold;
    }
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">

        <form class="form-sample" name="" action="<?php echo str_replace("criar", "salvar", current_url()); ?>" method="post" enctype="multipart/form-data">

        <div class="content-wrapper">
            <div class="justify-content-end d-flex grid-margin">
                <a href="<?php echo base_url($this->uri->segment(1).'/chamadas/chamado'); ?>">
                    <button class="btn btn-primary btn-icon-text" type="button">
                        <i class="ti-blackboard btn-icon-prepend"></i>
                        <span class="d-inline-block text-left">
                            <small class="font-weight-light d-block">Visualizar todas</small>
                            as chamadas
                        </span>
                    </button>
                </a>                          
            </div>

            <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                    <h6 class="mb-0">Número da Chamada</h6>
                                    <p class="mb-0 text-success font-weight-bold qtde-item"><?php echo $idChamada; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                    <h6 class="mb-0">Data/Hora</h6>
                                    <p class="mb-0 text-success font-weight-bold qtde-item-2">
                                        <input type="date" class="data-chamada" id="data_post" name="data_post" value="<?php if($metodo=='editar'){ echo $chamada->data; } else { echo date("Y-m-d"); }?>">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                    <h6 class="mb-0">Atendente</h6>
                                    <p class="mb-0 text-success font-weight-bold qtde-item-2">
                                        <?php 
                                        if($metodo=='editar')
                                        {
                                            echo $chamada->nomeAtendente;
                                        } else {
                                            echo $this->session->userdata('nome');
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php

            #echo "<pre>";
            #print_r($chamada);
            #echo $this->uri->segment(3);
            #echo "</pre>";
        ?>

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">



                        <?php 
                            if($metodo=='editar'){
                        ?>
                            <input type="hidden" name="idChamada" id="idChamada" value="<?php echo $chamada->idChamada; ?>">
                            <input type="hidden" name="tarifa" id="tarifa" value="<?php echo $chamada->tarifa; ?>">
                            <input type="hidden" name="valor_empresa" id="valor_empresa" value="<?php echo $chamada->valor_empresa; ?>">
                            <input type="hidden" name="valor_funcionario" id="valor_funcionario" value="<?php echo $chamada->valor_funcionario; ?>">
                            <input type="hidden" name="solicitante" id="solicitante" value="<?php echo $chamada->solicitante; ?>">
                            <input type="hidden" name="tipo_veiculo" id="tipo_veiculo" value="<?php echo $chamada->tipo_veiculo; ?>">
                            <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $chamada->idCliente; ?>">
                            <input type="hidden" name="pontos" id="pontos" value="<?php echo $chamada->pontos; ?>">
                        <?php } ?>

                        <input type="hidden" name="idAtendente" id="idAtendente" value="<?php echo $this->session->userdata('idUsuario'); ?>">
                        <input type="hidden" name="codigo" value="-1" />
                        <input type="hidden" name="valor_manual" value="false" />                        
                        <input type="hidden" name="data" value="<?php echo date("d/m/Y"); ?>" />                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cliente</label>
                                    <div class="col-sm-10">
                                        <select 
                                            class="form-control select2-lista" 
                                            id="idCliente" 
                                            name="idCliente" 
                                            onchange="clienteChange()" 
                                            data-placeholder="Pesquisar Cliente"
                                            required 
                                            <?php if($metodo=="editar"){ ?>disabled<? } ?>
                                        >
                                            <?php foreach($this->data['listaCliente'] as $listaCliente){ ?>
                                                <option></option>
                                                <option 
                                                    value="<? echo $listaCliente->idCliente;?>"
                                                    <?php 
                                                        if(isset($chamada->idCliente)){ 
                                                            if($chamada->idCliente==$listaCliente->idCliente){ 
                                                                echo "selected"; 
                                                            } 
                                                        }  
                                                    ?>
                                                >
                                                <?php echo $listaCliente->razaosocial;?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Solicitante</label>
                                    <div class="col-sm-10">
                                        <?php if($metodo=="editar"){ ?>
                                            <input 
                                                class="form-control" 
                                                disabled 
                                                type="text" 
                                                value="<?php if(!empty($chamada->nomeSolicitante)) echo $chamada->nomeSolicitante; ?>">
                                        <?php } else { ?>                                        
                                        <select class="form-control selectSolicitante  select2-lista" name="solicitante" id="solicitante">
                  
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">KM</label>
                                    <div class="col-sm-1">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="km" 
                                            id="km"
                                            value="<?php if(isset($chamada->km)){ echo $chamada->km; } ?>"
                                        >
                                    </div>

                                    <label class="col-sm-1 col-form-label">Descarga</label>
                                    <div class="col-sm-1">
                                        <input type="text" 
                                            class="form-control" 
                                            name="descarga" 
                                            id="descarga" 
                                            placeholder="0.00"
                                            value="<?php if(isset($chamada->descarga)){ echo $chamada->descarga; } ?>"
                                        >
                                    </div>

                                    <label class="col-sm-1 col-form-label">Pernoite</label>
                                    <div class="col-sm-1">
                                        <input type="text" 
                                            class="form-control" 
                                            name="pernoite" 
                                            id="pernoite" 
                                            placeholder="0.00"
                                            value="<?php if(isset($chamada->pernoite)){ echo $chamada->pernoite; } ?>"
                                        >
                                    </div>

                                    <label class="col-sm-1 col-form-label">Romaneio</label>
                                    <div class="col-sm-1">
                                        <input type="text" 
                                            class="form-control" 
                                            name="romaneio" 
                                            id="romaneio" 
                                            placeholder="0.00"
                                            value="<?php if(isset($chamada->romaneio)){ echo $chamada->romaneio; } ?>"
                                        >
                                    </div>

                                    <div class="col-sm-4">
                                        <select 
                                            class="form-control select2-lista" 
                                            id="tipo_veiculo" 
                                            name="tipo_veiculo"
                                            <?php if($metodo=="editar"){ ?>disabled<?php } ?>
                                        >
                                            <option value="1" <?php if(isset($chamada->tipo_veiculo)){ if($chamada->tipo_veiculo==1){ echo "selected"; } }  ?>>Veículo - Moto</option>
                                            <option value="2" <?php if(isset($chamada->tipo_veiculo)){ if($chamada->tipo_veiculo==2){ echo "selected"; } }  ?>>Veículo - Carro</option>
                                            <option value="3" <?php if(isset($chamada->tipo_veiculo)){ if($chamada->tipo_veiculo==3){ echo "selected"; } }  ?>>Veículo - Van</option>
                                            <option value="4" <?php if(isset($chamada->tipo_veiculo)){ if($chamada->tipo_veiculo==4){ echo "selected"; } }  ?>>Veículo - Caminhão</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <? if($metodo=="editar"){ ?>
                        <div class=" row">
                                <table class="table  table-hover">
                                    <tbody>
                                            <tr>
                                                <th></td>
                                                <th><strong>ENDEREÇO</strong></th>
                                                <th><strong>Nº</strong></th>
                                                <th><strong>CIDADE</strong></th>
                                                <th><strong>BAIRRO</strong></th>
                                                <th><strong>FALAR COM</strong></th>
                                            </tr>
                                            
                                        <?php foreach($chamada->chamadaServico as $valor){ ?>
                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong><? if($valor->tiposervico=='0'){ echo "Coleta"; } elseif($valor->tiposervico=='1'){ echo "Entrega"; } else { echo "Retorno"; } ?></strong>
                                                </td>
                                                <td><? echo $valor->endereco; ?></td>
                                                <td><? echo $valor->numero; ?></td>
                                                <td><? echo $valor->cidade; ?></td>
                                                <td><? echo $valor->bairro; ?></td>
                                                <td><? echo $valor->falarcom; ?></td>
                                            </tr>
                                         <?php } ?>
                                    </tbody>
                                </table>
                        </div>

                        <?php } else { ?>

      
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Itinerários</label>
                                    <div class="col-sm-5">
                                        <select id="idClienteFreteItinerario" name="idClienteFreteItinerario" class="form-control">
                                        
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row" id="servico_0">
                            <div class="col">
                                <label>Tipo</label>
                                <div id="the-basics">
                                    <select class="form-control" name="cham_tiposervico[]">
                                        <option value="0">Coleta</option>
                                        <option value="1">Entrega</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label>Endereço</label>
                                <div id="bloodhound">
                                    <input class="typeahead" type="text" placeholder="Endereço" name="cham_endereco[]">
                                </div>
                            </div>

                            <div class="col">
                                <label>Número</label>
                                <div id="bloodhound">
                                    <input class="typeahead" type="text" placeholder="Número" name="cham_numero[]">
                                </div>
                            </div>

                            <div class="col">
                                <label>Cidade</label>
                                <div id="bloodhound">
                                    <select class="form-control selectCidade" name="cham_cidade[]" id="cham_cidade[]" data-placeholder="Selecione a Cidade">
                                        <option value="">Selecione</option>
                                        <?php foreach($this->data['listaCidade'] as $cidade){ ?>
                                        <option value="<?php echo $cidade->idCidade; ?>"><?php echo $cidade->cidade; ?></option>
                                        <?php } ?>
                                    </select>                                                
                                </div>
                            </div>


                            <div class="col">
                                <label>Bairro</label>
                                <div id="bloodhound">
                                   <select class="form-control selectBairro" name="cham_bairro[]" id="cham_bairro[]">
                                        <option value="">Selecione</option>
                                    </select>                                                
                                </div>
                            </div> 

                            <div class="col">
                                <label>Falar com</label>
                                <div id="bloodhound">
                                    <input class="typeahead" type="text" name="cham_falarcom[]" placeholder="Falar com">
                                </div>
                            </div>  

                            <div class="col-sm-1">
                                <label>Opções</label>
                                <div id="bloodhound">
                                    <!-- Por ser o primeiro array() não há necessidade de exclusão e nem do botão adicionar
                                    <button class="btn btn-sm btn-warning">
                                        <span class="ti-plus"></span>
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        <span class="ti-trash"></span>
                                    </button>
                                    -->
                                </div>
                            </div>                                                                            
                        </div>

                        <div id="servicosTable"></div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label"></label>
                                    <div class="col-sm-2">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="retornar-origem" id="retornar-origem">
                                                Retornar à origem na conclusão
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <!--
                                                <input type="checkbox" class="form-check-input" name="gravar-itinerario" id="gravar-itinerario">
                                                Gravar Itinerário
                                                <i class="input-helper"></i>
                                                -->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                         
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Observações</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control" name="observacoes" id="observacoes" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Registradas</label>
                                    <div class="col-sm-11">
                                        <? if(isset($chamada->observacoes) && $chamada->observacoes != ""){
                                            echo str_replace("\n", "<br>", $chamada->observacoes);
                                        } ?>

                                        <? if(isset($chamada->observacoes_app) && $chamada->observacoes_app != ""){
                                            echo "<br><br>Observações no App<br>";
                                            echo str_replace("\n", "<br>", $chamada->observacoes_app);
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Funcionário</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2-lista" id="idFuncionario" name="idFuncionario" data-placeholder="Pesquisar Funcionário">
                                            <option value=""></option>
                                            <?php foreach($this->data['listaFuncionario'] as $funcionarioLista){ ?>
                                            <option 
                                                value="<?php echo $funcionarioLista->idFuncionario;?>"
                                                <?php 
                                                    if(isset($chamada->idFuncionario)){ 
                                                        if($funcionarioLista->idFuncionario==$chamada->idFuncionario){ 
                                                            echo "selected"; 
                                                        } 
                                                    } 
                                                ?>                                                
                                            >
                                                <?php echo $funcionarioLista->nome;?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Repasse</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" name="hora_repasse" id="hora_repasse">
                                    </div>
                                </div>
                            </div>
                        </div>                                

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Espera</label>
                                    <div class="col-sm-1">
                                        <input 
                                            type="time" 
                                            class="form-control" 
                                            name="tempo_espera" 
                                            id="tempo_espera"
                                            value="<?php if(isset($chamada->tempo_espera)){ echo $chamada->tempo_espera; } ?>"
                                        >
                                    </div>

                                    <label class="col-sm-1 col-form-label">Valor Empresa</label>
                                    <div class="col-sm-1">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="0.00"
                                            disabled="" 
                                            name="valor_empresa" 
                                            id="valor_empresa"
                                            value="<?php if(isset($chamada->valor_empresa)){ echo $chamada->valor_empresa; } ?>"
                                        >
                                    </div>

                                    <label class="col-sm-1 col-form-label">Valor Funcionário</label>
                                    <div class="col-sm-1">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="0.00" 
                                            disabled="" 
                                            name="valor_funcionario" 
                                            id="valor_funcionario"
                                            value="<?php if(isset($chamada->valor_funcionario)){ echo $chamada->valor_funcionario; } ?>"
                                        >
                                    </div>

                                    
                                    <div class="col-sm-2">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="alterar_valor" id="alterar_valor">
                                                Informar Valor?
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <select class="form-control select2-lista" id="status" name="status">
                                            <option value="0" <?php if(isset($chamada->status)){ if($chamada->status==0){ echo "selected"; } }  ?>>Pendente</option>
                                            <option value="1" <?php if(isset($chamada->status)){ if($chamada->status==1){ echo "selected"; } }  ?>>Em Andamento</option>
                                            <option value="2" <?php if(isset($chamada->status)){ if($chamada->status==2){ echo "selected"; } }  ?>>Concluída</option>
                                            <option value="3" <?php if(isset($chamada->status)){ if($chamada->status==3){ echo "selected"; } }  ?>>Cancelada</option>
                                            <?php if(isset($chamada->status) && $chamada->status==-2){ ?>
                                                <option value="-2" selected>Possui trecho sem valor</option>
                                            <?php } ?>                                            
                                        </select>   
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary mr-2 pull-left">Gravar Chamada</button>
                        <!--<button type="button" class="btn btn-danger mr-2 pull-left">Cancelar</button> \\ decidi não usar o cancelar -->


                    
                    
                </div>
            </div>
        </div>

    </form> <!-- end form -->

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021 Parceiro de Negócios. All rights reserved.
                </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Códigos Digitais - Agência Digital 
                <i class="ti-heart text-danger ml-1"></i>
                </span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->



<!-- Modelo para adicionar serviço -->
<input type="hidden" id="countServs" value="1" >
<div class="hidden" style="display:none">
    <div id="servicoModelo">
        <div class="form-group row" id="servico_COUNT">
            <div class="col">
                <div id="the-basics">
                    <select class="form-control" name="cham_tiposervico[]">
                        <option value="0">Coleta</option>
                        <option value="1" selected="">Entrega</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div id="bloodhound">
                    <input class="typeahead" type="text" placeholder="Endereço" name="cham_endereco[]">
                </div>
            </div>

            <div class="col">
                <div id="bloodhound">
                    <input class="typeahead" type="text" placeholder="Número" name="cham_numero[]">
                </div>
            </div>

            <div class="col">
                <div id="bloodhound">
                    <select class="form-control selectCidade" name="cham_cidade[]" data-placeholder="Selecione a Cidade">
                        <option value="">Selecione</option>
                        <?php foreach($this->data['listaCidade'] as $cidade){ ?>
                        <option value="<?php echo $cidade->idCidade; ?>"><?php echo $cidade->cidade; ?></option>
                        <?php } ?>
                    </select>                                                
                </div>
            </div>

            <div class="col">
                <div id="bloodhound">
                   <select class="form-control selectBairro" name="cham_bairro[]">
                        <option value="">Selecione</option>
                    </select>                                                
                </div>
            </div> 

            <div class="col">
                <div id="bloodhound">
                    <input class="typeahead" type="text" name="cham_falarcom[]" placeholder="Falar com">
                </div>
            </div>   

            <div class="col-sm-1">
                <div id="bloodhound">
                    <button type="button" class="btn btn-sm btn-warning" onclick="adicionarServico()">
                        <span class="ti-plus"></span>
                    </button>

                    <button type="button" class="btn btn-sm btn-danger" onclick="removerServico(COUNT)">
                        <span class="ti-trash"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modelo serviço -->


<div id="div-itinerario-servicos" role="<?php echo base_url('chamadas/get_itinerarios_cliente_ajax'); ?>" style="display: none;"></div>