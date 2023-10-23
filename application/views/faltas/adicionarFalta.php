<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/faltas/js/faltas.js"></script>

<?
	#Define Títulos Topo
	if($this->uri->segment(2)=="editar")
	{
		$tituloBase = "Editar Registros";
	} 
	else
	{
		$tituloBase = "Incluir Registros"; 
	}
?>
<script type="text/javascript">
$(document).ready(function() {
	getParametro();
	
	getEmpresaRegistro();

	$('#idCedente').change(function(){
		getFuncionario();
	});

	$('#idTipo').change(function(){
		getParametro();
	});
	
});
</script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5><?=$tituloBase;?></h5>
            </div>
            <div class="widget-content">
		    	<form class="form-inline" method="post" action="<?php echo current_url(); ?>">
				<?php 
                    if($this->uri->segment(2)=="editar"){
                        echo form_hidden('idFalta',$result->idFalta);
                    } 
                ?>
                <fieldset>
		    			<legend><i class="icon-plus icon-title"></i> Novo Registro</legend>
                        
						<div class="line">
							<label class="control-label">Tipo</label>
							<select class="input-xxlarge idTipo" name="idTipo" id="idTipo" style="width: 715px !important;">
							<option value="">Selecione o Tipo</option>
                            	<option style="height:35px; background-color: #CCCCCC;">TIPOS DE FALTAS</option>
                                <option value="896" <? if(isset($result) && $result->idTipo == 896) echo "selected"; ?>>Faltas Injustificadas</option>
                                <option value="897" <? if(isset($result) && $result->idTipo == 897) echo "selected"; ?>>Faltas Justificadas</option>
                                <option style="height:35px; background-color: #CCCCCC;">TIPOS DE ATRASOS</option>
                                <option value="899" <? if(isset($result) && $result->idTipo == 899) echo "selected"; ?>>Atrasos Injustificados / Saída Antecipada</option>
                                <option value="898" <? if(isset($result) && $result->idTipo == 898) echo "selected"; ?>>Atrasos Justificados / Saída Antecipada</option>
                                <option style="height:35px; background-color: #CCCCCC;">OUTROS</option>
                                <option value="939" <? if(isset($result) && $result->idTipo == 939) echo "selected"; ?>>Folga</option>
                                <option value="305" <? if(isset($result) && $result->idTipo == 305) echo "selected"; ?>>Afastamento</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Justificativa</label>
							<select class="input-xxlarge idParametro" name="idParametro" id="idParametro" role="<? if(isset($result)) echo $result->idParametro; ?>" style="width: 715px !important;">
							<option value="">Aguardando seleção de Tipo</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Empresa</label>
							<select class="input-xxlarge empresaRegistro" name="idCedente" id="idCedente" role="<? if(isset($result)) echo $result->idCedente; ?>" style="width: 715px !important;">
								<option value="">Aguardando seleção de Justificativa</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge idFuncionarioLista" name="idFuncionarioLista" id="idFuncionarioLista" role="<? if(isset($result)) echo $result->idFuncionario; ?>" style="width: 715px !important;">
								<option value="">Aguardando seleção de Empresa</option>
							</select>
						</div>
                        

						
						<div class="line">
							<label class="control-label">Data Solicitado</label>
							<input id="data_solicitado" class="input-small" style="width: 135px" name="data_solicitado" type="date" value="<? if(isset($result)) echo $result->data_solicitado; ?>" required="required">

							<label class="control-label">Data Cadastro</label>
							<input id="data_cadastro" class="input-small" style="width: 135px" name="data_cadastro" type="date" value="<? if(isset($result)) echo $result->data_cadastro; else echo date("Y-m-d"); ?>" required="required">

							<label class="control-label" style="width: 58px !important">Horários</label>
							<input id="hora_inicio" name="hora_inicio" class="input-small" type="time" required="required" value="<? if(isset($result) && $result->hora_inicio != '00:00:00') echo substr($result->hora_inicio, 0, 5); ?>" disabled>
                            <input id="hora_final" name="hora_final" class="input-small" type="time" required="required" value="<? if(isset($result) && $result->hora_final != '00:00:00') echo substr($result->hora_final, 0, 5); ?>" disabled>
                        </div>
                        
			
						<div class="line">
							<label class="control-label">Detalhes</label>
							<input class="input-large" style="width: 700px !important;" name="detalhes" value="<? if(isset($result->detalhes)){ echo $result->detalhes; } ?>" type="text">
						</div>
                        									    
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">
						<? if($this->uri->segment(2)=="editar"){ ?>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        <? } else { ?>
                            <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                        <? } ?>
                        <a href="<?php echo base_url() ?>faltas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
		    	</fieldset>
	    	</form>

                

             
        </div>
        
    </div>
</div>
</div>

	<script>
	
		function getParametro() {
			var id = $('#idTipo').val();
			$(".idParametro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>faltas/ajax/parametro/" + id,
				{idParametro:jQuery(id).val()},
				function(valor){
					 $(".idParametro").html(valor).after(function() {
							var role = $('#idParametro').attr('role');
							if (role != "")
								$('#idParametro option[value='+role+']').attr('selected', true).trigger('change');
							});
				}
			);

			var inputs = $('input[name="hora_inicio"], input[name="hora_final"]');
			if ($('#idTipo').val() == '899' || $('#idTipo').val() == '898') inputs.attr('disabled', false);
			else inputs.attr('disabled', true);
		}
		
		function getEmpresaRegistro() {
			var id = $('#idParametro').val();
			$(".empresaRegistro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>faltas/ajax/empresaregistro/",
				{empresaRegistro:jQuery(id).val()},
				function(valor){
					 $(".empresaRegistro").html(valor).after(function() {
						var role = $('#idCedente').attr('role');
						if (role != "")
							$('#idCedente option[value='+role+']').attr('selected', true).trigger('change');
						});
				}
			);
		}
		
		function getFuncionario() {
			var id = $('.empresaRegistro').val();
			$(".idFuncionarioLista").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>faltas/ajax/funcionario/"+id,
				{idFuncionarioLista:jQuery(id).val()},
				function(valor){
						
					 $(".idFuncionarioLista").html(valor).after(function() {
							var role = $('#idFuncionarioLista').attr('role');
							if (role != "")
								$('#idFuncionarioLista option[value='+role+']').attr('selected', true);
							});
				}
			);
		}
		
		/*var inputs = $('input[name="hora_inicio"], input[name="hora_final"]');
		$('#idTipo').on('change', function(){
			if (this.value == '899' || this.value=='898') inputs.removeAttr('disabled');
			else inputs.attr('disabled', 'true');
		});*/

	
	</script>