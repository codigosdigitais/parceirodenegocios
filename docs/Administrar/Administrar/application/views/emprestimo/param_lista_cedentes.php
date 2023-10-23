<!--
* @autor: Davi Siepmann
* @date: 25/09/2015
* @based on: views/cedentes/cedentes.php
*/
-->
<meta charset="utf-8">

<script type="text/javascript" src="<?php echo base_url()?>assets/controllers/emprestimo/js/param_emp_lista_cedentes.js?o1"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/novo-estilo.css?o1" />
<style type="text/css">
	.tabela-lista-cedentes tr:hover, .tabela-emprestimos-globais tr:hover{background-color: transparent;}
</style>

<div class="row-fluid" style="margin-top:-10px">
    <div class="span12">
            <div class="widget-content">
            
                <fieldset>
            	<legend class="form-title" style="margin-bottom:0 !important"><i class="icon-list-alt icon-title"></i>
            		Parâmetros para Empréstimos e Financiamentos
            	</legend>
                <div class="span12" id="divatraso" style=" margin-left: 0">
                    <div class="tab-content" >
                        <div class="tab-pane active" id="tab1">
		    			
                        <div class="widget-box">
                            <div class="widget-content nopadding">
								<div class="widget-title">
	                                <h5>&raquo; PARÂMETROS GLOBAIS</h5>
	                            </div>
	                            <table class="table table-bordered tabela-emprestimos-globais">
								    <thead>
								        <tr>
								            <th style="width: 40px;">COD</th>
								            <th>Nome</th>
								            <th style="width: 85px;">Habilitado</th>
								            <th style="width: 98px;">Ações</th>
								        </tr>
								    </thead>
								    <tbody>
								        <tr>
								            <td style="width: 40px;"><center><?=$this->session->userdata['idCliente']?></center></td>
								            <td><?=$this->session->userdata('razaosocial')?></td>
								            <td>
								            <?php 
								            	$param = array_shift($this->data['param_global']);
								            	if (0 == count($param)) {
								            		$idParametro = ''; $idCedente = ''; $habilitado = false;
								            	}
								            	else {
								            		$idParametro = $param->idParametro;
								            		$idCedente = $param->idCedente;
								            		$habilitado = $param->habilitado;
								            	}
								            	
								            	echo '<form id="form_param" class="form-inline" method="post" action="';
								            	echo base_url('paramemprestimos/gravar_habilita_cedentes');
								            	echo '">';
								            	echo '<input type="hidden" name="tb_idParametro[]" value="'.$idParametro.'">';
								            	echo '<input type="hidden" name="tb_idCedente[]" value="'.$idCedente.'">';
								            	echo '<input type="hidden" name="tb_habilitado[]" value="'.$habilitado.'">';
								            	
								            	$on = 'btn-on-disabled'; $off = 'btn-off-enabled';
									            if ($habilitado) {
									            	$on = 'btn-on-enabled'; $off = 'btn-off-disabled';
									            }
								            	echo '<button type="button" class="btn '.$on.'" title="Habilitar /Desabilitar">On</button>';
								            	echo '<button type="button" class="btn '.$off.'" title="Habilitar /Desabilitar">Off</button>';
								            	
								            	echo '</form>';
								            ?>
								            </td>
								            <td>
								            <?php
									            if($this->permission->controllerManual('paramemprestimos')->canUpdate()){
									            	echo '<a href="'.base_url().'paramemprestimos/param_cedente/" ';
									            	echo 'class="btn btn-alterar a-btn-abre-cedente" type="button">';
									                echo '<i class="icon-list-alt"></i>Alterar</button>';
									            }
									        ?>
								            </td>
								        </tr>
								    </tbody>
								</table>
								
							</div>
						</div>
						<div class="widget-box">
                            <div class="widget-content nopadding">
								
								<div class="widget-title">
	                                <h5>&raquo; PARÂMETROS POR CEDENTE</h5>
	                            </div>
								<table class="table table-bordered tabela-lista-cedentes">
								    <thead>
								        <tr>
								            <th style="width: 40px;">COD</th>
								            <th>Nome</th>
								            <th style="width: 160px;">CPF/CNPJ</th>
								            <th style="width: 85px;">Habilitado</th>
								            <th style="width: 98px;">Ações</th>
								        </tr>
								    </thead>
								    <tbody>
								        <?php 
								        if (0 < count($results)) {
								        	foreach ($results as $r) {
									            echo '<tr>';
									            echo '<td><center>'.$r->idCedente.'</center></td>';
									            echo '<td>'.$r->razaosocial.'</td>';
									            echo '<td>'.$r->cnpj.'</td>';
	
									            echo '<td>';
									            echo '<form id="form_param" class="form-inline" method="post" action="';
									            echo base_url('paramemprestimos/gravar_habilita_cedentes');
									            echo '">';
									            echo '<input type="hidden" name="tb_idParametro[]" value="'.$r->idParametro.'">';
								            	echo '<input type="hidden" name="tb_idCedente[]"   value="'.$r->idCedente.'">';
								            	echo '<input type="hidden" name="tb_habilitado[]"  value="'.$r->habilitado.'">';
									            	
								            	$on = 'btn-on-disabled'; $off = 'btn-off-enabled';
									            if ($r->habilitado) {
									            	$on = 'btn-on-enabled'; $off = 'btn-off-disabled';
									            }
								            	echo '<button type="button" class="btn '.$on.'" title="Habilitar /Desabilitar">On</button>';
								            	echo '<button type="button" class="btn '.$off.'" title="Habilitar /Desabilitar">Off</button>';
								            	
									            echo '</form>';
									            echo '</td>';
									            
									            echo '<td>';
									            if($this->permission->controllerManual('paramemprestimos')->canUpdate()){
									            	echo '<a href="'.base_url().'paramemprestimos/param_cedente/'.$r->idCedente.'" ';
									            	echo 'class="btn btn-alterar a-btn-abre-cedente" type="button">';
									                echo '<i class="icon-list-alt"></i>Alterar</a>';
									            }
									            echo '</td>';
									            echo '</tr>';
								        	}
								        }
								       	?>
								        <tr>
								            
								        </tr>
								    </tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
			</div>
		</fieldset>
	</div>
</div>
</div>