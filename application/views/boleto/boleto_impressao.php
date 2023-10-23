<style type="text/css">
	table, .table {
		height: auto !important;
		padding: 0px !important;
		margin: 0px !important;
		width: 700px !important;
		background-color: #FFFFFF !important;	
		font-family: Arial, Helvetica, sans-serif !important;
		font-size: 12px !important;
		color: black !important;
		border-collapse: collapse;  
	}
	
	

	.tabela_instrucoes {
		border-bottom: dashed 1px black !important;
		border-collapse: collapse; 	
	}
	
	.boleto_instrucoes {
		list-style: none !important;
		margin-left: 0px !important;	
		font-size: 11px !important;
		font-color: black !important;
	}
	
	.boleto_grupo_banco {
		border-bottom: solid 2px black !important;	
		border-collapse: collapse; 
	}
	
	.boleto_grupo_banco_logo {
		border-right: 2px solid black !important;
		border-collapse: collapse; 
		width: 160px !important;
	}
	
	.boleto_grupo_banco_banco {
		border-right: solid 2px black !important;
		border-collapse: collapse; 
		width: 60px !important;
		font-size: 18px !important;
		padding: 5px !important;
		text-align: center !important;
	}

	.boleto_grupo_banco_linha {
		font-size: 15px !important;
		padding: 5px !important;
		text-align: right !important;
	}
	
	.boleto_titulos_pequenos {
		font-size: 9px !important;
		height:12px !important;	
	}
	
	.boleto_dados_basicos {
		font-size: 11px !important;
		height:18px !important;	
		padding-right: 5px !important;
	}
	
	.boleto_dados_basicos_demonstrativo {
		font-size: 11px !important;
		font-weight: bold !important;	
	}
	
	.boleto_grupo {
		border: solid 1px black !important;
		border-collapse: collapse; 
	}
	
	.boleto_grupo_linha {
		border: 1px solid black !important;	
	}
	
	.boleto_grupo_cedente {
		border-right: solid 1px black !important;
		border-collapse: collapse; 
		width: 300px !important;
		padding-left: 5px !important;	
	}
	
	.boleto_grupo_normal_left {
		border-left: solid 1px black !important;
		border-collapse: collapse; 
		padding-left: 5px !important;		
	}
	
	.boleto_grupo_normal {
		border-right: 1px solid black !important;
		border-collapse: collapse; 
		padding-left: 5px !important;	
	}	
	
	.boleto_grupo_normal_sem_borda {
		padding-left: 5px !important;	
	}
	
	.boleto_dados_valor_documento {
		text-align: right !important;	
		font-size: 11px !important;
		font-weight: bold !important;
		padding-right: 5px !important;	
	}
	
	.encaixe_179 {
		width: 179px !important;	
	}
	
	.padding_left {
		padding-left: 5px !important;	
	}
	
	.linha_bottom {
		border-bottom: dashed 1px black !important;	
		border-collapse: collapse; 
	}
	
</style>

<!--- Instruções de Impressão do Boleto CEF --->
<table class="tabela_instrucoes">
	<tr>
    	<td><center><strong>Instruções de Impressão</strong></center></td>
    </tr>
    <tr>
    	<td>
        	<ul class="boleto_instrucoes">
                <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).</li>
                <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.</li>
                <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.</li>
                <li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.</li>
                <li>Caso tenha problemas ao imprimir, copie a seqüencia numérica abaixo e pague no caixa eletrônico ou no internet banking:</li>
            </ul>
        </td>
        <tr>
        	<td><strong>Linha Digitável:</strong> <?php echo $dadosboleto["linha_digitavel"]?></td>
        </tr>
        <tr>
        	<td><strong>Valor:</strong> R$ <?php echo $dadosboleto["valor_boleto"]?></td>
        </tr>
    </tr>
</table>


<table>
	<tr>
    	<td style="text-align: right" class="boleto_instrucoes"><strong>Recibo do Sacado</strong></td>
    </tr>
</table>

<table>
	<tr class="boleto_grupo_banco">
    	<td class="boleto_grupo_banco_logo"><img src="<? echo base_url('assets/img/boleto'); ?>/imagens/logocaixa.jpg" width="150" height="40" border=0></td>
        <td class="boleto_grupo_banco_banco"><?php echo $dadosboleto["codigo_banco_com_dv"]?></td>
        <td class="boleto_grupo_banco_linha"><?php echo $dadosboleto["linha_digitavel"]?></td>
    </tr>
</table>

<table class="boleto_grupo">
	<tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_cedente">
        	<div class="boleto_titulos_pequenos">Cedente</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["cedente"]; ?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Agência/Código do Cedente</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["agencia_codigo"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Espécie</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["especie"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Quantidade</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["quantidade"]?></div>
        </td>
        <td class="boleto_grupo_normal_sem_borda">
        	<div class="boleto_titulos_pequenos">Nosso Número</div>
            <div class="boleto_dados_valor_documento"><?php echo $dadosboleto["nosso_numero"]?></div>
        </td>
    </tr>
    
    <tr>
    	<td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Número do Documento</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["numero_documento"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">CPF/CNPJ</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["cpf_cnpj"]?></div>        
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Vencimento</div>
            <div class="boleto_dados_basicos"><?php echo ($dadosboleto["data_vencimento"] != "") ? $dadosboleto["data_vencimento"] : "Contra Apresentação" ?></div>        
        </td>
        <td colspan="2" class="boleto_grupo_normal_sem_borda">
        	<div class="boleto_titulos_pequenos">Valor do Documento</div>
            <div class="boleto_dados_valor_documento">R$ <?php echo $dadosboleto["valor_boleto"]?></div>        
        </td>
    </tr>
</table>

<table>
	<tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">(-) Desconto / Abatimento</div>
            <div class="boleto_dados_basicos">&nbsp;</div>
        </td>
        <td class="boleto_grupo_normal_left boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(-) Outras deduções</div>
            <div class="boleto_dados_basicos">&nbsp;</div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(+) Mora / Multa</div>
            <div class="boleto_dados_basicos">&nbsp;</div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(+) Outros acréscimos</div>
            <div class="boleto_dados_basicos">&nbsp;</div>
        </td>
        <td class="boleto_grupo_normal encaixe_179">
        	<div class="boleto_titulos_pequenos">(=) Valor cobrado</div>
            <div class="boleto_dados_basicos">&nbsp;</div>
        </td>
    </tr>
    
    <tr class="boleto_grupo_linha boleto_grupo_normal_left boleto_grupo_normal">
    	<td colspan="5">
        	<div class="boleto_titulos_pequenos padding_left">Sacado</div>
            <div class="boleto_dados_basicos padding_left"><?php echo $dadosboleto["sacado"]?></div>
        </td>
    </tr>
    
    <tr>
    	<td colspan="5">
        	<div class="boleto_titulos_pequenos padding_left">Demonstrativo</div>
            <div class="boleto_dados_basicos_demonstrativo padding_left">
				  <?php echo $dadosboleto["demonstrativo1"]?><br>
                  <?php echo $dadosboleto["demonstrativo2"]?><br>
                  <?php echo $dadosboleto["demonstrativo3"]?><br>
            </div>
        </td>
    </tr>
</table>

<table>
	<tr>
    	<td style="text-align: right" class="boleto_instrucoes linha_bottom"><strong>Corte na linha Pontilhada</strong></td>
    </tr>
</table>

<!---- Recibo do Cedente --->

<table>
	<tr>
    	<td>&nbsp;</td>
    </tr>
	<tr class="boleto_grupo_banco">
    	<td class="boleto_grupo_banco_logo"><img src="<? echo base_url('assets/img/boleto'); ?>/imagens/logocaixa.jpg" width="150" height="40" border=0></td>
        <td class="boleto_grupo_banco_banco"><?php echo $dadosboleto["codigo_banco_com_dv"]?></td>
        <td class="boleto_grupo_banco_linha"><?php echo $dadosboleto["linha_digitavel"]?></td>
    </tr>
</table>


<table class="boleto_grupo">
	<tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Local de Pagamento</div>
            <div class="boleto_dados_basicos">Pagável em qualquer Banco até o Vencimento</div>
        </td>
        <td class="boleto_grupo_normal_sem_borda encaixe_179">
        	<div class="boleto_titulos_pequenos">Vencimento</div>
            <div class="boleto_dados_valor_documento"><?php echo ($dadosboleto["data_vencimento"] != "") ? $dadosboleto["data_vencimento"] : "Contra Apresentação" ?></div>
        </td>
    </tr>
    
    <tr>
    	<td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Cedente</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["cedente"]?></div>
        </td>
        <td class="boleto_grupo_normal_sem_borda encaixe_179">
        	<div class="boleto_titulos_pequenos">Agência/Código Cedente</div>
            <div class="boleto_dados_valor_documento"><?php echo $dadosboleto["agencia_codigo"]?></div>        
        </td>
    </tr>
</table>

<table>
	<tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">Data do Documento</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["data_documento"]?></div>
        </td>
        <td class="boleto_grupo_normal_left boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Nº Documento</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["numero_documento"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Espécie Doc.</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["especie_doc"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Aceite</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["aceite"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Data Processamento</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["data_processamento"]?></div>
        </td>
        <td class="boleto_grupo_normal encaixe_179">
        	<div class="boleto_titulos_pequenos">Nosso Número</div>
            <div class="boleto_dados_valor_documento"><?php echo $dadosboleto["nosso_numero"]?></div>
        </td>
    </tr>
</table>

<table>
	<tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">Uso do banco</div>
            <div class="boleto_dados_basicos"></div>
        </td>
        <td class="boleto_grupo_normal_left boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Carteira</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["carteira"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Espécie</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["especie"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Quantidade</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["quantidade"]?></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">Valor Documento</div>
            <div class="boleto_dados_basicos"><?php echo $dadosboleto["valor_unitario"]?></div>
        </td>
        <td class="boleto_grupo_normal encaixe_179">
        	<div class="boleto_titulos_pequenos">(=) Valor Documento</div>
            <div class="boleto_dados_valor_documento">R$ <?php echo $dadosboleto["valor_boleto"]?></div>
        </td>
    </tr>
</table>

<table>
	<tr class="boleto_grupo_linha  boleto_grupo_normal_left">
    	<td rowspan="6" valign="top">
        	<div class="boleto_titulos_pequenos">Instruções para o Caixa</div>
            <div class="boleto_dados_basicos">
				<?php echo $dadosboleto["instrucoes1"]; ?><br>
                <?php echo $dadosboleto["instrucoes2"]; ?><br>
                <?php echo $dadosboleto["instrucoes3"]; ?><br>
                <?php echo $dadosboleto["instrucoes4"]; ?>
            </div>

        </td>
    </tr>
    <tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal encaixe_179 boleto_grupo_normal_left">        	
        	<div class="boleto_titulos_pequenos">(-) Desconto / Abatimentos</div>
            <div class="boleto_dados_valor_documento">&nbsp;</div>
        </td>
    </tr>
    <tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal encaixe_179 boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">(-) Outras deduções</div>
            <div class="boleto_dados_valor_documento">&nbsp;</div>
        </td>
    </tr>
    <tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal encaixe_179 boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">(+) Mora / Multa</div>
            <div class="boleto_dados_valor_documento">&nbsp;</div>
        </td>
    </tr>
    <tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal encaixe_179 boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">(+) Outros acréscimos</div>
            <div class="boleto_dados_valor_documento">&nbsp;</div>
        </td>
    </tr>
    <tr class="boleto_grupo_linha">
    	<td class="boleto_grupo_normal encaixe_179 boleto_grupo_normal_left">
        	<div class="boleto_titulos_pequenos">(=) Valor cobrado</div>
            <div class="boleto_dados_valor_documento">&nbsp;</div>
        </td>
    </tr>

</table>

<table>
   <tr class="boleto_grupo_linha boleto_grupo_normal_left boleto_grupo_normal">
    	<td colspan="2">
        	<div class="boleto_titulos_pequenos padding_left">Sacado</div>
            <div class="boleto_dados_basicos_demonstrativo padding_left">
				  <?php echo $dadosboleto["sacado"]?><Br />
				  <?php echo $dadosboleto["endereco1"]?><br />
                  <?php echo $dadosboleto["endereco2"]?><br>
            </div>
        </td>
    </tr>
    
    <tr style="height:30px;">
    	<td>
        	<div class="boleto_titulos_pequenos padding_left">Sacador/Avalista</div>
        </td>
    	<td>
        	<div class="boleto_titulos_pequenos padding_left" style="text-align: right">Autenticação mecânica - Ficha de Compensação</div>
        </td>
    </tr>
	
    <tr>
    	<td colspan="2" style="padding-left: 10px;">
        	<?php $this->boleto_model->fbarcode($dadosboleto["codigo_barras"]); ?>
        </td>
    </tr>   
</table>

<table>
	<tr>
    	<td style="text-align: right" class="boleto_instrucoes linha_bottom"><strong>Corte na linha Pontilhada</strong></td>
    </tr>
</table>
