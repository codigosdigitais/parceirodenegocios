
<a id="Pesquisar_Botao" class="btn btn-primary" style="width: 125px;"><i class="icon-search icon-white"></i> Pesquisar Cliente</a> 


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Clientes</li></ol>
    <ol class="breadcrumb"> 
    <?php if($this->permission->canInsert()){ ?>

        <a href="<?php echo base_url();?>clientes/adicionar" class="btn btn-primary"><i class="icon-plus icon-white"></i> Adicionar Cliente</a>

        <a href="<?php echo base_url();?>relatorios/clientes" class="btn btn-danger" style="width: 125px;"><i class="icon-check icon-white"></i> Relatório</a>

    <?php } ?>
    </ol>
</nav>


<?php
if(!$results){?>
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
            <td colspan="6">Nenhum Cliente Cadastrado</td>
        </tr>
    </tbody>
</table>
<?php } else { ?>

<div class="widget-content nopadding">
<div id="Pesquisar" <? if(isset($_GET['razaosocial']) || isset($_GET['cnpj'])){ ?> <? } else { ?> style="display:none"<? } ?>>
        <div class="span12" style="padding: 10px;">
            <form action="<?php echo base_url()?>clientes" method="get">
            <div class="span6">
                <label for="">Razão Social</label>
                <input type="text" name="razaosocial" class="span12" value="<? if(isset($_GET['razaosocial'])){ echo $_GET['razaosocial']; } ?>" />
            </div>
            <div class="span4">
                <label for="">CPF/CNPJ</label>
                <input type="number" name="cnpj" class="span12" value="<? if(isset($_GET['cnpj'])){ echo $_GET['cnpj']; } ?>" />
            </div>
            
             <div class="span2">
                <label for="">&nbsp;</label>
                <button class="btn btn-inverse span12"><i class="icon-print icon-white"></i> Filtrar</button>
            </div>
            
            </form>
        </div>

</div>
</div>

<table class="table table-bordered table-striped listagem">
    <thead>
        <tr>
            <th width="5%">COD</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th>Responsável</th>
            <th>Situação</th>
            <th width="11%"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($results as $r) { 
                $situacao = ($r->situacao) ? "Ativo" : "Inativo";
        ?>
        <tr>
            <td><?php echo $r->idCliente; ?></td>
            <td><?php echo $r->razaosocial; ?></td>
            <td><?php echo $r->cnpj; ?></td>
            <td width="10%"><?php echo "(".$r->responsavel_telefone_ddd.") ".$r->responsavel_telefone; ?></td>
            <td><?php echo $r->responsavel; ?></td>
            <td><?php echo $situacao; ?></td>
            <td>

                <?php if($this->permission->canUpdate()){
                    echo '<a href="'.base_url().'clientes/editar/'.$r->idCliente.'" style="margin-right: 1%" class="btn btn-info btn-icone-pequeno  " title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
                }
                if($this->permission->canDelete()){
                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="'.$r->idCliente.'" style="margin-right: 1%" class="btn btn-danger btn-icone-pequeno " title="Excluir Cliente"><i class="icon-trash icon-white"></i></a>'; 
                }                
                ?>

            </td>
        </tr>        
        <?php } ?>
    </tbody>
</table>

<? 
	if(isset($_GET['razaosocial']) || isset($_GET['cnpj'])){ 
		
	} else {
		echo $this->pagination->create_links();	
	}
}
?>



 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>clientes/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Cliente</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCliente" name="idCliente" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este cliente?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<script type="text/javascript">
        $( "#Pesquisar_Botao" ).click(function() {
            $("#Pesquisar").css("display","block");
        });
/*
$('.listagem').DataTable({
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
        },
        "iDisplayLength": 100  
    });
    */

</script>




