<?php //if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>chamadas/adicionar" class="btn btn-success" style="width: 135px;"><i class="icon-plus icon-white"></i> Adicionar Chamada</a>    
    <a id="Pesquisar_Botao" class="btn btn-primary" style="width: 135px;"><i class="icon-search icon-white"></i> Pesquisar Chamada</a> 
    <a href="<?php echo base_url();?>financeiro/chamada" class="btn btn-danger" style="width: 135px;"><i class="icon-check icon-white"></i> Relatório</a> 
<?php //}  ?>
<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
	.table-bordered tr:hover{color: #000 !important;}
	.div-explain-colors .div-color{width: 15px;height: 15px;display: inline-block;vertical-align: middle;border: 1px solid #afafaf;}
	.div-explain-colors label{display: inline-block;font-size: 11px;margin-left: 5px;margin-right: 15px;}
</style>
<?php
if(!$results){?>
        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Chamadas</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>CHM</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Chamada</th>
                        <th>Repasse</th>
                        <th>Empresa</th>
                        <th>Funcionário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8">Nenhuma Chamada Cadastrado</td>
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
        <h5>Chamadas</h5>
     </div>
 <div id="Pesquisar" style="display:none">
        <div class="span12" style="padding: 10px;">
<form class="form-inline" method="get" action="<?php echo base_url('chamadas'); ?>">
                <input type="hidden" id="view" name="view" value="">
                <fieldset>
						<div class="line">
							<label class="control-label">Cliente</label>
							<select class="input-xxlarge" name="idCliente" id="idCliente" style="width: 715px !important;">
								<option value="">Selecione o Cliente</option>
								<?
                                    foreach($this->data['listaCliente'] as $clienteLista){ 
                                ?>
                                <option value="<?=$clienteLista->idCliente;?>" <? if(isset($result->idCliente)){ if($clienteLista->idCliente==$result->idCliente){ echo "selected"; } } ?> ><?=$clienteLista->razaosocial;?></option>
                                <? } ?>								
							</select>
						</div>
						<div class="line">
							<label class="control-label">Funcionário</label>
							<select class="input-xxlarge" name="idFuncionario" id="idFuncionario" style="width: 715px !important;">
								<option value="">Selecione o Funcionário</option>
								<?
                                    foreach($this->data['listaFuncionario'] as $funcionarioLista){ 
                                ?>
                                <option value="<?=$funcionarioLista->idFuncionario;?>" <? if(isset($result->idFuncionario)){ if($funcionarioLista->idFuncionario==$result->idFuncionario){ echo "selected"; } } ?> ><?=$funcionarioLista->nome;?></option>
                                <? } ?>								
							</select>
						</div>
            <div class="line">
                <label for="">Nº Chamada</label>
                <input type="number" name="idChamada" class="span4" value="<? if(isset($_GET['idChamada'])){ echo $_GET['idChamada']; } ?>" />
            </div>
						<div class="line">
							<label class="control-label">Data Inicial</label>
							<input id="dataInicial" class="input-small"  name="dataInicial" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="date" style="width: 150px;">
            				<label class="control-label">Data Final</label>
							<input id="dataFinal" class="input-small"  name="dataFinal" value="<? if(isset($result->data)){ echo date("d/m/Y", strtotime($result->data)); } ?>" type="date" style="width: 150px;">				
							<button class="btn btn-inverse" style="width: 150px; height:30px; margin-left: 45px;"><i class="icon-print icon-white"></i> Filtrar</button>
						</div>
		    	</fieldset>
	    	</form>
        </div>
</div>
<!--<div style="border: solid 2px red; background-color: #cccccc; padding: 15px;">
    <center><h4>FAVOR NÃO REMOVER OS TESTES INSERIDOS, POIS ATRAPALHA O DESENVOLVIMENTO E TESTES! </h4></center>
</div>-->
<div class="widget-content nopadding">
			<!---
        <div class="span12" style="padding: 10px;" id="pesquisa_base">
            <form action="<?php echo base_url()?>chamadas" method="get">
            <div class="span2">
                <label for="">Data Inicial:</label>
                <input type="date" name="dataInicial" class="span12" value="<? if(isset($_GET['dataInicial'])){ echo $_GET['dataInicial']; } ?>" />
            </div>
            <div class="span2">
                <label for="">Data Final:</label>
                <input type="date" name="dataFinal" class="span12" value="<? if(isset($_GET['dataFinal'])){ echo $_GET['dataFinal']; } ?>" />
            </div>
            <div class="span2">
                <label for="">Nº Chamada</label>
                <input type="number" name="idChamada" class="span8" value="<? if(isset($_GET['idChamada'])){ echo $_GET['idChamada']; } ?>" />
            </div>
            <div class="span2">
                <label for="">&nbsp;</label>
                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>
            </div>
            </form>
        </div>
		-->
<table class="table table-bordered ">
    <thead>
        <tr>
            <th>CHM</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Chamada</th>
            <th>Repasse</th>
            <th style="width: 200px;">Funcionário</th>
            <th style="width: 100px;">Empresa</th>
            <th style="width: 100px;">Funcionário</th>
            <th style="width: 15%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $existePreCadastro = false;
        $existeTrechoSemValor = false;
        foreach ($results as $r) {
			if($r->status=='3'){
				$cor = "#75A9DD";	
				$style = "style='color: black;'";
			} elseif($r->status=='1') {
				$cor = "#FFCC00";
				$style = "style='color: black;'";	
			} elseif($r->status=='0'){
				$cor = "red";
				$style = "style='color: white;'";				
			} elseif($r->status=='-1'){
				$existePreCadastro =true;
				$cor = "#000";
				$style = "style='color: white;'";				
			} elseif($r->status=='-2'){
				$existeTrechoSemValor =true;
				$cor = "#666";
				$style = "style='color: white;'";				
			} else { 
				$cor = NULL;
				$style = NULL;	
			}
			if($r->idChamada<=9){
				$idChamada = "0".$r->idChamada;	
			} else {
				$idChamada = $r->idChamada;		
			}
            echo "<tr bgcolor='{$cor}' {$style}>";
            echo "<td><strong><div style='background-color:#5bb75b; border-radius: 3px; padding-right: 6px; padding: 3px; color: #fff'><center>".$idChamada."</center></div></strong></td>";
            echo '<td>'.substr($r->nomefantasia, 0, 40).'</td>';
            echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
            echo '<td>'.$r->hora.'</td>';
			echo '<td>'.$r->hora_repasse.'</td>';
			echo '<td>'.substr($r->funcionarioNome, 0, 25).'</td>';
			echo '<td>R$ '.number_format($r->valor_empresa, "2", ",", ".").'</td>';
			echo '<td>R$ '.number_format($r->valor_funcionario, "2", ",", ".").'</td>';
            echo '<td>';
            //if($this->permission->canSelect()){
                echo '<a href="'.base_url().'chamadas/visualizar/'.$r->idChamada.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
           // }
            //if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'chamadas/editar/'.$r->idChamada.'" style="margin-right: 1%" class="btn btn-info " title="Editar Chamada"><i class="icon-pencil icon-white"></i></a>'; 
            //}
            //if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" chamada="'.$r->idChamada.'" style="margin-right: 1%" class="btn btn-danger" title="Excluir Chamada"><i class="icon-trash icon-white"></i></a>'; 
            //}
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
        </tr>
    </tbody>
</table>
</div>
</div>
<div class="div-explain-colors">
		<div class="div-color" style="background-color: red;"></div>
		<label>Pendente</label>
		<div class="div-color"  style="background-color: #FFCC00;"></div>
		<label>Em andamento</label>
		<div class="div-color"  style="background-color: #75A9DD;"></div>
		<label>Cancelada</label>
		<div class="div-color"  style="background-color: #fff;"></div>
		<label>Concluída</label>
		<?php if ($existePreCadastro) { ?>
		<div class="div-color"  style="background-color: #000;"></div>
		<label>Pré-cadastro website</label>
		<?php } ?>
		<?php if ($existeTrechoSemValor) { ?>
		<div class="div-color"  style="background-color: #666;"></div>
		<label>Possui trecho sem valor</label>
		<?php } ?>
</div>
<?php 
if(isset($_GET['idChamada']) || isset($_GET['dataInicial']) || isset($_GET['idCliente'])){ } else { echo $this->pagination->create_links(); } }?>
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>chamadas/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Chamada</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idChamada" name="idChamada" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Chamada?</h5>
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
        var chamada = $(this).attr('chamada');
        $('#idChamada').val(chamada);
    });
	$( "#Pesquisar_Botao" ).click(function() {
		$("#Pesquisar").css("display","block");
		$("#pesquisa_base").css("display","none");
	});	
});
</script>
