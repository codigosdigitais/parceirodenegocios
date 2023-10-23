<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entrega extends MY_Controller {

    public function __construct() {
    	
    	parent::__construct();
    	
        $this->load->model('entrega_model','',TRUE);
		$this->load->model('documentos_model','',TRUE);
		
		//somente carregar permission_model em classes que possam chamar $this->permission->autoSetSessionPermissions()
		$this->load->model ('permission_model', '', TRUE );
    }

    public function index() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
        }

        if ($this->session->userdata('tipo') == 'SISAdmin') {

        	$this->data['parceiros'] = $this->entrega_model->getParceirosParaSelecionar();
        	$this->data['view'] = 'sis/sis_painel';
        	$this->load->view('tema/topo',  $this->data);
        }
        else {
			$this->data['propaganda'] = $this->documentos_model->get('documento',null,null,'propaganda',500, null, 2);

	        $this->data['view'] = 'entrega/painel';
		    $this->load->view('tema/topo',  $this->data);
        }
    }
    
    /**
     * Faz com que usuário SISAdmin logado tenha acesso ao sistema de um parceiro
     */
    public function vinculaParceiroSISAdmin() {
    	if ($this->session->userdata('tipo') == 'SISAdmin') {
    		
    		$this->unsetAllUserData();
    		
    		$idCliente = $this->input->post('idCliente');
    		$idUsuario = $this->input->post('idUsuario');
    		$idPerfil  = $this->input->post('idPerfil');
    		
    		if ($idUsuario) {
    			$usuario = $this->entrega_model->getUsuarioSimulaAcesso(array('idUsuario' => $idUsuario));
    				
    			if ($usuario) {
    				$usuario = array_shift($usuario);
    				
    				$this->session->set_userdata($usuario);
    				$this->permission->autoSetSessionPermissions($usuario->idUsuarioSimulacao);
    			}
    		}
    		else if ($idPerfil && $idCliente) {
    			$usuario = $this->entrega_model->getEmpresaSimulaAcesso(array('idCliente' => $idCliente));
    			
    			if ($usuario) {
    				$usuario = array_shift($usuario);
    			
    				$this->session->set_userdata($usuario);
    				$this->permission->autoSetSessionPermissionsSimulacao($idPerfil);
    				
    			}
    		}
    	}
    	
    	redirect(base_url().'entrega');
    }

    private function unsetAllUserData() {

    	$this->session->unset_userdata('idUsuarioSimulacao');
    	$this->session->unset_userdata('nomeSimulacao');
    	$this->session->unset_userdata('tipoSimulacao');
    	$this->session->unset_userdata('loginSimulacao');
    	$this->session->unset_userdata('nomePerfilSimular');
    	$this->session->unset_userdata('idPerfilSimular');
    	$this->session->unset_userdata('permissoes');
    	
    }
    

    public function minhaConta() {
		
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
        }

        $this->data['usuario'] = $this->entrega_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'entrega/minhaConta';
        $this->load->view('tema/topo',  $this->data);
     
    }

    public function login(){
		//como padrão quando não informado ID
    	//passado ID 148 manualmente pois era o primeiro parceiro
    	//pessoal não era habituado a acessar sistema pela própria URL
    	$this->data['idEmpresa'] = 148;

        $url = $this->session->userdata('url');
        //$this->session->sess_destroy();
        
        if ($url) redirect($url);
        else redirect(base_url('parceiro/nr'));
        //$this->load->view('entrega/login', $this->data);
    }
	
    public function encaminhaSistema() {
    	redirect('entrega');
    }
    
    public function sair(){
    	$url = $this->session->userdata('url');
        $this->session->sess_destroy();
        
        if ($url) redirect($url);
        else 	  redirect('entrega/login');
    }

    public function verificarLogin() {
    	
    	if ($this->validaDadosLogin()) {
    		
			$where = $this->getDadosFormUsuario();
			
			$usuario = $this->entrega_model->getUsuario($where);
			
			if ($usuario) {
				$usuario = array_shift($usuario);
				
				//Armazena dados usuário na sessão
				$this->session->set_userdata($usuario);
				$this->session->set_userdata('logado', true);
				
				if ($this->permission->autoSetSessionPermissions($usuario->idUsuario)) {
					
					$this->logs_modelclass->registrar_log_insert ( 'sis_usuario', 'idUsuario', $usuario->idUsuario, 'Acesso ao sistema: Sucesso!' );
					/*
					var_dump($this->session->userdata);
					die('encontrou e senha correga!');
					*/
					redirect(base_url().'entrega');
				}
				else {
					$this->session->set_userdata('error','Usuário não possui permissões no sistema!');
				}
			}
			else {
				$this->session->set_userdata('error','Usuário não existe ou está inativo.');
			}
			
    	}
   		redirect(base_url().'entrega/login');
    }

    public function verificarLoginAjax() {
    	 
    	$resposta = array();
    	 
    	if ($this->validaDadosLogin()){

    		$where = $this->getDadosFormUsuario();    			
    		$usuario = $this->entrega_model->getUsuario($where);
    			
    		if ($usuario) {
    			$usuario = array_shift($usuario);
    
    			//Armazena dados usuário na sessão
    			$this->session->set_userdata("usuarioLogado", $usuario); // Definido 19-10-2020
    			$this->session->set_userdata('logado', true);
    			
    			if ($this->permission->autoSetSessionPermissions($usuario->idUsuario)) {
    				
    				$this->logs_modelclass->registrar_log_insert ( 'sis_usuario', 'idUsuario', $usuario->idUsuario, 'Acesso ao sistema: Sucesso!' );
    				$resposta = array('success' => true);
    				
    			}
    			else {
    				$resposta = array('error' => true, 'mensagem' => 'Usuário não possui permissões no sistema!');
    			}
    		}
    		else {
    			$resposta = array('error' => true, 'mensagem' => 'Usuário ou senha inválido!');
    		}
    			
    	}
    	else {
    		$resposta = array('error' => true, 'mensagem' => 'Dados em formato inválido.');
    	}
    	 
    	echo json_encode($resposta);
    }

    

    private function getDadosFormUsuario() {
    	
    	$dados = array(
    		'a.login'		=> $this->input->post('login'),
    		'a.idEmpresa'	=> $this->input->post('idEmpresa'),
    		'a.senha'		=> $this->input->post('senha'),
    		'a.situacao'	=> 5
    	);
    	
    	return $dados;
    }
    
    private function validaDadosLogin() {
    	
    	$this->load->library('form_validation');
    	 
    	$this->form_validation->set_rules('idEmpresa', 	'Empresa (parceiro)', 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('login', 		'Usuário/Login',	 		'trim|required|xss_clean');
    	$this->form_validation->set_rules('senha', 		'Senha',			 		'trim|required|xss_clean');
       // $this->form_validation->set_rules('senha',      'Senha',                    'trim|required|xss_clean|MD5');
    	 
    	if ($this->form_validation->run() == false) {
    		$this->session->set_userdata('error','Verifique as informações fornecidas.<br>' . validation_errors());    		 
    		return false;
    	}
    	 
    	else return true;
    }
	/*
    public function verificarLogin(){

		$email = $this->input->post('email');
		$senha = $this->input->post('senha');

		$this->load->library('encrypt');   
//		$senha = $this->encrypt->sha1($senha);

		$this->db->select('idCliente, email, senha, razaosocial, responsavel, situacao, idPermissao, idEmpresa');
		$this->db->where('email',$email);
		$this->db->where('senha',$senha);
		$this->db->limit(1);
		$usuario = $this->db->get('cliente')->row();
	
		if(count($usuario) > 0){//& $senha == 'londres2016& $senha == 'londres2016
		
			if($usuario->situacao){
				$permissao = $usuario->idPermissao;
				$sql = "SELECT * FROM permissoes WHERE idPermissao = '{$permissao}'";
				$permissao = $this->db->query($sql)->row('permissoes');
				
				//precisa do IDEmpresa, ou seja, empresa que este cliente pertence
				//utilizado nos logs (entre outros)
				$idEmpresa = ($usuario->idEmpresa > 0) ? $usuario->idEmpresa : $usuario->idCliente;
				
				$dados = 
					array(
						'nome' => $usuario->responsavel, 
						'empresa' =>  $usuario->razaosocial, 
						'idCliente' => $usuario->idCliente, 
						'idEmpresa' => $idEmpresa,
						'permissao' => $usuario->idPermissao, 
						'permissoes' => $permissao, 
						'logado' => TRUE
					);
					
				$this->session->set_userdata($dados);
				
				$this->logs_modelclass->registrar_log_insert ( 'sis_usuario', 'idUsuario', $usuario->idCliente, 'Acesso ao sistema: Sucesso!' );
				
				redirect(base_url().'entrega');
			} else {
				$this->logs_modelclass->registrar_log_insert ( 'sis_usuario', 'idUsuario', $usuario->idCliente, 'Acesso ao sistema: Usuário inativo ('.$email.')' );
				$this->session->set_userdata('error','Este usuário encontra-se inativo em nosso banco de dados.');
				redirect(base_url().'entrega/login');					
			}

		} else {
			$this->session->set_userdata('error','Os dados de acesso estão incorretos.');
			redirect(base_url().'entrega/login');
		}
        
    }
	*/

    public function backup(){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
        }

        $this->logs_modelclass->registrar_log_insert ( 'sis_usuario', 'idUsuario', $this->session->userdata('idUsuario'), 'Backup do banco de dados' );

        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup =& $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }

}
