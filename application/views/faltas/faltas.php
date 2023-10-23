
<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>faltas/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</a> 
    <a href="<?php echo base_url();?>relatorios/faltas" class="btn btn-success"><i class="icon-plus icon-white"></i> Relatório</a>   
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Faltas</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Nenhuma falta Cadastrada</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Faltas & Atrasos</h5>
     </div>

<div id="Pesquisar" <? if(isset($_GET['razaosocial']) || isset($_GET['cnpj'])){ ?> <? } else { ?> style="display:block"<? } ?>>
		    	<form class="form-inline" method="post" action="<?php echo base_url('faltas/pesquisar'); ?>">
                <fieldset>

						<div class="line" style="margin-top: 15px;">
							<label class="control-label">Tipo</label>
							<select class="input-xxlarge idTipo" name="idTipo" id="idTipo" onChange="getParametro()" style="width: 715px !important;">
							<option value="">Selecione o Tipo</option>
                            	<option style="height:35px; background-color: #CCCCCC;">TIPOS DE FALTAS</option>
                                <option value="896,897">Todos os tipos de Faltas</option>
                                <option value="896">Faltas Injustificadas</option>
                                <option value="897">Faltas Justificadas</option>
                                <option style="height:35px; background-color: #CCCCCC;">TIPOS DE ATRASOS</option>
                                <option value="899,898">Todos os tipos de Atrasos</option>
                                <option value="899">Atrasos Injustificados / Saída Antecipada</option>
                                <option value="898">Atrasos Justificados / Saída Antecipada</option>
                                <option style="height:35px; background-color: #CCCCCC;">OUTROS</option>
                                <option value="939">Folga</option>
                                <option value="305">Afastamento</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Justificativa</label>
							<select class="input-xxlarge idParametro" name="idParametro" id="idParametro" onChange="getEmpresaRegistro()"  style="width: 715px !important;">
							<option value="">Aguardando seleção de Tipo</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Empresa</label>
							<select class="input-xxlarge empresaRegistro" name="idCedente" id="idCedente"  onChange="getFuncionario()" style="width: 715px !important;">
								<option value="">Aguardando seleção de Justificativa</option>
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge idFuncionarioLista" name="idFuncionarioLista" id="idFuncionarioLista" style="width: 715px !important;">
								<option value="">Aguardando seleção de Empresa</option>
							</select>
						</div>
						
                        <!---
						<div class="line">
							<label class="control-label">Referência</label>
                                <select name="periodo" id="periodo" onChange="removerDatas()" style="width: 715px !important;">
                                    <option value="">Selecione a Referência</option>
                                    <option value="1" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==1){ echo "selected"; } } ?>>Janeiro</option>
                                    <option value="2" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==2){ echo "selected"; } } ?>>Fevereiro</option>
                                    <option value="3" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==3){ echo "selected"; } } ?>>Março</option>
                                    <option value="4" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==4){ echo "selected"; } } ?>>Abril</option>
                                    <option value="5" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==5){ echo "selected"; } } ?>>Maio</option>
                                    <option value="6" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==6){ echo "selected"; } } ?>>Junho</option>
                                    <option value="7" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==7){ echo "selected"; } } ?>>Julho</option>
                                    <option value="8" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==8){ echo "selected"; } } ?>>Agosto</option>
                                    <option value="9" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==9){ echo "selected"; } } ?>>Setembro</option>
                                    <option value="10" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==10){ echo "selected"; } } ?>>Outubro</option>
                                    <option value="11" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==11){ echo "selected"; } } ?>>Novembro</option>
                                    <option value="12" <? if($this->input->post('periodo')!=NULL){ if($this->input->post('periodo')==12){ echo "selected"; } } ?>>Dezembro</option>
                                    </select>   
						</div>
                        ---->
                        
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




<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
        	<th style="width:50px"><center>ID</center></th>
            <th>Funcionário</th>
            <th>Tipo</th>
            <th>Justificativa</th>
            <th>Data</th>
            <th style="width: 150px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
			echo '<td><center>'.$r->idFalta.'</center></td>';
            echo '<td>'.$r->nomeFuncionario.'</td>';
            echo '<td>'.$r->nomeParametro.'</td>';
			echo '<td>'.$r->nomeJustificativa.'</td>';
            echo '<td>'.date("d/m/Y", strtotime($r->data_solicitado)).'</td>';
            echo '<td>';
            if($this->permission->canSelect()){
                echo '<a href="'.base_url().'faltas/visualizar/'.$r->idFalta.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'faltas/editar/'.$r->idFalta.'" style="margin-right: 1%" class="btn btn-info " title="Editar Falta"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" falta="'.$r->idFalta.'" style="margin-right: 1%" class="btn btn-danger" title="Excluir Falta"><i class="icon-trash icon-white"></i></a>'; 
            }

              
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php echo $this->pagination->create_links();}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>faltas/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir falta</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFalta" name="idFalta" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este falta?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
	   $(document).on('click', 'a', function(event) {
			var falta = $(this).attr('falta');
			$('#idFalta').val(falta);
		});
	});

	$(document).ready(function(){
		$(document).on('click', 'a', function(event) {
			var cliente = $(this).attr('cliente');
			$('#idCliente').val(cliente);
		});
	
		$( "#Pesquisar_Botao" ).click(function() {
			$("#Pesquisar").css("display","block");
		});	
	});
	
	function removerDatas() {
		$('[name="data_inicial"]').val($('[name="data_inicial"]').false);
		$('[name="data_final"]').val($('[name="data_final"]').false);
	}
	
	$(function(){
		$('#periodo').chosen({});
	});
	
		function getParametro() {
			var id = $('#idTipo').val();
			$(".idParametro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>faltas/ajax/parametro/" + id,
				{idParametro:jQuery(id).val()},
				function(valor){
					 $(".idParametro").html(valor);
				}
			);
		}
		
		function getEmpresaRegistro() {
			var id = $('#idParametro').val();
			$(".empresaRegistro").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>faltas/ajax/empresaregistro/",
				{empresaRegistro:jQuery(id).val()},
				function(valor){
					 $(".empresaRegistro").html(valor);
				}
			);
		}
		
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
		
		var inputs = $('input[name="hora_inicio"], input[name="hora_final"]');
		$('#idTipo').on('change', function(){
			if (this.value == '899' || this.value=='898') inputs.removeAttr('disabled');
			else inputs.attr('disabled', 'true');
		});



</script>




