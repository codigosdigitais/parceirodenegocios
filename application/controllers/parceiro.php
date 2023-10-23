<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class parceiro extends MY_Controller {

    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    }
	
     /* ################################*
     * Criar campo unico no cad cliente*
     * e abrir dinamicamente a tela de *
     * login pelo nome na URL          *
     * utilizar HTACCESS para isso     * 
     * 								   */
    
    public function id() {
    	$idEmpresa = $this->uri->segment(3);
    	$this->loadFirstView($idEmpresa);
    }
    
    /* NR. SERVIÇOS ADMINISTRATIVOS */
    public function nr() {
    	$this->loadFirstView(148);
    }
    
    private function loadFirstView($idEmpresa) {
    	
    	$url = base_url(uri_string());
    	$this->session->set_userdata('url', $url);
    	
    	if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
    		$this->data['idEmpresa'] = $idEmpresa;
    		$this->load->view('entrega/login', $this->data);
    	}
    	else {
    		redirect(base_url());
    	}
    }
    
    
}
