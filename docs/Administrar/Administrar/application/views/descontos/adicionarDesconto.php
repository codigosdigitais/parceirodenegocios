<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/descontos/js/descontos.js"></script>

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                    <i class="icon-tags"></i>
                    </span>
                    <h5><? echo $parametro_selecionado->parametro; ?></h5>
                </div>
                <div class="widget-content">
                	
                    <form class="form-inline" method="post" action="<?php echo current_url(); ?>/conferir">
                    	<fieldset>
                            <div class="line">
                                <label class="control-label">Registro</label>
                                <select class="input-xxlarge empresaRegistro" name="empresaRegistro" id="empresaRegistro" style="width: 715px !important;" onChange="getFuncionario()">
                                	<option value="">Selecione a Empresa</option>
                                    <?
										foreach($lista_cedente as $valor){
									?>
                                    	<option value="<? echo $valor->idCedente; ?>"><? echo $valor->razaosocial; ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Funcionário</label>
                                <select class="input-xxlarge idFuncionarioLista" name="idFuncionarioLista" id="idFuncionarioLista" style="width: 715px !important;">
                                <option value="">Aguardando seleção de Registro</option>
                                </select>
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Base de Cáculo</label>
                               	<input id="base_calculo" class="span2" type="text" name="base_calculo" placeholder="0.0%"  />
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Referência</label>
                                    <select name="referencia" id="referencia">
                                        <option>Selecione a Referência</option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>                               	
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Data</label>
                               	<input id="data" class="span3" type="date" name="data"/>
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Valor</label>
                               	<input id="valor" class="span2" type="text" name="valor" placeholder="0.00"/>
                            </div>
                            
                            <div class="line">
                                <label class="control-label">Detalhes</label>
                               	<input id="detalhes" class="span8" type="text" name="detalhes"/>
                            </div>
                            
                            <div class="span12" style="padding: 1%; margin-left: 0">
                                <div class="span6 offset3" style="text-align: center">
                                        <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Conferir Registros</button>
                                    <a href="<?php echo base_url() ?>descontos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                </div>
                            </div>
                            
                        </fieldset>
                    </form>
                    
                    
                            <tr>
                                
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

<script>
		function getFuncionario() {
			var id = $('#empresaRegistro').val();
			$(".idFuncionarioLista").append('<option value="0">Carregando...</option>');
			$.post("<? echo base_url(''); ?>descontos/ajax/funcionario/"+id,
				{idFuncionarioLista:jQuery(id).val()},
				function(valor){
					 $(".idFuncionarioLista").html(valor);
				}
			);
		}
		
$('#base_calculo').on('blur', function(){
    var valor = $(this).val();
    valor = valor.replace(',','.');
    if(!$.isNumeric(valor)) return;
    valor += '%';
    $(this).val(valor);
});

</script>
