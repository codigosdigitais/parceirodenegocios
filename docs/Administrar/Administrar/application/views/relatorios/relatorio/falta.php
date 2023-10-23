
<?
	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "";
	} 
	else
	{
		$tituloBase = "Relatório de Faltas & Atrasos"; 
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
		    	<form class="form-inline" method="post" action="<?php echo base_url('relatorios/listarFalta'); ?>">
                <fieldset>

						<div class="line" style="margin-top: 15px;">
							<label class="control-label">Tipo</label>
							<select class="input-xxlarge idTipo" name="idTipo" id="idTipo" style="width: 715px !important;">
							<option value="">Selecione o Tipo</option>
                            	<option style="height:35px; background-color: #CCCCCC;">TIPOS DE FALTAS</option>
                                <option value="896">Faltas Injustificadas</option>
                                <option value="897">Faltas Justificadas</option>
                                <option style="height:35px; background-color: #CCCCCC;">TIPOS DE ATRASOS</option>
                                <option value="899">Atrasos Injustificados / Saída Antecipada</option>
                                <option value="898">Atrasos Justificados / Saída Antecipada</option>
                                <option style="height:35px; background-color: #CCCCCC;">OUTROS</option>
                                <option value="939">Folga</option>
                                <option value="305">Afastamento</option>
							</select>
						</div>
                        <!---
						<div class="line">
							<label class="control-label">Justificativa</label>
							<select class="input-xxlarge idParametro" name="idParametro" id="idParametro" onChange="getEmpresaRegistro()"  style="width: 715px !important;">
							<option value="">Aguardando seleção de Tipo</option>
							</select>
						</div>
                        --->
						<div class="line">
							<label class="control-label">Empresa</label>
							<select class="input-xxlarge empresaRegistro" name="idCedente" id="idCedente"  onChange="getFuncionario()" style="width: 715px !important;">
								<option value="">Selecione um Cedente</option>
                                <?
									foreach($listaCedente as $cedente){ 
								?>
                                	<option value="<? echo $cedente->idCedente; ?>"><? echo $cedente->razaosocial; ?></option>
                                <? } ?>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge idFuncionarioLista" name="idFuncionarioLista" id="idFuncionarioLista" style="width: 715px !important;">
								<option value="">Aguardando seleção de Empresa</option>
							</select>
						</div>
						
						<div class="line">
							<label class="control-label">Data Inicial</label>
							<input id="data_inicial" class="input-small" name="data_inicial" value="<? if($this->input->post('data_inicial')!=NULL){ echo $this->input->post('data_inicial');  } ?>" type="date" style="width: 150px;">
			
            				<label class="control-label">Data Final</label>
							<input id="data_final" class="input-small" name="data_final"  value="<? if($this->input->post('data_final')!=NULL){ echo $this->input->post('data_final');  } ?>" type="date" style="width: 150px;">				
						</div>
						<div style="padding-left: 105px; margin-bottom: 20px;">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-inverse span2" name="Filtro" value="acao"><i class="icon-print icon-white"></i> Filtrar</button>
                        </div>
		    	</fieldset>
	    	</form>

	        </div>
   	 	</div>
	</div>
</div>
<script type="text/javascript">
	

	
	function getFuncionario() {
		var id = $('.empresaRegistro').val();
		$(".idFuncionarioLista").append('<option value="0">Carregando...</option>');
		$.post("<? echo base_url(''); ?>faltas/ajax/funcionario/"+id,
			{idFuncionarioLista:jQuery(id).val()},
			function(valor){
				 $(".idFuncionarioLista").html(valor);
			}
		);
	}
		
</script>

