<?php

class Adicionaisc extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('adicionaisc_model','',TRUE);
			$this->data['parametroDesconto'] = $this->adicionaisc_model->getParametroById(812);
			$this->data['listaFuncionario'] = $this->adicionaisc_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(3));
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar adicionais.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'adicionaisc/gerenciar/';
        $config['total_rows'] = $this->adicionaisc_model->count('adicional');
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
        
	    $this->data['results'] = $this->adicionaisc_model->get('adicional','idadicional, idFuncionario, tipo, data, detalhes, valor','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'adicionaisc/adicionais';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar adicionais.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('adicionais') == false) {
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
			$data['modulo'] = 'cliente';
			
			$id = $this->adicionaisc_model->add('adicional', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('adicional', 'idAdicional', $id, 'Adicionais para Cliente');
                $this->session->set_flashdata('success','Adicional adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/adicionaisc/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'adicionaisc/adicionarAdicional';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar adicionais.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('adicionais') == false) {
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
			
			$this->logs_modelclass->registrar_log_antes_update('adicional', 'idAdicional', $this->input->post('idAdicional'), 'Adicionais para Cliente');
            if ($this->adicionaisc_model->edit('adicional', $data, 'idAdicional', $this->input->post('idAdicional')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Adicional editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/adicionaisc/editar/'.$this->input->post('idAdicional'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->adicionaisc_model->getById($this->uri->segment(3));
        $this->data['view'] = 'adicionaisc/adicionarAdicional';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar adicionais.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->adicionaisc_model->getByIdView($this->uri->segment(3));
        $this->data['view'] = 'adicionaisc/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir adicionais.');
               redirect(base_url());
            }
			
            $id =  $this->input->post('idAdicional');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir adicional.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/adicionaisc/gerenciar/');
            }
            
            $this->logs_modelclass->registrar_log_antes_delete('adicional', 'idAdicional', $id, 'Adicionais para Cliente');
            
            if ($this->adicionaisc_model->delete('adicional','idAdicional',$id))
            	$this->logs_modelclass->registrar_log_depois();
            
            $this->session->set_flashdata('success','Adicional excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/adicionaisc/gerenciar/');
    }
}

