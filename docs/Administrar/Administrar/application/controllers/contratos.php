<?php

class Contratos extends MY_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('entrega/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('contratos_model','',TRUE);
			$this->data['listaCliente'] = $this->contratos_model->getBase('cliente', 'razaosocial', 'ASC', $this->uri->segment(4));
			$this->data['listaCedente'] = $this->contratos_model->getListaCedentesBase($this->uri->segment(4));
			$this->data['listaFuncionario'] = $this->contratos_model->getBase('funcionario', 'nome', 'ASC', $this->uri->segment(4));
			$this->data['parametroBanco'] = $this->contratos_model->getParametroById(2);
			$this->data['parametroFormaPagamento'] = $this->contratos_model->getParametroById(8);
			$this->data['parametroNota'] = $this->contratos_model->getParametroById(12);
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

		/*

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar contratos.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
   
        $config['base_url'] = base_url().'contratos/gerenciar/';
        $config['total_rows'] = $this->contratos_model->count('contrato');
        $config['per_page'] = 200;
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
        
	    $this->data['results'] = $this->contratos_model->get('contrato','idContrato, idCliente, idCedente','',$config['per_page'],$this->uri->segment(4));

	    */

	    $this->data['results'] = $this->contratos_model->getContratos();
       	$this->data['view'] = 'contratos/contratos';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
	
    function adicionar() {
        if(!$this->permission->canInsert()){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar contratos.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('contratos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
			



			#define campos do contrato
			$data['idCliente'] = $this->input->post('idCliente');
			$data['idCedente'] = $this->input->post('idCedente');
			$data['idEmpresa'] = $this->session->userdata['idEmpresa'];
			$data['forma_de_pagamento'] = $this->input->post('forma_de_pagamento');
			$data['nota_fiscal'] = $this->input->post('nota_fiscal');
			$data['fechamento_de'] = $this->input->post('fechamento_de');
			$data['fechamento_a'] = $this->input->post('fechamento_a');
			$data['vencimento'] = $this->input->post('vencimento');
			$data['guias'] = $this->input->post('guias');
			$data['dataativo'] = $this->input->post('dataativo');
			$data['datainativo'] = $this->input->post('datainativo');	
			$data['renovacao'] = $this->input->post('renovacao');	
			$data['observacoes'] = $this->input->post('observacoes');		
			$data['situacao'] = $this->input->post('situacao');

			$ultimo_id = $this->contratos_model->cadastrando('contrato', $data);
			
			if ($ultimo_id) {
				$this->logs_modelclass->registrar_log_insert ( 'contrato', 'idContrato', $ultimo_id, 'Contratos' );
			}

			#funcionario
			$funcionarioCad=array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="func"){
					$funcionarioCad[$tmp[1]]=$val;
					unset($_POST[$key]);
				}
			}	
			
			$novo_funcionario = array();
			for($i=0;$i<count($funcionarioCad['idFuncionario']);$i++){
				foreach($funcionarioCad as $key=>$val){
					$novo_funcionario[$i][$key] = $funcionarioCad[$key][$i];
				}
			}
			

			for($i=0;$i<count($novo_funcionario);$i++){ $novo_funcionario[$i]['idContrato'] = $ultimo_id; }
			

			
			$ids = $this->contratos_model->addContratoFuncionario($novo_funcionario);
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'contrato_funcionario', 'idContratoFuncionario', json_encode($ids), 'Contratos: Funcionários' );
			}
			
			#add contrato model
            if ($ultimo_id == TRUE) {
                $this->session->set_flashdata('success','Contrato adicionado com sucesso!');
               	redirect(base_url() . $this->permission->getIdPerfilAtual().'/contratos/gerenciar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }

        }
        $this->data['view'] = 'contratos/adicionarContrato';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->canUpdate()){
           $this->session->set_flashdata('error','Você não tem permissão para editar Contratos.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('contratos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


			#define campos do contrato
			$data['idCliente'] = $this->input->post('idCliente');
			$data['idCedente'] = $this->input->post('idCedente');
			$data['forma_de_pagamento'] = $this->input->post('forma_de_pagamento');
			$data['nota_fiscal'] = $this->input->post('nota_fiscal');
			$data['fechamento_de'] = $this->input->post('fechamento_de');
			$data['fechamento_a'] = $this->input->post('fechamento_a');
			$data['vencimento'] = $this->input->post('vencimento');
			$data['guias'] = $this->input->post('guias');
			$data['dataativo'] = $this->input->post('dataativo');
			$data['datainativo'] = $this->input->post('datainativo');
			$data['renovacao'] = $this->input->post('renovacao');
			$data['observacoes'] = $this->input->post('observacoes');
			$data['situacao'] = $this->input->post('situacao');

			$ultimo_id = $this->uri->segment(4);

			// remove os dados antigo de funcionarios
			$this->logs_modelclass->registrar_log_antes_delete ( 'contrato_funcionario', 'idContrato', $ultimo_id, 'Contratos: Funcionários (on edit)' );
			if ($this->contratos_model->limpa_dados_anteriores($ultimo_id, 'contrato_funcionario') ) {
				$this->logs_modelclass->registrar_log_depois ();
			}
			
			#funcionario
			$funcionarioCad=array();
			foreach($_POST AS $key=>$val){
				$tmp = explode("_",$key);
				if($tmp[0]=="func"){
					$funcionarioCad[$tmp[1]]=$val;
					unset($_POST[$key]);
				}
			}	
			
			$novo_funcionario = array();
			for($i=0;$i<count($funcionarioCad['idFuncionario']);$i++){
				foreach($funcionarioCad as $key=>$val){
					$novo_funcionario[$i][$key] = $funcionarioCad[$key][$i];
				}
			}
			

						
			
			for($i=0;$i<count($novo_funcionario);$i++){ $novo_funcionario[$i]['idContrato'] = $ultimo_id; }
		
			
			$ids = $this->contratos_model->addContratoFuncionario($novo_funcionario);
			
			if ($ids) {
				$this->logs_modelclass->registrar_log_insert ( 'contrato_funcionario', 'idContratoFuncionario', json_encode($ids), 'Contratos: Funcionários' );
			}
		
			
			$this->logs_modelclass->registrar_log_antes_update ( 'contrato', 'idContrato', $this->input->post ( 'idContrato' ), 'Contratos' );
            if ($this->contratos_model->edit('contrato', $data, 'idContrato', $this->input->post('idContrato')) == TRUE) {
            	$this->logs_modelclass->registrar_log_depois ();
                $this->session->set_flashdata('success','Contrato editado com sucesso!');
                redirect(base_url() . $this->permission->getIdPerfilAtual().'/contratos/editar/'.$this->input->post('idContrato'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->contratos_model->getById($this->uri->segment(4));
        $this->data['view'] = 'contratos/adicionarContrato';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->canSelect()){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Contratos.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
		$this->data['result'] = $this->contratos_model->getById($this->uri->segment(4));

		$this->data['view'] = 'contratos/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
	
    public function excluir(){

            if(!$this->permission->canDelete()){
               $this->session->set_flashdata('error','Você não tem permissão para excluir contratos.');
               redirect(base_url());
            }

            $id =  $this->input->post('idContrato');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir contrato.');            
                redirect(base_url().$this->permission->getIdPerfilAtual().'/contratos/gerenciar/');
            }
			
            $this->db->where('idContrato', $id);
            $os = $this->db->get('contrato')->result();

            if($os != null){

                foreach ($os as $o) {
                    $this->db->where('idContrato', $o->idContrato);
                    $this->db->delete('contrato_funcionario');
                }
            }
			
            $this->logs_modelclass->registrar_log_antes_delete ( 'contrato', 'idContrato', $id, 'Contratos' );
            
            if ($this->contratos_model->delete('contrato','idContrato',$id)) {
            	$this->logs_modelclass->registrar_log_depois ();
            }
            
            $this->session->set_flashdata('success','Contrato excluido com sucesso!');            
            redirect(base_url().$this->permission->getIdPerfilAtual().'/contratos/gerenciar/');
    }
}

