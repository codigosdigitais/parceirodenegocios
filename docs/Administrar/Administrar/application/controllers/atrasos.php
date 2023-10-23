<?php

class Atrasos extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('atrasos_model','',TRUE);
            $this->load->model('logs_modelclass','',TRUE);
			$this->data['parametroAtraso'] = $this->atrasos_model->getParametroById(1);
			$this->data['listaFuncionario'] = $this->atrasos_model->getBase('funcionario', 'nome', 'ASC');
            $this->data['menu'] = 'recursoshumanos';
			$this->data['modulosBase'] = $this->atrasos_model->getModulosCategoria();
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rec_vAtrasos')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar atrasos.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'atrasos/gerenciar/';
        $config['total_rows'] = $this->atrasos_model->count('atraso');
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
        
	    $this->data['results'] = $this->atrasos_model->get('atraso','idAtraso, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'atrasos/atrasos';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rec_aAtrasos')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar atrasos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('atrasos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$date = $this->input->post('data');
			$date = str_replace('/', '-', $date);
			$data['data'] = date('Y-m-d', strtotime($date));
			
			$id = $this->atrasos_model->add('atraso', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('atraso', 'idAtraso', $id, 'Atrasos');
                $this->session->set_flashdata('success','Atraso adicionado com sucesso!');
                redirect(base_url() . 'atrasos/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'atrasos/adicionarAtraso';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rec_eAtrasos')){
           $this->session->set_flashdata('error','Você não tem permissão para editar atrasos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('atrasos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$date = $this->input->post('data');
			$date = str_replace('/', '-', $date);
			$data['data'] = date('Y-m-d', strtotime($date));
			
			$this->logs_modelclass->registrar_log_antes_update('atraso', 'idAtraso', $this->input->post('idAtraso'), 'Atrasos');
            if ($this->atrasos_model->edit('atraso', $data, 'idAtraso', $this->input->post('idAtraso')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Atraso editado com sucesso!');
                redirect(base_url() . 'atrasos/editar/'.$this->input->post('idAtraso'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->atrasos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'atrasos/adicionarAtraso';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rec_vAtrasos')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar atrasos.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->atrasos_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'atrasos/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rec_dAtrasos')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir atrasos.');
               redirect(base_url());
            }

            $id =  $this->input->post('idAtraso');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir atraso.');            
                redirect(base_url().'atrasos/gerenciar/');
            }
			
            $this->logs_modelclass->registrar_log_antes_delete('atraso', 'idAtraso', $id, 'Atraso');
            if ($this->atrasos_model->delete('atraso','idAtraso',$id)) {
            	$this->logs_modelclass->registrar_log_depois();
            }
            $this->session->set_flashdata('success','Atraso excluido com sucesso!');            
            redirect(base_url().'atrasos/gerenciar/');
    }
}

