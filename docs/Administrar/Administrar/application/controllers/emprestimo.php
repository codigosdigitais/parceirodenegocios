<?php
/*
* @autor: Davi Siepmann
* @date: 15/10/2015
*/
class emprestimo extends MY_Controller {
	
	
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
			//verifica login
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) redirect('entrega/login');
	}	
	
	/*
	* @autor: Davi Siepmann
	* @date: 15/10/2015
	*/
	# exibe parametros de empréstimo e financiamento à funcionários
	function index(){
		if(!$this->permission->canSelect()){
			$this->session->set_flashdata('error','Você não tem permissão para visualizar emprestimos.');
			redirect(base_url());
		}
		else {
			redirect(base_url() . $this->permission->getIdPerfilAtual().'/financiamento/emprestimo');
		}
	}
}