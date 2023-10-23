<?php
# DOCUMENTOS EXTENDS CONTROLLER #
class Documentos_externo extends MY_Controller {
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('documentos_externo_model','',TRUE);
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
       	$this->data['view'] = 'documentos/documentos_externo';
       	$this->load->view('tema/topo',$this->data);
    }
    
	
	# DOC GER CEDENTE #
    public function cedente(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar estes documentos.');
           redirect(base_url());
        }
		
        $this->load->library('table');
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'documentos_externo/cedente/';
        $config['total_rows'] = $this->documentos_externo_model->count('documento','idCedente','cedente','cedente');
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
        
        $this->data['view'] = 'documentos/cadastros/cedentes_externo';
		$this->data['results'] = $this->documentos_externo_model->get('documento','idCedente','cedente','cedente',$config['per_page'],$this->uri->segment(4));
       	$this->load->view('tema/topo',$this->data);
    }
	
    
	# DOWNLOAD BASE #
    public function download($id = null){
    	
        if(!$this->permission->canSelect()){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar Documento.');
          redirect(base_url());
        }

    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos_externo/cedente');
    	}
			
//         die('ici');

    	$file = $this->documentos_externo_model->getById($id);
    	$this->load->library('zip');
    	$path = $file[0]->diretorio;
		$this->zip->read_file($path); 
		$this->zip->download('file'.date('d-m-Y-H.i.s').'.zip');

    	redirect(base_url() . $this->permission->getIdPerfilAtual().'/documentos_externo/cedente');
    }


}

