<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Provento";
	} 
	else
	{
		$tituloBase = "Relatório de Clientes"; 
	}
?>

<div class="row-fluid" style="margin-top:-35px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content">
                   <form class="form-inline" id="frm" method="post" action="listarCliente">
                        <fieldset>
                            <legend><i class="icon-search icon-title"></i> Pesquisar Clientes</legend>
                            
                            <div class="line">
                                <label class="control-label">Razão Social</label>
                                <input class="input-xxlarge" type="text" placeholder="Razão Social" name="razaosocial_busca">
                            </div>				    	
                            
                            <div class="line">
                                <label class="control-label">CNPJ</label>
                                <input class="input-xxlarge" type="text" placeholder="CNPJ" name="cnpj_busca">
                            </div>				    	
                            
                            <div class="line">
                                <label class="control-label">Email</label>
                                <input class="input-xxlarge" type="text" placeholder="Email" name="email_busca">
                            </div>
                            
                            <legend style="position: relative; top: 12px;"></legend>
                            
                            <div class="line">
                            

                                            
                                            
                                    <ul class="quick-actions">
                                        <li class="bg_lo" style="background-color: #C02028 !important"> 
                                            <a href=""> 
                                                <i class="icon-group"></i> 
                                                <input style="position: relative; top: -1px; width: 80px; " type="radio" value="dados_empresa" name="campo[]">
                                                <br>Dados da <br>Empresa
                                            </a> 
                                        </li>
                                        
                                        <li class="bg_lo" style="background-color: red !important"> 
                                            <a href=""> 
                                                <i class="icon-group"></i> 
                                                <input style="position: relative; top: -1px; width: 80px; " type="radio" value="dados_faturamento" name="campo[]">
                                                <br>Dados de <br>Faturamento
                                            </a> 
                                        </li>
                                        
                                        <li class="bg_lo" style="background-color: black !important"> 
                                            <a href=""> 
                                                <i class="icon-group"></i> 
                                                <input style="position: relative; top: -1px; width: 80px; " type="radio" value="contatos_empresa" name="campo[]">
                                                <br>Contatos <br>Empresa
                                            </a> 
                                        </li>
                                        
                                        <li class="bg_lo" style="background-color: blue !important"> 
                                            <a href=""> 
                                                <i class="icon-group"></i> 
                                                <input style="position: relative; top: -1px; width: 80px; " type="radio" value="situacao" name="campo[]">
                                                <br>Situação de <br>Clientes
                                            </a> 
                                        </li>
                                        
                                        <li class="bg_lo" style="background-color: purple !important"> 
                                            <a href=""> 
                                                <i class="icon-group"></i> 
                                                <input style="position: relative; top: -1px; width: 80px; " type="radio" value="dados_frete" name="campo[]">
                                                <br>Tabela de <br>Frete
                                            </a> 
                                        </li>
                                        
   
                                    </ul>
                                    
                            
                            <!----
                            
                                <label class="control-label"></label>
                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    Dados da Empresa
                                </label>

                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    <input style="position: relative; top: -1px;" type="radio" value="empresa_endereco" name="campo[]"> Endereço da Empresa
                                </label>
                                
                                
                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    <input style="position: relative; top: -1px;" type="radio" value="setores" name="campo[]"> Responsáveis por Setores
                                </label>                                
                            </div>
                            
                            <div class="line">
                                <label class="control-label"></label>
                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    <input style="position: relative; top: -1px;" type="radio" value="faturamento_dados" name="campo[]"> Dados de Faturamento
                                </label>

                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    <input style="position: relative; top: -1px;" type="radio" value="faturamento_endereco" name="campo[]"> Endereço de Faturamento
                                </label>

                            </div>
                            
                            <div class="line">
                                <label class="control-label"></label>
                                <label class="checkbox" style="width: 225px !important; text-align: left;">
                                    <input style="position: relative; top: -1px;" type="radio" value="status" name="campo[]"> Status
                                </label>

                            </div>                            
                            ---->
                            
                            <div class="button-form line">										    
                                <div class="span6 offset3" style="text-align: center">

                                    <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Pesquisar</button>
                                </div>
                            </div>
                            </div>
                        </fieldset>
                    </form>
	        </div>
   	 	</div>
	</div>
</div>

