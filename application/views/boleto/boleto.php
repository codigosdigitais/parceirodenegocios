<div id="imprimir">

<style>
	.table, table {
		height: auto !important;
		padding: 0px !important;
		margin: 0px !important;
		width: 700px;
		background-color: #FFFFFF !important;	
		font-family: Arial, Helvetica, sans-serif !important;
		font-size: 12px !important;
		color: #000000 !important; 
	}
	
	.tabela_instrucoes {
		border-bottom: dashed 1px #000000;	
	}
	
	.boleto_instrucoes {
		list-style: none;
		margin-left: 0px;	
		font-size: 11px;
		font-color: #000000 !important;
	}
	
	.boleto_grupo_banco {
		border-bottom: 2px solid #000;	
	}
	
	.boleto_grupo_banco_logo {
		border-right: 2px solid #000;
		width: 160px;
	}
	
	.boleto_grupo_banco_banco {
		border-right: 2px solid #000;
		width: 60px;
		font-size: 18px;
		padding: 5px;
		text-align: center !important;
	}

	.boleto_grupo_banco_linha {
		font-size: 15px;
		padding: 5px;
		text-align: right !important;
	}
	
	.boleto_titulos_pequenos {
		font-size: 9px !important;
		height:12px;	
	}
	
	.boleto_dados_basicos {
		font-size: 11px !important;
		height:18px;	
		padding-right: 5px;
	}
	
	.boleto_dados_basicos_demonstrativo {
		font-size: 11px !important;
		font-weight: bold;	
	}
	
	.boleto_grupo {
		border: solid 1px #000000;
	}
	
	.boleto_grupo_linha {
		border-bottom: solid 1px #000000;	
	}
	
	.boleto_grupo_cedente {
		border-right: 1px solid #000000;
		width: 300px;
		padding-left: 5px;	
	}
	
	.boleto_grupo_normal_left {
		border-left: 1px solid #000000;
		padding-left: 5px;		
	}
	
	.boleto_grupo_normal {
		border-right: 1px solid #000000;
		padding-left: 5px;	
	}	
	
	.boleto_grupo_normal_sem_borda {
		padding-left: 5px;	
	}
	
	.boleto_dados_valor_documento {
		text-align: right;	
		font-size: 11px !important;
		font-weight: bold !important;
		padding-right: 5px;	
	}
	
	.encaixe_179 {
		width: 179px !important;	
	}
	
	.padding_left {
		padding-left: 5px;	
	}
	
	.linha_bottom {
		border-bottom: 1px dashed #000000;	
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

<!--- Recibo do Sacado --->
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
            <div class="boleto_dados_basicos"></div>
        </td>
        <td class="boleto_grupo_normal_left boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(-) Outras deduções</div>
            <div class="boleto_dados_basicos"></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(+) Mora / Multa</div>
            <div class="boleto_dados_basicos"></div>
        </td>
        <td class="boleto_grupo_normal">
        	<div class="boleto_titulos_pequenos">(+) Outros acréscimos</div>
            <div class="boleto_dados_basicos"></div>
        </td>
        <td class="boleto_grupo_normal encaixe_179">
        	<div class="boleto_titulos_pequenos">(=) Valor cobrado</div>
            <div class="boleto_dados_basicos"></div>
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

<table style="width: 699px;">
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
</div>
<button id="imprimir_botao" name="imprimir_botao" style="btn btn-primary">Imprimir</button>
<script type="text/javascript">
    $(document).ready(function(){
        $("#imprimir_botao").click(function(){         
            PrintElem('#imprimir');
        })

        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'Entregas Rápidas - Controller', 'height=600,width=1100');
            mywindow.document.write('<html><head><title>Entregas Rápidas - Controller</title>');
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' />");
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");
            mywindow.document.write("</head><body>");
			mywindow.document.write("<div style='background-color: #FFFFFF; padding: 20px'>");
			mywindow.document.write("<style>table,td,tr { font-family: arial; font-size: 10px; } </style>");
            mywindow.document.write(data);
			mywindow.document.write('</div>');
            
            mywindow.document.write("</body></html>");


            return true;
        }

    });
</script>

