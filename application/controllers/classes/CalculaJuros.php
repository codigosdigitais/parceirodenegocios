<?php
class CalculaJuros {
	
	private $vl_financiado;
	private $qde_parcelas;
	private $forma_calc_juros;
	
	function __construct() {
		
	}
	
	function getValParcelaJurosSimples($valor, $taxa, $parcelas) {
		$taxa = $taxa /100;
	
		$juros = $valor * $taxa * $parcelas;
		$total = $valor + $juros;
		
		if (is_numeric($parcelas) && $parcelas > 0)
			$valParcela = $total / $parcelas;
		
		else
			$valParcela = 0;
	
		return $valParcela;
	}
	
	function getValParcelaJurosCompostos($valor, $taxa, $parcelas) {
		$taxa = $taxa /100;
	
		$total = $valor * pow((1 + $taxa), $parcelas);
		
		if (is_numeric($parcelas) && $parcelas > 0)
			$valParcela = $total / $parcelas;
		
		else
			$valParcela = 0;
	
		return $valParcela;
	}
}