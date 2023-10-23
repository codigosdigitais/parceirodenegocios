<?php
/*
 * @autor: Davi Siepmann
 * @date: 19/12/2015
 *
 */
include_once (dirname ( __FILE__ ) . "/global_functions_helper.php");
include_once (dirname ( __FILE__ ) . "/classes/CORS_HEADERS.php");
include_once (dirname ( __FILE__ ) . "/classes/FuncionarioExternoClass.php");
class funcionarioexterno extends MY_Controller {
	function __construct() {
		parent::__construct ();
		date_default_timezone_set ( 'America/Sao_Paulo' );
		
		$this->load->helper ( array (
				'codegen_helper' 
		) );
		$this->load->library ( 'form_validation' );
		$this->load->library ( 'session' );
		
		$this->load->model ( 'funcionario_model', '', TRUE );
		$this->load->model ( 'clienteexterno_model', '', TRUE );
		
		$this->data['estados'] = $this->funcionario_model->ListaEstados ();
		
	}
	
	/**
	 * Novo formulário solicitado pelo André em Março/2016
	 * 
	 * @author Davi Coradini
	 *         @date 21-03-2016
	 */
	public function novoformulario() {
		$clientId = $this->session->userdata ( 'idEmpresaWebsite' );
		
		if (!$clientId) {
			$clientKey = ($this->session->userdata ( 'clientKey') != "") ? $this->session->userdata ( 'clientKey' ) : $this->uri->segment ( 3 );
			$clientId = $this->clienteexterno_model->verifyClientKeyGetIdParaChamadaExterna ( $clientKey );
			
			if (!$clientId) {
				if ($this->session->userdata ( 'logado' )) {
					$clientId = $this->session->userdata ['idEmpresa'];
				}
			}
			
			$this->session->set_userdata ( 'idEmpresaWebsite', $clientId );
		}
		
		if (! $clientId) {
			die ( 'chave de acesso (integração) incorreta' );
		}
		else if ($this->uri->segment ( 3 ) != "") {
			redirect ( base_url () . 'funcionarioexterno/novoformulario');
		}
		$this->session->unset_userdata ( 'idFuncionarioExternoNovoTemp' );
		
		$this->registraSessaoCriaCors ();
		
		$this->load->view ( '/funcionario/externo/adicionar_novo', $this->data );
	}
	
	function adicionar() {
		
		$idEmpresa = $this->session->userdata ( 'idEmpresaWebsite' );
		
		// Carrega Biblioteca de Validação de Formulário
		$this->load->library ( 'form_validation' );
		$this->data ['custom_error'] = '';
		
		// Chega se tem ação de formulário
		if ($this->form_validation->run ( 'funcionario' ) == false) {
			$this->load->view ( 'funcionarioexterno/novoformulario' );
		} else {
			
			// blocobase - Novo Funcionario
			$funcionario_base = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocobase") {
					$funcionario_base [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_base_novo = array ();
			for($i = 0; $i < count ( $funcionario_base ['nome'] ); $i ++) {
				foreach ( $funcionario_base as $key => $val ) {
					$funcionario_base_novo [$key] = $funcionario_base [$key];
					$funcionario_base_novo ['idEmpresa'] = $idEmpresa;
				}
			}
			
			$imagem = $this->uploadImagemRemoveAntigaRetornaNomeArquivo ( null );
			if ($imagem)
				$funcionario_base_novo ['imagem_perfil'] = $imagem;
				
				// adiciona registro deste bloco
			$ultimo_id = $this->funcionario_model->cadastrando ( 'funcionario', $funcionario_base_novo );
			
			
			// blocodoc - Documentos
			$funcionario_blocodoc = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocodoc") {
					$funcionario_blocodoc [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
				
			$funcionario_blocodoc_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocodoc ['cpfnumero'] ); $i ++) {
				foreach ( $funcionario_blocodoc as $key => $val ) {
					$funcionario_blocodoc_novo [$key] = $funcionario_blocodoc [$key];
				}
			}
				
			$funcionario_blocodoc_novo ['idFuncionario'] = $ultimo_id;
			$id = $this->funcionario_model->cadastrando ( 'funcionario_documentos', $funcionario_blocodoc_novo );
				
			
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Funcionario adicionado com sucesso!' );
				$this->session->set_userdata ( 'idFuncionarioExternoNovoTemp', $ultimo_id );
				redirect ( base_url () . 'funcionarioexterno/editar/' . $ultimo_id );
			} else {
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
			}
			
			$this->load->view ( 'funcionarioexterno/novoformulario' );
		}
	}
	function editar() {
		
		$idFuncionario = $this->uri->segment ( 3 );
		
		if ($idFuncionario != $this->session->userdata ( 'idFuncionarioExternoNovoTemp' )) {
			$this->session->set_flashdata ( 'error', 'Não é possível acessar demais cadastros.' );
			redirect ( base_url ( 'funcionarioexterno/novoformulario') );
		}
		
		$this->load->library ( 'form_validation' );
		$this->data ['custom_error'] = '';
		
		if ($this->form_validation->run ( 'funcionario' ) == false) {
			$this->data ['custom_error'] = (validation_errors () ? '<div class="form_error">' . validation_errors () . '</div>' : false);
		} else {
			
			// blocobase - Novo Funcionario
			$funcionario_base = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocobase") {
					$funcionario_base [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_base_novo = array ();
			for($i = 0; $i < count ( $funcionario_base ['nome'] ); $i ++) {
				foreach ( $funcionario_base as $key => $val ) {
					$funcionario_base_novo [$key] = $funcionario_base [$key];
				}
			}
			
			$antiga = $this->funcionario_model->getImagemPerfilFuncionario ( $this->input->post ( 'idFuncionario' ) );
			
			if ($this->input->post ( 'remove_imagem' ))
				$this->removerImagem ( $antiga );
			else {
				$imagem = $this->uploadImagemRemoveAntigaRetornaNomeArquivo ( $antiga );
				if ($imagem)
					$funcionario_base_novo ['imagem_perfil'] = $imagem;
			}
			/**
			 */
			
			// adiciona registro deste bloco
			if ($this->funcionario_model->edit ( 'funcionario', $funcionario_base_novo, 'idFuncionario', $this->input->post ( 'idFuncionario' ) )) {
			}
			$ultimo_id = $this->input->post ( 'idFuncionario' );
			
			// deleta dados antigos
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_documentos' )) {
			}
			// blocodoc - Documentos
			$funcionario_blocodoc = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocodoc") {
					$funcionario_blocodoc [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
				
			$funcionario_blocodoc_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocodoc ['cpfnumero'] ); $i ++) {
				foreach ( $funcionario_blocodoc as $key => $val ) {
					$funcionario_blocodoc_novo [$key] = $funcionario_blocodoc [$key];
				}
			}
				
			$funcionario_blocodoc_novo ['idFuncionario'] = $ultimo_id;
			$ultimo_id_edit = $this->funcionario_model->cadastrando ( 'funcionario_documentos', $funcionario_blocodoc_novo );
				
			
			
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Funcionario editado com sucesso!' );
				redirect ( base_url () . '/funcionarioexterno/editar/' . $this->input->post ( 'idFuncionario' ) );
			} else {
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
			}
		}
		
		$this->data ['result'] = $this->funcionario_model->getById ( $this->uri->segment ( 3 ) );
		$this->load->view ( 'funcionario/externo/adicionar_novo', $this->data );
	}
	function removerImagem($imagem) {
		if (file_exists ( $imagem ))
			return unlink ( $imagem );
		
		else
			return false;
	}
	function uploadImagemRemoveAntigaRetornaNomeArquivo($antiga) {
		// diretorio de upload
		$diretorio = 'assets/funcionario/foto';
		
		if (! is_dir ( $diretorio )) {
			mkdir ( $diretorio, 0777, TRUE );
			chmod ( $diretorio, 0777 );
		}
		
		// configuracoes base
		$config ['upload_path'] = $diretorio;
		$config ['allowed_types'] = 'jpg|jpeg|png';
		$config ['remove_spaces'] = TRUE;
		$config ['encrypt_name'] = TRUE;
		$config ['max_size'] = '8192'; // 8Mbs
		                               
		// inicia a biblioteca
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		
		// faz upload
		$this->upload->do_upload ();
		$arquivo = $this->upload->data ();
		
		// dados do banco de dados
		$file = $arquivo ['file_name'];
		$path = $arquivo ['full_path'];
		$url = $diretorio . '/' . $file;
		
		if ($arquivo ['file_name'] != "") {
			$this->load->library ( 'image_lib' );
			$config ['image_library'] = 'gd2';
			$config ['source_image'] = $url;
			$config ['create_thumb'] = FALSE;
			$config ['maintain_ratio'] = TRUE;
			$config ['width'] = 300;
			$config ['height'] = 300;
			
			$this->image_lib->clear ();
			$this->image_lib->initialize ( $config );
			$this->image_lib->resize ();
			
			// remove imagem antiga caso faça upload da nova corretamente
			if (file_exists ( $antiga ))
				unlink ( $antiga );
			
			return $url;
		} else
			return false;
	}
	public function index() {
		if ((! $this->session->userdata ( 'session_id' )) || (! $this->session->userdata ( 'logado' )))
			redirect ( 'entrega/login' );
		
		$idEmpresa = $this->session->userdata ['idCliente'];
		
		$this->load->model ( 'funcionario_model', '', TRUE );
		
		$funcionario = new FuncionarioExternoClass ();
		$this->data ['results'] = $funcionario->getListaFuncionarios ( $idEmpresa );
		
		$this->data ['view'] = 'funcionario/externo/funcionarioexterno_view';
		$this->load->view ( '/tema/topo', $this->data );
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 26/12/2015
	 */
	public function copiarcadastro() {
		$funcionario = new FuncionarioExternoClass ();
		$funcionario->carregar ( $this->input->post ( 'id' ) );
		
		$idFuncionario = $funcionario->copiarCadastroParaFuncionario ();
		
		if ($idFuncionario)
			$resposta = array (
					'result' => 'success',
					'id' => $idFuncionario 
			);
		else
			$resposta = array (
					'result' => 'error' 
			);
		
		echo json_encode ( $resposta );
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 19/12/2015
	 */
	public function getboxfuncionario() {
		$clientKey = $this->uri->segment ( 3 );
		$clientId = $this->clienteexterno_model->verifyClientKeyGetIdParaChamadaExterna ( $clientKey );
		
		// setado na view
		// $this->session->set_userdata(array('idEmpresaWebsite' => $clientId));
		
		$this->registraSessaoCriaCors ();
		
		if ($clientId) {
			$this->data ['idEmpresaWebsite'] = $clientId;
			
			// temporário - testar layout
			$this->data ['layout'] = '1';
			$this->load->view ( '/funcionario/externo/funcionarioexterno', $this->data );
		} else {
			echo "A chave utilizada n�o pode ser verificada. Favor entrar em contato conosco. SYS_Integration(chamadaexterna)";
		}
	}
	private function registraSessaoCriaCors() {
		
		/*
		 * if ($this->input->post('clientKey')) {
		 * $clientId = $this->clienteexterno_model->verifyClientKeyGetIdParaChamadaExterna($this->input->post('clientKey'));
		 * $this->session->set_userdata(array('idEmpresaWebsite' => $clientId));
		 *
		 * $cors = new Cors_headers();
		 * $cors->_PRINT_CORS_HEADERS(NULL);
		 * }
		 * else {
		 */
		// $idEmpresaWebsite = $this->session->userdata('idEmpresaWebsite');
		$cors = new Cors_headers ();
		$cors->_PRINT_CORS_HEADERS ( NULL );
		// }
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 24/11/2015
	 */
	public function form_pre_cadastro() {
		$this->registraSessaoCriaCors ();
		
		$resposta = array ();
		
		if ($this->session->userdata ( 'idEmpresaWebsite' )) {
			
			if ($this->validarFormPreCadastro ()) {
				$funcionario = $this->popularPreCadastro ();
				
				$id_resposta = $funcionario->salvar ();
				
				if ($id_resposta) {
					$resposta = array (
							'resposta' => 'success' 
					);
				} else {
					
					if ($funcionario->getDb_error_number () == 1062)
						$erro = "Email ja cadastrado!";
					else
						$erro = "Favor entrar em contato conosco. " . $funcionario->getDb_error_number ();
					
					$resposta = array (
							'resposta' => 'error',
							'error' => $erro 
					);
				}
			} else {
				$resposta = array (
						'resposta' => 'error',
						'error' => 'Dados inconsistentes: ' . $this->validation_errors 
				);
			}
		} else {
			$resposta = array (
					'resposta' => 'error',
					'error' => 'Servico não disponivel. Por favor, tente recarregar a página!' 
			);
		}
		
		echo json_encode ( $resposta );
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 24/12/2015
	 */
	private function popularPreCadastro() {
		$funcionario = new FuncionarioExternoClass ();
		
		$idEmpresa = $this->session->userdata ( 'idEmpresaWebsite' );
		
		$funcionario->setIdEmpresa ( $idEmpresa );
		$funcionario->setNome ( $this->input->post ( 'nome' ) );
		$funcionario->setEmail ( $this->input->post ( 'email' ) );
		$funcionario->setSenha ( $this->input->post ( 'senha' ) );
		$funcionario->setTelefone ( $this->input->post ( 'telefone' ) );
		$funcionario->setCidade ( $this->input->post ( 'cidade' ) );
		$funcionario->setEstado ( $this->input->post ( 'estado' ) );
		$funcionario->setTemSmartphone ( $this->input->post ( 'temSmartphone' ) );
		$funcionario->setTipoSmartphone ( $this->input->post ( 'tipoSmartphone' ) );
		$funcionario->setTemBauInstalado ( $this->input->post ( 'temBauInstalado' ) );
		$funcionario->setTemMEI ( $this->input->post ( 'temMEI' ) );
		$funcionario->setTemPlacaVermelha ( $this->input->post ( 'temPlacaVermelha' ) );
		$funcionario->setTemCondumoto ( $this->input->post ( 'temCondumoto' ) );
		
		return $funcionario;
	}
	
	/*
	 * @autor: Davi Siepmann
	 * @date: 24/12/2015
	 */
	private function validarFormPreCadastro() {
		$this->load->library ( 'form_validation' );
		
		// regras para validação
		$this->form_validation->set_rules ( 'nome', 'Nome requerido', 'trim|required|xss_clean|min_length[5]|max_length[60]' );
		$this->form_validation->set_rules ( 'email', 'Email requerido', 'trim|required|xss_clean|min_length[6]|max_length[60]|valid_email' );
		$this->form_validation->set_rules ( 'senha', 'Senha requerida', 'trim|required|xss_clean|min_length[6]|max_length[60]|matches[senha_conf]|md5' );
		$this->form_validation->set_rules ( 'senha_conf', 'Conf Senha requerida', 'trim|required|xss_clean|min_length[6]|max_length[60]' );
		$this->form_validation->set_rules ( 'telefone', 'Telefone requerido', 'trim|required|xss_clean|min_length[14]|max_length[15]' );
		$this->form_validation->set_rules ( 'cidade', 'Cidade requerida', 'trim|required|xss_clean|min_length[6]|max_length[60]' );
		$this->form_validation->set_rules ( 'estado', 'Estado requerido', 'trim|required|xss_clean|min_length[2]|max_length[2]' );
		
		$this->form_validation->set_rules ( 'tipoSmartphone', 'Tipo Smartphone', 'trim|xss_clean|min_length[5]|max_length[11]' );
		$this->form_validation->set_rules ( 'temSmartphone', 'Tem Smartphone', 'trim|required|xss_clean|min_length[1]|max_length[1]' );
		$this->form_validation->set_rules ( 'temBauInstalado', 'Tem Bau', 'trim|required|xss_clean|min_length[1]|max_length[1]' );
		$this->form_validation->set_rules ( 'temMEI', 'Tem MEI', 'trim|required|xss_clean|min_length[1]|max_length[1]' );
		$this->form_validation->set_rules ( 'temPlacaVermelha', 'Tem Placa Vermelha', 'trim|required|xss_clean|min_length[1]|max_length[1]' );
		$this->form_validation->set_rules ( 'temCondumoto', 'Tem Condumoto', 'trim|required|xss_clean|min_length[1]|max_length[1]' );
		
		if ($this->form_validation->run () == false) {
			$this->validation_errors = validation_errors ();
			
			return false;
		} else {
			$idEmpresa = $this->session->userdata ( 'idEmpresaWebsite' );
			
			$funcionario = new FuncionarioExternoClass ();
			
			if ($funcionario->existeEmailFuncionarioCadastrado ( $this->input->post ( 'email' ), $idEmpresa )) {
				$this->validation_errors = "Email ja encontra-se cadastrado.";
				return false;
			}
		}
		
		return true;
	}
}