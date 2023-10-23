<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>tabelafrete" class="btn btn-success" style="height: 25px;"><i class="icon-plus icon-white" style="height: 25px;"></i> Tabela Padrão</a>    
<?php } ?>

<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>tabelafrete/metropolitano" class="btn btn-info" style="height: 25px;"><i class="icon-plus icon-white" style="height: 25px;"></i> Tabela Metropolitana</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Tabela de Frete</h5>

        </div>

        <div class="widget-content nopadding">
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cidade</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">Nenhum dado Cadastrado na Tabela de Frete</td>
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
        <h5>Tabela de Frete</h5>

     </div>
     
     
<div class="widget-content nopadding">

<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Saida</th>
            <th width="100px;">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->cidade.'</td>';
            	echo '<td>';
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'tabelafrete/metropolitano/editar/'.$r->idCidade.'" style="margin-right: 1%" class="btn btn-info " title="Editar Tabela de Frete"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" id="'.$r->idCidade.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Tabela de Frete"><i class="icon-remove icon-white"></i></a>'; 
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
<?php }?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>tabelafrete/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir tabelafrete</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idTabelaFrete" name="idTabelaFrete" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este tabelafrete?</h5>
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
        
        var tabelafrete = $(this).attr('tabelafrete');
        $('#idTabelaFrete').val(tabelafrete);

    });

});

</script>




