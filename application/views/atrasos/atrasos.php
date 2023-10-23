<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rec_aAtrasos')){ ?>
    <a href="<?php echo base_url();?>atrasos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Atraso</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Atrasos</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Hora Ini.</th>
                        <th>Hora Fin.</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Nenhuma atraso Cadastrado</td>
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
        <h5>Atrasos</h5>
     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Funcionário</th>
            <th>Tipo</th>
            <th>Data</th>
            <th>Hora Ini.</th>
            <th>Hora Fin.</th>
            <th>Valor</th>
            <th style="width: 115px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->nomeFuncionario.'</td>';
            echo '<td>'.$r->nomeParametro.'</td>';
            echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
			echo '<td>'.$r->hora_inicial.'</td>';
			echo '<td>'.$r->hora_final.'</td>';
			echo '<td>R$ '.number_format($r->valor, "2", ",", ".").'</td>';
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'rec_vAtrasos')){
                echo '<a href="'.base_url().'atrasos/visualizar/'.$r->idAtraso.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'rec_eAtrasos')){
                echo '<a href="'.base_url().'atrasos/editar/'.$r->idAtraso.'" style="margin-right: 1%" class="btn btn-info " title="Editar atraso"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'rec_dAtrasos')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" atraso="'.$r->idAtraso.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir atraso"><i class="icon-remove icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>atrasos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir atraso</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAtraso" name="idAtraso" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este atraso?</h5>
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
        
        var atraso = $(this).attr('atraso');
        $('#idAtraso').val(atraso);

    });

});

</script>




