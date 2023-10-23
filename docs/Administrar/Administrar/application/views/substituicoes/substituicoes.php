<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>substituicoes/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Substituição</a> 
    
    <a href="<?php echo base_url();?>relatorios/substituicoes" class="btn btn-danger" style="width: 125px;"><i class="icon-check icon-white"></i> Relatório</a>    
<?php } ?>

<style>
	.table th, .table td {
		padding: 2px;
		line-height: 20px;
		text-align: left;
		vertical-align: top;
		border-top: 1px solid #ddd;
		font-size: 11px;
	}
</style>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Substituições</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Funcionário </th>
                        <th>Funcionário Substituto</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma Substituição Cadastrada</td>
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
        <h5>Substituições</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Funcionário </th>
            <th>Funcionário Substituto</th>
            <th style="width: 115px;">Data</th>
            <th style="width: 115px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.substr($r->razaosocial, 0, 40).'</td>';
            echo '<td>'.$r->nomeFalta.'</td>';
            echo '<td>'.$r->nomeSubstituto.'</td>';
            echo '<td><center>'.date("d/m/Y", strtotime($r->data)).'</center></td>';
            echo '<td>';
            
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'substituicoes/editar/'.$r->idSubstituicao.'" style="margin-right: 1%" class="btn btn-info " title="Editar Substituição"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" substituicao="'.$r->idSubstituicao.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Substituição"><i class="icon-remove icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>substituicoes/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Substituição</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idSubstituicao" name="idSubstituicao" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta Substituição?</h5>
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
        
        var substituicao = $(this).attr('substituicao');
        $('#idSubstituicao').val(substituicao);

    });

});

</script>




