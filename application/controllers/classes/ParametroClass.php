<?php
class ParametroClass {
	
	function __construct() {
		
	}

	function getDescricaoAcesso($acessoParam) {
		$acesso = $acessoParam;
			
		if ($acessoParam == 'sisadmin') $acesso = "SIS Admin";
		if ($acessoParam == 'perfil') $acesso = "via Perfil apenas";
		if ($acessoParam == 'usuario') $acesso = "Usuário pode definir";
			
		return $acesso;
	}
	
	
	function getInputInformarValor($tipoParam, $valorAtual, $valoresPossiveis) {
		$input = "";
	
		switch ($tipoParam) {
			case 'VF' :
				$keyValues = array(0 => 'Falso', 1 => 'Verdadeiro');
				$input = $this->getSelectInput($keyValues, $valorAtual);
				break;
	
			case 'texto' :
				$input = "<input type='text' id='valorParametro' name='valorParametro' class='input-small' value='".$valorAtual."' maxlength='60' placeholder='Texto padrão'>";
				break;
	
			case 'inteiro' :
				$input = "<input type='text' id='valorParametro' name='valorParametro' class='input-small mascara_numero_sem_decimal' value='".$valorAtual."' maxlength='60' placeholder='Núm. padrão'>";
				break;
	
			case 'real' :
				$input = "<input type='text' id='valorParametro' name='valorParametro' class='input-small mascara_float_3_digitos' value='".$valorAtual."' maxlength='60' placeholder='Val. padrão'>";
				break;
	
			case 'faixaInteiro' :
				$valorAtualInicial = (count($valorAtual) > 0) ? $valorAtual[0] : "";
				$valorAtualFinal   = (count($valorAtual) > 1) ? $valorAtual[1] : "";
				$valorAtualPadrao  = (count($valorAtual) > 2) ? $valorAtual[2] : "";
				$input = "<input type='text' id='valorParametroInicial' name='valorParametroInicial' class='input-small mascara_numero_sem_decimal' value='".$valorAtualInicial."' maxlength='60' placeholder='Núm. Inicial'>";
				$input.= "<input type='text' id='valorParametroFinal' name='valorParametroFinal' class='input-small mascara_numero_sem_decimal' value='".$valorAtualFinal."' maxlength='60' placeholder='Núm. Final'>";
				$input.= "<input type='text' id='valorParametro' name='valorParametro' class='input-small mascara_numero_sem_decimal' value='".$valorAtualPadrao."' maxlength='60' placeholder='Núm. padrão'>";
				break;
	
			case 'faixaReal' :
				$valorAtualInicial = (count($valorAtual) > 0) ? $valorAtual[0] : "";
				$valorAtualFinal   = (count($valorAtual) > 1) ? $valorAtual[1] : "";
				$valorAtualPadrao  = (count($valorAtual) > 2) ? $valorAtual[2] : "";
				$input = "<input type='text' id='valorParametroInicial' name='valorParametroInicial' class='input-small mascara_float_3_digitos' value='".$valorAtualInicial."' maxlength='60' placeholder='Val. Inicial'>";
				$input.= "<input type='text' id='valorParametroFinal' name='valorParametroFinal' class='input-small mascara_float_3_digitos' value='".$valorAtualFinal."' maxlength='60' placeholder='Val. Final'>";
				$input.= "<input type='text' id='valorParametro' name='valorParametro' class='input-small mascara_float_3_digitos' value='".$valorAtualPadrao."' maxlength='60' placeholder='Val. padrão'>";
				break;
	
			case 'array' :
				$input = $this->getSelectInput($valoresPossiveis, $valorAtual);
				break;
		}
	
		return $input;
	}
	
	function getDescricaoValPadraoSistema($tipoParam, $valoresPossiveis, $valorPadrao) {
		$valor = $valorPadrao;
		
		switch ($tipoParam) {
			case 'VF' :
				$valor = ($valorPadrao) ? 'Verdadeiro' : 'Falso';
				break;
			case 'faixaInteiro' :
				$valorPadrao = unserialize($valorPadrao);
				$valor = $valorPadrao[0]." à ".$valorPadrao[1]." padrão: ".$valorPadrao[2];
				break;
		
			case 'faixaReal' :
				$valorPadrao = unserialize($valorPadrao);
				$valor = $valorPadrao[0]." à ".$valorPadrao[1]." padrão: ".$valorPadrao[2];
				break;
		
			case 'array' :
				foreach ($valoresPossiveis as $key => $value) if ($key == $valorPadrao) $valor = $value;
				break;
		}
		
		return $valor;
	}
	
	private function getSelectInput($keyValues, $valorAtual) {
		$input = "<select id='valorParametro' name='valorParametro' class='input-large'>";
		$input.= "<option></option>";
		
		foreach ($keyValues as $key => $value) {
			$input .= "<option value='".$key."' ";

			if (null != $valorAtual && $key == $valorAtual) $input .= "selected";
			
			$input .= ">".$value."</option>";
		}
		
		$input .= "</select>";
		
		return $input;
	}
	
	function getDescricaoTipo($tipoParam) {
		$tipo = $tipoParam;
			
		switch ($tipoParam) {
			case 'VF' :
				$tipo = 'Verdadeiro e Falso';
				break;
					
			case 'texto' :
				$tipo = 'Texto';
				break;
	
			case 'inteiro' :
				$tipo = 'Numérico';
				break;
	
			case 'real' :
				$tipo = 'Valor';
				break;
	
			case 'faixaInteiro' :
				$tipo = 'Faixa Numérico';
				break;
	
			case 'faixaReal' :
				$tipo = 'Faixa Valores';
				break;
	
			case 'array' :
				$tipo = 'Conjunto /Array';
				break;
		}
			
		return $tipo;
	}
}