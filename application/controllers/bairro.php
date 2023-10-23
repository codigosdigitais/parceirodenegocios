<?php

class Bairro extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('bairro_model','',TRUE);
			$this->data['cidades'] = $this->bairro_model->getCidades();
			$this->data['menuConfiguracoes'] = 'Bairro';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar bairro.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'bairro/gerenciar/';
        $config['total_rows'] = $this->bairro_model->count('bairro');
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
        
	    $this->data['results'] = $this->bairro_model->get('bairro','idBairro, idCidade, idTipo, bairro','',$config['per_page'],$this->uri->segment(3));

       	$this->data['view'] = 'bairro/bairro';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar bairro.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
        if ($this->form_validation->run('bairros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			$id = $this->bairro_model->add('bairro', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('bairro', 'idBairro', $id, 'Bairros');
                $this->session->set_flashdata('success','Bairro adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/bairro/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
		
        $this->data['view'] = 'bairro/adicionarBairro';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar bairro.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('bairros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}

			$this->logs_modelclass->registrar_log_antes_update('bairro', 'idBairro', $this->input->post('idBairro'), 'Bairros');
            if ($this->bairro_model->edit('bairro', $data, 'idBairro', $this->input->post('idBairro')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Bairro editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/bairro/editar/'.$this->input->post('idBairro'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->bairro_model->getById($this->uri->segment(3));
        //$this->data['view'] = 'bairro/editarbairro';
		$this->data['view'] = 'bairro/adicionarBairro';
        $this->load->view('tema/topo', $this->data);

    }


    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir bairro.');
               redirect(base_url());
            }
            
            $id =  $this->input->post('idBairro');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir bairro.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/bairro/gerenciar/');
            }
			
            $this->logs_modelclass->registrar_log_antes_delete('bairro', 'idBairro', $id, 'Bairros');
            if ($this->bairro_model->delete('bairro','idBairro',$id)) {
            	$this->logs_modelclass->registrar_log_depois();
            }

            $this->session->set_flashdata('success','Bairro excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/bairro/gerenciar/');
    }
}

