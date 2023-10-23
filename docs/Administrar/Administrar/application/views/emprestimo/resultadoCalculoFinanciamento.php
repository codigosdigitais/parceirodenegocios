
<meta charset="utf-8">
<style>
.tabela-resultado-simulacao{width: 400px;}
</style>
<?php
//print_r($this->data['parcelamento']); die();

	$resumo = $this->data['resumo'];

	echo '<div class="div-result-simulacao">';
	echo '<input type="hidden" id="comprometimentoReal" value="'.$resumo->comprometimentoReal.'">';
	
	if ($resumo->situacao == 'simulacao') {
		if ($resumo->aprovado) 
			echo 'Financiamento Aprovado!';
		
		else {
			echo 'O financiamento não será aprovado.<br />';
			echo $resumo->motivo_reprovacao;
		}
	}
	
	echo '</div><br />';
	
	echo '<div class="div-desc-parcelamento">Demonstrativo de parcelamento</div>';
	$i = 0;
	echo '<table class="tabela-resultado-simulacao"><tbody>';
	foreach($this->data['parcelamento'] as $parcela){
		$i++;
		
		echo '<tr><td>Parcela #'. $i .'</td>';
		echo '<td>'. $parcela->data .'</td>';
		echo '<td class="alignR">R$ '. $parcela->valor .'</td></tr>';
		
	}

	echo '<tr><td></td>';
	echo '<td></td>';
	echo '<td class="alignR"><b>R$ '. $resumo->total .'</b></td></tr>';
	
	echo '</tbody></table>';
	
?>