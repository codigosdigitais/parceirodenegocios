<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Listagem de Holerites</li>
    </ol>

    <ol class="breadcrumb">

        <li class="breadcrumb-item">
            <label>Trocar Período: </label>
            <select class="trocarPeriodo botaoValor">
                <?php
                $i = 0;

                $ciclo_data_get = (!empty($this->uri->segment(4))) ? $this->uri->segment(4) : null;

                foreach ($ciclo_lista as $ciclo) {
                    if ($i>6) {
                        if ($ciclo_data_get !== null && $ciclo_data_get===$ciclo[0]) {
                            $selected = "selected='selected'";
                        } elseif ($ciclo_data_get === null) {
                            $hoje = date("Y-m", strtotime("-2 months"));
                            $selected = "";

                            if (strpos($ciclo[0], $hoje) !== false) {
                                $selected = "selected='selected'";
                            }
                        } else {
                            $selected = "";
                        } ?>
                <option value="<?php echo $ciclo[0]; ?>" <?=$selected; ?>> <?php echo date("d/m/Y", strtotime($ciclo[0]))." até ".date("d/m/Y", strtotime($ciclo[1])); ?>
                </option>
                <?php
                    }
                    $i++;
                }
                ?>
            </select>
        </li>

        <?php

                $totalBruto = 0;
                $totalLiquido = 0;
                $totalDesconto = 0;

               // echo "<pre>";
                foreach ($listagem_holerite as $item) {
                    // print_r($item->salario);
                    
                    if (isset($item->salario)) {
                        $totalBruto += isset($item->salario->bruto) ? $item->salario->bruto : 0;
                        $totalLiquido += isset($item->salario->liquido) ? $item->salario->liquido : 0;
                        $totalDesconto += isset($item->salario->desconto) ? $item->salario->desconto : 0;
                    }
                }
               // echo "</pre>";
            
            ?>
        <li class="breadcrumb-item"><button class="btn-sm btn-default botaoValor">Bruto: R$ <?php echo number_format($totalBruto, 2, ',', '.'); ?></button>
        </li>
        <li class="breadcrumb-item"><button class="btn-sm btn-warning botaoValor">Descontos: R$ <?php echo number_format($totalDesconto, 2, ',', '.'); ?></button>
        </li>
        <li class="breadcrumb-item"><button class="btn-sm btn-danger botaoValor">Pendente: R$ <?php echo number_format($totalLiquido, 2, ',', '.'); ?></button>
        </li>

    </ol>
</nav>

<?php
    if (!$listagem_holerite) {
        echo "Nenhum funcionário foi encontrado";
    } else {
        ?>
<style>
    .listar td {
        padding: 5px !important;
    }

    .botaoValor {
        height: 33px;
        border-radius: 5px;
    }
</style>
<table class="table table-bordered table-striped listar" id="listagem_padrao">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Função</th>
            <th>Banco</th>
            <th>Agência</th>
            <th>Conta</th>
            <th>Operação</th>
            <th>Salário</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listagem_holerite as $lista) { ?>
        <tr>
            <td><?php echo $lista->nome; ?>
            </td>
            <td><?php echo $lista->funcao_nome; ?>
            </td>
            <td><?php echo $lista->bancobanco; ?>
            </td>
            <td><?php echo $lista->bancoagencia; ?>
            </td>
            <td><?php echo $lista->bancoconta; ?>
            </td>
            <td><?php echo $lista->bancooperacao; ?>
            </td>
            <td>
                <?php
                    if (isset($lista->salario->liquido)) {
                        $salario_a_receber = $lista->salario->liquido;
                    } else {
                        $salario_a_receber = 0;
                    }
                ?>

                <?php if ($salario_a_receber > 0) { ?>
                <button type="button" class="btn-sm btn-success botaoValor" style="width:120px"><?php echo "R$ ".number_format($salario_a_receber, 2, ',', '.'); ?></button>
                <?php  } elseif ($salario_a_receber < 0) { ?>
                <button type="button" class="btn-sm btn-danger botaoValor" style="width:120px"><?php echo "R$ ".number_format($salario_a_receber, 2, ',', '.'); ?></button>
                <?php } else { ?>
                <button type="button" class="btn-sm btn-default botaoValor" style="width:120px"><?php echo "R$ ".number_format($salario_a_receber, 2, ',', '.'); ?></button>
                <?php } ?>
            </td>
            <td>
                <a
                    href="<?php echo base_url('holerites/gerar/'.$lista->idFuncionario); ?>/<?php echo $ciclo_atual[0]; ?>/<?php echo $ciclo_atual[1]; ?>">
                    <button type="button" class="btn-sm btn-warning botaoValor">Holerite</button>
                </a>

                <!--<button class="btn-sm btn-primary"><i class="fas icon-check" aria-hidden="true"></i></button>-->
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
    } ?>


<script language="javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script language="javascript">
    $(document).ready(function() {
        $('#listagem_padrao').DataTable({
            /*"fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $('td:eq(6)', nRow).append("<a href='item/x/idDesconto'><button class='btn-sm btn-primary'>Editar</button></a>");
            }, */
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
            },
            "lengthMenu": [
                [100, 250, 500, -1],
                [100, 250, 500, "All"]
            ]
        });
    });
</script>