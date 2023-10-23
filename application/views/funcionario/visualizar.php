<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Funcionário</a></li>
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'funcionario/editar/'.$result[0]->idFuncionario.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
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
                                                    <td style="text-align: right; width: 30%"><strong>Nome</strong></td>
                                                    <td><?php echo $result[0]->nome ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento RG</strong></td>
                                                    <td><?php echo $result[0]->rg ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento CPF</strong></td>
                                                    <td><?php echo $result[0]->cpfnumero ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento CNH</strong></td>
                                                    <td><?php echo $result[0]->cnhnumero ?></td>
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
                                                    <td style="text-align: right; width: 30%"><strong>Telefone Fixo</strong></td>
                                                    <td>(<?php echo $result[0]->responsaveltelefoneddd ?>) <?php echo $result[0]->responsaveltelefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Telefone Celular</strong></td>
                                                    <td>(<?php echo $result[0]->responsavelcelularddd ?>) <?php echo $result[0]->responsavelcelular?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Email Principal</strong></td>
                                                    <td><?php echo $result[0]->email ?></td>
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
                                                    <td><?php echo $result[0]->endereco ?>, <?php echo $result[0]->endereconumero ?> - <?php echo $result[0]->enderecocomplemento ?> - <?php echo $result[0]->enderecobairro ?> (<?php echo $result[0]->enderecocidade ?>)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                            
              				<div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGSix" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Documentação</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGSix">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                            	<?
												if(count($result[0]->documentacao)>0){ 
													foreach($result[0]->documentacao as $documento){
												?>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong><? echo $documento->nomearquivo;?></strong></td>
                                                    <td><? echo '<a href="'.base_url().'documentos/download/'.$documento->idDocumento.'" style="margin-right: 1%" class="btn " title="Download do Arquivo"><i class="icon-download-alt"></i></a>'; ?></td>
                                                </tr>
                                                <? 
													} 
												} else { 
												
												?>
                                                <tr>
                                                	<td>
                                                    	Este cliente não possui nenhum documento arquivado até o momento.
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