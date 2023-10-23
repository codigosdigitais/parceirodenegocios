<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Documentos - Cedentes</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cedente</th>
                        <th>Documento</th>
                        <th>Data</th>
                        <th>Formato</th>
                        <th>Tamanho</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7">Nenhum Documento Cadastrado</td>
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
        <h5>Documentos - Cedentes</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Documento</th>
            <th>Data</th>
            <th>Formato</th>
            <th>Tamanho</th>
            <th style="width: 150px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->nomePessoaJF.'</td>';
            echo '<td>'.$r->nomearquivo.'</td>';
			echo '<td>'.date("d/m/Y", strtotime($r->data)).'</td>';
            echo '<td>'.$r->extensao.'</td>';
			echo '<td>'.$r->tamanho.' kbs</td>';
            echo '<td>';
            
            if ($r->arquivo != "")
    	        echo '<a href="'.base_url().'documentos_externo/download/'.$r->idDocumento.'" style="margin-right: 1%" class="btn " title="Download do Arquivo"><i class="icon-download-alt"></i></a>'; 
            else 
            	echo 'Não há documento';
    	        
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
  <form action="<?php echo base_url() ?>documentos/cedenteExcluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Documento</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idDocumento" name="idDocumento" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este Documento?</h5>
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
        
        var documento = $(this).attr('documento');
        $('#idDocumento').val(documento);

    });

});

</script>



