<?php
if(!$results){?>
<div  style="margin-top: -30px;">
        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Contratos - Customizado</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Responsável</th>
                        <th>Telefone</th>
                        <th>Funcionários</th>
                        <th>Valor Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Nenhum Contrato Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }else{
	

?>
<div class="widget-box" style="margin-top: -25px;">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Contratos - Customizado</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Responsável</th>
            <th>Telefone</th>
            <th>Funcionários</th>
            <th>Valor Total</th>
            <th style="width: 115px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
			foreach($r->contratoFuncionarios as $funcionarios){ 
			
				echo '<tr>';
				echo '<td>'.$r->razaosocial.'</td>';
				echo '<td>'.$r->responsavel.'</td>';
				echo '<td>('.$r->responsavel_telefone_ddd.') '.$r->responsavel_telefone.'</td>';
				echo '<td><center>'.$funcionarios->quantidadeFuncionario.'</center></td>';
				echo '<td>R$ '.number_format($funcionarios->valorContrato, 2, ",", ".").'</td>';
				echo '<td>';
				if($this->permission->controllerManual('relatorios/contratos')->canSelect()){
					echo '<a href="'.base_url().'contratos/visualizar/'.$r->idContrato.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
				}
				if($this->permission->controllerManual('relatorios/contratos')->canUpdate()){
					echo '<a href="'.base_url().'contratos/editar/'.$r->idContrato.'" style="margin-right: 1%" class="btn btn-info " title="Editar contrato"><i class="icon-pencil icon-white"></i></a>'; 
				}
				if($this->permission->controllerManual('relatorios/contratos')->canDelete()){
					echo '<a href="#modal-excluir" role="button" data-toggle="modal" contrato="'.$r->idContrato.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir contrato"><i class="icon-remove icon-white"></i></a>'; 
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
<? } ?>