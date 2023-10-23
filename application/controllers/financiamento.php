<?php
/*
* @autor: Davi Siepmann
* @date: 27/09/2015
*/
include_once (dirname(__FILE__) . "/global_functions_helper.php");
include_once (dirname(__FILE__) . "/classes/CalculaJuros.php");

# FECHAMENTO EXTENDS CONTROLLER #
class financiamento extends MY_Controller {
	
	//ajaxResponse
	private $flashData = "";
	private $empFinancPermissao;

	/*atributos utilizados nos c�lculos de financiamento*/
		private $aprovado;
		private $motivoReprovacao;
		private $totalComJuros = 0;
		
		//atributos padrao vindos da base
		private $base_situacao;
		private $base_financ_max_valor;
		private $base_financ_max_comprometimento;
		private $base_financ_max_parcelas;
		private $base_financ_tx_juros;
		private $base_financ_periodo;
		private $base_financ_tipo;
		private $base_salario;
		private $base_valor_comprometido_atual;

		private $base_emp_max_valor;
		private $base_emp_max_comprometimento;
		private $base_emp_max_parcelas;
		private $base_emp_tx_juros;
		private $base_emp_periodo;
		private $base_emp_tipo;
		
		//atributos enviados pelo usu�rio
		private $idParametro;
		private $idEmprestimo;
		private $idFornecedor = NULL;
		private $tipoEmprestimo = NULL;
		private $situacao;
		private $dataSolicitacao;
		private $idFuncionario;
		private $idCedente;
		private $salario;
		private $dataPrimParcela;
		private $valor;
		private $valor_parcelas;
		private $parcelas;
		private $comprometimento;
		private $juros;
		private $juros_periodo;
		private $juros_tipo;
		private $inserirAlterarRemover;
    
	
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
			//verifica login
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');
            
            $this->load->helper(array('codegen_helper'));
            $this->load->library('form_validation');
            $this->load->model('paramemprestimos_model','',TRUE);
            $this->load->model('financiamento_model','',TRUE);
			$this->load->model('clientes_model','',TRUE);
			
			$this->tipoEmprestimo = $this->input->post('tipoEmprestimo');
			
			if (!$this->tipoEmprestimo) {
				switch ($this->uri->segment(4)) {
					case 'emprestimo'	: $this->tipoEmprestimo = 'emprestimo'; 	break;
					default				: $this->tipoEmprestimo = 'financiamento';	break;
				}
			}
	}	
	
	/*
	* @autor: Davi Siepmann
	* @date: 27/09/2015
	*/
	# exibe parametros de empréstimo e financiamento à funcionários
	function index(){
		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar financiamentos.');
			redirect(base_url());
		}
		else {
			$this->data['results'] 			= $this->financiamento_model->getListaFinanciamentos('financiamento');
			$this->data['tipoEmprestimo'] 	= 'financiamento';
			
			$this->data['view'] = 'emprestimo/financiamento_lista';
			$this->load->view('tema/topo',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	# exibe parametros de empréstimo e financiamento à funcionários
	function emprestimo_externo(){
		$this->setControllerMenu($this->router->method);
		
		if(!$this->permission->controllerManual('emprestimo_externo')->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar esta função (cód: not[v_emp_ext]).');
			redirect(base_url());
		}

		else if(!$this->session->userdata('idAcessoExterno')){
			$this->session->set_flashdata('error','Funcção exige cliente externo vinculado.');
			redirect(base_url());
		}
		else {
			//PROVISÓRIO ####################################################################
			//$this->session->set_userdata(array('idAcessoExterno' => $this->uri->segment(4)));
			//PROVISÓRIO ####################################################################
			
			$idAcessoExterno = $this->session->userdata('idAcessoExterno');
			$this->data['dados_fornecedor'] = $this->clientes_model->getById($idAcessoExterno);
			
			
			$this->data['results'] 			= $this->financiamento_model->getListaEmprestimosExternos($idAcessoExterno);
			$this->data['tipoEmprestimo'] 	= 'emprestimo_externo';
	
			$this->data['view'] = 'emprestimo/financiamento_lista';
			$this->load->view('tema/topo',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	function empestimo_externo_view(){
		$this->setControllerMenu('emprestimo_externo');
		
		$this->data['result'] = NULL;
	
		if(!$this->permission->controllerManual('emprestimo_externo')->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar esta função (cód: not[a_emp_ext]).');
			redirect(base_url());
		}
		else {
			$idEmpresa 	   = $this->session->userdata['idCliente'];
			$idAcessoExterno = $this->session->userdata('idAcessoExterno');
			$this->data['dados_fornecedor'] = $this->clientes_model->getById($idAcessoExterno);

			$this->data['view'] = 'emprestimo/empestimo_externo_view';
			$this->load->view('tema/topo',$this->data);
		}
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 15/10/2015
	 */
	# exibe parametros de empréstimo e financiamento à funcionários
	function emprestimo(){
		$this->setControllerMenu($this->router->method);
		
		if(!$this->permission->controllerManual('emprestimo')->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar empréstimos.');
			redirect(base_url());
		}
		else {
			$this->data['results'] 			= $this->financiamento_model->getListaFinanciamentos('emprestimo');
			$this->data['tipoEmprestimo'] 	= 'emprestimo';
	
			$this->data['view'] = 'emprestimo/financiamento_lista';
			$this->load->view('tema/topo',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	function isSenhaFuncionarioOK() {
		
		$this->form_validation->set_rules('senha', 'Senha', 'trim|required|xss_clean|MD5');
		
		if ($this->form_validation->run() == true) {
			 return $this->financiamento_model->isSenhaFuncionarioOK($this->idFuncionario, $this->input->post('senha'));
		}
		$this->motivoReprovacao = validation_errors();
		
		return false;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	function gravarEmprestimoExterno() {
		$this->popularDadosEmprestimoExterno();
		$dados = array();
		
		if ($this->isSenhaFuncionarioOK()) {
			if ($this->isAprovadoEmprestimoExterno()) {
				if ($this->inserirEmprestimoExterno()) {
					
					$dados = array("sucesso" => true);
					$dados = array_merge($dados, array("mensagem" => "Empréstimo Registrado!<br>
					Valor de cada parcela: R$ " . number_format($this->valor_parcelas, 2, ",", ".")));
				}
				else {
					$dados = array("sucesso" => false);
					$dados = array_merge($dados, array("mensagem" => "Não foi possível registrar o empréstimo!<br>" . $this->motivoReprovacao));
				}
			}
			else {
				$dados = array("sucesso" => false);
				$dados = array_merge($dados, array("mensagem" => "Empréstimo Reprovado:<br>" . $this->motivoReprovacao));
			}
		}
		else {
			$dados = array("sucesso" => false);
			$dados = array_merge($dados, array("mensagem" => "<b>Senha incorreta!</b><br>" . $this->motivoReprovacao));
		}
		
		$json = json_encode($dados);
		echo $json;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	function verificarEmprestimoExterno() {
		$this->popularDadosEmprestimoExterno();
		
		if ($this->isAprovadoEmprestimoExterno()) {
			echo "Empréstimo Aprovado!<br>";
			echo "Valor de cada parcela: R$ " . number_format($this->valor_parcelas, 2, ",", ".");
		}
		else {
			echo "Empréstimo Reprovado:<br>";
			echo $this->motivoReprovacao;
		}
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	private function isAprovadoEmprestimoExterno() {
		if ($this->financiamento_model->existeParamFuncionarioXCedente($this->idFuncionario, $this->idCedente, $this->idParametro)) {
		
			$this->calcParcelasEmpExt();
			$this->calcComprometimento();
			$this->verificaAprovacaoLancamentoEmpExterno();
		
			if ($this->aprovado || $this->situacao == 'simulacao' || $this->inserirAlterarRemover == 'remover')
				return true;
		
			else
				return false;
		}
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 27/09/2015
	 */
	#
	function buscaParamFuncEmpExternoAjax() {
		if($this->permission->controllerManual('emprestimo_externo')->canInsert()){
			$this->retornaParamFuncionarioAjax();
		}
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 27/09/2015
	 */
	#
	function buscaParamFuncionarioAjax() {
		if($this->permission->controllerManual($this->tipoEmprestimo)->canSelect()){
			$this->retornaParamFuncionarioAjax();
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	private function retornaParamFuncionarioAjax() {
		$idFuncionario = $this->input->post('idFuncionario');
		
		$dados = array();
		$dados['cedentes'] = $this->financiamento_model->buscaParamFuncionario($idFuncionario);
		$dados['funcionario'] = $this->financiamento_model->getFuncionarioEmpExterno($idFuncionario);
			
		if (count($dados['funcionario']) == 0) {
			$dados = array_merge($dados, array("error" => "Profissional não localizado ou inativo!"));
			$dados['cedentes'] = '';
		}
		else if (count($dados['cedentes']) == 0) {
			$dados = array_merge($dados, array("error" => "Não habilitado empréstimo a este profissional!"));
		}
		
		$json = json_encode($dados);
		echo $json;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 1/10/2015
	 */
	#
	function simularFinanciamento() {
		if($this->permission->controllerManual($this->tipoEmprestimo)->canSelect()){
			$parcelamento = array();
			
			$this->popularDadosFomulario();
			$this->popularDadosPadraoBase();
			
			//realiza c�lculo dos juros
			$parcelamento = $this->calcParcelasComJuros();
			$this->data['parcelamento'] = $parcelamento;
			
			$this->calcComprometimento();
			
			$this->verificaAprovacaoSimulacao();
			
			$this->data['resumo'] = (object)array(
					'juros'    			=> $this->juros,
					'juros_tipo' 		=> $this->juros_tipo,
					'inicio_pagto'		=> conv_data_YMD_para_DMY($this->dataPrimParcela),
					'aprovado'			=> $this->aprovado,
					'situacao'			=> $this->situacao,
					'motivo_reprovacao' => $this->motivoReprovacao,
					'total'				=> number_format($this->totalComJuros, 2, ",", "."),
					'comprometimentoReal'=> round(($this->comprometimento), 2)
			);
			
			
			$this->load->view('emprestimo/resultadoCalculoFinanciamento',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	#
	function visualiza_financiamento(){
		
		$this->data['result'] = NULL;
		
		if (is_numeric($this->uri->segment(4)))	$this->data['result']	= $this->financiamento_model->getFinanciamento($this->uri->segment(4));
		
		if ($this->data['result'] != null) $this->tipoEmprestimo = $this->data['result'][0]->tipoEmprestimo;
		
		if(!$this->permission->controllerManual($this->tipoEmprestimo)->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar '.$this->tipoEmprestimo .'.');
			redirect(base_url());
		}
		else {
			$idEmpresa 	   = $this->session->userdata['idCliente'];
			$idFornecedor  = ($this->data['result']==null) ? null : $this->data['result'][0]->idFornecedor;

			
			$idFuncionario = ($this->data['result'] == null) ? null : $this->data['result'][0]->idFuncionario;
			$idCedente = 	 ($this->data['result'] == null) ? null : $this->data['result'][0]->idCedente;
			
			$this->data['lista_funcionarios'] 	= $this->financiamento_model->getFuncionarios($idFuncionario);
			$this->data['lista_cedentes'] 		= $this->financiamento_model->getCedentes($idCedente);
			$this->data['fornecedores'] 		= $this->financiamento_model->getListaFornecedoresEmprestimo($idFornecedor);
			
			$this->data['tipoEmprestimo'] 		= $this->tipoEmprestimo;

			$this->setControllerMenu($this->tipoEmprestimo);
			
			$this->data['view'] = 'emprestimo/financiamento_view';
			$this->load->view('tema/topo',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 15/10/2015
	 */
	#
	private function calcComprometimento(){
		$comp_atual_mais_parcela = $this->valor_parcelas + $this->base_valor_comprometido_atual;
		$this->comprometimento = 100;
		if ($this->salario > 0)
			$this->comprometimento = ($comp_atual_mais_parcela *100 / $this->salario);
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 08/10/2015
	 */
	#
	function gravarFinanciamento() {
		$parcelamento = array();
		
		$this->popularDadosFomulario();
		$this->popularDadosPadraoBase();
		
		//realiza cálculo dos juros
		$parcelamento = $this->calcParcelasComJuros();
		$this->calcComprometimento();
		
		if ($this->tipoEmprestimo == 'financiamento' && $this->inserirAlterarRemover != 'remover')
			$this->verificaAprovacaoLancamentoFinanciamento();
		
		elseif ($this->tipoEmprestimo == 'emprestimo' && $this->inserirAlterarRemover != 'remover')
			$this->verificaAprovacaoLancamentoEmprestimo();
		
		if ($this->aprovado || $this->situacao == 'simulacao' || $this->inserirAlterarRemover == 'remover') {
			
			switch($this->inserirAlterarRemover) {
				case 'inserir':
					$this->inserirFinanciamento();
					break;
				case 'alterar':
					$this->alterarFinancEmprestimo();
					break;
				case 'remover':
					$this->removerFinancEmprestimo();
					$this->idEmprestimo = '';
					break;
			}
			
			$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
			if ($this->flashData == "") $this->flashData = "Registro realizado com sucesso!";
			
			$this->session->set_flashdata($flashDataType, $this->flashData);
			
			if ($this->inserirAlterarRemover == 'remover') {
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/'.$this->tipoEmprestimo .'/');
			}
			else {
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/financiamento/visualiza_financiamento/' . $this->idEmprestimo);
			}
		}
		else {
			$this->session->set_flashdata('error', 'Problemas ao registrar financiamento.<br />' . $this->motivoReprovacao);
			
			if ($this->idEmprestimo == '')
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/financiamento/');
			else
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/financiamento/visualiza_financiamento/' . $this->idEmprestimo);
		}
	}
	/**
	 * @autor Davi Daniel
	 * @date 22/10/2015
	 */
	private function verificaAprovacaoLancamentoEmpExterno() {
		$this->aprovado = true;
		$this->motivoReprovacao = '';
	
		$comprometimentoReal = $this->comprometimento;
		if ($this->base_emp_max_comprometimento < $comprometimentoReal){
			$comprometimentoReal = round(($comprometimentoReal), 2);
			$this->aprovado = false;
			$this->motivoReprovacao.= '&raquo Comprometimento salarial: '. $comprometimentoReal. '%, limite: '.$this->base_emp_max_comprometimento.'%<br />';

			if ($this->base_valor_comprometido_atual > 0)
				$this->motivoReprovacao.= '&raquo Existe empréstimo em aberto: R$ '. number_format($this->base_valor_comprometido_atual, 2, ",", ".") .' de comprometimento<br />';
		}

		if ($this->base_emp_max_parcelas < $this->parcelas) {
			$this->aprovado = false; $this->motivoReprovacao.= '&raquo Quantidade de parcelas ultrapassou o máximo: '.$this->base_emp_max_parcelas.'<br />';
		}

		if ($this->base_emp_max_valor < $this->valor) {
			$this->aprovado = false; $this->motivoReprovacao.= '&raquo Valor solicitado ultrapassou máximo: '.$this->base_emp_max_valor.'<br />';
		}
	}
	
	private function verificaAprovacaoLancamentoEmprestimo() {
		$this->aprovado = true;
		$this->motivoReprovacao = '';
	
		if (!$this->base_situacao || $this->base_situacao == 'simulacao') {
			$comprometimentoReal = $this->comprometimento;
			if ($this->base_emp_max_comprometimento < $comprometimentoReal){
				$comprometimentoReal = round(($comprometimentoReal), 2);
				$this->aprovado = false;
				$this->motivoReprovacao.= '&raquo Comprometimento salarial: '. $comprometimentoReal. '%, limite: '.$this->base_emp_max_comprometimento.'%<br />';
	
				if ($this->base_valor_comprometido_atual > 0)
					$this->motivoReprovacao.= '&raquo Existe empréstimo em aberto: R$ '. number_format($this->base_valor_comprometido_atual, 2, ",", ".") .' de comprometimento<br />';
			}
				
			if ($this->base_emp_max_parcelas < $this->parcelas) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Quantidade de parcelas ultrapassou o máximo: '.$this->base_emp_max_parcelas.'<br />';
			}
				
			if ($this->base_emp_max_valor < $this->valor) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Valor solicitado ultrapassou máximo: '.$this->base_emp_max_valor.'<br />';
			}
				
			if ($this->base_emp_periodo != $this->juros_periodo) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Período para taxa de juros permitida: '.ucfirst($this->base_emp_periodo).'<br />';
			}
				
			if ($this->base_emp_tipo != $this->juros_tipo) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Forma de aplicação de juros permitida: '. ucfirst($this->base_emp_tipo).'<br />';
			}
				
			if ($this->base_emp_tx_juros > $this->juros) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Taxa de juros abaixo da permitida: '.$this->base_emp_tx_juros.'<br />';
			}
		}
	}
	
	private function verificaAprovacaoLancamentoFinanciamento() {
		$this->aprovado = true;
		$this->motivoReprovacao = '';
		
		if (!$this->base_situacao || $this->base_situacao == 'simulacao') {
			$comprometimentoReal = $this->comprometimento;
			if ($this->base_financ_max_comprometimento < $comprometimentoReal){
				$comprometimentoReal = round(($comprometimentoReal), 2);
				$this->aprovado = false;
				$this->motivoReprovacao.= '&raquo Comprometimento salarial: '. $comprometimentoReal. '%, limite: '.$this->base_financ_max_comprometimento.'%<br />';
				
				if ($this->base_valor_comprometido_atual > 0)
					$this->motivoReprovacao.= '&raquo Existe financiamento em aberto: R$ '. number_format($this->base_valor_comprometido_atual, 2, ",", ".") .' de comprometimento<br />';
			}
			
			if ($this->base_financ_max_parcelas < $this->parcelas) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Quantidade de parcelas ultrapassou o máximo: '.$this->base_financ_max_parcelas.'<br />';
			}
			
			if ($this->base_financ_max_valor < $this->valor) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Valor solicitado ultrapassou máximo: '.$this->base_financ_max_valor.'<br />';
			}
			
			if ($this->base_financ_periodo != $this->juros_periodo) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Período para taxa de juros permitida: '.ucfirst($this->base_financ_periodo).'<br />';
			}
			
			if ($this->base_financ_tipo != $this->juros_tipo) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Forma de aplicação de juros permitida: '. ucfirst($this->base_financ_tipo).'<br />';
			}
			
			if ($this->base_financ_tx_juros > $this->juros) {
				$this->aprovado = false; $this->motivoReprovacao.= '&raquo Taxa de juros abaixo da permitida: '.$this->base_financ_tx_juros.'<br />';
			}
		}
	}
	
	private function verificaAprovacaoSimulacao() {
		$this->aprovado = true;
		$this->motivoReprovacao = '';
		
		$comprometimentoReal = $this->comprometimento;
		if ($this->base_financ_max_comprometimento < $comprometimentoReal){
			$comprometimentoReal = round(($comprometimentoReal), 2);
			$this->aprovado = false;
			$this->motivoReprovacao.= '&raquo Comprometimento salarial: '. $comprometimentoReal. '%, limite: '.$this->base_financ_max_comprometimento.'%<br />';
			
		if ($this->base_valor_comprometido_atual > 0)
			$this->motivoReprovacao.= '&raquo Existe empréstimo/financiamento em aberto: R$ '. number_format($this->base_valor_comprometido_atual, 2, ",", ".") .' de comprometimento<br />';
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 22/10/2015
	 */
	#
	private function calcParcelasEmpExt() {
		$cj = new CalculaJuros();
		$valParcela = 0;
	
		switch ($this->juros_tipo)
		{
			case 'simples' 	 	 : $valParcela = $cj->getValParcelaJurosSimples($this->valor, $this->juros, $this->parcelas); break;
			case 'compostos' 	 : $valParcela = $cj->getValParcelaJurosCompostos($this->valor, $this->juros, $this->parcelas); break;
		}
		$this->valor_parcelas = $valParcela;
	}
	
	private function calcParcelasComJuros() {
		$cj = new CalculaJuros();
		$parcelamento = array();
		$valParcela = 0;
		
		switch ($this->juros_tipo)
		{
			case 'simples' 	 	 : $valParcela = $cj->getValParcelaJurosSimples($this->valor, $this->juros, $this->parcelas); break;
			case 'compostos' 	 : $valParcela = $cj->getValParcelaJurosCompostos($this->valor, $this->juros, $this->parcelas); break;
		}
		$this->valor_parcelas = $valParcela;
		
		if ('diario' == $this->juros_periodo) {
			$valParcela = $valParcela * $this->parcelas;
			$this->totalComJuros += $valParcela;

			$parcelamento[0] = (object)array('parcela' => 1, 'data' => conv_data_YMD_para_DMY($this->dataPrimParcela), 
															 'valor' => number_format($valParcela, 2, ",", "."));
		}
		else {
			for($i = 0; $i < $this->parcelas; $i++) {
				$this->totalComJuros += $valParcela;
				
				$parcelamento[$i] = (object)array('parcela' => $i, 'data' => conv_data_YMD_para_DMY(soma_em_data($this->dataPrimParcela, $i, 'M')), 'valor' => number_format($valParcela, 2, ",", "."));
			}
		}
		
		return $parcelamento;
	}
	
	private function popularDadosPadraoBase() {
		$dados['params'] = $this->financiamento_model->buscaParamFuncionario($this->idFuncionario);
		
		foreach($dados['params'] as $params){			
			if ($params->idParametro == $this->idParametro) {
				$this->base_financ_max_valor = 	  	  		$params->financ_max_valor;
				$this->base_financ_max_comprometimento =  	$params->financ_max_comprometimento;
				$this->base_financ_max_parcelas = 	  		$params->financ_max_parcelas;
				$this->base_financ_tx_juros = 		  		$params->financ_tx_juros;
				$this->base_financ_periodo = 		  		$params->financ_periodo;
				$this->base_financ_tipo = 			  		$params->financ_tipo;

				$this->base_emp_max_valor = 	  	  		$params->emp_max_valor;
				$this->base_emp_max_comprometimento =  		$params->emp_max_comprometimento;
				$this->base_emp_max_parcelas = 	  			$params->emp_max_parcelas;
				$this->base_emp_tx_juros = 		  			$params->emp_tx_juros;
				$this->base_emp_periodo = 		  			$params->emp_periodo;
				$this->base_emp_tipo = 			  			$params->emp_tipo;
				
				$this->base_salario =				  		$params->salario;
			}
		}
		
		$compAtualBase = $this->financiamento_model->buscaComprometimentoFuncionario($this->idFuncionario, 'FIN', $this->idEmprestimo);
		$compAtualBase = array_shift($compAtualBase);
		$this->base_valor_comprometido_atual = $compAtualBase->valor;
		
		if ($this->idEmprestimo > 0) {
			$financiamento = $this->financiamento_model->getFinanciamento($this->idEmprestimo);
			$financiamento = array_shift($financiamento);
			$this->base_situacao = $financiamento->situacao;
			$this->tipoEmprestimo= $financiamento->tipoEmprestimo;
			
			if ($this->base_situacao == 'aprovado' || $this->base_situacao == 'liquidado') {
				$this->idEmprestimo= 	$financiamento->idEmprestimo;
				$this->idFornecedor =	$financiamento->idFornecedor;
				$this->dataSolicitacao= $financiamento->dataSolicitacao;
				$this->idFuncionario =	$financiamento->idFuncionario;
				$this->idCedente =		$financiamento->idCedente;
				$this->salario = 		$financiamento->salarioAtual;
				$this->dataPrimParcela= $financiamento->dataPrimParcela;
				$this->valor = 			$financiamento->valor;
				$this->parcelas = 		$financiamento->parcelas;
				$this->juros = 			$financiamento->juros;
				$this->juros_periodo = 	$financiamento->juros_periodo;
				$this->juros_tipo = 	$financiamento->juros_tipo;
			}
		}
	}

	/*
	 * @autor: Davi Daniel
	 * @date : 22/10/2015
	 */
	private function popularDadosEmprestimoExterno() {
		$this->situacao	=		'aprovado';
		$this->idParametro =	$this->input->post('idParametro');
		$this->idFornecedor =	$this->session->userdata('idAcessoExterno');
		$this->tipoEmprestimo =	'emprestimo';
		$this->dataSolicitacao= date("Y-m-d");
		$this->dataPrimParcela= date("Y-m-d", strtotime("+30 days"));
		$this->idFuncionario =	$this->input->post('idFuncionario');
		$this->idCedente =		$this->input->post('idCedente');
		$this->valor = 			conv_num_para_base($this->input->post('valor'));
		$this->parcelas = 		$this->input->post('parcelas');

		
		$dados['params'] = $this->financiamento_model->buscaParamFuncionario($this->idFuncionario);
		
		foreach($dados['params'] as $params){
			if ($params->idParametro == $this->idParametro) {
				$this->base_emp_max_valor = 	  	  		$params->emp_max_valor;
				$this->base_emp_max_comprometimento =  		$params->emp_max_comprometimento;
				$this->base_emp_max_parcelas = 	  			$params->emp_max_parcelas;
				$this->base_emp_tx_juros = 		  			$params->emp_tx_juros;
				$this->base_emp_periodo = 		  			$params->emp_periodo;
				$this->base_emp_tipo = 			  			$params->emp_tipo;
				$this->base_salario =				  		$params->salario;
				
				$this->juros = 								$params->emp_tx_juros;
				$this->juros_periodo = 						$params->emp_periodo;
				$this->juros_tipo = 						$params->emp_tipo;
				$this->salario =					  		$params->salario;
			}
		}
		
		$compAtualBase = $this->financiamento_model->buscaComprometimentoFuncionario($this->idFuncionario, 'FIN', $this->idEmprestimo);
		$compAtualBase = array_shift($compAtualBase);
		$this->base_valor_comprometido_atual = $compAtualBase->valor;
	}
	
	private function popularDadosFomulario() {
		$this->inserirAlterarRemover = $this->input->post('inserirAlterarRemover');
		$this->idEmprestimo			= $this->input->post('idEmprestimo');
		$this->empFinancPermissao 	= ucfirst($this->input->post('tipoEmprestimo'));
		
		if ('remover' != $this->input->post('inserirAlterarRemover')) {
			$this->situacao	=		$this->input->post('situacao');
			$this->idParametro =	$this->input->post('idParametro');
			$this->idFornecedor =	$this->input->post('idFornecedor');
			$this->tipoEmprestimo =	$this->input->post('tipoEmprestimo');
			$this->dataSolicitacao= conv_data_DMY_para_YMD($this->input->post('dataSolicitacao'));
			$this->idFuncionario =	$this->input->post('idFuncionario');
			$this->idCedente =		$this->input->post('idCedente');
			$this->salario = 		conv_num_para_base($this->input->post('salario'));
			$this->dataPrimParcela= conv_data_DMY_para_YMD($this->input->post('dataPrimParcela'));
			$this->valor = 			conv_num_para_base($this->input->post('valor'));
			$this->parcelas = 		$this->input->post('parcelas');
			$this->juros = 			conv_num_para_base($this->input->post('juros'));
			$this->juros_periodo = 	$this->input->post('juros_periodo');
			$this->juros_tipo = 	$this->input->post('juros_tipo');
		}
	}
	
	/**persistencia*/

	function inserirEmprestimoExterno() {
		$idEmpresa = $this->financiamento_model->getIdEmpresaPeloIdFuncionario($this->idFuncionario);
		
		$dados = array(
				'idEmpresa' 				=> $idEmpresa,
				'idFuncionario'				=> $this->idFuncionario,
				'situacao'					=> 'aprovado',
				'tipoEmprestimo'			=> 'emprestimo',
				'localLancamento'			=> 'externo',
				'dataSolicitacao'			=> $this->dataSolicitacao,
				'dataPrimParcela'			=> $this->dataPrimParcela,
				'valor'						=> $this->valor,
				'valor_parcelas'			=> $this->valor_parcelas,
				'parcelas'					=> $this->parcelas,
				'comprometimento'			=> round(($this->comprometimento), 2),
				'juros_periodo'				=> $this->juros_periodo,
				'juros_tipo'				=> $this->juros_tipo,
				'juros'						=> $this->juros,
				'salarioAtual'				=> $this->base_salario,
				'aprovado'					=> $this->aprovado,
				'idFornecedor'				=> $this->session->userdata('idAcessoExterno')
			);
		
		$id = $this->financiamento_model->insert('emprestimos_grava_financiamento', $dados);
		
		if (!$id) {
			$this->motivoReprovacao .= 'Problemas ao inserir o registro [cód: notIns]';
			return false;
		}
		$this->logs_modelclass->registrar_log_insert('emprestimos_grava_financiamento', 'idEmprestimo', $id, 'Emprestimo Externo');
		return true;
	}
	
	function inserirFinanciamento() {
		if(!$this->permission->controllerManual($this->tipoEmprestimo)->canInsert()){
			$this->flashData = 'Você não tem permissão para inserir empr�stimos e financiamentos.';
		}
		else {
			$dados = $this->getDadosFormParaDatabaseFinanciamento();
	
			$id = $this->financiamento_model->insert('emprestimos_grava_financiamento', $dados);
	
			if (!$id) $this->flashData.= 'Problemas ao inserir o registro';
			
			$this->logs_modelclass->registrar_log_insert('emprestimos_grava_financiamento', 'idEmprestimo', $id, 'Emprestimo /Financiamento Interno');
			
			$this->idEmprestimo = $id;
		}
	}
	
	function alterarFinancEmprestimo() {
		if(!$this->permission->controllerManual($this->tipoEmprestimo)->canUpdate()){
			$this->flashData = 'Você não tem permissão para atualizar empr�stimos e financiamentos.';
		}
		else {
			$dados = $this->getDadosFormParaDatabaseFinanciamento();
			
			$this->logs_modelclass->registrar_log_antes_update('emprestimos_grava_financiamento', 'idEmprestimo', $this->idEmprestimo, 'Emprestimo /Financiamento Interno');
			$id = $this->financiamento_model->edit('emprestimos_grava_financiamento', $dados, 'idEmprestimo', $this->idEmprestimo);
			
			if (!$id) $this->flashData.= 'Problemas ao alterar o registro';
			else      $this->logs_modelclass->registrar_log_depois();
		}
	}
	
	function removerFinancEmprestimo() {
		if(!$this->permission->controllerManual($this->tipoEmprestimo)->canDelete()){
			$this->flashData = 'Você não tem permissão para remover ' . $this->tipoEmprestimo .'.';
		}
		else {
			if ($this->base_situacao != 'simulacao') {
				$this->flashData.= 'Apenas situação "Simulação" permite remover registro';
			}
			
			else {
				$this->logs_modelclass->registrar_log_antes_delete('emprestimos_grava_financiamento', 'idEmprestimo', $this->idEmprestimo, 'Emprestimo /Financiamento Interno');
				
				if (!$this->financiamento_model->delete(
					'emprestimos_grava_financiamento',
					array('idEmprestimo' => $this->idEmprestimo))
				) {
					$this->flashData.= 'Problemas ao remover o registro';
				}
				else      $this->logs_modelclass->registrar_log_depois();
			}			
		}
	}
	
	private function getDadosFormParaDatabaseFinanciamento() {
		$idEmpresa = $this->session->userdata['idCliente'];

		$dados = array(
				'idEmpresa' 				=> $idEmpresa,
				'idFuncionario'				=> $this->idFuncionario,
				'situacao'					=> $this->situacao,
				'tipoEmprestimo'			=> $this->tipoEmprestimo
		);
		
		if (!$this->base_situacao || $this->base_situacao == 'simulacao') {
			$dados = array_merge($dados, array(
				'dataSolicitacao'			=> $this->dataSolicitacao,
				'dataPrimParcela'			=> $this->dataPrimParcela,
				'valor'						=> $this->valor,
				'valor_parcelas'			=> $this->valor_parcelas,
				'parcelas'					=> $this->parcelas,
				'comprometimento'			=> round(($this->comprometimento), 2),
				'juros_periodo'				=> $this->juros_periodo,
				'juros_tipo'				=> $this->juros_tipo,
				'juros'						=> $this->juros,
				'salarioAtual'				=> $this->base_salario,
				'aprovado'					=> $this->aprovado
			));
			if (NULL != $this->idFornecedor) {
				$dados = array_merge($dados, array(
					'idFornecedor'				=> $this->idFornecedor
				));
			}
			if ($this->inserirAlterarRemover == 'inserir') {
				$dados = array_merge($dados, array(
					'localLancamento'			=> 'interno'
				));
			}
		}
		
		if ($this->idCedente > 0) $dados = array_merge($dados, array('idCedente' => $this->idCedente));
				
		return $dados;
	}
}