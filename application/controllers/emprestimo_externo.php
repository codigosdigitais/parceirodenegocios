<?php
/*
* @autor: Davi Siepmann
* @date: 22/10/2015
*/
class emprestimo_externo extends MY_Controller {
	
	
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
			//verifica login
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');
	}	
	
	/*
	* @autor: Davi Siepmann
	* @date: 22/10/2015
	*/
	# exibe parametros de empréstimo e financiamento à funcionários
	function index(){
		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para acessar esta função (cód: not[emp_ext]).');
			redirect(base_url());
		}
		else {
			redirect(base_url() . $this->permission->getIdPerfilAtual().'/financiamento/emprestimo_externo');
		}
	}
}