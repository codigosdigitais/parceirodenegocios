<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class sis_libera_modulos extends MY_Controller {
    
	private $flashData;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            	redirect(base_url());
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('sis_libera_modulos_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Liberação de Módulos.');
           redirect(base_url());
        }
		
		$this->data['historico'] = $this->sis_libera_modulos_model->carregarTodosClientes();
		
		$this->data['view'] = 'sis/sis_libera_modulos_todos';
		$this->load->view('tema/topo',$this->data);
		
    }

    function edita_modulo(){
    	if(!$this->permission->canSelect()){
    		$this->session->set_flashdata('error','Você não tem permissão para visualizar Liberação de Módulos.');
    		redirect(base_url());
    	}
    	
    	$idModuloCliente = $this->uri->segment(4);
    	 
    	$this->data['historico'] = false;
    	 
    	if ($idModuloCliente) {
    		$this->data['historico'] = $this->sis_libera_modulos_model->carregarModulo($idModuloCliente);
    		$this->data['funcoesDisponiveis'] = $this->sis_libera_modulos_model->carregarFuncoesDisponiveis($idModuloCliente);
    	}
    	
    	$this->data['view'] = 'sis/sis_libera_modulos_funcoes';
    	$this->load->view('tema/topo',$this->data);
    
    }
    
    function editar_modulos_cliente(){

    	if(!$this->permission->canSelect()){
    		$this->session->set_flashdata('error','Você não tem permissão para visualizar Liberação de Módulos.');
    		redirect(base_url());
    	}
    	
    	$idCliente = $this->uri->segment(4);
    	
    	$this->data['historico'] = false;
    	
    	if ($idCliente) {
    		$this->data['historico'] = $this->sis_libera_modulos_model->carregarModulosCliente($idCliente);
    		$this->data['parceiros'] = $this->sis_libera_modulos_model->carregarParceiros($idCliente);
    	}
    
    	$this->data['view'] = 'sis/sis_libera_modulos_modulos';
    	$this->load->view('tema/topo',$this->data);
    
    }
    
    function remover_funcao_modulo() {

    	if(!$this->permission->canDelete()){
    		$this->session->set_flashdata('error','Você não tem permissão para remover funções de Liberação de Módulos.');
    		redirect(base_url());
    	}
    	
    	$table = 'sis_modulo_cliente_funcao';
    	
    	$idModuloClienteFuncao = $this->input->post('idModuloClienteFuncao');
    	$idModuloCliente= $this->input->post('idModuloCliente');
    	
    	$result = false;
    	
    	if ($idModuloClienteFuncao != "") {
    		$this->logs_modelclass->registrar_log_antes_delete($table, 'idModuloClienteFuncao', $idModuloClienteFuncao, 'Liberação de Módulos p/ Parceiro (remove função)');
    		
	    	$where = array('idModuloClienteFuncao' => $idModuloClienteFuncao);
	    	$result = $this->sis_libera_modulos_model->removerRegistro($table, $where);
	    	
	    	if (!$result) $this->flashData = "Problemas ao remover registro.";
	    	else $this->logs_modelclass->registrar_log_depois();
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	 
    	if ($result) {
    		$this->flashData = "Registro removido com sucesso!";
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_libera_modulos/edita_modulo/' . $idModuloCliente));
    	
    }
    
    function gravar_funcao_modulo() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Liberação de Módulos.');
           redirect(base_url());
        }
        
    	$table = 'sis_modulo_cliente_funcao';
    	
    	$idModuloCliente = $this->input->post('idModuloCliente');
    	$idModuloClienteFuncao = $this->input->post('idModuloClienteFuncao');
    	
    	if ($this->validarFormFuncao()) {
    		
    		$dados = $this->getDadosFormFuncao();
    		
    		if ($idModuloClienteFuncao == "") {
    			$result = $this->sis_libera_modulos_model->inserirDados($table, $dados);
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idModuloClienteFuncao', $result, 'Liberação de Módulos p/ Parceiro (insere função)');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idModuloClienteFuncao', $idModuloClienteFuncao, 'Liberação de Módulos p/ Parceiro (atualiza função)');
    			
    			$where = array('idModuloClienteFuncao' => $idModuloClienteFuncao);
    			$result = $this->sis_libera_modulos_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_libera_modulos/edita_modulo/' . $idModuloCliente));
    }

    function remover_modulo() {
    	if(!$this->permission->canDelete()){
    		$this->session->set_flashdata('error','Você não tem permissão para remover Liberação de Módulos.');
    		redirect(base_url());
    	}
    
    	$table = 'sis_modulo_cliente';
    	$idCliente = $this->input->post('idCliente');
    
    	if ($this->validarFormRemover()) {
    		$idModulo 		   = $this->input->post('idModulo');
    		 
    		$result = $this->sis_libera_modulos_model->removerModulo($idModulo);
    		 
    		$flashDataType = ($result) ? "success" : "error";
    
    		if ($result) {
    			$this->flashData = "Remoção realizada com sucesso!";
    		} else {
    			$this->flashData = "Problemas ao copiar módulo /funções";
    		}
    
    	}
    
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_libera_modulos/editar_modulos_cliente/' . $idCliente));
    }
    
    function copiar_modulo() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Liberação de Módulos.');
           redirect(base_url());
        }
        
        $table = 'sis_modulo_cliente';
        $idCliente = $this->input->post('idCliente');
        
        if ($this->validarFormCopia()) {
        	$idParceiroDestino = $this->input->post('idParceiroDestino');
        	$idModulo 		   = $this->input->post('idModulo');
        	
        	
        	$result = $this->sis_libera_modulos_model->copiarModulo($idModulo, $idParceiroDestino);
        	
        	
	    	$flashDataType = ($result) ? "success" : "error";
	    	
	    	if ($result) {
	    		$this->flashData = "Cópia realizada com sucesso!";
	    	} else {
	    		$this->flashData = "Problemas ao copiar módulo /funções";
	    	}
	    	
        }
        
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_libera_modulos/editar_modulos_cliente/' . $idCliente));
    }

    function gravar_modulo() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Liberação de Módulos.');
           redirect(base_url());
        }
        
    	$table = 'sis_modulo_cliente';
    	
    	$idCliente = $this->input->post('idCliente');
    	$url = $this->permission->getIdPerfilAtual().'/sis_libera_modulos/editar_modulos_cliente/' . $idCliente;
    	
    	if ($this->validarFormModulo()) {
    		
    		$idModuloCliente = $this->input->post('idModuloCliente');
    		
    		$dados = $this->getDadosFormModulo();
    		
    		if ($idModuloCliente == "") {
    			$idModuloCliente = $this->sis_libera_modulos_model->inserirDados($table, $dados);
    			$result = $idModuloCliente;
    			
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idModuloCliente', $idModuloCliente, 'Liberação de Módulos p/ Parceiro');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idModuloCliente', $idModuloCliente, 'Liberação de Módulos p/ Parceiro');
    			
    			$where = array('idModuloCliente' => $idModuloCliente);
    			$result = $this->sis_libera_modulos_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    			
    			$url = $this->permission->getIdPerfilAtual().'/sis_libera_modulos/edita_modulo/' . $idModuloCliente;
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($url));
    }

    function validarFormFuncao() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idModuloClienteFuncao', 	'idModuloClienteFuncao', 	'trim|xss_clean');
    	$this->form_validation->set_rules('idModuloCliente', 	'idModuloCliente', 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('idFuncao', 	 		'idFuncao', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('nomeFuncao', 	 	'nomeFuncao', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('ordemVisualizacao',	'ordemVisualizacao','trim|xss_clean');
    	$this->form_validation->set_rules('situacao', 	 	 	'situacao', 		'trim|required|xss_clean');
    	 
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function validarFormCopia() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idCliente', 	 	 			'idCliente', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('idParceiroDestino', 	 		'idParceiroDestino', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idModulo', 	 	 			'idModulo', 				'trim|required|xss_clean');
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function validarFormRemover() {
    
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idCliente', 	 	 			'idCliente', 				'trim|required|xss_clean');
    	$this->form_validation->set_rules('idModulo', 	 	 			'idModulo', 				'trim|required|xss_clean');
    
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }
    
    function validarFormModulo() {
    	
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idModuloCliente', 	'idModuloCliente', 	'trim|xss_clean');
    	$this->form_validation->set_rules('idCliente', 	 	 	'idCliente', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('nomeModulo', 	 	'nomeModulo', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('ordemVisualizacao',	'ordemVisualizacao','trim|xss_clean');
    	$this->form_validation->set_rules('situacao', 	 	 	'situacao', 		'trim|required|xss_clean');
    	
    	
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function getDadosFormFuncao() {
    	$dados = array(
    			'idModuloCliente'	=> $this->input->post('idModuloCliente'),
    			'idFuncao'			=> $this->input->post('idFuncao'),
    			'nome'				=> $this->input->post('nomeFuncao'),
    			'ordem'				=> $this->input->post('ordemVisualizacao'),
    			'situacao'			=> $this->input->post('situacao')
    	);
    	return $dados;
    }
    
    function getDadosFormModulo() {
    	$dados = array(
    		'idCliente'	=> $this->input->post('idCliente'),
    		'nome'		=> $this->input->post('nomeModulo'),
    		'ordem'		=> $this->input->post('ordemVisualizacao'),
    		'situacao'	=> $this->input->post('situacao')
    	);
    	return $dados;
    }
    
}