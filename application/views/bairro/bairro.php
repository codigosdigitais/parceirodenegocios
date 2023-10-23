<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Bairros</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>bairro/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Bairro</a>   
    <?php } ?>
    </ol>
</nav>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Bairros</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cidade</th>
                        <th>Bairro</th>
                        <th>Tipo</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma Bairro Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else { ?>

<table class="table table-bordered table-striped ">
    <thead>
        <tr>
            <th>Cidade</th>
            <th>Bairro</th>
            <th>Tipo</th>
            <th width="114px;">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->cidade.'</td>';
				echo '<td>'.$r->bairro.'</td>';
				echo '<td>'.$this->bairro_model->getTipoBairro($r->idTipoBairro).'</td>';
            echo '<td>';
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'bairro/editar/'.$r->idBairro.'" style="margin-right: 1%" class="btn btn-info " title="Editar Bairro"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" bairro="'.$r->idBairro.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Bairro"><i class="icon-trash icon-white"></i></a>'; 
            }

              
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>

<?php echo $this->pagination->create_links();}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>bairro/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir bairro</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idBairro" name="idBairro" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Bairro?</h5>
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
        
        var bairro = $(this).attr('bairro');
        $('#idBairro').val(bairro);

    });

});

</script>




