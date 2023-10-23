
<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>proventos" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Provento</a>    
<?php } ?>
<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
</style>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Proventos</h5>

     </div>

<div id="Pesquisar" <? if(isset($_GET['razaosocial']) || isset($_GET['cnpj'])){ ?> <? } else { ?> style="display:block"<? } ?>>
		    	<form class="form-inline" method="post" action="<?php echo base_url('proventos/pesquisar'); ?>">
                <fieldset>


                        
						<div class="line" style="margin-top: 15px;">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge" name="idFuncionario" id="idFuncionario" style="width: 715px !important;">
								<option value="">Selecione o Funcionário</option>
								<?
                                    foreach($this->data['listaFuncionario'] as $funcionarioLista){ 
                                ?>
                                <option value="<?=$funcionarioLista->idFuncionario;?>" <? if($this->input->post('idFuncionario')!=NULL){ if($funcionarioLista->idFuncionario==$this->input->post('idFuncionario')){ echo "selected"; } } ?> ><?=$funcionarioLista->nome;?></option>
                                <? } ?>								
							</select>
						</div>
                        
						<div class="line">
							<label class="control-label">Tipo de Provento</label>
							<select class="input-xxlarge" name="idTipo" id="idTipo" style="width: 715px !important;">
								<option value="">Selecione o Tipo de Provento</option>
								<?
                                    foreach($this->data['parametroProvento'] as $parametroProvento){ 
                                ?>
                                <option value="<?=$parametroProvento->idParametro;?>" <? if($this->input->post('idTipo')!=NULL){ if($parametroProvento->idParametro==$this->input->post('idTipo')){ echo "selected"; } } ?>><?=$parametroProvento->parametro;?></option>
                                <? } ?>								
							</select>
						</div>
						
                        
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
                        
						<div class="line">
							<label class="control-label">Data Inicial</label>
							<input id="data_inicial" class="input-small" name="data_inicial" value="<? if($this->input->post('data_inicial')!=NULL){ echo $this->input->post('data_inicial');  } ?>" type="date" style="width: 150px;">
			
            				<label class="control-label">Data Final</label>
							<input id="data_final" class="input-small" name="data_final"  value="<? if($this->input->post('data_final')!=NULL){ echo $this->input->post('data_final');  } ?>" type="date" style="width: 150px;">				
						</div>
						<div style="padding-left: 105px; margin-bottom: 20px;">
                            <button class="btn btn-inverse span2" name="Filtro" value="acao"><i class="icon-print icon-white"></i> Filtrar</button>
                            <a href="<?php echo base_url('proventos/lista'); ?>" class="btn btn-default" style="margin-left: 10px;"><i class="icon-retweet"></i> Limpar filtros</a>
                        </div>
		    	</fieldset>
	    	</form>

</div>


<div class="widget-content nopadding">

			<? 
				if($this->input->post("Filtro")){
					$total_rs = 0;
					foreach ($results as $r) {
						$total_rs += $r->valor;
					}
			?>
                <div class="row" style="margin-bottom: 10px !important;">
                    <div class="span7">
                    </div>
                    <div class="span2">
                        <label for="">Total de Registros</label>
                        <button class="btn btn-inverse span12" style="background-color: red"> Total: <? echo count($results); ?>  </button>
                    </div>
                    
                    <div class="span2">
                        <label for="">Total em Reais</label>
                        <button class="btn btn-inverse span12"> Valor: <? echo number_format($total_rs, 2, ',', '.'); ?> </button>
                    </div>
                </div>								  
            <? } ?>

<table class="table table-bordered ">
    <thead>
        <tr>
        	<th>ID</th>
            <th>Funcionário</th>
            <th>Tipo</th>
            <th>Referência</th>
            <th>Data</th>
            <th>Valor</th>
            <th style="width: 150px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
			echo '<td><center>'.$r->idProvento.'</center></td>';
            echo '<td>'.$r->nomeFuncionario.'</td>';
            echo '<td>'.$r->nomeParametro.'</td>';
			echo '<td>'.$r->referencia.'</td>';
            echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
			echo '<td>R$ '.number_format($r->valor, "2", ",", ".").'</td>';
            echo '<td>';
            if($this->permission->canSelect()){
                echo '<a href="'.base_url().'proventos/visualizar/'.$r->idProvento.'" style="margin-right: 1%" class="btn" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'proventos/lista/editar/'.$r->idProvento.'" style="margin-right: 1%" class="btn btn-info" title="Editar Provento"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" Provento="'.$r->idProvento.'" style="margin-right: 1%" class="btn btn-danger" title="Excluir Provento"><i class="icon-remove icon-white"></i></a>'; 
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
<?php 
if (isset($this->data['limitePesquisa'])) echo "Limite de ".$this->data['limitePesquisa']." registros. Caso necessário, reformule os filtros.";
if (isset($this->pagination)) echo $this->pagination->create_links(); 
?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>proventos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Provento</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idProvento" name="idProvento" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Provento?</h5>
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
			var Provento = $(this).attr('Provento');
			$('#idProvento').val(Provento);
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
		$('#idCliente').chosen({
		});
		
		$('#idFuncionario').chosen({
		});
		
		$('#idTipo').chosen({
		});
		
		$('#localtrabalho').chosen({
		});
	});



</script>
