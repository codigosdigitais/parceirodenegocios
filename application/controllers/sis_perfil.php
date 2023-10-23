<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");
include_once (dirname(__FILE__) . "/classes/ParametroClass.php");

class sis_perfil extends MY_Controller {
    
	private $flashData;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('sis_perfil_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Perfil.');
           redirect(base_url());
        }
        
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$this->data['historico'] = $this->sis_perfil_model->carregarTodosPerfis($idEmpresa);
		
		$this->data['view'] = 'sis/sis_perfil_todos';
		$this->load->view('tema/topo',$this->data);
		
    }
    
    function popup_funcao_parametros() {

    	if(!$this->permission->canSelect()){
    		$this->session->set_flashdata('error','Você não tem permissão para visualizar Perfil.');
    		redirect(base_url());
    	}
    	
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	$idPerfilFuncao = $this->uri->segment(3);
    	
    	if ($idPerfilFuncao != "") {

    		$this->data['funcao'] = $this->sis_perfil_model->getDadosFuncao($idEmpresa, $idPerfilFuncao);
    		$this->data['permissoes'] = $this->sis_perfil_model->getDadosFuncaoPermissoes($idPerfilFuncao);
    		$this->data['parametros'] = $this->sis_perfil_model->getDadosFuncaoParametros($idPerfilFuncao);
    		//var_dump($this->data['permissoes']); die();
    	}
    	
    	$this->load->view('sis/sis_perfil_modulo_funcoes_parametros', $this->data);
    }

    function gravar_perfil_funcao_permissoes() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Perfil (parâmetros).');
           redirect(base_url());
        }
        
    	$table = 'sis_perfil_funcao';
    	 
    	if ($this->validarFormPerfilFuncaoPermissoes()) {
    	
    		$idPerfilFuncao = $this->input->post('idPerfilFuncao');
    		$dados = $this->getDadosFormPerfilFuncaoPermissoes();
    		
    		$this->logs_modelclass->registrar_log_antes_update($table, 'idPerfilFuncao', $idPerfilFuncao, 'Perfil (permissões)');
    		
   			$where = array('idPerfilFuncao' => $idPerfilFuncao);
   			$result = $this->sis_perfil_model->atualizarDados($table, $dados, $where);
   			
   			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
   			else $this->logs_modelclass->registrar_log_depois();
    	
    		$flashDataType = ($result) ? "success" : "error";
    	
    		if ($result) {
    			$this->flashData = "Registro armazenado com sucesso!";
    		}
    	
    		$this->session->set_flashdata($flashDataType, $this->flashData);
    		$url = $this->permission->getIdPerfilAtual().'/sis_perfil/popup_funcao_parametros/' . $idPerfilFuncao;
    		redirect(base_url($url));
    	}
    	 
    	else redirect(base_url('sis_perfil'));
    }

    function gravar_perfil_funcao_parametros_ajax() {
    	if(!$this->permission->canUpdate()){
    		echo 'Você não tem permissão para atualizar Perfil (parâmetros).';
    	}
    
    	$table = 'sis_perfil_funcao_parametro';
    	$retorno = array();
    
    	if ($this->validarFormPerfilFuncaoParametros()) {
    		
    		$idPerfilFuncaoParametro = $this->input->post('idPerfilFuncaoParametro');
    		$dados = $this->getDadosFormPerfilFuncaoParametros();
    		
    		if ($idPerfilFuncaoParametro == '') {
    			
    			$result = $this->sis_perfil_model->inserirDados($table, $dados);
    			
    			if (!$result) {
    				$retorno = array('error' => true, 'mensagem' => 'Erro ao inserir novo parâmetro');
    			}
    			else {
    				$retorno = array('success' => true, 'idPerfilFuncaoParametro' => $result);
    				$this->logs_modelclass->registrar_log_insert($table, 'idPerfilFuncaoParametro', $result, 'Perfil (parâmetros)');
    			}
    		
    		}
    		else {
	    		$this->logs_modelclass->registrar_log_antes_update($table, 'idPerfilFuncaoParametro', $idPerfilFuncaoParametro, 'Perfil (parâmetros)');
	    
	    		$where = array('idPerfilFuncaoParametro' => $idPerfilFuncaoParametro);
	    		$result = $this->sis_perfil_model->atualizarDados($table, $dados, $where);
    		
    			if (!$result) {
    				$retorno = array('error' => true, 'mensagem' => 'Erro ao atualizar parâmetro');
    			}
    			else {
    				$retorno = array('success' => true);
    				$this->logs_modelclass->registrar_log_depois();
    			}
    		}
    		
    	}
    	
    	else {
    		$retorno = array('error' => true, 'mensagem' => 'Erro na validação do formulário: ' . $this->flashData);
    	}
    	
    	echo json_encode($retorno);
    	//var_dump($retorno);
    }
    
    function perfilAdicionar(){
    	 
    	$idPerfil = $this->uri->segment(3);
    	
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	 
    	$this->data['historico'] = false;
    	 
    	if ($idPerfil) {
    		$this->data['historico'] = $this->sis_perfil_model->carregarPerfil($idEmpresa, $idPerfil);
    		$this->data['modulosFuncoesVinculados'] = $this->sis_perfil_model->carregarModulosFuncoesVinculados($idEmpresa, $idPerfil);
    		
    		$this->data['modulosFuncoesDisponiveis'] = $this->sis_perfil_model->carregarModulosFuncoesDisponiveis($idEmpresa, $idPerfil);
    		
    	}
    	
    	$this->data['view'] = 'sis/sis_perfil_view';
    	$this->load->view('tema/topo',$this->data);
    
    }
    
    function remover_perfil_funcao() {
        if(!$this->permission->canDelete()){
           $this->session->set_flashdata('error','Você não tem permissão para remover Perfil (função).');
           redirect(base_url());
        }
        
    	$table = 'sis_perfil_funcao';
    	
    	$idPerfilFuncao = $this->input->post('idPerfilFuncao');
    	$idPerfil= $this->input->post('idPerfil');
    	
    	$result = false;
    	
    	if ($idPerfilFuncao != "") {
    		
    		$this->logs_modelclass->registrar_log_antes_delete($table, 'idPerfilFuncao', $idPerfilFuncao, 'Perfil (função)');
    		
	    	$where = array('idPerfilFuncao' => $idPerfilFuncao);
	    	$result = $this->sis_perfil_model->removerRegistro($table, $where);
	    	
	    	if (!$result) $this->flashData = "Problemas ao remover registro.";
	    	else $this->logs_modelclass->registrar_log_depois();
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	 
    	if ($result) {
    		$this->flashData = "Registro removido com sucesso!";
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_perfil/perfilAdicionar/' . $idPerfil));
    	
    }
    
    function gravar_perfil_funcao() {
    	$table = 'sis_perfil_funcao';
    	
    	$idPerfilFuncao = $this->input->post('idPerfilFuncao');
    	$idModuloCliente = $this->input->post('idModuloCliente');
    	$idPerfil = $this->input->post('idPerfil');
    	
    	$url = $this->permission->getIdPerfilAtual().'/sis_perfil/perfilAdicionar/' . $idPerfil;
    	
    	if($idPerfilFuncao == '' && !$this->permission->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir Perfil (função).');
    		redirect(base_url());
    	}
    	else if(!$this->permission->canUpdate()){
    		$this->session->set_flashdata('error','Você não tem permissão para atualizar Perfil (função).');
    		redirect(base_url());
    	}
    	
    	if ($this->validarFormPerfilFuncao()) {
    		
    		$dados = $this->getDadosFormPerfilFuncao();
    		
    		if ($idPerfilFuncao == '') {
	    		$idPerfilFuncao = $this->sis_perfil_model->inserirDados($table, $dados);
	    		$result = $idPerfilFuncao;
	    		if (!$result) $this->flashData = "Problemas ao inserir registro.";
	    		else $this->logs_modelclass->registrar_log_insert($table, 'idPerfilFuncao', $idPerfilFuncao, 'Perfil (função)');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idPerfilFuncao', $idPerfilFuncao, 'Perfil (função)');
    			
    			$where = array('idPerfilFuncao' => $idPerfilFuncao);
    			$result = $this->sis_perfil_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    			
    			$url = $this->permission->getIdPerfilAtual().'/sis_perfil/popup_modulo_parametros/' . $idPerfilFuncao;
    		}
    		
	    	$flashDataType = ($result) ? "success" : "error";
	    	
	    	if ($result) {
	    		$this->flashData = "Registro armazenado com sucesso!";
	    	}
	    	
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url($url));
	    }
	    
	    else {
	    	$flashDataType = ($result) ? "success" : "error";
	    	$this->session->set_flashdata($flashDataType, $this->flashData);
	    	redirect(base_url($url));
	    }
    }

    function gravar_perfil() {
    	$table = 'sis_perfil';
    	$url = $this->permission->getIdPerfilAtual().'/sis_perfil';

    	$idPerfil = $this->input->post('idPerfil');

    	if($idPerfil == '' && !$this->permission->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir Perfil.');
    		redirect(base_url());
    	}
    	else if(!$this->permission->canUpdate()){
    		$this->session->set_flashdata('error','Você não tem permissão para atualizar Perfil.');
    		redirect(base_url());
    	}
    	
    	if ($this->validarFormPerfil()) {
    		
    		$dados = $this->getDadosFormPerfil();
    		
    		if ($idPerfil == "") {
    			$idPerfil = $this->sis_perfil_model->inserirDados($table, $dados);
    			$result = $idPerfil;
    			
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idPerfil', $idPerfil, 'Perfil');
    			
    			$url = $this->permission->getIdPerfilAtual().'/sis_perfil/perfilAdicionar/' . $idPerfil;
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idPerfil', $idPerfil, 'Perfil');
    			
    			$where = array('idPerfil' => $idPerfil);
    			$result = $this->sis_perfil_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    			
    			$url = $this->permission->getIdPerfilAtual().'/sis_perfil/perfilAdicionar/' . $idPerfil;
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($url));
    }

    function validarFormPerfilFuncaoPermissoes() {
    	
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';


    	$this->form_validation->set_rules('idPerfilFuncao', 		'idPerfilFuncao',	 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idUsuario', 	 			'idUsuario', 				'trim|xss_clean');
    	$this->form_validation->set_rules('situacaoUsuario', 		'situacaoUsuario',			'trim|xss_clean');
    	$this->form_validation->set_rules('canSelect', 	 	 		'canSelect', 				'trim|xss_clean');
    	$this->form_validation->set_rules('canInsert', 	 	 		'canInsert', 				'trim|xss_clean');
    	$this->form_validation->set_rules('canUpdate', 	 	 		'canUpdate', 				'trim|xss_clean');
    	$this->form_validation->set_rules('canDelete', 	 	 		'canDelete', 				'trim|xss_clean');
    
    
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function validarFormPerfilFuncaoParametros() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';

    	$this->form_validation->set_rules('idPerfilFuncaoParametro','idPerfilFuncaoParametro',	'trim|xss_clean');
    	$this->form_validation->set_rules('idPerfilFuncao', 		'idPerfilFuncao',	 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idFuncaoParam', 	 		'idUsuario', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('valorParametro', 	 	'valorParametro', 			'trim|xss_clean');
    
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function validarFormPerfilFuncao() {
    	
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';

    	$this->form_validation->set_rules('idModuloClienteFuncao', 	'idModuloClienteFuncao','trim|xss_clean');
    	$this->form_validation->set_rules('idModuloCliente', 		'idModuloCliente', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idPerfil', 	 			'idPerfil', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('situacao', 	 	 		'situacao', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('visivel', 	 	 		'visivel', 				'trim|required|xss_clean');
    
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }
    
    function validarFormPerfil() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idPerfil', 	 		'idPerfil', 		'trim|xss_clean');
    	$this->form_validation->set_rules('nomePerfil', 	 	'nomePerfil', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('situacao', 	 	 	'situacao', 		'trim|required|xss_clean');
    	 
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }
    
    function getDadosFormPerfilFuncaoPermissoes() {
    	$dados = array(
    			'idPerfilFuncao'		=> $this->input->post('idPerfilFuncao'),
    			'canSelect' 			=> $this->input->post('canSelect') ? true : false,
    			'canInsert' 			=> $this->input->post('canInsert') ? true : false,
    			'canUpdate' 			=> $this->input->post('canUpdate') ? true : false,
    			'canDelete' 			=> $this->input->post('canDelete') ? true : false,
    			'situacao'		 		=> 1
    	);
    	return $dados;
    }

    function getDadosFormPerfilFuncaoParametros() {
    	$dados = array(
    			'idPerfilFuncao'		=> $this->input->post('idPerfilFuncao'),
    			'idFuncaoParam'			=> $this->input->post('idFuncaoParam'),
    			'valor'					=> $this->input->post('valorParametro')
    	);
    	return $dados;
    }

    function getDadosFormPerfilFuncao() {
    	$dados = array(
    			'idPerfil'		 		=> $this->input->post('idPerfil'),
    			'idModuloClienteFuncao' => $this->input->post('idModuloClienteFuncao'),
    			'situacao'		 		=> $this->input->post('situacao'),
    			'visivel'		 		=> $this->input->post('visivel')
    	);
    	return $dados;
    }
    
    function getDadosFormPerfil() {
    	$dados = array(
    			'idPerfil'			=> $this->input->post('idPerfil'),
    			'idEmpresa'			=> $this->session->userdata['idEmpresa'],
    			'nome'				=> $this->input->post('nomePerfil'),
    			'situacao'			=> $this->input->post('situacao')
    	);
    	return $dados;
    }
}