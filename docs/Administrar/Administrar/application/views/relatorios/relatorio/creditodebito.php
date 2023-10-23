<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/contratos/js/contratos.js"></script>

<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "";
	} 
	else
	{
		$tituloBase = "Relatório de Crédito e Débito"; 
	}
?>

<div class="row-fluid" style="margin-top:-10px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content">
                   <form class="form-inline" id="frm" method="post" action="listarCreditoDebito">
                        <fieldset>
                            <legend><i class="icon-search icon-title"></i> Pesquisar Crédito & Débito</legend>
							
                            <div class="line">
                                <label class="control-label">Método</label>
                                <select class="input-xxlarge metodo" name="metodo" id="metodo" style="width: 715px !important;" >
                                    <option value="">Selecione</option>							
                                    <option value="1">Cliente</option>							
                                    <option value="2">Funcionário</option>							
                                </select>
                            </div>								
							
                            <div class="line">
                                <label class="control-label">Tipo de Adicional</label>
                                <select class="input-xxlarge tipo_operacao" name="tipo_operacao" id="tipo_operacao" style="width: 715px !important;" onChange="getTipo()">
                                    <option value="">Selecione</option>							
                                    <option value="812">Crédito</option>							
                                    <option value="813">Débito</option>							
                                    <option value="-1">Todos</option>							
                                </select>
                            </div>	

							<div class="line">
                                <label class="control-label">Tipo </label>
                                <select class="input-xxlarge tipo" name="tipo" id="tipo" style="width: 715px !important;">
                                    <option value="">Aguardando seleção do Tipo Adicional</option>															
                                </select>
                            </div>
							                           
                            <div class="line">
                                <label class="control-label">Nome</label>
                                <select class="input-xxlarge idAdministrativo" name="idAdministrativo" id="idAdministrativo" style="width: 715px !important;">
                                    <option value="">Aguardando seleção do Método</option>
                                    						
                                </select>
                            </div>		

							<div class="line">
                                <label class="control-label">Data Inicial</label>
                                <input id="data_inicial" class="input-small" name="data_inicial" value="<? if($this->input->post('data_inicial')!=NULL){ echo $this->input->post('data_inicial');  } ?>" type="date" style="width: 150px;">
                
                                <label class="control-label">Data Final</label>
                                <input id="data_final" class="input-small" name="data_final"  value="<? if($this->input->post('data_final')!=NULL){ echo $this->input->post('data_final');  } ?>" type="date" style="width: 150px;">				
                            </div>
                            
                            <legend style="position: relative; top: 12px;"></legend>

                            <div class="button-form line">										    
                                <div class="span6 offset3" style="text-align: center">
                                    <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Pesquisar</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
	        </div>
   	 	</div>
	</div>
</div>
<script type="text/javascript">
	function getTipo() {
		var tipo = $('.tipo_operacao').val();
		var metodo = $('.metodo').val();
		
		$(".tipo").append('<option value="0">Carregando...</option>');
		$.post("<? echo base_url(''); ?>relatorios/ajax/tipo/"+tipo,
			{tipo:jQuery(tipo).val()},
			function(valor){
				 $(".tipo").html(valor);
			}
		);
		
		$(".idAdministrativo").append('<option value="0">Carregando...</option>');
		$.post("<? echo base_url(''); ?>relatorios/ajax/idadministrativo/"+metodo,
			{idAdministrativo:jQuery(idAdministrativo).val()},
			function(valor){
				 $(".idAdministrativo").html(valor);
			}
		);		
	}		
</script>

