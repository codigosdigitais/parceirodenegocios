<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Parâmetros</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>parametro/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Parâmetro</a>    
    <?php } ?>
    </ol>
</nav>


<?php if(!$results){ ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Parâmetro</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">Nenhum Parâmetro Cadastrado</td>
        </tr>
    </tbody>
</table>

<?php } else { ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th width="30px;">#</th>
            <th>Categoria</th>
            <th>Parâmetro</th>
            <th width="110px;">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->idParametro.'</td>';
				echo '<td>'.$r->parametro.'</td>';
				echo '<td>'.$r->parametroCategoria.'</td>';
            echo '<td>';
            if($this->permission->canSelect()){
                echo '<a href="'.base_url().'parametro/visualizar/'.$r->idParametro.'" style="margin: 0px !important;" class="btn btn-icone-pequeno" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'parametro/editar/'.$r->idParametro.'" style="margin: 0px !important;" class="btn btn-info btn-icone-pequeno" title="Editar Parametro"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" Parametro="'.$r->idParametro.'" style="margin: 0px !important;" class="btn btn-danger btn-icone-pequeno" title="Excluir Parametro"><i class="icon-remove icon-white"></i></a>'; 
            }

              
            echo '</td>';
            echo '</tr>';
        }?>
    </tbody>
</table>

<?php echo $this->pagination->create_links();}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>parametro/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Parametro</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idParametro" name="idParametro" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Parâmetro?</h5>
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
        
        var Parametro = $(this).attr('Parametro');
        $('#idParametro').val(Parametro);

    });

});

</script>




