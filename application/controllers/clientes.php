<?php
class Clientes extends MY_Controller {
    
	private $flashData = "";
	private $urlBtnRetornar = 'clientes';
	
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            	redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
			$this->load->model('tabelafretecliente_model','',TRUE);
			$this->data['estados'] = $this->clientes_model->ListaEstados();
			$this->data['parametroFormaPagamento'] = $this->clientes_model->getParametroById(8);
			$this->data['parametroSetor'] = $this->clientes_model->getParametroById(169);
			$this->data['parametroNota'] = $this->clientes_model->getParametroById(12);
			
			$this->data['listaCedente'] = $this->clientes_model->getListaCedentesBase($this->uri->segment(4));
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Clientes.');
           redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'clientes/gerenciar/';
        $config['total_rows'] = $this->clientes_model->count('cliente');
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
        
	    $this->data['results'] = $this->clientes_model->get('cliente','idCliente, razaosocial, cnpj, responsavel_telefone_ddd, responsavel_telefone, responsavel, situacao','',$config['per_page'],$this->uri->segment(4));

	    //$this->data['results'] = $this->db->get('cliente')->result();
       	
       	$this->data['view'] = 'clientes/clientes';
       	$this->load->view('tema/topo',$this->data);
		
    }

	function meu_cadastro() {
		$this->setControllerMenu('clientes/meu_cadastro');

		if(!$this->permission->controllerManual('clientes/meu_cadastro')->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar seu cadastro.');
			redirect(base_url());
		}

		$idClienteExterno = $this->session->userdata['idAcessoExterno'];

		$this->data['result'] = $this->clientes_model->getById($idClienteExterno);
		$this->data['view'] = 'clientes/visualizar';
		$this->load->view('tema/topo', $this->data);
	}
    
    function novo_solicitante_ajax() {
    	$resposta['resposta'] = 'error';
    	
    	if(!$this->permission->canUpdate()){
    		$resposta['resposta'] = 'error';
    		$resposta['mensagem'] = 'Usuário não possui permissão para alterar cadastro de clientes';
    	}
    	
    	if ($this->validarFormNovoSolicitante()) {
    		$table = "cliente_responsaveis";
    		
    		$dados = $this->getDadosFormNovoSolicitante();
    		
    		$id = $this->clientes_model->add($table, $dados);
    		
    		if ($id) {
    			$this->logs_modelclass->registrar_log_insert($table, 'idClienteResponsavel', $id, 'Clientes Responsáveis (via Chamada)');
    			
    			$resposta['resposta'] = 'success';
    			$resposta['idClienteResponsavel'] = $id;
    			$resposta['nome'] = $this->input->post('resp_nome');
    		}
    		else {
    			$resposta['resposta'] = 'error';
    			$resposta['mensagem'] = 'Problemas ao inserir registro';
    		}
    		
    	}
    	else {
    		$resposta['resposta'] = 'error';
    		$resposta['mensagem'] = $this->flashData;
    	}
    	
    	
    	echo json_encode($resposta);
    }

    function getDadosFormNovoSolicitante() {
    	$dados = array(
    			'idCliente'			=> $this->input->post('idCliente'),
    			'nome'				=> $this->input->post('resp_nome'),
    			'telefoneddd'		=> $this->input->post('resp_telefoneddd'),
    			'telefone'			=> $this->input->post('resp_telefone'),
    			'telefoneddd2'		=> $this->input->post('resp_telefoneddd2'),
    			'telefone2'			=> $this->input->post('resp_telefone2'),
    			'setor'				=> $this->input->post('resp_setor'),
    			'email'				=> $this->input->post('resp_email'),
    			'confemail1'		=> $this->input->post('resp_confemail1'),
    			'confemail2'		=> $this->input->post('resp_confemail2'),
    			'confemail3'		=> $this->input->post('resp_confemail3'),
    			'confemail4'		=> $this->input->post('resp_confemail4')
    	);
    	return $dados;
    }

    function validarFormNovoSolicitante() {
    	 
    	$this->load->library('form_validation');
    	$this->data['custom_error'] = '';
    
    	$this->form_validation->set_rules('idCliente', 	 		'idCliente', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('resp_nome', 	 		'resp_nome', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('resp_telefoneddd', 	'resp_telefoneddd', 'trim|xss_clean');
    	$this->form_validation->set_rules('resp_telefone', 	 	'resp_telefone', 	'trim|xss_clean');
    	$this->form_validation->set_rules('resp_telefoneddd', 	'resp_telefoneddd', 'trim|xss_clean');
    	$this->form_validation->set_rules('resp_telefone2', 	'resp_telefone2', 	'trim|xss_clean');
    	$this->form_validation->set_rules('resp_setor', 	 	'resp_setor', 		'trim|xss_clean');
    	$this->form_validation->set_rules('resp_email', 	 	'resp_email', 		'trim|xss_clean');
    	$this->form_validation->set_rules('resp_confemail1', 	'resp_confemail1', 	'trim|xss_clean');
    	$this->form_validation->set_rules('resp_confemail2', 	'resp_confemail2', 	'trim|xss_clean');
    	$this->form_validation->set_rules('resp_confemail3', 	'resp_confemail3', 	'trim|xss_clean');
    	$this->form_validation->set_rules('resp_confemail4', 	'resp_confemail4', 	'trim|xss_clean');
    	 
    	if ($this->form_validation->run() == false) {
    		$this->flashData = '<div class="form_error">Problemas com o formulário!</div>'.validation_errors();
    		 
    		return false;
    	}
    	else return true;
    }

	function adicionarviaexterno() {

		$this->urlBtnRetornar = ($this->input->post('urlBtnRetornar')) ? $this->input->post('urlBtnRetornar') : $this->uri->segment(4);

		$this->adicionar();
	}

    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

		$this->data['urlBtnRetornar'] = ($this->input->post('urlBtnRetornar')) ? $this->input->post('urlBtnRetornar') : $this->urlBtnRetornar;
		unset($_POST['urlBtnRetornar']);

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			

			#contatos administrativos
			$responsaveis_cadastro = array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="resp"){
					$responsaveis_cadastro[$tmp[1]]=$val;
					unset($_POST[$key]);
				}
			}	
			
			$responsaveis_cadastro_novo = array();
			for($i=0;$i<count($responsaveis_cadastro['nome']);$i++){
				foreach($responsaveis_cadastro as $key=>$val){
					if (isset($responsaveis_cadastro[$key][$i]))
						$responsaveis_cadastro_novo[$i][$key] = $responsaveis_cadastro[$key][$i];
				}
			}	
			
			#cadastra cliente para buscar o ultimo id
			$campos = array($_POST);
			foreach($campos as $valor){
				//$data['nomefantasia'] = $this->input->post('nomefantasia'); 
				$data = $valor;
			}
			$idEmpresa = $this->session->userdata['idEmpresa'];

			$data['idEmpresa'] = $idEmpresa;

			$date = $this->input->post('data_ativo');
			if (stristr($date, "/")) {
				$date = explode('/', $date);
				$data['data_ativo'] = $date[2]."-".$date[1]."-".$date[0];
			}
			else $date = "";
			//$data['cnpj'] = $this->input->post('cnpj');
			
			$ultimo_id = $this->clientes_model->cadastrando('cliente', $data);
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert('cliente', 'idCliente', $ultimo_id, 'Clientes');
			}
			
			for($i=0;$i<count($responsaveis_cadastro_novo);$i++){
				$responsaveis_cadastro_novo[$i]['idCliente'] = $ultimo_id;
			}
			//var_dump($data); die();
			
			$ids = $this->clientes_model->addBatch('cliente_responsaveis', $responsaveis_cadastro_novo);
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'cliente_responsaveis', 'idClienteResponsavel', json_encode($ids), 'Clientes: Responsáveis' );
			}

			//como ainda não tem parametrização no sistema...
			//na NR todos novos clientes já recebem tabela de fretes
			if ($idEmpresa == 148) {
				$this->criaTabelaFreteInicial($ultimo_id);
			}

			
            if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success','Cliente adicionado com sucesso!');
				$this->session->set_flashdata('urlBtnRetornar', $this->urlBtnRetornar);
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/clientes/editar/' . $ultimo_id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

	function criaTabelaFreteInicial($idCliente) {
		$idEmpresa = $this->session->userdata['idEmpresa'];
		$idClienteFreteCopiar = $this->tabelafretecliente_model->getIdClienteFreteAtual($idEmpresa);

		$registroAntigo = $this->tabelafretecliente_model->carregar($idClienteFreteCopiar);

		$novoRegistro = array();
		foreach ($registroAntigo[0] as $key => $value) {
			if ($key != 'nomefantasia' && $key != 'idClienteFrete') {

				//pode ser copiada a tabela de um cliente para outro
				if ($key == 'idCliente' && $idCliente != null) {
					$novoRegistro = array_merge($novoRegistro, array('idCliente' => $idCliente));
				}
				else if ($key == 'vigencia_inicial' && $idCliente == null) {
					$novoRegistro = array_merge($novoRegistro, array('vigencia_inicial' => $registroAntigo[0]->vigencia_final));
				}
				else if ($key == 'vigencia_final') {
					$novoRegistro = array_merge($novoRegistro, array('vigencia_final' => null));
				}
				else {
					$novoRegistro = array_merge($novoRegistro, array($key => $value));
				}
			}
		}
		$id = $this->tabelafretecliente_model->inserirDados($novoRegistro);

		if ($id) if ($id) $this->logs_modelclass->registrar_log_insert ( 'cliente_frete', 'idClienteFrete', $id, 'Tabela Frete Cliente (auto)' );
	}

    function editar() {

    	#echo "<pre>";
    	#print_r($this->permission);
    	#die();
		
		/*
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }
        */

		if ($this->session->flashdata('urlBtnRetornar')) {
			$this->urlBtnRetornar = $this->session->flashdata('urlBtnRetornar');
			$this->data['urlBtnRetornar'] = $this->urlBtnRetornar;
		}
		else if ($this->input->post('urlBtnRetornar')) {
			$this->urlBtnRetornar = $this->input->post('urlBtnRetornar');
			$this->data['urlBtnRetornar'] =$this->urlBtnRetornar;
			unset($_POST['urlBtnRetornar']);
		}
		else {
			$this->data['urlBtnRetornar'] = $this->urlBtnRetornar;
		}


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			#contatos administrativos
			$responsaveis_cadastro = array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="resp"){
					$responsaveis_cadastro[$tmp[1]]=$val;
					unset($_POST[$key]);
				}
			}	
			
			$responsaveis_cadastro_novo = array();
			for($i=0;$i<count($responsaveis_cadastro['nome']);$i++){
				foreach($responsaveis_cadastro as $key=>$val){
					$responsaveis_cadastro_novo[$i][$key] = $responsaveis_cadastro[$key][$i];
				}
			}	
			

			#cadastra cliente para buscar o ultimo id
			$campos = array($_POST);
			foreach($campos as $valor){
// 				$data['nomefantasia'] = $this->input->post('nomefantasia'); 
				$data = $valor;
			}
			
	
			$date = $this->input->post('data_ativo');
			if (stristr($date, "/")) {
				$date = explode('/', $date);
				$data['data_ativo'] = $date[2]."-".$date[1]."-".$date[0];
			}
			else $date = "";
// 			$data['cnpj'] = $this->input->post('cnpj');
			
			$this->logs_modelclass->registrar_log_antes_update ( 'cliente', 'idCliente', $this->input->post ( 'idCliente' ), 'Clientes' );
			if ($this->clientes_model->edit('cliente', $data, 'idCliente', $this->input->post('idCliente')) ) {
				$this->logs_modelclass->registrar_log_depois();
			}
			
			$ultimo_id = $this->input->post('idCliente');
			
			$this->logs_modelclass->registrar_log_antes_delete ( 'cliente_responsaveis', 'idCliente', $ultimo_id, 'Clientes: Responsáveis (on edit)' );
			if ($this->clientes_model->limpa_dados_anteriores($ultimo_id, 'cliente_responsaveis')) {
				$this->logs_modelclass->registrar_log_depois();
			}
	
			for($i=0;$i<count($responsaveis_cadastro_novo);$i++){
				$responsaveis_cadastro_novo[$i]['idCliente'] = $ultimo_id;
			}
			
			$ids = $this->clientes_model->addBatch('cliente_responsaveis', $responsaveis_cadastro_novo);
			
			if ($ids) {
				foreach ( $ids as $id ) {
					$this->logs_modelclass->registrar_log_insert ( 'cliente_responsaveis', 'idCliente', $id, 'Clientes: Responsáveis' );
				}
			}

            if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success','Cliente editado com sucesso!');
				$this->session->set_flashdata('urlBtnRetornar', $this->urlBtnRetornar);
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/clientes/editar/'.$this->input->post('idCliente'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

		$this->data['listagem_cidade'] = $this->clientes_model->getRegistro('cidade', 'idEstado', $this->clientes_model->getRegistro('cliente', 'idCliente', $this->uri->segment(4), 'endereco_estado'), null);
		$this->data['listagem_bairro'] = $this->clientes_model->getRegistro('bairro', 'idBairro', $this->clientes_model->getRegistro('cliente', 'idCliente', $this->uri->segment(4), 'endereco_bairro'), null);
		
		$this->data['fat_listagem_cidade'] = $this->clientes_model->getRegistro('cidade', 'idEstado', $this->clientes_model->getRegistro('cliente', 'idCliente', $this->uri->segment(4), 'fat_endereco_estado'), null);
		$this->data['fat_listagem_bairro'] = $this->clientes_model->getRegistro('bairro', 'idBairro', $this->clientes_model->getRegistro('cliente', 'idCliente', $this->uri->segment(4), 'fat_endereco_bairro'), null);

        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(4));
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(4));
        $this->data['view'] = 'clientes/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir clientes.');
               redirect(base_url());
            }

            
            $id =  $this->input->post('idCliente');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/clientes/gerenciar/');
            }

            $this->db->where('idCliente', $id);
            $os = $this->db->get('cliente')->result();

            if($os != null){

                foreach ($os as $o) {
                    $this->db->where('idCliente', $o->idCliente);
                    $this->db->delete('cliente_responsaveis');
                }
            }
			
            $this->logs_modelclass->registrar_log_antes_delete ( 'cliente', 'idCliente', $id, 'Clientes e Responsáveis' );
            if ($this->clientes_model->delete('cliente','idCliente',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }

            $this->session->set_flashdata('success','Cliente excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/clientes/gerenciar/');
    }
	
	/* AJAX COMPONENTE FALTAS */
	function ajax($parametro, $cod){
	
	
			switch($parametro){
				case 'cidade':
				$this->db->where('idEstado', $cod);
				$this->db->order_by('cidade', 'ASC');
				$consulta = $this->db->get('cidade')->result();
				echo "<option value=''>Selecione uma Cidade</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idCidade."'>".$valor->cidade."</option>"; }		
				break;
				
				case 'bairro':
				$this->db->where('idCidade', $cod);
				$this->db->order_by('bairro', 'ASC');
				$consulta = $this->db->get('bairro')->result();
				echo "<option value=''>Selecione um Bairro</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idBairro."'>".$valor->bairro."</option>"; }		
				break;
				
			}
			
	}

}

