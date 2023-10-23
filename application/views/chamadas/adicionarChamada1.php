<!-- zomm nas imagens fancybox -->
<script type="text/javascript" src="<?php echo base_url()?>/js/fancybox/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/js/fancybox/jquery.fancybox.css" media="screen" />
<style>
    .select2-search__field {
        padding: 19px !important;
    }
</style>
<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/chamadas/js/chamadas.js?3"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $("a[rel=zoom]").fancybox({
            'overlayShow'	: false,
            'transitionIn'	: 'elastic',
            'transitionOut'	: 'elastic',
            'titlePosition' 	: 'over',
            'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Imagem ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
        });
    })
</script>

<?

	#Define Títulos Topo
	if($this->router->method=="editar")
	{
		$tituloBase = "Editar Chamada";
	} 
	else
	{
		$tituloBase = "Cadastro de Chamada"; 
	}

    #echo "<pre>";
    #print_r($result);
    #die();
?>
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
                    if($this->router->method=="editar"){
                        $tituloIcone = "Editar Chamada";
                        echo form_hidden('idChamada',$result->idChamada);
                        echo form_hidden('tarifa',$result->tarifa);
                        echo form_hidden('valor_empresa',$result->valor_empresa);
                        echo form_hidden('valor_funcionario',$result->valor_funcionario);
                        echo form_hidden('solicitante',$result->solicitante);
                        echo form_hidden('tipo_veiculo',$result->tipo_veiculo);
                        echo form_hidden('idCliente',$result->idCliente);
                        echo form_hidden('pontos',$result->pontos);
                        
                    } else {
                        $tituloIcone = "Nova Chamada";	
                    }
                ?>
                
                <input type="hidden" name="codigo" value="-1" />
                <input type="hidden" name="valor_manual" value="false" />
            
                <fieldset>
                    <legend><i class="icon-plus icon-title"></i> <? echo $tituloIcone; ?></legend>

                        <div class="line" style="height: 70px;">
                            <label class="control-label">Chamada</label>
                            <span class="label label-inverse" style="width: 76px; text-align: center; position: relative; top: 5px; padding: 14px; font-weight: 200; font-size: 22px !important;">
                                <?
                                    if($this->router->method=="editar"){ echo $this->uri->segment(3); } else { echo "0"; } 
                                ?>
                            </span>
                            
                            <label class="control-label" style="width: 50px !important;">Data</label>
                            <input id="dp1" class="input-small" type="text" onkeyup="mascaraData(this);" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" name="data" value="<?  if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } else { echo date("d/m/Y"); } ?>">
                            
                            <label class="control-label" style="width: 42px !important;">Hora</label>
                            <input type="hidden" name="hora" value="<?=date("H:i:s", strtotime('-1 HOUR'));?>" >
                            <label class="control-label" style="width: 45px !important;"><b><? if(isset($result->hora)){ echo $result->hora; } else { echo date("H:i:s", strtotime('-1 HOUR')); } ?></b></label>
                            
                            <label class="control-label" style="width: 74px !important;">Atendente</label>
                            <select class="input-large" style="width: 300px !important;" name="idAtendente" disabled>
                                <option value="<?php echo $this->session->userdata('idUsuario'); ?>"><?php echo $this->session->userdata('nome'); ?></option>
                                    <?
                                        //foreach($this->data['listaUsuario'] as $listaUsuario){
                                        //<option value="<? //echo $listaUsuario->idUsuario; ?>" <? //if($listaUsuario->idUsuario==$this->session->userdata('idUsuario')){ echo  "selected"; } ?> ><? //echo $listaUsuario->nome; ?></option>
                                    <? //} ?>
                                
                            </select>
                        </div>		
        
                     
                        <div class="line" style="height: 50px">
                            <label class="control-label" >Cliente</label>
                            <select class="input-xxlarge lista" style="width: 355px !important;" id="idCliente" name="idCliente" onchange="clienteChange()" required <? if($this->router->method=="editar"){ ?>disabled<? } ?>>
                                <option value=""></option>
                                    <? foreach($this->data['listaCliente'] as $listaCliente){ ?>
                                        <option value="<? echo $listaCliente->idCliente;?>"  <? if(isset($result->idCliente)){ if($result->idCliente==$listaCliente->idCliente){ echo "selected"; } }  ?>><? echo $listaCliente->razaosocial;?></option>
                                    <? } ?>
                            </select>
                            
                            <label class="control-label">Solicitante</label>
                            <span style="line-height: 15px !important; font-size: 12px !important;">
                            <? if($this->router->method=="editar"){ ?>
                                <input class="input-small" style="width: 266px !important;" disabled type="text" value="<? if(!empty($result->chamadaResponsavel)) echo $result->chamadaResponsavel; ?>">
                            <? } else { ?>
                            <? $width = ($this->permission->controllerManual('clientes')->canUpdate()) ? "225px;" : "280px;" ?>
                            <select class="input-small selectSolicitante" name="solicitante" id="solicitante" style="width: <?php echo $width; ?>">
                              
                            </select>
                            
                            <? if ($this->permission->controllerManual('clientes')->canUpdate()) { ?>
                            <button id="btnNovoCliente" type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#novoSolicitante">Novo</button>
                            <? } ?>
                            
                            <? } ?>
                            </span>                                      
                        </div>
                        
        
                        <div class="line">
                            <label class="control-label">KM</label>
                            <input class="input-small" style="width: 50px !important;" type="number" name="km" value="<? if(isset($result->km)){ echo $result->km; } ?>">
                            
                            <label class="control-label" style="width: 75px !important;" >Descarga</label>
                            <input class="input-small" style="width: 50px !important;" type="text" name="descarga" value="<? if(isset($result->descarga)){ echo $result->descarga; } ?>" placeholder="0.00" disabled>
                            
                            <label class="control-label" style="width: 75px !important;" >Pernoite</label>
                            <input class="input-small" style="width: 50px !important;" type="text" name="pernoite" value="<? if(isset($result->pernoite)){ echo $result->pernoite; } ?>" placeholder="0.00" disabled>
                            
                            <label class="control-label" style="width: 75px !important;" >Romaneio</label>
                            <input class="input-small" style="width: 50px !important;" type="text" name="romaneio" value="<? if(isset($result->romaneio)){ echo $result->romaneio; } ?>" placeholder="0.00" disabled>                                                                                
                            <label class="control-label" style="width: 75px !important;" >Veiculo</label>
                            <select class="input-small" name="tipo_veiculo" style="width: 159px !important;"  <? if($this->router->method=="editar"){ ?>disabled<? } ?>>
                                <option value="1" <? if(isset($result->tipo_veiculo)){ if($result->tipo_veiculo==1){ echo "selected"; } }  ?>>Base - Moto</option>
                                <option value="2" <? if(isset($result->tipo_veiculo)){ if($result->tipo_veiculo==2){ echo "selected"; } }  ?>>Médio - Carro</option>
                                <option value="3" <? if(isset($result->tipo_veiculo)){ if($result->tipo_veiculo==3){ echo "selected"; } }  ?>>Intermediário - Van</option>
                                <option value="4" <? if(isset($result->tipo_veiculo)){ if($result->tipo_veiculo==4){ echo "selected"; } }  ?>>Grande Porte - Caminhão</option>
                            </select>
                        </div>
                        
                        <legend style="margin-bottom: 5px;"><i class="icon-plus icon-title"></i> Serviços</legend>
                        <? if($this->router->method=="editar"){ ?>
                            <div class="line-fill-height" style="margin-left: 84px;">
                                    <table class="table table-responsive" style="text-transform: uppercase;width: 815px;border-bottom: 1px solid #CCCCCC;">
                                        <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td><strong>ENDEREÇO</strong></td>
                                                    <td><strong>Nº</strong></td>
                                                    <td><strong>CIDADE</strong></td>
                                                    <td><strong>BAIRRO</strong></td>
                                                    <td><strong>FALAR COM</strong></td>
                                                </tr>
                                                
                                            <? foreach($result->chamadaServico as $valor){ ?>
                                                <tr>
                                                    <td style="text-align: right;">
                                                        <strong><? if($valor->tiposervico=='0'){ echo "Coleta"; } elseif($valor->tiposervico=='1'){ echo "Entrega"; } else { echo "Retorno"; } ?></strong>
                                                    </td>
                                                    <td><? echo $valor->endereco; ?></td>
                                                    <td><? echo $valor->numero; ?></td>
                                                    <td><? echo $valor->cidade; ?></td>
                                                    <td><? echo $valor->bairro; ?></td>
                                                    <td><? echo $valor->falarcom; ?></td>
                                                </tr>
                                             <? } ?>
                                        </tbody>
                                    </table>
                                    <div style="height: 10px;"></div>
                            </div>
                        <? } else { ?>
                        
                        <div class="line-fill-height" style="margin-left: 84px;">
                        		<div class="div-idClienteFreteItinerario" style="margin-bottom: 10px;display: none;">
	                        		<label for="idClienteFreteItinerario" style="text-align: left;">Itinerários</label>
	                        		<br>
	                        		<select id="idClienteFreteItinerario" name="idClienteFreteItinerario" class="input-xlarge">
	                        		
	                        		</select>
                        		</div>
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
                                        
                                        
                                            <tr id="servico_0">
                                                <td style="line-height: 10px !important;">
                                               
                                                    <select class="input-small" name="cham_tiposervico[]">
                                                        <option value="0" selected >Coleta</option>
                                                        <option value="1"  >Entrega</option>
                                                    </select>
                                                    
<!--                                                         <option value="2"  >Retorno</option> -->
                                                </td>
                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                    <input class="input-small" style="width: 222px !important;" type="text" name="cham_endereco[]" value="" required>
                                                </td>
                                                <td style="line-height: 10px !important; font-size: 12px !important;">
                                                    <input class="input-small" style="width: 50px !important;" type="text" name="cham_numero[]" value="" required>
                                                </td>
                                                <td style="line-height: 10px !important;  font-size: 12px !important;">
                                                    
                                                    <select class="input-small selectCidade" name="cham_cidade[]" id="cham_cidade[]" style="width: 140px;">
                                                    <option value="0">Selecione</option>
                                                        <? foreach($this->data['listaCidade'] as $cidade){ ?>
                                                        <option value="<? echo $cidade->idCidade; ?>"><? echo $cidade->cidade; ?></option>
                                                        <? } ?>
                                                    </select>
                                                </td>
                                                <td style="line-height: 15px !important; font-size: 12px !important;">
                                                   <select class="input-small selectBairro" name="cham_bairro[]" id="cham_bairro[]" style="width: 120px;">
                                                        <option value="">Selecione</option>
                                                    </select>
                                                </td>
                                                <td style="line-height: 15px !important; font-size: 12px !important;">
                                                    <input class="input-small" type="text" name="cham_falarcom[]" value="">
                                                </td>
                                                <td>
                                                    <button class="btn" type="button" onclick="removerServico(0)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
                                                </td>
                                            </tr>
                                        
                                        
                                    </tbody>
                                </table>
                                
                                <div style="height: 54px; width: 815px;">
                                	<div style="display: inline-block;margin-top: 4px;">
	                                	<input type="checkbox" name="retornar-origem" id="retornar-origem">
										<label for="retornar-origem" style="width:250px !important;text-align: left;vertical-align: sub;margin-left: 4px;">Retornar à origem ao final</label>
                                	</div>
                                	<div style="display: inline-block;float: right;">
                                    	<button class="btn btn-small" type="button" onclick="adicionarServico()" style="float: right; position: relative; top: 7px; right: 3px;"><i class="icon-plus-sign"></i> Adicionar Serviço</button>
                                    </div>
                                </div>
                        </div>
                        
                        <? } ?>
                        
                            <div class="line-fill-height" style="margin-bottom: 20px;">
                                <label class="control-label">Observações</label>
                                <textarea name="observacoes" class="input-xxlarge" style="height: 90px; width: 752px;"></textarea>
                                <div style="margin-left: 130px;font-size: 14px;">
                                    <? if(isset($result->observacoes) && $result->observacoes != ""){
                                        echo str_replace("\n", "<br>", $result->observacoes);
                                    } ?>

                                    <? if(isset($result->observacoes_app) && $result->observacoes_app != ""){
                                        echo "<br><br>Observações no App<br>";
                                        echo str_replace("\n", "<br>", $result->observacoes_app);
                                    } ?>
                                </div>
                            </div>
                        
                        <div class="line">
                            <label class="control-label" >Funcionário</label>
                            <select class="input-large" style="width: 536px !important;" id="idFuncionario" name="idFuncionario">
                                <option value=""></option>
                                <?
                                    foreach($this->data['listaFuncionario'] as $funcionarioLista){ 
                                ?>
                                <option value="<?=$funcionarioLista->idFuncionario;?>" <? if(isset($result->idFuncionario)){ if($funcionarioLista->idFuncionario==$result->idFuncionario){ echo "selected"; } } ?> ><?=$funcionarioLista->nome;?></option>
                                <? } ?>
                            </select>
                            
                            <label class="control-label" style="width: 130px !important;">Hora de Repasse</label>
                            <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" type="time" style="background-color: #ffffff !important;  width: 70px !important;" name="hora_repasse" value="<? if(isset($result->hora_repasse)){ echo $result->hora_repasse; } ?>">
                        </div>
        
                        <div class="line">
                            <label class="control-label">Tempo Espera</label>
                            <input placeholder="00:00" data-format="hh:mm" class="add-on input-small" type="time" style="background-color: #ffffff !important;  width: 72px !important;" name="tempo_espera" value="<? if(isset($result->tempo_espera)){ echo $result->tempo_espera; } ?>">
                            
                            <label class="control-label" style="width: 120px !important;">Valor Empresa</label>
                            <input class="input-small right mascara_reais" type="text" style="width: 50px !important;" name="valor_empresa" disabled value="<? if(isset($result->valor_empresa)){ echo conv_monetario_br($result->valor_empresa); } ?>" <? if($this->router->method=="editar"){ ?> disabled<? } ?>>
                            
                            <label class="control-label" style="width: 120px !important;">Valor. Motorista</label>
                            <input class="input-small right mascara_reais" type="text" style="width: 50px !important;" name="valor_funcionario" disabled value="<? if(isset($result->valor_funcionario)){ echo conv_monetario_br($result->valor_funcionario); } ?>" <? if($this->router->method=="editar"){ ?> disabled<? } ?>>
                            
                            
                            <div style="display: inline-block;margin-top: 4px;margin-left: 15px;">
                            	<input type="checkbox" name="alterar_valor" id="alterar_valor">
								<label for="alterar_valor" style="width:90px !important;text-align: left;vertical-align: sub;margin-left: 4px;">Informa valor</label>
                            </div>
                            <? if($this->router->method=="editar"){ ?>
                            <div style="display: inline-block;margin-top: 4px;margin-left: 15px;">
                            	<input type="checkbox" name="calcula_automatico" id="calcula_automatico">
								<label for="calcula_automatico" style="width:90px !important;text-align: left;vertical-align: sub;margin-left: 4px;">Calcula auto</label>
                            </div>
                            <?php } ?>
                            
                            
                            
                        </div>
                        
                        <div class="line">
                            
                            <label class="control-label">Status</label>
                            <select class="input" name="status">
                                <option value="0" <? if(isset($result->status)){ if($result->status==0){ echo "selected"; } }  ?>>Pendente</option>
                                <option value="1" <? if(isset($result->status)){ if($result->status==1){ echo "selected"; } }  ?>>Em Andamento</option>
                                <option value="2" <? if(isset($result->status)){ if($result->status==2){ echo "selected"; } }  ?>>Concluída</option>
                                <option value="3" <? if(isset($result->status)){ if($result->status==3){ echo "selected"; } }  ?>>Cancelada</option>
                                
                                <?php if ($this->session->userdata('tipo') == 'SISAdmin') { ?>
                                <option value="-1">Não vai para p App</option>
                                <?php } ?>
                               	
                               	<? if(isset($result->status) && $result->status==-2){ ?>
                               		<option value="-2" selected>Possui trecho sem valor</option>
                               	<?php } ?>
                               
                            </select>      
                            
                            
                        </div>
        
                       
                        <div class="button-form line">										    
                            <div class="span6 offset3" style="text-align: center">
                            <? if($this->router->method=="editar"){ ?>
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <? if($result->status=='3'){ } else {  ?>
                                <a href="#modal-excluir" data-toggle="modal" chamada='<? echo $result->idChamada;?>' class="btn btn-danger"><i class="icon-remove"></i> Cancelar</a>
                                <? } ?>
                            <? } else { ?>
                                <button class="btn btn-success" id="btnContinuar"><i class="icon-plus icon-white"></i> Adicionar</button>
                            <? } ?>
                            <a href="<?php echo base_url() ?>chamadas" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    
                    </fieldset>
                </form>

        </div>
    </div>
    
	<input type="hidden" id="countServs" value="1" >

	<div style="display: none;">
		<table>
			<tbody id="servicoModelo">
				<tr id="servico_COUNT">
					<td style="line-height: 15px !important; font-size: 12px !important;">
					
						<select class="input-small" name="cham_tiposervico[]">
							<option value="1" selected >Entrega</option>
						</select>
<!-- 							<option value="2">Retorno</option> -->
					</td>
					<td style="line-height: 15px !important; font-size: 12px !important;">
						<input class="input-small" style="width: 222px !important;" type="text" name="cham_endereco[]">
					</td>
					<td style="line-height: 15px !important; font-size: 12px !important;">
						<input class="input-small" style="width: 50px !important;" type="text" name="cham_numero[]" value="">
					</td>
                    <td style="line-height: 10px !important;  font-size: 12px !important;">
                        <select class="input-small selectCidade cidade1" name="cham_cidade[]" id="cham_cidade[]" style="width: 140px;">
                        <option value="0">Selecione</option>
                            <? foreach($this->data['listaCidade'] as $cidade){ ?>
                            <option value="<? echo $cidade->idCidade; ?>"><? echo $cidade->cidade; ?></option>
                            <? } ?>
                        </select>
                    </td>
                    <td style="line-height: 15px !important; font-size: 12px !important;">                                                                <select class="input-small selectBairro bairro1" name="cham_bairro[]" id="cham_bairro[]" style="width: 120px;">
                            <option value="">Selecione</option>
                        </select>
                    </td>
					<td style="line-height: 15px !important; font-size: 12px !important;">
						<input class="input-small" type="text" name="cham_falarcom[]">
					</td>
					<td>
						<button class="btn" type="button" onclick="removerServico(COUNT)" style="padding: 3px; width: 32px !important;"><i class="icon-trash"></i></button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</div>
</div>
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>chamadas/cancelar" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Chamada</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idChamada" name="idChamada" value="" />
    <h5 style="text-align: center">Deseja realmente cancelar esta Chamada?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Não desejo Cancelar</button>
    <button class="btn btn-danger">Sim, desejo Cancelar!</button>
  </div>
  </form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
	   $(document).on('click', 'a', function(event) {
			var chamada = $(this).attr('chamada');
			$('#idChamada').val(chamada);
		});
	});
	
	$(function(){
		$("input[name='km']").on("keyup change", function(){
			campos = "input[name='descarga'],input[name='pernoite'],input[name='romaneio']";
			if ($(this).val()) {
			  $(campos).prop({disabled:false});
			} else {
			  $(campos).prop({disabled:true});
			}
		});
	});
</script>
<!-- Modal -->


<style>
    .div-imagens-chamada{text-align: center;}
    .div-imagens-chamada img{max-width: 200px;height:150px;display: inline-block;margin: 5px;}
</style>
<div class="div-imagens-chamada">
    <?php
    if($this->router->method=="editar") {
        $dir = "img/chamada/" . $result->idChamada . "/";

        $arquivos = glob($dir . "*.*");

        foreach ($arquivos as $img) {
            echo '<a href="../../../' . $img . '" rel=\'zoom\'>';
            echo '<img src="../../../' . $img . '">';
            echo '</a>';
        }
    }
    ?>
</div>

<!-- Modal -->
<div id="novoSolicitante" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <form id="formNovoSolicitante" action="<?php echo base_url() ?>clientes/novo_solicitante_ajax" method="post" >
  <input type="hidden" name="idCliente" id="idCliente">
  
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel2">Incluir novo solicitante</h5>
  </div>
  <div class="modal-body">
		
	<table>
		<tbody id="servicosTable" style="width: auto;">
			<tr>
				<td style="line-height: 10px !important;">
					<input class="input-small" style="width: 250px !important;" type="text" name="resp_nome" placeholder="Nome Completo">
				</td>
				<td style="line-height: 10px !important; font-size: 12px !important;">
					<input class="input-small mascara_so_numeros" maxlength="2" style="width: 40px !important;" type="text" name="resp_telefoneddd" placeholder="DDD">
					<input class="input-small mascara_telefone" maxlength="10" style="width: 173px !important;" type="text" name="resp_telefone" placeholder="Telefone">
				</td>
			</tr>
			<tr>
				<td>
					<input class="input-small mascara_so_numeros" maxlength="2" style="width: 40px !important;" type="text" name="resp_telefoneddd2" placeholder="DDD">
					<input class="input-small mascara_telefone" maxlength="10" style="width: 193px !important; margin-right: 15px;" type="text" name="resp_telefone2" placeholder="Telefone">
                </td>
                <td>
					<select class="input-small" name="resp_setor" id="resp_setor" style="width: 244px;margin: 0 0 10px 0;">
					<? foreach($this->data['parametroSetorSolicitante'] as $setor){ ?>
						<option value="<? echo $setor->idParametro; ?>"><? echo $setor->parametro; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input class="input-small" style="width: 250px !important;" type="email" name="resp_email" value="" placeholder="E-mail">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="checkbox" name="resp_confemail1" id="1_0">&nbsp;&nbsp;<label for="1_0" style="text-align: left;display: inline-block;margin-right: 40px;">Financeiro</label>
					<input type="checkbox" name="resp_confemail2" id="2_0">&nbsp;&nbsp;<label for="2_0" style="text-align: left;display: inline-block;margin-right: 40px;">Operacional</label>
					<input type="checkbox" name="resp_confemail3" id="3_0">&nbsp;&nbsp;<label for="3_0" style="text-align: left;display: inline-block;margin-right: 40px;">Marketing</label>
					<input type="checkbox" name="resp_confemail4" id="4_0">&nbsp;&nbsp;<label for="4_0" style="text-align: left;display: inline-block;margin-right: 40px;">Retorno</label>
				</td>
			</tr>
		</tbody>
	</table>
		<div id="resultIncluirSolicitante" style="margin-top: 20px;"></div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button id="btnIncluirSolicitante" type="button" class="btn btn-info">Incluir Solicitante</button>
  </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){

	onSubmitChangeCheckboxesToInput('formNovoSolicitante', 'input:checkbox');

	$('#btnNovoCliente').click(function(){
		var idCliente = $('.form-inline #idCliente').val();
		$('#novoSolicitante #idCliente').val( idCliente );
	});

	$('#btnIncluirSolicitante').click(function(){

		if ($('#novoSolicitante #idCliente').val() != "" && $('#novoSolicitante #resp_nome').val() != "") {
		
			$.ajax({
		        url: $('#formNovoSolicitante').attr('action'),
		        type: "POST",
		        data: $('#formNovoSolicitante').serialize(),
		        dataType: "json",
		        beforeSend: function( xhr ) {
		        	$('#btnIncluirSolicitante').attr('disabled', true);
		        	$('#resultIncluirSolicitante').html(htmlGifCarregando());
		        },
		        success: function(data) {
		        	$('#btnIncluirSolicitante').attr('disabled', false);
		        	$('#resultIncluirSolicitante').html('');
	
		        	//$('#resultIncluirSolicitante').html(data);
		        	
		        	if (data.resposta == 'success') {
						var newOption = '<option value="'+ data.idClienteResponsavel +'">'+ data.nome +'</option>';
						$('.form-inline #solicitante').append(newOption).find('option[value="'+ data.idClienteResponsavel +'"]').attr('selected', true);
						$('#novoSolicitante').modal('hide');
		        	}
		        	else {
		        		$('#resultIncluirSolicitante').html(data.mensagem);
		        	}
		        	
		        },
		        error: function (request, error) {
		        	$('#btnIncluirSolicitante').attr('disabled', false);
		        	$('#resultIncluirSolicitante').html('Não foi possível conectar ao servidor [cód: (ajaxCheck)]!' + error);
		        }
		    });
		}
		else {
			$('#resultIncluirSolicitante').html('Selecione um cliente e informe o nome do solicitante');
		}
		
	});
	

   $('a.bt-deletar').on('click', function(event) {
        var chamada = $(this).attr('chamada');
        $('#idChamada').val(chamada);
    });
	
   $("a.btn-info").on('click', function(event) {
        var chamada = $(this).attr('chamada');
        $('#idChamada').val(chamada);
		conteudo = $(this).parent().parent();
		$("#modal-editar").find('#idChamada').val( chamada );
		$("#modal-editar").find('.area-titulo').text( conteudo.find('td').eq(1).text() );
		$("#modal-editar").find('.area-data').text( conteudo.find('td').eq(2).text() );
		$("#modal-editar").find('.area-nome').text( conteudo.find('td').eq(5).text() );
		$("#modal-editar").find('.area-valor-empresa').find('input').val( conteudo.find('td').eq(6).text().replace(",", ".").replace("R$ ", "") );							
		$("#modal-editar").find('.area-valor-funcionario').find('input').val( conteudo.find('td').eq(7).text().replace(",", ".").replace("R$ ", "") );									
    });	

});

</script>

<div id="div-itinerario-servicos" role="<?php echo base_url('chamadas/get_itinerarios_cliente_ajax'); ?>" style="display: none;">

</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.lista').select2();
</script>