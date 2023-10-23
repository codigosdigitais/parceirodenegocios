<?php

class Parametro extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('parametro_model','',TRUE);
            $this->load->model ( 'logs_modelclass', '', TRUE );
            $this->data['menuParametro'] = 'parametro';
			$this->data['parametrosCategoria'] = $this->parametro_model->ListaParametrosCategoria();
			$this->data['menuConfiguracoes'] = 'Parâmetros';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aParametro')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar parametro.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'parametro/gerenciar/';
        $config['total_rows'] = $this->parametro_model->count('parametro');
        $config['per_page'] = 300;
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
        
	    $this->data['results'] = $this->parametro_model->get('parametro','idParametro, idParametroCategoria, parametro','',$config['per_page'],$this->uri->segment(3));
       	
       	$this->data['view'] = 'parametro/parametro';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aParametro')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar parametro.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
        if ($this->form_validation->run('parametros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$ultimo_id = $this->parametro_model->add('parametro', $data);
			
            if ($id) {
            	$this->logs_modelclass->registrar_log_insert ( 'parametro', 'idParametro', $ultimo_id, 'Parâmetros' );
                $this->session->set_flashdata('success','Parâmetro adicionado com sucesso!');
                redirect(base_url() . 'parametro/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'parametro/adicionarParametro';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eParametro')){
           $this->session->set_flashdata('error','Você não tem permissão para editar parametro.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('parametros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}

			$this->logs_modelclass->registrar_log_antes_update ( 'parametro', 'idParametro', $this->input->post ( 'idParametro' ), 'Parâmetros' );
			
            if ($this->parametro_model->edit('parametro', $data, 'idParametro', $this->input->post('idParametro')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Parâmetro editado com sucesso!');
                redirect(base_url() . 'parametro/editar/'.$this->input->post('idParametro'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->parametro_model->getById($this->uri->segment(3));
        //$this->data['view'] = 'parametro/editarParametro';
		$this->data['view'] = 'parametro/adicionarParametro';
        $this->load->view('tema/topo', $this->data);

    }


    public function excluir(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dParametro')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir Parâmetro.');
               redirect(base_url());
            }
            
            $id =  $this->input->post('idParametro');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Parâmetro.');            
                redirect(base_url().'parametro/gerenciar/');
            }

            $this->logs_modelclass->registrar_log_antes_delete ( 'parametro', 'idParametro', $id, 'Parâmetros' );
            if ($this->parametro_model->delete('parametro','idParametro',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }

            $this->session->set_flashdata('success','Parâmetro excluido com sucesso!');            
            redirect(base_url().'parametro/gerenciar/');
    }
}

