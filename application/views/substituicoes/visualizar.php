<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Substitutos deste Cliente</a></li>
           
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'substituicoes/"><i class="icon-pencil icon-white"></i> Editar</a>'; 
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
                                            <span class="icon"><i class="icon-list"></i></span>
                                            <h5><? echo $result[0]->nomeCliente; ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                       
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>Funcionário</th>
                                                    <th>Funcionário Substituto</th>
                                                    <th>Data</th>
                                                    <th>Valor Empresa</th>
                                                    <th>Valor Funcionário</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result[0]->listaSubstCliente as $r) {
                                                    echo '<tr>';
                                                    echo '<td>'.$r->nomeFalta.'</td>';
                                                    echo '<td>'.$r->nomeSubstituto.'</td>';
                                                    echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
                                                    echo '<td>R$ '.number_format($r->valor_empresa, "2", ",", ".").'</td>';
                                                    echo '<td>R$ '.number_format($r->valor_funcionario, "2", ",", ".").'</td>';
                                                    echo '</tr>';
                                                }?>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="text-align:left; font-size: 14px;">R$ <? echo number_format($result[0]->listaSubstCliente[0]->valorTotal[0]->totalEmpresa, "2", ",", "."); ?></th>
                                                    <th style="text-align:left; font-size: 14px;">R$ <? echo number_format($result[0]->listaSubstCliente[0]->valorTotal[0]->totalFuncionario, "2", ",", "."); ?></th>
                                                </tr>

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