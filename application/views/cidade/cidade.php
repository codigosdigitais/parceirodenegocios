<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Cidades</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>cidade/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Cidade</a>     
    <?php } ?>
    </ol>
</nav>

<?php  if(!$results){ ?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Cidades</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cidade</th>
                        <th>Tipo</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma Cidade Cadastrada</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else { ?>

<table class="table table-bordered table-striped ">
    <thead>
        <tr>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Tipo</th>
            <th width="114px">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->estado.'</td>';
				echo '<td>'.$r->cidade.'</td>';
				echo '<td>'.$this->cidade_model->getTipoCidade($r->idTipo).'</td>';
            echo '<td>';
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'cidade/editar/'.$r->idCidade.'" style="margin-right: 1%" class="btn btn-info btn-sm" title="Editar Cidade"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" cidade="'.$r->idCidade.'" style="margin-right: 1%" class="btn btn-danger btn-sm " title="Excluir Cidade"><i class="icon-trash icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>cidade/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Cidade</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCidade" name="idCidade" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta Cidade?</h5>
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
        
        var cidade = $(this).attr('cidade');
        $('#idCidade').val(cidade);

    });

});

</script>




