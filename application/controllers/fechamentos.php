<?php
# FECHAMENTO EXTENDS CONTROLLER #
class Fechamentos extends MY_Controller {
    
	# CLASSE DOCUMENTACAO #
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('fechamentos_model','',TRUE);
	}	
	
	function index(){
		$this->gerenciar();
	}

	# gerencia a pagina principal #
	function gerenciar(){

        if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
       	$this->data['view'] = 'fechamentos/fechamentos';
       	$this->load->view('tema/topo',$this->data);
    }
	
	# gerencia funcionario
	function funcionario(){
		if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->fechamentos_model->getBase('funcionario', 'nome', 'ASC');
       	$this->data['view'] = 'fechamentos/fechamento/funcionario';
       	$this->load->view('tema/topo',$this->data);		
	}
	
    public function fechamentoFuncionario(){
    	$this->setControllerMenu('financeiro/funcionario');

        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->fechamentos_model->fechamentoFuncionario($idFuncionario, $data_inicial,$data_final, $view);
		$this->data['view'] = 'fechamentos/imprimir/funcionario';
		$this->load->view('tema/topo',$this->data);	
    
    }
	
	# gerencia chamada
	function chamada(){
		if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->fechamentos_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->fechamentos_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'fechamentos/fechamento/chamada';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoChamada(){
    	$this->setControllerMenu('financeiro/chamada');
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idCliente = $this->input->get('idCliente');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');
		
        $this->data['results'] = $this->fechamentos_model->fechamentoChamada2($data_inicial, $data_final, $idCliente, $idFuncionario, $view);

		$this->data['view'] = 'fechamentos/imprimir/chamada';
		$this->load->view('tema/topo',$this->data);	
    
    }
	
	
	# gerencia particular
	function particular(){
		if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->fechamentos_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->fechamentos_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'fechamentos/fechamento/particular';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoParticular(){
    	if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para gerar fechamento.');
           redirect(base_url());
        }
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->fechamentos_model->fechamentoParticular($data_inicial, $data_final, $idFuncionario, $view);
		$this->data['view'] = 'fechamentos/imprimir/particular';
		$this->load->view('tema/topo',$this->data);	
    
    }

	# gerencia empresa
	function empresa(){
		if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fechamentos.');
           redirect(base_url());
        }
		
		$this->data['listaFuncionario'] = $this->fechamentos_model->getBase('funcionario', 'nome', 'ASC');
		$this->data['listaCliente'] = $this->fechamentos_model->getBase('cliente', 'razaosocial', 'ASC');
       	$this->data['view'] = 'fechamentos/fechamento/empresa';
       	$this->load->view('tema/topo',$this->data);		
	}

    public function fechamentoEmpresa(){
    	if(!$this->permission->controllerManual('financeiro/chamada')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para gerar fechamento.');
           redirect(base_url());
        }
		
		// tipo_chamada, idCliente, idFuncionario, data_inicial, data_final, view
        $data_inicial = $this->input->get('data_inicial');
        $data_final = $this->input->get('data_final');
		$idFuncionario = $this->input->get('idFuncionario');
		$view = $this->input->get('view');

        $this->data['results'] = $this->fechamentos_model->fechamentoEmpresa($data_inicial, $data_final, $idFuncionario, $view);
		$this->data['view'] = 'fechamentos/imprimir/empresa';
		$this->load->view('tema/topo',$this->data);	
    
    }




}

