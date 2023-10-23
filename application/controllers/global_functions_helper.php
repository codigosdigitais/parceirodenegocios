<?
/*
* @autor: Davi Siepmann
* @date: 18/09/2015
* @based on: views/financeiro/view/chamada.php
* 
* @autor: André Baill
* @date: 14/10/2020
* @description: manutenção da validação de CPF
*/
if(!function_exists('conv_monetario_br'))
{
  function conv_monetario_br($value)
  {
   return number_format($value, "2", ",", ".");
  }
}
if(!function_exists('conv_porcent_sem_decimal'))
{
  function conv_porcent_sem_decimal($value)
  {
   return number_format($value, "0", ",", ".");
  }
}

if(!function_exists('conv_porcent_1_decimal'))
{
	function conv_porcent_1_decimal($value)
	{
		return number_format($value, "1", ",", ".");
	}
}
if(!function_exists('conv_porcent_3_decimal'))
{
  function conv_porcent_3_decimal($value)
  {
   return number_format($value, "3", ",", ".");
  }
}
if(!function_exists('conv_num_para_base'))
{
  function conv_num_para_base($value)
  {
	$value = str_replace(".", "", $value);
	return str_replace(",", ".", $value);
  }
}
if(!function_exists('conv_data_DMY_para_YMD'))
{
	function conv_data_DMY_para_YMD($data)
	{
		if (strpos($data, '/')) {
			list($day, $month, $year) = explode('/', $data);
			$data = $year .'-'. $month .'-'. $day; 
		}
		return $data;
	}
}
if(!function_exists('conv_data_YMD_para_DMY'))
{
	function conv_data_YMD_para_DMY($data)
	{
		if (strpos($data, '-')) {
			list($year, $month, $day) = explode('-', $data);
			$data = $day .'/'. $month .'/'. $year;
		}
		return $data;
	}
}

if(!function_exists('conv_data_YMDHMS_para_DMYHMS'))
{
	function conv_data_YMDHMS_para_DMYHMS($data)
	{
		if (strpos($data, ' ')) {
			$data = explode(' ', $data);
			list($year, $month, $day) = explode('-', $data[0]);
			$dmy = $day .'/'. $month .'/'. $year;
		}
		return $dmy .' '. $data[1];
	}
}
if(!function_exists('soma_em_data'))
{
	function soma_em_data($data, $soma, $DMY)
	{
		$data = strtotime($data);
		
		switch ($DMY)
		{
			case 'M' : $data = date("Y-m-d", strtotime('+'. $soma .' month', $data));
				break;
			 
		}
		
		return $data;
	}
}
if(!function_exists('validaCPF'))
{
	function validaCPF($cpf = null) {
	 
		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}
	 
		$cpf = preg_replace('/[^0-9]/', '', $cpf);		 

		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			 
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
	 
			return true;
		}
	}
}
if(!function_exists('validaCNPJ'))
{
	function validaCNPJ($cnpj)
	{
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;
		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
	}
}/*if(!function_exists('fillArrPositions')) {	function fillArrPositions($array, $startIndex, $finalIndex, $value) {				if (is_array($array)) {			$all = array_fill($startIndex, $finalIndex, $value);						$filled = $array + $all;			ksort($filled);						$array = array();			for ($i=1; $i <= count($filled); $i++) {				$array[] = $filled[$i];			}						//$array = $filled;		}		return $array;	}}*/
?>