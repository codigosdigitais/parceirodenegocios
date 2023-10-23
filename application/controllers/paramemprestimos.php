<?php
/*
* @autor: Davi Siepmann
* @date: 21/09/2015
*/
include_once (dirname(__FILE__) . "/global_functions_helper.php");

# FECHAMENTO EXTENDS CONTROLLER #
class paramemprestimos extends MY_Controller {
	
	//ajaxResponse
	private $flashData = "";
	
	//parametros por funcionário
	private $idParametro;
	private $idFuncionario;
	private $action;
	private $emp_max_valor;
	private $emp_max_comprometimento;
	private $emp_max_parcelas;
	private $emp_tx_juros;
	private $financ_max_valor;
	private $financ_max_comprometimento;
	private $financ_max_parcelas;
	private $financ_tx_juros;
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
			//verifica login
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');
            
            $this->load->helper(array('codegen_helper'));
            $this->load->model('paramemprestimos_model','',TRUE);
	}	
	
	/*
	* @autor: Davi Siepmann
	* @date: 18/09/2015
	*/
	# exibe parametros de empréstimo e financiamento à funcionários
	function index(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar os parâmetros de empréstimo.');
           redirect(base_url());
        }
		else {
			$idEmpresa = $this->session->userdata['idCliente'];
			
		    $this->data['results'] = $this->paramemprestimos_model->getCedentes();
		    
		    $where = array('idEmpresa' => $idEmpresa, 'idCedente' => NULL);
		    $this->data['param_global'] = $this->paramemprestimos_model->getBase('emprestimos_habilita_cedentes b', $where, NULL);
		    
	       	$this->data['view'] = 'emprestimo/param_lista_cedentes';
	       	$this->load->view('tema/topo',$this->data);
		}
	}

	/*
	 * @autor: Davi Siepmann
	 * @date: 18/09/2015
	 */
	# exibe parametros de empréstimo e financiamento à funcionários
	function param_cedente(){
		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar os parâmetros de empréstimo.');
			redirect(base_url());
		}
		else {
			$idEmpresa = $this->session->userdata['idCliente'];
			
			$this->data['lista_funcionarios'] 		= $this->paramemprestimos_model->getFuncionariosCedente($this->uri->segment(4));
			$this->data['param_emprestimos'] 		= $this->paramemprestimos_model->getParametrosCedente($this->uri->segment(4));
			$this->data['lista_params'] 			= $this->paramemprestimos_model->getParamFuncionarios($this->uri->segment(4));

			if (1 == count($this->data['param_emprestimos'])) {
				$this->data['view'] = 'emprestimo/param_por_cedente';
				$this->load->view('tema/topo',$this->data);
			}
			else redirect(base_url() . $this->permission->getIdPerfilAtual().'/paramemprestimos');
		}
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 26/09/2015
	 */
	function gravar_habilita_cedentes() {
	
		if(!$this->permission->canUpdate()){
			$this->flashData = 'Você não tem permissão para atualizar os parâmetros de empréstimo.';
		}
		else {
			$idEmpresa = $this->session->userdata['idCliente'];
			
			$idParametro = $this->input->post('tb_idParametro');
			$idCedente = $this->input->post('tb_idCedente');
			$habilitado = $this->input->post('tb_habilitado');
			
			for ($i=0; $i < count($idCedente); $i++) {
				$data = array('idEmpresa' => $idEmpresa, 'habilitado' => $habilitado[$i]);
				
				//verifica se par�metros globais (n�o por cedente)
				if (0 < $idCedente[$i]) $data = array_merge($data, array('idCedente' => $idCedente[$i]));
				else					$data = array_merge($data, array('idCedente' => NULL));
				
				$tabela = 'emprestimos_habilita_cedentes';
				
				if(!$idParametro[$i]) {
					$id = $this->paramemprestimos_model->insert($tabela, $data);
					$this->logs_modelclass->registrar_log_insert($tabela, 'idParametro', $id, 'Habilita/Desabilita Param Emp /Financ Cedente');
				}
				else {
					$this->logs_modelclass->registrar_log_antes_update($tabela, 'idParametro', $idParametro[$i], 'Habilita/Desabilita Param Emp /Financ Cedente');
					if ($this->paramemprestimos_model->edit($tabela, $data,'idParametro',$idParametro[$i]))
						$this->logs_modelclass->registrar_log_depois();
				}
				
			}
		}
		$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
		if ($this->flashData == "") $this->flashData = "Parâmetros registrados com sucesso!";
		
		$this->session->set_flashdata($flashDataType, $this->flashData);
		redirect(base_url() . $this->permission->getIdPerfilAtual().'/paramemprestimos/');
	}
	
	/*
	* @autor: Davi Siepmann
	* @date: 18/09/2015
	*/
	function gravar_param_emprestimos() {
		
        if(!$this->permission->canUpdate()){
			$this->flashData = 'Você não tem permissão para atualizar os parâmetros de empréstimo.';
        }
		else { 
			if ($this->validaFormulario()) {
				//carrega dados do formulário para parâmetros globais
				$data = array(
					'emp_max_valor' 				=> conv_num_para_base($this->input->post('emp_max_valor')),
					'emp_max_comprometimento'		=> conv_num_para_base($this->input->post('emp_max_comprometimento')),
					'emp_max_parcelas'				=> $this->input->post('emp_max_parcelas'),
					'emp_tx_juros'					=> conv_num_para_base($this->input->post('emp_tx_juros')),
					'emp_periodo'					=> $this->input->post('emp_periodo'),
					'emp_tipo'						=> $this->input->post('emp_tipo'),
					'financ_max_valor'				=> conv_num_para_base($this->input->post('financ_max_valor')),
					'financ_max_comprometimento'	=> conv_num_para_base($this->input->post('financ_max_comprometimento')),
					'financ_max_parcelas'			=> $this->input->post('financ_max_parcelas'),
					'financ_tx_juros'				=> conv_num_para_base($this->input->post('financ_tx_juros')),
					'financ_periodo'				=> $this->input->post('financ_periodo'),
					'financ_tipo'					=> $this->input->post('financ_tipo'),
				);
				$this->logs_modelclass->registrar_log_antes_update('emprestimos_parametros', 'idParametro', $this->input->post('idParametro'), 'Param Emp /Financ Cedente');
				if (!$this->paramemprestimos_model->edit('emprestimos_parametros',$data,'idParametro',$this->input->post('idParametro')) == TRUE)
				{
					$this->flashData = 'Problemas ao gravar os Parâmetros Globais! Por favor, tente novamente';
				}
				else $this->logs_modelclass->registrar_log_depois();
				
				//insere parâmetros por funcionário (caso houverem)
				if (isset($_POST['tb_idFuncionario'])) {
					$this->idParametro				= $this->input->post('tb_idParametro');
					$this->idFuncionario			= $this->input->post('tb_idFuncionario');
					$this->action					= $this->input->post('tb_action');
					$this->emp_max_valor			= conv_num_para_base($this->input->post('tb_emp_max_valor'));
					$this->emp_max_comprometimento	= conv_num_para_base($this->input->post('tb_emp_max_comprometimento'));
					$this->emp_max_parcelas			= $this->input->post('tb_emp_max_parcelas');
					$this->emp_tx_juros				= conv_num_para_base($this->input->post('tb_emp_tx_juros'));
					$this->financ_max_valor			= conv_num_para_base($this->input->post('tb_financ_max_valor'));
					$this->financ_max_comprometimento	= conv_num_para_base($this->input->post('tb_financ_max_comprometimento'));
					$this->financ_max_parcelas		= $this->input->post('tb_financ_max_parcelas');
					$this->financ_tx_juros			= conv_num_para_base($this->input->post('tb_financ_tx_juros'));
					
					
					for ($i=0; $i < count($this->idFuncionario); $i++) {
						switch($this->action[$i]) {
							case 'inserir':
								$this->inserirParamFuncionario($i);
								break;
							case 'alterar':
								$this->alterarParamFuncionario($i);
								break;
							case 'remover':
								$this->removerParamFuncionario($i);
								break;
						}
					}
				}
			}
		}
		$flashDataType 	 = ($this->flashData == "") ? "success" : "error";
		if ($this->flashData == "") $this->flashData = "Parâmetros registrados com sucesso!";
		
		$this->session->set_flashdata($flashDataType, $this->flashData);
		redirect(base_url() . $this->permission->getIdPerfilAtual().'/paramemprestimos/param_cedente/' . $this->input->post('idCedente'));
	}	
	
	function validaFormulario() {
		//estas informações não estarão disponíveis apenas se o usuário alterar o cód. fonte do navegador (ou por um problema de javascript)
		$this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('emp_max_valor', 			'Empréstimo: Valor máximo global', 				'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_max_comprometimento','Empréstimo: Comprometimento máx. salário', 		'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_max_parcelas', 		'Empréstimo: Quantidade máx. parcelas', 			'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_tx_juros', 			'Empréstimo: Taxa de juros padrão %', 			'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_periodo',  			'Empréstimo: Período aplicação de juros', 		'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_tipo', 				'Empréstimo: Tipo de aplicação de juros', 		'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_max_valor', 		'Financiamento: Valor máximo global', 				'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_max_comprometimento',	'Financiamento: Comprometimento máx. salário %', 	'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_max_parcelas',	'Financiamento: Quantidade máx. parcelas', 		'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_tx_juros', 		'Financiamento: Taxa de juros padrão %', 			'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_periodo',  		'Financiamento: Período aplicação de juros', 	'trim|required|xss_clean');
		$this->form_validation->set_rules('financ_tipo', 			'Financiamento: Tipo de aplicação de juros', 		'trim|required|xss_clean');
		if (isset($_POST['tb_idFuncionario'])) {
			$this->form_validation->set_rules('tb_idFuncionario[]', 		'Funcionário (parâmetro por funcionário)', 			'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_action[]', 				'Func. Ação [comunique responsável pelo sistema]', 	'trim|xss_clean');
			$this->form_validation->set_rules('tb_emp_max_valor[]', 		'Empréstimo: Valor máximo por funcionário',			'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_emp_max_comprometimento[]','Empréstimo: Comprometimento por funcionário', 		'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_emp_max_parcelas[]',		'Empréstimo: Quantidade parcelas por funcionário',	'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_emp_tx_juros[]', 			'Empréstimo: Taxa de juros por funcionário', 			'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_financ_max_valor[]', 		'Financiamento: Valor máximo por funcionário', 		'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_financ_max_comprometimento[]','Financiamento: Comprometimento por funcionário',		'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_financ_max_parcelas[]',	'Financiamento: Qtde parcelas por funcionário', 		'trim|required|xss_clean');
			$this->form_validation->set_rules('tb_financ_tx_juros[]', 		'Financiamento: Taxa de juros por funcionário', 		'trim|required|xss_clean');
		}
		if ($this->form_validation->run() == false) {
			//se não passar na validação informa erro ao usuário
			$this->flashData = '<div class="form_error">Problemas ao gravar alguns Parâmetros!</div>'.validation_errors();
			
			return false;
		}
		else return true;
	}
	
	function inserirParamFuncionario($index) {
		if(!$this->permission->canInsert()){
			$this->flashData = 'Você não tem permissão para inserir parâmetros de empréstimo.';
		}
		else {
			$idEmpresa = $this->session->userdata['idCliente'];
			
			$param_funcionario = array(
				'idEmpresa' 				=> $idEmpresa,
				'idFuncionario'				=> $this->idFuncionario[$index],
				'emp_max_valor'				=> $this->emp_max_valor[$index],
				'emp_max_comprometimento' 	=> $this->emp_max_comprometimento[$index],
				'emp_max_parcelas'			=> $this->emp_max_parcelas[$index],
				'emp_tx_juros' 				=> $this->emp_tx_juros[$index],
				'financ_max_valor' 			=> $this->financ_max_valor[$index],
				'financ_max_comprometimento'=> $this->financ_max_comprometimento[$index],
				'financ_max_parcelas' 		=> $this->financ_max_parcelas[$index],
				'financ_tx_juros' 			=> $this->financ_tx_juros[$index]
			);
			
			//verifica se par�metros globais (n�o por cedente)
			if (0 < $this->input->post('idCedente'))
				$param_funcionario = array_merge($param_funcionario, array('idCedente' => $this->input->post('idCedente')));
			
			$id = $result = $this->paramemprestimos_model->insert('emprestimos_parametros', $param_funcionario);
			$this->logs_modelclass->registrar_log_insert('emprestimos_parametros', 'idParametro', $id, 'Param Emp /Financ por Funcionario');
			
			if (!$result) {
				$this->flashData.= 'Problemas ao gravar os parâmetros para funcionário código: '. $this->idFuncionario[$index] .'.';
			}
		}
	}
	
	function alterarParamFuncionario($index) {
		if(!$this->permission->canUpdate()){
			$this->flashData = 'Você não tem permissão para atualizar parâmetros de empréstimo.';
		}
		else {
			$param_funcionario = array(
				'emp_max_valor'				=> $this->emp_max_valor[$index],
				'emp_max_comprometimento' 	=> $this->emp_max_comprometimento[$index],
				'emp_max_parcelas'			=> $this->emp_max_parcelas[$index],
				'emp_tx_juros' 				=> $this->emp_tx_juros[$index],
				'financ_max_valor' 			=> $this->financ_max_valor[$index],
				'financ_max_comprometimento'=> $this->financ_max_comprometimento[$index],
				'financ_max_parcelas' 		=> $this->financ_max_parcelas[$index],
				'financ_tx_juros' 			=> $this->financ_tx_juros[$index]
			);
			
			$this->logs_modelclass->registrar_log_antes_update('emprestimos_parametros', 'idParametro', $this->idParametro[$index], 'Param Emp /Financ por Funcionario');
			if (!$this->paramemprestimos_model->edit(
				'emprestimos_parametros',
				$param_funcionario,
				'idParametro',
				$this->idParametro[$index])
			) {
				$this->flashData.= 'Problemas ao gravar os parâmetros para funcionário código: '. $this->idFuncionario[$index] .'.';
			}
			else $this->logs_modelclass->registrar_log_depois();
		}
	}
	
	function removerParamFuncionario($index) {
		if(!$this->permission->canDelete()){
			$this->flashData = 'Você não tem permissão para remover parâmetros de empréstimo.';
		}
		else {
			$this->logs_modelclass->registrar_log_antes_delete('emprestimos_parametros', 'idParametro', $this->idParametro[$index], 'Param Emp /Financ por Funcionario');
			if (!$this->paramemprestimos_model->delete(
				'emprestimos_parametros',
				array('idParametro' => $this->idParametro[$index]))
			) {
				$this->flashData.= 'Problemas ao remover parâmetros para funcionário código: '. $this->idFuncionario[$index] .'.';
			}
			else $this->logs_modelclass->registrar_log_depois();
		}
	}
}
?>