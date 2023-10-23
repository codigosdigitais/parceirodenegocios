<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Contratos</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>
        <a href="<?php echo base_url();?>contratos/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Contrato</a>
        <a href="<?php echo base_url();?>relatorios/contratos" class="btn btn-danger" style="width: 125px;"><i class="icon-check icon-white"></i> Relatório</a>
    <?php } ?>
    </ol>
</nav>

<?php if(!$results){ ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Responsável</th>
            <th>Telefone</th>
            <th>Funcionários</th>
            <th>Valor Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">Nenhum Contrato Cadastrado</td>
        </tr>
    </tbody>
</table>
<?php } else { ?>
<table class="table table-bordered table-striped" id="lista-registros-padrao">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Responsável</th>
            <th>Ativo</th>
            <th>Renovação</th>
            <th>Funcionários</th>
            <th style="width: 150px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
		
		foreach ($results as $r) {
			//foreach($r->contratoFuncionarios as $funcionarios){ 

                if($r->renovacao==null) 
                    $r->renovacao = "-"; 
                else 
                    $r->renovacao = date("d/m/Y", strtotime($r->renovacao));
                
			
				echo '<tr>';
				echo '<td>'.$r->razaosocial.'</td>';
				echo '<td>'.$r->responsavel.'</td>';
				echo '<td>'.date("d/m/Y", strtotime($r->dataativo)).'</td>';
                echo '<td>'.$r->renovacao.'</td>';
				echo '<td><center>'.$r->total_funcionarios.'</center></td>';
				echo '<td>';
				if($this->permission->canSelect()){
					echo '<a href="'.base_url().'contratos/visualizar/'.$r->idContrato.'" style="margin-right: 1%" class="btn btn-icone-pequeno " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
				}
				if($this->permission->canUpdate()){
					echo '<a href="'.base_url().'contratos/editar/'.$r->idContrato.'" style="margin-right: 1%" class="btn btn-info btn-icone-pequeno" title="Editar contrato"><i class="icon-pencil icon-white"></i></a>'; 
				}
				if($this->permission->canDelete()){
					echo '<a href="#modal-excluir" role="button" data-toggle="modal" contrato="'.$r->idContrato.'" style="margin-right: 1%" class="btn btn-danger btn-icone-pequeno " title="Excluir contrato"><i class="icon-trash icon-white"></i></a>'; 
				}
	
				  
				echo '</td>';
				echo '</tr>';
		
			//	} 
		
		}
		?>
        <tr>
            
        </tr>
    </tbody>
</table>

<?php } //echo $this->pagination->create_links();}?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>contratos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir contrato</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idContrato" name="idContrato" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este contrato?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<script type="text/javascript">


$('#lista-registros-padrao').DataTable({
    language:{
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar",
        "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
        },
        "oAria": {
            "sSortAscending": ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
        }
    }
});



    $(document).ready(function(){
       $(document).on('click', 'a', function(event) {
            var contrato = $(this).attr('contrato');
            $('#idContrato').val(contrato);
        });
    });
</script>




