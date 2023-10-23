<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>adicionais/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Adicionais</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Adicionais para Funcionário</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6">Nenhum Adicional Cadastrado</td>
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
        <h5>Adicionais para Funcionário</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
        	<th></th>
            <th>Funcionário</th>
            <th>Parâmetro</th>
            <th>Data</th>
            <th>Valor</th>
            <th style="width: 115px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
			echo '<td><center>'.$r->tipoValor.'</center></td>';
            echo '<td>'.$r->nomeFuncionario.'</td>';
            echo '<td>'.$r->nomeParametro.'</td>';
            echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
			echo '<td>R$ '.number_format($r->valor, "2", ",", ".").'</td>';
            echo '<td>';
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'adicionais/editar/'.$r->idAdicional.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Adicional"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" adicional="'.$r->idAdicional.'" style="margin-right: 1%" class="btn btn-danger  tip-top" title="Excluir Adicional"><i class="icon-remove icon-white"></i></a>'; 
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
      <form action="<?php echo base_url() ?>adicionais/excluir" method="post" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Excluir Adicional</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idAdicional" name="idAdicional" value="" />
        <h5 style="text-align: center">Deseja realmente excluir este adicional?</h5>
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
                var adicional = $(this).attr('adicional');
                $('#idAdicional').val(adicional);
            });
        });
    </script>
    
    
    
    
