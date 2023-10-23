<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>fornecedores/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Fornecedor</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>fornecedores</h5>

        </div>

        <div class="widget-content nopadding">
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
                        <td colspan="6">Nenhum fornecedor Cadastrado</td>
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
        <h5>fornecedores</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th>Responsável</th>
            <th>Situação</th>
            <th style="width: 150px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
        	$situacao = ($r->situacao) ? "Ativo" : "Inativo";
            echo '<tr>';
            echo '<td>'.$r->idFornecedor.'</td>';
            echo '<td>'.$r->razaosocial.'</td>';
            echo '<td>'.$r->cnpj.'</td>';
            echo '<td>('.$r->responsavel_telefone_ddd.') '.$r->responsavel_telefone.'</td>';
			echo '<td>'.$r->responsavel.'</td>';
			echo "<td>".$situacao."</td>";
            echo '<td>';
            if($this->permission->canSelect()){
                echo '<a href="'.base_url().'fornecedores/visualizar/'.$r->idFornecedor.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'fornecedores/editar/'.$r->idFornecedor.'" style="margin-right: 1%" class="btn btn-info " title="Editar fornecedor"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" fornecedor="'.$r->idFornecedor.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir fornecedor"><i class="icon-trash icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>fornecedores/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir fornecedor</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idfornecedor" name="idfornecedor" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este fornecedor?</h5>
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
        
        var fornecedor = $(this).attr('fornecedor');
        $('#idfornecedor').val(fornecedor);

    });

});

</script>




