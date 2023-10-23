<?php
include_once (dirname ( __FILE__ ) . "/global_functions_helper.php");
class Funcionario extends MY_Controller {
	function __construct() {
		parent::__construct ();
		if ((! $this->session->userdata ( 'session_id' )) || (! $this->session->userdata ( 'logado' ))) {
			redirect ( 'entrega/login' );
		}
		$this->load->helper ( array (
				'codegen_helper' 
		) );
		$this->load->model ( 'funcionario_model', '', TRUE );
		
		// campos usados no form
		$this->data ['parametroEscolaridade'] = $this->funcionario_model->getParametroById ( 5 );
		$this->data ['parametroEstadoCivil'] = $this->funcionario_model->getParametroById ( 6 );
		$this->data ['parametroCNHCategoria'] = $this->funcionario_model->getParametroById ( 3 );
		$this->data ['parametroCertidaoTipo'] = $this->funcionario_model->getParametroById ( 43 );
		$this->data ['parametroContratoTipo'] = $this->funcionario_model->getParametroById ( 16 );
		
		#echo "<pre>";
		$this->data ['parametroFuncao'] = $this->funcionario_model->getParametroById ( 969 );
		#echo $this->db->last_query();
		#print_r($this->data);
		#die();

		
		$this->data ['parametroSalario'] = $this->funcionario_model->getParametroById ( 44 );
		$this->data ['parametroBanco'] = $this->funcionario_model->getParametroById ( 2 );
		$this->data ['parametroVeiculoMarca'] = $this->funcionario_model->getParametroById ( 17 );
		$this->data ['parametroVeiculoSituacao'] = $this->funcionario_model->getParametroById ( 15 );
		$this->data ['parametroMateriaisTrabalho'] = $this->funcionario_model->getParametroById ( 10 );
		$this->data ['estados'] = $this->funcionario_model->ListaEstados ();
		$this->data ['listaCliente'] = $this->funcionario_model->getBase ( 'cliente', 'razaosocial', 'ASC' );
		$this->data ['listaCedente'] = $this->funcionario_model->getListaCedentesBase ( $this->uri->segment ( 3 ) );
		
	}
	function index() {
		$this->gerenciar ();
	}
	function gerenciar() {
		if (! $this->permission->canSelect ()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para visualizar funcionario.' );
			redirect ( base_url () );
		}
		
		$this->data ['results'] = $this->funcionario_model->getListaFuncionario(1);
		$this->data ['results_inativo'] = $this->funcionario_model->getListaFuncionario(0);
		
		$this->data ['view'] = 'funcionario/funcionario';
		$this->load->view ( 'tema/topo', $this->data );
	}
	
	// Adicionar Funcionário
	function adicionar() {
		
		// Checar Permissões
		if (! $this->permission->canInsert ()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para adicionar funcionario.' );
			redirect ( base_url () );
		}
		
		// Carrega Biblioteca de Validação de Formulário
		$this->load->library ( 'form_validation' );
		$this->data ['custom_error'] = '';
		
		// Chega se tem ação de formulário
		if ($this->form_validation->run ( 'funcionario' ) == false) {
			$this->data ['view'] = 'funcionario/adicionarFuncionario';
			$this->load->view ( 'tema/topo', $this->data );
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
					$funcionario_base_novo ['idEmpresa'] = $this->session->userdata ['idEmpresa'];
				}
			}

			/**
			 * Imagem do profissional
			 *
			 * @author Davi Coradini
			 *         @date 21-03-2016
			 * @var unknown
			 */
			$imagem = $this->uploadImagemRemoveAntigaRetornaNomeArquivo ( null );
			if ($imagem)
				$funcionario_base_novo ['imagem_perfil'] = $imagem;
			/**
			 */
					
			
			// adiciona registro deste bloco
			$ultimo_id = $this->funcionario_model->cadastrando ( 'funcionario', $funcionario_base_novo );
			
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario', 'idFuncionario', $ultimo_id, 'Funcionários' );
			}
			
			// blocobaseFECHA
			
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
			
			if ($id) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_documentos', 'idFuncionarioDocumento', $id, 'Funcionários: Documentos' );
			}
			
			// blococon - Dados do Contrato
			$funcionario_blococon = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blococon") {
					$funcionario_blococon [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blococon_novo = array ();
			for($i = 0; $i < count ( $funcionario_blococon ['tipocontrato'] ); $i ++) {
				foreach ( $funcionario_blococon as $key => $val ) {
					$funcionario_blococon_novo [$key] = $funcionario_blococon [$key];
					$funcionario_blococon_novo ['idFuncionario'] = $ultimo_id;
				}
			}
			
			$id = $this->funcionario_model->cadastrando ( 'funcionario_dadosregistro', $funcionario_blococon_novo );
			
			if ($id) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_dadosregistro', 'idFuncionarioDadosContrato', $id, 'Funcionários: Registro' );
			}
			
			// bloco - Remuneração
			$funcionario_blocorem = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocorem") {
					$funcionario_blocorem [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blocorem_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocorem ['salario'] ); $i ++) {
				foreach ( $funcionario_blocorem as $key => $val ) {
					$funcionario_blocorem_novo [$key] = $funcionario_blocorem [$key];
				}
			}
			
			$funcionario_blocorem_novo ['idFuncionario'] = $ultimo_id;
			$id = $this->funcionario_model->cadastrando ( 'funcionario_remuneracao', $funcionario_blocorem_novo );
			
			if ($id) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_remuneracao', 'idFuncionarioRemuneracao', $id, 'Funcionários: Remuneração' );
			}
			
			// bloco - dados do contrato blocodcon
			$funcionario_blocodcon = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocodcon") {
					$funcionario_blocodcon [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blocodcon_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocodcon ['localtrabalho'] ); $i ++) {
				foreach ( $funcionario_blocodcon as $key => $val ) {
					
					$funcionario_blocodcon_novo [$i] [$key] = $funcionario_blocodcon [$key] [$i];
					$funcionario_blocodcon_novo [$i] ['idFuncionario'] = $ultimo_id;
				}
			}
			
			$ids = $this->funcionario_model->add_batch ( 'funcionario_dadoscontrato', $funcionario_blocodcon_novo );
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_dadoscontrato', 'idFuncionarioDadosContrato', json_encode ( $ids ), 'Funcionários: Contrato' );
			}
			
			// bloco - Dados do Veículo
			$funcionario_veiculo = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "veiculos") {
					$funcionario_veiculo [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_veiculo_novo = array ();
			for($i = 0; $i < count ( $funcionario_veiculo ['marca'] ); $i ++) {
				foreach ( $funcionario_veiculo as $key => $val ) {
					if ($funcionario_veiculo ['marca'] [$i] == "0") {
						unset ( $funcionario_veiculo [$i] );
					} else {
						$funcionario_veiculo_novo [$i] [$key] = $funcionario_veiculo [$key] [$i];
						$funcionario_veiculo_novo [$i] ['idFuncionario'] = $ultimo_id;
					}
				}
			}
			
			$ids = $this->funcionario_model->add_batch ( 'funcionario_veiculo', $funcionario_veiculo_novo );
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_veiculo', 'idFuncionarioVeiculo', json_encode ( $ids ), 'Funcionários: Veículo' );
			}
			
			// bloco - Materiais de Trabalho
			$funcionario_materiais = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "materiais") {
					$funcionario_materiais [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_materiais_novo = array ();
			for($i = 0; $i < count ( $funcionario_materiais ['material'] ); $i ++) {
				foreach ( $funcionario_materiais as $key => $val ) {
					
					if ($funcionario_materiais ['quantidade'] [$i] == "0") {
						unset ( $funcionario_materiais [$i] );
					} else {
						$funcionario_materiais_novo [$i] [$key] = $funcionario_materiais [$key] [$i];
						$funcionario_materiais_novo [$i] ['idFuncionario'] = $ultimo_id;
					}
				}
			}
			$ids = $this->funcionario_model->add_batch ( 'funcionario_materiais', $funcionario_materiais_novo );
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_materiais', 'idFuncionarioMaterial', json_encode ( $ids ), 'Funcionários: Material' );
			}
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Funcionario adicionado com sucesso!' );
				redirect ( base_url () . $this->permission->getIdPerfilAtual () . '/funcionario/editar/' . $ultimo_id );
			} else {
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
			}
			$this->data ['view'] = 'funcionario/adicionarFuncionario';
			$this->load->view ( 'tema/topo', $this->data );
		}
	}
	
	function editar() {
		if (! $this->permission->canUpdate ()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para editar funcionario.' );
			redirect ( base_url () );
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
			
			/**
			 * Imagem do profissional
			 *
			 * @author Davi Coradini
			 *         @date 21-03-2016
			 * @var unknown
			 */
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
			$this->logs_modelclass->registrar_log_antes_update ( 'funcionario', 'idFuncionario', $this->input->post ( 'idFuncionario' ), 'Funcionário' );
			
			if ($this->funcionario_model->edit ( 'funcionario', $funcionario_base_novo, 'idFuncionario', $this->input->post ( 'idFuncionario' ) )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			$ultimo_id = $this->input->post ( 'idFuncionario' );
			
			// blocobaseFECHA
			
			// deleta dados antigos
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_documentos', 'idFuncionario', $ultimo_id, 'Funcionário: Documentos (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_documentos' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_dadosregistro', 'idFuncionario', $ultimo_id, 'Funcionário: Registro (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_dadosregistro' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_dadoscontrato', 'idFuncionario', $ultimo_id, 'Funcionário: Contrato (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_dadoscontrato' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_remuneracao', 'idFuncionario', $ultimo_id, 'Funcionário: Remuneração (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_remuneracao' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_veiculo', 'idFuncionario', $ultimo_id, 'Funcionário: Veículo (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_veiculo' )) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario_materiais', 'idFuncionario', $ultimo_id, 'Funcionário: Materiais (on edit)' );
			if ($this->funcionario_model->limpa_dados_anteriores ( $ultimo_id, 'funcionario_materiais' )) {
				$this->logs_modelclass->registrar_log_depois ();
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
			
			if ($ultimo_id_edit) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_documentos', 'idFuncionarioDocumento', $ultimo_id_edit, 'Funcionários: Documentos (on edit)' );
			}
			
			// blococon - Dados do Contrato
			$funcionario_blococon = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blococon") {
					$funcionario_blococon [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blococon_novo = array ();
			for($i = 0; $i < count ( $funcionario_blococon ['tipocontrato'] ); $i ++) {
				foreach ( $funcionario_blococon as $key => $val ) {
					$funcionario_blococon_novo [$key] = $funcionario_blococon [$key];
					$funcionario_blococon_novo ['idFuncionario'] = $ultimo_id;
				}
			}
			
			$ultimo_id_edit = $this->funcionario_model->cadastrando ( 'funcionario_dadosregistro', $funcionario_blococon_novo );
			
			if ($ultimo_id_edit) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_dadosregistro', 'idFuncionarioDadosContrato', $ultimo_id_edit, 'Funcionários: Registro (on edit)' );
			}
			
			// bloco - dados do contrato blocodcon
			$funcionario_blocodcon = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocodcon") {
					$funcionario_blocodcon [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blocodcon_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocodcon ['localtrabalho'] ); $i ++) {
				foreach ( $funcionario_blocodcon as $key => $val ) {
					
					$funcionario_blocodcon_novo [$i] [$key] = $funcionario_blocodcon [$key] [$i];
					$funcionario_blocodcon_novo [$i] ['idFuncionario'] = $this->input->post ( 'idFuncionario' );
				}
			}
			
			$ids = $this->funcionario_model->add_batch ( 'funcionario_dadoscontrato', $funcionario_blocodcon_novo );
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_dadoscontrato', 'idFuncionarioDadosContrato', json_encode ( $ids ), 'Funcionários: Contrato (on edit)' );
			}
			
			// bloco - Remuneração
			$funcionario_blocorem = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "blocorem") {
					$funcionario_blocorem [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_blocorem_novo = array ();
			for($i = 0; $i < count ( $funcionario_blocorem ['salario'] ); $i ++) {
				foreach ( $funcionario_blocorem as $key => $val ) {
					$funcionario_blocorem_novo [$key] = $funcionario_blocorem [$key];
				}
			}
			
			$funcionario_blocorem_novo ['idFuncionario'] = $ultimo_id;
			$ultimo_id_edit = $this->funcionario_model->cadastrando ( 'funcionario_remuneracao', $funcionario_blocorem_novo );
			
			if ($ultimo_id_edit) {
				$this->logs_modelclass->registrar_log_insert ( 'funcionario_remuneracao', 'idFuncionarioRemuneracao', $ultimo_id_edit, 'Funcionários: Remuneração (on edit)' );
			}
			
			// bloco - Dados do Veículo
			$funcionario_veiculo = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "veiculos") {
					$funcionario_veiculo [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_veiculo_novo = array ();
			for($i = 0; $i < count ( $funcionario_veiculo ['marca'] ); $i ++) {
				foreach ( $funcionario_veiculo as $key => $val ) {
					if ($funcionario_veiculo ['marca'] [$i] == "0") {
						unset ( $funcionario_veiculo [$i] );
					} else {
						$funcionario_veiculo_novo [$i] [$key] = $funcionario_veiculo [$key] [$i];
						$funcionario_veiculo_novo [$i] ['idFuncionario'] = $ultimo_id;
					}
				}
			}
			
			if (count ( $funcionario_veiculo_novo ) > 0) {
				$ids = $this->funcionario_model->add_batch ( 'funcionario_veiculo', $funcionario_veiculo_novo );
				
				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'funcionario_veiculo', 'idFuncionarioVeiculo', json_encode ( $ids ), 'Funcionários: Veículo (on edit)' );
				}
			}
			
			// bloco - Materiais de Trabalho
			$funcionario_materiais = array ();
			foreach ( $_POST as $key => $val ) {
				$tmp = explode ( "_", $key );
				if ($tmp [0] == "materiais") {
					$funcionario_materiais [$tmp [1]] = $val;
					unset ( $_POST [$key] );
				}
			}
			
			$funcionario_materiais_novo = array ();
			for($i = 0; $i < count ( $funcionario_materiais ['material'] ); $i ++) {
				foreach ( $funcionario_materiais as $key => $val ) {
					
					if ($funcionario_materiais ['quantidade'] [$i] == "0") {
						unset ( $funcionario_materiais [$i] );
					} else {
						$funcionario_materiais_novo [$i] [$key] = $funcionario_materiais [$key] [$i];
						$funcionario_materiais_novo [$i] ['idFuncionario'] = $ultimo_id;
					}
				}
			}
			
			if (count ( $funcionario_materiais_novo ) > 0) {
				$ids = $this->funcionario_model->add_batch ( 'funcionario_materiais', $funcionario_materiais_novo );
				
				if ($ids) {
					$this->logs_modelclass->registrar_log_insert ( 'funcionario_materiais', 'idFuncionarioMaterial', json_encode ( $ids ), 'Funcionários: Material (on edit)' );
				}
			}
			
			if ($ultimo_id == TRUE) {
				$this->session->set_flashdata ( 'success', 'Funcionario editado com sucesso!' );
				redirect ( base_url () . $this->permission->getIdPerfilAtual () . '/funcionario/editar/' . $this->input->post ( 'idFuncionario' ) );
			} else {
				$this->data ['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
			}
		}
		
		$this->data ['result'] = $this->funcionario_model->getById ( $this->uri->segment ( 3 ) );
		$this->data ['view'] = 'funcionario/adicionarFuncionario';
		$this->load->view ( 'tema/topo', $this->data );
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
	
	public function visualizar() {
		if (! $this->permission->canSelect ()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para visualizar funcionario.' );
			redirect ( base_url () );
		}
		
		$this->data ['custom_error'] = '';
		$this->data ['result'] = $this->funcionario_model->getByIdVisualizar ( $this->uri->segment ( 3 ) );
		
		$this->data ['view'] = "funcionario/visualizar";
		
		$this->load->view ( 'tema/topo', $this->data );
	}
	public function excluir() {
		if (! $this->permission->canDelete ()) {
			$this->session->set_flashdata ( 'error', 'Você não tem permissão para excluir funcionario.' );
			redirect ( base_url () );
		}
		
		$id = $this->input->post ( 'idFuncionario' );
		if ($id == null) {
			$this->session->set_flashdata ( 'error', 'Erro ao tentar excluir Funcionario.' );
			redirect ( base_url () . $this->permission->getIdPerfilAtual () . '/funcionario/gerenciar/' );
		}
		
		$this->db->where ( 'idFuncionario', $id );
		
		$antiga = $this->funcionario_model->getImagemPerfilFuncionario ( $id );
		$this->logs_modelclass->registrar_log_antes_delete ( 'funcionario', 'idFuncionario', $id, 'Funcionário' );
		
		if ($this->funcionario_model->delete ( 'funcionario', 'idFuncionario', $id )) {
			$this->logs_modelclass->registrar_log_depois ();

			$this->removerImagem ( $antiga );
		}
		
		$this->session->set_flashdata ( 'success', 'Funcionario excluido com sucesso!' );
		redirect ( base_url () . $this->permission->getIdPerfilAtual () . '/funcionario/gerenciar/' );
	}
}

