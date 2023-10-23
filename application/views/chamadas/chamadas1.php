<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Clientes</li></ol>
            <ol class="breadcrumb"> 
            <?php //if($this->permission->canInsert()){ ?>
        
            <a 
                href="<?php echo base_url();?>chamadas/adicionar" 
                class="btn btn-success" 
                style="width: 135px;
            ">
            <i class="icon-plus icon-white"></i> Adicionar Chamada</a>

            <a 
                id="Pesquisar_Botao" 
                href="<?php echo base_url();?>financeiro/chamada"
                class="btn btn-primary" 
                style="width: 135px;
            ">
            
            <i class="icon-search icon-white"></i> Pesquisar Chamada</a> 



    <?php //} ?>
    </ol>
</nav>

<style type="text/css">

    tbody th, table.dataTable tbody td {
        padding: 2px !important;
    }

</style>



<?php

if(!$results){?>
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Chamadas</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>CHM</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Chamada</th>
                        <th>Repasse</th>
                        <th>Empresa</th>
                        <th>Funcionário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8">Nenhuma Chamada Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else { ?>
    <table class="table table-bordered table-striped" id="listagem_padrao">
        <thead>
            <tr>
                <th>CHM</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Repasse</th>
                <th>Funcionário</th>
                <th>Empresa</th>
                <th>Funcionário</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($results as $r){ 
                // Verificação de cores
                if($r->status=='3'){
                    $cor = "#75A9DD";   
                    $style = "style='color: black;'";
                } elseif($r->status=='1') {
                    $cor = "#FFCC00";
                    $style = "style='color: black;'";
                } elseif($r->status=='0'){
                    $cor = "red";
                    $style = "style='color: white;'";
                } elseif($r->status=='-5' || $r->statusPayment=='0' && $r->idFuncionario==NULL){
                    $cor = "#C02028";
                    $style = "style='color: white;'";
                } elseif($r->status=='-1'){
                    $existePreCadastro =true;
                    $cor = "#000";
                    $style = "style='color: white;'";
                } elseif($r->status=='-2'){
                    $existeTrechoSemValor =true;
                    $cor = "#666";
                    $style = "style='color: white;'";
                } else { 
                    $cor = NULL;
                    $style = NULL;  
                }

                # Modificando numeração com 0 na frente
                if($r->idChamada<=9){
                    $idChamada = "0".$r->idChamada; 
                } else {
                    $idChamada = $r->idChamada;     
                } 
            ?>
            <tr>
                <td><div style='background-color:#5bb75b; border-radius: 3px; padding-right: 6px; padding: 3px; color: #fff'><center><?php echo $idChamada; ?></center></div></strong></td>
                <td><?php echo substr($r->nomefantasia, 0, 40); ?></td>
                <td><center><?php echo date("d/m/Y", strtotime($r->data)); ?></center></td>
                <td><center><?php echo $r->hora; ?></center></td>
                <td><center><?php echo $r->hora_repasse; ?></center></td>
                <td><?php echo substr($r->funcionarioNome, 0, 25); ?></td>
                <td>R$ <?php echo number_format($r->valor_empresa, "2", ",", "."); ?></td>
                <td>R$ <?php echo number_format($r->valor_funcionario, "2", ",", "."); ?></td>
                <td>
                    <div style='background-color:<?php echo $cor; ?> !important; border-radius: 3px; padding-right: 6px; height: 20px !important; padding: 3px; color: #fff'><center></center></div></strong>
                </td>
                <td>
                    <?php echo '<a href="'.base_url().$this->permission->getIdPerfilAtual().'/chamadas/editar/'.$r->idChamada.'" style="margin-right: 1%" class="btn btn-info btn-icone-pequeno" title="Editar Chamada"><i class="icon-pencil icon-white"></i></a>'; ?>

                    <?php echo '<a href="#modal-excluir" role="button" data-toggle="modal" chamada="'.$r->idChamada.'" style="margin-right: 1%" class="btn btn-danger btn-icone-pequeno" title="Excluir Chamada"><i class="icon-trash icon-white"></i></a>'; ?>

                </td>
            </tr>
            <?php } ?>
        </tbody>
</table>
<?php } ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>chamadas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            <h5 id="myModalLabel">Excluir Chamada</h5>
        </div>

        <div class="modal-body">
            <input type="hidden" id="idChamada" name="idChamada" value="" />

            <h5 style="text-align: center;">Deseja realmente excluir este Chamada?</h5>
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
            var chamada = $(this).attr('chamada');
            $('#idChamada').val(chamada);
        });
        
        $( "#Pesquisar_Botao" ).click(function() {
            $("#Pesquisar").css("display","block");
            $("#pesquisa_base").css("display","none");
        }); 
    });
</script>


<script language="javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script language="javascript">
    $(document).ready(function() 
    {
        $('#listagem_padrao').DataTable({
            /*"fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $('td:eq(6)', nRow).append("<a href='item/x/idDesconto'><button class='btn-sm btn-primary'>Editar</button></a>");
            }, */           
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
            },  
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
             "order": false
        });
    });
</script>