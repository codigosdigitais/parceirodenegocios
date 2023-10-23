<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do fornecedor</a></li>
           
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'fornecedores/editar/'.$result[0]->idFornecedor.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
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
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Pessoais</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Razão Social</strong></td>
                                                    <td><?php echo $result[0]->razaosocial ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento CNPJ</strong></td>
                                                    <td><?php echo $result[0]->cnpj ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento IE</strong></td>
                                                    <td><?php echo $result[0]->ie ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento IM</strong></td>
                                                    <td><?php echo $result[0]->im ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Contatos</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Responsável</strong></td>
                                                    <td><?php echo $result[0]->responsavel ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Telefone Fixo</strong></td>
                                                    <td>(<?php echo $result[0]->responsavel_telefone_ddd ?>) <?php echo $result[0]->responsavel_telefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Telefone Celular</strong></td>
                                                    <td>(<?php echo $result[0]->responsavel_celular_ddd ?>) <?php echo $result[0]->responsavel_celular?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Email Principal</strong></td>
                                                    <td><?php echo $result[0]->email ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Responsável Financeiro</strong></td>
                                                    <td><?php echo $result[0]->responsavel_financeiro ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Telefone Fixo</strong></td>
                                                    <td>(<?php echo $result[0]->responsavel_financeiro_telefone_ddd ?>) <?php echo $result[0]->responsavel_financeiro_telefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Telefone Celular</strong></td>
                                                    <td>(<?php echo $result[0]->responsavel_financeiro_celular_ddd ?>) <?php echo $result[0]->responsavel_financeiro_celular ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Email Financeiro</strong></td>
                                                    <td><?php echo $result[0]->email_financeiro ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Endereço</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGThree">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Rua</strong></td>
                                                    <td><?php echo $result[0]->endereco ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Número</strong></td>
                                                    <td><?php echo $result[0]->endereco_numero ?> - <?php echo $result[0]->endereco_complemento ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Bairro</strong></td>
                                                    <td><?php echo $result[0]->endereco_bairro ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Cidade</strong></td>
                                                    <td><?php echo $result[0]->endereco_cidade ?> - <?php echo $result[0]->estado ?></td>
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