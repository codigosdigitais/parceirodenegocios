<?php
class Substituicoes extends MY_Controller {

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            	redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('substituicoes_model','',TRUE);
			$this->data['listaCliente'] = $this->substituicoes_model->getClienteContrato($this->uri->segment(3));
			$this->data['listaFuncionario'] = $this->substituicoes_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(3));
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar substituicoes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'substituicoes/gerenciar/';
        $config['total_rows'] = $this->substituicoes_model->count('substituicao');
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
        
        $pag = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
	    $this->data['results'] = $this->substituicoes_model->get('substituicao','idsubstituicao, idCliente','',$config['per_page'],$pag);
       	
       	$this->data['view'] = 'substituicoes/substituicoes';
       	$this->load->view('tema/topo',$this->data);
    }
	
    function adicionar() {
    	if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar Substuição.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('substituicoes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
	
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}

			#define campos
			$id = $this->substituicoes_model->cadastrando('substituicao', $data);
			if ( $id ) {
				$this->logs_modelclass->registrar_log_insert ( 'substituicao', 'idSubstituicao', $id, 'Substituições' );
				$this->session->set_flashdata('success','Substuição adicionada com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/substituicoes/editar/' . $id);
			} else {
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
			}
        }
        $this->data['view'] = 'substituicoes/adicionarSubstituicao';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
		
		
    	if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar Substuição.');
           redirect(base_url());
        }
		
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('substituicoes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'substituicao', 'idSubstituicao', $this->input->post ( 'idSubstituicao' ), 'Substituições' );
            if ($this->substituicoes_model->edit('substituicao', $data, 'idSubstituicao', $this->input->post('idSubstituicao')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Substuição editada com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/substituicoes/editar/'.$this->input->post ( 'idSubstituicao' ));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->substituicoes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'substituicoes/adicionarSubstituicao';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

    	if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar substituicoes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->substituicoes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'substituicoes/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

    		if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Substuição.');
               redirect(base_url());
            }

            $id =  $this->input->post('idSubstituicao');
			
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Substuição.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/substituicoes/');
            }

            $this->logs_modelclass->registrar_log_antes_delete ( 'substituicao', 'idSubstituicao', $id, 'Substituições' );
            if ($this->substituicoes_model->delete('substituicao','idSubstituicao',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }
            $this->session->set_flashdata('success','Substituição excluída com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/substituicoes/');
    }
	
	# Ajax para listagem de funcionários pertinentes a aquele cliente
	public function ajax($parametro, $cod){
		
			switch($parametro){
				case 'funcionario':
				$this->db->select('contrato_funcionario.*, funcionario.nome');
				$this->db->where('contrato_funcionario.idContrato', $cod);
				$this->db->join("funcionario", "funcionario.idFuncionario=contrato_funcionario.idFuncionario", "LEFT");
				$consulta = $this->db->get('contrato_funcionario')->result();
				echo "<option value=''>Selecione um Funcionário</option>";	
				foreach($consulta as $valor){ echo "<option>".$valor->nome."</option>"; }		
				break;
				
				case 'solicitante':
				$this->db->where('idCliente', $cod);
				$consulta = $this->db->get('cliente_responsaveis')->result();
				echo "<option value=''>Selecione um Responsável</option>";	
				foreach($consulta as $valor){ echo "<option value='".$valor->idClienteResponsavel."'>".$valor->nome."</option>"; }		
				break;
			}
			
	}
}

