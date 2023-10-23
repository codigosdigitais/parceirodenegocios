<?php

/*
 *
 * @autor: Davi Siepmann
 *
 * @date: 21/11/2015
 *
 * @modify: André Baill
 *
 * @date: 10/12/2020
 */
include_once (dirname ( __FILE__ ) . "/PersistivelInterface.php");

// #####################
// #####################
/*
 * DEIXAR EXTENDENDO
 * CI_Controller
 */
// #####################
class ChamadaExternaClass extends CI_Controller implements PersistivelInterface {
	
	private $idChamada = null;
	private $idCliente;
	private $idAcessoExterno;
	private $idEmpresa;
	private $idFuncionario;
	private $tarifa;
	private $data;
	private $hora;
	private $tipo_veiculo;
	private $observacoes;
	private $valor_empresa;
	private $valor_funcionario;
	private $pontos;
	private $status;
	private $servicos;
	private $hora_repasse;
	private $tempo_espera;
	private $idAtendente;
	private $solicitante;	
	
	function __construct() {
		parent::__construct ();		
		$this->load->model ( 'chamadaexterna_model', '', TRUE );		
		$this->load->model ( 'logs_modelclass', '', TRUE );
	}
	
	/**
	 *
	 * @param $idCliente Necess�rio
	 *        	para localizar de qual empresa se trata o cliente
	 *        	
	 *        	n�o existe esta informa��o na sess�o
	 *        	
	 */
	function buscarIdEmpresaPeloIdCliente($idCliente) {
		return $this->chamadaexterna_model->buscarIdEmpresaPeloIdCliente ( $idCliente );
	}
	
	/**
	 * Inherited
	 */
	
	public function carregar($idChamada) {
		
		$chamadaArr = $this->chamadaexterna_model->getChamada($idChamada);
		
		$this->idChamada = $idChamada;
		$this->data = $chamadaArr->data;
		$this->hora = $chamadaArr->hora;
		$this->hora_repasse = $chamadaArr->hora_repasse;
		$this->idCliente = $chamadaArr->idCliente;
		$this->idEmpresa = $chamadaArr->idEmpresa;
		$this->idAcessoExterno = ($this->session->userdata('idAcessoExterno'));
		$this->idFuncionario = $chamadaArr->idFuncionario;
		$this->observacoes = $chamadaArr->observacoes;
		$this->pontos = $chamadaArr->pontos;
		$this->status = $chamadaArr->status;
		$this->tarifa = $chamadaArr->tarifa;
		$this->tempo_espera = $chamadaArr->tempo_espera;
		$this->tipo_veiculo = $chamadaArr->tipo_veiculo;
		$this->valor_empresa = $chamadaArr->valor_empresa;
		$this->valor_funcionario = $chamadaArr->valor_funcionario;
		$this->idAtendente = $chamadaArr->idAtendente;
		$this->solicitante = $chamadaArr->solicitante;
		
		$this->servicos = $this->carregarServicos($idChamada);
	}
	
	private function carregarServicos($idChamada) {
		$servicos = array();
		
		$servicosArr = $this->chamadaexterna_model->getChamadaServicos($idChamada);
		
		foreach ($servicosArr as $s) {
			$servico = new ChamadaServicoExternaClass($this);
			
			$servico->setBairro($s->bairro);
			$servico->setCidade($s->cidade);
			$servico->setEndereco($s->endereco);
			$servico->setFalarcom($s->falarcom);
			$servico->setNumero($s->numero);
			$servico->setTiposervico($s->tiposervico);
			
			array_push($servicos, $servico);
		}
		
		return $servicos;
	}

	/*
	*@autor: André Baill
	*@date: 19/10/2020
	*@description: adicionado logadoUser && idAcessoExterno
	*@para salvar no banco de dados
	*/
	
	public function salvar() {
		$dados = array ();


		//echo "<pre>";
		//print_r($this->session->userdata('idAcessoExterno'));

		//die();
		//logadoUser::idAcessoExterno

		if($this->session->userdata('idAcessoExterno')==true && $this->input->post('idCliente')==false){
			$idCliente = $this->session->userdata('idAcessoExterno');
		} else {
			$idCliente = $this->input->post('idCliente');
		}

		//if ($this->idAcessoExterno != null) {
			$dados = array_merge ( $dados, array (
					'idCliente' => $idCliente
			) );
		//}

		#if ($this->idEmpresa != null) {
			$dados = array_merge ( $dados, array (
					'idEmpresa' => '148'
			) );
		#}

		if ($this->tarifa != null) {
			$dados = array_merge ( $dados, array (
					'tarifa' => $this->tarifa
			) );
		}

// 		if ($this->valor_empresa != null) {
			$dados = array_merge ( $dados, array (
					'valor_empresa' => $this->valor_empresa
			) );
// 		}

		if ($this->pontos != null) {
			$dados = array_merge ( $dados, array (
					'pontos' => $this->pontos
			) );
		}

		if ($this->data != null) {
			$dados = array_merge ( $dados, array (
					'data' => $this->data
			) );
		}

		if ($this->hora != null) {
			$dados = array_merge ( $dados, array (
					'hora' => $this->hora
			) );
		}

		if ($this->tipo_veiculo != null) {
			$dados = array_merge ( $dados, array (
					'tipo_veiculo' => $this->tipo_veiculo
			) );
		}

		if ($this->observacoes != null) {
			$dados = array_merge ( $dados, array (
					'observacoes' => $this->observacoes
			) );
		}

		if ($this->status != null) {
			$dados = array_merge ( $dados, array (
					'status' => $this->status
			) );
		}

		if ($this->hora_repasse != null) {
			$dados = array_merge ( $dados, array (
					'hora_repasse' => $this->hora_repasse
			) );
		}

		if ($this->idAtendente != null) {
			$dados = array_merge ( $dados, array (
					'idAtendente' => $this->idAtendente
			) );
		}

		if ($this->solicitante != null) {
			$dados = array_merge ( $dados, array (
					'solicitante' => $this->solicitante
			) );
		}
		
		if ($this->tempo_espera != null) {
			$dados = array_merge ( $dados, array (
					'tempo_espera' => $this->tempo_espera
			) );
		}
		
// 		if ($this->valor_funcionario > 0) {
			$dados = array_merge ( $dados, array (
					'valor_funcionario' => $this->valor_funcionario 
			) );
// 		}
		
		if ($this->idFuncionario != null && $this->idFuncionario != "")
			$dados = array_merge ( $dados, array (
					'idFuncionario' => $this->idFuncionario 
			) );
		

		
		if (null == $this->idChamada) {

			#echo "<pre>";
			#print_r($dados);
			#die();
			
			$idChamada = $this->inserir ( $dados );

			#echo "idChamada:".$idChamada."<hr>";
 					
			if ($idChamada) {
				$ids = array ();
				
				foreach ( $this->servicos as $servico ) {
					$servico->setChamada ( $this );
					
					$idSrv = $servico->salvar ();

					#echo "idSrv: ".$idSrv."<hr>";
					
					if ($idSrv) {
						array_push ( $ids, $idSrv );
					}
				}
				
				$this->logs_modelclass->registrar_log_insert ( 'chamada_servico', 'idChamadaServico', json_encode ( $ids ), 'Chamada Externa: Serviços' );
				
				return $idChamada;
			}
		}
		else {
			if ($this->editar($dados)) {
				return true;
			}
		}

		#die();
		
		return false;
	}
	private function editar($dados) {
		$this->logs_modelclass->registrar_log_antes_update('chamada', 'idChamada', $this->idChamada, 'Chamada');
		
		$where = array('idChamada' => $this->idChamada);
		$resposta = $this->chamadaexterna_model->atualizar( $where, $dados );
		
		if ($resposta) {
			$this->logs_modelclass->registrar_log_depois();
		}
		
		return $resposta;
	}
	private function inserir($dados) {

		$idChamada = $this->chamadaexterna_model->inserirChamada ( $dados );

		#var_dump($idChamada);
		#print_r($idChamada);
		#die();
		
		if ($idChamada) {
			$this->logs_modelclass->registrar_log_insert ( 'chamada', 'idChamada', $idChamada, 'Chamada Externa' );
			$this->idChamada = $idChamada;
			return $idChamada;
		} 

		else
			return false;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see Persistivel::remover() M�todo remover n�o implementado para chamados externos
	 *     
	 */
	public function remover() {
	}
	
	/**
	 * Realiza c�lculo e atribui valor da chamada + pontos
	 */
	public function calculaValorChamada($calcSoValFuncionario = false) {
		
		//valores serão retornados
		$valor_empresa = 0;
		$valor_funcionario = 0;
		$pontos = 0;

		#echo "<br><br>Valor Empresa -> Inicio <br>";
		#die();	

		//varre serviços (endereços) pegando valores
		//começa pelo segundo endereço
		for($i = 1; $i < count($this->servicos); $i++) {
			
			//verifica valores para cada par de endereços
			$pontos = 0;
			$tipo_servico = $this->servicos[$i]->getTiposervico();
			
			//quando tipo sertiço == retorno, a origem é o primeiro endereço (coleta)
			$iOrigem  = ($tipo_servico == 2) ? $i -1 : 0;
			$iDestino = ($tipo_servico == 2) ? 0 : $i;

			//valor de cada ponto
			$tarifa = $this->tarifa;
			
			//pega cidade da empresa
			$idEmpresa = $this->idEmpresa;
			$cidadeEmpresa = $this->chamadaexterna_model->getCidadeDaEmpresa($idEmpresa);

			
			//verifica se tarifa deve ser metropolitano
			if ($this->servicos[$iOrigem]->getCidade() != $cidadeEmpresa || $cidadeEmpresa != $this->servicos[$iDestino]->getCidade()) {
				//conjunto de endereços metropolitano
				#echo "{{tarifa <b>metropolitana</b>: i=" . $i;
				#echo " && cidade origem/destino/cliente: " . $this->servicos[$iOrigem]->getCidade() ."/". $this->servicos[$iDestino]->getCidade() ."/".$cidadeEmpresa."}}";
				#echo "<br>";


				//die();
				
				//busca o tipo da cidade: 1=Capital (sede da empresa), 2=Metropolitano ou 3=Interior
// 				$tipoCidade = $this->chamadaexterna_model->getTipoCidade($this->servicos[$iDestino]->getCidade());
			
				//se a tarifa for normal
				if ($tarifa == 1) { $tarifa = 3;
					//tarifa 1 = normal + Capital (sede empresa)
					//tarifa 3 = normal + metropolitado ou interior
// 					$tarifa = ($tipoCidade == 2 || $tipoCidade == 3) ? 3 : 1;
				}
				//se a tarifa for após as 18h
				else { $tarifa = 4;
					//tarifa 2 = após 18h + Capital (sede empresa)
					//tarifa 4 = após 18h + metropolitano ou interior
// 					$tarifa = ($tipoCidade == 2 || $tipoCidade == 3) ? 4 : 2;
				}
			}
			else {
				//quando conjuntos de endereços forem na mesma cidade da empresa a tarifa é normal
				#echo " > {{tarifa <b>normal</b>: i=" . $i;
				#echo " && cidade origem/destino/cliente: " . $this->servicos[$iOrigem]->getCidade() ."/". $this->servicos[$iDestino]->getCidade() ."/".$cidadeEmpresa."}}";
				#echo "<br>";
			}

			#echo "aqui";


			//die();

			$atributo_valor = $this->getNomeAtributoParaValor($tarifa, $this->tipo_veiculo);
			$vlPontoCliente = $this->chamadaexterna_model->getValorHoraCliente($this->idCliente, $atributo_valor);
			$vlPontoFuncionario = $this->chamadaexterna_model->getValorHoraFuncionario($this->idFuncionario, $atributo_valor);
			
			#echo "Atributo Valor: ".$atributo_valor."<br>";
			#echo "Tarifa: " . $tarifa . "<br>";
			#echo "vlPontoCliente: " . $vlPontoCliente . "<br>";
			#echo "vlPontoFuncionario: " . $vlPontoFuncionario;
			#echo "<br><br>";

			#die();
			 
			
			//quando cidade for D I F E R E N T E  é calculado segundo tabela A, B, C de proximidade dos bairros
			if ($this->servicos[$iOrigem]->getCidade() != $this->servicos[$iDestino]->getCidade()) {
				$b = $this->servicos[$iOrigem]->getBairro();
				$o = $this->servicos[$iOrigem]->getCidade();
				$d = $this->servicos[$iDestino]->getCidade();
				$v = $this->tipo_veiculo;
				
				$pontos = $this->chamadaexterna_model->getPontosTabelaCidadeABC($b, $o, $d, $v, $tipo_servico);

				/*echo "Tabela Cidade ABC : bairro(";
				echo $this->servicos[$iOrigem]->getBairro() . ") :: ";
				echo $this->servicos[$iOrigem]->getCidade();
				echo " à ". $this->servicos[$iDestino]->getCidade();
				echo " = ". $pontos . " pontos : ";*/
			}
			else {
				$b = $this->servicos[$iOrigem]->getBairro();
				$o = $this->servicos[$iOrigem]->getBairro();
				$d = $this->servicos[$iOrigem +1]->getBairro();
				$v = $this->tipo_veiculo;
				
				$pontos = $this->chamadaexterna_model->getPontosTabelaBairro($b, $o, $d, $v, $tipo_servico);
				
				
				#echo "Tabela Bairro : bairro(";
				#echo $this->servicos[$iOrigem]->getBairro() . ") :: ";
				#echo $this->servicos[$iOrigem]->getBairro();
				#echo " à ". $this->servicos[$iDestino]->getBairro();
				#echo " = ". $pontos . " pontos : ";
				
			}
			

			//die();



			//agora tem a quantidade de pontos deste trecho: $pontos
			//também tem o valor da empresa e funcionário: $vlPontoCliente e $vlPontoFuncionario

			#echo "<hr> Pontos Funcionario";
			#echo $vlPontoFuncionario;
			#echo "<hr>";
			#echo $vlPontoCliente;

			$valor_empresa += ($pontos * $vlPontoCliente);
			$valor_funcionario += ($pontos * $vlPontoFuncionario);

			#echo "<br><br> Valor Empresa: ".$valor_empresa."<br><br><hr>";
			#echo "<pre>";
			#print_r($this->session->userdata);
			#die();
			
			//Informa na interface que existe trecho sem valoração em alguma das tabelas
			if (($pontos * $vlPontoCliente) == 0) $this->status = -2;
			
			/*echo "tipo_serviço " . $tipo_servico . " :: ";
			echo "val cliente: " . $vlPontoCliente * $pontos . " : ";
			echo "val func: " . $vlPontoFuncionario* $pontos . " : ";
			echo "<hr>";


			echo "Retorno Valor ". $this->getValor_empresa();
			var_dump($this->getValor_empresa());*/
			//die();
			
		}

		if (!$calcSoValFuncionario) {
			$this->valor_empresa = $valor_empresa;
			$this->pontos = $pontos;
		}
		$this->valor_funcionario = $valor_funcionario;

	}
	
	private function getNomeAtributoParaValor($tarifa, $veiculo) {

		$nome_atributo_valor = "";
		
		if ($tarifa == '1' and $veiculo == '1') {
			$nome_atributo_valor = "valor_moto_normal";
		}
		
		if ($tarifa == '2' and $veiculo == '1') {
			$nome_atributo_valor = "valor_moto_depois_18";
		}
		
		if ($tarifa == '3' and $veiculo == '1') {
			$nome_atributo_valor = "valor_moto_metropolitano";
		}
		
		if ($tarifa == '4' and $veiculo == '1') {
			$nome_atributo_valor = "valor_moto_metropolitano_apos18";
		}
		
		if ($tarifa == '1' and $veiculo == '2') {
			$nome_atributo_valor = "valor_carro_normal";
		}
		
		if ($tarifa == '2' and $veiculo == '2') {
			$nome_atributo_valor = "valor_carro_depois_18";
		}
		
		if ($tarifa == '3' and $veiculo == '2') {
			$nome_atributo_valor = "valor_carro_metropolitano";
		}
		
		if ($tarifa == '4' and $veiculo == '2') {
			$nome_atributo_valor = "valor_carro_metropolitano_apos18";
		}
		
		if ($tarifa == '1' and $veiculo == '3') {
			$nome_atributo_valor = "valor_van_normal";
		}
		
		if ($tarifa == '2' and $veiculo == '3') {
			$nome_atributo_valor = "valor_van_depois_18";
		}
		
		if ($tarifa == '3' and $veiculo == '3') {
			$nome_atributo_valor = "valor_van_metropolitano";
		}
		
		if ($tarifa == '4' and $veiculo == '3') {
			$nome_atributo_valor = "valor_van_metropolitano_apos18";
		}
		
		if ($tarifa == '1' and $veiculo == '4') {
			$nome_atributo_valor = "valor_caminhao_normal";
		}
		
		if ($tarifa == '2' and $veiculo == '4') {
			$nome_atributo_valor = "valor_caminhao_depois_18";
		}
		
		if ($tarifa == '3' and $veiculo == '4') {
			$nome_atributo_valor = "valor_caminhao_metropolitano";
		}
		
		if ($tarifa == '4' and $veiculo == '4') {
			$nome_atributo_valor = "valor_caminhao_metropolitano_apos18";
		}
		
		return $nome_atributo_valor;
	}
	
	/**
	 * Getters and Setters
	 */
	public function getIdChamada() {
		return $this->idChamada;
	}
	public function setIdChamada($idChamada) {
		$this->idChamada = $idChamada;
	}
	public function getIdFuncionario() {
		return $this->idFuncionario;
	}
	public function setIdFuncionario($idFuncionario) {
		$this->idFuncionario = $idFuncionario;
	}
	public function getIdCliente() {
		return $this->idCliente;
	}
	public function setIdCliente($idCliente) {
		$this->idCliente = $idCliente;
	}
	public function getIdAcessoExterno() {
		return $this->idAcessoExterno;
	}
	public function setIdAcessoExterno($idAcessoExterno) {
		$this->idAcessoExterno = $idAcessoExterno;
	}	
	public function getIdEmpresa() {
		return $this->idEmpresa;
	}
	public function setIdEmpresa($idEmpresa) {
		$this->idEmpresa = $idEmpresa;
	}
	public function getTarifa() {
		return $this->tarifa;
	}
	public function setTarifa($tarifa) {
		$this->tarifa = $tarifa;
	}
	public function getData() {
		return $this->data;
	}
	public function setData($data) {
		$this->data = $data;
	}
	public function getHora() {
		return $this->hora;
	}
	public function setHora($hora) {
		$this->hora = $hora;
	}
	public function getTipo_veiculo() {
		return $this->tipo_veiculo;
	}
	public function setTipo_veiculo($tipo_veiculo) {
		$this->tipo_veiculo = $tipo_veiculo;
	}
	public function getObservacoes() {
		return $this->observacoes;
	}
	public function setObservacoes($observacoes) {

		$username_to_concat = $this->session->userdata('login');

		if ($observacoes != "") {
			$obs_old = $this->observacoes;

			if ($obs_old != null && $obs_old != "") {
				$obs_old.= "\n";
			}

			$observacoes = $obs_old . "[" . date('d/m/Y H:i:s') . " " .$username_to_concat."]\n" . $observacoes;
		}
		else {
			$observacoes = $this->observacoes;
		}

		$this->observacoes = $observacoes;
	}
	public function getValor_empresa() {
		return $this->valor_empresa;
	}
	public function setValor_empresa($valor_empresa) {
		$this->valor_empresa = $valor_empresa;
	}
	public function getValor_funcionario() {
		return $this->valor_funcionario;
	}
	public function setValor_funcionario($valor_funcionario) {
		$this->valor_funcionario = $valor_funcionario;
	}
	public function getPontos() {
		return $this->pontos;
	}
	public function setPontos($pontos) {
		$this->pontos = $pontos;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	public function getServicos() {
		return $this->servicos;
	}
	public function setServicos($servicos) {
		$this->servicos = $servicos;
	}
	public function getHora_repasse() {
		return $this->hora_repasse;
	}
	public function setHora_repasse($hora) {
		$this->hora_repasse = $hora;
	}
	public function getTempo_espera() {
		return $this->tempo_espera;
	}
	public function setTempo_espera($tempo) {
		$this->tempo_espera = $tempo;
	}

	public function getIdAtendente() {
		return $this->idAtendente;
	}
	public function setIdAtendente($id) {
		$this->idAtendente = $id;
	}
	public function getSolicitante() {
		return $this->solicitante;
	}
	public function setSolicitante($sol) {
		$this->solicitante = $sol;
	}
	
}