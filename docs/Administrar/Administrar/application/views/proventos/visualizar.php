<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Proventos deste Funcionário</a></li>
           
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'proventos/"><i class="icon-pencil icon-white"></i> Editar</a>'; 
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
                                            <h5><? echo $result[0]->nomeFuncionario; ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                       
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>Funcionário</th>
                                                    <th>Tipo</th>
                                                    <th>Data</th>
                                                    <th>Valor</th>
                                                    <th style="width: 115px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php foreach ($result[0]->listaProventosView as $r) {
													
													@$total += $r->valor; 
													
                                                    echo '<tr>';
                                                    echo '<td>'.$result[0]->nomeFuncionario.'</td>';
                                                    echo '<td>'.$r->nomeParametro.'</td>';
                                                    echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
                                                    echo '<td>R$ '.number_format($r->valor, "2", ",", ".").'</td>';
                                                    echo '<td>';

                                                    if($this->permission->canUpdate()){
                                                        echo '<a href="'.base_url().'proventos/lista/editar/'.$r->idProvento.'" style="margin-right: 1%" class="btn btn-info " title="Editar Provento"><i class="icon-pencil icon-white"></i></a>'; 
                                                    }
                                                    if($this->permission->canDelete()){
                                                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" Provento="'.$r->idProvento.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Provento"><i class="icon-remove icon-white"></i></a>'; 
                                                    }
                                        
                                                      
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }?>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="text-align: left; font-size: 14px;">R$ <? echo number_format($total, "2", ",", "."); ?> </th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?
										//print_r($result[0]->listaClientesView);
										?>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

        </div>
    </div>
</div>