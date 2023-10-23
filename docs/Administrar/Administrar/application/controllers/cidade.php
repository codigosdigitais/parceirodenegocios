<?php

class Cidade extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('cidade_model','',TRUE);
			$this->data['estados'] = $this->cidade_model->ListaEstados();
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar cidade.');
           redirect(base_url());
        }
        
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'cidade/gerenciar/';
        $config['total_rows'] = $this->cidade_model->count('cidade');
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
        
	    $this->data['results'] = $this->cidade_model->get('cidade','idCidade, idEstado, idTipo, cidade','',$config['per_page'],$this->uri->segment(3));

       	$this->data['view'] = 'cidade/cidade';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar cidade.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
        if ($this->form_validation->run('cidades') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			$id = $this->cidade_model->add('cidade', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('cidade', 'idCidade', $id, 'Cidades');
                $this->session->set_flashdata('success','Cidade adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/cidade/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
		
        $this->data['view'] = 'cidade/adicionarCidade';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar cidade.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('cidades') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}

			$this->logs_modelclass->registrar_log_antes_update('cidade', 'idCidade', $this->input->post('idCidade'), 'Cidades');
            if ($this->cidade_model->edit('cidade', $data, 'idCidade', $this->input->post('idCidade')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Cidade editada com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/cidade/editar/'.$this->input->post('idCidade'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->cidade_model->getById($this->uri->segment(4));
        //$this->data['view'] = 'cidade/editarcidade';
		$this->data['view'] = 'cidade/adicionarCidade';
        $this->load->view('tema/topo', $this->data);

    }


    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Cidade.');
               redirect(base_url());
            }
            
            $id =  $this->input->post('idCidade');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Cidade.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/cidade/gerenciar/');
            }
            
            $this->logs_modelclass->registrar_log_antes_delete('cidade', 'idCidade', $id, 'Cidades');
            if ($this->cidade_model->delete('cidade','idCidade',$id)) {
            	$this->logs_modelclass->registrar_log_depois();
            }

            $this->session->set_flashdata('success','Cidade excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/cidade/gerenciar/');
    }
}

