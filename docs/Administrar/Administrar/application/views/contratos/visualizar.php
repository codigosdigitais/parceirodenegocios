<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Contrato</a></li>
           
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'contratos/editar/'.$result[0]->idContrato.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>
    
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">

            <div class="accordion" id="collapse-group">
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Principais</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">

                                        <table class="table table-bordered">
                                            <tbody>
                                            <? foreach($result[0]->cliente as $valor){ ?>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Cliente</strong></td>
                                                    <td><?php echo $valor->razaosocial; ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Responsável</strong></td>
                                                    <td><?php echo $valor->responsavel ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Telefone</strong></td>
                                                    <td>(<?php echo $valor->responsavel_telefone_ddd ?>) <?php echo $valor->responsavel_telefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>E-mail</strong></td>
                                                    <td><?php echo $valor->email ?></td>
                                                </tr>
                                                <? } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Funcionários</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                             <? foreach($result[0]->funcionarioLista as $valor){ ?>
                                                <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                            <tr>
                                                              <td width="35%"><?=$valor->nomeFuncionario;?></td>
                                                              <td width="25%">Manhã: <?=$valor->horaentrada;?> às <?=$valor->horasaida;?> - Tarde: <?=$valor->horaentradatarde;?> às <?=$valor->horasaidatarde;?></td>
                                                              <td width="10%">R$ <?=number_format($valor->valor, 2, ',', '.');?></td>
                                                              <td width="35%">Sábado: <?=$valor->horaentradamanhasabado;?> às <?=$valor->horasaidamanhasabado;?> - Tarde: <?=$valor->horaentradasabado;?> às <?=$valor->horasaidasabado;?></td>
                                                            </tr>

                                                        </table>
                                                        </td>
                                                </tr>
                                             <? } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

        </div>
    </div>
</div>