<?php
class Administrando extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('entrega/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('administrando_model', '', TRUE);
		$this->data['parametrosCategoria'] = $this->administrando_model->ListaParametrosCategoria();
        $this->data['menuAdministrar'] = 1;
    }

    function index(){
	    $this->data['view'] = 'administrando/administrando';
       	$this->load->view('tema/topo',$this->data);
	}

    function clientes(){

    	if(!$this->permission->controllerManual('clientes')->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para visualizar Clientes.');
    		redirect(base_url());
    	}
    	
		$this->data['results'] = $this->administrando_model->get("cliente");
	    $this->data['view'] = 'administrando/clientes/clientes';
       	$this->load->view('tema/topo',$this->data);
	}
	
    function clientesAdicionar(){

    	if(!$this->permission->controllerManual('clientes')->canInsert()){
    		$this->session->set_flashdata('error','Você não tem permissão para inserir Clientes.');
    		redirect(base_url());
    	}
		
        $this->load->library('form_validation');
		$this->load->library('encrypt'); 
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('cedentes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			# Adicinoar Cliente
			$cliente = array($_POST);
			foreach($cliente as $value){
				$data_cliente = $value;
				$data_cliente['tipo'] = 'parceiro';
				//$data_cliente['idEmpresa'] = '0';
				//$data_cliente['senha'] = $this->input->post('cnpj');
				//unset($data_cliente['permissoes']);
			}
			
			$ultimo_id = $this->administrando_model->add('cliente', $data_cliente);
			
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert('cliente', 'idCliente', $ultimo_id, 'Adm: Clientes');
			}
			
			# Adicionar Permissões do Cliente
			/*
			$permissoes = array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="permissoes"){
					$permissoes=$val;
					unset($_POST[$key]);
				}
			}
			$permissoes = serialize($permissoes);
			$data['permissoes'] = $permissoes;
			$data['idCliente'] = $ultimo_id;
			
			$idPermissao = $this->administrando_model->add('permissoes', $data);
			if ($idPermissao) {
				$this->logs_modelclass->registrar_log_insert('permissoes', 'idPermissao', $idPermissao_id, 'Adm: Permissões');
			}
			*/
			
            if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success', 'Cliente adicionado com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/administrando/clientesEditar/' . $ultimo_id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

		}
		
		$this->data['resultsModels'] = $this->administrando_model->getModulosCategoria();
	    $this->data['view'] = 'administrando/clientes/adicionarCliente';
       	$this->load->view('tema/topo',$this->data);
	}


    function clientesEditar(){
    	if(!$this->permission->controllerManual('clientes')->canUpdate()){
    		$this->session->set_flashdata('error','Você não tem permissão para atualizar Clientes.');
    		redirect(base_url());
    	}
		
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('cedentes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			
			# Adicinoar Cliente
			$cliente = array($_POST);
			foreach($cliente as $value){
				$data_cliente = $value;
				//$data_cliente['senha'] = $this->input->post('cnpj');
				unset($data_cliente['permissoes']);
			}
			
			$this->logs_modelclass->registrar_log_antes_update('cliente', 'idCliente', $this->input->post('idCliente'), 'Adm: Clientes');
			if ($this->administrando_model->edit('cliente', $data_cliente, 'idCliente', $this->input->post('idCliente'))) {
				$this->logs_modelclass->registrar_log_depois();
			}
			$ultimo_id = $this->input->post('idCliente');			
	
			# Adicionar Permissões do Cliente
			/*
			$permissoes = array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="permissoes"){
					$permissoes=$val;
					unset($_POST[$key]);
				}
			}
			$permissoes = serialize($permissoes);
			$data_permissao['permissoes'] = $permissoes;
			
			$this->logs_modelclass->registrar_log_antes_update('permissoes', 'idCliente', $this->input->post('idCliente'), 'Adm: Permissões');
			if ($this->administrando_model->edit('permissoes', $data_permissao, 'idCliente', $this->input->post('idCliente'))) {
				$this->logs_modelclass->registrar_log_depois();
			}
			*/
			$url = "";
			if($this->uri->segment(4)){
				$url = $this->uri->segment(4);
			}
				
           if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success', 'Permissão alterada com sucesso!');
				redirect(base_url() . $this->permission->getIdPerfilAtual().'/administrando/clientesEditar/'.$this->input->post('idCliente').'/'.$url);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

		}
		
		$this->data['result'] = $this->administrando_model->getByIdADMCliente($this->uri->segment(3));
		$this->data['resultsModels'] = $this->administrando_model->getModulosCategoria();
	    $this->data['view'] = 'administrando/clientes/adicionarCliente';
       	$this->load->view('tema/topo',$this->data);
	}

    /*function modulos(){
		$this->data['results'] = $this->administrando_model->getModulos();
	    $this->data['view'] = 'administrando/modulos/modulos';
       	$this->load->view('tema/topo',$this->data);
	}*/
	
    /*function modulosAdicionar(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('administrando_modulos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$id = $this->administrando_model->add('modulos', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('modulos', 'idModulo', $id, 'Adm: Módulos');
                $this->session->set_flashdata('success','Módulo adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/administrando/modulosAdicionar');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Preencha corretamente todos os dados.</p></div>';
            }
        }
		
	    $this->data['view'] = 'administrando/modulos/adicionarModulos';
       	$this->load->view('tema/topo',$this->data);
	}*/
	
	
	/*function modulosEditar(){
		
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('administrando_modulos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$this->logs_modelclass->registrar_log_antes_update('modulos', 'idModulo', $this->input->post('idModulo'), 'Adm: Módulos');
            if ($this->administrando_model->edit('modulos', $data, 'idModulo', $this->input->post('idModulo')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Cedente editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/administrando/modulosEditar/'.$this->input->post('idModulo'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->administrando_model->getById($this->uri->segment(3));
	    $this->data['view'] = 'administrando/modulos/adicionarModulos';
       	$this->load->view('tema/topo',$this->data);
	
	}*/
	
	
    public function clientesExcluir(){

	    	if(!$this->permission->controllerManual('clientes')->canDelete()){
	    		$this->session->set_flashdata('error','Você não tem permissão para remover Clientes.');
	    		redirect(base_url());
	    	}
	    	
            $id =  $this->input->post('idCliente');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/administrando/clientes/');
            }
			
            $this->logs_modelclass->registrar_log_antes_delete('cliente', 'idCliente', $id, 'Adm: Clientes');
            $this->administrando_model->delete('cliente','idCliente',$id);
            $this->logs_modelclass->registrar_log_depois();
            
            $this->session->set_flashdata('success','Cliente excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/administrando/clientes/');
    }

	
	

    function parametros(){
    	$this->setControllerMenu('administrando/parametros');
    	
    	if(!$this->permission->controllerManual('administrando/parametros')->canSelect()){
    		$this->session->set_flashdata('error','Você não tem permissão para visualizar parâmetros gerais.');
    		redirect(base_url());
    	}

		#paginacao
			$this->load->library('table');
			$this->load->library('pagination');
	
			$config['base_url'] = base_url().'administrando/parametros';
			$config['total_rows'] = $this->administrando_model->count('parametro');
			$config['per_page'] = 50;
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
		#fecha paginacao
				
		$this->data['results_lista'] = $this->administrando_model->getParametrosLista();
		$this->data['results'] = $this->administrando_model->getParametros('chamada','idChamada, idCliente','',$config['per_page'],$this->uri->segment(3));
	    $this->data['view'] = 'administrando/parametros/parametros';
       	$this->load->view('tema/topo',$this->data);
	}
	
    function parametrosAdicionar(){
        $this->setControllerMenu('administrando/parametros');
		
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('parametros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

        	if(!$this->permission->controllerManual('administrando/parametros')->canInsert()){
        		$this->session->set_flashdata('error','Você não tem permissão para inserir parâmetros gerais.');
        		redirect(base_url());
        	}
        	
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$id = $this->administrando_model->add('parametro', $data);
            if ( $id ) {
            	$this->logs_modelclass->registrar_log_insert('parametro', 'idParametro', $id, 'Adm: Parâmetros');
                $this->session->set_flashdata('success','Parâmetro adicionado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/administrando/parametros/adicionarParametro');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        if(!$this->permission->controllerManual('administrando/parametros')->canSelect()){
        	$this->session->set_flashdata('error','Você não tem permissão para visualizar parâmetros gerais.');
        	redirect(base_url());
        }
		
	    $this->data['view'] = 'administrando/parametros/adicionarParametro';
       	$this->load->view('tema/topo',$this->data);
	}
	
    function parametrosEditar(){
        $this->setControllerMenu('administrando/parametros');

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
        if ($this->form_validation->run('parametros') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

        	if(!$this->permission->controllerManual('administrando/parametros')->canUpdate()){
        		$this->session->set_flashdata('error','Você não tem permissão para atualizar parâmetros gerais.');
        		redirect(base_url());
        	}
        	
			// adiciona campos criados dinamicamentes para inserção de conteudos
			$campos = array($_POST);
			foreach($campos as $valor){
				$data = $valor;
			}
			
			$tipo_parametro = $this->input->post('tipo_parametro'); 
			if(isset($tipo_parametro)){
				$redirecionar = $this->permission->getIdPerfilAtual()."/administrando/parametros?tipo_parametro={$tipo_parametro}";	
			} else {
				$redirecionar = $this->permission->getIdPerfilAtual()."/administrando/parametros";	
			}
			
			unset($data['tipo_parametro']);
			
			$this->logs_modelclass->registrar_log_antes_update('parametro', 'idParametro', $this->input->post('idParametro'), 'Adm: Parâmetros');
            if ($this->administrando_model->edit('parametro', $data, 'idParametro', $this->input->post('idParametro')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois();
                $this->session->set_flashdata('success','Parâmetro editado com sucesso!');
              	redirect(base_url($redirecionar));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->administrando_model->getByIdParametro($this->uri->segment(3));
        //$this->data['view'] = 'parametro/editarParametro';
		$this->data['view'] = 'administrando/parametros/adicionarParametro';
        $this->load->view('tema/topo', $this->data);

	}
	
    public function parametroExcluir(){

	    	if(!$this->permission->controllerManual('administrando/parametros')->canDelete()){
	    		$this->session->set_flashdata('error','Você não tem permissão para remover parâmetros gerais.');
	    		redirect(base_url());
	    	}
    	
	        $id =  $this->input->post('idParametro');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Parâmetro.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/administrando/parametros');
            }
			
            $this->logs_modelclass->registrar_log_antes_delete('parametro', 'idParametro', $id, 'Adm: Parâmetro');
            
            $this->administrando_model->delete('parametro','idParametro',$id);
            $this->logs_modelclass->registrar_log_depois();
            
            
            $this->session->set_flashdata('success','Parâmetro excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/administrando/parametros');
    }



}

