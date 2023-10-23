<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Cedentes</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>cedentes/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Cedente</a>
    <?php } ?>
    </ol>
</nav>


<?php if(!$results){?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th>Responsável</th>
            <th>Situação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">Nenhum Cedente Cadastrado</td>
        </tr>
    </tbody>
</table>

<?php } else { ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="5%">COD</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th>Responsável</th>
            <th>Situação</th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
        	$situacao = ($r->situacao) ? "Ativo" : "<font color='red'><b>Inativo</b></font>";
            $colorFont = ($r->situacao) ? "" : "#F5F5F5";
        	
            echo '<tr>';
            echo '<td style='.$colorFont.'><center>'.$r->idCedente.'</center></td>';
            echo '<td color='.$colorFont.'>'.$r->razaosocial.'</td>';
            echo '<td color='.$colorFont.'>'.$r->cnpj.'</td>';
            echo '<td color='.$colorFont.'>('.$r->responsavel_telefone_ddd.') '.$r->responsavel_telefone.'</td>';
			echo '<td color='.$colorFont.'>'.$r->responsavel.'</td>';
			echo '<td color='.$colorFont.'>'.$situacao.'</td>';
            echo '<td>';
            if($this->permission->canSelect()){
                echo '<a href="'.base_url().'cedentes/visualizar/'.$r->idCedente.'" style="margin: 0px !important;" class="btn" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'cedentes/editar/'.$r->idCedente.'" style="margin: 0px !important;" class="btn btn-info" title="Editar Cedente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" Cedente="'.$r->idCedente.'" style="margin: 0px !important;" class="btn btn-danger" title="Excluir Cedente"><i class="icon-trash icon-white"></i></a>'; 
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
<?php echo $this->pagination->create_links();?>
<?php } ?>



<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <form action="<?php echo base_url() ?>cedentes/excluir" method="post" >
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <h5 id="myModalLabel">Excluir Cedente</h5>
      </div>
      <div class="modal-body">
         <input type="hidden" id="idCedente" name="idCedente" value="" />
         <h5 style="text-align: center">Deseja realmente excluir este Cedente?</h5>
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
        var Cedente = $(this).attr('Cedente');
        $('#idCedente').val(Cedente);
    });
});
</script>




