<style>
    #holerite {
        background-color: white;
        padding: 10px;
    }

    .table {
        width: 100%;
        border: solid 1px #B4B0B0;
        border-bottom: 2px solid #666;
    }

    .table_titles {
        font-size: 9px;
    }

    .table th,
    .table td {
        line-height: 20px;
        font-size: 11px;
    }

    .swal2-title,
    .swal2-html-container {
        font-size: 14px !important;
    }

    .swal2-icon-content {
        font-size: 44px !important;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo $dados['dados_funcionario']->nome; ?>
        </li>
    </ol>
</nav>


<?php
    // echo "<pre>";
    // print_r($dados);
    // echo "</pre>";
?>


<div id="holerite" style="background-color: white;">

    <table class="table">
        <tr>
            <td><strong>Registrado na Empresa: </strong><?php echo $dados['dados_funcionario']->empresa_registro; ?>
            </td>
            <td style="width: 260px"><strong>Referência:</strong>
                <?php echo date("d/m/Y", strtotime($dados['ciclo_selecionado'][0])); ?>
                a
                <?php echo date("d/m/Y", strtotime($dados['ciclo_selecionado'][1])); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>CNPJ: </strong><? echo $dados['dados_funcionario']->empresa_cnpj; ?></td>
        </tr>
    </table>

    <table class="table" style="margin-top: -15px;">
        <tr>
            <td class="table_titles"><strong>
                    <center>Código</center>
                </strong></td>
            <td class="table_titles"><strong>Nome do Funcionário</strong></td>
            <td class="table_titles"></td>
        </tr>
        <tr>
            <td>
                <center><? echo $dados['dados_funcionario']->idFuncionario; ?></center>
            </td>
            <td><? echo $dados['dados_funcionario']->nome; ?></td>
            <td>
                <?
					if($dados['dados_funcionario']->horista==0){ echo "Mensalista"; } else { echo "Horista"; }
				?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><? echo $dados['dados_funcionario']->funcao_cbo; ?> - <? echo $dados['dados_funcionario']->funcao; ?>
            </td>
            <td><strong>Admissão:
                </strong><? echo date("d/m/Y", strtotime($dados['dados_funcionario']->dataadmissao)); ?></td>
        </tr>
    </table>

    <table class="table" style="margin-top: -15px;">
        <tr>
            <td class="table_titles" style="width: 10%"><strong>
                    <center>Código</center>
                </strong></td>
            <td class="table_titles" style="width: 50%"><strong>Descrição</strong></td>
            <td class="table_titles" style="width: 20%"><strong>Vencimentos</strong></td>
            <td class="table_titles" style="width: 20%"><strong>Descontos</strong></td>
        </tr>
        <tr>
            <td>186</td>
            <td>Salário</td>
            <td>R$ <? echo number_format($dados['dados_funcionario']->salario, 2, ",", "."); ?></td>
            <td></td>
        </tr>


        <?
			$provento_total = 0;
			if(count($dados['provento'])>0){
				
				foreach($dados['provento'] as $valor){
                    $obj_valor = "R$ ".number_format($valor->valor, 2, ",", ".");
                    $provento_total += $valor->valor;
					
		?>
        <tr>
            <td><? echo $valor->codigoeSocial;?></td>
            <td><? echo ucfirst($valor->nome_provento); ?></td>
            <td><? echo $obj_valor; ?></td>
            <td></td>
        </tr>

        <?
				}
			}
        ?>

        <?
			$total_folha_proventos = 0;
			if(count($dados['folha_provento'])>0){
				
				foreach($dados['folha_provento'] as $valor){
					$obj_valor=0;
					if($valor->formato==1){
						$obj_valor = "R$ ".number_format($valor->valor, 2, ",", ".");
						$total_folha_proventos += $valor->valor;
					} else {
						$obj_valor = NULL;
					}
					
		?>
        <tr>
            <td><? echo $valor->codigoeSocial;?></td>
            <td><? echo ucfirst($valor->nome_funcao); ?></td>
            <td><? echo $obj_valor; ?></td>
            <td></td>
        </tr>

        <?
				}
			}
        ?>

        <?php 
            $total_periculosidade = 0;
			if($dados['dados_funcionario']->periculosidade==1)
            {

			if($dados['periculosidade'] > 0){ 

                $periculosidade = $dados['periculosidade'];
                $total_periculosidade = $periculosidade;
		?>
        <tr>
            <td>203</td>
            <td>Periculosidade</td>
            <td>R$ <? echo number_format($dados['periculosidade'], 2, ",", "."); ?></td>
            <td></td>
        </tr>
        <? } ?>
        <? } ?>

        <?
            $total_insalubridade = 0;
            if($dados['dados_funcionario']->insalubridade==1)
            {
			if($dados['insalubridade'] > 0){
                $total_insalubridade = $dados['insalubridade'];
		?>
        <tr>
            <td>202</td>
            <td>Insalubridade</td>
            <td>R$ <? echo number_format($dados['insalubridade'], 2, ",", "."); ?></td>
            <td></td>
        </tr>
        <? } ?>
        <? } ?>

        <?php 
			# Cálculo INSS
			$inss_faixa = ($dados['inss']->faixa) ? $dados['inss']->faixa : 0;
			$inss_valor_calculo = ($dados['dados_funcionario']->salario);
            $inss_valor = ($inss_valor_calculo / 100) * str_replace(",", ".", $inss_faixa);

            # Cálculo IRRF
            #$irr_faixa = $dados['irrf']->faixa; // sem registro no banco de dados
            $irr_faixa = '0'; // default
            $irr_valor_calculo = ($dados['dados_funcionario']->salario);
            $irr_valor = ($irr_valor_calculo / 100) * str_replace(",", ".", $irr_faixa);                
		?>

        <?php if($dados['credito']>0){ ?>
        <tr>
            <td>547</td>
            <td>Crédito</td>
            <td>R$ <? echo number_format($dados['credito'], 2, ",", "."); ?></td>
            <td></td>
        </tr>
        <?php 
        }
        if($dados['debito']>0){ ?>
        <tr>
            <td>548</td>
            <td>Débito</td>
            <td></td>
            <td>R$ <? echo number_format($dados['debito'], 2, ",", "."); ?></td>
        </tr>
        <?php } ?>

        <!-- descontos da folha normal -->
        <?
            $total_folha_descontos = 0;
            if(isset($dados['folha_desconto']) and $dados['folha_desconto'] != null){

                
                foreach($dados['folha_desconto'] as $valor){
                    $obj_valor=0;
                    $obj_valor = "R$ ".number_format($valor->valor_total, 2, ",", ".");
                    $total_folha_descontos += $valor->valor_total;
                    
        ?>
        <tr>
            <td><? echo $valor->codigoeSocial;?></td>
            <td><? echo ucfirst($valor->nome_parametro); ?></td>
            <td></td>
            <td><? echo $obj_valor; ?></td>
        </tr>
        <?
                }
            }
        ?>


        <!-- Emprestimo -->
        <?php
            if($dados['emprestimo']->p_total > 0){
        ?>
        <tr>
            <td>E021</td>
            <td>Empréstimo</td>
            <td></td>
            <td>R$ <?php echo number_format($dados['emprestimo']->p_total, 2, ',', '.'); ?>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <td></td>
            <td>INSS</td>
            <td></td>
            <td>R$ <? echo number_format($inss_valor, 2, ",", "."); ?></td>
        </tr>
        <!--
        <tr>
            <td></td>
            <td>IRRF</td>
            <td></td>
            <td>R$ <? echo number_format($irr_valor, 2, ",", "."); ?></td>
        </tr>
        -->
        <tr>
            <td></td>
            <td>Faltas</td>
            <td></td>
            <td>R$ <? echo number_format($dados['falta_total_valor'], 2, ",", ".");?></td>
        </tr>
        <tr>
            <td></td>
            <td>Atrasos</td>
            <td></td>
            <td>R$ <? echo number_format($dados['atraso_total_valor'], 2, ",", ".");?></td>
        </tr>
    </table>

    <table class="table" style="margin-top: -15px;">
        <tr>
            <td class="table_titles" style="width: 10%"></td>
            <td class="table_titles" style="width: 60%"></td>
            <td class="table_titles" style="width: 15%"><strong>Total de Vencimentos</strong></td>
            <td class="table_titles" style="width: 15%"><strong>Total de Descontos</strong></td>
        </tr>

        <?php

            $desconto = (
                            $total_folha_descontos + 
                            $dados['emprestimo']->p_total + 
                            $inss_valor + 
                            $dados['falta_total_valor'] + 
                            $dados['atraso_total_valor'] +
                            $dados['debito'] +
                            $irr_valor
                        );

            $total_vencimento = (
                                    $dados['dados_funcionario']->salario + 
                                    $provento_total + 
                                    $total_folha_proventos + 
                                    $total_periculosidade + 
                                    $total_insalubridade +
                                    $dados['credito']
                                );

        ?>

        <tr>
            <td></td>
            <td></td>
            <td>R$ <?php echo number_format($total_vencimento, 2, ',', '.'); ?>
            </td>
            <td>R$ <?php echo number_format($desconto, 2, ',', '.'); ?>
            </td>
        </tr>

        <?php

            // $liquido = (
            //                 $dados['dados_funcionario']->salario +
            //                 $dados['periculosidade'] +
            //                 $dados['credito'] + 
            //                 $total_folha_proventos 
            //             );

        ?>

        <tr>
            <td></td>
            <td></td>
            <td bgcolor="#CCC"><strong>Líquido a Receber</strong></td>
            <td bgcolor="#666666" style="color: white;"><strong>R$ <?php echo number_format($total_vencimento - $desconto, 2, ',', '.'); ?></strong>
            </td>
        </tr>
    </table>


    <table class="table" style="margin-top: -15px;">
        <tr>
            <td class="table_titles" style="width: 16%"><strong>Salário Base</strong></td>
            <td class="table_titles" style="width: 17%"><strong>Sal. Contr. INSS</strong></td>
            <td class="table_titles" style="width: 16%"><strong>Base Cálc. FGTS</strong></td>
            <td class="table_titles" style="width: 16%"><strong>FGTS do Mês</strong></td>
            <td class="table_titles" style="width: 16%"><strong>Base Cálc. IRRF</strong></td>
            <td class="table_titles" style="width: 16%"><strong>Faixa IRRF</strong></td>
        </tr>

        <tr>
            <td>R$ <? echo number_format($dados['dados_funcionario']->salario, 2, ",", "."); ?></td>
            <td>R$ <? echo number_format($inss_valor, 2, ",", "."); ?></td>
            <td>R$ <? echo number_format($total_vencimento, 2, ",", "."); ?></td>
            <td>R$ <? echo number_format($inss_valor, 2, ",", "."); ?></td>
            <td>R$ <? echo number_format($irr_valor, 2, ",", "."); ?></td>
            <td>R$ <?php echo number_format($irr_valor_calculo, 2, ",", "."); ?>
            </td>
        </tr>


    </table>

</div>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php if($dados['holerite_confirmado']==0){ ?>
        <button
            data-idFuncionario="<?php echo $dados['dados_funcionario']->idFuncionario; ?>"
            data-ciclo_1="<?=$dados['ciclo_selecionado'][0];?>"
            data-ciclo_2="<?=$dados['ciclo_selecionado'][1];?>"
            data-vencimentos="<?php echo $total_vencimento; ?>"
            data-descontos="<?php echo $desconto; ?>"
            data-liquido="<?php echo $total_vencimento - $desconto; ?>"
            class="btn btn-danger" id="confirmar-holerite" style="width: 135px;" type="button">
            <i class="icon-check"></i> Confirmar</button>
        <?php } ?>

        <a href="<?php echo base_url();?>holerites/imprimir/<?php echo $dados['dados_funcionario']->idFuncionario; ?>/<?=$dados['ciclo_selecionado'][0];?>/<?=$dados['ciclo_selecionado'][1];?>"
            class="btn btn-info " style="width: 135px;
        ">
            <i class="icon-print"></i> Imprimir Holerite</a>
        </a>
    </ol>
</nav>