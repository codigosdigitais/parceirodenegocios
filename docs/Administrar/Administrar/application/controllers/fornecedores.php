<?php

include_once (dirname(__FILE__) . "/global_functions_helper.php");

class Fornecedores extends MY_Controller {

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            	redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('fornecedores_model','',TRUE);
            
			$this->data['parametroBanco'] = $this->fornecedores_model->getParametroById(2);
			$this->data['parametroSetor'] = $this->fornecedores_model->getParametroById(169);

	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		
        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Fornecedores.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'fornecedores/gerenciar/';
        $config['total_rows'] = $this->fornecedores_model->count('fornecedor');
        $config['per_page'] = 10;
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
        
	    $this->data['results'] = $this->fornecedores_model->get('fornecedor','idFornecedor, razaosocial, cnpj, responsavel_telefone_ddd, responsavel_telefone, responsavel, situacao','',$config['per_page'],$this->uri->segment(4));
       	
       	$this->data['view'] = 'fornecedores/fornecedores';
       	$this->load->view('tema/topo',$this->data);
    }
	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar Fornecedores.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        $result = false;

        if ($this->form_validation->run('fornecedores') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			/*
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			$data['idEmpresa'] = $this->session->userdata['idCliente'];
			
            if ($this->fornecedores_model->add('fornecedor', $data) == TRUE) {
                $this->session->set_flashdata('success','Fornecedor adicionado com sucesso!');
                redirect(base_url() . 'fornecedores/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }*/
			
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

			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$data['idEmpresa'] = $this->session->userdata['idEmpresa'];
			$ultimo_id = $this->fornecedores_model->cadastrando('fornecedor', $data);
			
			$result = $ultimo_id;
			
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert ( 'fornecedor', 'idFornecedor', $ultimo_id, 'Fornecedores' );
			}
			
			for($i=0;$i<count($responsaveis_cadastro_novo);$i++){ 
				$responsaveis_cadastro_novo[$i]['idFornecedor'] = $ultimo_id; 
			}
			
			$ids = $this->fornecedores_model->addBatch('fornecedor_responsaveis', $responsaveis_cadastro_novo);
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'fornecedor_responsaveis', 'idFornecedorResponsavel', json_encode($ids), 'Fornecedores: Responsáveis' );
			}
			
            if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success','Fornecedor adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/fornecedores/editar/' . $ultimo_id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

			
        }
        $this->data['view'] = 'fornecedores/adicionarFornecedor';
        	
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar Fornecedores.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('fornecedores') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
        	$data = array();
        	$responsaveis_cadastro = array();
        	
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			$i = 0;
			foreach($campos[0] as $key => $value){
				
				if ($key != 'idFornecedor' && !is_array($value)) {
					$data = array_merge($data, array($key => $value));
					unset($_POST[$key]);
				}
				
				else if (is_array($value)) {
					$tmp = explode("_",$key);

					$responsaveis_cadastro[$tmp[1]]=$value;
				}
				$i++;
			}

			//var_dump($responsaveis_cadastro); echo "<hr>";
			$arrValToIgnore = array();
			for($i=0;$i<count($responsaveis_cadastro['nome']);$i++){
				$responsaveis_cadastro_novo = array();
				
				foreach($responsaveis_cadastro as $key=>$val){
					if (isset($responsaveis_cadastro[$key][$i]) && $key != 'idFornecedorResponsavel')
						$responsaveis_cadastro_novo[$key] = $responsaveis_cadastro[$key][$i];
					
				}
				
				if (isset($responsaveis_cadastro['idFornecedorResponsavel'][$i]) && $responsaveis_cadastro['idFornecedorResponsavel'][$i] > 0) {
					$arrValToIgnore[] = $responsaveis_cadastro['idFornecedorResponsavel'][$i];
					$this->fornecedores_model->edit('fornecedor_responsaveis', $responsaveis_cadastro_novo, 'idFornecedorResponsavel', $responsaveis_cadastro['idFornecedorResponsavel'][$i]);
					
				}
				else {
					$id = $this->fornecedores_model->cadastrando('fornecedor_responsaveis', $responsaveis_cadastro_novo);
					$arrValToIgnore[] = $id;
				}
			}
			
			//Remove registros antigos que não vieram do form para editar
			$attrToIgnore = null;
			if (count($arrValToIgnore) > 0) { echo "entreiii";
				$attrToIgnore = 'idFornecedorResponsavel';
			}

			$where = array('idFornecedor' => $this->input->post ( 'idFornecedor' ));
			$this->fornecedores_model->deleteWhereNotIn('fornecedor_responsaveis', $attrToIgnore, $arrValToIgnore, $where);
			
					
			$this->logs_modelclass->registrar_log_antes_update ( 'fornecedor', 'idFornecedor', $this->input->post ( 'idFornecedor' ), 'Fornecedores' );
			
            if ($this->fornecedores_model->edit('fornecedor', $data, 'idFornecedor', $this->input->post('idFornecedor'))) {
            	$this->logs_modelclass->registrar_log_depois ();
            	
                $this->session->set_flashdata('success','Fornecedor editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/fornecedores/editar/'.$this->input->post('idFornecedor'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->fornecedores_model->getById($this->uri->segment(4));
        $this->data['view'] = 'fornecedores/adicionarFornecedor';
        $this->load->view('tema/topo', $this->data);
    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Fornecedores.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->fornecedores_model->getById($this->uri->segment(4));
        
        $this->data['view'] = 'fornecedores/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Fornecedores.');
               redirect(base_url());
            }
			
            $id =  $this->input->post('idfornecedor');
            
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Fornecedor.');            
                redirect(base_url(). $this->permission->getIdPerfilAtual().'/fornecedores/gerenciar/');
            }

            $this->logs_modelclass->registrar_log_antes_delete ( 'fornecedor', 'idFornecedor', $id, 'Fornecedores' );
            
            if ($this->fornecedores_model->delete('fornecedor','idFornecedor',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }
            
            $this->session->set_flashdata('success','fornecedor excluido com sucesso!');            
            redirect(base_url(). $this->permission->getIdPerfilAtual().'/fornecedores/gerenciar/');
    }
}