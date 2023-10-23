<?
class boleto_model extends CI_Model {

		function __construct() {
			parent::__construct();
		}
		
		public function getModulosCategoria(){
			$sql = "SELECT * FROM modulos WHERE idModuloBase = '0' ORDER BY modulo ASC";
			$consulta = $this->db->query($sql)->result();	
			
				foreach($consulta as &$valor){
					$sql_model = "SELECT * FROM modulos WHERE idModuloBase = '{$valor->idModulo}' ORDER BY modulo ASC";
					$valor->subModulo = $this->db->query($sql_model)->result();		
				}
			
			return $consulta;
		}

		
		function sequenciaNossoNumero($nossoNumero) {
			$constante1 = substr($nossoNumero, 0, 1);
			$constante2 = substr($nossoNumero, 1, 1);
		
			$sequencia1 = substr($nossoNumero, 2, 3);
			$sequencia2 = substr($nossoNumero, 5, 3);
			$sequencia3 = substr($nossoNumero, 8, 9);
		
			return $sequencia1 . $constante1 . $sequencia2 . $constante2 . $sequencia3;
		}
		
		function digitoVerificador_nossonumero($numero) {
			$resto2 = $this->modulo_11($numero, 9, 1);
			 $digito = 11 - $resto2;
			 if ($digito == 10 || $digito == 11) {
				$dv = 0;
			 } else {
				$dv = $digito;
			 }
			 return $dv;
		}
		
		
		function digitoVerificador_barra($numero) {
			$resto2 = $this->modulo_11($numero, 9, 1);
			 if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
				$dv = 1;
			 } else {
				$dv = 11 - $resto2;
			 }
			 return $dv;
		}
		
		
		// FUNÇÕES
		// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco
		
		function formata_numero($numero,$loop,$insert,$tipo = "geral") {
			if ($tipo == "geral") {
				$numero = str_replace(",","",$numero);
				while(strlen($numero)<$loop){
					$numero = $insert . $numero;
				}
			}
			if ($tipo == "valor") {
				/*
				retira as virgulas
				formata o numero
				preenche com zeros
				*/
				$numero = str_replace(",","",$numero);
				while(strlen($numero)<$loop){
					$numero = $insert . $numero;
				}
			}
			if ($tipo == "convenio") {
				while(strlen($numero)<$loop){
					$numero = $numero . $insert;
				}
			}
			return $numero;
		}
		
		
		function fbarcode($valor){
		
		$fino = 1 ;
		$largo = 3 ;
		$altura = 50 ;
		
		  $barcodes[0] = "00110" ;
		  $barcodes[1] = "10001" ;
		  $barcodes[2] = "01001" ;
		  $barcodes[3] = "11000" ;
		  $barcodes[4] = "00101" ;
		  $barcodes[5] = "10100" ;
		  $barcodes[6] = "01100" ;
		  $barcodes[7] = "00011" ;
		  $barcodes[8] = "10010" ;
		  $barcodes[9] = "01010" ;
		  for($f1=9;$f1>=0;$f1--){
			for($f2=9;$f2>=0;$f2--){
			  $f = ($f1 * 10) + $f2 ;
			  $texto = "" ;
			  for($i=1;$i<6;$i++){
				$texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
			  }
			  $barcodes[$f] = $texto;
			}
		  }
		
		
		//Desenho da barra
		
		
		//Guarda inicial
		?><img src=<? echo base_url('assets/img/boleto'); ?>/imagens/p.png width=<?php echo $fino?> height=<?php echo $altura?> style="height:<?php echo $altura?>px" border=0><img
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?>  style="height:<?php echo $altura?>px" border=0><img
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/p.png width=<?php echo $fino?> height=<?php echo $altura?>  style="height:<?php echo $altura?>px" border=0><img
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?>  style="height:<?php echo $altura?>px" border=0><img
		<?php
		$texto = $valor ;
		if((strlen($texto) % 2) <> 0){
			$texto = "0" . $texto;
		}
		
		// Draw dos dados
		while (strlen($texto) > 0) {
		  $i = round($this->esquerda($texto,2));
		  $texto = $this->direita($texto,strlen($texto)-2);
		  $f = $barcodes[$i];
		  for($i=1;$i<11;$i+=2){
			if (substr($f,($i-1),1) == "0") {
			  $f1 = $fino ;
			}else{
			  $f1 = $largo ;
			}
		?>
			src=<? echo base_url('assets/img/boleto'); ?>/imagens/p.png width=<?php echo $f1?> height=<?php echo $altura?>  style="height:<?php echo $altura?>px" border=0><img
		<?php
			if (substr($f,$i,1) == "0") {
			  $f2 = $fino ;
			}else{
			  $f2 = $largo ;
			}
		?>
			src=<? echo base_url('assets/img/boleto'); ?>/imagens/b.png width=<?php echo $f2?> height=<?php echo $altura?>  style="height:<?php echo $altura?>px" border=0><img
		<?php
		  }
		}
		
		// Draw guarda final
		?>
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/p.png width=<?php echo $largo?> height=<?php echo $altura?> style="height:<?php echo $altura?>px"  border=0><img
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/b.png width=<?php echo $fino?> height=<?php echo $altura?> style="height:<?php echo $altura?>px"  border=0><img
		src=<? echo base_url('assets/img/boleto'); ?>/imagens/p.png width=<?php echo 1?> height=<?php echo $altura?> style="height:<?php echo $altura?>px"  border=0>
		  <?php
		} //Fim da função
		
		function esquerda($entra,$comp){
			return substr($entra,0,$comp);
		}
		
		function direita($entra,$comp){
			return substr($entra,strlen($entra)-$comp,$comp);
		}
		
		function fator_vencimento($data) {
		  if ($data != "") {
			$data = explode("/",$data);
			$ano = $data[2];
			$mes = $data[1];
			$dia = $data[0];
			return(abs(($this->_dateToDays("1997","10","07")) - ($this->_dateToDays($ano, $mes, $dia))));
		  } else {
			return "0000";
		  }
		}
		
		function _dateToDays($year,$month,$day) {
			$century = substr($year, 0, 2);
			$year = substr($year, 2, 2);
			if ($month > 2) {
				$month -= 3;
			} else {
				$month += 9;
				if ($year) {
					$year--;
				} else {
					$year = 99;
					$century --;
				}
			}
			return ( floor((  146097 * $century)    /  4 ) +
					floor(( 1461 * $year)        /  4 ) +
					floor(( 153 * $month +  2) /  5 ) +
						$day +  1721119);
		}
		
		function modulo_10($num) {
				$numtotal10 = 0;
				$fator = 2;
		
				// Separacao dos numeros
				for ($i = strlen($num); $i > 0; $i--) {
					// pega cada numero isoladamente
					$numeros[$i] = substr($num,$i-1,1);
					// Efetua multiplicacao do numero pelo (falor 10)
					$temp = $numeros[$i] * $fator;
					$temp0=0;
					foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
					$parcial10[$i] = $temp0; //$numeros[$i] * $fator;
					// monta sequencia para soma dos digitos no (modulo 10)
					$numtotal10 += $parcial10[$i];
					if ($fator == 2) {
						$fator = 1;
					} else {
						$fator = 2; // intercala fator de multiplicacao (modulo 10)
					}
				}
		
				// várias linhas removidas, vide função original
				// Calculo do modulo 10
				$resto = $numtotal10 % 10;
				$digito = 10 - $resto;
				if ($resto == 0) {
					$digito = 0;
				}
		
				return $digito;
		
		}
		
		function modulo_11($num, $base=9, $r=0)  {
			/**
			 *   Autor:
			 *           Pablo Costa <pablo@users.sourceforge.net>
			 *
			 *   Função:
			 *    Calculo do Modulo 11 para geracao do digito verificador
			 *    de boletos bancarios conforme documentos obtidos
			 *    da Febraban - www.febraban.org.br
			 *
			 *   Entrada:
			 *     $num: string numérica para a qual se deseja calcularo digito verificador;
			 *     $base: valor maximo de multiplicacao [2-$base]
			 *     $r: quando especificado um devolve somente o resto
			 *
			 *   Saída:
			 *     Retorna o Digito verificador.
			 *
			 *   Observações:
			 *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
			 *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
			 */
		
			$soma = 0;
			$fator = 2;
		
			/* Separacao dos numeros */
			for ($i = strlen($num); $i > 0; $i--) {
				// pega cada numero isoladamente
				$numeros[$i] = substr($num,$i-1,1);
				// Efetua multiplicacao do numero pelo falor
				$parcial[$i] = $numeros[$i] * $fator;
				// Soma dos digitos
				$soma += $parcial[$i];
				if ($fator == $base) {
					// restaura fator de multiplicacao para 2
					$fator = 1;
				}
				$fator++;
			}
		
			/* Calculo do modulo 11 */
			if ($r == 0) {
				$soma *= 10;
				$digito = $soma % 11;
				if ($digito == 10) {
					$digito = 0;
				}
				return $digito;
			} elseif ($r == 1){
				$resto = $soma % 11;
				return $resto;
			}
		}
		
		function monta_linha_digitavel($codigo) {
		
				// Posição 	Conteúdo
				// 1 a 3    Número do banco
				// 4        Código da Moeda - 9 para Real
				// 5        Digito verificador do Código de Barras
				// 6 a 9   Fator de Vencimento
				// 10 a 19 Valor (8 inteiros e 2 decimais)
				// 20 a 44 Campo Livre definido por cada banco (25 caracteres)
		
				// 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
				// do campo livre e DV (modulo10) deste campo
				$p1 = substr($codigo, 0, 4);
				$p2 = substr($codigo, 19, 5);
				$p3 = $this->modulo_10("$p1$p2");
				$p4 = "$p1$p2$p3";
				$p5 = substr($p4, 0, 5);
				$p6 = substr($p4, 5);
				$campo1 = "$p5.$p6";
		
				// 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
				// e livre e DV (modulo10) deste campo
				$p1 = substr($codigo, 24, 10);
				$p2 = $this->modulo_10($p1);
				$p3 = "$p1$p2";
				$p4 = substr($p3, 0, 5);
				$p5 = substr($p3, 5);
				$campo2 = "$p4.$p5";
		
				// 3. Campo composto pelas posicoes 16 a 25 do campo livre
				// e livre e DV (modulo10) deste campo
				$p1 = substr($codigo, 34, 10);
				$p2 = $this->modulo_10($p1);
				$p3 = "$p1$p2";
				$p4 = substr($p3, 0, 5);
				$p5 = substr($p3, 5);
				$campo3 = "$p4.$p5";
		
				// 4. Campo - digito verificador do codigo de barras
				$campo4 = substr($codigo, 4, 1);
		
				// 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
				// indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
				// tratar de valor zerado, a representacao deve ser 000 (tres zeros).
				$p1 = substr($codigo, 5, 4);
				$p2 = substr($codigo, 9, 10);
				$campo5 = "$p1$p2";
		
				return "$campo1 $campo2 $campo3 $campo4 $campo5";
		}
		
		function geraCodigoBanco($numero) {
			$parte1 = substr($numero, 0, 3);
			$parte2 = $this->modulo_11($parte1);
			return $parte1 . "-" . $parte2;
		}





		# Configurações do Boleto #
		function GerarBoletoCEF($id_cliente=NULL, $data_inicial=NULL, $data_final=NULL){
			
			# Recuperar dados do Cliente
			$this->db->select('idCliente, vencimento, razaosocial, cnpj, endereco, endereco_numero, endereco_bairro, endereco_cidade, (SELECT estado FROM estados WHERE idEstado = endereco_estado) as endereco_estado, endereco_cep, codCedente');
			$this->db->where('idCliente', $id_cliente);
			$cliente = $this->db->get('cliente')->row();
			
			# Recuperar dados das chamadas
			$this->db->select("sum(valor_empresa) as valor_total_empresa");
			$this->db->where('idCliente', $id_cliente);
			$this->db->where("data BETWEEN '".$data_inicial."' AND '".$data_final."'");
			$this->db->where("status", 2); // concluida
			$chamada = $this->db->get('chamada')->row();

			
			# Recuperar dados do cedente
			$this->db->select('razaosocial, cnpj, banco_agencia, banco_conta, banco_operacao, banco_banco, endereco, endereco_numero, endereco_bairro, endereco_cidade, (SELECT estado FROM estados WHERE idEstado = endereco_estado) as endereco_estado, endereco_cep,');
			$this->db->where('idCedente', $cliente->codCedente);
			$cedente = $this->db->get('cedente')->row();
			
			# data de veencimento
			$dias_de_prazo_para_pagamento_inicial = 30;
			$data_venc = date($cliente->vencimento."/m/Y", time() + ($dias_de_prazo_para_pagamento_inicial * 86400));

			$taxa_boleto = 0;
			//$data_venc = date($cliente->vencimento."/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
			//$data_venc = $cliente->vencimento."/".date("12/Y");
			$valor_cobrado = $chamada->valor_total_empresa; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
			$valor_cobrado = str_replace(",", ".",$valor_cobrado);
			$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
			
			$dadosboleto["inicio_nosso_numero"] = "24";  // 24 - Padrão da Caixa Economica Federal
			$dadosboleto["nosso_numero"] = "19525086";  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
			$dadosboleto["numero_documento"] = "0001.".$cliente->idCliente.".".date("my").".".$cliente->codCedente;	// Num do pedido ou do documento
			$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
			$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
			$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
			$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
			
			// DADOS DO SEU CLIENTE
			$dadosboleto["sacado"] = $cliente->razaosocial;
			$dadosboleto["endereco1"] = $cliente->endereco.", ".$cliente->endereco_numero." - ".$cliente->endereco_bairro;
			$dadosboleto["endereco2"] = $cliente->endereco_cidade." - ".$cliente->endereco_estado." - CEP ".$cliente->endereco_cep;
			
			// INFORMACOES PARA O CLIENTE
			$dadosboleto["demonstrativo1"] = "Pagamento Referente a Serviços de Entrega";
			$dadosboleto["demonstrativo2"] = "no período de ".date("d/m/Y", strtotime($data_inicial))." à ".date("d/m/Y", strtotime($data_final))."<br>Taxa Bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
			$dadosboleto["demonstrativo3"] = "";
			
			// INSTRUÇÕES PARA O CAIXA
			$dadosboleto["instrucoes1"] = "<br>- Sr. Caixa, cobrar multa de 2% após o vencimento";
			$dadosboleto["instrucoes2"] = "- Receber até 5 dias após o vencimento";
			$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: andre@jcentregasrapidas.com.br";
			$dadosboleto["instrucoes4"] = "";
			
			// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
			$dadosboleto["quantidade"] = "";
			$dadosboleto["valor_unitario"] = "";
			$dadosboleto["aceite"] = "";		
			$dadosboleto["especie"] = "R$";
			$dadosboleto["especie_doc"] = "";
			
			
			// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
			
			
			// DADOS DA SUA CONTA - CEF
			$dadosboleto["agencia"] = $cedente->banco_agencia; // Num da agencia, sem digito
			$dadosboleto["conta"] = str_replace("-", "", $cedente->banco_conta); 	// Num da conta, sem digito
			$dadosboleto["conta_dv"] = ""; 	// Digito do Num da conta
			
			// DADOS PERSONALIZADOS - CEF
			$dadosboleto["conta_cedente"] = str_replace("-", "", $cedente->banco_conta); // ContaCedente do Cliente, sem digito (Somente Números)
			$dadosboleto["conta_cedente_dv"] = ""; // Digito da ContaCedente do Cliente
			$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)
			
			// SEUS DADOS
			$dadosboleto["identificacao"] = "BOLETO SERVIÇO PRESTADO JC";
			$dadosboleto["cpf_cnpj"] = $cedente->cnpj;
			$dadosboleto["endereco"] = $cedente->endereco.", ".$cedente->endereco_numero." - ".$cedente->endereco_bairro;
			$dadosboleto["cidade_uf"] = $cedente->endereco_cidade." - ".$cedente->endereco_estado." - CEP ".$cedente->endereco_cep;
			$dadosboleto["cedente"] = $cedente->razaosocial;	
			
			

			$codigobanco = "104";
			$codigo_banco_com_dv = $this->geraCodigoBanco($codigobanco);
			$nummoeda = "9";
			$fator_vencimento = $this->fator_vencimento($dadosboleto["data_vencimento"]);
			$valor = $this->formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
			$agencia = $this->formata_numero($dadosboleto["agencia"],4,0);
			$conta = $this->formata_numero($dadosboleto["conta"],5,0);
			$conta_dv = $this->formata_numero($dadosboleto["conta_dv"],1,0);
			$carteira = $dadosboleto["carteira"];

			$conta_cedente = $this->formata_numero($dadosboleto["conta_cedente"],6,0);
			$conta_cedente_dv = $this->modulo_10($conta_cedente);
			
			$nossonumero = $dadosboleto["inicio_nosso_numero"] . $this->formata_numero($dadosboleto["nosso_numero"],15,0);
			$sequenciaNossoNumero = $this->sequenciaNossoNumero($nossonumero);
			
			$livre = rand(1, 9);
			
			$dv = $this->digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$conta_cedente$conta_cedente_dv$sequenciaNossoNumero$livre", 9, 0);
			$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$conta_cedente$conta_cedente_dv$sequenciaNossoNumero$livre";
			
			$agencia_codigo = $agencia." / ". $conta_cedente ."-". $conta_cedente_dv;
			
			$dadosboleto["codigo_barras"] = $linha;
			$dadosboleto["linha_digitavel"] = $this->monta_linha_digitavel($linha);
			$dadosboleto["agencia_codigo"] = $agencia_codigo;
			$dadosboleto["nosso_numero"] = $nossonumero;
			$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

			
			return $dadosboleto;	
		}

}
?>