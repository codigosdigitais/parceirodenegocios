<a href="<?php echo base_url();?>administrando/modulosAdicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Módulo</a>    

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Módulos</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Módulo</th>
                        <th>Pasta</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Nenhum Módulo Cadastrado</td>
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
        <h5>Módulos</h5>
     </div>

<div class="widget-content nopadding">
<table class="table table-bordered ">
    <thead>
        <tr>
            <th style="width: 50px;">COD</th>
            <th>Módulo Principal</th>
            <th>Módulo Auxiliar</th>
			<th>Pasta</th>
            <th>Status</th>
            <th style="width: 115px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
			if($r->status==0) $status = "Ativo"; elseif($r->status==1) $status = "Inativo"; elseif($r->status==2) $status = "Bloqueado";  
            echo '<tr>';
            echo '<td>'.$r->idModulo.'</td>';
            echo '<td>'.$r->moduloBase.'</td>';
            echo '<td>'.$r->modulo.'</td>';
            echo '<td>'.$r->pasta.'</td>';
			echo '<td>'.$status.'</td>';
            echo '<td>';
                echo '<a href="'.base_url().'administrando/modulosEditar/'.$r->idModulo.'" style="margin-right: 1%" class="btn btn-info " title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->idModulo.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Cliente"><i class="icon-remove icon-white"></i></a>'; 
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php }?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>clientes/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Cliente</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCliente" name="idCliente" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente?</h5>
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
        
        var cliente = $(this).attr('cliente');
        $('#idCliente').val(cliente);

    });

});

</script>




