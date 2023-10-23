<?php 
$Cliente = array_shift( $this->data['result'] );
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#btnAddEndereco').click(function() {
		var model = $('#servicosTable tr:first').clone(true, true);
		$(model).find('input').val('');
		$(model).find('.selectBairro').html('');
		$('#servicosTable').append(model);

		$(model).find('.btn-remover-endereco').show();

		$('#servicosTable select[name="cham_tiposervico[]"]:not(:first) option[value="0"]').remove();
	});

	$('.btn-alterar-servico').click(function(){
		$('.form-itinerario').show();
		$('#btn-novo-itinerario').hide();

		var line = $(this).parent().parent();
		var id = line.find('#idClienteFreteItinerario').val();
		var nome = line.find('td:eq(1)').html();
		var val_emp = line.find('#valor_empresa').val();
		var val_fun = line.find('#valor_funcionario').val();
		var tipo_veiculo = line.find('#tipo_veiculo').val();
		var retorno = (line.find('#retorno').val() == 0) ? false : true;

		$('.form-itinerario #idClienteFreteItinerario').val(id);
		$('.form-itinerario #nome_itinerario').val(nome);
		$('.form-itinerario #valor_empresa_itinerario').val(val_emp);
		$('.form-itinerario #valor_funcionario_itinerario').val(val_fun);
		$('.form-itinerario #tipo_veiculo').val(tipo_veiculo);

		$('.form-itinerario #retornar-origem').prop('checked', retorno);

		var servicosJson = JSON.parse( $('#div-itinerario-servicos').html() );

		$('#servicosTable tr').find('input').val('');
		$('#servicosTable tr').find('.selectBairro').html('');
		
		var lineServico = $('#servicosTable tr:first').clone(true, true);
		$(lineServico).find('input').val('');
		$(lineServico).find('.selectBairro').html('');
		
		$('#servicosTable tr').remove();
		
		$.each(servicosJson, function(key, value) {
			if (value.idClienteFreteItinerario == id) {
				lineServico = $(lineServico).clone(true, true);

				lineServico.find('input[name="cham_idClienteFreteItinerarioServico[]"]').val(value.idClienteFreteItinerarioServico);
				lineServico.find('select[name="cham_tiposervico[]"]').val(value.tiposervico);
				lineServico.find('input[name="cham_endereco[]"]').val(value.endereco);
				lineServico.find('input[name="cham_numero[]"]').val(value.numero);
				lineServico.find('select[name="cham_cidade[]"]').val(value.cidade).trigger('change');
				lineServico.find('select[name="cham_bairro[]"]').attr('rule', value.bairro);
				lineServico.find('input[name="cham_falarcom[]"]').val(value.falarcom);

				$('#servicosTable').append(lineServico);
			}
		});

		$('#servicosTable tr:gt(0)').find('.btn-remover-endereco').show();
	});

	$('.btn-remover-servico').click(function(){
		var id = $(this).attr('role');
		$('#modal-remover-itinerario #idClienteFreteItinerario').val(id);
	});

	$('#btn-cancelar-itinerario').click(function(){
		$('#form-itinerario').find('input:not(#idClienteFrete), select').val('');
		$('#servicosTable tr').find('input, select').val('');
		$('#servicosTable tr').find('.selectBairro').html('');
		$('#servicosTable tr:not(:first)').remove();
		
		$('.form-itinerario').hide();
		$('#btn-novo-itinerario').show();
	});
	
	$('.btn-remover-endereco').click(function(){
		if ( $('#servicosTable tr').length > 2 ) {
			$(this).parent().parent().remove();
		};
	});

	$('#btn-novo-itinerario').click(function() {
		$('.form-itinerario').show();
		$(this).hide();
		$('#btnAddEndereco').trigger('click');
	});
	
	$('#btn-nova-vigencia').click(function(){
		if ( $('#vigencia_inicial').val() == "" || $('#vigencia_final').val() == "") {
			mostrarMensagemAlertaTopoPagina('error', 'Para criar uma nova vigência, primeiramente informe a data final da vigência atual.')
		}
		else {
			$('#novaCompetencia').prop('checked', true);
			$('#form-update-tabela').submit();
		}
	});

	$('.selectCidade').change(function(){
		getSelectCidade(this);
	});
});

function getSelectCidade(obj){
	if ($(obj).val() != '') {
	    var selectBairro = jQuery(obj).parents('tr').find('select.selectBairro');
	    selectBairro.html('<option value="0">Carregando...</option>');
	    $.post("/Administrar/bairros.ajax.php",
	        {cidade:jQuery(obj).val()},
	        function(valor){
	            selectBairro.html(valor).after(function(){
	            	if (selectBairro.attr('rule')) {
	            		idBairro = selectBairro.attr('rule');
	            		selectBairro.val(idBairro);
	            		selectBairro.removeAttr('rule');
	            	}
	            });
	        }
	    );
	}
}
</script>

<style>
.form-itinerario, #div-itinerario-servicos{display: none;}
.inline-bloc{display: inline-block;margin-right: 21px;}
.inline-bloc label{width: auto !important;display: block;text-align: left;}
.div-itinerarios{margin-bottom: 30px;}
#form-itinerario .div-buttons {width: 100%; text-align: right;margin: 5px 0 0 0;}
#form-itinerario .div-buttons button{margin-right: 2px;}
#btn-novo-itinerario{margin-bottom: 30px;}
.div-itinerarios table td, .div-itinerarios table th{text-align: right;}
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar Vigência Atual: <?php echo $Cliente->nomefantasia; ?></h5>
            </div>
            <div class="widget-content">
                
			    <fieldset>
			    <?php if ($this->session->userdata('tipo') == 'SISAdmin' || $this->session->userdata('tipo') == 'Interno') { ?>
				<legend class="form-title"><i class="icon-list-alt icon-title"></i> Vigência</legend>
				    <form class="form-inline" id="form-update-tabela" method="post" action="<?php echo base_url('tabelafretecliente/gravartabela'); ?>">
		    		<input type="hidden" name="idClienteFrete" value="<?php echo $Cliente->idClienteFrete; ?>" >
		
					<div class="line">
						
						<label class="control-label" style="width: 75px !important;">Inicial</label>
						<input class="input-large mascara_data datepicker" type="text" maxlength="10" minlength="10" required="required" placeholder="__/__/____" name="vigencia_inicial" id="vigencia_inicial" value="<?php echo conv_data_YMD_para_DMY($Cliente->vigencia_inicial); ?>" >
					
						<label class="control-label" style="width: 75px !important;">Final</label>
						<input class="input-large mascara_data datepicker" type="text" maxlength="10" minlength="10" placeholder="__/__/____" name="vigencia_final" id="vigencia_final" value="<?php echo conv_data_YMD_para_DMY($Cliente->vigencia_final); ?>" >
					</div>
					
					<legend class="form-title"><i class="icon-list-alt icon-title"></i> Valores de Frete</legend>
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Moto</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_normal" value="<? if(isset($result[0]->valor_moto_normal)){ echo conv_monetario_br($result[0]->valor_moto_normal); } ?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_metropolitano" value="<? if(isset($result[0]->valor_moto_metropolitano)){ echo conv_monetario_br($result[0]->valor_moto_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_depois_18" value="<? if(isset($result[0]->valor_moto_depois_18)){ echo conv_monetario_br($result[0]->valor_moto_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_moto_km" value="<? if(isset($result[0]->valor_moto_km)){ echo conv_monetario_br($result[0]->valor_moto_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_moto_metropolitano_apos18" value="<? if(isset($result[0]->valor_moto_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_moto_metropolitano_apos18); } ?>" >
					</div>
					
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Carro</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_normal" value="<? if(isset($result[0]->valor_carro_normal)){ echo conv_monetario_br($result[0]->valor_carro_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_metropolitano" value="<? if(isset($result[0]->valor_carro_metropolitano)){ echo conv_monetario_br($result[0]->valor_carro_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_depois_18" value="<? if(isset($result[0]->valor_carro_depois_18)){ echo conv_monetario_br($result[0]->valor_carro_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_carro_km" value="<? if(isset($result[0]->valor_carro_km)){ echo conv_monetario_br($result[0]->valor_carro_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_carro_metropolitano_apos18" value="<? if(isset($result[0]->valor_carro_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_carro_metropolitano_apos18); } ?>" >
					</div>
                    
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Van</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_normal" value="<? if(isset($result[0]->valor_van_normal)){ echo conv_monetario_br($result[0]->valor_van_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_metropolitano" value="<? if(isset($result[0]->valor_van_metropolitano)){ echo conv_monetario_br($result[0]->valor_van_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_depois_18" value="<? if(isset($result[0]->valor_van_depois_18)){ echo conv_monetario_br($result[0]->valor_van_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_van_km" value="<? if(isset($result[0]->valor_van_km)){ echo conv_monetario_br($result[0]->valor_van_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_van_metropolitano_apos18" value="<? if(isset($result[0]->valor_van_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_van_metropolitano_apos18); } ?>" >

					</div>
                    
					<div class="line">
						<label class="control-label" style="width: 75px !important;">Caminhão</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_normal" value="<? if(isset($result[0]->valor_caminhao_normal)){ echo conv_monetario_br($result[0]->valor_caminhao_normal); } ;?>" >
						
						<label class="control-label" style="width: 60px !important;">Metrop.</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_metropolitano" value="<? if(isset($result[0]->valor_caminhao_metropolitano)){ echo conv_monetario_br($result[0]->valor_caminhao_metropolitano); } ;?>" >
					
						<label class="control-label">Depois 18hs</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_depois_18" value="<? if(isset($result[0]->valor_caminhao_depois_18)){ echo conv_monetario_br($result[0]->valor_caminhao_depois_18); } ;?>" >
						
						<label class="control-label" style="width: 30px !important;">KM</label>
						<input class="input-small right money mascara_reais" style="width: 75px !important;" type="text" placeholder="0,00" name="valor_caminhao_km" value="<? if(isset($result[0]->valor_caminhao_km)){ echo conv_monetario_br($result[0]->valor_caminhao_km); } ;?>" >
                        
                    <label class="control-label">M. Após 18hs</label>
                    <input class="input-small right money mascara_reais" style="width: 60px !important;" placeholder="0.00" type="text" name="valor_caminhao_metropolitano_apos18" value="<? if(isset($result[0]->valor_caminhao_metropolitano_apos18)){ echo conv_monetario_br($result[0]->valor_caminhao_metropolitano_apos18); } ?>" >

					</div>
                    
				
					<div class="line"></div>
					
				    <input type="checkbox" id="novaCompetencia" name="novaCompetencia" style="display: none;">
					<div class="button-form line">										    
                        <div class="span6 offset3" style="text-align: center">

                            <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                        	
                        	<button type="button" class="btn btn-primary btn-remover-form" id="btn-remover-form" style="margin-left:10px;">
                            		<i class="icon-trash"></i> Remover</button>
                            		
                            <button type="button" class="btn btn-success" id="btn-nova-vigencia"><i class="icon-plus icon-white"></i> Nova Vigência</button>
                            
                        	<a href="<?php echo base_url() ?>tabelafretecliente" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                        </div>
				    </div>
				    
		    		</form>
		    	<?php } ?>
		    	<legend class="form-title"><i class="icon-list-alt icon-title"></i> Itinerários</legend>
						
						<div class="div-itinerarios">
						
							<table class="table table-striped" style="width: 900px">
                            	<thead>
		                            <tr>
			                            <th style="text-align:left;">Nome</th>
			                            <th>Val. Empresa</th>
			                            <th>Val. Funcionário</th>
			                            <th>Veículo</th>
			                            <?php if ($this->session->userdata('tipo') == 'SISAdmin' || $this->session->userdata('tipo') == 'Interno') { ?>
			                            <th>Retorno</th>
			                            <th style="width: 104px;text-align: center;">Ações</th>
			                            <?php } ?>
		                            </tr>
	                            </thead>
	                        	<tbody>
						<?php 
							if (!$listaItinerarios)
								echo '<td colspan="6">Nenhum itinerário cadastrado</td>';
							else {
								$idItinerarioAtual = -1;
								$arr_servicos = array();
								$a = 0;
								
								foreach ($listaItinerarios as $itinerario) {
									
									if ($idItinerarioAtual != $itinerario->idClienteFreteItinerario) {
										$idItinerarioAtual = $itinerario->idClienteFreteItinerario;

										echo '<tr>';
										echo '<td style="display:none;">';
										echo '<input type="hidden" id="idClienteFreteItinerario" value="'.$itinerario->idClienteFreteItinerario.'">';
										echo '</td>';
										
										echo '<td style="text-align:left;">' .$itinerario->nome . '</td>';
										
										echo '<td>';
										echo '<input type="hidden" id="valor_empresa" value="'.conv_monetario_br($itinerario->valor_empresa).'">';
										echo 'R$ ' . conv_monetario_br($itinerario->valor_empresa) . '</td>';
										
										echo '<td>';
										echo '<input type="hidden" id="valor_funcionario" value="'.conv_monetario_br($itinerario->valor_funcionario).'">';
										echo 'R$ ' . conv_monetario_br($itinerario->valor_funcionario) . '</td>';
										
										echo '<td>';
										echo '<input type="hidden" id="tipo_veiculo" value="'.$itinerario->tipo_veiculo.'">';
										echo $itinerario->nomeTipoVeiculo . '</td>';
										

										if ($this->session->userdata('tipo') == 'SISAdmin' || $this->session->userdata('tipo') == 'Interno') {
											echo '<td>';
											echo '<input type="hidden" id="retorno" value="'.$itinerario->retorno.'">';
											echo  $itinerario->nomeRetorno . '</td>';
										
											echo '<td>';
											echo '<button class="btn btn-alterar-servico" type="button"><i class="icon-pencil icon-white"></i> Alterar</button>';
											echo '<button class="btn btn-remover-servico" type="button" data-toggle="modal" data-target="#modal-remover-itinerario" role="'.$itinerario->idClienteFreteItinerario.'"><i class="icon-trash"></i></button>';
											echo '</td>';
										}
										echo '</tr>';
									}
									
									//armazena serviços (endereços) para possibilitar alteração do registro
									$servico['idClienteFreteItinerarioServico'] = $itinerario->idClienteFreteItinerarioServico;
									$servico['idClienteFreteItinerario'] = $itinerario->idClienteFreteItinerario;
									$servico['tiposervico'] = $itinerario->tiposervico;
									$servico['endereco'] = $itinerario->endereco;
									$servico['numero'] = $itinerario->numero;
									$servico['bairro'] = $itinerario->bairro;
									$servico['cidade'] = $itinerario->cidade;
									$servico['falarcom'] = $itinerario->falarcom;
									$arr_servicos[$a] = $servico;
									
									$a++;
								}
							}
						?>
								</tbody>
							</table>
							<div id="div-itinerario-servicos">
							<?php if (isset($arr_servicos)) echo json_encode($arr_servicos); ?>
							</div>
						</div>


						<form class="form-inline form-itinerario" id="form-itinerario" method="post" action="<?php echo base_url('tabelafretecliente/gravaritinerario'); ?>">
							<input type="hidden" id="idClienteFrete" name="idClienteFrete" value="<?php echo $Cliente->idClienteFrete; ?>" >
							<h4><i class="icon-plus icon-title"></i> Novo Itinerário</h4>
						
							<div class="inline-bloc">
								<input type="hidden" id="idClienteFreteItinerario" name="idClienteFreteItinerario">
							
								<label for="nome_itinerario">Nome</label>
								<input type="text" id="nome_itinerario" name="nome_itinerario" class="input-xlarge" required="required">
							</div>
							<?php if ($this->session->userdata('tipo') == 'SISAdmin' || $this->session->userdata('tipo') == 'Interno') { ?>
							<div class="inline-bloc">
								<label for="valor_empresa_itinerario">Valor Empresa</label>
								<input type="text" id="valor_empresa_itinerario" name="valor_empresa_itinerario" class="input-small mascara_reais" required="required">
							</div>
							<div class="inline-bloc">
								<label for="valor_funcionario_itinerario">Val. Funcionário</label>
								<input type="text" id="valor_funcionario_itinerario" name="valor_funcionario_itinerario" class="input-small mascara_reais" required="required">
							</div>

                            <?php } ?>
							<div class="inline-bloc">
								<label for="tipo_veiculo">Veiculo</label>
	                            <select class="input-medium" id="tipo_veiculo" name="tipo_veiculo" required="required">
	                                <option value="1">Base - Moto</option>
	                                <option value="2">Médio - Carro</option>
	                                <option value="3">Intermediário - Van</option>
	                                <option value="4">Grande Porte - Caminhão</option>
	                            </select>
							</div>
                            
                        
                        	<div style="width: 900px;">
         						<div style="margin: 20px 0 0 0;">
                                	<table class="table table-striped" style="display: inline;">
                                    	<thead>
	                                        <tr>
	                                            <th>Tipo</th>
	                                            <th>Endereço</th>
	                                            <th>Número</th>
	                                            <th>Cidade</th>
	                                            <th>Bairro</th>
	                                            <th>Falar com</th>
	                                            <th></th>
	                                        </tr>
	                                    </thead>
	                                    <tbody id="servicosTable" style="width: 898px;">
                                            <tr>
                                                <td style="line-height: 10px !important;">
                                                	<input type="hidden" name="cham_idClienteFreteItinerarioServico[]">
                                               
                                                    <select class="input-small" name="cham_tiposervico[]" required="required">
                                                        <option value="0" selected >Coleta</option>
                                                        <option value="1"  >Entrega</option>
                                                    </select>
                                                </td>
                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                    <input class="input-small" style="width: 222px !important;" type="text" name="cham_endereco[]" value="" required="required">
                                                </td>
                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                    <input class="input-small" style="width: 50px !important;" type="text" name="cham_numero[]" value="" required="required">
                                                </td>
                                                <td style="line-height: 10px !important;  font-size: 12px !important;">
                                                    
                                                    <select class="input-small selectCidade" name="cham_cidade[]" id="cham_cidade[]" style="width: 184px;" required="required">
                                                    	<option value=""></option>
                                                        <? foreach($this->data['listaCidade'] as $cidade){ ?>
                                                        <option value="<? echo $cidade->idCidade; ?>"><? echo $cidade->cidade; ?></option>
                                                        <? } ?>
                                                    </select>
                                                </td>
                                                <td style="line-height: 15px !important; font-size: 12px !important;">
                                                   <select class="input-small selectBairro" name="cham_bairro[]" id="cham_bairro[]" style="width: 160px;" required="required">
                                                   		<option value=""></option>
                                                    </select>
                                                </td>
                                                <td style="line-height: 15px !important; font-size: 12px !important;">
                                                    <input class="input-small" type="text" name="cham_falarcom[]" value="">
                                                </td>
                                                <td>
                                                    <button class="btn btn-remover-endereco" type="button" style="padding: 3px; width: 32px !important;display: none;"><i class="icon-trash"></i></button>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
								<div style="float:left;margin-top: 4px;">
									<input type="checkbox" name="retornar-origem" id="retornar-origem">
									<label for="retornar-origem" style="width:250px !important;text-align: left;vertical-align: sub;margin-left: 4px;">Retornar à origem ao final</label>
								</div>
                                <div class="div-buttons">
                                	<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Gravar</button>
                                	<button type="button" id="btn-cancelar-itinerario" class="btn btn-default"><i class="icon-ok icon-white"></i> Cancelar</button>
                            		<button id="btnAddEndereco" class="btn btn-small" type="button"><i class="icon-plus-sign"></i> Adicionar Serviço</button>
                            	</div>
							</div>
                        </div>
					</form>
					
					<button id="btn-novo-itinerario" type="button" class="btn btn-primary"><i class="icon-ok icon-white"></i> Novo itinerário</button>
					
					<?php if ($this->session->userdata('tipo') == 'SISAdmin' || $this->session->userdata('tipo') == 'Interno') { ?>
					<legend class="form-title"><i class="icon-list-alt icon-title"></i> Histórico de Valores</legend>
				    
						<table class="table table-striped table-frete-cliente">
							<thead>
								<tr>
									<th rowspan="2">Vigência</th>
									<th colspan="5">Moto</th>
									<th colspan="5">Carro</th>
									<th colspan="5">Van</th>
									<th colspan="5">Caminhão</th>
								</tr>
								<tr>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
							        <th class="textOnVertical">Normal</th>
							        <th class="textOnVertical">Metrop</th>
							        <th class="textOnVertical">Após 18h</th>
							        <th class="textOnVertical">Km</th>
							        <th class="textOnVertical">Km Ap.18h</th>
								</tr>
				    <?php 
				    if (0 < count($historico)) {
						foreach ($historico as $h) { 
							
							echo "<tr>";
							echo "<td style='text-align:left;font-weight:bold;'>";
							echo '<a href="'. base_url("tabelafretecliente/editar/" . $h->idClienteFrete) .'">';
							echo conv_data_YMD_para_DMY($h->vigencia_inicial) . " ";
							echo ($h->vigencia_final != "") ? "à ".conv_data_YMD_para_DMY($h->vigencia_final) : "(atual)";
							echo "</a></td>";
							echo "<td>". conv_monetario_br($h->valor_moto_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_moto_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_carro_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_carro_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_van_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_van_metropolitano_apos18) ."</td>";

							echo "<td>". conv_monetario_br($h->valor_caminhao_normal) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_metropolitano) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_depois_18) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_km) ."</td>";
							echo "<td>". conv_monetario_br($h->valor_caminhao_metropolitano_apos18) ."</td>";
							echo "<tr>";
							
						}
				    }
				    ?>
				    		</thead>
				    	</table>
				    <?php } ?>
				    
		    	</fieldset>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){
		
					$('#btn-remover-form').click(function(){
						$( "#dialog-remove-cliente" ).dialog( "open" );
					});
					
					$( "#dialog-remove-cliente" ).dialog({
					  autoOpen: false,
					  modal: true,
					  width: 500,
					  heigth: 500,
					  buttons: {
						"Remover": {
							text: 'Remover Tabela',
							click: function() {
								$(".ui-dialog-buttonpane button:contains('Remover Tabela')").attr("disabled", true).addClass("ui-state-disabled");
								$('#form-remover-tabela').submit();
							}
						},
						"Retornar": function() {
							$( this ).dialog( "close" );
						}
					  }
					});
					
				});
			</script>
			<div id="dialog-remove-cliente" title="Selecione um cliente" style="display:none">
	        	<form id="form-remover-tabela" method="post" action="<?php echo base_url('tabelafretecliente/removertabela'); ?>">
	        		<input type="hidden" name="idClienteFrete" value="<?php echo $Cliente->idClienteFrete; ?>" >
	        		
	        		<div class="">
	        			Deseja realmente remover esta tabela de fretes?
	        		</div>
	        	</form>
	        </div>
    </div>
	    
	<div id="modal-remover-itinerario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <form action="<?php echo base_url(); ?>tabelafretecliente/remover_itinerario" method="post" >
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h5 id="myModalLabel">Remover Itinerário</h5>
	  </div>
	  <div class="modal-body">
	  	<input type="hidden" name="idClienteFrete" value="<?php echo $Cliente->idClienteFrete; ?>" >
	    <input type="hidden" id="idClienteFreteItinerario" name="idClienteFreteItinerario" value="" />
	    <h5 style="text-align: center">Deseja realmente remover este itinerário?</h5>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	    <button class="btn btn-danger">Excluir</button>
	  </div>
	  </form>
	</div>
</div>
</div>