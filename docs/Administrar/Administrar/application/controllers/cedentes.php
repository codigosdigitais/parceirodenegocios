<?php
class cedentes extends MY_Controller {
	
	function __construct() {
		
		parent::__construct ();
		
		if ((! $this->session->userdata ( 'session_id' )) || (! $this->session->userdata ( 'logado' ))) {
			redirect ( 'entrega/login' );
		}
		
		$this->load->helper ( array (
				'codegen_helper' 
		) );
		$this->load->model ( 'cedentes_model', '', TRUE );
		
		$this->data ['estados'] = $this->cedentes_model->ListaEstados ();
		$this->data ['parametroBanco'] = $this->cedentes_model->getParametroById ( 2 );
		$this->data ['parametroSetor'] = $this->cedentes_model->getParametroById ( 169 );
	}
	
	function index() {
		$this->gerenciar ();
	}
	
	function gerenciar() {
		if (! $this->permission->canSelect()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para visualizar cedentes.' );
		}
		$this->load->library ( 'table' );
		$this->load->library ( 'pagination' );
		
		$config ['base_url'] = base_url () . 'cedentes/gerenciar/';
		$config ['total_rows'] = $this->cedentes_model->count ( 'cedente' );
		$config ['per_page'] = 10;
		$config ['next_link'] = 'Próxima';
		$config ['prev_link'] = 'Anterior';
		$config ['full_tag_open'] = '<div class="pagination alternate"><ul>';
		$config ['full_tag_close'] = '</ul></div>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
		$config ['cur_tag_close'] = '</b></a></li>';
		$config ['prev_tag_open'] = '<li>';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		$config ['first_link'] = 'Primeira';
		$config ['last_link'] = 'Última';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		$this->pagination->initialize ( $config );
		
		$this->data ['results'] = $this->cedentes_model->get ( 'cedente', 'idCedente, razaosocial, cnpj, responsavel_telefone_ddd, responsavel_telefone, responsavel, situacao', '', $config ['per_page'], $this->uri->segment ( 4 ) );
		$this->data ['view'] = 'cedentes/cedentes';
		$this->load->view ( 'tema/topo', $this->data );
	}
	function adicionar() {
		if (! $this->permission->canInsert()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para adicionar cedentes.' );
			redirect ( base_url () );
		}
		
		$this->load->library ( 'form_validation' );
		$this->data ['custom_error'] = '';
		
		if ($this->form_validation->run ( 'cedentes' ) == false) {
			$this->data ['custom_error'] = (validation_errors () ? '<div class="form_error">' . validation_errors () . '</div>' : false);
		} else {
			
			// contatos administrativos
			$responsaveis_cadastro = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "resp") {
					$responsaveis_cadastro [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$responsaveis_cadastro_novo = array ();
			for($i = 0; $i < count ( $responsaveis_cadastro ['nome'] ); $i ++) {
				foreach ( $responsaveis_cadastro as $key => $val ) {
					$responsaveis_cadastro_novo [$i] [$key] = $responsaveis_cadastro [$key] [$i];
				}
			}
			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array (
					$_POST 
			);
			foreach ( $campos as $valor ) {
				$data = $valor;
			}
			
			$data ['idEmpresa'] = $this->session->userdata['idEmpresa'];
			
			$ultimo_id = $this->cedentes_model->cadastrando ( 'cedente', $data );
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert ( 'cedente', 'idCedente', $ultimo_id, 'Cedentes' );
			}
			
			for($i = 0; $i < count ( $responsaveis_cadastro_novo ); $i ++) {
				$responsaveis_cadastro_novo [$i] ['idCedente'] = $ultimo_id;
			}
			
			$ids = $this->cedentes_model->addBatch ( 'cedente_responsaveis', $responsaveis_cadastro_novo );
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'cedente_responsaveis', 'idCedenteResponsavel', json_encode($ids), 'Cedentes: Responsáveis' );
			}
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Cedente adicionado com sucesso!' );
				redirect ( base_url () . $this->permission->getIdPerfilAtual().'/cedentes/adicionar/' );
			} else {
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
			}
		}
		$this->data ['view'] = 'cedentes/adicionarCedente';
		$this->load->view ( 'tema/topo', $this->data );
	}
	function editar() {
		if (! $this->permission->canUpdate()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para editar cedentes.' );
			redirect ( base_url () );
		}
		
		$this->load->library ( 'form_validation' );
		$this->data ['custom_error'] = '';
		
		if ($this->form_validation->run ( 'cedentes' ) == false) {
			$this->data ['custom_error'] = (validation_errors () ? '<div class="form_error">' . validation_errors () . '</div>' : false);
		} else {
			
			// contatos administrativos
			$responsaveis_cadastro = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "resp") {
					$responsaveis_cadastro [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$responsaveis_cadastro_novo = array ();
			for($i = 0; $i < count ( $responsaveis_cadastro ['nome'] ); $i ++) {
				foreach ( $responsaveis_cadastro as $key => $val ) {
					$responsaveis_cadastro_novo [$i] [$key] = $responsaveis_cadastro [$key] [$i];
				}
			}
			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array (
					$_POST 
			);
			foreach ( $campos as $valor ) {
				$data = $valor;
			}
			
			$ultimo_id = $this->input->post ( 'idCedente' );
			for($i = 0; $i < count ( $responsaveis_cadastro_novo ); $i ++) {
				$responsaveis_cadastro_novo [$i] ['idCedente'] = $ultimo_id;
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'cedente_responsaveis', 'idCedente', $ultimo_id, 'Cedentes: Responsáveis (on edit)' );
			if ($this->cedentes_model->limpa_dados_anteriores ( $ultimo_id, 'cedente_responsaveis' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_update ( 'cedente', 'idCedente', $this->input->post ( 'idCedente' ), 'Cedentes' );
			if ($this->cedentes_model->edit ( 'cedente', $data, 'idCedente', $this->input->post ( 'idCedente' ) )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$ids = $this->cedentes_model->addBatch ( 'cedente_responsaveis', $responsaveis_cadastro_novo );
			
			if ($ids) {
				foreach ( $ids as $id ) {
					$this->logs_modelclass->registrar_log_insert ( 'cedente_responsaveis', 'idCedenteResponsavel', $id, 'Cedentes: Responsáveis' );
				}
			}
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Cedente editado com sucesso!' );
				redirect ( base_url () . $this->permission->getIdPerfilAtual().'/cedentes/editar/' . $this->input->post ( 'idCedente' ) );
			} else { 
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
			}
		}
		
		$this->data ['result'] = $this->cedentes_model->getById ( $this->uri->segment ( 4 ) );
		$this->data ['view'] = 'cedentes/adicionarCedente';
		$this->load->view ( 'tema/topo', $this->data );
	}
	public function visualizar() {
		if (! $this->permission->canSelect()) { die('tenho sim');
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para visualizar cedentes.' );
			redirect ( base_url () );
		}
		
		$this->data ['custom_error'] = '';
		$this->data ['result'] = $this->cedentes_model->getById ( $this->uri->segment ( 4 ) );
		$this->data ['view'] = 'cedentes/visualizar';
		$this->load->view ( 'tema/topo', $this->data );
	}
	public function excluir() {
		if (! $this->permission->canDelete()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para excluir cedentes.' );
			redirect ( base_url () );
		}
		
		$id = $this->input->post ( 'idCedente' );
		if ($id == null) {
			
			$this->session->set_flashdata ( 'error', 'Erro ao tentar excluir Cedente.' );
			redirect ( base_url () . $this->permission->getIdPerfilAtual().'/cedentes/' );
		}
		
		$this->logs_modelclass->registrar_log_antes_delete ( 'cedente', 'idCedente', $id, 'Cedentes e Responsáveis' );
		if ($this->cedentes_model->delete ( 'cedente', 'idCedente', $id )) {
			$this->logs_modelclass->registrar_log_depois ();
		}
		
		
		$this->session->set_flashdata ( 'success', 'Cedente excluido com sucesso!' );
		redirect ( base_url () . $this->permission->getIdPerfilAtual().'/cedentes/' );
	}
}

