<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class sis_unidade extends MY_Controller {
    
	private $flashData;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('sis_unidade_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Unidades Organizacionais.');
           redirect(base_url());
        }
        
		$this->data['historico'] = $this->sis_unidade_model->carregarHistoricoTodos();

		$this->data['view'] = 'sis/sis_unidade_todos';
		$this->load->view('tema/topo',$this->data);
		
    }

    function editarunidade(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Unidades Organizacionais.');
           redirect(base_url());
        }
    	
    	$idUnidade = $this->uri->segment(4);
    	
    	$this->data['historico'] = false;
    	
    	if ($idUnidade) {
    		$this->data['historico'] = $this->sis_unidade_model->carregar($idUnidade);
    	}
    
    	$this->data['view'] = 'sis/sis_unidade_view';
    	$this->load->view('tema/topo',$this->data);
    
    }

    function editarparametrosfuncao() {
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Unidades Organizacionais.');
           redirect(base_url());
        }

    	$idFuncao = $this->uri->segment(4);
    	 
    	$this->data['historico'] = false;
    	 
    	if ($idFuncao) {
    		$this->data['historico'] = $this->sis_unidade_model->carregarFuncaoParam($idFuncao);
    	}
    	
    	$this->data['view'] = 'sis/sis_unidade_param';
    	$this->load->view('tema/topo',$this->data);
    }
    
    function gravar_parametro() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para inserir Unidades Organizacionais (parâmetros).');
           redirect(base_url());
        }
    	$table = 'sis_funcao_param';
    	 
    	if ($this->validarFormParametros()) {
    		
    		$idFuncao = $this->input->post('idFuncao');
    		$dados = $this->getDadosFormParametros();
    		
    		$result = $this->sis_unidade_model->inserirDados($table, $dados);
    		if (!$result) $this->flashData = "Problemas ao inserir registro.";
    		else $this->logs_modelclass->registrar_log_insert($table, 'idFuncaoParam', $result, 'Unidades Organizacionais (insere parâmetro)');
    	}

    	$flashDataType = ($result) ? "success" : "error";
    	 
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/sis_unidade/editarparametrosfuncao/' . $idFuncao);
    }

    function gravar_unidade() {        
    	$table = 'sis_unidade';

    	$idUnidade = $this->input->post('idUnidade');

    	if($idUnidade == "" && !$this->permission->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir Unidades Organizacionais.');
    		redirect(base_url());
    	}
    	
    	else if(!$this->permission->canUpdate()){
    		$this->session->set_flashdata('error','Você não tem permissão para atualizar Unidades Organizacionais.');
    		redirect(base_url());
    	}
    	
    	if ($this->validarFormUnidade()) {
    		
    		$dados = $this->getDadosFormUnidade();
    		
    		if ($idUnidade == "") {
    			$idUnidade = $this->sis_unidade_model->inserirDados($table, $dados);
    			$result = $idUnidade;
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idUnidade', $result, 'Unidades Organizacionais');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idUnidade', $idUnidade, 'Unidades Organizacionais');
    			
    			$where = array('idUnidade' => $idUnidade);
    			$result = $this->sis_unidade_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/sis_unidade/editarunidade/' . $idUnidade);
    }

    function gravar_funcao() {
    	$idUnidade = $this->input->post('idUnidade');
    	$idFuncao  = $this->input->post('idFuncao');
    	$table = 'sis_funcao';

    	if($idFuncao == "" && !$this->permission->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir funções em Unidades Organizacionais.');
    		redirect(base_url());
    	}

    	else if(!$this->permission->canUpdate()){
    		$this->session->set_flashdata('error','Você não tem permissão para atualizar funções em Unidades Organizacionais.');
    		redirect(base_url());
    	}
    	
    	if ($this->validarFormFuncao()) {
    		$dados = $this->getDadosFormFuncao();
    		
    		if ($idFuncao == "") {
    			$result = $this->sis_unidade_model->inserirDados($table, $dados);
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idFuncao', $result, 'Unidades Organizacionais (insere função)');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idFuncao', $idFuncao, 'Unidades Organizacionais (atualiza função)');
    			
    			$where = array('idFuncao' => $idFuncao);
    			$result = $this->sis_unidade_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/sis_unidade/editarunidade/' . $idUnidade);
    }

    function validarFormParametros() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idFuncao', 	 	 'idFuncao', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('nomeParametro', 	 'nomeParametro', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('stringParametro', 'stringParametro', 'trim|required|xss_clean');
    	$this->form_validation->set_rules('tipoParametro', 	 'tipoParametro', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('acessivel', 		 'acessivel', 		'trim|required|xss_clean');
    	
    	$this->form_validation->set_rules('valPadrao', 		 'valPadrao', 		'trim|xss_clean');
    	$this->form_validation->set_rules('valInicial', 	 'valInicial', 		'trim|xss_clean');
    	$this->form_validation->set_rules('valFinal', 		 'valFinal', 		'trim|xss_clean');
    	$this->form_validation->set_rules('arrCodigos[]', 	 'arrCodigos[]', 	'trim|xss_clean');
    	$this->form_validation->set_rules('arrValores[]', 	 'arrValores[]', 	'trim|xss_clean');
    	
    	$stringForm = $this->input->post('stringParametro');
    	$stringPHP  = preg_replace('/[^A-Za-z0-9\-]/', '', $stringForm);
    	
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else if ($stringForm != $stringPHP) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário! Reveja o nome do parâmetro.</div>';
    		 
    		return false;
    	}
    	else return true;
    }
    
    function getDadosFormParametros() {
    	
    	$valor = $this->getDadosFormParametrosValorConformeTipo();
    	$padrao= $this->getDadosFormParametrosPadraoConfTipo();
    
    	$dados = array(
    			'idFuncao'		=> $this->input->post('idFuncao'),
    			'nome'			=> $this->input->post('nomeParametro'),
    			'string'		=> $this->input->post('stringParametro'),
    			'tipo'			=> $this->input->post('tipoParametro'),
    			'valor'			=> $valor,
    			'padrao'		=> $padrao,
    			'acesso'		=> $this->input->post('acessivel'),
    	);
    	
    	return $dados;
    }
    
    function getDadosFormParametrosPadraoConfTipo() {
    	$valor = $this->input->post('valPadrao');
    	
    	switch ($this->input->post('tipoParametro')) {
    		case 'faixaInteiro' : $valor = $this->getDadosFormParamFaixas(); break;
    		case 'faixaReal' 	: $valor = $this->getDadosFormParamFaixas(); break;
    	}

    	return $valor;
    }
    
    function getDadosFormParametrosValorConformeTipo() {
    	$valor = "";
    	
    	switch ($this->input->post('tipoParametro')) {
    		case 'array' 		: $valor = $this->getDadosFormParamArray(); break;
    	}

    	return $valor;
    }
    
    function getDadosFormParamFaixas() {
    	$valor = array(	$this->input->post('valInicial'),
    					$this->input->post('valFinal'),
    					$this->input->post('valPadrao')
    	);
    	
    	return serialize( $valor );
    }
    function getDadosFormParamArray() {
    	
    	$arrCodigos = $this->input->post('arrCodigos');
    	$arrValores = $this->input->post('arrValores');
    	
    	$valor = array();
    	
    	for ($i = 0; $i < count($arrCodigos); $i++) {
    		$key = preg_replace('/[^A-Za-z0-9\-]/', '', $arrCodigos[$i]);
    		$val = $arrValores[$i];
    		
    		$valor = array_merge($valor, array($key => $val));
    	}
		
    	return serialize( $valor );
    }
    
    function validarFormUnidade() {
    	
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';

    	$this->form_validation->set_rules('idUnidade', 	 	'idUnidade', 		'trim|xss_clean');
    	$this->form_validation->set_rules('nomeUnidade', 	 'nomeUnidade', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('situacaoUnidade', 'situacaoUnidade', 'trim|required|xss_clean');
    	
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }
    
    function getDadosFormUnidade() {
    	$dados = array(
    		'nome'		=> $this->input->post('nomeUnidade'),
    		'situacao'	=> $this->input->post('situacaoUnidade')
    	);
    	return $dados;
    }

    function validarFormFuncao() {
    	
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';

    	$this->form_validation->set_rules('idUnidade', 	 	'idUnidade', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idFuncao', 	 	'idFuncao', 		'trim|xss_clean');
    	$this->form_validation->set_rules('nomeFuncao', 	'nomeFuncao', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('controller', 	'controller', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('situacaoFuncao', 'situacaoFuncao', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('tipo', 			'tipo', 			'trim|required|xss_clean');
    	
    	$stringForm = $this->input->post('controller');
    	$stringPHP  = preg_replace('/[^A-Za-z0-9\_\-\/]/', '', $stringForm);
    	
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else if ($stringForm != $stringPHP) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário! Reveja o nome do controller.</div>';
    		 
    		return false;
    	}
    	
    	else return true;
    }
    
    function getDadosFormFuncao() {
    	$dados = array(
    		'idUnidade'		=> $this->input->post('idUnidade'),
    		'nome'			=> $this->input->post('nomeFuncao'),
    		'controller'	=> $this->input->post('controller'),
    		'situacao'		=> $this->input->post('situacaoFuncao'),
    		'tipo'			=> $this->input->post('tipo')
    	);
    	return $dados;
    }
    
}