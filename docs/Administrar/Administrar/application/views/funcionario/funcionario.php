<style type="text/css">
    .btn {
        padding: 5px 11px !important;
        margin-bottom: 0 !important;
        margin-top: 0 !important;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Lista de Funcionários</li>
    </ol>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            
            <?php if($this->permission->canInsert()){ ?>
                <a href="<?php echo base_url()?>funcionario/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Funcionário</a>
            <?php } ?>
            
        </li>
    </ol>

    <ol class="breadcrumb btn-danger">
        <li class="breadcrumb-item">Funcionários Ativos</li>
    </ol>
</nav>

<?php if(!$results){ ?>

<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefones</th>
            <th>Situação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Funcionário Cadastrado</td>
        </tr>
    </tbody>
</table>

<?php } else { ?>
<table class="table table-bordered stripe" id="listagem_ativos">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefones</th>
            <th>Situação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results as $r) {
            $situacao = ($r->situacao) ? "Ativo" : "Inativo";
        ?>
        <tr>
            <td><?php echo $r->nome; ?></td>
            <td><?php echo $r->endereco.", ".$r->endereconumero.", ".$r->enderecobairro." - ".$r->enderecocidade; ?></td>
            <td><?php echo '('.$r->responsaveltelefoneddd.') '.$r->responsaveltelefone.' | '.$r->responsavelcelular; ?></td>
            <td><?php echo $situacao; ?></td>
            <td>
                <?php

                    if($this->permission->canSelect()){
                        echo '<a href="'.base_url().'funcionario/visualizar/'.$r->idFuncionario.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                    }
                    if($this->permission->canUpdate()){
                        echo '<a style="margin-right: 1%" href="'.base_url().'funcionario/editar/'.$r->idFuncionario.'" class="btn btn-info " title="Editar Funcionário"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                    if($this->permission->canDelete()){
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" funcionario="'.$r->idFuncionario.'" class="btn btn-danger" title="Excluir Funcionário"><i class="icon-trash icon-white"></i></a>  '; 
                    } 

                ?>
            </td>
        </tr>
        <?php } ?>

    </tbody>
</table>
<?php } ?>


<hr>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb btn-primary">
        <li class="breadcrumb-item">Funcionários Inativos</li>
    </ol>
</nav>


<table class="table table-bordered stripe" id="listagem_inativos">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Telefones</th>
            <th>Situação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results_inativo as $r) {
            $situacao = ($r->situacao) ? "Ativo" : "Inativo";
        ?>
        <tr>
            <td><?php echo $r->nome; ?></td>
            <td><?php echo $r->endereco.", ".$r->endereconumero.", ".$r->enderecobairro." - ".$r->enderecocidade; ?></td>
            <td><?php echo '('.$r->responsaveltelefoneddd.') '.$r->responsaveltelefone.' | '.$r->responsavelcelular; ?></td>
            <td><?php echo $situacao; ?></td>
            <td>
                <?php

                    if($this->permission->canSelect()){
                        echo '<a href="'.base_url().'funcionario/visualizar/'.$r->idFuncionario.'" style="margin-right: 1%" class="btn " title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                    }
                    if($this->permission->canUpdate()){
                        echo '<a style="margin-right: 1%" href="'.base_url().'funcionario/editar/'.$r->idFuncionario.'" class="btn btn-info " title="Editar Funcionário"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                    if($this->permission->canDelete()){
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" funcionario="'.$r->idFuncionario.'" class="btn btn-danger" title="Excluir Funcionário"><i class="icon-trash icon-white"></i></a>  '; 
                    } 

                ?>
            </td>
        </tr>
        <?php } ?>

    </tbody>
</table>



<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>funcionario/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Funcionário</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idFuncionario" name="idFuncionario" value="" />
            <h5 style="text-align: center;">Deseja realmente excluir este Funcionário?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<script language="javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script language="javascript">
    $(document).ready(function() 
    {

        $(document).on('click', 'a', function(event) {
            var funcionario = $(this).attr('funcionario');
            $('#idFuncionario').val(funcionario);
        });

        /* Lista Funcionários Ativos */
        $('#listagem_ativos').DataTable({         
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
            },  
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });

        /* Lista Funcionários Ativos */
        $('#listagem_inativos').DataTable({         
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
            },  
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });
    });
</script>