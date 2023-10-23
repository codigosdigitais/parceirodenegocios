<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class sis_usuario extends MY_Controller {
    
	private $flashData;

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            	redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('sis_usuario_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Usuários.');
           redirect(base_url());
        }
		
		$idEmpresa = $this->session->userdata['idEmpresa'];
		
		$where = "a.idEmpresa = " .$idEmpresa;
		if ($this->input->get('nome')) 		$where .= " and a.nome like '%".$this->input->get('nome')."%'";
		if ($this->input->get('tipo')) 			$where .= " and a.tipo = '".$this->input->get('tipo')."'";
		else if (!isset($_GET['tipo']))		$where .= " and a.tipo = 'Interno'";
		if ($this->input->get('vinculado')) $where .= " and b.nomefantasia like '%".$this->input->get('vinculado')."%'";
		if ($this->input->get('login')) 	$where .= " and a.login like '%".$this->input->get('login')."%'";
		
		if (!isset($_GET['situacao']) || $this->input->get('situacao')) 	$where .= " and a.situacao = 1";
		else								$where .= " and a.situacao = 0";
		
		$this->data['historico'] = $this->sis_usuario_model->carregarTodosUsuarios($where);
		
		$this->data['view'] = 'sis/sis_usuario_todos';
		$this->load->view('tema/topo',$this->data);
		
    }

    function usuario_editar(){
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Usuários.');
           redirect(base_url());
        }
    	 
    	$idUsuario = $this->uri->segment(3);
    	
    	$idEmpresa = $this->session->userdata['idEmpresa'];

    	$idFuncionario = null;
    	$idCliente = null;
    	 
    	$this->data['historico'] = false;
    	 
    	if ($idUsuario) {
    		$this->data['historico'] = $this->sis_usuario_model->carregarUsuario($idEmpresa, $idUsuario);
	
    		if ($this->data['historico']) {
    			$historico = $this->data['historico'];
    			$Usuario = array_shift($historico);
    			$idFuncionario = $Usuario->idFuncionario;
    			$idCliente = $Usuario->idCliente;
    		}
    	}
    	
    	$this->data['funcionarios'] = $this->sis_usuario_model->carregarTodosFuncionario($idEmpresa, $idFuncionario);
    	$this->data['clientes'] = $this->sis_usuario_model->carregarTodosClientes($idEmpresa, $idCliente);
    	$this->data['perfisDisponiveis'] = $this->sis_usuario_model->carregarPerfisDisponiveis($idEmpresa, $idUsuario);
    	$this->data['perfisVinculados'] = $this->sis_usuario_model->carregarPerfisFuncoesVinculados($idUsuario);
    	
    	$this->data['view'] = 'sis/sis_usuario_view';
    	$this->load->view('tema/topo',$this->data);
    
    }

    function remover_perfil() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Usuários.');
           redirect(base_url());
        }
        
    	$table = 'sis_usuario_perfil';
    	 
    	$idUsuario= $this->input->post('idUsuario');
    	$idUsuarioPerfil= $this->input->post('idUsuarioPerfil');
    	 
    	$result = false;
    	 
    	if ($idUsuarioPerfil != "") {
    		$this->logs_modelclass->registrar_log_antes_delete($table, 'idUsuarioPerfil', $idUsuarioPerfil, 'Usuário (remover perfil)');
    		
    		$where = array('idUsuarioPerfil' => $idUsuarioPerfil);
    		$result = $this->sis_usuario_model->removerRegistro($table, $where);
    		
    		if (!$result) $this->flashData = "Problemas ao remover registro.";
    		else $this->logs_modelclass->registrar_log_depois();
    	}
    	 
    	$flashDataType = ($result) ? "success" : "error";
    
    	if ($result) {
    		$this->flashData = "Registro removido com sucesso!";
    	}
    
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_usuario/usuario_editar/' . $idUsuario));
    	 
    }
    
    function remover_usuario() {
        if(!$this->permission->canDelete()){
           $this->session->set_flashdata('error','Você não tem permissão para remover Usuários.');
           redirect(base_url());
        }
        
    	$table = 'sis_usuario';
    	
    	$idUsuario= $this->input->post('idUsuario');
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
    	$result = false;
    	
    	if ($idUsuario != "") {
    		$this->logs_modelclass->registrar_log_antes_delete($table, 'idUsuario', $idUsuario, 'Usuário');
    		
	    	$where = array('idUsuario' => $idUsuario, 'idEmpresa' => $idEmpresa);
	    	$result = $this->sis_usuario_model->removerRegistro($table, $where);
	    	
	    	if (!$result) $this->flashData = "Problemas ao remover registro.";
	    	else $this->logs_modelclass->registrar_log_depois();
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	 
    	if ($result) {
    		$this->flashData = "Registro removido com sucesso!";
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	redirect(base_url($this->permission->getIdPerfilAtual().'/sis_usuario'));
    	
    }

    function gravar_perfil() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Usuários.');
           redirect(base_url());
        }
        
    	$table = 'sis_usuario_perfil';
    
    	$idUsuario = $this->input->post('idUsuario');
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	 
    	if ($this->validarFormPerfil()) {

    		$idUsuarioPerfil = $this->input->post('idUsuarioPerfil');
    
    		$dados = $this->getDadosFormPerfil();
    		
    		if ($idUsuarioPerfil == "") {
    			$idUsuarioPerfil = $this->sis_usuario_model->inserirDados($table, $dados);
    			$result = $idUsuarioPerfil;
    			
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idUsuarioPerfil', $idUsuarioPerfil, 'Usuário (perfil)');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idUsuarioPerfil', $idUsuarioPerfil, 'Usuário (perfil)');
    			
    			$where = array('idUsuarioPerfil' => $idUsuarioPerfil);
    			$result = $this->sis_usuario_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    		}
    	}
    	 
    	$flashDataType = ($result) ? "success" : "error";
    	 
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	 
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	 
    	$url = $this->permission->getIdPerfilAtual().'/sis_usuario/usuario_editar/' . $idUsuario;
    	redirect(base_url($url));
    }
    
    function gravar_usuario() {
    	$table = 'sis_usuario';

    	$idUsuario = $this->input->post('idUsuario');
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	

    	if($idUsuario == "" && !$this->permission->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir Usuários.');
    		redirect(base_url());
    	}
    	else if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para atualizar Usuários.');
           redirect(base_url());
        }
    	
    	if ($this->validarFormUsuario()) {
    		
    		$dados = $this->getDadosFormUsuario();
    		
    		if ($idUsuario == "") {
    			$idUsuario = $this->sis_usuario_model->inserirDados($table, $dados);
    			$result = $idUsuario;
    			
    			if (!$result) $this->flashData = "Problemas ao inserir registro.";
    			else $this->logs_modelclass->registrar_log_insert($table, 'idUsuario', $idUsuario, 'Usuário');
    		}
    		else {
    			$this->logs_modelclass->registrar_log_antes_update($table, 'idUsuario', $idUsuario, 'Usuário');
    			
    			$where = array('idUsuario' => $idUsuario);
    			$result = $this->sis_usuario_model->atualizarDados($table, $dados, $where);
    			
    			if (!$result) $this->flashData = "Problemas ao atualizar registro.";
    			else $this->logs_modelclass->registrar_log_depois();
    		}
    	}
    	
    	$flashDataType = ($result) ? "success" : "error";
    	
    	if ($result) {
    		$this->flashData = "Registro armazenado com sucesso!";
    	}
    	
    	$this->session->set_flashdata($flashDataType, $this->flashData);
    	
    	$url = $this->permission->getIdPerfilAtual().'/sis_usuario/usuario_editar/' . $idUsuario;
    	redirect(base_url($url));
    }

    function validarFormPerfil() {
    
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idUsuario', 			'idUsuario', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('idPerfil', 			'idPerfil',		 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('situacao',	 	 	'situacao', 		'trim|required|xss_clean');
    
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

    function validarFormUsuario() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idUsuario', 			'idUsuario', 		'trim|xss_clean');
    	$this->form_validation->set_rules('nome', 				'nome',			 	'trim|required|xss_clean');
    	$this->form_validation->set_rules('tipo',	 	 		'tipo', 			'trim|required|xss_clean');
    	$this->form_validation->set_rules('login',	 	 		'login', 			'trim|required|xss_clean|min_length[5]|max_length[60]');
    	$this->form_validation->set_rules('senha',	 	 		'senha', 			'trim|xss_clean|min_length[6]|max_length[20]|matches[conf_senha]|md5');
    	$this->form_validation->set_rules('conf_senha',	 	 	'conf_senha', 		'trim|xss_clean');
    	$this->form_validation->set_rules('idFuncionario', 	 	'idFuncionario',	'trim|xss_clean');
    	$this->form_validation->set_rules('idCliente',			'idCliente',		'trim|xss_clean');
    	$this->form_validation->set_rules('situacao', 	 	 	'situacao', 		'trim|required|xss_clean');

    	$stringForm = $this->input->post('login');
    	$stringPHP  = preg_replace('/[^A-Za-z0-9\_\-\.^\@]/', '', $stringForm);
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else if ($stringForm != $stringPHP) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário! Reveja campo Usuário/Login.</div>';
    		 
    		return false;
    	}
    	 
    	else return true;
    }

    function getDadosFormPerfil() {
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	 
    	$dados = array(
    			'idUsuario'			=> $this->input->post('idUsuario'),
    			'idPerfil'			=> $this->input->post('idPerfil'),
    			'situacao'			=> $this->input->post('situacao')
    	);
    	return $dados;
    }
    
    function getDadosFormUsuario() {
    	$idEmpresa = $this->session->userdata['idEmpresa'];
    	
    	$dados = array(
    			'idUsuario'			=> $this->input->post('idUsuario'),
    			'idEmpresa'			=> $idEmpresa,
    			'nome'				=> $this->input->post('nome'),
    			'login'				=> $this->input->post('login'),
    			'situacao'			=> $this->input->post('situacao')
    	);
    	$tipo			= $this->input->post('tipo');
    	$senha 			= $this->input->post('senha');
    	$idFuncionario 	= $this->input->post('idFuncionario');
    	$idCliente	 	= $this->input->post('idCliente');
    	
    	//Garante que usuário não consiga inserir tipo == SISAdmin
		if ($tipo == 'SISAdmin')
    		if ($this->session->userdata('tipo') != 'SISAdmin') $tipo = 'Interno';
    	
    	$dados = array_merge($dados, array('tipo' => $tipo));
    	//********************************************************
    	
    	if ($senha) 				$dados = array_merge($dados, array('senha' => $senha));
    	
    	if ($tipo == 'SISAdmin'){
    		if ($idCliente)		$dados = array_merge($dados, array('idCliente' => $idCliente));
    		else				$dados = array_merge($dados, array('idCliente' => null));
    		
    		if ($idFuncionario)	$dados = array_merge($dados, array('idFuncionario' => $idFuncionario));
    		else 				$dados = array_merge($dados, array('idFuncionario' => null));
    	}
    	else {
    		if ($idCliente)		$dados = array_merge($dados, array('idCliente' => $idCliente, 'idFuncionario' => null));
    		
    		if ($idFuncionario)	$dados = array_merge($dados, array('idFuncionario' => $idFuncionario, 'idCliente' => null));
    	}
    	
    	return $dados;
    }
}