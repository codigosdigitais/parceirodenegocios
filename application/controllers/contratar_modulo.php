<?php

class contratar_modulo extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        

        $this->load->model('bairro_model','',TRUE);
	}	
	
	function index(){
		$this->data['view'] = 'tema/no_permission';
		$this->load->view('tema/topo',$this->data);
	}
}