<?php if($this->permission->canInsert()){ ?>
    <a href="<?php echo base_url();?>bairro/adicionar" class="btn btn-success" style="height: 25px;"><i class="icon-plus icon-white" style="height: 25px;"></i> Adicionar Bairro</a>    

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
        
        <div class="span12" style="padding: 10px;">  
        <form action="<?php echo current_url(); ?>" method="post" id="formCidade">
            <div class="span3">
          
                <label for="">Cidade:</label>
                    <select class="span12" name="idCidade" id="idCidade" value="">
                    <? foreach($this->data['cidades'] as $valor){ ?>
                    	<?
							if($this->input->post('idCidade') == null){
								$idCidade = 1;
							} else {
								$idCidade = $this->input->post('idCidade');
							}
						?>
                        <option value="<? echo $valor->idCidade;?>" <? if($valor->idCidade == $idCidade){ echo "selected"; } ?> ><? echo $valor->cidade;?></option>
                    <? } ?>
                </select>
                
            </div>
            
            <div class="span2">
            	<label for="">&nbsp;</label>
                <button class="btn btn-success" id="btnContinuar" style="height:30px;"><i class="icon-ok icon-white"></i> Listar Bairros</button>
            </div>
            </form>
        </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Saida</th>
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
        <div class="span12" style="padding: 10px;">  
        <form action="<?php echo current_url(); ?>" method="post" id="formCidade">
            <div class="span3">
          
                <label for="">Cidade:</label>
                    <select class="span12" name="idCidade" id="idCidade" value="">
                    <? foreach($this->data['cidades'] as $valor){ ?>
                    	<?
							if($this->input->post('idCidade') == null){
								$idCidade = 1;
							} else {
								$idCidade = $this->input->post('idCidade');
							}
						?>
                        <option value="<? echo $valor->idCidade;?>" <? if($valor->idCidade == $idCidade){ echo "selected"; } ?> ><? echo $valor->cidade;?></option>
                    <? } ?>
                </select>
                
            </div>
            
            <div class="span2">
            	<label for="">&nbsp;</label>
                <button class="btn btn-success" id="btnContinuar" style="height:30px;"><i class="icon-ok icon-white"></i> Listar Bairros</button>
            </div>
            </form>
        </div>


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Saida</th>
            <th width="114px;">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
            echo '<tr>';
				echo '<td>'.$r->bairro.'</td>';
            	echo '<td>';
            if($this->permission->canUpdate()){
                echo '<a href="'.base_url().'tabelafrete/editar/'.$r->idBairro.'" style="margin-right: 1%" class="btn btn-info " title="Editar Tabela de Frete"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->canDelete()){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" id="'.$r->idBairro.'" style="margin-right: 1%" class="btn btn-danger " title="Excluir Tabela de Frete"><i class="icon-trash icon-white"></i></a>'; 
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




