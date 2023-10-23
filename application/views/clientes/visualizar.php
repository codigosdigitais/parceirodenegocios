<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Cliente</a></li>
            <div class="buttons">
                    <?php if($this->permission->canUpdate()){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'clientes/editar/'.$result[0]->idCliente.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
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
                                            <span class="icon"><i class="icon-list"></i></span><h5><?php echo $result[0]->razaosocial ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Razão Social</strong></td>
                                                    <td colspan="5"><?php echo $result[0]->razaosocial ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Documento CNPJ</strong></td>
                                                    <td><?php echo $result[0]->cnpj ?></td>
                                                    <td style="text-align: right"><strong>Documento IE</strong></td>
                                                    <td><?php echo $result[0]->ie ?></td>
                                                    <td style="text-align: right"><strong>Documento IM</strong></td>
                                                    <td><?php echo $result[0]->im ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right" colspan="0"><strong>Data de Cadastro</strong></td>
                                                    <td colspan="5"><?php echo date("d/m/Y", strtotime($result[0]->data_ativo)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <!--<div class="accordion-group widget-box">
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
                                                    <td style="text-align: right; width: 30%"><strong>Telefone Fixo</strong></td>
                                                    <td>(<?php echo $result[0]->fat_telefone_ddd ?>) <?php echo $result[0]->fat_telefone ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Telefone Celular</strong></td>
                                                    <td>(<?php echo $result[0]->fat_celular_ddd ?>) <?php echo $result[0]->fat_celular ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Email Secundário</strong></td>
                                                    <td><?php echo $result[0]->email_financeiro ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>-->
                            
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
                                                    <td><?php echo $result[0]->endereco ?>, <?php echo $result[0]->endereco_numero ?> - <?php echo $result[0]->endereco_bairro ?> - <?php echo $result[0]->endereco_cidade ?> - <?php echo $result[0]->nomeEstado ?> - CEP <?php echo $result[0]->endereco_cep ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            
              				<div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGFive" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Contato</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGFive">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                            	<?
													foreach($result[0]->clienteResponsaveis as $responsaveis){
												?>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong><? echo $responsaveis->setor;?></strong></td>
                                                    <td><? echo $responsaveis->nome;?></td>
                                                    <td>(<? echo $responsaveis->telefoneddd;?>) <? echo $responsaveis->telefone;?></td>
                                                    <td><? echo $responsaveis->email;?></td>
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