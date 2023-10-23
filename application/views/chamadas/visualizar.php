<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Detalhes da Chamada</a></li>
        </ul>
    </div>

    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active">
            <div class="accordion" id="collapse-group">
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                <span class="icon"><i class="icon-list"></i></span>
                                <h5>Detalhes da Chamada e Transação</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse in accordion-body" id="collapseGOne">
                        <div class="widget-content">
                           
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Chamada</th>
                                        <th>Cliente</th>
                                        <th>Data</th>
                                        <th>Funcionário</th>
                                        <th>TID</th>
                                        <th>NSU</th>
                                        <th>Tipo</th>
                                        <th>Cartão</th>
                                        <th>Valor</th>
                                        <th>Status de Pgto</th>
                                        <th>Data do Pgto.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $result->idChamada; ?></td>
                                        <td><?php echo $result->cliente_nome; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($result->data)) . $result->hora; ?></td>
                                        <td><?php echo ($result->funcionario_nome) ? $result->funcionario_nome : '-'; ?></td>
                                        <td><?php echo ($result->tid) ? $result->tid : '-'; ?></td>
                                        <td><?php echo ($result->nsu) ? $result->nsu : '-'; ?></td>
                                        <td><strong><?php echo ($result->cardType) ? $result->cardType : '-'; ?></strong></td>
                                        <td><?php echo ($result->cardNumber) ? substr_replace($result->cardNumber, ' **** **** ', 4, 8) : '-'; ?></td>
                                        <td>R$ <?php echo number_format($result->valor_empresa, 2, ',', '.'); ?></td>
                                        <td><?php echo ($result->status_detail) ? $result->status_detail : '-'; ?></td>
                                        <td><?php echo date("d/m/Y - H:i:s", strtotime($result->dateOfPayment)); ?></td>
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
