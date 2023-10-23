<?php
# DOCUMENTOS EXTENDS CONTROLLER #
class Documentos extends MY_Controller {
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('documentos_model','',TRUE);
			$this->data['parametroDocumento'] = $this->documentos_model->getParametroById(1);
			$this->data['listaFuncionario'] = $this->documentos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
	}	
	
	function index(){
		$this->gerenciar();
	}

	# gerencia a pagina principal #
	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar documentos.');
           redirect(base_url());
        }
       	$this->data['view'] = 'documentos/documentos';
       	$this->load->view('tema/topo',$this->data);
    }
	
	# DOC GER CLIENTE #
    public function cliente(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/cliente/';
			$config['total_rows'] = $this->documentos_model->count('documento', 'idCliente', 'cliente', 'cliente');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/clientes';
		$this->data['results'] = $this->documentos_model->get('documento','idCliente','cliente','cliente',$config['per_page'],$this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }
	
	# DOC GER FORNECEDODR #
    public function fornecedor(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/fornecedor/';
			$config['total_rows'] = $this->documentos_model->count('documento','idFornecedor','fornecedor','fornecedor');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/fornecedores';
		$this->data['results'] = $this->documentos_model->get('documento','idFornecedor','fornecedor','fornecedor',$config['per_page'],$this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }
	
	# DOC GER CEDENTE #
    public function cedente(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/cedente/';
			$config['total_rows'] = $this->documentos_model->count('documento','idCedente','cedente','cedente');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/cedentes';
		$this->data['results'] = $this->documentos_model->get('documento','idCedente','cedente','cedente',$config['per_page'],$this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }
	
	# DOC GER CONTRATO #
    public function contrato(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/contrato/';
			$config['total_rows'] = $this->documentos_model->count('documento', 'idCliente', 'cliente', 'contrato');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/contratos';
		$this->data['results'] = $this->documentos_model->get('documento', 'idCliente', 'cliente', 'contrato', $config['per_page'],$this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }
	
	# DOC GER FUNCIONARIO #
    public function funcionario(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/funcionario/';
			$config['total_rows'] = $this->documentos_model->count('documento','idFuncionario','funcionario','funcionario');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/funcionarios';
		$this->data['results'] = $this->documentos_model->get('documento','idFuncionario','funcionario','funcionario',$config['per_page'], $this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }

	public function propaganda(){

		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
			redirect(base_url());
		}

		$this->data['view'] = 'documentos/cadastros/propaganda';
		$this->data['results'] = $this->documentos_model->get('documento',null,null,'propaganda',500, $this->uri->segment(4));
		$this->load->view('tema/topo',$this->data);
	}
	
	# DOC GER ATESTADO #
    public function atestado(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'documentos/atestado/';
			$config['total_rows'] = $this->documentos_model->count('documento','idFuncionario','funcionario','atestado');
			$config['per_page'] = 30;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config); 	
		#fecha paginacao
		
		
        $this->data['view'] = 'documentos/cadastros/atestados';
		$this->data['results'] = $this->documentos_model->get('documento','idFuncionario','funcionario','atestado',$config['per_page'], $this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }	
			
	

	# DOC ADD CLIENTE #
    public function clienteAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaCliente'] = $this->documentos_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/clientes/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'cliente',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
			
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Cliente' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

	}
	
	# DOC ADD CONTRATO #
    public function contratoAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaContrato'] = $this->documentos_model->getBaseContrato('contrato', 'idContrato', 'ASC');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/contratos/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'contrato',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
			
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Contrato' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/contrato');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarContrato';
        $this->load->view('tema/topo', $this->data);

	}
	
	# DOC ADD FORNECEDODR #
    public function fornecedorAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaFornecedor'] = $this->documentos_model->getBase('fornecedor', 'razaosocial', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/fornecedores/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'fornecedor',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
		
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Fornecedor' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/fornecedor');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarFornecedor';
        $this->load->view('tema/topo', $this->data);

	}
	
	# DOC ADD CEDENTE #
    public function cedenteAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaCedente'] = $this->documentos_model->getListaCedentesBase(null);
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/cedentes/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'cedente',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
		
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Cedente' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cedente');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarCedente';
        $this->load->view('tema/topo', $this->data);

	}

	# DOC ADD FUNCIONARIO #
    public function funcionarioAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaFuncionario'] = $this->documentos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/funcionarios/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '51200'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();

			if ( $this->upload->error_msg ) {
				$this->session->set_flashdata('error', 'Erro!<br>' . $this->upload->error_msg[0]);
				redirect(base_url() . $this->permission->getIdPerfilAtual() . '/documentos/funcionario');
				exit();
			}
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'funcionario',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
		
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Funcionário' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/funcionario');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarFuncionario';
        $this->load->view('tema/topo', $this->data);

	}


	public function adicionarPropaganda(){

		if(!$this->permission->canInsert()){
			$this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
			redirect(base_url());
		}

		$this->load->library('form_validation');
		$this->data['custom_error'] = '';

		if ($this->form_validation->run('documentos') == false) {
			$this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
		} else {

			#diretorio de upload
			$diretorio = 'assets/documentos/propaganda/'.date("Y-m-d");

			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}

			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs

			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			#faz upload
			$this->upload->do_upload();
			$arquivo = $this->upload->data();

			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];

			$data = date("Y-m-d", strtotime($this->input->post('data')));
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'propaganda',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);

			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Propaganda' );
				$this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/propaganda');
			} else {
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
			}


		}
		$this->data['view'] = 'documentos/cadastros/adicionarPropaganda';
		$this->load->view('tema/topo', $this->data);

	}

	# DOC ADD ATESTADO #
    public function atestadoAdicionar(){

        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['listaFuncionario'] = $this->documentos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#diretorio de upload
			$diretorio = 'assets/documentos/atestados/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d", strtotime($this->input->post('data')));
			$data = array(
				'nomearquivo' => $this->input->post('nomearquivo'),
				'idAdministrador' => $this->input->post('idAdministrador'),
				'idEmpresa' => $this->session->userdata['idEmpresa'],
				'modulo' => 'atestado',
				'arquivo' => $file,
				'diretorio' => $path,
				'url' => $url,
				'data' => $data,
				'tamanho' => $tamanho,
				'extensao' => $tipo
			);
		
			$id = $this->documentos_model->add('documento', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'documento', 'idDocumento', $id, 'Documentos: Atestado' );
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
               redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/atestado');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarAtestado';
        $this->load->view('tema/topo', $this->data);

	}	
	
	

	# DOC EDI CLIENTE #
	public function clienteEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaCliente'] = $this->documentos_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#diretorio de upload
			$diretorio = 'assets/documentos/clientes/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'cliente',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'cliente'
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Cliente' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

		
	}
	
	# DOC EDI CONTRATO #
	public function contratoEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaContrato'] = $this->documentos_model->getBaseContrato('contrato', 'idContrato', 'ASC');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#diretorio de upload
			$diretorio = 'assets/documentos/contratos/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'contrato',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'contrato'
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Contrato' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/contrato/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarContrato';
        $this->load->view('tema/topo', $this->data);
	}

	# DOC EDI FORNECEDODR #
	public function fornecedorEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaFornecedor'] = $this->documentos_model->getBase('fornecedor', 'razaosocial', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#diretorio de upload
			$diretorio = 'assets/documentos/fornecedores/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'fornecedor',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'fornecedor'
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Fornecedor' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/fornecedor/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarFornecedor';
        $this->load->view('tema/topo', $this->data);

		
	}
	
	# DOC EDI CEDENTE #
	public function cedenteEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaCedente'] = $this->documentos_model->getListaCedentesBase($this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#diretorio de upload
			$diretorio = 'assets/documentos/cedentes/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			
		
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'cedente',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'cedente'
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Cedente' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cedente/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarCedente';
        $this->load->view('tema/topo', $this->data);

		
	}
	
	# DOC EDI FUNCIONARIO #
	public function funcionarioEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaFuncionario'] = $this->documentos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
		//	echo "Não altere nada, em teste!";
		//	die();


			#diretorio de upload
			$diretorio = 'assets/documentos/funcionarios/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d");
			
		
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'funcionario',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'funcionario'
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Funcionário' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
                $this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/funcionario/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarFuncionario';
        $this->load->view('tema/topo', $this->data);

		
	}	
	
	
	# DOC EDI ATESTADO #
	public function atestadoEditar(){
		
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
           redirect(base_url());
        }

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->data['listaFuncionario'] = $this->documentos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('documentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#diretorio de upload
			$diretorio = 'assets/documentos/atestados/'.date("Y-m-d");
			
			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}
			
			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs
			
			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			#faz upload
			$this->upload->do_upload();	
			$arquivo = $this->upload->data();
			
			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];
	
			$data = date("Y-m-d", strtotime($this->input->post('data')));
			
		
			if($file!=""){ 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'atestado',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else { 
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'atestado',
					'data' => $data
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Atestado' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
                $this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Documento editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/atestado/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }

			
        }
        $this->data['view'] = 'documentos/cadastros/adicionarAtestado';
        $this->load->view('tema/topo', $this->data);

		
	}

	public function propagandaEditar(){

		if(!$this->permission->canInsert()){
			$this->session->set_flashdata('error','Você não tem permissão para adicionar documentos.');
			redirect(base_url());
		}

		$this->data['result'] = $this->documentos_model->getById($this->uri->segment(4));
		$this->load->library('form_validation');
		$this->data['custom_error'] = '';


		if ($this->form_validation->run('documentos') == false) {
			$this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
		} else {


			#diretorio de upload
			$diretorio = 'assets/documentos/propaganda/'.date("Y-m-d");

			if(!is_dir($diretorio)){
				mkdir($diretorio, 0777, TRUE);
				chmod($diretorio, 0777);
			}

			#configuracoes base
			$config['upload_path'] = $diretorio;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = '8192'; // 8Mbs

			#inicia a biblioteca
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			#faz upload
			$this->upload->do_upload();
			$arquivo = $this->upload->data();

			#dados do banco de dados
			$file = $arquivo['file_name'];
			$path = $arquivo['full_path'];
			$url = $diretorio.'/'.$file;
			$tamanho = $arquivo['file_size'];
			$tipo = $arquivo['file_ext'];

			$data = date("Y-m-d", strtotime($this->input->post('data')));


			if($file!=""){
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'propaganda',
					'arquivo' => $file,
					'diretorio' => $path,
					'url' => $url,
					'data' => $data,
					'tamanho' => $tamanho,
					'extensao' => $tipo
				);
			} else {
				$data = array(
					'nomearquivo' => $this->input->post('nomearquivo'),
					'idAdministrador' => $this->input->post('idAdministrador'),
					'modulo' => 'propaganda',
					'data' => $data
				);
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'documento', 'idDocumento', $this->input->post ( 'idDocumento' ), 'Documentos: Propaganda' );
			if($this->documentos_model->edit('documento', $data, 'idDocumento', $this->input->post('idDocumento')) == TRUE) {
				$this->logs_modelclass->registrar_log_depois ();
				$this->session->set_flashdata('success','Documento editado com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/propaganda/');
			} else {
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
			}


		}
		$this->data['view'] = 'documentos/cadastros/adicionarPropaganda';
		$this->load->view('tema/topo', $this->data);


	}

	# DOC DEL CLIENTE #
    public function clienteExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente');
    	}
		
    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Cliente' );
    	
    	$file = $this->documentos_model->getById($id);
    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente');
        }
    }
	
	# DOC DEL CONTRATO #
    public function contratoExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/contrato');
    	}

    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Contrato' );
    	
    	$file = $this->documentos_model->getById($id);
    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/contrato');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/contrato');
        }
    }
	
	# DOC DEL FORNECEDODR #
    public function fornecedorExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/fornecedor');
    	}
    	
    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Fornecedor' );
    	
    	$file = $this->documentos_model->getById($id);
    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/fornecedor');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/fornecedor');
        }
    }
	
	# DOC DEL CEDENTE #
    public function cedenteExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cedente');
    	}
    	
    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Cedente' );
    	 
    	$file = $this->documentos_model->getById($id);

    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}
        	
	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cedente');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cedente');
        }
    }
	
	# DOC DEL FUNCIONARIO #
    public function funcionarioExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/funcionario');
    	}
    	
    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Funcionário' );
    	 
    	$file = $this->documentos_model->getById($id);
    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/funcionario');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/funcionario');
        }
    }	
	
	# DOC DEL ATESTADO #
    public function atestadoExcluir(){
    	if(!$this->permission->canDelete()){
          $this->session->set_flashdata('error','Você não tem permissão para excluir este documento.');
          redirect(base_url());
        }

    	$id = $this->input->post('idDocumento');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/atestado');
    	}

    	$this->logs_modelclass->registrar_log_antes_delete ( 'documento', 'idDocumento', $id, 'Documentos: Atestado' );
    	 
    	$file = $this->documentos_model->getById($id);
    	$this->db->where('idDocumento', $id);
        if($this->db->delete('documento')){
        	$this->logs_modelclass->registrar_log_depois ();

        	if ($file && file_exists($file[0]->diretorio)) {
        		unlink($file[0]->diretorio);
        	}
        	
	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/atestado');
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/atestado');
        }
    }	
	
	
	
	# DOWNLOAD BASE #
    public function download($id = null){
    	
        /*if(!$this->permission->canSelect()){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar Documento.');
          redirect(base_url());
        }*/

	//	$file = $this->documentos_model->getById($id);
//		print_r($file);

//echo "pare!";
		//	die();


    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos/cliente');
    	}
		
		$this->data['view'] = 'documentos/cadastros/visualizar';
        $this->load->view('tema/topo', $this->data);	


    	$file = $this->documentos_model->getById($id);
    	$this->load->library('zip');
    	$path = $file[0]->diretorio;
		$this->zip->read_file($path); 
		$this->zip->download('file'.date('d-m-Y-H.i.s').'.zip');
    }


}

