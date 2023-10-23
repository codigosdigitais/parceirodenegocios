<?php
class Externo extends MY_Controller {

	//tabela que armazena suario e senha
	//necessario pois isso será alterado
	//setado no construtor
	private $tabelaUsuarioTabela;
	private $tabelaUsuarioPk;
	
	
    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
	            redirect('entrega/login');
            }

            $this->load->helper(array('codegen_helper'));
            $this->load->model('externo_model','',TRUE);

			$this->tabelaUsuarioTabela = "sis_usuario";
			$this->tabelaUsuarioPk	   = "idUsuario";
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		$this->setControllerMenu('externo/chamadas');

        if(!$this->permission->controllerManual('externo/chamadas')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Ordens de Serviço.');
           redirect(base_url());
        }
       	
       	$this->data['view'] = 'externo/chamadas';
       	$this->load->view('tema/topo',$this->data);
    }

    public function minha_conta() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('retifica/login');
        }

        $this->data['usuario'] = $this->externo_model->getById($this->session->userdata('idCliente'));
        $this->data['view'] = 'entrega/minhaConta';
        $this->load->view('tema/topo',  $this->data);
    }

    public function alterar_senha() {
		
		
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('retifica/login');
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        
        $this->logs_modelclass->registrar_log_antes_update ( $this->tabelaUsuarioTabela, $this->tabelaUsuarioPk, $this->session->userdata('idCliente'), 'Alteração de senha' );
        
        $result = $this->externo_model->alterarSenha($senha,$oldSenha, $this->session->userdata('idCliente'));
        if($result){
        	$this->logs_modelclass->registrar_log_depois ();
            $this->session->set_flashdata('success','Senha Alterada com sucesso!');
            redirect(base_url() . 'externo/minha_conta');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url() . 'externo/minha_conta');
            
        }
    }



    function chamadas(){
        $this->setControllerMenu('externo/chamadas');

        if(!$this->permission->controllerManual('externo/chamadas')->canSelect()){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Ordens de Serviço.');
            redirect(base_url());
        }

        if($this->uri->segment(3)=='imprimir'){
            $this->data['imprimir_chamada'] = $this->externo_model->getChamadaById($this->uri->segment(4));
        }

        $this->data['lista_chamadas'] = $this->externo_model->getChamadas();

        #echo "<pre>";
        #echo $this->db->last_query();
        #print_r($this->data);
        #die();

        $this->data['view'] = 'externo/chamadas';
        $this->load->view('tema/topo',$this->data);
    }

	function chamadas_funcionario(){
		$this->setControllerMenu('externo/chamadas_funcionario');

        if(!$this->permission->controllerManual('externo/chamadas_funcionario')->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Ordens de Serviço.');
           redirect(base_url());
        }
		
		if($this->uri->segment(3)=='imprimir'){
			$this->data['imprimir_chamada'] = $this->externo_model->getChamadaById($this->uri->segment(4));	
		}

        $idFuncionario = ($this->session->userdata('idFuncionario')) ? $this->session->userdata('idFuncionario') : '0';
		$this->data['lista_chamadas'] = $this->externo_model->getChamadasFuncionario($idFuncionario);
       	
       	$this->data['view'] = 'externo/chamadas';
       	$this->load->view('tema/topo',$this->data);
    }

}